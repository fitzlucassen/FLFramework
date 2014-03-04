<!DOCTYPE HTML>
<html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    	<?php
	    	// S'il n'y a pas de title de précisé, on inclue le title par défaut présent en base de données
		    if(!$this->containsTitle($__head)) {
		?>
			<title>Template Email</title>
		<?php
		    }
			// Inclusion de la vue cible
			$this->render($__head);
	    ?>
    </head>

    <body>
		<div id="global">
		    <?php
				// Inclusion de la vue cible
				$this->render($__content);
		    ?>
		</div>
    </body>
</html>