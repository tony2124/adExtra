<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	if(isMobile()) {
		include "mobile/header.php";
	} else {
?>
<!DOCTYPE html>
<html lang="<?php print get("webLang"); ?>">
	<head>
	 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php print path("www/lib/images/itsa.png","www") ?>" />
    <title><?php print $this->getTitle(); ?></title>
    
    <link href="<?php print path("vendors/css/frameworks/bootstrap/css/bootstrap.min.css", "zan"); ?>" rel="stylesheet">
    <?php //print $this->getCSS(); ?>
    <link rel="stylesheet" href="<?php print path("www/lib/css/font-awesome-4.3.0/css/font-awesome.min.css", "www"); ?>">
    
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
    <script src="<?php print path("www/lib/scripts/ouwScript.js","www") ?>"></script>
    <script src="<?php print path("vendors/js/jquery-2.1.4.min.js","zan") ?>"></script>
    <script src="<?php print path("vendors/css/frameworks/bootstrap/js/bootstrap.min.js", "zan"); ?>"></script>
    <script src="<?php print path("vendors/js/jquery.validate.js","zan") ?>"></script>
    <script>
      function goBack() {
          window.history.back();
      }
    </script>

    <script>
    $( document ).ready(function() {
      $(function () {
           var $win = $(window);
           $win.scroll(function () {
               if ($win.scrollTop() > 400){
                  $(".menu-principal-fixed").addClass("mostrar-menu-collapse");
                  $("#totop").addClass("activo-totop");
                }
               else {
                    $(".menu-principal-fixed").removeClass("mostrar-menu-collapse");
                    $("#totop").removeClass("activo-totop");
               }
            }); 

           $('[rel="tooltip"]').tooltip();



          /* ==========================================================================
        Scroll To top
        ========================================================================== */
        jQuery('#totop a').on('click', function () {
              jQuery('html, body').animate({scrollTop: '0'}, 800);
              return false;
          });
        });
    });

     </script>
    
    <style>
        body { padding-top: 70px; }
    </style>
  
  </head>

	<body>
	<?php if(SESSION('usuario_promotor')) { ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Promotores extraescolares</a>
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if($menu == 1) print "class='active'" ?>  class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Alumnos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php print get('webURL'). _sh .'promotor/index/'  ?>">Listas de alumnos</a></li>
            <li><a href="#">Estadística <span class="label label-primary">Pro</span></a></li>
          </ul>
        </li>
        <li <?php if($menu == 2) print "class='active'" ?> >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promotor <span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="<?php print get('webURL'). _sh .'promotor/datos/'  ?>">Mis datos</a></li>
             <!--<li><a href="<?php print get('webURL'). _sh .'promotor/historial/' ?>">Historial de participación</a></li>-->
             <li><a href="<?php print get('webURL'). _sh .'promotor/horarios' ?>">Horarios</a></li>
           </ul>
        </li>
      </ul>
      <div class="btn-group navbar-right" style="margin-top: 8px; margin-right: 8px">
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-user"></span> <?php print strtoupper(SESSION('nombre_promotor').' '.SESSION('ap_promotor').' '.SESSION('am_promotor')) ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
              <li><a href="<?php print get('webURL')._sh.'promotor/salirSesion' ?>"><b class="icon-off"></b> Salir de la sesión</a></li>
          </ul>
      </div>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
      <?php } ?>
    <div class="panel panel-default" style="border: 0px;background: transparent">
        <div class="panel-body">

<?php } ?>
