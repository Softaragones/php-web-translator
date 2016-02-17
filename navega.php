<?php

$apy_url = "http://softaragones.org:2737";
$default_url = 'http://softaragones.org';

if (isset($_GET['langpair'])) $par=str_replace("-","|",urldecode($_GET['langpair']));
else $par = 'spa|arg';
if (isset($_GET['adreza'])) $adreza=urldecode($_GET['adreza']);
else $adreza = $default_url;
if (isset($_GET['markUnknown'])) $marks=urldecode($_GET['markUnknown']);
else $marks = 'no';

$script_url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?langpair='.urlencode($par).'&markUnknown='.urlencode($marks).'&adreza=';
$base_url = parse_url($adreza,PHP_URL_SCHEME). "://".parse_url($adreza,PHP_URL_HOST).preg_replace( '#/[^/]*$#', '',parse_url($adreza, PHP_URL_PATH)).'/';

function rel2abs( $rel, $base ) {
	// parse base URL  and convert to local variables: $scheme, $host,  $path
	$parse = parse_url( $base );
	$host = $parse['host'];
	$scheme = $parse['scheme'];
	$path = $parse['path'];
	if ( strpos( $rel,"//" ) === 0 )
		return $scheme . ':' . $rel;
	// return if already absolute URL
	if ( parse_url( $rel, PHP_URL_SCHEME ) != '' )
		return $rel;
	// queries and anchors
	if ( $rel[0] == '#' || $rel[0] == '?' )
		return $base . $rel;
	// remove non-directory element from path
	$path = preg_replace( '#/[^/]*$#', '', $path );
	// destroy path if relative url points to root
	if ( $rel[0] ==  '/' )
		$path = '';
	// dirty absolute URL
	$abs = $host . $path . "/" . $rel;
	// replace '//' or  '/./' or '/foo/../' with '/'
	$abs = preg_replace( "/(\/\.?\/)/", "/", $abs );
	$abs = preg_replace( "/\/(?!\.\.)[^\/]+\/\.\.\//", "/", $abs );
	// absolute URL is ready!
	return $scheme . '://' . $abs;
}

$tempfilename = rand();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$adreza);
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$conteniu = curl_exec($curl);
$mime = curl_getinfo($curl,CURLINFO_CONTENT_TYPE);
curl_close($curl);

if ($conteniu == NULL) {
  echo "A pachina ".$adreza." no s'ha puesto ubrir";
  header("Location: index.php?error=True&adreza=".$adreza);
  die();
}

require_once('Encoding.php');
use \ForceUTF8\Encoding;
$conteniu = Encoding::toUTF8($conteniu);
$conteniu = preg_replace('/(charset=\")(.+)\"/', "$1"."UTF-8\"", $conteniu);


file_put_contents($tempfilename,$conteniu);

$curl = curl_init();
$args['langpair'] = $par;
$args['markUnknown'] = $marks;
$args['file'] = new CurlFile($tempfilename, 'text/html');
$header = array('Content-Type: multipart/form-data', 'Content-Disposition: attachment');
curl_setopt($curl,CURLOPT_URL,$apy_url."/translateDoc");
curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,$args);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
$result = curl_exec($curl);
curl_close($curl);
unlink($tempfilename);

$dom = new DOMDocument;
$dom->loadHTML('<?xml encoding="UTF-8">' . $result);
// dirty fix
foreach ($dom->childNodes as $item)
    if ($item->nodeType == XML_PI_NODE)
        $dom->removeChild($item); // remove hack
$dom->encoding = 'UTF-8'; // insert proper

$heads = $dom->getElementsByTagName('head');
$head_base = $dom->createElement('base');
$refs = $heads[0]->getElementsByTagName('*');
$head_base->setAttribute('href',$base_url);
$heads[0]->insertBefore($head_base,$refs[0]);

$links = $dom->getElementsByTagName('a');
foreach($links as $link) {
  if ($link->hasAttribute('href')){
    if (!(strpos($link->getAttribute('href'),'javascript:') !== FALSE )){
      $link->setAttribute('href',$script_url.urlencode(rel2abs($link->getAttribute('href'),$base_url)));
    }
  }
}
$iframes = $dom->getElementsByTagName('iframe');
foreach($iframes as $iframe) {
  if ($iframe->hasAttribute('src')){
	 $iframe->setAttribute('src',$script_url.urlencode(rel2abs($iframe->getAttribute('src'),$base_url)));
  }
}
$frames = $dom->getElementsByTagName('frame');
foreach($frames as $frame) {
  if ($frame->hasAttribute('src')){
	 $frame->setAttribute('src',$script_url.urlencode(rel2abs($frame->getAttribute('src'),$base_url)));
  }
}
echo $dom->saveHTML();
?>
