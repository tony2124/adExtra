
<legend><span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;  <strong>Ver noticia</strong><a href="#" class="btn btn-primary btn-sm pull-right" onclick="goBack()"> <span class="glyphicon glyphicon-chevron-left"></span> Regresar</a> </legend>
	<!--<a href="http://www.facebook.com/sharer.php?s=100&p[url]=http://itsaextraescolares.com?s=100&p[title]=<?php print "Esta+es+una+noticia" ?>&p[images][0]=<?php print _rs."/img/noticias/".$noticia['imagen_noticia'] ?>&p[summary]=Hola">facebook</a> -->

<?php if(file_exists(_spath."/img/noticias/".$noticia['imagen_noticia']) && strcmp($noticia['imagen_noticia'],"") != 0) { ?>
<div class="img-thumbnail" style="background: url(<?php print _rs."/img/noticias/".$noticia['imagen_noticia'] ?>); background-size: cover; width:300px; height: 300px; float: left; margin-right: 30px; margin-bottom: 30px"></div>
<?php }else{ ?>
<div class="img-thumbnail" style="background: url(<?php print _rs."/img/noticias/no-disponible.png" ?>); background-size: cover; width:300px; height: 300px; float: left; margin-right: 30px; margin-bottom: 30px"></div>
<?php } ?>
<h3><?php print $noticia['nombre_noticia'] ?></h3>
<hr>
<p><i><?php print "Publicado el ".convertirFecha($noticia['fecha_modificacion'])." a las ".$noticia['hora'] ?>.</i></p>
<p><?php print $noticia['texto_noticia'] ?></p>