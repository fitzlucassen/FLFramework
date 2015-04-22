<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/error.css" />
<title>Erreur !</title>

<?php
	// inclure ci-dessus les balises à inclure dans la balise <head> du layout
	$this->endSection('head');
?>
<?php
	// inclure ci-dessous les balises à inclure à la fin de votre DOM
	$this->beginSection();
?>
<?php
	$this->endSection('scripts');
	$this->beginSection();
	// START CONTENT
	// Intégrer ci-dessous la vue
?>

<div id="ErrorPage">
	<p>Visiblement, vous tentez d'exécuter une action qui n'existe pas.</p>
	<ul>
	<li>Vérifier que la fonction <b><?php echo $this->Model->_modelTarget; ?></b> du contrôleur <b><?php echo $this->Model->_controllerTarget; ?></b>, existe bien.</li>
	<li>De même, vérifiez que vous ne vous trompez pas de controller.</li>
	</ul>
</div>