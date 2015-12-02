<script type="text/javascript" src="<?php print path("www/lib/uploadify/jquery.uploadify-3.1.min.js",true) ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/uploadify/uploadify.css",true) ?>">

<script type="text/javascript">
	$(document).ready(function() {

		  $('#file_upload').uploadify({
		        'swf'      : '<?php print path("www/lib/uploadify/uploadify.swf",true) ?>',
		        'uploader' : '<?php print get("webURL")."/admin/subirfotosalumnos/" ?>',
		        'buttonText' : 'SELECCIONA FOTOGRAFÍAS',
		        'width'	     : 230,
		        'height'	: 40,
		        'method'   : 'post',
		        'cancelImg': '<?php print path("www/lib/uploadify/uploadify-cancel.png",true) ?>',
    			'onQueueComplete' : function(queueData) {
            		
        		}
		    });

	});
</script>
<DIV class="alert alert-warning">Suba solo fotografías de alumnos proporcionadas por el departamento de servicios escolares.</DIV>
<div class="well">
	Las fotografías deben tener las siguientes características:
	<ul>
		<li>Tamaño máximo por fotografía 20 KB</li>
		<li>Y la forma de estas son rectangulares de manera vertical.</li>
		<li>Las dimensiones recomendadas 414 x 554.</li>
		<li>El nombre de cada fotografía debe coincidir con el número de control del alumno.</li>
	</ul>

</div>
<p>&nbsp;</p>
<center>	
	<input type="file" name="Filedata" id="file_upload" />
</center>