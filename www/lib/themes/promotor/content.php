<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	if(isMobile()) {
		include "mobile/content.php";
	} else {
?>
<div class="col-md-1"></div>
<div class="col-md-10">
	<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
</div>
<?php } ?>