<?php
	use fitzlucassen\FLFramework\Library\Core;
	
	// facultative var. Mandatory if you have something like 'localhost/mywebsite'
	define('__site_url__', "");
	// Includes
	require_once 'routes.config.php';
	require_once 'app.class.php';
	
	// Auto-load pour les entity et les repository et les helper
	spl_autoload_register("App::manageAutoload");
	
	// Put your SQL config here
	Core\Sql::setDb("flframework");
	Core\Sql::setHost("localhost");
	Core\Sql::setUser("root");
	Core\Sql::setPwd("");
	// End SQL config
	
	/* FOR DEVELOPER ONLY */
	// Put your router config here
	Core\Router::setDefaultAction("index");
	Core\Router::setDefaultController("home");
	Core\Router::setDefaultLanguage("fr");
	// End router config

	// Put your logger config here
	Core\Logger::setLogFile(__log_directory__ . '/log.txt');
	Core\Logger::setExpireTime(3600);
	// End logger config
	
	// Put your Cache config here
	Core\Cache::setCacheFolder(__cache_directory__ . '/');
	Core\Cache::setExpireTime(3600);
	// End logger config
	
	// Define your webapp needs here
	App::setIsDebugMode(true);
	App::setDatabaseNeeded(true);
	App::setUrlRewritingNeeded(true);
	// End
	
	$App = new App();
	$modules = $App->getModuleToInclude();
	foreach ($modules as $value) {
		require_once $value;
	}

	$App->run();
