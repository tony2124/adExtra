
<legend><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;  <strong>Reglamento del departamento</strong></legend>
<p>Escriba el reglamento del departamento cultural, deportiva y recreativa, tome en cuenta que este reglamento es el que se muestra en el sitio informativo y nada esta enlazado con el archivo de descarga del reglamento.</p>
<hr>
<form id="textoForm" name="textoForm" action="<?php print get('webURL'). _sh . 'admin/guardarReglamento' ?>" method="post">
	<div class="form-group">
		<div class="col-sm-12">
		<textarea style="width: 100%" name="reglamento" id="reglamento">
			<?php echo $reglamento['reglamento'] ?>
		</textarea>
		</div>
	</div>
<p>&nbsp;</p>
	<div class="form-group">
		<div class="col-sm-10"></div>
		<div class="col-sm-2">
			<button type="submit" style="width:100%" class="btn btn-success">Guardar</button>
		</div>
	</div>

</form>

<script src="<?php print get("webURL")."/www/lib/tinymce/tinymce.min.js" ?>"></script>

<script type="text/javascript">
       tinymce.init({
            selector: "#reglamento",
            height: 300
        });
</script>