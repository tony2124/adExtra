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
	<div class="col-sm-7"></div>
	<div class="col-sm-2">
		<div class="btn-group" style="width:100%">
	      <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#" style="width:100%">
	        <span  class="glyphicon glyphicon-save"></span>
	        Descarga
	        <span class="caret"></span>
	      </a>
	      <ul class="dropdown-menu">
	        <li><a target="_blank" href="<?php print get("webURL")."/admin/pdf/formatos/zip-ins/0/$periodo"  ?>">ZIP Cédulas de Inscripción</a></li>
	        <li><a href="<?php print get("webURL")."/admin/pdf/formatos/zip-res/0/$periodo"  ?>" target="_blank">ZIP Cédulas de resultados</a></li>
	      </ul>
	    </div>
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
									<a href="<?php print get("webURL")._sh.'admin/listacarrera/'.$carreras[$i]['id_carrera'].'/'.$periodo ?>"><?php echo $carreras[$i]['nombre_carrera'] ?></a>		
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
			 <!-- ****** TABLA OTROS ****** -->
			 <div class="table-responsive">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Tipo</th>
					    <th rowspan="2">Nombre del club</th>
					    <th colspan="3">Alumnos inscritos</th>
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
			<!--<p>TOTAL DE ALUMNOS LIBERADOS: <span style="font-size: 30px"><?php print  $totalesX[2] + ($tmL+$thL) ?></span></p>-->

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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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
		        	['Task', 'Hours per Day'],
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

<hr>

<p><h3><strong>IMPORTANTE</strong></h3><i>Los datos que aquí se presentan hacen referencia únicamente a los alumnos que se inscribieron a los diferentes clubes deportivos y culturales. Los gráficos no incluyen los datos de los alumnos que liberaron en otras actividades.</i></p>
