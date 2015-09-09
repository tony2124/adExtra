<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_editor.min.css" ?>" rel="stylesheet" type="text/css" />
<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_content.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />


<script type="text/javascript">

function eliminar(id)
{
	var con = confirm("Está seguro que desea eliminar la noticia con el id = "+id,'Titulo');
	if(con==true)
	{
		location.href="<?php print get('webURL')._sh.'admin/elimnoticia/' ?>"+id;
	}
}

</script>

<legend><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;  <strong>Publica una nueva noticia</strong></legend>
<form id="textoForm" action="<?php print ($id) ? get('webURL')._sh.'admin/modnoticia/'.$id : get('webURL')._sh.'admin/guardarnoticia' ?>" method="post" enctype="multipart/form-data">
<!--	<label for="titulo">Título</label>
	<input style="width: 300px" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($id) ? $modnot['nombre_noticia'] : NULL ?>" />
	-->
	
	
	<div class="col-sm-12 form-horizontal">
		<div class="form-group">		
			<label class="label-control col-sm-2" for="titulo">Título</label>
			<div class="col-sm-10">
				<input class="form-control" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($id) ? $modnot['nombre_noticia'] : NULL ?>" />
			</div>
		</div>
		<?php
		if(isset($id))
			if($modnot['imagen_noticia'])
			{ ?>
			<div class="form-group">
				<div class="col-sm-5">
					<a href="#" data-toggle="collapse" data-target="#fotocollapse" aria-expanded="false" aria-controls="fotocollapse">Ver foto de la noticia.</a>
					<div class="collapse" id="fotocollapse">
					    <img class="img-thumbnail" src="<?php print _rs ?>/img/noticias/<?php print $modnot['imagen_noticia'] ?>" width="330">				
					</div>
					<p>
							<input type="checkbox" name="mostrarfoto" id="mostrarfoto" checked="checked" />&nbsp;Mantener foto actual.
						</p>
				</div>
			</div>
				

			<?php } 	?>
		<div class="form-group">
			<label class="label-control col-sm-2"for="foto">Subir una foto</label>
			<div class="col-sm-9">
				<input name="foto" id="foto" type="file" />
			</div>
		</div>
	</div>	

	<div class="form-group">
		<div class="col-sm-12">
			<textarea name="texto" id="edit" ><?php 
				if(isset($id))
				{
					print $modnot['texto_noticia'];
				}
		?></textarea>
		</div>
	</div>
	<p>&nbsp;</p>
	<div class="form-group">
		<div class="col-sm-10"></div>
		<div class="col-sm-2">
			<button style="width:100%" class="btn btn-success">Guardar</button>
		</div>
	</div>

</form>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;  <strong>Historial de noticias</strong></legend>
<table class="table table-striped table-condensed">
	<thead>
		<th>Id noticia</th>
		<th>Título de la noticia</th>
		<th>Foto</th>
		<th>Desc.</th>
		<th>Fecha</th>
		<th>Hora.</th>
		<th width="100"></th>
	</thead>
	<tbody>
		<?php foreach ($noticias as $not) { ?>
		<tr class="roll">
			<td><?php echo $not['id_noticias'] ?></td>
			<td><?php echo $not['nombre_noticia'] ?></td>
			<td>
				<?php if($not['imagen_noticia']!=NULL) { ?>
					<span class="glyphicon glyphicon-ok"></span>
				<?php } ?>
			</td>
			<td>
				<?php if($not['texto_noticia']!=NULL) { ?>
					<span class="glyphicon glyphicon-ok"></span>
				<?php } ?>
			</td>
			<td><?php echo convertirFecha($not['fecha_modificacion']) ?></td>
			<td><?php echo $not['hora'] ?></td>
			<td>
				<a title="Editar noticia" class="btn btn-default btn-xs" href="<?php print get('webURL')._sh.'admin/noticias/'.$not['id_noticias'] ?>">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
				<a title="Eliminar" class="btn btn-danger btn-xs" onclick="eliminar('<?php print $not['id_noticias'] ?>');" href="#">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
				<a title="Eliminar" class="btn btn-default btn-xs" href="<?php print get("webURL")."/admin/vernoticia/".$not['id_noticias'] ?>">
					ver
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<script src="<?php print get("webURL")."/www/lib/froala_editor/js/froala_editor.min.js" ?>"></script>

<script type="text/javascript">
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