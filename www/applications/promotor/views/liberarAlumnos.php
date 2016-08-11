 <legend><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;  <strong>Listas de alumnos</strong></legend>
<!--COMBO PARA SELECCIONAR EL PERIODO -->
<p class="label label-primary">SELECCIONA UN PERIODO: </p>
<div class="form-group">
  	<div class="col-sm-3">
		<select class="form-control" style="max-width:300px" onchange="location.href='<?php print get("webURL").'/promotor/index/' ?>'+$(this).val()">
			<?php foreach ($periodos as $per ) {
				print "<option ";
				if(strcmp($per,$periodo)==0) print "selected='selected'";
				?>

				 id="<?php print $per ?>">
				
				<?php print $per;
				print "</option>";		
			}
			?>
		</select>
	</div>
	<div class="col-sm-7"></div>
	<div class="col-sm-2">
		<?php if($promotorasignado) {  ?>
		<div class="btn-group" style="width:100%">
	      <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#" style="width:100%">
	        <span  class="glyphicon glyphicon-save"></span>
	        Descarga
	        <span class="caret"></span>
	      </a>
	      <ul class="dropdown-menu">
	        <li><a target="_blank" href="<?php print get('webURL')._sh.'admin/pdf/formatos/lista/'.$alumnos[0]['id_club'].'/'.$periodo ?>">Lista de alumnos</a></li>
	        <li><a href="#" target="_blank">Lista de resultados <span class="label label-primary">Pro</span></a> </li>
	      </ul>
	    </div>
	    <?php  } ?>
	</div>
</div>
<div style="clear: both"></div>
<hr>
<?php if(!$promotorasignado) {  ?>
<div class="alert alert-warning">No ha sido asignado a un club en el periodo <?php print $periodo ?>. Contacte al administrador del sistema para que sea asignado.</div>

<?php
 return; }
 ?>

<table>
	<tr>
		<td width="100">CLUB:</td>
		<td><b><?php print strtoupper($promotorasignado[0]['nombre_club']) ?></b></td>
	</tr>
	<tr>
		<td>PERIODO: </td>
		<td><b><?php print $periodo ?></b></td>
	</tr>
	<tr>
		<td>NÚM. ALUM.:</td>
		<td> <b><?php print ($alumnos) ? sizeof($alumnos) : "0" ?></b></td>
	</tr>
</table>
<hr>
<form action="<?php print get('webURL')._sh.'promotor/acreditando/'.$periodo ?>" method="post">
	<input type="hidden" name="na" value="<?php print sizeOf($alumnos) ?>">
<table class="table table-striped table-condensed table-hover">
	<thead>
		<th>No.</th>
		<th>No. Control</th>
		<th>Nombre</th>
		<th>Sexo</th>
		<th>Sem</th>
		<th>Carrera</th>
		<th>Resultado</th>
		<?php if($liberacion){ ?><th colspan="2">Panel</th> <?php }?>
	</thead>
	<tbody>
		<?php if($alumnos!=NULL) { $i=0;
			foreach ($alumnos as $alumno) { ?>
	   <tr>
	   	<td><?php print $i+1; ?></td>
		<td><?php print strtoupper($alumno['numero_control']) ?></td>
		<td><a target="_blank" href="<?php print get("webURL")."/promotor/alumno/".$alumno['numero_control'] ?>"> <?php print strtoupper($alumno['apellido_paterno_alumno'].' '.$alumno['apellido_materno_alumno'].' '.$alumno['nombre_alumno']) ?></a></td>
		<td><?php print (strcmp($alumno['sexo'],"1") == 0) ? "HOMBRE" : "MUJER";  ?></td>
		<td><?php print $alumno['semestre'] ?></td>
		<td><?php print strtoupper($alumno['abreviatura_carrera']) ?></td>
		<td> <?php print ($alumno['acreditado'] == 1) ? "<label class='label label-success'>ACREDITADO</label>" : "<label class='label label-danger'>NO ACREDITADO</label>"  ?></td>
		<?php if($liberacion){ ?>
		<td width="100">
			
			<div class="btn-group" data-toggle="buttons">
			  <label class="btn btn-default btn-sm <?php if($alumno['acreditado'] == 1) print 'active' ?>">
			    <!--<input type="radio" name="options" id="option2" autocomplete="off"> Radio 2-->
			    <input type="radio" <?php if($alumno['acreditado'] == 1) print 'checked' ?> name="res<?php print $i ?>" id="si<?php print $i ?>" value="1">SI
			  </label>
			  <label class="btn btn-default btn-sm <?php if($alumno['acreditado'] == 0) print 'active' ?>">
			    <!--<input type="radio" name="options" id="option3" autocomplete="off"> Radio 3-->
			    <input type="radio" <?php if($alumno['acreditado'] == 0) print 'checked' ?> name="res<?php print $i ?>" id="no<?php print $i ?>" value="0">NO
				<input type="hidden" name="folio<?php print $i++ ?>" value="<?php print $alumno['folio'] ?>">
			  </label>
			</div>
			
		</td>
		<?php } ?>
	   </tr>
	   <?php } } ?>
	</tbody>
</table>
<?php if($liberacion){ ?><input type="submit" class="btn btn-primary pull-right" value="Guardar reporte"><?php } ?>
<div style="clear: both"></div>
</form>
<?php // } else { ?>
<hr>
		<!--<h3>Descarga de lista del periodo: <a target="_blank" href="<?php print get('webURL')._sh.'admin/pdf/formatos/lista/'.$alumnos[0]['id_club'].'/'.$periodo ?>" class="btn"><?php print $periodo ?></a></h3>-->
<?php // } ?>