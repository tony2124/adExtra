<?php
if(isset($clubes))
	foreach ($clubes as $club) {
		if($URL['club'] == $club['id_club']){
			$URL['club_nombre'] = $club['nombre_club']; break;
		}
	}

if(isset($albumes))
	if($albumes!=NULL)
	foreach ($albumes as $album) {
		if($URL['album'] == $album['id_album']){
			$URL['album_nombre'] = $album['nombre_album']; break;
		}
	}

if(isset($URL['tipo']))
	switch($URL['tipo'])
	{
		case '0': $URL['tipo_nombre'] = 'GENERAL'; 	break;
		case '1': $URL['tipo_nombre'] = 'DEPORTIVO'; break;
		case '2': $URL['tipo_nombre'] = 'CULTURAL'; break;
	}
?>	
<legend><span class="glyphicon glyphicon-picture"></span>&nbsp;&nbsp;  <strong>Galería</strong></legend>

<script type="text/javascript" src="<?php print path("www/lib/fancybox/jquery.mousewheel-3.0.6.pack.js",true) ?>"></script>
<script type="text/javascript" src="<?php print path("www/lib/fancybox/jquery.fancybox.pack.js",true) ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/fancybox/jquery.fancybox.css",true); ?>" media="screen" />
<script type="text/javascript" src="<?php print path("www/lib/uploadify/jquery.uploadify-3.1.min.js",true) ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/uploadify/uploadify.css",true) ?>">

<script type="text/javascript">
	$(document).ready(function() {

		<?php if(isset($URL['album'])) { ?>
		  $('#file_upload').uploadify({
		        'swf'      : '<?php print path("www/lib/uploadify/uploadify.swf",true) ?>',
		        'uploader' : '<?php print get("webURL")."/admin/subirfoto" ?>',
		        'buttonText' : 'SELECCIONA FOTOGRAFÍAS',
		        'width'	     : 230,
		        'height'	: 40,
		        'method'   : 'post',
		        'cancelImg': '<?php print path("www/lib/uploadify/uploadify-cancel.png",true) ?>',
    			'formData' : { 'album' : '<?php print $URL["album"] ?>', 'club' : '<?php print $URL["club"] ?>', 'tipo' : '<?php print $URL["tipo"] ?>' },
    			'onQueueComplete' : function(queueData) {
            		location.href="<?php print get('webURL') . _sh . 'admin/galeria' . _sh .$URL['tipo'] . _sh . $URL['club'] . _sh . $URL['album'] ?>";
        		}
		    });
		<?php } ?>

		$("a[rel=galeria]").fancybox();

	});
</script>

<script type="text/javascript">
	
	function eliminarAlbum(tipo, club, album, nombre_album)
	{
	   $('#nombre_album').html(nombre_album);
	   $('#eliminar').attr("href","<?php print get('webURL') . _sh . 'admin/elimAlbum/' ?>"+tipo+"/"+club+"/"+album);
	}

	function eliminarFoto( id , imname)
	{
		$('#id_imagen').val(id);
		$('#image_name').val(imname);
	}
	$( document ).ready(function() {
		$('[rel="tooltip"]').tooltip();
	});
</script>

<style type="text/css">
	.gallery{
		position: relative;
		width: 730px;
	}

	.horizontalList{	
		list-style: none;
	}

	.horizontalListItem{
		float: left;
	}

	.borderContainer{
		position: relative;
		width: 190px;
		height: 140px;
		margin: 5px;
		border: 1px solid #009966;
		padding: 4px; 
	}

	.imageContainer{
		position: relative;
		width: 180px;
		height: 130px;
		background-size: cover;
	}
