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
	<p>Il semble y avoir un problème au niveau de la connexion MySQL. Cela peut-être dû à plusieurs choses :</p>
	<ul>
	<li>Vous n'avez pas créez de base de données sur votre serveur.</li>
	<li>Vous avez mal renseigné les configurations liées à la base de données dans le fichier Library/Core/sql.class.php</li>
	<li>Vous n'avez aucun serveur PHP/MySQL de lancer (lancer WAMP ou XAMP en local)</li>
	</ul>
</div>