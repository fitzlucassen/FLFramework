<title>Hackathon</title>

<?php
    // inclure ci-dessus les balises à inclure dans la balise <head> du layout
    $head = $this->RegisterViewHead();
    // START CONTENT
    // Intégrer ci-dessous la vue
?>
<div class="page">
	<p class="login"><a href="#">Récupérer ma lettre</a></p>
	<div class="login-panel">
		<?php echo $this->Model->loginForm; ?>
	</div>


	<div class="perenoel">
	</div>

	<div class="htmlContainer">
		<?php echo $this->Model->htmlForm; ?>
	</div>
</div>