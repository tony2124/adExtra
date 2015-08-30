<script>
function promotor(usuario, name)
{
   $('#nombre_promotor').html(name);
   $('#usuario_promotor').val(usuario);
}

function guardar(posicion)
{
    var request = $.ajax({
      type: "POST",
      url: "<?php print get('webURL')._sh.'admin/guardarHorario/'.$periodo ?>",
      data: { club: $('#club'+posicion).val(), promotor: $('#promotor'+posicion).val(), lugar : $('#lugar'+posicion).val(), horario: $('#horario'+posicion).val() }
      });

    request.done(function( msg ) {
      alert( "El registro ha sido actualizado: " );
    });

    request.fail(function(jqXHR, textStatus) {
     alert( "Error al actualizar datos: " + textStatus );
    });
}



</script>



<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Horarios</legend>
<!--
<div class="well">
  <p>Para el mejor funcionamiento del sistema considere las siguientes recomendaciones:</p>
  <ul>
    <li>No tenga activo a más de un promotor en un club, dé primero de baja el actual y después inscriba al nuevo promotor.</li>
    <li>El usuario y contraseña que estén asignadas son las que utilizará el promotor para iniciar sesión en su apartado: <a href="http://serviciosextraescolares.itsapatzingan.net/loginAdministrador/adExtra/promotor">http://serviciosextraescolares.itsapatzingan.net/loginAdministrador/adExtra/promotor</a></li>
  </ul>
</div>
--> 
  <p class="label label-primary">SELECCIONA UN PERIODO: </p>
<div class="form-group">
  <div class="col-sm-3">
    <select class="form-control" onchange="location.href='<?php print get("webURL").'/admin/formHorarios/' ?>'+$(this).val()">
      <?php 
        $bandera = false;
        foreach ($periodos as $per ) 
        {
          print "<option  id='".$per."' ";
          if(strcmp($per,$periodo)==0) 
          { 
              print "selected='selected'"; 
              $bandera=true; 
          }
          ?>
          >
          
          <?php print $per . "</option>";
        }

        if($bandera == false)
          print "<option id='".$periodo."' selected='selected'> ".$periodo."</option>";
        
      ?>
    </select>
  </div>
  <div class="col-sm-7"></div>
  <div class="col-sm-2">
    <div class="btn-group" style="width:100%">
      <a class="btn dropdown-toggle btn-success" data-toggle="dropdown" href="#" style="width:100%">
        <span  class="glyphicon glyphicon-cog"></span>
        Operación
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a href="<?php print get("webURL")."/admin/formHorarios/1"  ?>">Usar horarios periodo ant.</a></li>
        <li><a href="<?php  ?>" target="_blank">Descargar horario</a></li>
      </ul>
    </div>
  </div>

</div>
<?php if($promotores==NULL) { ?>
<div style="clear: both"></div>
<p>&nbsp;</p>
<div class="alert alert-danger">
  <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
  <p>No se encuentra ningún promotor ASIGNADO en este periodo, 
    por favor asigne los promotores correspondientes a cada club y 
    su horario de participación. Debe tener en cuenta que si es un periodo 
    pasado sólo podrá hacer esta configuración UNA VEZ, es necesario 
    que cuente con el horario correspondiente al periodo.</p>
  
</div>
 <?php } ?>

 <?php if(isset($mostrar_datos)) { ?>
<div style="clear: both"></div>
<p>&nbsp;</p>
<div class="alert alert-warning">
  <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
  <p>Ha sido cargado el horario del periodo anterior, por favor guarde 
    los cambios para cada club. Los cambios se pueden comprobar si se actualiza la página.</p>
</div>
 <?php } ?>
<hr>

<div style="clear: both"></div>
<p>&nbsp;</p>
<table class="table">
  <thead style="background: #eeeeee">
    <td width="150" align="center"><strong> CLUB</strong></td>
    <th width="250">PROMOTOR</th>
    <th>LUGAR</th>
    <th>HORARIO</th>
    <th width="20"></th>
  </thead>
  <tbody>

