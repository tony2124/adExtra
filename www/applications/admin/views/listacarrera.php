<div class="col-sm-12">
	<form action="<?php print get('webURL')._sh.'admin/listacarrera/' ?>" method="get" class="form-horizontal">
		<fieldset>
			<legend><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp; <strong>Lista de alumnos por carrera</strong></legend>
			<div class="form-group">
				<!--<label class="control-label">CLUB</label>-->
				<div class="col-sm-4">
					<select class="form-control" name="carrera" id="carrera">
					<option value="">--Selecciona una carrera--</option>
					<?php 
					foreach ($carreras as $row)
					{
						print '<option ';
						print ($par1 == $row['id_carrera']) ? 'selected="selected"' : '';
						print ' value="'.$row['id_carrera'].'">';
						print $row['abreviatura_carrera']." (".$row['plan_estudio'].")";	
						print '</option>';
					
					} ?>
				</select>
				</div>
		
				<!--<label class="form-label">PERIODO</label> -->
			    <div class="col-sm-4">
				  	<select class="form-control" name="periodo" id="periodo">
				  		<option value="">--Selecciona un periodo--</option>
					<?php
						
						foreach ($periodos as $per)
						{
							print '<option ';
							print ($per == $par2) ? 'selected="selected"' : '';
							print ' value="'.$per.'">';
							print $per;
							print '</option>';
						}
						?>
					</select>
				</div>
				<div class="col-sm-1">
				</div>
				<div class="col-sm-1">
					<span data-toggle="tooltip" data-placement="top" title="Búsqueda avanzada">
						<a data-toggle="modal" data-target="#avanzada" class="btn btn-primary"><span class="glyphicon glyphicon-filter"></span></a>  
					</span>
				</div>
				<div class="col-sm-2">
					<input type="button" value="Ver alumnos" style="width:100%" class="btn btn-primary" onclick="location.href='<?php print get("webURL")._sh."admin/listacarrera/" ?>'+$('#carrera').val()+'/'+$('#periodo').val()" />
				</div>
			</div>
			<hr>
		</fieldset>
	</form>
</div>

<?php 
if($alumnos != NULL) { ?>
	<div class="col-sm-9">	
		Número de registros encontrados: <?php print count($alumnos) ?><br>
		Nombre de la carrera: <?php print $alumnos[0]['nombre_carrera'] ?>

	</div>
	<!--<div class="col-sm-1">

	 	</span>
	 </div>
	<div class="col-sm-2">		
		<div class="btn-group" style="width:100%">
		  <a class="btn dropdown-toggle btn-default" data-toggle="dropdown" href="#" style="width:100%">
		  	<span  class="glyphicon glyphicon-save-file"></span>
		    Descarga
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
				<li><a href="<?php print get('webURL')._sh.'admin/pdf/formatos/lista/'.$par1.'/'.$par2 ?>" target="_blank">Lista de alumnos</a></li>
		  </ul>
		</div>
	</div>-->
<div style="clear: both"></div>

<p>&nbsp;</p>

<!--
<div class="btn-group pull-right">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    Descarga
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    
  </ul>
</div><br>-->
<hr>
<script src="<?php print path("www/lib/jquery.tablesorter.min.js","www") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/green/style.css","www") ?>">
<script>
$(document).ready(function() 
    { 
        $("#lista").tablesorter(); 
    } 
); 
    
</script>

<table id="lista" class="table table-striped table-condensed table-hover">


  <thead>
    <tr style="background: #eeeeee">
	  <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;N0.</th>
      <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;N. control</th>
      <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;Nombre</th>
      <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;Club</th>
      <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;Sexo</th>
      <th><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;Edad</th>
      <th align="center"><span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;Res.</th>
    </tr>
  </thead>
  <tbody>
<?php

