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
      ocupacion: "required",
      direccion: "required",
      horario: "required",
      lugar: "required"
    },
    messages: {
      user: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      pass: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      nombre: "* Este campo es obligatorio",
      ap: "* Este campo es obligatorio",
      am: "* Este campo es obligatorio",
      email: { required: "* Este campo es obligatorio", email: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "* Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      ocupacion: "* Este campo es obligatorio",
      direccion: "* Este campo es obligatorio",
      horario: "* Este campo es obligatorio",
      lugar: "* Este campo es obligatorio",
      tel: {digits: "Este campo solo admite números", minlength: "El teléfono debe contener de 7 a 10 números", maxlength: "El teléfono debe contener de 7 a 10 números"}

    }
  });
});
</script> 

<style type="text/css">
  label.error { color: red; display: inline; margin-left: 10px;font-size: 10px;}
</style>

 <form id="registropromotor" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regProm' ?>" enctype="multipart/form-data">
    <fieldset>
      <legend><span class="glyphicon glyphicon-user"></span>&nbsp;  Registro de un nuevo promotor</legend>
      <div class="well">
      <h5>Antes de registrar al promotor debe tomar en cuenta los siguientes aspectos:</h5>
        <ul>
          <li>No debe usarse acentos en el nombre y apellidos del promotor.</li>
          <li>El nombre y apellidos debe escribirse con letra mayúscula.</li>
          <li>El correo electrónico del promotor es indispensable.</li>
        </ul>
      </div>
        <hr>
        <div class="form-group">
           <label class="col-sm-3 control-label" for="user">Foto</label>
          <div class="col-sm-3">
    <!-- -->  <input type="file"  name="foto">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="user">Usuario</label>
          <div class="col-sm-3">
    <!-- -->  <input type="text" name="user" class="form-control" id="user">
          </div>
          <label class="col-sm-3 control-label" for="pass">Contraseña</label>
          <div class="col-sm-3">
    <!-- -->  <input type="password" name="pass" class="form-control" id="pass">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="nombre">Nombre</label>
          <div class="col-sm-3">
    <!-- -->  <input type="text" name="nombre" class="form-control" id="nombre">
          </div>
          <label class="col-sm-3 control-label" for="ap">Apellido paterno</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="ap" class="form-control" id="ap">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="am">Apellido materno</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="am" class="form-control" id="am">
          </div>
          <label class="col-sm-3 control-label" for="fecha_nac" >Fecha de nacimiento</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="fecha_nac" class="form-control selectorFecha" placeholder="aaaa/mm/dd" id="fecha_nac" class="form-control selectorfecha">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Sexo</label>
          <div class="col-sm-3" >
      <!-- -->  <select name="sexo" class="form-control" id="sexo" >
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
          </div>
          <label class="col-sm-3 control-label" for="email">Correo electrónico</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="email" class="form-control" id="email">
          </div>
        </div>
        <div class="form-group">
           <label class="col-sm-3 control-label" for="tel">Teléfono</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="tel" class="form-control" id="tel">
          </div>
          <label class="col-sm-3 control-label" for="direccion">Dirección</label>
          <div class="col-sm-3">
      <!-- -->  <textarea name="direccion" id="direccion"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="ocupacion">Ocupación</label>
          <div class="col-sm-3">
      <!-- -->  <input type="text" name="ocupacion" class="form-control" id="ocupacion">
          </div>
          <div class="form-actions">
            <input type="submit" class="btn btn-success span2 pull-center" value="Registrar">  
          </div>

        </div>
      </fieldset>
</form> 