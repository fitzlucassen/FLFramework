<footer>
	
</footer>

<!-- Required script -->
<script type="text/javascript" src="/<?php echo __js_directory__; ?>/Module/jquery-1.10.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__; ?>/Module/materialize.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/jquery-ui-1.10.custom.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/_built.js"></script>

<?php
	if(isset($this->Sections['scripts']))
		$this->render($this->Sections['scripts']);
?>