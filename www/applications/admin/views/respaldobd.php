<script>
function eliminar(name)
{
   $('#nombre_archivo').html(name);
   $('#eliminar').attr("href","<?php print get('webURL') . _sh . 'admin/eliminarrespaldo/' ?>"+name);
}
</script>
<legend><span class="glyphicon glyphicon-hdd"></span>&nbsp;&nbsp;Respaldo de la base de datos</legend>
<div class="well">Esta acción le permitirá descargar una copia de la base de datos del sistema. Es recomendable mantener respaldos periodicos. Por su seguridad e integridad de la información, guarde el archivo en un lugar seguro para evitar que personas no autorizadas tengan o alteren la información </div>
<p>
	<a data-toggle="modal" data-target="#myModal" href="#" class="btn btn-success">Respaldar BD</a>
</p>
<p>&nbsp;</p>
<legend><span class="glyphicon glyphicon-hdd"></span>&nbsp;&nbsp;Historial de respaldos</legend>
<table class="table table-striped table-condensed">
	<thead>
		<th width="200">Nombre del respaldo</th>
		<th width="150">Tamaño</th>
		<th>Fecha de creación</th>
		<th width="70"></th>
	</thead>
	<tbody>
		<?php $i = 0; while($i < sizeof($files)) { ?>
		<tr>
			<td ><a href="<?php print _rs . '/respaldos/' . $files[$i] ?>" target="_blank"><?php echo $files[$i] ?></a></td>
			<td><?php print redondear_dos_decimal( filesize( _spath . "/respaldos/".$files[$i]) / (1024*1024) )." MB" ?></td>
			<td><?php print date("F d Y H:i:s.", filectime ( _spath . "/respaldos/".$files[$i] ) ) ?></td>
			<td >
				<a rel="tooltip" title="Eliminar" data-toggle="modal" class="btn btn-danger btn-xs" href="<?php print get("webURL")."/admin/eliminarrespaldo/". $files[$i] ?>">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
				<a class="btn btn-success btn-xs" target="_blank" href="<?php print _rs . '/respaldos/' . $files[$i++] ?>">
					<span class="glyphicon glyphicon-save"></span>
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="myModalLabel">Respaldo de la Base de datos </h4>
      </div>
      <div class="modal-body">
        <div class="progress">
		  <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
		    0%
		  </div>
		</div>
      </div>
      <div class="modal-footer">
        <button id="cancelar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="iniciar" onclick="descargarBD()" type="button" class="btn btn-primary">Iniciar descarga</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

	var tablas = ["administradores","albumes","alumnos","carreras","clubes","configuracion","conf_fechas","formatos","galeria","horarios","inscripciones","noticias","operaciones_administrativas","operaciones_alumnos","promotores","revisiones","tipo_club"];
	var name ="<?php print date('YmdHis') ?>";
	function descargarBD(){

		$("#iniciar").attr("disabled","disabled");
		$("#cancelar").attr("disabled","disabled");
		
		reiniciar();
		cont = 0;
		recursivo(cont);
	}

	function reiniciar(){
		$.ajax({
			  url: "<?php print get('webURL').'/admin/limpiarrespaldo' ?>",
		});	
	}


	function recursivo( i ){
		var urlS = <?php print '"'.get('webURL').'/admin/respaldando/" + name + "/" + tablas[i]'  ?>;
		$.ajax({
			  url: urlS,
			  success: function(data){
			  	    $("#progress").css("width",( parseInt((i  + 1 ) * 100 / (tablas.length-1))) + "%");
			    	$("#progress").html(  parseInt( (i  + 1 ) * 100 / (tablas.length-1) )+ "%");
			    	
			    	i++;
			    	if(i == tablas.length-1)
			    	{
			    		descargarZIP();
			    		$('#myModal').modal('hide');
			    		
			    	}
			    	else
			    		recursivo(i);

			  }
		});
	}

	function descargarZIP(){
		$.ajax({
			  url: "<?php print get('webURL').'/admin/descargarBD/' ?>"+name,
			  success: function( data ){
			  	window.location.href="<?php print _rs.'/respaldos/' ?>" + name + ".zip";
			  	window.location.href="<?php print get('webURL').'/admin/respaldoBD' ?>";
			  }
		});	
	}

</script>