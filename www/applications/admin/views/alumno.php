<legend><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;<strong>Datos del alumno</strong> <a title="Modificar datos del alumno" data-toggle="modal" data-target="#miModal" href="#" class="pull-right btn btn-primary btn-sm">
  <i class="glyphicon glyphicon-pencil"></i> Editar
</a> </legend>
<p >En la siguiente tabla se muestra los datos del alumno, el apartado de semestre aparace como NO DISP si el alumno tiene más de 12 semestres. Haga clic en editar si desea realizar alguna modificación.  </span>.</p>
<hr>
<?php 
if(!$alumno){
  ?>
  <div class="alert alert-danger"><h2>Error</h2>No se ha detectado el número de control de un alumno, por favor introdusca un número de contol para encontrar resultados.</div>
  <?php
  return;
}
?>
<script>
  function modAcreditacion(periodo, actividad, acred, folio)
  {
       $('#periodo').html(periodo); 
       $('#actividad').html(actividad);
       $('#obs').val('');
       $('#folio').val(folio);
       if(acred=='1')
          $("#selectRes > option[value='1']").attr("selected","selected");
       else $("#selectRes > option[value='0']").attr("selected","selected");
  }

function modActividad(periodo, folio)
  {
       $('#periodoAct').html(periodo); 
       $('#folioAct').val(folio);
  }

  function updateDataInsForm(semestre, periodo)
  {
     $('#periodoIns').val(periodo);
     $('#semestre').val(semestre);
     $('#obsIns').val('');
  }