$i=1;
foreach ($alumnos as $alum) {	?>
  <tr>
    <td><?php print $i++ ?></td>
    <td><?php print $alum['numero_control'] ?></td>
    <td><a href="<?php print get("webURL")._sh."admin/alumno/".$alum['numero_control'] ?>"><?php echo $alum['apellido_paterno_alumno']." ".$alum['apellido_materno_alumno']." ".$alum['nombre_alumno'] ?></a></td>
    <td><?php echo $alum['nombre_club'] ?></td>
    <td align="center"><?php echo ($alum['sexo']==1) ? 'H' : 'M' ?></td>
    <td align="center"><?php echo calcularEdad($alum['fecha_nacimiento'],$alum['fecha_inscripcion_club']) ?></td>
    <td align="center" <?php print ($alum['acreditado']==0) ? 'class="danger"' :'class="success"' ?>><?php echo ($alum['acreditado']==0) ? 'NO' :'SI'  ?></td>
  </tr>
<?php	
}
?>
   </tbody>
 </table>
<?php } ?>

<div class="modal fade"  id="avanzada" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><div>Búsqueda avanzada <span class="label label-primary">Pro</span></div></h3>
      </div>
      <div class="modal-body">
      	<div class="form-horizontal">
	   	<div class="form-group">
	    	<label class="col-sm-2 control-label">CARRERA: </label>
		    <div class="col-sm-3">
		      	<select name="club" id="club" class="form-control">
		      		<option value="">--Selecciona una carrera--</option>
					<?php 
					foreach ($carreras as $row)
					{
						print '<option ';
						print ($par1 == $row['id_carrera']) ? 'selected="selected"' : '';
						print ' value="'.$row['id_carrera'].'">';
						print $row['abreviatura_carrera'];	
						print '</option>';
					
					} ?>

						
					</select>
		    </div>
	    	<label class="col-sm-3 control-label">PERIODO: </label>
		    <div class="col-sm-3">
		      	<select class="form-control" name="periodo" id="periodo">
				  		<option value="">--Selecciona un periodo--</option>
					<?php
						
						foreach ($periodos as $per)
						{
							print '<option ';
							print ($per == $par2) ? 'selected="selected"' : '';
							print ' value="'.$per.'">';
							print $per;
							print '</option>';
						}
						?>
					</select>
		    </div>
  		</div>
  		<div class="form-group">
	    	<label class="col-sm-2 control-label">CLUB: </label>
		    <div class="col-sm-3">
		      	<select id="status" class="form-control input">
		      		<option value="-1">-- Sin filtro</option>
		      		<!--<option value="1">Activo</option>
		      		<option value="0">Inactivo</option>-->
		      	</select>
		    </div>
	    	<label class="col-sm-3 control-label">SEXO: </label>
		    <div class="col-sm-3">
		      	<select id="status" class="form-control input">
		      		<option value="-1">-- Sin filtro</option>
		      		<option value="1">Activo</option>
		      		<option value="0">Inactivo</option>
		      	</select>
		    </div>
  		</div>
  		<div class="form-group">
	    	<label class="col-sm-2 control-label">SIT. ESC.: </label>
		    <div class="col-sm-3">
		      	<select id="status" class="form-control input">
		      		<option value="-1">-- Sin filtro</option>
		      		<option value="1">Activo</option>
		      		<option value="0">Inactivo</option>
		      	</select>
		    </div>
  		</div>

  		<div class="form-group">
	    	<label class="col-sm-2 control-label">Edad: </label>
		    <div class="col-sm-3">
		      	<select id="fecha" onchange="verificar2()" class="form-control input">
		      		<option value="0">--- Sin filtro</option>
		      		<option value="1">Menor que</option>
		      		<option value="2">Igual que</option>
		      		<option value="3">Mayor que</option>
		      		<option value="4">Entre</option>
		      	</select>
		    </div>
		    <div class="col-sm-3">
		      	<input id="fecha_i"  disabled class="form-control input" type="num" min="0">
		    </div> 
		    <div class="col-sm-3">
		      	<input id="fecha_f" style="display:none" class="form-control input" type="num" min="0">
		    </div> 

  		</div>

  		</div>
  		<div style="clear:both"></div>
  		<p>&nbsp;</p>
	  </div>
	  <div class="modal-footer">
	  	<center>
		    <button style="width: 150px" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		    <button onclick="aplicar()" style="width: 150px" class="btn btn-primary" data-dismiss="modal">Aplicar</button>
		    <input type="hidden" id="filtro">
	    </center>
      </div>
    </div>
  </div>
</div>
