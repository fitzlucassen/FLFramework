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
	<p>Visiblement, vous n'avez pas fourni de modèle à une vue qui en nécessite un.</p>
	<ul>
	<li>Vérifier que la fonction <b><?php echo $this->Model->_modelTarget; ?></b> du contrôleur <b><?php echo $this->Model->_controllerTarget; ?></b>, se termine bien par : <i>'$this->_view->view($this->_controller, $this->_action, array("Model" => $this->Model)'</i></li>
	<li>De même, vérifiez que l'objet que vous passé en paramètre comme modèle hérite bien de la classe <i>Website/MVC/Model/Model.php</i></li>
	</ul>
</div>