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
    });
</script>



<legend><span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;  <strong>Editar datos del administrador</strong> <a onclick="goBack()" href="#" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;&nbsp;Regresar</a></legend>
<p>En el siguiente formulario se muestran los datos del administrador, por favor edite los campos correspondientes y haga clic en guardar cambios.</p>
<p>&nbsp;</p>
<form id="editarAdmin" class="form-horizontal" method="POST" action="<?php print get('webURL')._sh.'admin/editaAdmin' ?>">
    <div class="form-group">
        <label class="control-label col-sm-2" for="input01">Usuario</label>
        <div class="col-sm-4">
            <input type="text" name="usuario" class="form-control" id="input01" value="<?php print $datosAdmin[0]['usuario_administrador'] ?>">
        </div>
        <label class="control-label col-sm-2" for="input02">Contraseña 
            <a rel="popover" data-content="Actual: Ingresa la vieja contraseña <br> Nueva: Ingresa una nueva contraseña <br> Re-nueva: Vuelve a ingresar la nueva contraseña" data-original-title="AYUDA"><i class="glyphicon glyphicon-info-sign"></i></a>
        </label>
        <div class="col-sm-4">
            <input type="password" name="lastpass" class="form-control" id="input02" placeholder="Actual">
        </div>
    </div>

    
    <div class="form-group">
        <label class="control-label col-sm-2" for="input01">Fec. de nac.</label>
        <div class="col-sm-4">
            <input type="text" name="fecha" class="form-control selectorFecha"  value="<?php print $datosAdmin[0]['fecha_nacimiento_admin'] ?>">
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <input type="password" name="newpass1" class="form-control" id="input02" placeholder="Nueva">
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-8">

        </div>
        <div class="col-sm-4">
            <input type="password" name="newpass2" class="form-control" id="input02" placeholder="Re-nueva">
        </div>
    </div>
 <div class="form-group">
        <label class="control-label col-sm-2" for="input03">Nombre(s)</label>
    <div class="col-sm-4">
        <input type="text" name="nombre" class="form-control" id="input03"  value="<?php print $datosAdmin[0]['nombre_administrador'] ?>">
    </div>
    <label class="control-label col-sm-2" for="input04">Apellido paterno</label>
    <div class="col-sm-4">
        <input type="text" required name="adminAP" class="form-control" id="input04"  value="<?php print $datosAdmin[0]['apellido_paterno_administrador'] ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="input04">Apellido materno</label>
    <div class="col-sm-4">
<!-- -->  <input type="text" name="adminAM" class="form-control" id="input04"  value="<?php print $datosAdmin[0]['apellido_materno_administrador'] ?>">
    </div>
    <label class="control-label col-sm-2" for="input06">Correo electrónico</label>
    <div class="col-sm-4">
<!-- -->  <input type="email" name="email" class="form-control" id="input06"  value="<?php print $datosAdmin[0]['correo_electronico'] ?>" required>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="input07">Profesión</label>
    <div class="col-sm-4">
<!-- -->  <input type="text" name="profe" class="form-control" id="input07"  value="<?php print $datosAdmin[0]['profesion_administrador'] ?>">
    </div>
    <label class="control-label col-sm-2" for="input08">Abreviatura de la profesión</label>
    <div class="col-sm-4">
<!-- -->  <input type="text" name="abrevi" class="form-control" id="input08"  value="<?php print $datosAdmin[0]['abreviatura_profesion'] ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="input08">Dirección</label>
    <div class="col-sm-10">
<!-- -->  <textarea type="text" name="direc" class="form-control" id="input09"><?php print $datosAdmin[0]['direccion_administrador'] ?></textarea>
    </div>
   </div>
   <div class="modal-footer">
        <!--<a class="btn btn-default" data-dismiss="modal">Cerrar</a>-->
        <input type="submit" value="Guardar cambios" name="guardarCambios" class="btn btn-primary" id="guardarCambios">
   </div>
</form>