<legend><span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;  <strong>Datos del administrador</strong> <a rel="tooltip" title="Modificar datos del administrador" data-toggle="modal" href="<?php print get("webURL")."/admin/editadmin" ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Editar</a></legend>

<?php if(!$datosAdmin) { ?>
<div class="alert alert-block alert-danger fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>Ups no se ha encontrado datos</h3>
  <p>Este error se debe a que el ID del administrador no existe</p>
  
</div>
<?php } else 
{ if (isset($errorEstado) && $errorEstado == true) { ?>
<div class="alert alert-block alert-danger fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>No se puede ausentar</h3>
  <p>Por lo menos debe de estar un administrador activo, asigna vigente a otro administrador y podrá ausentarse</p>
  
</div>
<?php } if(isset($adminUpdate)) { $textos = explode(":",$adminUpdate);?>
<div class="alert alert-block alert-danger fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3><?php print $textos[0];?></h3>
  <p><?php print $textos[1];?></p>
</div>
<?php } ?>


<table class="table table-striped table-condensed">
  <!-- <thead>
    <th>Descripción</th>
    <th>Valor asociado</th>
  </thead> -->
  <tbody>

    <tr>
      <td width="200" rowspan="10">
        <img width="200" class="img-thumbnail" src="<?php print _rs."/img/administradores/".$datosAdmin[0]['foto_admin'] ?>">
      </td>
      <td width="200"><strong>Usuario</strong></td>
      <td><?php print $datosAdmin[0]['usuario_administrador'] ?></td>
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
      <td><strong>Edad</strong></td>
      <td><?php print edad($datosAdmin[0]['fecha_nacimiento_admin'])." años. Su fecha de nacimiento es: ".convertirFecha($datosAdmin[0]['fecha_nacimiento_admin']) ?></td>
    </tr>
    <tr>
      <td><strong>Profesión</strong></td>
      <td><?php print $datosAdmin[0]['profesion_administrador'] ?></td>
    </tr>
    <tr>
      <td><strong>Abreviatura de la profesión</strong></td>
      <td><?php print $datosAdmin[0]['abreviatura_profesion'] ?></td>
    </tr>
    <tr>
      <td><strong>Correo electrónico</strong></td>
      <td><?php print $datosAdmin[0]['correo_electronico'] ?></td>
    </tr>
    <tr>
      <td><strong>Dirección</strong></td>
      <td><?php print $datosAdmin[0]['direccion_administrador'] ?></td>
    </tr>
    <tr>
      <td><strong>Fecha de registro</strong></td>
      <td><?php print convertirFecha($datosAdmin[0]['fecha_registro']) ?></td>
    </tr>
    <tr>
      <td><strong>Estado</strong></td>
      <td><span class="label <?php print  ($datosAdmin[0]['actual']==1) ? 'label-success' : 'label-danger' ?>"><?php print  ($datosAdmin[0]['actual']==1) ? 'VIGENTE' : 'NO VIGENTE'  ?></span>
        <?php if($datosAdmin[0]['actual']==1) { ?> 
          <a href="<?php print get('webURL')._sh.'admin/cambiarEstado/noVigente'?>" class="btn btn-danger btn-xs pull-right" rel="popover" data-content="Cambia el estado de este administrador a NO VIGENTE" data-original-title="CAMBIAR A NO VIGENTE"><i class="glyphicon glyphicon-remove"></i></a>
        <?php }else{ ?>
          <a href="<?php print get('webURL')._sh.'admin/cambiarEstado/Vigente'?>" class="btn btn-success btn-xs pull-right" rel="popover" data-content="Cambia el estado de este administrador a VIGENTE" data-original-title="CAMBIAR A VIGENTE"><i class="glyphicon glyphicon-ok"></i></a>
        <?php } ?>
      </td>
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
    <th width="200">Fecha de registro</th>
    <th>Usuario</th>
    <th>Administrador</th>
    <th align="center" width="100">Estado</th>
  </thead>
  <tbody>
    <?php $cI = 0; foreach ($allAdmin as $ad) { ?>
    <tr>
      <td width="120"><?php print convertirFecha($ad['fecha_registro']) ?></td>
      <td width="200"><?php print $ad['usuario_administrador'] ?></td>
      <td width="470"><a href=""><?php print strtoupper($ad['abreviatura_profesion'].'. '.$ad['nombre_administrador'].' '.$ad['apellido_paterno_administrador'].' '.$ad['apellido_materno_administrador']) ?></a></td>
      <td>
        <div class="btn-group">
          <a <?php if($ad['actual'] == 1) print "class='btn btn-success active'"; else print " href='".get('webURL')._sh.'admin/cambiarEstado/Vigente/'.$ad['usuario_administrador']."' class='btn btn-default'";?>><i class="glyphicon glyphicon-ok"></i></a>
          <a <?php if($ad['actual'] == 0) print "class='btn btn-danger active'"; else print " href='".get('webURL')._sh.'admin/cambiarEstado/noVigente/'.$ad['usuario_administrador']."' class='btn btn-default'";?>><i class="glyphicon glyphicon-remove"></i></a>
        </div>
      </td>
    </tr>
    <?php $cI++; } ?>
  </tbody>
</table>

<div class="modal fade" id="modalEditarAdmin">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edición de datos del administrador</h3>
      </div>
      <div class="modal-body">
        <p>En el siguiente formulario se muestran los datos del administrador, por favor edite los campos correspondientes y haga clic en guardar cambios.</p>
        <form id="editarAdmin" class="form-horizontal" method="POST" action="<?php print get('webURL')._sh.'admin/editaAdmin' ?>">
          <div class="control-group">
            <label class="control-label" for="input01">Usuario</label>
            <div class="controls">
        <!-- -->  <input type="text" name="usuario" disabled class="input-xlarge" id="input01" value="<?php print $datosAdmin[0]['usuario_administrador'] ?>">
            </div><br>
            <label class="control-label" for="input02">Contraseña <a rel="popover" data-content="Actual: Ingresa la vieja contraseña <br> Nueva: Ingresa una nueva contraseña <br> Re-nueva: Vuelve a ingresar la nueva contraseña" data-original-title="AYUDA"><i class="icon-exclamation-sign"></i></a></label>
            <div class="controls">
        <!-- -->  <input type="password" name="lastpass" class="input-xlarge" id="input02" placeholder="Actual">
            </div>
            <div class="controls">
        <!-- -->  <input type="password" name="newpass1" class="input-xlarge" id="input02" placeholder="Nueva">
            </div>
            <div class="controls">
        <!-- -->  <input type="password" name="newpass2" class="input-xlarge" id="input02" placeholder="Re-nueva">
            </div><hr>
            <label class="control-label" for="input03">Nombre(s)</label>
            <div class="controls">
        <!-- -->  <input type="text" name="nombre" class="input-xlarge" id="input03"  value="<?php print $datosAdmin[0]['nombre_administrador'] ?>">
            </div><br>
            <label class="control-label" for="input04">Apellido paterno</label>
            <div class="controls">
        <!-- -->  <input type="text" required name="adminAP" class="input-xlarge" id="input04"  value="<?php print $datosAdmin[0]['apellido_paterno_administrador'] ?>">
            </div><br>
            <label class="control-label" for="input04">Apellido materno</label>
            <div class="controls">
        <!-- -->  <input type="text" name="adminAM" class="input-xlarge" id="input04"  value="<?php print $datosAdmin[0]['apellido_materno_administrador'] ?>">
            </div><br>
            <label class="control-label" for="input06">Correo electrónico</label>
            <div class="controls">
        <!-- -->  <input type="email" name="email" class="input-xlarge" id="input06"  value="<?php print $datosAdmin[0]['correo_electronico'] ?>" required>
            </div><hr>
            <label class="control-label" for="input07">Profesión</label>
            <div class="controls">
        <!-- -->  <input type="text" name="profe" class="input-xlarge" id="input07"  value="<?php print $datosAdmin[0]['profesion_administrador'] ?>">
            </div><br>
            <label class="control-label" for="input08">Abreviatura de la profesión</label>
            <div class="controls">
        <!-- -->  <input type="text" name="abrevi" class="input-xlarge" id="input08"  value="<?php print $datosAdmin[0]['abreviatura_profesion'] ?>">
            </div><br>
            <label class="control-label" for="input08">Dirección</label>
            <div class="controls">
        <!-- -->  <input type="text" name="direc" class="input-xlarge" id="input09"  value="<?php print $datosAdmin[0]['direccion_administrador'] ?>">
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <a class="btn btn-default" data-dismiss="modal">Cerrar</a>
          <input type="submit" value="Guardar cambios" name="guardarCambios" class="btn btn-primary" id="guardarCambios">
        </form>
      </div>
    </div>
  </div>
</div>