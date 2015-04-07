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
	<p>Visiblement, le layout que vous souhaitez utiliser n'existe pas</p>
	<ul>
	<li>Vérifier que le fichier <b><?php echo $this->Model->_layoutTarget; ?></b> existe bien dans le dossier <i>Website/MVC/View/Layout</i></li>
	</ul>
</div>