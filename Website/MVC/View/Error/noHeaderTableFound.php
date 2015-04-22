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
	<p>Il semble que vous n'ayez pas, dans votre base de données une table <b>"header"</b> gérant les descriptions par défault.</p>
	<ul>
	<li>Si vous souhaitez bénéficier de ce module, importer le fichier SQL <b><i>Module/NativeSQLModule/header_module</i></b></li>
	<li>
		Si vous ne souhaitez pas bénéficier de ce module, vous pouvez :<br/>
		Désactiver le mode debug dans le fichier <b><i>bootstrap.php</i></b> et supprimer dans le fichier <b><i>Website/MVC/Partial/meta.php</i></b> l'utilisation de l'objet <b><i>_headerInformations</i></b>
	</li>
	</ul>
</div>