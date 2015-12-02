<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Información del promotor <a style="margin-left: 10px" class="btn btn-primary pull-right btn-sm" href="<?php print get('webURL'). _sh .'admin/formEdicionPromotor/'.$promotor['usuario_promotor']  ?>"><span class="glyphicon glyphicon-pencil"></span> Editar</a><a style="margin-left: 10px" class="btn btn-primary pull-right btn-sm" href="<?php print get('webURL'). _sh .'admin/promotores/'  ?>"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></legend>
<div class="col-sm-8"></div>
<div class="col-sm-2">
  
</div>
<div class="col-sm-2">
  
</div>
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
        <td width="210" rowspan="12">
          <img onerror="this.src='<?php print ($promotor['sexo_promotor']==1) ? _rs."/img/default/nofotoh.png" : _rs."/img/default/nofotom.png" ?>'" class="img-thumbnail" width="200" src="<?php print _rs."/img/promotores/".$promotor['foto_promotor'] ?>">
        </td>
        <td width="200"><strong>Usuario</strong></td>
        <td colspan="3"><?php print $promotor['usuario_promotor'] ?></td>
      </tr>
      <tr>
        <td><strong>Contraseña</td>
        <td colspan="3"><?php print $promotor['contrasena_promotor'] ?></td>
      </tr>
      <tr>
        <td><strong>Nombre</td>
        <td colspan="3"><?php print $promotor['apellido_paterno_promotor']." ". $promotor['apellido_materno_promotor'] ." ". $promotor['nombre_promotor'] ?></td>
      </tr>
       <tr> 
        <td width="200"><strong>Ocupación</td>
        <td><?php print $promotor['ocupacion_promotor'] ?></td>
      </tr>
      <tr> 
        <td width="200"><strong>Edad</td>
        <td><?php print edad($promotor['fecha_nacimiento_promotor']) ." años. Su fecha de nacimiento es: ".convertirFecha($promotor['fecha_nacimiento_promotor']) ?></td>
      </tr>
      <tr> 
        <td><strong>Sexo</td>
        <td><?php print ($promotor['sexo_promotor']==1) ? 'HOMBRE' : 'MUJER' ?></td>
       </tr>
      <tr> 
        <td><strong>Estado</td>
        <td><?php print ($promotor['eliminado_promotor']==0) ? '<label class="label label-success">ACTIVO</label>' : '<label class="label label-danger">INACTIVO</label>' ?></td>
      </tr>
      <tr>
        <td><strong>Correo electrónico</td>
        <td><?php print $promotor['correo_electronico_promotor'] ?></td>
       </tr>
      <tr> 
        <td><strong>Teléfono</td>
        <td><?php print $promotor['telefono_promotor'] ?></td>
      </tr>
      <tr> 
        <td><strong>Dirección</td>
        <td><?php print $promotor['direccion_promotor'] ?></td>
      </tr>
      <tr> 
        <td><strong>Fecha de registro</td>
        <td><?php print convertirFecha($promotor['fecha_registro_promotor']) . ". La última modificación fue el ".convertirFecha($promotor['fecha_modificacion_promotor']) ?></td>
      </tr>
      <!--<tr> 
        <td><strong>Última modificación</td>
        <td><?php print $promotor['fecha_modificacion_promotor'] ?></td>
      </tr>-->
  </tbody>
</table>
<div style="clear: both"></div>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Historial</legend>

<table CLASS="table table-striped table-condensed">
 <thead>
    <tr>
      <th>PERIODO</th>
      <th width="200">NOMBRE DEL CLUB</th>
      <th>LUGAR</th>
      <th>HORA</th>
      <th>INSC.</th>
      <!--<th>LIB.</th>-->
    </tr>
  </thead>
  <tbody>
<?php foreach ($historial as $historia) { ?>
    <tr>
      <td><a href="<?php print get("webURL")."/admin/listaclub/".$historia['idclub']."/".$historia['per'] ?>"> <?php print $historia['per']  ?></a></td>
      <td><?php print $historia['nombre_club'] ?></td>
      <td><?php print $historia['lugar'] ?></td>
      <td><?php print $historia['horario'] ?></td>
      <td><?php print $historia['ins'] ?></td>
    </tr>
<?php } ?>
</table>