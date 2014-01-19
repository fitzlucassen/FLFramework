<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/error.css" />
<title>Erreur !</title>

<?php
    // inclure ci-dessus les balises à inclure dans la balise <head> du layout
    $head = $this->RegisterViewHead();
    // START CONTENT
    // Intégrer ci-dessous la vue
?>

<div id="ErrorPage">
    <p>Le fichier <b><?php echo $Model->_controllerTarget; ?></b> a bien été inclue. Cependant, la classe qui y réside n'existe pas</p>
    <ul>
	<li>Vérifier que dans le fichier <b><?php echo $Model->_controllerTarget; ?></b> il existe bien une classe du même nom.</li>
    </ul>
</div>