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
		  <p>&nbsp;</p>
			<div class="collapse" id="collapseExample">
			  <div >
			    <label>
		    		<input type="checkbox" name="sit" value="5"> Incluir alumnos egresados.
		  		</label>
			  </div>
			</div>


		</form>
		<p><a target="_blank" href="<?php print _rs ?>/973164852/MANUAL_ADMINISTRADOR.pdf">¡Descargar manual de administrador!</a></p>
		<center>
			<a href="http://www.itsa.edu.mx/"  title="Ir a la página del ITSA" rel="tooltip">
				<img align="center" width="100" class="pull-right" src="<?php print ruta_imagen.'/itsa.png' ?>">
			</a>
		</center>
		
	
	</div>

<?php } ?>