<script src="<?php print path("vendors/js/jquery-ui.min.js","zan") ?>"></script>
<link href="<?php print path("vendors/css/frameworks/jquery-ui/jquery-ui.min.css", "zan"); ?>" rel="stylesheet">
<script type="text/javascript">
$().ready(function() {

   $( ".selectorFecha" ).datepicker({  
          defaultDate: "-15y", 
                yearRange: "1900:-15",
        dateFormat: 'yy-mm-dd',  
        showAnim: 'show',
        duration: 'normal',
        changeMonth: true,
                changeYear: true });

   $("#registropromotor").validate({
    rules: {
      user: {required:true, minlength: 6, maxlength: 16},
      pass: {required:true, minlength: 6, maxlength: 16},
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      tel: {digits: true, minlength: 7, maxlength: 10},
      profesion: "required",
      abrev: "required",
      direccion: "required"
      
    },
    messages: {
      user: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      pass: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      nombre: "* Este campo es obligatorio",
      ap: "* Este campo es obligatorio",
      am: "* Este campo es obligatorio",
      email: { required: "* Este campo es obligatorio", email: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "* Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      profesion: "* Este campo es obligatorio",
      direccion: "* Este campo es obligatorio",
      tel: {digits: "Este campo solo admite números", minlength: "El teléfono debe contener de 7 a 10 números", maxlength: "El teléfono debe contener de 7 a 10 números"}

    }
  });
});
</script> 

<?php if(isset($success)) { ?>
<div>
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

<form class="form-horizontal" accept-charset="UTF-8" method="post" action="<?php print get('webURL')._sh.'admin/registrandoAdmin';?>" id="registroAdmin"  enctype="multipart/form-data">
  <fieldset>
    <legend><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<strong>Registro de nuevo administrador</strong></legend>
    <div>Utiliza el siguiente formulario para registrar un administrador. La fotografía debe tener una orientación vertical.</div>
    <hr>
    <div class="form-group">
      <label class="control-label col-sm-2">Foto</label>
      <div class="col-sm-4">
        <input type="file" name="foto">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="adminUser">Usuario</label>
      <div class="col-sm-4">
        <input type="text" name="user" class="form-control" id="user" required>
      </div>
      <label class="control-label col-sm-2">Contraseña</label>
      <div class="col-sm-4">
        <input type="password" name="pass" class="form-control" id="pass" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Tipo de admin.</label>
      <div class="col-sm-4">
        <select name="tipo" class="form-control">
          <option value="1">ADMINISTRADOR</option>
          <!--<option value="2">COORDINADOR</option>-->
        </select>
      </div>
      <label class="control-label col-sm-2">Nombre</label>
      <div class="col-sm-4">
        <input type="text" name="nombre" class="form-control" id="nombre" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Apellido paterno</label>
      <div class="col-sm-4">
        <input type="text" name="ap" class="form-control" id="ap" required>
      </div>
      <label class="control-label col-sm-2" >Apellido materno</label>
      <div class="col-sm-4">
        <input type="text" name="am" class="form-control" id="am" required>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" >Sexo</label>
      <div class="col-sm-4">
        <!--<input type="email" name="email" class="form-control" id="adminEmail" required>-->
        <select name="sexo" class="form-control">
          <option value="1">HOMBRE</option>
          <option value="2">MUJER</option>
        </select>
      </div>
      <label class="control-label col-sm-2" >Fecha de nac.</label>
      <div class="col-sm-4">
        <input type="text" name="fecha_nac" class="form-control selectorFecha" id="fecha_nac" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" >Profesión</label>
      <div class="col-sm-4">
        <input type="text" name="profesion" class="form-control" id="profesion" required>
      </div>
      <label class="control-label col-sm-2">Abreviatura de la profesión</label>
      <div class="col-sm-4">
        <input type="text" name="abrev" class="form-control" id="abrev" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" >Correo electrónico</label>
      <div class="col-sm-4">
        <input type="email" name="email" class="form-control" id="email" required>
      </div>
      <label class="control-label col-sm-2" >Teléfono</label>
      <div class="col-sm-4">
        <input type="number" name="tel" class="form-control" id="tel" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="admindir">Dirección</label>
      <div class="col-sm-4">
        <textarea name="direccion" class="form-control" id="direccion"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <input type="submit" class="btn btn-success pull-right" value="Registrar Administrador">
      </div>
    </div>
  </fieldset>
</form>
<!--
<?php
if(isset($date))
    print "Fecha del servidor ".$date;
?>-->