<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="col-md-9">
		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
	</div>
	<!-- search for the student -->
<?php if(SESSION('user_admin'))	{ ?>
	<div class="col-md-3">
		<h4><b class="glyphicon glyphicon-search"></b> <strong>Búsqueda de alumnos</strong></h4>
		<form class="well" align="center" action="<?php print get('webURL'). _sh .'admin/buscar' ?>" method="post">
		  <label style="float: left">Buscar:</label>
		  <input type="text" name="bus" class="form-control" placeholder="Núm. control / nombre / apellido">
		  <p>&nbsp;</p>
		  <button type="submit" style="min-width: 150px" class="btn btn-primary">Buscar</button>
		  <span data-toggle="tooltip" data-placement="top" title="Filtro de búsqueda">
		  <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		  	<span class="glyphicon glyphicon-filter"></span>
		  </button>
		</span>
		  
			<div class="collapse" id="collapseExample">
				<p>&nbsp;</p>
			 	<label>
			 		<input type="checkbox" name="sit" value="5"> Incluir alumnos inactivos.
			 	</label>
			</div>


		</form>
		<hr>
		<h4><b class="glyphicon glyphicon-globe"></b> <strong>Número de visitas: <?php print $visitas[0]["numero_visitas"] ?></strong></h4>
		<hr>
		<?php if($adminactuales){ ?>
		<?php if($adminactuales[0]["count"] > 1){ ?>
		<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> <strong>¡MÁS DE UN ADMINISTRADOR!</strong> <br>Tiene activo más de un administrador. Por favor, active sólo un administrador actual para no causar inestabilidad.</div>
		
		<?php } } if($fecha_liberacion_abierta){ ?>
		<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> <strong>¡PERIODO DE LIBERACIÓN ABIERTO!</strong> <br>Inicia: <kbd><?php print convertirFecha($fecha_liberacion_abierta[sizeof($fecha_liberacion_abierta) - 1]["fecha_inicio_liberacion"]) ?></kbd> <br>Finaliza: <kbd><?php print convertirFecha($fecha_liberacion_abierta[sizeof($fecha_liberacion_abierta) -1]["fecha_fin_liberacion"]) ?></kbd></div>
		<?php } if($fecha_inscripcion_abierta){ ?>
		<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign"></span> <strong>¡INSCRIPCIONES ABIERTAS!</strong> <br>Inicia: <kbd><?php print convertirFecha($fecha_inscripcion_abierta[0]["fecha_inicio_inscripcion"]) ?></kbd> <br>Finaliza: <kbd><?php print convertirFecha($fecha_inscripcion_abierta[0]["fecha_fin_inscripcion"]) ?></kbd>
			<a  href="<?php print get("webURL")."/admin/notificacion/2" ?>" data-toggle="tooltip" title="Envía notificación de inscripciones abiertas a celulares." class="btn btn-primary"><span class="glyphicon glyphicon-phone"></span> Notificar</a>
		</div>
		<?php } if($clubesnoasignados){ ?>
		<div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign"></span> No se ha asignado promotor a los siguientes clubes: 
			<?php
				foreach ($clubesnoasignados as $key) {
					print "<kbd>".$key['nombre_club']."</kbd>,";
				}
			?>	vaya al apartado de <a href="<?php print get("webURL")."/admin/formHorarios" ?>">horarios</a> para asignarlos.
		</div>
		<?php } if($clubessinresena) { ?>
		<div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign"></span> Los siguientes clubes NO tienen foto o reseña:  
			<?php
				foreach ($clubessinresena as $key) {
					print "<kbd>".$key['nombre_club']."</kbd>, ";
				}
			?>, por favor vaya al apartado de <a href="<?php print get("webURL")."/admin/adminclubes" ?>">administración de clubes</a> para editarlos.
		</div>
		<?php } ?>
		<!--<p><a target="_blank" href="<?php print _rs ?>/973164852/MANUAL_ADMINISTRADOR.pdf">¡Descargar manual de administrador!</a></p>-->
		
		<a target="_blank" href="http://www.itsaextraescolares.com" >
			<img style=" margin-right: 20px" align="center" width="150" title="Ir a la página de Extraescolares" data-toggle="tooltip" class="pull-left" src="<?php print ruta_imagen.'/cuinique.png' ?>">
		</a>
		<a target="_blank" href="https://play.google.com/store/apps/details?id=simpus.mobile.itsaextraescolares" >
			<img style="margin-top: 20px; margin-right: 20px" align="center" width="150"  title="Descargar la App" data-toggle="tooltip" class="pull-left" src="<?php print ruta_imagen.'/googleplay.jpg' ?>">
		</a>
		<a target="_blank" href="http://www.itsa.edu.mx/"  >
			<img align="center" width="90" title="Ir a la página del ITSA" data-toggle="tooltip" src="<?php print ruta_imagen.'/itsa.png' ?>">
		</a>
		
		
	
	</div>

<?php } ?>