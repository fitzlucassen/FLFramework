<link type="text/css" rel="stylesheet" href="<?php echo __css_directory__;?>/home.css" />
<title>404 - Cette page n'existe pas ou plus...</title>

<?php
    // inclure ci-dessus les balises à inclure dans la balise <head> du layout
    $this->EndSection('head');
?>
<?php
	// inclure ci-dessous les balises à inclure à la fin de votre DOM
	$this->BeginSection();
?>
<?php
	$this->EndSection('scripts');
	$this->BeginSection();
	// START CONTENT
    // Intégrer ci-dessous la vue
?>
<div class="ErrorPage">
		<h1 class="title">Cette page n'existe pas</h1>

		<p class="title">404</p>
</div>