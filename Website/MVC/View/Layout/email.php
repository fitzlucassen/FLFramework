<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
		<?php
			// L'inclusion des CSS, JS et HTML personnalisés pour chaque page
			// C'est à remplir dans les vues.
			$this->render($this->Sections['head']);

			// S'il n'y a pas de title de précisé, on inclue le title par défaut présent en base de données
			if(!$this->containsTitle($this->Sections['head'])) {
		?>
			<title>E-mail</title>
		<?php
			}
		?>
	</head>
	<body>
		<div id="global">
			<?php
				// Inclusion de la vue cible
				$this->render($this->Sections['body']);
			?>
		</div>
	</body>
</html>