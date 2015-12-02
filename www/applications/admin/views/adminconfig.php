<legend><span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;  <strong>Datos del administrador</strong> 
<?php if(SESSION('id_admin') == $id ) { ?>
  <a rel="tooltip" title="Modificar datos del administrador" data-toggle="modal" href="<?php print get("webURL")."/admin/editadmin" ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Editar</a>
<?php } ?>
</legend>

<?php if(!$datosAdmin) { ?>
<div class="alert alert-block alert-danger fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>Ups no se ha encontrado datos</h3>
  <p>Este error se debe a que el ID del administrador no existe</p>
  
</div>
<?php } else { 
          if ($error == 1) { ?>
<div class="alert alert-block alert-danger fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>No se puede ausentar</h3>
  <p>El sistema necesita por lo menos un administrador activo. Puede solucionar este problema de dos formas:
  <ul>
    <li>Cambie el estado a VIGENTE de un administrador registrado. (debe tener en cuenta que la contraseña y el usuario ya se encuentran registrados en el sistema)</li>
    <li>Registre un nuevo administrador y posteriormente cambie el estado a VIGENTE.</li>
  </ul> 
  
</div>
<?php } ?>


<table class="table table-striped table-condensed">
  <tbody>
    <tr>
      <td width="200" rowspan="11">
        <img width="200" class="img-thumbnail" onerror="this.src='<?php print ($datosAdmin[0]['sexo_admin']==1) ? _rs."/img/default/nofotoh.png" : _rs."/img/default/nofotom.png" ?>'" src="<?php print _rs."/img/administradores/".$datosAdmin[0]['foto_admin'] ?>">
      </td>
      <td width="200"><strong>Usuario</strong></td>
      <td><?php print $datosAdmin[0]['usuario_administrador'];  ?><span class="pull-right label <?php print  ($datosAdmin[0]['actual']==1) ? 'label-success' : 'label-danger' ?>"><?php print  ($datosAdmin[0]['actual']==1) ? 'VIGENTE' : 'NO VIGENTE'  ?></span></td>
    </tr>
    <tr>
      <td width="200"><strong>Contraseña</strong></td>
      <td><label class="label label-warning">No disponible por seguridad</label></td>
    </tr>
    <tr>
      <td><strong>Nombre</strong></td>
      <td><?php print $datosAdmin[0]['nombre_administrador'] ." ". $datosAdmin[0]['apellido_paterno_administrador'] ." ". $datosAdmin[0]['apellido_materno_administrador'] ?></td>
    </tr>
    <tr>
      <td><strong>Sexo</strong></td>
      <td><?php print ($datosAdmin[0]['sexo_admin'] == 1) ? "HOMBRE" : "MUJER"; ?></td>
    </tr>
    <tr>
      <td><strong>Edad</strong></td>
      <td><?php print edad($datosAdmin[0]['fecha_nacimiento_admin'])." años. Su fecha de nacimiento es: ".convertirFecha($datosAdmin[0]['fecha_nacimiento_admin']) ?></td>
    </tr>
    <tr>
      <td><strong>Profesión</strong></td>
      <td><?php print $datosAdmin[0]['profesion_administrador']. " (" . $datosAdmin[0]['abreviatura_profesion'] . ")" ?></td>
    </tr>
    <tr>
      <td><strong>Correo electrónico</strong></td>
      <td><?php print $datosAdmin[0]['correo_electronico'] ?></td>
    </tr>
    <tr>
      <td><strong>Teléfono</strong></td>
      <td><?php print $datosAdmin[0]['telefono_administrador'] ?></td>
    </tr>
    <tr>
      <td><strong>Dirección</strong></td>
      <td><?php print $datosAdmin[0]['direccion_administrador'] ?></td>
    </tr>
    <tr>
      <td><strong>Fecha de registro</strong></td>
      <td><?php print convertirFecha($datosAdmin[0]['fecha_registro']) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;  <strong>Lista de administradores</strong></legend>
<table class="table">
  <thead align="left">
    <th width="10">ID.</th>
    <th width="200">Fecha de registro</th>
    <th>Usuario</th>
    <th>Administrador</th>
    <th align="center" width="100">Estado</th>
  </thead>
  <tbody>
    <?php $cI = 0; foreach ($allAdmin as $ad) { ?>
    <tr>
      <td><?php print $ad['id_administrador'] ?></td>
      <td width="120"><?php print convertirFecha($ad['fecha_registro']) ?></td>
      <td width="200"><?php print $ad['usuario_administrador'] ?></td>
      <td width="470"><a href="<?php print get("webURL")._sh."admin/adminconfig/".$ad['id_administrador'] ?>"><?php print strtoupper($ad['abreviatura_profesion'].'. '.$ad['nombre_administrador'].' '.$ad['apellido_paterno_administrador'].' '.$ad['apellido_materno_administrador']) ?></a></td>
      <td>
        <div class="btn-group">
          <a <?php if($ad['actual'] == 1) print "class='btn btn-success active'"; else print " href='".get('webURL')._sh.'admin/cambiarEstado/1/'.$ad['id_administrador']."' class='btn btn-default'";?>><i class="glyphicon glyphicon-ok"></i></a>
          <a <?php if($ad['actual'] == 0) print "class='btn btn-danger active'"; else print " href='".get('webURL')._sh.'admin/cambiarEstado/0/'.$ad['id_administrador']."' class='btn btn-default'";?>><i class="glyphicon glyphicon-remove"></i></a>
        </div>
      </td>
    </tr>
    <?php $cI++; } ?>
  </tbody>
</table>
