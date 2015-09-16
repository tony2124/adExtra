<script>
$(document).ready(
    function()
    {
      
    }
  );
</script>

<?php if(isset($success)) { ?>
<div class="well">
<button class="close" data-dismiss="alert">×</button>
  <h3>Registro finalizado</h3>
  <p>Los datos fueron validados y aceptados, el registro se realizó satisfactoriamente.</p>
</div>
<?php } if(isset($regAdminError)) {
  $error = explode(":",$regAdminError); ?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3><?php print $error[0];?></h3>
  <p><?php print $error[1];?></p>
</div>

<?php } ?>

<form class="form-horizontal" accept-charset="UTF-8" method="post" action="<?php print get('webURL')._sh.'admin/regisAdmin';?>" id="registroAdmin">
  <fieldset>
    <legend><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<strong>Registro de nuevo administrador</strong><span class="label label-danger">En construcción</span></legend>
    <div class="well">Completa el formulario para registrar un administrador.</div>
    <hr>
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminUser">Foto</label>
      <div class="col-sm-4">
        <input type="file" name="foto">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminUser">Usuario</label>
      <div class="col-sm-4">
        <input type="text" name="usuario" class="form-control" id="adminUser" required>
      </div>
      <label class="control-label col-sm-2" for="passUno">Contraseña</label>
      <div class="col-sm-4">
        <input type="password" name="passone" class="form-control" id="passUno" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="passDos">Tipo de admin.</label>
      <div class="col-sm-4">
        <!--<input type="password" name="passtwo" class="form-control" id="passDos" required>-->
        <select name="sexo" class="form-control">
          <option value="1">ADMINISTRADOR</option>
          <!--<option value="2">COORDINADOR</option>-->
        </select>
      </div>
      <label class="control-label col-sm-2" for="adminNombre">Nombre</label>
      <div class="col-sm-4">
        <input type="text" name="nombre" class="form-control" id="adminNombre" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminap">Apellido paterno</label>
      <div class="col-sm-4">
        <input type="text" name="apepat" class="form-control" id="adminap" required>
      </div>
      <label class="control-label col-sm-2" for="adminam">Apellido materno</label>
      <div class="col-sm-4">
        <input type="text" name="apemat" class="form-control" id="adminam" required>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminEmail">Sexo</label>
      <div class="col-sm-4">
        <!--<input type="email" name="email" class="form-control" id="adminEmail" required>-->
        <select name="sexo" class="form-control">
          <option value="1">HOMBRE</option>
          <option value="2">MUJER</option>
        </select>
      </div>
      <label class="control-label col-sm-2" for="admindir">Fecha de nac.</label>
      <div class="col-sm-4">
        <input type="text" name="direccion" class="form-control" id="admindir" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminpro">Profesión</label>
      <div class="col-sm-4">
        <input type="text" name="prof" class="form-control" id="adminpro" required>
      </div>
      <label class="control-label col-sm-2" for="adminabr">Abreviatura de la profesión</label>
      <div class="col-sm-4">
        <input type="text" name="abprof" class="form-control" id="adminabr" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminEmail">Correo electrónico</label>
      <div class="col-sm-4">
        <input type="email" name="email" class="form-control" id="adminEmail" required>
      </div>
      <label class="control-label col-sm-2" for="admindir">Dirección</label>
      <div class="col-sm-4">
        <textarea name="direccion" class="form-control" id="admindir"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-4">
        <input type="submit" name="btnSubmit" class="btn btn-primary" id="ejeRegAdmin" value="Registrar Administrador">
      </div>
    </div>
  </fieldset>
</form>
<!--
<?php
if(isset($date))
    print "Fecha del servidor ".$date;
?>-->