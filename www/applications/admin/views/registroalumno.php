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



   $("#registroalumno").validate({
    rules: {
      numero_control: {required:true, minlength: 8, maxlength: 8, digits: true},
      clave: { required:true, minlength: 6, maxlength: 16},
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      se: { required: true, digits: true, maxlength: 1}
    },
    messages: {
      numero_control: { required: "* Este campo es obligatorio", minlength: "Debe tener 8 números", maxlength: "Debe tener 8 números", digits: "Debe introducir solo números" },
      clave: { required: "* Este campo es obligatorio", minlength: "Debe tener 6 caracteres mínimo", maxlength: "Debe tener 16 caracteres máximo" },
      nombre: "* Este campo es obligatorio",
      ap: "* Este campo es obligatorio",
      am: "* Este campo es obligatorio",
      email: { required: "* Este campo es obligatorio", email: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "* Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      se: { required: "* Este campo es obligatorio", digits: "Solo se aceptan números", maxlength: "Ingrese no más de 1 dígito."},
    }
  });
});
</script>

<style type="text/css">
  label.error { color: red; display: inline; margin-left: 10px; font-size: 10px;}
</style>
 <form id="registroalumno" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regisalumno' ?>">
    <fieldset>
      <legend><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<strong>Registro de un nuevo alumno</strong></legend>
       <div class="well">
       <h5>Antes de registrar el alumno debe tomar en cuenta los siguientes aspectos:</h5>
        <ul>
          <li>No debe usarse acentos en el nombre y apellidos del alumno.</li>
          <li>El correo electrónico de un alumno es indispensable.</li>
          <li>La clave hace referencia a la contraseña para entrar el sitio de extraescolares e inscribirse a clubes.</li>
        </ul>
      </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="numero_control">Núm. de control</label>
          <div class="col-sm-2">
    <!-- -->  <input type="text" maxlength="8" name="numero_control" class="form-control" id="numero_control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="nombre">Nombre</label>
          <div class="col-sm-4">
    <!-- -->  <input type="text" name="nombre" class="form-control" id="nombre">
          </div>
          <label class="control-label col-sm-2">Carrera</label>
          <div class="col-sm-4">
      <!-- -->  <select name="carrera" class="form-control" id="carrera">
                  <?php foreach ($carreras as $carrera) { 
                    print '<option value="'.$carrera['id_carrera'].'">'.$carrera['abreviatura_carrera'].' ('.$carrera['plan_estudio'].')</option>';
                  } ?>
  
                </select>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-2 control-label" for="ap">Apellido paterno</label>
          <div class="col-sm-4">
      <!-- -->  <input type="text" name="ap" class="form-control" id="ap">
          </div>
          <label class="control-label col-sm-2">Fecha de nacimiento</label>
          <div class="col-sm-4">
      <!-- -->  <input type="text" name="fecha_nac" class="form-control selectorFecha" placeholder="aaaa/mm/dd" id="fecha_nac">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="am">Apellido materno</label>
          <div class="col-sm-4">
      <!-- -->  <input type="text" name="am" class="form-control" id="am">
          </div>
          <label class="control-label col-sm-2">Sexo</label>
          <div class="col-sm-4">
      <!-- -->  <select name="sexo" class="form-control" id="sexo">
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Correo electrónico</label>
          <div class="col-sm-4">
      <!-- -->  <input type="text" name="email"  class="form-control" id="email">
          </div>
          <label class="control-label col-sm-2" for="se">Situación escolar</label>
          <div class="col-sm-4">
      <!--<  <input type="text" name="se"  class="form-control" id="se">-->
                <select name="se"  class="form-control" id="sexo">
                  <option value="1">ACTIVO</option>
                  <option value="0">INACTIVO</option>
                </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="clave">Clave del sitio</label>
          <div class="col-sm-4">
      <!-- -->  <input type="text" name="clave"  class="form-control" id="clave">
          </div>
          <div class="col-sm-4"></div>
          <div class="col-sm-2">
            <input type="submit" style="width:100%" class="btn btn-success" value="Registrar">  
          </div>
        </div>
      </fieldset>
</form> 