</style>
<?php if(!isset($URL['album'])) { ?>
<div class="col-sm-1"><label>TIPO</label></div>
<div class="col-sm-3">
	<select class="form-control" onchange="if($(this).val()==0) location.href='<?php print get('webURL')._sh.'admin/galeria/0/0' ?>'; else location.href='<?php print get('webURL')._sh.'admin/galeria/' ?>'+$(this).val()">
		<option value="">:::Selecciona una opción:::</option>
		<option <?php ($URL['tipo']=='1') ? print 'selected="selected"' : NULL ?> value="1">DEPORTIVO</option>
		<option <?php ($URL['tipo']=='2') ? print 'selected="selected"' : NULL ?> value="2">CULTURAL</option>
		<option <?php ($URL['tipo']=='0') ? print 'selected="selected"' : NULL ?> value="0">GENERAL</option>
	</select> 
</div>

<?php }	if(isset($clubes)  && !isset($URL['album']) && $clubes[0]['id_club']!=0) { ?>
<div class="col-sm-1">	<label>CLUB</label></div>
<div class="col-sm-3">
	<select class="form-control" id="club" name="club" onchange="location.href='<?php print get('webURL'). _sh .'admin/galeria/'.$URL['tipo'].'/'?>'+document.getElementById('club').value" >
		<option value="">:::Selecciona un club:::</option>
	<?php foreach ($clubes as $club) {	?>
		<option <?php if($URL['club'] == $club['id_club']) print 'selected="selected"' ?> value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
	<?php } ?>
	</select>
</div>

 <?php } 

   if(isset($albumes) && !isset($URL['album'])) 
   { ?>
<div style="clear: both"></div>
<p>&nbsp;</p>
<div class="col-sm-1">
	<a href="#crearAlbum" data-toggle="modal" class="btn btn-primary" rel="tooltip" title="Crear un álbum">
		<i class="glyphicon glyphicon-pencil"></i>
	</a>
</div>

<div style="clear: both"></div>
<p>&nbsp;</p>
<?php
	if($albumes!=NULL)
		foreach ($albumes as $album) 
		{ ?>
			<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo']. _sh . $URL['club'] . _sh . $album['id_album'] ?>">
				<div align="center" style="float: left; width: 150px; height: 150px; border: 1px solid #EEE; padding: 5px; margin: 5px">			
					<img src="<?php print path('www/lib/images/carpeta.png','www') ?>" width="100" height="100" />
					<br>
					<?php echo $album['nombre_album'] ?>				
				</div>
			</a>
			<a  onclick="eliminarAlbum('<?php echo $URL['tipo']."','".$URL['club']."','".$album['id_album']."','".$album['nombre_album']."'" ?>)" data-toggle="modal" href="#confirmModalAlbum">
				<span data-toggle="tooltip" title="Eliminar álbum <?php print $album['nombre_album'] ?>" style="width: 20px; height: 20px; float: left; margin-left: -30px; margin-top: 10px" class="glyphicon glyphicon-remove"></span>
				<!--<img style="width: 20px; height: 20px; float: left; margin-left: -30px;" src="<?php print path('www/lib/images/eliminar.gif',true) ?>" /> -->
			</a>	
<?php	} 
	
	} 

	if(isset($URL['album'])) { ?>
	<a href="<?php print get('webURL'). _sh . 'admin/galeria' ?>">GALERIA</a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] ?>"><?php print $URL['tipo_nombre'] ?></a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] . _sh . $URL['club'] ?>"><?php print $URL['club_nombre'] ?></a> /
	<a href=""><?php print $URL['album_nombre'] ?></a> /
	<p>&nbsp;</p>
	<div class="col-sm-3">
		<a rel="tooltip" title="Atrás" onclick="goBack()" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left" ></i></a>&nbsp;
		<a rel="tooltip" title="Eliminar álbum" onclick="eliminarAlbum('<?php echo $URL['tipo']."','".$URL['club']."','".$album['id_album']."','".$album['nombre_album']."'" ?>)" data-toggle="modal" href="#confirmModalAlbum" class="btn btn-danger"><i class="glyphicon glyphicon-remove" ></i></a>&nbsp;
		<a rel="tooltip" title="Editar nombre" data-toggle="modal" href="#editarAlbum" class="btn btn-primary"><i class="glyphicon glyphicon-pencil" ></i></a>&nbsp;
	</div>
	<div style="clear: both"></div>
	<p>&nbsp;</p>
    <table>
	  <tr>
		<td>
		  <div id="gallery">
			<ul id="galleyList" class="horizontalList">
			<?php if($fotos == NULL) print '<div class="alert alert-danger">No hay fotos en este álbum</div>'; else foreach ($fotos as $foto) { ?>					
					<li class="horizontalListItem">
					    <div class="borderContainer">
					    	<div class="btn-group" role="group" aria-label="..." style="z-index: 1; position: absolute; right: 5px">
							  <div class="btn-group" role="group" >
							    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      <span class="glyphicon glyphicon-chevron-down"></span>
							    </button>
							    <ul class="dropdown-menu">
					              <li>
					              	<a href="#">
					              		<span class="glyphicon glyphicon-pencil"></span> Editar descripción <span class="label label-primary">Pro</span>
					              	</a>
					              </li>
					              <li class="divider"></li>
							      <li>
					              	<a href="#">
					              		<span class="glyphicon glyphicon-refresh"></span> Cambiar a otro álbum <span class="label label-primary">Pro</span>
					              	</a>
					              </li>
					                <li class="divider"></li>
					              <li>
					              	<a data-toggle="modal" href="#confirmModal" onclick="eliminarFoto('<?php print $foto['id_imagen']."','".$foto['nombre_imagen'] ?>')">
					              		<span class="glyphicon glyphicon-remove"></span> Eliminar foto
					              	</a>
					              </li>
					            </ul>
							  </div>
							</div>
					       <a rel="galeria" title="<?php print 'Descripción: '.$foto['pie'] ?>" href="<?php print _rs."/img/galeria/".$URL['club']. _sh . $URL['album']. _sh .$foto['nombre_imagen'] ?>">
						       <div class="imageContainer" style="background-image: url('<?php echo _rs."/img/galeria/".$URL['club']. _sh . $URL['album'] . "/thumbs/".$foto['nombre_imagen'] ?>');"></div>
						   </a>
				      </div>
				 	</li>						        							            
			<?php
			}
			?>
			</ul>
		  </div>
	    </td>
	  </tr>
   </table>

   <p>&nbsp;</p>
   <center>	<input type="file" name="file_upload" id="file_upload" /></center>

     <hr>
   <p>&nbsp;</p>
	<?php }	?>

