<script>
function eliminar(name)
{
   $('#nombre_archivo').html(name);
   $('#eliminar').attr("href","<?php print get('webURL') . _sh . 'admin/eliminararchivo/' ?>"+name);
}
</script>

<legend><span class="glyphicon glyphicon-open"></span>&nbsp;&nbsp;  <strong>Subir un archivo</strong></legend>
<div class="well">Seleccione un archivo para almacenarlo en el servidor y el alumno pueda descargarlo a través de la página publictaria. Para subir un archivo toma en consideración los siguientes puntos:
	<ul>
		<li>No utilice acentos en el nombre del archivo.</li>
		<li>Utilice un nombre con un número no mayor a 50 caracteres.</li>
		<li>Puede subir  cualquier formato de archivo, pero evite en especial aquellos que tienen la extensión .exe</li>
	</ul>
</div>

<form action="<?php print get('webURL')._sh.'admin/subiendo' ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<div class="col-sm-2"> <label>Elige el archivo</label> </div>
		<div class="col-sm-8"> <input type="file" name="archivo"> </div>
		<div class="col-sm-2"> <input style="width:100%" type="submit" value="Subir" class="btn btn-success"> </div>
	</div>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<legend><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;  <strong>Archivos en el servidor</strong></legend>
<table class="table table-striped table-condensed">
	<thead>
		<th width="500">Nombre del archivo</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0; while($i < sizeof($files)) { ?>
		<tr class="roll">
			<td><a href="<?php print _rs . '/descarga/' . $files[$i] ?>" target="_blank"><?php echo $files[$i] ?></a></td>
			<td width="30">
				<a rel="tooltip" title="Eliminar" data-toggle="modal" class="btn btn-danger btn-xs" onclick="eliminar('<?php print $files[$i++] ?>')" href="#confirmModal">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<div class="modal fade" id="confirmModal">
	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
			  <div class="modal-header">
			    <button class="close" data-dismiss="modal">×</button>
			    <h3>Confirmación</h3>
			  </div>
			  <div class="modal-body">
			    <p>¿Está seguro que desea eliminar el archivo <span class="label label-danger" id="nombre_archivo"></span> de la lista de descargas?</p>
			  </div>
			  <div class="modal-footer">
			    <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
			    <a href="#" class="btn btn-danger" id="eliminar">Eliminar</a>
			  </div>
		</div>
	</div>
</div>