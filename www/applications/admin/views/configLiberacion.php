<script src="<?php print path("vendors/js/jquery-ui.min.js","zan") ?>"></script>
<link href="<?php print path("vendors/css/frameworks/jquery-ui/jquery-ui.min.css", "zan"); ?>" rel="stylesheet">

 <script type="text/javascript">

 
$().ready(function() {

  $( ".selectorFechaInicio" ).datepicker({ 
        dateFormat: 'yy-mm-dd',  
        showAnim: 'explode',
        duration: 'normal',
        changeMonth: true,
                changeYear: true });
});
</script>

<form class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/updateLiberacion' ?>">
  <fieldset>
    <legend>Fechas de inscripciones</legend>
    <div class="well">
      Esta fecha hace referencia al periodo de inscripción del alumno. El campo de número de clubes por periodo tiene el número máximo de clubes que el alumno puede inscribirse.
    </div>
    <div class="control-group">
      <label class="col-sm-1 control-label" for="ins_ini">Del</label>
      <div class="col-sm-3">
        <input type="text" class="selectorFechaInicio form-control" name="ins_ini" id="ins_ini" value="<?php print $config['fecha_inicio_inscripcion'] ?>">
      </div>
      <label class="col-sm-1 control-label" for="ins_fin">Al</label>
      <div class="col-sm-3">
        <input type="text" class="selectorFechaInicio form-control" name="ins_fin" id="ins_fin" value="<?php print $config['fecha_fin_inscripcion'] ?>">
      </div>
      <label class="col-sm-2 control-label" for="nclubes">No. de clubes por periodo</label>
      <div class="col-sm-2">
      	<select class="form-control" name="nper"> 
      		<?php $i = 1; while($i <= 8) { ?>
      		<option <?php if($i == $config['numero_clubes_periodo']) print 'selected="selected"' ?>><?php print $i++ ?></option>
      		<?php } ?>
      	</select>
      </div>
     </div>
     <legend>Fechas de liberación</legend>
     <div class="control-group">
      <label class="control-label" for="lib_ini">Fecha de inicio</label>
      <div class="controls">
        <input type="text" class="selectorFechaInicio" name="lib_ini" class="form-control" id="lib_ini" value="<?php print $config['fecha_inicio_liberacion'] ?>">
      </div>
      <label class="control-label" for="lib_fin">Fecha de fin</label>
      <div class="controls">
        <input type="text" class="selectorFechaInicio" name="lib_fin" class="form-control" id="lib_fin" value="<?php print $config['fecha_fin_liberacion'] ?>">
      </div><br>
      <label class="control-label" for="periodo">Periodo de liberación</label>
      <div class="controls">
      	<select name="periodo">
       	<?php foreach ($periodos as $per) { ?>
       		<option <?php if($per == $config['periodo']) print 'selected="selected"' ?>><?php print $per; ?></option>
       	<?php } ?>
       	</select>
      </div><br>
      <div class="controls">
        <input type="submit" value="Guardar" class="btn btn-success">
      </div>
     </div>

   </fieldset>
</form>