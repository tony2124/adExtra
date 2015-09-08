<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Subir datos de alumnos</legend>
<div class="well">La base de datos debe tener el formato correspondiente y guardado con la extensión .CSV(MS-DOS). Consulte el manual para dar el formato correspondiente a la información</div>
<p>
	<form action="<?php print get('webURL')._sh.'admin/subiendoBD' ?>" method="post" enctype="multipart/form-data">
		<label>Elige el archivo</label>
		<input type="file" name="archivo"><br>
		<input type="submit" value="Subir" class="btn btn-primary">
	</form>
</p>