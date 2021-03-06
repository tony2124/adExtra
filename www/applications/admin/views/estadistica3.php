  <script src="<?php print path("www/lib/google/jsapi.js","www") ?>"></script>
 <legend><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;  <strong>Estadísticas</strong></legend>
<!--COMBO PARA SELECCIONAR EL PERIODO -->
<p class="label label-primary">SELECCIONA UN PERIODO: </p>
<div class="form-group">
  	<div class="col-sm-3">
		<select class="form-control" style="max-width:300px" onchange="location.href='<?php print get("webURL").'/admin/estadistica/' ?>'+$(this).val()">
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

	<div class="col-sm-3"></div>
	<div class="col-sm-2">
		<a style="width:100%" href="<?php print get("webURL")."/admin/aplicacion" ?>" data-toggle="tooltip" title="Lista de registros de descarga de la APP." class="btn btn-success">Descargas APP</a>
	</div>
	<div class="col-sm-2">
		<div style="width:100%" class="btn-group">
	      <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#" style="width:100%">
	        <span  class="glyphicon glyphicon-save"></span>
	        Descarga
	        <span class="caret"></span>
	      </a>
	      <ul class="dropdown-menu">
	        <!--<li><a data-toggle="modal" data-target="#myModal" target="_blank" href="<?php print get("webURL")."/admin/pdf/formatos/zip-ins/0/$periodo"  ?>">ZIP Cédulas de Inscripción</a></li>-->
	        <li><a data-toggle="modal" data-target="#myModal" href="#">ZIP Cédulas de Inscripción</a></li>
	        <li><a data-toggle="modal" data-target="#myModalRes" href="#" >ZIP Cédulas de resultados</a></li>
	      </ul>
	    </div>
	</div>
	<div class="col-sm-2">
	    <a style="width:100%" href="<?php print get("webURL")."/admin/notificacion/1" ?>" data-toggle="tooltip" title="Envía el aviso a los celulares." class="btn btn-primary"><span class="glyphicon glyphicon-phone"></span> Notificar</a>
	</div>
</div>
<div style="clear: both"></div>
<hr>

<?php for ($indice = 0; $indice < sizeof($periodos); $indice++)
			{ 

				$th = 0;
				$thX = 0;
				$tm = 0;
				$tmX = 0;
				$thL = 0;
				$tmL = 0;
				$porcentaje = 0;
				$i = 0;
				$conta = 0;
				$contaX= 0;
				while($i < sizeof($clubes))
				{
					//if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
					{
						$contador = 0;
						$hombres = 0;
						$mujeres = 0;
						$hombresX = 0;
						$mujeresX = 0;
						$hLib = 0;
						$mLib = 0;
						if($todos_alumnos != null)
						foreach ($todos_alumnos as $al) {
							if(strcmp($al['periodo'],$periodos[$indice])==0)
							{
								if($al['id_club'] == $clubes[$i]['id_club'])
								{
									if(strcmp($al['sexo'],'2')==0)
									{
										if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
										{
											$mujeres++;
											if($al['acreditado'] == 1)
												$mLib++;
										}
										else
										{
											$mujeresX++;
										}
									}
									else
									{
										if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
										{
											if($al['acreditado'] == 1)
												$hLib++;
											$hombres++;
										}
										else
										{
											$hombresX++;
										}
									}
									
								}
							}
						}

						$th += $hombres;
						$thX += $hombresX;
						$tm += $mujeres;
						$tmX += $mujeresX;
						$thL += $hLib;
						$tmL += $mLib;
						$por = ($mujeres + $hombres > 0) ? round( ($hLib + $mLib) / ($mujeres + $hombres) * 10000) / 100 : 0;
						
						if( strcmp( $periodo, $periodos[$indice]) == 0 )
						{
							if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
							{
								$mostrar[$conta][0] = $clubes[$i]['id_club'];
								$mostrar[$conta][1] = $clubes[$i]['tipo_club'];
								$mostrar[$conta][2] = $clubes[$i]['nombre_club'];
								$mostrar[$conta][3] = $mujeres;
								$mostrar[$conta][4] = $hombres;
								$mostrar[$conta][5] = $mujeres + $hombres;
								$mostrar[$conta][6] = $mLib;
								$mostrar[$conta][7] = $hLib;
								$mostrar[$conta][8] = $hLib+$mLib;
								$mostrar[$conta][9] = $por;
								
								$conta++;
							}
							else
							{
								$mostrarX[$contaX][0] = $clubes[$i]['id_club'];
								$mostrarX[$contaX][1] = $clubes[$i]['tipo_club'];
								$mostrarX[$contaX][2] = $clubes[$i]['nombre_club'];
								$mostrarX[$contaX][3] = $mujeresX;
								$mostrarX[$contaX][4] = $hombresX;
								$mostrarX[$contaX][5] = $mujeresX + $hombresX;
								$contaX++;
							}	
						}
					}

					$i++;
				}

				if( strcmp( $periodo, $periodos[$indice]) == 0 )
				{
					$totales[0] = $tm; 
					$totales[1] = $th;
					$totales[2] = $tm+$th;
					$totales[3] = $tmL;
					$totales[4] = $thL;
					$totales[5] = $tmL+$thL;

					$totalesX[0] = $tmX;
					$totalesX[1] = $thX;
					$totalesX[2] = $tmX + $thX;

				}

				$porcentaje = ($tm+$th > 0) ? round( ($tmL+$thL) / ($tm+$th) * 10000 ) / 100 : 0;

				if(strcmp($periodo,$periodos[$indice])==0)
					$ppa = $porcentaje;

				$pct[$periodos[$indice]] = $tmL+$thL + $tmX + $thX;//$porcentaje;
			}
				?>	
