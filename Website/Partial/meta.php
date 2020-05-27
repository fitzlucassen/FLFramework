<?php
	$defaultMetaDesc = isset($this->Model->_headerInformations) ? $this->Model->_headerInformations->getMetaDescription() : "";
	$defaultTitle = isset($this->Model->_headerInformations) ? $this->Model->_headerInformations->getTitle() : "";
?>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta name="Description" content="<?php echo $defaultMetaDesc; ?>" >
<meta name="Author" content="Thibault Dulon">

<meta name="Revisit-after" content="3 days">
<meta name="Publisher" content="Thibault dulon">
<meta name="Generator" content="PHP Engineer, HTML5/CSS3 Integrator">
<meta name="Robots" content="index, follow, all">
<meta name="Rating" content="general">
<meta name="Language" content="fr">
<meta name="Viewport" content="initial-scale=1.0">

<meta property="og:title" content="<?php echo $defaultTitle; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://<?php echo $_SERVER['SERVER_NAME']; ?>" />
<meta property="og:image" content="http://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php echo __image_directory__; ?>/Icons/favicon-96x96.png" />
<meta property="og:description" content="<?php echo $defaultMetaDesc; ?>" />

<link rel="icon" type="images/png" href="<?php echo __image_directory__; ?>/Icons/favicon.ico" />
<!--[if IE]>
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
<![endif]-->

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo __image_directory__; ?>/Icons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo __image_directory__; ?>/Icons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo __image_directory__; ?>/Icons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo __image_directory__; ?>/Icons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo __image_directory__; ?>/Icons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo __image_directory__; ?>/Icons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo __image_directory__; ?>/Icons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo __image_directory__; ?>/Icons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo __image_directory__; ?>/Icons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo __image_directory__; ?>/Icons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo __image_directory__; ?>/Icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo __image_directory__; ?>/Icons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo __image_directory__; ?>/Icons/favicon-16x16.png">
<link rel="manifest" href="<?php echo __image_directory__; ?>/Icons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo __image_directory__; ?>/Icons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<link href="https://plus.google.com/118113345454496028722" rel="publisher" />

<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/Module/materialize.min.css" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/_built.css" />

<!--[if lt IE 9]>
	<script src="/<?php echo __js_directory__  ; ?>/Module/html5shiv.js"></script>
<![endif]-->

<?php
	include(__partial_directory__ . "/tracking.php");

	// S'il n'y a pas de title de précisé, on inclue le title par défaut présent en base de données
	if(!$this->containsTitle($this->Sections['head'])) {
?>
	<title><?php echo $defaultTitle; ?></title>
<?php
	}
?>