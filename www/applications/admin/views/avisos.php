

<legend><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;  <strong>Publica un aviso</strong></legend>
<?php if($conf['mostraraviso'] == 0) { ?>
<div class="alert alert-warning">
	<a href="#" class="close" data-dismiss="alert">x</a>
	<p>La configuración actual indica que el aviso NO se está mostrando en el sitio web.</p>
</div>
<?php } ?>
<div class="well">En el siguiente apartado usted podrá escribir un aviso o varios avisos a las personas que visiten el sitio de Servicios Extraescolores. Al momento de guardar el aviso también se envía una notificación a todos los alumnos que tienen la aplicación de extraescolares.</div>
<hr>
<form id="textoForm" name="textoForm" action="<?php print get('webURL'). _sh . 'admin/guardarAviso' ?>" method="post">
	<textarea style="width: 100%" name="aviso" id="aviso">
		<?php echo $mensaje['texto_noticia'] ?>
	</textarea>
	<p>&nbsp;</p>
	<div class="form-group">
		<div class="col-sm-10">
			<label class="checkbox" >
				<input type="checkbox"  
					<?php if($conf['mostraraviso'] == 1) print 'checked="checked"' ?>
							name="mostrarAviso"> Mostrar el aviso cuando se entre al sitio de extraescolares.
			</label>
		</div>
		<div class="col-sm-2">
			<button type="submit" style="width:100%" class="btn btn-success">Guardar</button>
		</div>
	</div>
<p>

</p>
</form>

<script src="<?php print get("webURL")."/www/lib/tinymce/tinymce.min.js" ?>"></script>

<script type="text/javascript">
       tinymce.init({
            selector: "#aviso",
            height: 300
        });
</script>