<div class="alert alert-info">ESTADÍSTICAS DE ALUMNOS INSCRITOS/LIBERADOS EN LOS CLUBES EN EL PERIODO: <strong><?php print $periodo ?></strong></div>
<p style="float: right">TOTAL DE ALUMNOS LIBERADOS: <span style="font-size: 30px"><?php print  $totalesX[2] + $totales[5]?></span></p>
<!-- PESTAÑAS PARA MOSTRAR LA INFORMACIÓN POR SEPARADO. -->
    <ul class="nav nav-tabs">
	    <li class="active"><a href="#clubes" data-toggle="tab"><span class="glyphicon glyphicon-knight"></span> CLUBES</a></li>
	    <li><a href="#otros" data-toggle="tab"><span class="glyphicon glyphicon-record"></span>  OTRAS ACT.</a></li>
	    <li><a href="#carreras" data-toggle="tab"><span class="glyphicon glyphicon-education"></span>  CARRERAS</a></li>
	    <li><a href="#grafico" data-toggle="tab"><span class="glyphicon glyphicon-stats"></span> GRÁFICO PARTICIPACIÓN</a></li>
    </ul>

    <div class="tab-content">
		<div class="tab-pane active" id="clubes">
			<div class="table-responsive">
			<table id="estadistica" width="600" class="table table-bordered table-condensed table-hover">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Tipo</th>
					    <th rowspan="2">Nombre del club</th>
					    <th colspan="3">Alumnos inscritos</th>
					    <th colspan="3">Alumnos Liberados</th>
					    <th rowspan="2">Acreditado, %</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
				<?php 
					$i = 0;
					$ix = 0;
					while($ix < sizeof($clubes)) 
					{ 
						if ( strcmp ( $clubes[$ix]['tipo_club'] , "3" ) != 0 )
						{
					?>

						<tr>
							<td><?php echo $mostrar[$i][0] ?></td>
							<td><?php echo $mostrar[$i][1] ?></td>		
							<td>
								<a href="<?php print get("webURL")._sh.'admin/listaclub/'.$mostrar[$i][0].'/'.$periodo ?>"><?php echo $mostrar[$i][2] ?></a>
							</td>
							<td><?php print $mostrar[$i][3] ?></td>
							<td><?php print $mostrar[$i][4] ?></td>
							<td><?php print $mostrar[$i][5] ?></td>
							<td><?php print $mostrar[$i][6] ?></td>
							<td><?php print $mostrar[$i][7] ?></td>
							<td><?php print $mostrar[$i][8] ?></td>
							<td style="color: <?php if($mostrar[$i][9] > 90) print "green"; else if($mostrar[$i][9] < 70) print "red" ?>"><?php print $mostrar[$i][9]." %"  ?></td>
						</tr>
						<?php
						$i++;
						}
					$ix++;
					}
				?>
					<tr bgcolor="#EEF">
						<td colspan="3"></td>
						<td style="font-size: 15px;"><b><?php print $totales[0] ?></b></td>
						<td style="font-size: 15px;"><b><?php print $totales[1] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totales[2] ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $totales[3] ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $totales[4] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totales[5] ?></b></td>
						<td style="font-size: 20px; color: <?php if($ppa > 90) print "green"; else if($ppa < 70) print "red" ?>"><b><?php print $ppa. " %"  ?></td>
					</tr>
				</tbody>
			</table>
			</div>
			<hr>
			

		</div>
		<div class="tab-pane" id="otros">
			<!-- ****** TABLA OTROS ****** -->
			<div class="table-responsive">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Tipo</th>
					    <th rowspan="2">Nombre del club</th>
					    <th colspan="3">Alumnos liberados</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
				<?php 
					$i = 0;
					$ix = 0;
					while($ix < sizeof($clubes)) 
					{ 
						if ( strcmp ( $clubes[$ix]['tipo_club'] , "3" ) == 0 )
						{
					?>
					<tr>
						<td><?php echo $mostrarX[$i][0] ?></td>
						<td><?php echo $mostrarX[$i][1] ?></td>		
						<td>
							<a href="<?php print get("webURL")._sh.'admin/listaclub/'.$clubes[$ix]['id_club'].'/'.$periodo ?>"><?php echo $clubes[$ix]['nombre_club'] ?></a>
						</td>
						<td><?php print $mostrarX[$i][3] ?></td>
						<td><?php print $mostrarX[$i][4] ?></td>
						<td><?php print $mostrarX[$i][5] ?></td>
					</tr>
					<?php
					
					$i++;
					}
					$ix++;
					}
				?>
					<tr bgcolor="#EEF">
						<td colspan="3"></td>
						<td style="font-size: 15px;"><b><?php print $totalesX[0] ?></b></td>
						<td style="font-size: 15px;"><b><?php print $totalesX[1] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totalesX[2] ?></b></td>
						
					</tr>
				</tbody>
			</table>
			</div>
			<hr>
			
		</div>
		<div class="tab-pane" id="carreras">
			<div class="table-responsive">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Nombre de la carrera</th>
					    <th colspan="3">Alumnos inscritos</th>
					    <th colspan="3">Alumnos Liberados</th>
					    <th rowspan="2">Acreditado, %</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
			  		<?php

					$th = 0;
					$tm = 0;
					$thL = 0;
					$tmL = 0;
					$porcentaje = 0;
					$i = 0;
					
					while($i < sizeof($carreras))
					{

							$contador = 0;
							$hombres = 0;
							$mujeres = 0;
							$hLib = 0;
							$mLib = 0;
							if($alumnos != null)
							foreach ($alumnos as $al) {
								if($al['id_carrera'] == $carreras[$i]['id_carrera'])
								{
									if(strcmp($al['tipo_club'], "3") != 0)
									{
										if(strcmp($al['sexo'],'2')==0)
										{
											$mujeres++;
											if($al['acreditado'] == 1)
												$mLib++;
										}
										else
										{
											if($al['acreditado'] == 1)
												$hLib++;
											$hombres++;
										}
									}
									
									
								}
							}
							$dg[$i][0] = $carreras[$i]['abreviatura_carrera'];
							$dg[$i][1] = $hombres;
							$dg[$i][2] = $mujeres;
							$dg[$i][3] = $hombres + $mujeres;
							$dg[$i][4] = $hLib;
							$dg[$i][5] = $mLib;
							$dg[$i][6] = $hLib + $mLib;

							$th += $hombres;
							$tm += $mujeres;
							$thL += $hLib;
							$tmL += $mLib;
							$por = ($mujeres + $hombres > 0) ? round( ($hLib + $mLib) / ($mujeres + $hombres) * 10000) / 100 : 0;
							
				?>
							<tr>
								<td><?php echo $carreras[$i]['id_carrera'] ?></td>
										
								<td>
									<a href="<?php print get("webURL")._sh.'admin/listacarrera/'.$carreras[$i]['id_carrera'].'/'.$periodo ?>"><?php echo $carreras[$i]['nombre_carrera']." (".$carreras[$i]['plan_estudio'].")" ?></a>		
								</td>
								<td><?php print $mujeres ?></td>
								<td><?php print $hombres ?></td>
								<td><?php print $mujeres + $hombres ?></td>
								<td><?php print $mLib ?></td>
								<td><?php print $hLib ?></td>
								<td><?php print $hLib+$mLib ?></td>
								<td style="color: <?php if($por > 90) print "green"; else if($por < 70) print "red" ?>"><?php print $por." %"  ?></td>
							</tr>
				<?php
						
						$i++;
					}

					$porcentaje = ($tm+$th > 0) ? round( ($tmL+$thL) / ($tm+$th) * 10000 ) / 100 : 0;
				?>
				<tr>
					<td colspan="2"></td>
					<td style="font-size: 15px;"><b><?php print $tm ?></b></td>
					<td style="font-size: 15px;"><b><?php print $th ?></b></td>
					<td style="font-size: 20px;"><b><?php echo $tm+$th ?></b></td>
					<td style="font-size: 15px;"><b><?php echo $tmL ?></b></td>
					<td style="font-size: 15px;"><b><?php echo $thL ?></b></td>
					<td style="font-size: 20px;"><b><?php echo $tmL+$thL ?></b></td>
					<td style="font-size: 20px; color: <?php if($porcentaje > 90) print "green"; else if($porcentaje < 70) print "red" ?>"><b><?php print $porcentaje. " %"  ?></td>
				</tr>
			  	</tbody>
			 </table>
			</div>
			 <hr>
			 <!-- ****** TABLA OTROS ****** --
			 <div class="table-responsive">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Tipo</th>
					    <th rowspan="2">Nombre del club</th>
					    <th colspan="3">Alumnos liberados</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
				<?php 
					$i = 0;
					$ix = 0;
					while($ix < sizeof($clubes)) 
					{ 
						if ( strcmp ( $clubes[$ix]['tipo_club'] , "3" ) == 0 )
						{
					?>
					<tr>
						<td><?php echo $mostrarX[$i][0] ?></td>
						<td><?php echo $mostrarX[$i][1] ?></td>		
						<td>
							<a href="<?php print get("webURL")._sh.'admin/listaclub/'.$clubes[$ix]['id_club'].'/'.$periodo ?>"><?php echo $clubes[$ix]['nombre_club'] ?></a>
						</td>
						<td><?php print $mostrarX[$i][3] ?></td>
						<td><?php print $mostrarX[$i][4] ?></td>
						<td><?php print $mostrarX[$i][5] ?></td>
					</tr>
					<?php
					
					$i++;
					}
					$ix++;
					}
				?>
					<tr bgcolor="#EEF">
						<td colspan="3"></td>
						<td style="font-size: 15px;"><b><?php print $totalesX[0] ?></b></td>
						<td style="font-size: 15px;"><b><?php print $totalesX[1] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totalesX[2] ?></b></td>
						
					</tr>
				</tbody>
			</table>
			</div>
			<hr>
			-<p>TOTAL DE ALUMNOS LIBERADOS: <span style="font-size: 30px"><?php print  $totalesX[2] + ($tmL+$thL) ?></span></p>-->

		</div>
		<div class="tab-pane" id="grafico">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingOne">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
			          ALUMNOS INSCRITOS / LIBERADOS
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			      <div class="panel-body">
			      	<p>Muestra una comparativa entre los alumnos que se inscribieron en los clubes y aquellos que acreditaron sus horas.</p>
						 <div id="piechart_3d" style="width: 500px; height:430px" ></div>
						 <div id="piechart2_3d" style="width: 500px; height:430px" ></div>
						 <div id="piechart7_3d" style="width: 500px; height:500px" ></div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingTwo">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			        	ALUMNOS SEGÚN SU SEXO
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			      <div class="panel-body">
			      		<p>Muestra una comparativa de la participación de los alumnos según el sexo (hombre/mujer) en los diferentes clubes. Está basado en los alumnos que asistieron a los clubes y acreditaron.</p>
						 <div id="piechart3_3d" style="width: 500px; height:430px" ></div>
						 <div id="piechart4_3d" style="width: 500px; height:500px" ></div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingThree">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			         ALUMNOS SEGÚN SU CARRERA
			        </a>
			      </h4>
			    </div>
			    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			      <div class="panel-body">
			      	<p>En este gráfico se muestra la participación de los alumnos en los diferentes clubes. Está basado en alumnos que asistieron a los clubes y acreditaron.</p>
						 <div id="piechart5_3d" style="width: 500px; height:500px" ></div>
			      </div>
			    </div>
			  </div>
			   <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingFour">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
			         PARTICIPACIÓN CLUBES - OTROS
			        </a>
			      </h4>
			    </div>
			    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
			      <div class="panel-body">
			      		<p>Se muestra la participación que tienen los alumnos en los clubes que oferta el departamento y aquellos alumnos que liberan con otras actividades.</p>
						 <div id="piechart6_3d" style="width: 500px; height:500px" ></div>
			      </div>
			    </div>
			  </div>
			</div>
			<hr>


			
			
			
			 
		</div>

		 <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      google.setOnLoadCallback(drawChart2);
		      google.setOnLoadCallback(drawChart3);
		      google.setOnLoadCallback(drawChart4);
		      google.setOnLoadCallback(drawChart5);
		      google.setOnLoadCallback(drawChart6);
		      google.setOnLoadCallback(drawChart7);
		      
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 
		        		$i =  0;
		        		while( $i < sizeof($mostrar)) {
		        				print "['". $mostrar[$i][2] ."',".$mostrar[$i][5]."],";
		        				$i++;
		        		}

		        	?>
		          
		        ]);

		       var options = {
		          title: 'Alumnos inscritos en clubes',
		          height: 500,
		          width: 800,
		          chartArea:{top: '0px'},
		          is3D: true
		        };


		        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
		        chart.draw(data, options);
		      }

		      function drawChart2() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 
		        		$i =  0;
		        		while( $i < sizeof($mostrar)) {
		        				print "['". $mostrar[$i][2] ."',".$mostrar[$i][8]."],";
		        				$i++;
		        		}

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Alumnos liberados en clubes',
		          height: 500,
		          width: 800,
		          chartArea:{top: '0px'},
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart2_3d'));
		        chart.draw(data, options);
		      }

		      function drawChart3() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 
		        		$i =  0;
		        		while( $i < sizeof($mostrar)) {
		        				print "['". $mostrar[$i][2] ."',".$mostrar[$i][3]."],";
		        				$i++;
		        		}

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Total de mujeres en clubes',
		          height: 500,
		          width: 800,
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart3_3d'));
		        chart.draw(data, options);
		      }

		      function drawChart4() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 
		        		$i =  0;
		        		while( $i < sizeof($mostrar)) {
		        				print "['". $mostrar[$i][2] ."',".$mostrar[$i][4]."],";
		        				$i++;
		        		}

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Total de hombres en clubes',
		          height: 500,
		          width: 800,
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart4_3d'));
		        chart.draw(data, options);
		      }

		       function drawChart5() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 
		        		$i =  0;
		        		while( $i < sizeof($dg)) {
		        				print "['". $dg[$i][0] ."',".$dg[$i][6]."],";
		        				$i++;
		        		}

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Participación de alumnos por carrera',
		          height: 500,
		          width: 800,
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart5_3d'));
		        chart.draw(data, options);
		      }

		       function drawChart6() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 

		        				print "['PARTICIPACIÓN EN CLUBES',".$totales[5]."],";
		        				print "['OTROS',".$totalesX[2]."]";
		        				
		        		

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Participación CLUBES - OTROS',
		          height: 500,
		          width: 800,
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart6_3d'));
		        chart.draw(data, options);
		      }

		       function drawChart7() {
		        var data = google.visualization.arrayToDataTable([
		        	['Clubes', 'Alumnos'],
		        	<?php 

		        				print "['ACREDITADOS',".$totales[5]."],";
		        				print "['NO ACREDITADOS',".($totales[2] - $totales[5])."]";
		        				
		        		

		        	?>
		          
		        ]);

		        var options = {
		          title: 'Porcentaje de participación',
		          height: 500,
		          width: 800,
		          is3D: true
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart7_3d'));
		        chart.draw(data, options);
		      }

		      

		 </script>


	</div>
		<div style="clear: both"></div>
	<p>&nbsp;</p>	

	<legend><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;  <strong>Últimos alumnos inscritos en el periodo <?php print periodo_actual() ?></strong></legend>
	<table class="table table-hover" style="font-size: 12px">
		<tr>
			<td><strong>Folio</strong></td>
			<td><strong>Fecha insc.</strong></td>
			<td><strong>Disp.</strong> </td>
			<td><strong>Nombre</strong></td>
			<td><strong>Club</strong></td>
			<td><strong>Carrera</strong></td>
			<td align="center"><strong>Sem</strong></td>
		</tr>
		<?php
		if($ultimosinscritos)
			foreach ($ultimosinscritos as $ui) {  ?>
				<tr>
					<td><?php print $ui['folio'] ?></td>
					<td><?php print convertirFecha($ui['fecha_inscripcion_club']) ?></td>
					<td>
						<?php if(strcmp($ui['dispositivo'], '2')==0 ) { ?>
						<span class="glyphicon glyphicon-phone"></span>
						<?php }else{ ?>
						<span class="glyphicon glyphicon-globe"></span>
						<?php } ?>
					</td>
					<td><a href="<?php print get("webURL"). "/admin/alumno/".$ui['numero_control'] ?>"> <?php print $ui['apellido_paterno_alumno']." ".$ui['apellido_materno_alumno']." ".$ui['nombre_alumno'] ?></a></td>
					<td><?php print $ui['nombre_club'] ?></td>
					<td><?php print $ui['abreviatura_carrera'] ?></td>
					<td align="center"><?php print $ui['semestre'] ?></td>
				</tr>
<?php
			}
		?>
		
	</table>
<p>&nbsp;</p>	

<p><h3><strong>IMPORTANTE</strong></h3><i>Los datos que aquí se presentan hacen referencia únicamente a los alumnos que se inscribieron a los diferentes clubes deportivos y culturales. También se anexa de manera general los alumnos que acreditan con actividades externas al departamento.</i></p>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="myModalLabel">Descarga ZIP de Cédulas de Inscripción</h4>
      </div>
      <div class="modal-body">
      	<label id="preparando1"></label>
        <div class="clear: both"></div>
        <p>&nbsp;</p>
        <div class="progress">
		  <div id="progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
		    0%
		  </div>
		</div>
      </div>
      <div class="modal-footer">
        <button id="cancelar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="iniciar" onclick="descargarCedulaInscripcion()" type="button" class="btn btn-primary">Iniciar descarga</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModalRes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="myModalLabel">Descarga ZIP de Cédulas de Resultados</h4>
      </div>
      <div class="modal-body">
      	<label id="preparando"></label>
        <div class="clear: both"></div>
        <p>&nbsp;</p>
        <div class="progress">

		  <div id="progressRes" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
		    0%
		  </div>
		</div>
      </div>
      <div class="modal-footer">
        <button id="cancelarRes" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="iniciarRes" onclick="descargarCedulaResultados()" type="button" class="btn btn-primary">Iniciar descarga</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var cbs = [
		<?php 
		foreach ($clubesdescarga as $key) {
			print '"'.$key["id_club"].'",' ;
		}
		?>
		"0"];

	var cbs_nombre = [
		<?php 
		foreach ($clubesdescarga as $key) {
			print '"'.$key["nombre_club"].'",' ;
		}
		?>
		"0"];

	function descargarCedulaInscripcion(){

		$("#iniciar").attr("disabled","disabled");
		$("#cancelar").attr("disabled","disabled");
		
		reiniciar();
		cont = 0;
		recursivo(cont);
	}

	function descargarCedulaResultados(){

		$("#iniciarRes").attr("disabled","disabled");
		$("#cancelarRes").attr("disabled","disabled");
		
		reiniciar();
		cont = 0;
		recursivo_resultado(cont);
	}

	function reiniciar(){
		$.ajax({
			  url: "<?php print get('webURL').'/admin/pdf/formatos/re-temp//' ?>",
		});	
	}


	function recursivo( i ){
		var urlS = "<?php print get('webURL').'/admin/pdf/formatos/zip-ins/"+cbs[i]+"/'.$periodo ?>";
		$.ajax({
			  url: urlS,
			  method: "POST",
			  data: {nombre_club: cbs_nombre[i]},
			  beforeSend: function(  ){
			  	$("#preparando1").html("Preparando cédula de inscripción de " + cbs_nombre[i]);
			  },
			  success: function(data){
			  	    $("#progress").css("width",( parseInt((cont  + 1 ) * 100 / (cbs.length-1))) + "%");
			    	$("#progress").html(  parseInt( (cont  + 1 ) * 100 / (cbs.length-1) )+ "%");
			    	

			    	cont++;
			    	if(cont == cbs.length-1)
			    	{
			    		descargarZIP("zip-ins-desc","CedulasInscripcion");
			    		$('#myModal').modal('hide');
			    		return;
			    	}
			    	recursivo(cont);

			  }
		});
	}

	function recursivo_resultado( i ){
		var urlS = "<?php print get('webURL').'/admin/pdf/formatos/zip-res/"+cbs[i]+"/'.$periodo ?>";
		$.ajax({
			  url: urlS,
			  method: "POST",
			  data: {nombre_club: cbs_nombre[i]},
			  beforeSend: function(  ){
			  	$("#preparando").html("Preparando cédula de resultados de " + cbs_nombre[i]);
			  },
			  success: function(data){
			  	    $("#progressRes").css("width",( parseInt((cont  + 1 ) * 100 / (cbs.length-1))) + "%");
			    	$("#progressRes").html(  parseInt( (cont  + 1 ) * 100 / (cbs.length-1) )+ "%");
			    	
			    	cont++;
			    	if(cont == cbs.length-1)
			    	{
			    		descargarZIP("zip-res-desc","CedulasResultados");
			    		$('#myModalRes').modal('hide');
			    		return;
			    	}
			    	recursivo_resultado(cont);

			  }
		});
	}

	function descargarZIP(uri, name){
		$.ajax({
			  url: "<?php print get('webURL').'/admin/pdf/formatos/"+uri+"/0/'.$periodo ?>",
			  success: function( data ){
			  	window.location.href="<?php print _rs.'/temp/"+name+"_'.$periodo.'.zip' ?>";
			  }
		});	
	}
</script>