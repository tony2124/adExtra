<legend><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Horarios <a style="margin-left: 10px" onclick="goBack()" class="btn btn-primary pull-right btn-sm" href="#"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></legend>

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

<div style="clear: both"></div>
<p>&nbsp;</p>
<table class="table table-condensed table-hover">
  <thead style="background: #eeeeee">
    <td width="150" ><strong> CLUB</strong></td>
    <th width="250">PROMOTOR</th>
    <th>LUGAR</th>
    <th>HORARIO</th>
  </thead>
  <tbody>

<?php 
    $cI = 0; 
    foreach ($clubes as $club) {  
      $b = false; ?>
  
        <tr>
            <td >
               <?php print $club['nombre_club'] ?> 
              <input id="club<?php print $cI ?>" type="hidden" value="<?php print $club['id_club'] ?>" />
            </td>

           <?php 
              if($promotores != NULL) 
                  foreach ($promotores as $promotor) 
                      if($club['id_club'] == $promotor['id_club'])
                      { ?>
                            <td><?php print strtoupper($promotor['nombre_promotor'].' '.$promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor']) ?></td>
                            <td><?php print $promotor['lugar'] ?></td>
                            <td><?php print $promotor['horario'] ?></td>
<?php                     
                      } 
 ?>
        </tr><?php
                  }
                 ?>
              </tbody>
            </table>
