<button class="btn" onclick="location.href='<?php print get('webURL') . _sh .'admin/generarexcel/'.$period ?>'">Descargar</button>
<select onchange="location.href='<?php print get("webURL").'/admin/excel/' ?>'+$(this).val()">
	<?php 
		$bandera = false;
		foreach ($periodos as $per ) 
		{
			print "<option  id='".$per."' ";
			if(strcmp($per, $period)==0) 
			{ 
					print "selected='selected'"; 
					$bandera=true; 
			}
			?>
			>
			
			<?php print $per . "</option>";
		}

		if($bandera == false)
			print "<option id='".$periodo."' selected='selected'> ".$periodo."</option>";
		
	?>
</select>
<br><br>
<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
	<thead>
     	<tr align="center">
     		<th>ALUMNO</th>
		    <th>N. CONTROL</th>
		    <th>PERIODO</th>
		    <th>SEM</th>
		    <th>CARRERA</th>
		    <th>SEXO</th>
		    <th>ACTIVIDAD</th>
		    <th>FECHA LIB</th>
		    <th>RESULTADO</th>
    	</tr>
    </thead>
    <tbody>
    	<?php
			foreach ($datos as $data) { ?>
    	<tr>
    		<td><?php print $data['apellido_paterno_alumno'] . " " . $data['apellido_materno_alumno'] . " " . $data['nombre_alumno'] ?></td>
    		<td><?php print $data['numero_control'] ?></td>
    		<td><?php print $data['periodo'] ?></td>
    		<td><?php print $data['semestre'] ?></td>
    		<td><?php print $data['abreviatura_carrera'] ?></td>
    		<td><?php print $data['sexo'] ?></td>
    		<td><?php print $data['nombre_club'] ?></td>
    		<td><?php print $data['fecha_liberacion_club'] ?></td>
    		<td><?php print ($data['acreditado'] == '1') ? 'ACREDITADO' : 'NO ACREDITADO' ?></td>
    	</tr>
    	<?php } ?>
    </tbody>
</table>

	
