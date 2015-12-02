
<script type="text/javascript">
function eliminar(nombre, id)
{
   $('#nombre_club').html(nombre);
   $('#id_club').val(id);
}

$(function () {
  $('[rel="popover"]').popover()
})
</script>


<?php if($club == NULL) { ?>
<legend><span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;  <strong>Registrar nuevo club</strong></legend>
<?php }else{ ?>
<legend><span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;  <strong>Editar club</strong><a class="btn btn-primary btn-sm pull-right" href="<?php print get('webURL').'/admin/adminclubes' ?>">Nuevo club</a></legend>
<?php } ?>
<div class="well">Use el siguiente formulario para registrar / editar un nuevo club. Tenga en cuenta que mientras más resolución tenga la foto del club se visualizará mejor en el sitio publicitario.</div>
<form id="textoForm" action="<?php print ($club != NULL) ? get('webURL')._sh.'admin/modclub/'.$club[0]['id_club'] : get('webURL')._sh.'admin/guardarclub' ?>" method="post" enctype="multipart/form-data">
	<div class="col-sm-12 form-horizontal">
		<div class="form-group">
			<label class="label-control col-sm-2">Tipo de club</label>
			<div class="col-sm-3">
				<select class="form-control" name="tipo">
					<option value="3">Selecciona un tipo</option>
					<option value="1" <?php if(strcmp($club[0]['tipo_club'], "1") == 0) print 'selected="selected"' ?>>Deportivo</option>
					<option value="2" <?php if(strcmp($club[0]['tipo_club'], "2") == 0) print 'selected="selected"' ?>>Cultural</option>
				</select>
			</div>
		
			<label class="label-control col-sm-2" >Nombre del club</label>
			<div class="col-sm-5">
				<input class="form-control" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($club) ? $club[0]['nombre_club'] : NULL ?>" />
			</div>
		</div>
		<?php
		if(isset($club))
			if($club[0]['foto_club'])
			{ ?>
			<div class="form-group">
				<div class="col-sm-5">
					<a href="#" data-toggle="collapse" data-target="#fotocollapse" aria-expanded="false" aria-controls="fotocollapse">Ver foto actual del club.</a>
					<div class="collapse" id="fotocollapse">
					    <img class="img-thumbnail" src="<?php print _rs ?>/img/clubes/<?php print $club[0]['foto_club'] ?>" width="330">				
					</div>
					<p>
						<input type="checkbox" name="mostrarfoto" id="mostrarfoto" value="<?php echo $club[0]['foto_club'] ?>" checked="checked" />&nbsp;Mantener foto actual.
						<input type="hidden" value="<?php echo $club[0]['foto_club'] ?>" name="fotoanterior">
					</p>
				</div>
			</div>
				

			<?php } 	?>
		<div class="form-group">
			<label class="label-control col-sm-3">Subir una foto</label>
			<div class="col-sm-6">
				<input name="foto" id="foto" type="file" /><br>
			</div>
		</div>
		
		
	</div>	
	<div class="form-group">
		<div class="col-sm-12">
			<textarea  name="texto" id="edit" ><?php 
				if(isset($club))
				{
					print $club[0]['texto_club'];
				}
		?></textarea>
		</div>
	</div>
	<p>&nbsp;</p>
	<div class="form-group">
		<div class="col-sm-10"></div>
		<div class="col-sm-2">
			<input style="width:100%" type="submit" class="btn btn-success" value="Guardar">
		</div>
	</div>
	<!--<input type="hidden" id="texto" name="texto" />-->
</form>

<div style="clear: both"></div>
<hr>
<p>&nbsp;</p>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;  <strong>Lista de clubes</strong> </legend>
<table class="table table-striped table-condensed">
	<thead>
		<th>ID CLUB</th>
		<th>Tipo club</th>
		<th>Nombre del club</th>
		<th>Foto</th>
		<th>Reseña</th>
		<th>Fecha creación</th>
		<th>Fecha modif.</th>
		<th>Estado</th>
		<th width="70"></th>
	</thead>
	<tbody>
		<?php foreach ($clubes as $not) { ?>
		<tr class="roll">
			<td><?php echo $not['id_club'] ?></td>
			<td><?php if($not['tipo_club']==1)  print "DEPORTIVO"; else if($not['tipo_club']==2) print "CULTURAL"; else print "OTROS"; ?></td>
			<td><a href="<?php print get("webURL")._sh.'admin/adminclubes/'.$not['id_club'] ?>"><?php echo $not['nombre_club'] ?></a></td>
			<td>
				<?php if($not['foto_club']!=NULL) { ?>
					<span class="glyphicon glyphicon-ok"></span>
				<?php } ?>
			</td>
			<td>
				<?php if($not['texto_club']!=NULL) { ?>
					<span class="glyphicon glyphicon-ok"></span>
				<?php } ?>
			</td>
			
			<td><?php echo convertirFecha($not['fecha_creacion']) ?></td>
			<td><?php echo hace_tiempo($not['fecha_modificacion'],date("Y-m-d")) ?></td>
			<td><?php print ($not['eliminado_club'] == 0) ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>No activo</span>" ?></td>
			<td>
				<a rel="tooltip" title="Editar" class="btn btn-default btn-xs" href="<?php print get("webURL")._sh.'admin/adminclubes/'.$not['id_club'] ?>">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
<?php 			if($not['eliminado_club'] == 0){    		?>
				<a rel="tooltip" title="Eliminar" class="btn btn-danger btn-xs" data-toggle="modal" href="<?php print get('webURL')._sh.'admin/habilitarClub/'.$not['id_club'].'/1' ?>">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
<?php 			}else{ 	?>
				<a rel="tooltip" title="Eliminar" class="btn btn-success btn-xs" data-toggle="modal" href="<?php print get('webURL')._sh.'admin/habilitarClub/'.$not['id_club'].'/0' ?>">
					<span class="glyphicon glyphicon-ok"></span>
				</a>
<?php 			} 	?>


			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<script src="<?php print get("webURL")."/www/lib/tinymce/tinymce.min.js" ?>"></script>

<script type="text/javascript">
       tinymce.init({
            selector: "#edit",
            height: 300
        });
</script>