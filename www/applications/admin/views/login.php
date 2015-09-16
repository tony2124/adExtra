
<style type="text/css">

body{
	background: url(<?php print ruta_imagen . '/backgrounds/back4.jpg' ?>);
  background-size: cover;
}

</style>

<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	
<form class="form-horizontal center-block" style="max-width:300px" method="post" action="<?php print get('webURL') . _sh . 'admin/iniciarsesion' ?>">
<center>
	<img src="<?php print ruta_imagen . '/ITSA.png' ?>" width="120">
	<p>&nbsp;</p>
	<p style="font-family: 'Lobster', cursive; font-size: 2em; color: #fff">Departamento de actividades culturales, deportivas y recreativas</p>
	<hr>
</center>
<?php if($error=='1') { ?>
	<div class="alert alert-danger">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  ¡Datos incorrectos! Intente de nuevo por favor.
	</div>
	<?php } ?>
  <div class="form-group">
    <!--<label for="inputEmail3" class="col-sm-3 control-label">Usuario</label>-->
    <div class="col-sm-12">
      <input type="text" name="usuario" class="form-control" id="inputEmail3" placeholder="Usuario">
    </div>
  </div>
  <div class="form-group">
    <!--<label for="inputPassword3" class="col-sm-3 control-label">Contraseña</label>-->
    <div class="col-sm-12">
      <input type="password" name="clave" class="form-control" id="inputPassword3" placeholder="Contraseña">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary center-block" style="width: 150px">Entrar</button>
    </div>
  </div>
</form>
