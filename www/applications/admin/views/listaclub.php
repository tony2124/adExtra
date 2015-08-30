<div class="col-sm-12">
	<form action="<?php print get('webURL')._sh.'admin/listaclub/' ?>" method="get" class="form-horizontal">
		<fieldset>
			<legend><span class="glyphicon glyphicon-folder-open"></span> Elije un club y un periodo</legend>
			<div class="form-group">
				<!--<label class="control-label">CLUB</label>-->
				<div class="col-sm-4">
					<select name="club" id="club" class="form-control">
						<option value="">--Selecciona un club--</option>
						<?php 
						foreach ($clubes as $row)
						{
							print '<option ';
							print ($par1 == $row['id_club']) ? 'selected="selected"' : '';
							print ' value="'.$row['id_club'].'">';
							print $row['nombre_club'];	
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
					<input type="button" value="Ver alumnos" style="width:100%" class="btn btn-primary" onclick="location.href='<?php print get("webURL")._sh."admin/listaclub/" ?>'+$('#club').val()+'/'+$('#periodo').val()" />
				</div>
			</div>
			<hr>
		</fieldset>
	</form>
</div>
<?php 
if($alumnos != NULL) { ?>

	<div class="col-sm-9">Número de registros encontrados: <?php print count($alumnos) ?></div>
	<div class="col-sm-1">
	 	<span data-toggle="tooltip" data-placement="top" title="Gráfico de hombres y mujeres">
	 	<button class="btn btn-default" data-toggle="collapse"  data-target="#graf" aria-expanded="false" aria-controls="graf"><span class="glyphicon glyphicon-stats"></span></button>  
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
		    <li><a href="<?php print get('webURL')._sh.'admin/pdf/formatos/cedula/'.$par1.'/'.$par2 ?>" target="_blank">Cédula de inscripción</a></li>
		    <li><a href="<?php print get('webURL')._sh.'admin/pdf/formatos/resultados/'.$par1.'/'.$par2 ?>" target="_blank">Cédula de resultados</a></li>
		    <li class="divider"></li>
		    <li><a href="<?php print get('webURL')._sh.'admin/pdf/formatos/zip-lib/'.$par1.'/'.$par2 ?>" target="_blank">ZIP formatos de acred. de actividad</a></li>
		    <li><a href="<?php  ?>" target="_blank">ZIP formatos de act. comp.</a></li>
		  </ul>
		</div>
	</div>
<div style="clear: both"></div>

<p>&nbsp;</p>
<div class="collapse" id="graf">
		<p>Muestra una comparativa entre la cantidad de mujeres y hombres inscritos en el club.</p>
		<div id="piechart_3d" style="width: 500px; height:430px" ></div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>

</div>


<script src="<?php print path("www/lib/jquery.tablesorter.min.js","www") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/green/style.css","www") ?>">
<script >
	$(document).ready(function() { 
	        $("#lista").tablesorter(); 
	    } 
	); 
    
     function verificar2(){
			//alert("cambio a " + $("#costo").val());
			if($("#fecha").val() == 0)
				$("#fecha_i").attr("disabled","disabled");
			else 
				$("#fecha_i").removeAttr("disabled");

			if($("#fecha").val() == 4)
				$("#fecha_f").css("display","block");
			else
				$("#fecha_f").css("display","none");
		}

	
</script>


<div class="table-responsive">
	<table id="lista" class="table table-striped table-condensed table-hover">


	  <thead>
	    <tr style="background: #eeeeee">
	      <th><span class="icon-chevron-down"></span><br>N0.</th>
	      <th><span class="icon-chevron-down"></span><br>N. control</th>
	      <th><span class="icon-chevron-down"></span><br>Nombre</th>
	      <th><span class="icon-chevron-down"></span><br>Carrera</th>
	      <th><span class="icon-chevron-down"></span><br>Sexo</th>
	      <th><span class="icon-chevron-down"></span><br>Edad</th>
	      <th><span class="icon-chevron-down"></span><br>Res.</th>
	    </tr>
	  </thead>
	  <tbody>
	<?php
	$hombres = $mujeres = 0; 
	$i=1;
	foreach ($alumnos as $alum) {	?>
	<?php  if($alum['sexo']==1) $hombres++; else $mujeres++; ?>
	  <tr>
	    <td><?php print $i++ ?></td>
	    <td><?php print $alum['numero_control'] ?></td>
	    <td><a href="<?php print get("webURL")._sh."admin/alumno/".$alum['numero_control'] ?>"><?php echo $alum['apellido_paterno_alumno']." ".$alum['apellido_materno_alumno']." ".$alum['nombre_alumno'] ?></a></td>
	    <td><?php echo $alum['abreviatura_carrera'] ?></td>
	    <td><?php echo ($alum['sexo']==1) ? 'H' : 'M' ?></td>
	    <td><?php echo calcularEdad($alum['fecha_nacimiento'],$alum['fecha_inscripcion_club']) ?></td>
	    <td><?php echo ($alum['acreditado']==0) ? 'NO' :'SI'  ?></td>
	  </tr>
	<?php	
	}
	?>
	   </tbody>
	 </table>
</div>
<?php } ?>

<div class="modal fade"  id="avanzada" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><div>Búsqueda avanzada</div></h3>
      </div>
      <div class="modal-body">
      	<div class="form-horizontal">
	   	<div class="form-group">
	    	<label class="col-sm-2 control-label">CLUB: </label>
		    <div class="col-sm-3">
		      	<select name="club" id="club" class="form-control">
						<option value="">--Selecciona un club--</option>
						<?php 
						foreach ($clubes as $row)
						{
							print '<option ';
							print ($par1 == $row['id_club']) ? 'selected="selected"' : '';
							print ' value="'.$row['id_club'].'">';
							print $row['nombre_club'];	
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
	    	<label class="col-sm-2 control-label">CARRERA: </label>
		    <div class="col-sm-3">
		      	<select id="status" class="form-control input">
		      		<option value="-1">-- Sin filtro</option>
		      		<option value="1">Activo</option>
		      		<option value="0">Inactivo</option>
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

<script src="<?php print path("www/lib/google/jsapi.js","www") ?>"></script>
<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {
	    var data = google.visualization.arrayToDataTable([
	    	['Task', 'Hours per Day'],
	    	['HOMBRES', <?php print $hombres ?>],
	    	['MUJERES', <?php print $mujeres ?>]
	      
	    ]);

	    var options = {
	      title: 'HOMBRES Y MUJERES',
	      height: 500,
	      width: 800,
	      chartArea:{top: '0px'},
	      is3D: true
	    };

	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
	    chart.draw(data, options);
	  }


</script>