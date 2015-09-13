<legend><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;<strong>Datos del alumno</strong> <a onclick="goBack()" href="#" class="pull-right btn btn-primary btn-sm">
  <i class="glyphicon glyphicon-chevron-left"></i> Regresar
</a> </legend>
<?php 
if(!$alumno){
  ?>
  <div class="alert alert-danger"><h2>Error</h2>El número de control proporcionado no existe en la base de datos. Póngase en contacto con el administrador del sistema.</div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php
  return;
}
?>
<p >En la siguiente tabla se muestra los datos del alumno, el apartado de semestre aparace como NO DISP si el alumno tiene más de 12 semestres.   </span>.</p>
<hr>

<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td width="210" rowspan="9">
          <img onerror="this.src='<?php print ($alumno['sexo']==1) ? _rs."/img/alumnos/nofotoh.png" : _rs."/img/alumnos/nofotom.png" ?>'" class="img-thumbnail" width="200" src="<?php print _rs."/img/alumnos/".$alumno['numero_control'].".jpg" ?>">
        </td>
        <td width="200"><strong>Número de control</strong></td>
        <td colspan="3"><?php print $alumno['numero_control'] ?></td>
      </tr>
      <tr>
        <td><strong>Nombre</td>
        <td colspan="3"><?php print $alumno['apellido_paterno_alumno']." ". $alumno['apellido_materno_alumno'] ." ". $alumno['nombre_alumno'] ?></td>
      </tr>
      <tr>
        <td><strong>Carrera</td>
        <td colspan="3"><?php print $alumno['nombre_carrera'] ?></td>
      </tr>
      <tr>
        <td><strong>Semestre</td>
        <td><?php print (semestre( $alumno['fecha_inscripcion']) > 12) ? '<label class="label label-danger">NO DISP.</label>' : semestre( $alumno['fecha_inscripcion']) ?></td>
       </tr>
      <tr> 
        <td width="200"><strong>Edad</td>
        <td><?php print edad($alumno['fecha_nacimiento']) ." años. Su fecha de nacimiento es ".convertirFecha($alumno['fecha_nacimiento']) ?></td>
      </tr>
      <tr> 
        <td><strong>Sexo</td>
        <td><?php print ($alumno['sexo']==1) ? 'HOMBRE' : 'MUJER' ?></td>
       </tr>
      <tr> 
        <td><strong>Situación escolar (SE)</td>
        <td><?php print ($alumno['situacion_escolar']==1) ? '<label class="label label-success">ACTIVO</label>' : '<label class="label label-danger">INACTIVO</label>' ?></td>
      </tr>
      <tr>
        <td><strong>Correo electrónico</td>
        <td><?php print $alumno['correo_electronico'] ?></td>
       </tr>
      <tr> 
        <td><strong>Clave del sitio</td>
        <td><?php print "******";//$alumno['clave'] ?></td>
      </tr>
  </tbody>
</table>
<div style="clear: both"></div>
<p>&nbsp;</p>