<?php 
    $cI = 0; 
    foreach ($clubes as $club) {  
      $b = false; ?>
  
        <tr>
            <td align="center">
               <?php print $club['nombre_club'] ?> 
              <input id="club<?php print $cI ?>" type="hidden" value="<?php print $club['id_club'] ?>" />
            </td>

           <?php 
              if($promotores != NULL) 
                  foreach ($promotores as $promotor) 
                      if($club['id_club'] == $promotor['id_club'])
                      {
                        if(strcmp( $periodo , periodo_actual()) == 0)
                        {
                          ?>
                            <td>
                              <select class="form-control" id="promotor<?php print $cI ?>"> 
                                <?php 
                                  foreach ($promotores_actuales as $prom) 
                                    { ?>
                                      <option value="<?php print $prom['usuario_promotor'] ?>"  <?php if(strcmp($prom['usuario_promotor'], $promotor['usuario_promotor']) == 0) print "selected='selected'" ?>>
                                        <?php print strtoupper($prom['nombre_promotor'].' '.$prom['apellido_paterno_promotor'].' '.$prom['apellido_materno_promotor']) ?>
                                      </option>
                                <?php } ?>
                              </select>
                            </td>
                            <td>
                              <textarea class="form-control" id="lugar<?php print $cI ?>"><?php print $promotor['lugar'] ?></textarea>
                            </td>
                            <td>
                              <textarea class="form-control" id="horario<?php print $cI ?>"><?php print $promotor['horario'] ?></textarea>
                            </td>
                            <td>
                              <button id="guardar" class="btn btn-default" onclick="guardar(<?php print $cI ?>)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                              <button class="btn btn-default" data-toggle="collapse" href="#showAdmin_<?php print $cI;?>"><span class="glyphicon glyphicon-chevron-down"></span></button>
                            </td>
                            <?php 
                        }
                        else
                        { ?>

                            <td><?php print strtoupper($promotor['nombre_promotor'].' '.$promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor']) ?></td>
                            <td><?php print $promotor['lugar'] ?></td>
                            <td><?php print $promotor['horario'] ?></td>
                            <td>
                              <button class="btn btn-default" data-toggle="collapse" href="#showAdmin_<?php print $cI;?>"><span class="glyphicon glyphicon-chevron-down"></span></button>
                            </td>
<?php                   }
                        $b = true; 
                        break; 
                      } 

                      if($b == false)
                      {  ?>
                          <td>
                            <select class="form-control" id="promotor<?php print $cI ?>"> 
                              <option>Elige un promotor</option>
                              <?php 
                              foreach ($promotores_actuales as $prom) 
                              { ?>                        
                                      <option value="<?php print $prom['usuario_promotor'] ?>" >
                                        <?php print strtoupper($prom['nombre_promotor'].' '.$prom['apellido_paterno_promotor'].' '.$prom['apellido_materno_promotor']) ?>
                                      </option>
     <?php                     } 
       ?>                   </select>
                          </td>
                          <td><textarea class="form-control" id="lugar<?php print $cI ?>"></textarea></td>
                          <td><textarea class="form-control" id="horario<?php print $cI ?>"></textarea></td>
                          <td><button class="btn btn-default" onclick="guardar(<?php print $cI ?>)"><span class="glyphicon glyphicon-floppy-disk"></span></button></td>
  <?php               }  

?>
          </tr>

          <?php 
          if($b == true)  
            { 

?>
                <tr>
                  <td colspan="5">
                    <div id="showAdmin_<?php print $cI;?>" class="collapse out">

                      <table class="table table-striped table-condensed">
                        <thead>
                          <tr>
                            <th>Foto</th>
                            <th>Datos</th>
                          </tr>
                        </thead>
                        <tbody >
                          <tr>
                            <td width="200" rowspan="12">
                              <img class="img-thumbnail" src="<?php print _rs._sh.'img/promotores/'.$promotor['foto_promotor'] ?>" width="200" >
                            </td>
                          </tr>
                          <tr>
                            <td width="200">USUARIO</td>
                            <td><?php print $promotor['usuario_promotor']?></td>
                          </tr>
                          <tr>
                             <td>NOMBRE</td>
                            <td><a href=""> <?php print $promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'] ?></a></td>
                            </tr>
                          <tr>
                             <td>CLUB</td>
                            <td><?php print $promotor['nombre_club'] ?></td>
                            </tr>
                          <tr>
                             <td>LUGAR Y HORARIO</td>
                            <td><?php print $promotor['lugar']." horario:".$promotor['horario'] ?></td>
                            </tr>
                          <tr>
                             <td>SEXO</td>
                            <td><?php print ($promotor['sexo_promotor'] == 1) ? 'HOMBRE' : 'MUJER' ?></td>
                            </tr>
                          <tr>
                             <td>CORREO ELECTRÓNICO</td>
                            <td><?php print $promotor['correo_electronico_promotor'] ?></td>
                            </tr>
                          <tr>
                             <td>EDAD</td>
                            <td><?php print edad($promotor['fecha_nacimiento_promotor'])." años" ?></td>
                            </tr>
                          <tr>
                             <td>OCUPACIÓN</td>
                            <td><?php print $promotor['ocupacion_promotor']?></td>
                            </tr>
                          <tr>
                             <td>DIRECCIÓN</td>
                            <td><?php print $promotor['direccion_promotor'].' Teléfono: '.$promotor['telefono_promotor'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
                <?php 
                $cI++;
                 } 

                  }
                 ?>
              </tbody>
            </table>
<hr>


<a href="<?php print get('webURL'). _sh . 'admin/formRegistroPromotor' ?>">Agregar un nuevo promotor</a>

<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar a <span class="label label-important" id="nombre_promotor"></span> de la lista de promotores?</p>
   
    <form id="elimPromo" method="post" action="<?php print get('webURL')._sh.'admin/elimPromotor' ?>">
      <input name="usuario_promotor" id="usuario_promotor" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimPromo').submit()">Eliminar</a>
  </div>
</div>

