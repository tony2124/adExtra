<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_editor.min.css" ?>" rel="stylesheet" type="text/css" />
<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_content.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />

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
			<label class="label-control col-sm-2"for="foto">Tipo de club</label>
			<div class="col-sm-3">
				<select class="form-control" name="tipo">
					<option value="3">Selecciona un tipo</option>
					<option value="1" <?php if(strcmp($club[0]['tipo_club'], "1") == 0) print 'selected="selected"' ?>>Deportivo</option>
					<option value="2" <?php if(strcmp($club[0]['tipo_club'], "2") == 0) print 'selected="selected"' ?>>Cultural</option>
				</select>
			</div>
		
			<label class="label-control col-sm-2" for="titulo">Nombre del club</label>
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
						</p>
				</div>
			</div>
				

			<?php } 	?>
		<div class="form-group">
			<label class="label-control col-sm-3"for="foto">Subir una foto</label>
			<div class="col-sm-6">
				<input name="foto" id="foto" type="file" /><br>
			</div>
			<!--<label class="label-control col-sm-1">Grupo</label>
			<div class="col-sm-2">
				<select class="form-control">
					<option>A</option>
					<option>B <span class="label labe-primary">Pro</span></option>
					<option>C <span class="label labe-primary">Pro</span></option>
					<option>D <span class="label labe-primary">Pro</span></option>
				</select>
			</div>-->
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
<!--	<th>Foto</th>-->
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
			<!--<td>
				<?php if($not['foto_club']!=NULL) { ?>
				<a href="#" rel="popover" data-content="<?php print "<img src='"._rs."/img/clubes/".$not['foto_club']."' width='250' >" ?>" data-original-title="Imagen">ver</a>
				<?php } ?>
			</td>-->
			
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
<!--
<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar el club de <span class="label label-important" id="nombre_club"></span>?</p>
   
    <form id="elimClub" method="post" action="<?php print get('webURL')._sh.'admin/elimClub' ?>">
      <input name="id_club" id="id_club" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimClub').submit()">Eliminar</a>
  </div>
</div>
-->

<!-- Include JS files. -->
  <script src="<?php print get("webURL")."/www/lib/froala_editor/js/froala_editor.min.js" ?>"></script>

  <!-- Include IE8 JS. -->
  <!--[if lt IE 9]>
      <script src="../js/froala_editor_ie8.min.js"></script>
  <![endif]-->

  <!-- Initialize the editor. -->
  <script>
      $(function() {
          $('#edit').editable({
          	inlineMode: false,
          	allowStyle: true,
          	colors: [
		        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
		        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
		      ]
          })
      });
  </script>