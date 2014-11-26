<!DOCTYPE HTML>
<html>
    <head>
	<?php
	    // La page à modifier pour inclure le CSS le JS et les balises meta du layout (toutes les pages)
	    include(__partial_directory__ . "/meta.php");
	    
	    // L'inclusion des CSS, JS et HTML personnalisés pour chaque page
	    // C'est à remplir dans les vues.
	    $this->Render($this->Sections['head']);
	    
	    // S'il n'y a pas de title de précisé, on inclue le title par défaut présent en base de données
	    if(!$this->ContainsTitle($this->Sections['head'])) {
	?>
		<title><?php $this->Render($this->Model->_headerInformations->getTitle()); ?></title>
	<?php
	    }
	?>
    </head>

    <body>
	<div id="global">
	    <?php
			include(__partial_directory__ . "/header.php");
	    ?>
	    <?php
			// Inclusion de la vue cible
			$this->Render($this->Sections['body']);
	    ?>
	    <?php
			include(__partial_directory__ . "/footer.php");
	    ?>
	</div>
    </body>
</html>