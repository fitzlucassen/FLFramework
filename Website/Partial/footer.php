<!-- Required script -->
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Base/jquery-1.10.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Base/jquery-ui-1.10.custom.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Base/bootstrap.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/_built.js"></script>

<?php
	if(isset($this->Sections['scripts']))
		$this->Render($this->Sections['scripts']);
?>