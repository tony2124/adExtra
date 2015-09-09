<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_editor.min.css" ?>" rel="stylesheet" type="text/css" />
<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_content.min.css" ?>" rel="stylesheet" type="text/css" />

<link href="<?php print get("webURL")."/www/lib/froala_editor/css/froala_style.min.css" ?>" rel="stylesheet" type="text/css" />


<legend><span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;  <strong>Publica un aviso</strong></legend>
<?php if($conf['mostraraviso'] == 0) { ?>
<div class="alert alert-warning">
	<a href="#" class="close" data-dismiss="alert">x</a>
	<p>La configuración actual indica que el aviso NO se está mostrando en el sitio web.</p>
</div>
<?php } ?>
<div class="well">En el siguiente apartado usted podrá escribir un aviso o varios avisos a las personas que visiten el sitio de Servicios Extraescolores.</div>
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

<script src="<?php print get("webURL")."/www/lib/froala_editor/js/froala_editor.min.js" ?>"></script>

<script type="text/javascript">
      $(function() {
          $('#aviso').editable({
          	inlineMode: false,
          	allowStyle: true,
          	colors: [
		        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
		        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
		      ]
          })
      });
</script>