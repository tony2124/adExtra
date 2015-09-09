<script src="<?php print path("vendors/js/jquery-ui.min.js","zan") ?>"></script>
<link href="<?php print path("vendors/css/frameworks/jquery-ui/jquery-ui.min.css", "zan"); ?>" rel="stylesheet">

<script type="text/javascript">
$().ready(function() {

  $( ".selectorFechaInicio" ).datepicker({ 
        dateFormat: 'yy-mm-dd',  
        showAnim: 'show',
        duration: 'normal',
        changeMonth: true,
                changeYear: true });
});
</script>
<?php if (strcmp($type,"success") == 0) { ?>
<div class="alert alert-success">Los datos de la revisión han sido actualizados satisfactoriamente.</div>
<?php } if ($revactual) { ?>
<legend><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;  <strong>Actualizar revisión</strong></legend>
<?php }else{ ?>
<legend><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;  <strong>Registrar revisión</strong></legend>
<?php } ?>
<div class="well">Utilice el siguiente formulario para registrar una nueva revisión de formatos. NOTA: Tenga cuidado al momento de registrar la fecha de la revisión. Se tomará en cuenta la revisión con la fecha más reciente.</div>
<form id="textoForm" action="<?php print (!$revactual) ? get("webURL")."/admin/guardarRevision" : get("webURL")."/admin/actualizarRevision/".$revactual[0]['id_revision'] ?>" method="post" enctype="multipart/form-data">
	<div class="col-sm-12 form-horizontal">
		<div class="form-group">
			<label class="label-control col-sm-1">Nombre rev.</label>
			<div class="col-sm-4">
				<input class="form-control" name="nombre" type="text" value="<?php print ($revactual) ? $revactual[0]['nombre_revision'] : null ?>" />		
			</div>
		
			<div class="col-sm-2">
				<!--<input class="form-control" name="name" id="titulo" type="text" size="40" maxlength="40" />-->
			</div>
			<label class="label-control col-sm-1">Tipo formato:</label>
			<div class="col-sm-4">
				<select name="tipo_formato" class="form-control">
					<?php 
					foreach ($formatos as $k ) {
					
					?>
					<option <?php if ($revactual) if($revactual[0]['tipo_formato'] == $k['id_formato']) print "selected='selected'"; ?> value="<?php print $k['id_formato'] ?>" ><?php print $k['nombre_formato'] ?></option>

					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="label-control col-sm-1">Norma:</label>
			<div class="col-sm-4">
				<input class="form-control" name="norma" type="text" value="<?php print ($revactual) ? $revactual[0]['norma'] : null ?>" />		
			</div>
			<div class="col-sm-2"></div>
			<label class="label-control col-sm-1">Código:</label>
			<div class="col-sm-4">
				<input class="form-control" name="codigo" type="text" value="<?php print ($revactual) ? $revactual[0]['codigo'] : null ?>" />
			</div>
		</div>
		<div class="form-group">	
			<label class="label-control col-sm-1">Fecha inicio:</label>
			<div class="col-sm-4">
				<input class="form-control selectorFechaInicio" name="fecha" type="text" value="<?php print ($revactual) ? $revactual[0]['fecha_inicio_revision'] : null ?>" />
			</div>
			<div class="col-sm-7"></div>
		</div>
		<div class="form-group">	
			<div class="col-sm-10"></div>
			
			<div class="col-sm-2">
				<input class="btn btn-success" style="width: 100%" value="Guardar" type="submit" />
			</div>
		</div>
	</div>
</form>
		
<div style="clear: both"></div>
<hr>
<p>&nbsp;</p>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;  <strong>Historial de revisiones</strong> </legend>
<table class="table table-striped table-condensed">
	<thead>
		<th>ID</th>
		<th>Nombre rev.</th>
		<th>Código</th>
<!--	<th>Foto</th>-->
		<th>Norma</th>
		<th>Fecha inicio</th>
		<!--<th>Fecha fin</th>-->
		<th>Tipo formato</th>
		<th width="30"></th>
	</thead>
	<tbody>
		<?php foreach ($revisiones as $rev) { ?>
		<tr class="roll">
			<td><?php echo $rev['id_revision'] ?></td>
			<td><?php echo $rev['nombre_revision'] ?></td>
			<td><?php echo $rev['codigo'] ?></a></td>
			<td><?php echo $rev['norma'] ?></td>
			<td><?php echo convertirFecha($rev['fecha_inicio_revision']) ?></td>
			<!--<td><?php echo convertirFecha($rev['fecha_fin_revision'])  ?></td>-->
			<td><?php echo $rev['nombre_formato']  ?></td>
			<td>
				<a rel="tooltip" title="Editar" class="btn btn-default btn-xs" href="<?php print get("webURL")._sh.'admin/revisiones/'.$rev['id_revision'] ?>">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>
