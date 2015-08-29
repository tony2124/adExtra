
<form action="" method="post">
	<legend><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Relación de promotores</legend>
	<div  class="busqueda-form">
		<div class="form-group">
	    	<label for="inputBuscar" style="margin-top:5px;margin-right:10px" class="col-sm-1 control-label">Buscar</label>
	    	<div class="col-sm-7">
	      		<input type="text" value="<?php print $buscar ?>" name="buscar" class="form-control" placeholder="Nombre promotor / apellido pat. / apellido mat. / usuario">
	    	</div>
	    	<div class="col-sm-3">
	    		<button  type="submit" data-toggle="tooltip" class="btn btn-primary">
	    			<span class="glyphicon glyphicon-search"></span> Buscar
	    		</button>
				<a  data-toggle="modal" data-target="#avanzada" title="Búsqueda avanzada" class="btn btn-primary" ><span class="glyphicon glyphicon-filter"></span>&nbsp;</a>			
				<div class="btn-group">
		  <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#" style="width:100%">
		    Descarga
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <li><a href="<?php print get('webURL')._sh ?>" target="_blank">Lista de promotores</a></li>		  </ul>
		</div>
	    	</div>
	  	</div>
	</div>
</form>
<div style="clear: both"></div>
<p>&nbsp;</p>
<p>Registros encontrados: <?php if($promotores != null) print sizeof($promotores); else print "0"; ?></p>
<p>&nbsp;</p>
<table class="table table-hover">
	<tr>
		<td>Usuario</td>
		<td>Nombre</td>
		<td>Sexo</td>
		<td>E-mail</td>
		<td>Teléfono</td>
		<td>Edad</td>
		<td>Estado</td>
		<td></td>
	</tr>
	<tbody>
		<?php 
		if($promotores != null)
			foreach ($promotores as $prom) { ?>
			<tr>
				<td><?php print $prom['usuario_promotor'] ?></td>
				<td><?php print $prom['apellido_paterno_promotor']." ".$prom['apellido_materno_promotor']." ".$prom['nombre_promotor'] ?></td>
				<td><?php print ($prom['sexo_promotor']==1) ? "H" : "M"; ?></td>
				<td><?php print $prom['correo_electronico_promotor'] ?></td>
				<td><?php print $prom['telefono_promotor'] ?></td>
				<td><?php print edad($prom['fecha_nacimiento_promotor']) ?></td>
				<td><?php print ($prom['eliminado_promotor'] == 0) ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>No activo</span>" ?></td>
				<td>
					<a href="<?php print get("webURL") . "/admin/formEdicionPromotor/$prom[usuario_promotor]" ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> </button>
			<?php	if($prom['eliminado_promotor'] == 0) { ?>
					<a href="<?php print get("webURL") ."/admin/habilitarpromotor/$prom[usuario_promotor]/1" ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> </a>
			<?php } else { ?>
					<a href="<?php print get("webURL") ."/admin/habilitarpromotor/$prom[usuario_promotor]/0" ?>" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> </a>
			<?php } ?>
				</td>
			</tr>
	<?php	}

		?>
	</tbody>

</table>




<div class="modal fade"  id="avanzada" role="dialog" >
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><div>Búsqueda avanzada</div></h3>
      </div>
      <form action="<?php print get("webURL")."/admin/promotores" ?>" method="post"> 
	      <div class="modal-body">
		      	<div class="form-horizontal">
			  		<div class="form-group">
				    	<label class="col-sm-2 control-label">SEXO: </label>
					    <div class="col-sm-3">
					      	<select name="sexo" class="form-control input">
					      		<option value="-1">-- Sin filtro</option>
					      		<option value="1">HOMBRE</option>
					      		<option value="2">MUJER</option>
					      	</select>
					    </div>
				    	<label class="col-sm-2 control-label">ESTADO.: </label>
					    <div class="col-sm-4">
					      	<select name="estado" class="form-control input">
					      		<option value="-1">-- Sin filtro</option>
					      		<option value="0">ACTIVO</option>
					      		<option value="1">NO ACTIVO</option>
					      	</select>
					    </div>
					    <input type="hidden" name="buscar" value="<?php print $buscar ?>">;
			  		</div>
		  		</div>
	  		<div style="clear:both"></div>
	  		<p>&nbsp;</p>
		  </div>
		  <div class="modal-footer">
		  	<center>
			    <a style="width: 150px" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</a>
			    <button tyoe="submit" style="width: 150px" class="btn btn-primary" data-dismiss="modal">Aplicar</button>
			    <input type="hidden" id="filtro">
		    </center>
	      </div>
      </form>
    </div>
  </div>
</div>


<script>
     function verificar2(){
			//alert("cambio a " + $("#costo").val());
			if($("#fecha").val() == 0)
				$("#fecha_i").attr("disabled","disabled");
			else 
				$("#fecha_i").removeAttr("disabled");

			if($("#fecha").val() == 4)
				$("#fecha_f").css("display","block");
			else
				$("#fecha_f").css("display","none");
		}

	
</script>