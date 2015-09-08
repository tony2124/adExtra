<script>
function eliminar(name)
{
   $('#nombre_archivo').html(name);
   $('#eliminar').attr("href","<?php print get('webURL') . _sh . 'admin/eliminarrespaldo/' ?>"+name);
}
</script>
<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Respaldo de la base de datos</legend>
<div class="well">Esta acción le permitirá descargar una copia de la base de datos del sistema. Es recomendable mantener respaldos periodicos. Por su seguridad e integridad de la información, guarde el archivo en un lugar seguro para evitar que personas no autorizadas tengan o alteren la información </div>
<p>
	<a href="<?php print get('webURL'). '/admin/respaldando' ?>" class="btn btn-success">Respaldar BD</a>
</p>
<p>&nbsp;</p>
<h2>Historial de respaldos.</h2><hr>
<table class="table table-striped table-condensed">
	<thead>
		<th width="500">Nombre del respaldo</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0; while($i < sizeof($files)) { ?>
		<tr class="roll">
			<td><a href="<?php print _rs . '/respaldos/' . $files[$i] ?>" target="_blank"><?php echo $files[$i] ?></a></td>
			<td>
				<a rel="tooltip" title="Eliminar" data-toggle="modal" class="pull-right btn btn-danger" onclick="eliminar('<?php print $files[$i] ?>')" href="#confirmModal">
					Eliminar
				</a>
				<a class="btn btn-success" target="_blank" href="<?php print _rs . '/respaldos/' . $files[$i++] ?>">
					Descargar
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar el archivo <span class="label label-important" id="nombre_archivo"></span> de la lista de descargas?</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" id="eliminar">Eliminar</a>
  </div>
</div>