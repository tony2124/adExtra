<legend><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;  <strong>Historial de descargas de APP</strong></legend>
<p>En la siguiente tabla se muestra la relación de todos los alumnos que han utilizado la aplicación móvil.</p>
<p>El campo "Activo" se refiere a aquellos alumnos que mantienen una sesión abierta de la aplicación móvil, de tal forma que es posible que recibar las notificaciones como avisos. </p>
<table class="table">
	<thead>
		<th>ID</th>
		<th>Núm. Ctrl.</th>
		<th>Nombre</th>
		<th>Activo</th>
		<th>Fecha</th>
	</thead>
	<?php

foreach ($datos as $data) { ?>
	
	<tr>
		<td><?php print $data['id'] ?></td>
		<td><?php print $data['numero_control'] ?></td>
		<td><a href="<?php print get("webURL"). "/admin/alumno/".$data['numero_control'] ?>"><?php print $data['nombre'] ?></a></td>
		<td><?php print $data['estatus'] ?></td>
		<td><?php print $data['created_at'] ?></td>
	</tr>
<?php 
}

?>
</table>
