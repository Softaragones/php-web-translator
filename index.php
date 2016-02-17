<!DOCTYPE html>
<html dir="ltr">
<head>
  <title>Traductor de Softaragonés. Una plataforma de traducción entre as luengas d'Aragón</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/sandstone/bootstrap.min.css" rel="stylesheet" integrity="sha256-oqtj+Pkh1c3dgdH6V9qoS7qwhOy2UZfyVK0qGLa9dCc= sha512-izanB/WZ07hzSPmLkdq82m5xS7EH/qDMgl5aWR37EII+rJOi5c6ouJ3PYnrw6K+DWQcnMZ+nO1NqDr6SBKLBDg==" crossorigin="anonymous">
  <link rel="shortcut icon" href="/traductor/img/favicon.ico">
  <link type="text/css" rel="stylesheet" href="/traductor/css/min.css?1455357399">
  <script type="text/javascript" src="/traductor/js/min.js?1455357399"></script>
  <!--[if lt IE 9]> <script type="text/javascript" src="./js/compat.js"></script> <![endif]-->
  <link type="text/css" rel="stylesheet" href="/traductor/css/min.css?1455357399">
  <script type="text/javascript" src="/traductor/js/min.js?1455357399"></script>
  <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
    var $buoop = {};
    $buoop.ol = window.onload;
    window.onload = function () {
    try { if ($buoop.ol) $buoop.ol(); } catch (e) {}
      var e = document.createElement("script");
      e.setAttribute("type", "text/javascript");
      e.setAttribute("src", "//browser-update.org/update.js");
      document.body.appendChild(e);
    };
  </script>
  <!-- [if lt IE 10]>
    <style type="text/css">
       button#translateDoc { display: none; }
    </style>
  <![endif]-->
</head>
<body>
  <span class="fa hide" id="faChecker"></span>
    <script type="text/javascript">
      if($('#faChecker').css('fontFamily') !== 'FontAwesome') {
        $('<link type="text/css" rel="stylesheet" href="/traductor/css/font-awesome.min.css">').appendTo('head');
        console.error('FontAwesome CSS from CDN not available - reverting to local copy');
      }
    </script>
  <span class="pull-right flip hide" id="rtlChecker"></span>
  <script type="text/javascript">
    if($('#rtlChecker').css('float') !== 'left' && !$('.rtlStylesheet').attr('disabled')) {
      $('<link type="text/css" rel="stylesheet" href="/traductor/css/bootstrap-rtl.min.css" class="rtlStylesheet">').appendTo('head');
      console.error('BootstrapRTL CSS from CDN not available - reverting to local copy');
    }
  </script>
  <div id="wrap">
    <nav class="navbar navbar-default" role="navigation" style="margin-top: 0px;">
      <div class="container" style="position: relative">
        <div class="navbar-header">
           <div>
             <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="Apertium Box" class="apertiumBox">
             <span class="apertiumSubLogo">Luengas d'Aragón</span>
             <span class="apertiumLogo" style="margin-bottom: -.25em">Apertium</span>
           </div>
           <p data-text="tagline" class="tagline">Plataforma libre/de codigo fuent ubierto ta la traducción automatica</p>
        </div>
      </div>
    </nav>
    <div class="container" class="modeContainer" style="display: block;">
      <form action="navega.php" method="get" enctype="text/plain" class="form-horizontal">
      <fieldset class="container">
        <legend>
          <p>Traductor de pachinas web entre as luengas d'Aragón</p>
          <p>Traductor de pàgines web entre les llengües d'Aragó</p>
          <p>Traductor de páginas web entre las lenguas de Aragón</p>
        </legend>
        <?php
          if ($_GET['error'] == "True") {
          echo "        <div class=\"alert alert-danger\">\n";
          echo "          <p><strong>ERROR!</strong> A pachina ".$_GET['adreza']." no s'ha puesto cargar.<br/>\n";
          echo "            Prebe de escribir bien l'adreza u en escriba unatra.</p>\n";
          echo "        </div>\n";
          }
        ?>
        <div class="form-group">
          <label for="adreza">URL:</label>
          <input type="text" name="adreza" value=<?php
            if (isset($_GET['adreza'])) echo '"'.urldecode($_GET['adreza']).'"';
            else echo "http://softaragones.org";
            ?> class="form-control">
          <select name="langpair" class="form-control">
            <option value="spa-arg" label="spa-arg" selected>Castellano - Aragonés (spa->arg)</option>
            <option value="arg-spa" label="arg-spa">Aragonés - Castellano (arg->spa)</option>
            <option value="cat-arg" label="cat-arg">Català - Aragonés (cat->arg)</option>
            <option value="arg-cat" label="arg-cat">Aragonés - Català (arg->cat)</option>
            <option value="cat-spa" label="cat-spa">Català - Castellano (cat->spa)</option>
            <option value="spa-cat" label="spa-cat">Castellano - Català (spa->cat)</option>
          </select>
          <button type="submit" class="form-control btn btn-default">Ir-ie</button>
        </div>
      </fieldset>
      </form>
    </div>
  </div>
</body>
</html>
