
<script type="text/javascript">
function eliminar(nombre, id)
{
   $('#nombre_carrera').html(nombre);
   $('#id_carrera').val(id);
}
</script>


<legend><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;  <strong>Lista de carreras</strong> <a class="btn btn-primary pull-right" href="<?php print get('webURL').'/admin/carreras/nueva-edit' ?>">Nueva carrera</a>
</legend>
<table class="table table-striped table-condensed">
	<thead>
		<th>Id</th>
		<th>Nombre de la carrera</th>
		<th>Abreviatura</th>
		<th>Sem</th>
		<th>Plan de estudio</th>
		<th>Fecha registro</th>
		<th>Estado</th>
		<th></th>
	</thead>
	<tbody>
		<?php foreach ($carreras as $car) { ?>
		<tr class="roll">
			<td><?php echo $car['id_carrera'] ?></td>
			<td><a href="<?php print get("webURL")._sh.'admin/carreras/nueva-edit/'.$car['id_carrera'] ?>"><?php echo $car['nombre_carrera'] ?></a></td>
			<td><a href="<?php print get("webURL")._sh.'admin/carreras/nueva-edit/'.$car['id_carrera'] ?>"><?php echo $car['abreviatura_carrera'] ?></a></td>
			<td><?php echo $car['semestres_carrera'] ?></td>
			<td><?php echo $car['plan_estudio'] ?></td>
			<td><?php echo $car['fecha_registro'] ?></td>
			<td><?php print ($car['eliminada'] == 0) ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>No activo</span>" ?></td>
			<td>
				<?php  if($car['eliminada'] == 0) { ?>
				<a rel="tooltip" title="Eliminar" href="<?php print get('webURL')._sh.'admin/habilitarCarrera/'.$car['id_carrera'].'/1' ?>" class="btn btn-danger btn-xs">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
				<?php }else{ ?>
				<a rel="tooltip" title="Activar" href="<?php print get('webURL')._sh.'admin/habilitarCarrera/'.$car['id_carrera'].'/0' ?>" class="btn btn-success btn-xs">
					<span class="glyphicon glyphicon-ok"></span>
				</a>
<?php			} ?>
				<a rel="tooltip" title="Editar" href="<?php print get("webURL")._sh.'admin/carreras/nueva-edit/'.$car['id_carrera'] ?>" class="btn btn-default btn-xs">
					<span class="glyphicon glyphicon-pencil"></span>
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
		    <p>¿Está seguro que desea eliminar e la carrera de <span class="label label-danger" id="nombre_carrera"></span>?</p>
		   
		    <form id="elimClub" method="post" action="<?php print get('webURL')._sh.'admin/habilitarCarrera/' ?>">
		      <input name="id_carrera" id="id_carrera" type="hidden" value="">
		    </form> 
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		    <a href="#" class="btn btn-danger" onclick="$('#elimClub').submit()">Eliminar</a>
		  </div>
		 </div>
	</div>	 
</div>