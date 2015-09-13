<legend><span class="glyphicon glyphicon-open"></span>&nbsp;&nbsp;Subir datos de alumnos</legend>
<?php 
	if(isset($estado)){ ?>
	<div class="alert alert-success">Se ha intentado ingresar los datos al sistema, por favor verifique si los datos han sido ingresados.</div>
<?php } ?>
	
<DIV class="alert alert-warning">Haga un respaldo de la base de datos antes de realizar esta acción. Una vez realizada esta acción <strong>NO ES POSIBLE</strong> regresar a un estado anterior a menos que se cuente con un archivo de respaldo.</DIV>
<div class="well">
	Los datos de los alumnos deben tener el formato correspondiente y guardado con la extensión .CSV(MS-DOS).
	<p>El archivo debe contener la información de la siguiente manera: cada fila debe contener los siguientes campos:</p>
	<ul>
		<li>Número de control</li>
		<li>Clave / contraseña</li>
		<li>Nombre del alumno </li>
		<li>Apellido paterno</li>
		<li>Apellido materno</li>
		<li>ID carrera (consulte el ID en el apartado de "Carreras")</li>
		<li>Fecha de inscripción (XAAX  -> X: cualquier numero; AA: Dos últimos dígitos del año)</li>
		<li>Fecha de nacimiento (AAAA-MM-DD)</li>
		<li>Correo electrónico</li>
		<li>Sexo (1 -> HOMBRE, 2 -> MUJER) </li>
		<li>Situación escolar (1 -> ACTIVO, 2 -> INACTIVO) </li>
	</ul>

</div>
<form action="<?php print get('webURL')._sh.'admin/subiendoBD' ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
	  	<label class="control-label col-sm-2" for="nombre">Elige el archivo</label>
	  	<div class="col-sm-8">
			<input type="file" name="archivo"><br>
		</div>
		<div class="col-sm-2">
			<input type="submit" style="width: 100%" value="Subir" class="btn btn-success">	
		</div>
	</div>
</form>
