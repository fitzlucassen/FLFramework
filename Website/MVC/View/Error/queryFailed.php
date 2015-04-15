<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/error.css" />
<title>Erreur !</title>

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

<div id="ErrorPage">
	<p>Visiblement, la requête que vous tentez d'exécuter en base de données a provoquée une erreur. Voici le message</p>
	<ul>
		<li><?php echo $this->Model->_message; ?></li>
	</ul>
</div>