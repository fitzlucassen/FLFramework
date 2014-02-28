<?php
    use fitzlucassen\FLFramework\Library\Helper as helpers;
    use fitzlucassen\FLFramework\Library\Core as cores;

    session_start();
    
    // facultative var. Mandatory if you have something like 'localhost/mywebsite'
    define('__site_url__', "");
    // Includes
    require_once 'routes.config.php';
    require_once 'app.class.php';
    
    // Auto-load pour les entity et les repository et les helper
    spl_autoload_register("App::ManageAutoload");
    
    // Put your SQL config here
    cores\Sql::SetDb("flframework");
    cores\Sql::SetHost("localhost");
    cores\Sql::SetUser("root");
    cores\Sql::SetPwd("");
    // End SQL config
    
    /* FOR DEVELOPER ONLY */
    // Put your router config here
    cores\Router::SetDefaultAction("index");
    cores\Router::SetDefaultController("home");
    cores\Router::SetDefaultLanguage("fr");
    // End router config

    // Put your logger config here
    cores\Logger::setLogFile(__log_directory__ . '/log.txt');
    cores\Logger::setExpireTime(3600);
    // End logger config
    
    // Put your Cache config here
    cores\Cache::setCacheFolder(__cache_directory__ . '/');
    cores\Cache::setExpireTime(3600);
    // End logger config
    
    // Define your webapp needs here
    App::setIsDebugMode(true);
    App::setDatabaseNeeded(true);
    App::setUrlRewritingNeeded(true);
    // End
    
    $App = new App();
    $App->run();
    