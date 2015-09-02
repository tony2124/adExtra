<legend><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Coincidencias</legend>
<?php 
if(!$datos){
  ?>
  <div class="alert alert-danger">No se ha encontrado ningún registro con los datos proporcionados, por favor intente de nuevo con otros datos.</div>
  <?php
  return;
}
if($error){
  ?>
  <div class="alert alert-danger">No se ha introducido ningún dato en el formulario de búsqueda, por favor ingrese un dato para iniciar una búsqueda.</div>
  <?php
  return;
}
//include(_corePath . _sh .'/libraries/funciones/funciones.php'); ?>


<div class="alert alert-info"><strong>La búsqueda se ha realizado mediante la palabra <span class="label label-primary"><?php print $palabra ?></span>. Los resultados encontrados fueron los siguientes:</strong></div>
<p>Registros encontrados: <?php print sizeof($datos) ?></p>
<hr>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>No. de control</th>
      <th>SE</th>
      <th>Nombre</th>
      <th>Carrera</th>
      <th>Semestre</th>
      <th width="15"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($datos as $alumno) { ?>
      <tr>
        <td><?php print $alumno['numero_control']?></td>
        <td><?php print ($alumno['situacion_escolar']==1) ? '<label class="label label-success">Act.</label>' : '<label class="label label-danger">Inact.</label>' ?></td>
        <td><a href="<?php print get('webURL'). _sh . 'admin/alumno/'.$alumno['numero_control'] ?>"><?php print $alumno['apellido_paterno_alumno'].' '.$alumno['apellido_materno_alumno'].' '.$alumno['nombre_alumno'] ?></a></td>
        <td><?php print $alumno['abreviatura_carrera']?></td>
        <td><?php print  (semestre( $alumno['fecha_inscripcion']) > 12) ? '<label class="label label-danger">NO DISP.</label>' : semestre( $alumno['fecha_inscripcion'])  ?></td>
        <td><a href="<?php print get('webURL'). _sh . 'admin/alumno/'.$alumno['numero_control'] ?>" class="btn btn-default btn-xs">ver </a></td>
      </tr>
    <?php } ?>
    
  </tbody>
</table>