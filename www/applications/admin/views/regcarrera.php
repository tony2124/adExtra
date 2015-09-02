<?php if($carrera){ ?>
<legend><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;  <strong>Modificación de carrera</strong></legend>
<?php }else{ ?>
<legend><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;  <strong>Registro de nueva carrera</strong></legend>
<?php } ?>
<p></p>
<a class="btn btn-default pull-right" href="<?php print get('webURL').'/admin/carreras/' ?>"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
<form id="textoForm" action="<?php print isset($carrera) ? get('webURL')._sh.'admin/modcarrera/'.$carrera[0]['id_carrera'] : get('webURL')._sh.'admin/guardarcarrera' ?>" method="post">
	<div class="col-sm-8 form-horizontal">
		<?php if(!$carrera){ ?>
		<div class="form-group">
			<label class="label-control col-sm-3" for="id_carrera">ID carrera</label>
			<div class="col-sm-3">
				<input class="form-control" name="id_carrera" id="id_carrera" type="number" maxlength="2"  />
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
			<label class="label-control col-sm-3" for="titulo">Nombre de la carrera</label>
			<div class="col-sm-9">
				<input class="form-control" name="name" id="titulo" type="text" maxlength="50" value="<?php print ($carrera) ? $carrera[0]['nombre_carrera'] : NULL ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="label-control col-sm-3">Abreviatura de la carrera</label>
			<div class="col-sm-9">
				<input class="form-control" name="abreviatura" type="text" size="40" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['abreviatura_carrera'] : NULL ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="label-control col-sm-3">Plan de estudio</label>
			<div class="col-sm-9">
				<input class="form-control" name="plan" type="text" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['plan_estudio'] : NULL ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="label-control col-sm-3">Semestres</label>
			<div class="col-sm-4">
				<select name="sem" class="form-control">
					<?php
					$i = 6;
					$sem = 9;
					
					if($carrera)
						$sem = $carrera[0]['semestres_carrera'];

					for($i=6; $i<12; $i++)
					{
						 ?>
						<option <?php if($i == $sem) print 'selected="selected"' ?> value="<?php print $i ?>"><?php print $i ?></option>
						<?php
					}
					?>
					
				</select>
				<!--<input class="form-control" name="sem" type="text" size="40" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['semestres_carrera'] : NULL ?>" />-->
			</div>
		</div>
		<?php if(!$carrera){ ?>
			<center><input style="width: 150px" type="submit" class="btn btn-success" value="Registrar"></center>
		<?php } else { ?>
			<center><input style="width: 150px" type="submit" class="btn btn-success" value="Guardar"></center>
		<?php } ?>
	</div>
</form>