<div class="modal fade" id="confirmModalAlbum">
	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
		  <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Confirmación</h3>
		  </div>
		  <div class="modal-body">
		    <p>¿Está seguro que desea eliminar el album <span class="label label-danger" id="nombre_album"></span> de la galeria?</p>
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
		    <a href="#" class="btn btn-danger" id="eliminar">Eliminar</a>
		  </div>
		</div>
	</div>
</div>


<div class="modal fade" id="confirmModal">
	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
		  <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Confirmación</h3>
		  </div>
		  <div class="modal-body">
		    <p>¿Está seguro que desea eliminar esta foto?</p>
		   
		    <form id="elimPromo" method="post" action="<?php print get('webURL')._sh.'admin/elimFoto' ?>">
		      <input name="id_imagen" id="id_imagen" type="hidden" value="">
		      <input name="image_name" id="image_name" type="hidden" value="">
		      <input name="path" id="path" type="hidden" value="<?php print $URL['club'] . _sh .$URL['album']  ?>">
		      <input name="url" id="url" type="hidden" value="<?php print get('webURL') . _sh .'admin/galeria' . _sh . $URL['tipo'] . _sh . $URL['club'] . _sh .$URL['album'] ?>">
		    </form> 
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		    <a href="#" class="btn btn-danger" onclick="$('#elimPromo').submit()">Eliminar</a>
		  </div>
		</div>
	</div>
</div>

<div class="modal  fade" id="crearAlbum">
	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
		  <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Nuevo Álbum</h3>
		  </div>
		  <div class="modal-body">
		    <p>Escribe el nombre del álbum</p>
		   
		    <form id="album" method="post" action="<?php print get('webURL')._sh.'admin/crearAlbum/'.$URL['tipo']._sh.$URL['club'] ?>">
		      <input class="form-control" name="nombre_album" type="text">
		    </form> 
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
		    <a href="#" class="btn btn-primary" onclick="$('#album').submit()">Crear álbum</a>
		  </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editarAlbum">
	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
		  <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Editar nombre del Album</h3>
		  </div>
		  <div class="modal-body">
		    <p>Escribe el nuevo nombre del álbum</p>
		   
		    <form id="editalbum" method="post" action="<?php print get('webURL')._sh.'admin/editAlbum/'.$URL['tipo'].'/'.$URL['club'].'/'.$album['id_album'] ?>">
		      <input class="form-control" name="nombre_album" type="text">
		    </form> 
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
		    <a href="#" class="btn btn-success" onclick="$('#editalbum').submit()">Guardar nombre del álbum</a>
		  </div>
		 </div>
	</div>
</div>

