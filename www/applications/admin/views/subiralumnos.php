<h2>Subir base de datos</h2>
<p>La base de datos debe tener el formato correspondiente y guardado con la extensión .CSV(MS-DOS). Consulte el manual para dar el formato correspondiente a la información</p>
<p>
	<form action="<?php print get('webURL')._sh.'admin/subiendoBD' ?>" method="post" enctype="multipart/form-data">
		<label>Elige el archivo</label>
		<input type="file" name="archivo"><br>
		<input type="submit" value="Subir" class="btn">
	</form>
</p>