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
	<p>Il semble que vous ne bénéficiez pas du module rewriting du framework. Vous pouvez :</p>
	<ul>
	<li>Activer ce module en important dans votre base de données le fichier <b><i>Module/NativeSQLModule/rewriting_module.sql</i></b></li>
	<li>Ne pas activer ce module et garder le mode dispatcher. Pour cela, désactivez le mode debug dans <b><i>bootstrap.php</i></b></li>
	</ul>
</div>