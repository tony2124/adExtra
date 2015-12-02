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
 <form id="registropromotor" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/editProm/'.$promotor['usuario_promotor'] ?>" enctype="multipart/form-data">
    <fieldset>
      <legend><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edición de promotor<a class="btn btn-primary btn-sm pull-right" onclick="goBack()" href=""><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></legend>
      <div class="well" >
      <h5>Antes de editar al promotor debe tomar en cuenta los siguientes aspectos:</h5>
        <ul>
          <li>No debe usarse acentos en el nombre y apellidos.</li>
          <li>El nombre y apellidos debe escribirse con letra mayúscula.</li>
          <li>El correo electrónico es indispensable.</li>
        </ul>
      </div>
        <hr>
        <div class="control-group">
          <label class="control-label" for="user">Foto</label>
          <div class="form-group">
              <img class="thumbnail col-sm-2" src="<?php print _rs._sh.'img/promotores/'.$promotor['foto_promotor'] ?>" onerror="this.src='<?php print ($promotor['sexo_promotor']==1) ? _rs."/img/default/nofotoh.png" : _rs."/img/default/nofotom.png" ?>'" width="100">
              <div class="col-sm-8">
                <label class="col-sm-12">
                  <input type="checkbox" value="S" name="mantener" checked="checked"> &nbsp;Mantener la foto actual   </label>
                <input type="file" name="foto">
                <input type="hidden" name="fotoactual" value="<?php print $promotor['foto_promotor'] ?>">
                <p>&nbsp;</p>
                <p style="font-style: italic">* Para subir una nueva foto quite la selección de la casilla "mantener foto actual" y seleccione la foto. Nota: Si adjunta una foto nueva la anterior será destruida.</p>
              </div>
               <div class="col-sm-2">
                
              </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="user">Usuario</label>
            <div class="col-sm-4">
               <!-- <span class="input-xlarge uneditable-input"><?php print $promotor['usuario_promotor'] ?></span>-->
                <input type="text" name="usernew" class="form-control" value="<?php print $promotor['usuario_promotor'] ?>">
                <input type="hidden" name="user" value="<?php print $promotor['usuario_promotor'] ?>">
            </div>

            <label class="col-sm-2 control-label" for="pass">Contraseña</label>
            <div class="col-sm-4">
                <input type="password" name="pass" class="form-control" id="pass" value="<?php print $promotor['contrasena_promotor'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="nombre">Nombre</label>
            <div class="col-sm-4">
      <!-- -->  <input type="text" name="nombre" class="form-control" id="nombre" value="<?php print $promotor['nombre_promotor'] ?>">
            </div>
            <label class="col-sm-2 control-label" for="ap">Apellido paterno</label>
            <div class="col-sm-4">
        <!-- -->  <input type="text" name="ap" class="form-control" id="ap" value="<?php print $promotor['apellido_paterno_promotor'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="am">Apellido materno</label>
            <div class="col-sm-4">
        <!-- -->  <input type="text" name="am" class="form-control" id="am" value="<?php print $promotor['apellido_materno_promotor'] ?>">
            </div>
            <label class="col-sm-2 control-label" for="fecha_nac" >Fecha de nacimiento</label>
            <div class="col-sm-4">
        <!-- -->  <input type="text" name="fecha_nac" class="selectorFecha form-control" placeholder="aaaa/mm/dd" id="fecha_nac" class="input-xlarge selectorfecha" value="<?php print $promotor['fecha_nacimiento_promotor'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Sexo</label>
            <div class="col-sm-4">
        <!-- -->  <select class="form-control" name="sexo" id="sexo">
                    <option <?php if(strcmp($promotor['sexo_promotor'],'1') == 0) print 'selected="selected"' ?> value="1">HOMBRE</option>
                    <option <?php if(strcmp($promotor['sexo_promotor'],'2') == 0) print 'selected="selected"' ?> value="2">MUJER</option>
                  </select>
            </div>
            <label class="col-sm-2 control-label" for="email">Correo electrónico</label>
            <div class="col-sm-4">
        <!-- -->  <input type="text" name="email" class="form-control" id="email" value="<?php print $promotor['correo_electronico_promotor'] ?>">
            </div>
          </div>
          <div class="form-group">
             <label class="col-sm-2 control-label" for="tel">Teléfono</label>
            <div class="col-sm-4">
        <!-- -->  <input type="text" name="tel" class="form-control" id="tel" value="<?php print $promotor['telefono_promotor'] ?>">
            </div>
             <label class="col-sm-2 control-label" for="ocupacion">Ocupación</label>
              <div class="col-sm-4">
                <input type="text" name="ocupacion" class="form-control" id="ocupacion" value="<?php print $promotor['ocupacion_promotor'] ?>">
              </div>
           
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="direccion">Dirección</label>
            <div class="col-sm-6">
        <!-- -->  <textarea class="form-control" name="direccion" id="direccion"><?php print $promotor['direccion_promotor'] ?></textarea>
            </div>
             <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <input type="submit" style="width: 100%" class="btn btn-success span2 pull-center" value="Guardar">  
            </div>
          </div>
        </div>
      </fieldset>
</form> 