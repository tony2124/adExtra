<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
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
		
		
		<style>
	      body { padding-top: 70px; }
		</style>
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

			     $('[data-toggle="tooltip"]').tooltip();



		     	/* ==========================================================================
				Scroll To top
				========================================================================== */
				jQuery('#totop a').on('click', function () {
					    jQuery('html, body').animate({scrollTop: '0'}, 800);
					    return false;
					});
				});
		});

			/*$(function(){
		 	  $("a[rel=popover]").popover();
			  $("a[rel=tooltip]").tooltip();
			  $( ".selectorFecha" ).datepicker({  
    			defaultDate: "-15y", 
                yearRange: "1900:-15",
				dateFormat: 'yy-mm-dd',  
				showAnim: 'explode',
				duration: 'normal',
				changeMonth: true,
                changeYear: true });
			   $( ".selectorFechaInicio" ).datepicker({ 
				dateFormat: 'yy-mm-dd',  
				showAnim: 'explode',
				duration: 'normal',
				changeMonth: true,
                changeYear: true });
			});*/
		 </script>
	</head>

	<body>


<?php if(SESSION('user_admin')) { ?>
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
      <a class="navbar-brand" href="#">Extraescolares</a>
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if($menu == 1) print "class='active'" ?> >
        	<a href="<?php print get('webURL') . _sh .'admin/estadisticas' ?>">Estadísticas <span class="sr-only">(current)</span></a></li>
        <li <?php if($menu == 2) print "class='active'" ?> class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Alumnos <span class="caret"></span></a>
          <ul class="dropdown-menu">
		      <li><a href="<?php print get('webURL'). _sh .'admin/listaclub/'  ?>">Listas de alumnos</a></li>
		      <li><a href="<?php print get('webURL'). _sh .'admin/formRegistroalumno/'  ?>">Registrar nuevo alumno</a></li>
		      <li class="divider"></li>
		      <li><a href="<?php print get('webURL'). _sh .'admin/carreras/' ?>">Carreras / Licenciaturas</a></li>
		  </ul>
        </li>
        <li <?php if($menu == 3) print "class='active'" ?>>
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promotores <span class="caret"></span></a>
        	 <ul class="dropdown-menu">
				 <li><a href="<?php print get('webURL'). _sh .'admin/promotores/'  ?>">Lista de promotores</a></li>
				 <li><a href="<?php print get('webURL'). _sh .'admin/formRegistroPromotor/' ?>">Registrar nuevo promotor</a></li>
				 <li><a href="<?php print get('webURL'). _sh .'admin/formHorarios' ?>">Horarios</a></li>
				 <li class="divider"></li>
				 <li><a href="<?php print get('webURL'). _sh .'admin/adminclubes/' ?>">Administración de Clubes</a></li>
			 </ul>
        </li>
        <li <?php if($menu == 4) print "class='active'" ?>>
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuración <span class="caret"></span></a>
        	<ul class="dropdown-menu">
        		<li><a href="<?php print get('webURL'). _sh .'admin/configLiberacion/'  ?>">Fechas (inscr. / lib.)</a></li>
        		<li><a href="<?php print get('webURL'). _sh .'admin/'  ?>">Imágenes y logos <label class="label label-primary">Pro</label></a></li>
        		<li><a href="<?php print get('webURL'). _sh .'admin/revisiones'  ?>">Códigos y revisiones</a></li>
        		<li><a href="<?php print get('webURL'). _sh .'admin/'  ?>">Datos del instituto <label class="label label-primary">Pro</label></a></li>
        		<li><a href="<?php print get('webURL'). _sh .'admin/'  ?>">Conexión a BD de alumnos <label class="label label-primary">Pro</label></a></li>
        	</ul>
        </li>

        <li>
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantenimiento <span class="caret"></span></a>
        	<ul class="dropdown-menu">
			    <li><a href="<?php print get('webURL'). _sh .'admin/respaldoBD/'  ?>">Respaldo de BD</a></li>
			    <li><a href="<?php print get('webURL'). _sh .'admin/subirBD/'  ?>">Subir base de datos</a></li>
			    <li><a href="<?php print get('webURL'). _sh .'admin/eliminarhistorial/'  ?>">Eliminar historial</a></li>
			    <!--<li><a href="<?php print get('webURL'). _sh .'admin/excel/'  ?>">Archivo Excel</a></li>-->
			</ul>
        </li>
        <li <?php if($menu == 6) print "class='active'" ?>>
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sitio web <span class="caret"></span></a>
			<ul class="dropdown-menu">
			      <li class><a href="<?php print get('webURL'). _sh .'admin/noticias/'  ?>">Noticias</a></li>

			      <li><a href="<?php print get('webURL'). _sh .'admin/avisos/' ?>">Avisos</a></li>
			      <li class="divider"></li>
			      <li><a href="<?php print get('webURL'). _sh .'admin/galeria/' ?>">Galería</a></li>				      
			      <li><a href="<?php print get('webURL'). _sh .'admin/reglamento/' ?>">Reglamento</a></li>
			      <li class="divider"></li>
			      <li><a href="<?php print get('webURL'). _sh .'admin/subirarchivos/' ?>">Subir archivos</a></li>
			</ul>
		</li> 
		
		

      </ul>
      <div class="btn-group navbar-right" style="margin-top: 8px; margin-right: 8px">
		  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="glyphicon glyphicon-user"></span> <?php print strtoupper(SESSION('profesion_admin').' '.SESSION('name_admin').' '.SESSION('last1_admin')) ?> <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
              <li><a href="<?php print get('webURL'). _sh .'admin/adminconfig/' ?>"><b class="icon-wrench"></b> Configuración del administrador</a></li>
              <li><a href="<?php print get('webURL'). _sh .'admin/regisAdmin/' ?>"><b class="icon-pencil"></b> Registrar administrador</a></li>
              <li class="divider"></li>
              <li><a href="<?php print get('webURL') .  _sh .'admin/logout' ?>"><b class="icon-off"></b> Salir de la sesión</a></li>
           </ul>
		</div>
      <!--
      <form class="navbar-form navbar-right" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Núm. control">
	        </div>
	        <button type="submit" class="btn btn-default">Buscar</button>
	        <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-filter"></span> </a>
	   </form>
		-->

		

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php } ?>
		<div class="panel panel-default" style="border: 0px;background: transparent">
  			<div class="panel-body">