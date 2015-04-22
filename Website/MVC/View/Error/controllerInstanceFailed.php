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
	<p>Le fichier <b><?php echo $this->Model->_controllerTarget; ?></b> a bien été inclue. Cependant, la classe qui y réside n'existe pas</p>
	<ul>
	<li>Vérifier que dans le fichier <b><?php echo $this->Model->_controllerTarget; ?></b> il existe bien une classe du même nom.</li>
	</ul>
</div>