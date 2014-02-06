<?php
    use fitzlucassen\FLFramework\Library\Helper as helpers;

    session_start();
    
    // facultative var. Mandatory if you have something like 'localhost/mywebsite'
    define('__site_url__', "");
    // Includes
    require_once 'routes.config.php';
    require_once 'app.class.php';
    
    // Auto-load pour les entity et les repository et les helper
    spl_autoload_register("App::ManageAutoload");
    
    // Put your SQL config here
    helpers\Sql::SetDb("flframework");
    helpers\Sql::SetHost("localhost");
    helpers\Sql::SetUser("root");
    helpers\Sql::SetPwd("");
    // End SQL config
    
    /* FOR DEVELOPER ONLY */
    // Put your router config here
    helpers\Router::SetDefaultAction("index");
    helpers\Router::SetDefaultController("home");
    helpers\Router::SetDefaultLanguage("fr");
    // End router config

    // Put your logger config here
    helpers\Logger::setLogFile(__log_directory__ . '/log.txt');
    helpers\Logger::setExpireTime(3600);
    // End logger config
    
    // Put your Cache config here
    helpers\Cache::setCacheFolder(__cache_directory__ . '/');
    helpers\Cache::setExpireTime(3600);
    // End logger config
    
    $App = new App();
    $App->setIsDebugMode(true);
    $App->run();