$().ready(function() {

   $("#editalumno").validate({
    rules: {
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      se: { required: true, digits: true, maxlength: 1},
      clave: { minlength: 6, maxlength: 15}
    },
    messages: {
      nombre: "Este campo es obligatorio",
      ap: "Este campo es obligatorio",
      am: "Este campo es obligatorio",
      email: { required: "Este campo es obligatorio", minlength: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      se: { required: "Este campo es obligatorio", digits: "Solo se aceptan números", maxlength: "Ingrese no más de 1 dígito."},
      clave: { minlength: "Ingrese más caracteres", maxlength: "Ingrese menos caracteres"}

    }
  });

   $("[rel=tooltip]").tooltip();
     $("[rel=popover]").popover();
  // propose username by combining first- and lastname
 
});

</script>

<script>
function folio(folio)
{
   $('#folioElim').val(folio);
}
</script>

<style type="text/css">
  label.error { color: red;}
</style>

<!--<div class="well"><h4>A continuación se muestra los datos del alumno seleccionado.</h4></div>-->

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
        <td colspan="3"><?php print $alumno['nombre_carrera']." (".$alumno['plan_estudio'].")" ?></td>
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
        <td><?php print $alumno['clave'] ?></td>
      </tr>
  </tbody>
</table>
<div style="clear: both"></div>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;<strong>Historial de participación</strong></legend>
<p>A continuación se muestran los clubes y actividades en las que ha particpado <span class="label label-primary"><?php print $nombreAlumno ?> </span>.</p>
<hr><!--
<?php // if($inscripciones == NULL) { ?>
 <div class="alert"><h2>Advertencia</h2>Este alumno no se ha inscrito en ninguna actividad.</div>
<?php //}else{ ?> -->
<div class="tabbable tabs-left"> 
  <ul class="nav nav-tabs">
    <?php $i=0; 
    foreach ($periodos as $periodo) 
    { 
        $liberado = false;
        if($inscripciones!=NULL)
        foreach ($inscripciones as $ins) 
        {
          if($ins['periodo'] == $periodo && $ins['acreditado'] == 1)
          {
              $liberado = true; break;
          }
            
        }
      ?>
    <li class="<?php print ($i==sizeof($periodos) - 1) ? 'active' : NULL; $i++; ?>">
      <a href="#tab<?php print $i ?>" data-toggle="tab">
        <span class="label label-<?php print ($liberado) ? 'success' : 'danger' ?>"><?php print $periodo ?></span>
      </a>
    </li>
    <?php 
  } ?>
  </ul>
  
  <div class="tab-content">
    <?php $i=0; foreach ($periodos as $periodo) 
    { ?>
    
    <div class="tab-pane <?php print ($i==sizeof($periodos) - 1) ? 'active' : NULL; $i++; ?>" id="tab<?php print $i ?>">
      <table class="table table-striped table-condensed">
        <thead>
        <th>Folio</th>
        <th>fecha insc.</th>
        <th>fecha lib.</th>
        <th>Actividad</th>
        <th>Resultado</th>
        <th>Obser.</th>
        <th></th></thead>
        <tbody>
            <?php
            $band = false;
            if($inscripciones!=NULL)
            foreach ($inscripciones as $ins) 
            {
              if($ins['periodo'] == $periodo)
              { 
                $band = true;
                ?>
              <tr>
                <td><?php print $ins['folio'] ?></td>
                <td><?php print convertirFecha($ins['fecha_inscripcion_club']) ?></td>
                <td><?php print convertirFecha($ins['fecha_liberacion_club']) ?></td>
                <td>
                  <a data-toggle="modal" onclick="modActividad(<?php print "'".$periodo."','".$ins['folio']."'" ?>)" href="#cambiarActividad">
                    <?php print $ins['nombre_club'] ?>
                  </a>
                  </td>
                <td>
                  <a data-toggle="modal" onclick="modAcreditacion(<?php print "'".$periodo."','".$ins['nombre_club']."','".$ins['acreditado']."','".$ins['folio']."'" ?>)" href="#cambiarAcreditado">
                    <?php print ($ins['acreditado']==1) ? 'ACREDITADO' : 'NO ACREDITADO' ?>
                  </a>
                </td>
                <td>
                  <?php if($ins['observaciones']!=NULL) { ?>
                  <button class="btn btn-default btn-xs" rel="popover" data-content="<?php print $ins['observaciones'] ?>" data-original-title="Observación">ver</button><?php } ?></td>
                <td>
                  <a style="margin-left: 10px" title="Eliminar" data-toggle="modal" href="#confirmModal" rel="tooltip" href="#" class="btn btn-danger btn-xs pull-right" onclick="folio('<?php print $ins['folio'] ?>')"><span class="glyphicon glyphicon-remove"></span></a>
                  <a  href="<?php print get('webURL')._sh.'admin/pdf/formatos/liberacion/'.$ins['folio'] ?>" target="_blank" title="Descargar boleta de acreditación" rel="tooltip" class="btn btn-success btn-xs pull-right"><span class="glyphicon glyphicon-download-alt"></span> </a>
                  
                </td>
              </tr>
                <?php
              }
              
            }
            if(!$band) 
              print '<tr><td colspan="6"><div class="alert alert-danger">No se encuentra inscrito en ningún club ó actividad</div></td></tr>';
            ?>
            <tr>
              <td colspan="7">
                <a rel="tooltip" title="Inscribir a una actividad" onclick="updateDataInsForm(<?php print $i.",'".$periodo."'" ?>)" class="pull-right btn btn-success" data-toggle="modal" data-target="#insActDialog" href="#" >
                  <i class="glyphicon glyphicon-plus"></i> Inscribir actividad
                </a>
              </td>
            </tr>
        </tbody>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  
    <?php } ?>
  </div>
</div>

<!-- DIALOGO PARA CAMBIAR ACTIVIDAD -->
<div class="modal fade" id="cambiarActividad">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edición de actividad </h3>
      </div>
      <div class="modal-body">
        <p>En el siguiente formulario se cambiará la actividad.</p>
       
        <form id="editAct" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/editActividad' ?>">
        <div class="form-group">
          <label class="control-label col-sm-2">Actividad</label> 
          <div class="col-sm-9">
                <select class="form-control" name="actividad">
                  <?php foreach ($clubes as $club) { ?>
                    <option value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
                  <?php } ?>
                </select> 
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Periodo</label> 
          <div class="col-sm-9">
              <label id="periodoAct" ></label>
          </div>
          <input type="hidden" value="" id="folioAct" name="folio">
          <input type="hidden" value="<?php print $alumno['numero_control'] ?>" name="nc">
        </div>
    </form> 
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <a href="#" class="btn btn-primary" onclick="$('#editAct').submit()">Guardar cambios</a>
      </div>
    </div>
  </div>
</div>

<!-- DIALOGO PARA CAMBIAR ACREDITACION -->
<div class="modal fade" id="cambiarAcreditado">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edición de acreditación </h3>
      </div>
      <div class="modal-body">
        <p>En el siguiente formulario se cambiará la acreditación.</p>
       
        <form id="editres" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/editResultado' ?>">
        <div class="form-group">
            <label class="control-label col-sm-2">Actividad</label> 
          <div class="col-sm-9">
                <span id="actividad" type="text" class="uneditable-input"></span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Periodo</label> 
          <div class="col-sm-9">
              <span id="periodo" type="text" class="uneditable-input"></span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Resultado</label> 
          <div class="col-sm-9">
              <select class="form-control" name="acreditado" id="selectRes">
                  <option value="1">ACREDITADO</option>
                  <option value="0">NO ACREDITADO</option>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Observación</label> 
          <div class="col-sm-9">
              <textarea class="form-control" name="obs" id="obs"></textarea>
          </div>
          <input type="hidden" value="" id ="folio" name="folio">
          <input type="hidden" value="<?php print $alumno['numero_control'] ?>" name="numero_control">
        </div>
    </form> 
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <a href="#" class="btn btn-primary" onclick="$('#editres').submit()">Guardar cambios</a>
      </div>
    </div>
  </div>
</div>

<!-- DIALOGO PARA INSCRIBIR A UNA ACTIVIDAD -->

<div class="modal fade" id="insActDialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Inscripción a una actividad</h3>
      </div>
      <div class="modal-body">
        <p>Complete el siguiente formulario para inscribir a este alumno a una actividad.</p>
       
        <form id="insActForm" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/inscipcionActividad' ?>">
        <div class="form-group">
          <label class="control-label col-sm-2">Actividad</label> 
          <div class="col-sm-9">
                 <select class="form-control" name="actividad">
                    <?php foreach ($clubes as $club) { if($club['tipo_club'] != 1 && $club['tipo_club'] != 2) { ?>
                    <option value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
                  <?php } } ?>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Resultado</label> 
          <div class="col-sm-9">
              <select class="form-control" name="acreditado" id="selectRes">
                  <option value="1">ACREDITADO</option>
                  <option value="0">NO ACREDITADO</option>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Observación</label> 
          <div class="col-sm-9">
              <textarea class="form-control"  name="obsIns" id="obsIns"></textarea>
          </div>
          <input type="hidden" value="" id ="periodoIns" name="periodo">
          <input type="hidden" value="" id ="semestre" name="semestre">
          <input type="hidden" value="<?php print $alumno['numero_control'] ?>" name="numero_control">
        </div>
    </form> 
      </div>
      <div class="modal-footer">
       <a href="#" class="btn btn-default" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <a href="#" class="btn btn-primary" onclick="$('#insActForm').submit()">Guardar cambios</a>
      </div>
    </div>
  </div>
</div>

<!-- DIALOGO PARA EDITAR ALUMNOS -->
<div class="modal fade" id="miModal" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edición de datos del alumno&nbsp;&nbsp;&nbsp;&nbsp;<a rel="tooltip" title="Actualizar" href="<?php print get('webURL'). _sh . 'admin/alumno/'.$alumno['numero_control'] ?>">
            <i class="icon-refresh"></i>
          </a>
        </h3>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <!--<p>En el siguiente formulario se muestran los datos del alumno, por favor edite el campo correspondiente y haga clic en guardar cambios.</p>-->
          <form id="editalumno" method="POST" action="<?php print get('webURL')._sh.'admin/editalumno/' ?>">
            <div class="form-group">
              <label class="control-label col-sm-4" >Número de control</label>
              <div class="col-sm-8">
          <!-- -->  <input type="num" minlength="8" maxlenght="8" name="numero_control" class="form-control" id="numero_control" value="<?php print $alumno['numero_control'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="nombre">Nombre</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="nombre" class="form-control" id="nombre" value="<?php print $alumno['nombre_alumno'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="ap">Apellido paterno</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="ap" class="form-control" id="ap" value="<?php print $alumno['apellido_paterno_alumno'] ?>">
              </div>
            </div>
           
            <div class="form-group">
              <label class="control-label col-sm-4" for="am">Apellido materno</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="am" class="form-control" id="am"  value="<?php print $alumno['apellido_materno_alumno'] ?>">
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-4" >Carrera</label>
              <div class="col-sm-8">
          <!--   <input type="text" name="ap" class="form-control" id="ap" value="<?php print $alumno['apellido_paterno_alumno'] ?>"> -->
                   <select name="carrera" class="form-control">
                    <?php foreach ($carreras as $car) { ?>
                      <option <?php if($alumno['id_carrera'] == $car['id_carrera']) print "selected='selected'" ?> value="<?php print $car['id_carrera']  ?>"><?php print $car['abreviatura_carrera']." (".$car['plan_estudio'].")" ?></option>
                    <?php } ?>  
                    </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="fecha_nac">Fecha de nacimiento</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="fecha_nac" class="form-control" id="fecha_nac"  value="<?php print $alumno['fecha_nacimiento'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="sexo">Sexo</label>
              <div class="col-sm-8">
          <!-- -->  <select name="sexo" id="sexo" class="form-control">
                      <option value="1">HOMBRE</option>
                      <option value="2" <?php if($alumno['sexo']!=1) print 'selected="selected"' ?>>MUJER</option>
                    </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="email">Correo electrónico</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="email" class="form-control" id="email"  value="<?php print $alumno['correo_electronico'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="se">Situación escolar</label>
              <div class="col-sm-8">
                <select name="se" id="se" class="form-control">
                      <option value="1">ACTIVO</option>
                      <option value="2" <?php if($alumno['situacion_escolar']!=1) print 'selected="selected"' ?>>INACTIVO</option>
                </select>
          <!-- -  <input type="text" name="se" class="form-control" id="se"  value="<?php print $alumno['situacion_escolar'] ?>">-->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="clave">Clave del sitio</label>
              <div class="col-sm-8">
          <!-- -->  <input type="text" name="clave" class="form-control" id="clave"  value="<?php print $alumno['clave'] ?>">
              </div>
              <input type="hidden" name="numero_control_ant" value="<?php print $alumno['numero_control'] ?>"> 
            </div>
            <div style="clear: both"></div>
            <div class="modal-footer">
             <a href="#" class="btn btn-default" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <button class="btn btn-primary" type="submit">Guardar cambios</button>
            </div>      
          </form> 
        </div>
      </div>

      
    </div>
  </div>
</div>

<!-- DIALOGO PARA CONFIRMACIÓN DE ELIMINACION -->
<div class="modal fade" id="confirmModal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Confirmación</h3>
      </div>
      <div class="modal-body">
        <p>¿Está seguro que desea eliminar esta actividad?</p>
       
        <form id="elimActividad" method="post" action="<?php print get('webURL')._sh.'admin/elimActividad' ?>">
          <input name="folio" id="folioElim" type="hidden" value="">
          <input name="nc" type="hidden" value="<?php print $alumno['numero_control'] ?>">

        </form> 
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
        <a href="#" class="btn btn-danger" onclick="$('#elimActividad').submit()">Eliminar</a>
      </div>
    </div>
  </div>
</div>