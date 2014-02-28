<?php
    use fitzlucassen\FLFramework\Library\Adapter as adapters;
    use fitzlucassen\FLFramework\Library\Helper as helpers;
    use fitzlucassen\FLFramework\Library\Core as cores;
    
    use fitzlucassen\FLFramework\Data as data;
    
    class App {
	private $_CONTROLLER_NAMESPACE = '\fitzlucassen\FLFramework\Website\MVC\Controller\\';
	private $_FLF_NAMESPACE = '\fitzlucassen\FLFramework\\';
	
	// Url routing vars
	private $_routeUrl = null;
	private $_rewrittingUrl = null;
	private $_routeUrlRepository = null;
	private $_rewrittingUrlRepository = null;
	private $_langRepository = null;
	private $_url = "";
	private $_page = "";
	
	// Boolean vars
	private $_isInErrorPage = false;
	private $_isOnMobile = false;
	private $_isValidUrl = false;
	private static $_isDebugMode = false;
	private static $_databaseNeeded = true;
	private static $_urlRewritingNeeded = true;
	
	// String vars
	private $_lang = "";
	private $_controllerName = "";
	private $_actionName = "";
	private $_controller = null;
	private $_userAgent = "";

	// Helpers object
	private $_pdo = null;
	private $_session = null;
	private $_errorManager = null;
	private $_repositoryManager = null;
	
	// Construction des objets et récupération des variables
	public function __construct() {
	    $this->initialize();
	    
	    // Initialisation base de données sauf si on est sur une page d'erreur
	    if(!isset($this->_pdo) && self::$_databaseNeeded && !$this->_isInErrorPage){
		try{
		    $this->_pdo = new cores\Sql();
		    $this->_repositoryManager = new cores\RepositoryManager($this->_pdo, $this->_session->read('lang'));
		}
		catch(adapters\ConnexionException $e){
		    $this->_errorManager->noConnexionAvailable();
		    die();	
		}
	    }
	    
	    $this->run();
	}
	
	public function initialize(){
	    // L'url cible
	    $this->_page = $_SERVER['REQUEST_URI'];
	    // Pour gérer les différents devices
	    $this->_userAgent = $_SERVER['HTTP_USER_AGENT'];
	    $this->_isOnMobile = (  preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$this->_userAgent) || 
				    preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($this->_userAgent,0,4)));
	    
	    // On instancie le manager d'erreur
	    $this->_errorManager = new cores\Error();
	    // Initialisation de la session
	    $this->_session = new helpers\Session();
	    // Booléen permettant de savoir s on est sr une page erreur
	    $this->_isInErrorPage = strpos($this->_page, '/Error/') !== false;
	    
	    // Si on a pas de langue on session on set celle par défaut
	    if(!$this->_session->ContainsKey("lang"))
		$this->_session->Write("lang", cores\Router::GetDefaultLanguage());
	}
	
	/**
	 * run -> initialisation de l'app
	 */
	public function run(){	
	    // On vérifie que tous les modules quasi indispensable sont inclus.
	    // Si non on lance les exceptions adaptées
	    $this->ManageModuleException();
	    
	    $langInUrl = false;
	    
	    // On récupère les routes en base de données seulement si a une base de données
	    if(self::$_databaseNeeded && !$this->_isInErrorPage){
		$this->_langRepository = $this->_repositoryManager->get('Lang');
		
		// Si les langues ne sont pas encore en cache on requête en BDD
		if(!$langs = cores\Cache::read("lang")){
		    $langs = data\Repository\LangRepository::getAll($this->_pdo);
		    // On ecrit le résultat en cache
		    cores\Cache::write("lang", $langs);
		    // Si on a pas de module multilingue on insère la langue par défaut
		    if(count($langs) == 0)
			$langs = array(array('id' => 1, 'code' => cores\Router::GetDefaultLanguage()));
		}
		
		// On ajoute toutes les routes présentes en base de données au router
		foreach($langs as $thisLang){
		    // Si les routes ne sont pas encore en cache on requête en BDD
		    if(!$routes = cores\Cache::read("routeurl")){
			$routes = data\Repository\RouteUrlRepository::getAll($this->_pdo);
			// On ecrit le résultat en cache
			cores\Cache::write("routeurl", $routes);
		    }
		    cores\Router::AddRange($routes, $thisLang->getCode(), $this->_pdo);
		    
		    // Si on est sur une page de langue spécifique alors on change la langue en session
		    if(strpos($this->_page, "/" . $thisLang->getCode() . "/") === 0){
			$this->_session->Write("lang", $thisLang->getCode());
			$langInUrl = true;
		    }
		}
	    }
	    
	    // Si on est pas sur une page de langue spécifique, on set la langue par défaut en session
	    if(!$langInUrl)
		$this->_session->Write("lang", cores\Router::GetDefaultLanguage());
	    
	    $this->_lang = $this->_session->Read("lang");
	    
	    // On récupère le controller et l'action de l'url
	    if(self::$_databaseNeeded && !$this->_isInErrorPage){
		$this->_rewrittingUrlRepository = $this->_repositoryManager->get('RewrittingUrl');
		$this->_url = $this->_rewrittingUrlRepository->getByUrlMatched($this->_page);
	    }
	    else {
		$this->_url = cores\Router::GetRoute($this->_page);
	    }
	    
	    $this->ManageRouting();
	}
	
	/**
	 * ManageRouting -> Renvoie false si on doit renvoyer vers la page par défaut. True sinon. Gère le routing de base
	 * @return boolean
	 */
	public function ManageRouting(){
	    if(self::$_databaseNeeded && !$this->_isInErrorPage){
		$this->_routeUrlRepository = $this->_repositoryManager->get('RouteUrl');
		
		// S'il n'y a aucune route en base matchant cette url, ou que l'url est '/'
		if(!isset($this->_url['controller']) || empty($this->_url['controller']) || ($this->_url["debug"] == "default" && $this->_page == '/')){
		    // On récupère la route de la homepage et on en déduit l'objet rewritting
		    $this->_routeUrl = $this->_routeUrlRepository->getByRouteName('home');
		    $this->_rewrittingUrl = $this->_rewrittingUrlRepository->getByIdRouteUrl($this->_routeUrl->getId());
		    
		    header('location: ' . $this->_rewrittingUrl->getUrlMatched());
		    die();
		}
		// Sinon on récupère la route grâce à l'url rewritté
		else {
		    // Via cette url on récupère l'objet route correspondant
		    $this->_routeUrl = $this->_routeUrlRepository->getByControllerAction($this->_url['controller'], $this->_url['action']);
		}
	    }
	    $this->Manage404Route();
	}
	
	/**
	 * Manage404Route -> gère le routing vers la page 404 si la page n'existe pas
	 */
	public function Manage404Route(){
	    // On récupèrele nom du controller
	    $controllerTemp = isset($this->_routeUrl) ? $this->_routeUrl->getController() : "";
	    
	    // Si on est sur une page erreur OU si on a pas de module rewriting alors on récupère le controller et l'action via l'url directement
	    // Sinon on récupère le controller et l'action via l'objet routeurl
	    if(empty($controllerTemp) && (!self::$_databaseNeeded || !self::$_urlRewritingNeeded || $this->_isInErrorPage || (isset($this->_url['debug']) && $this->_url['debug'] == 'ok'))){
		$c =  $this->_CONTROLLER_NAMESPACE . ucwords($this->_url['controller'] . 'Controller');
		$c2 = str_replace($this->_FLF_NAMESPACE, '', $c) . '.php';
	    }
	    else {
		$c = $this->_CONTROLLER_NAMESPACE . ucwords($this->_routeUrl->getController() . 'Controller');
		$c2 = str_replace($this->_FLF_NAMESPACE, '', $c) . '.php';
	    }
	    
	    // On vérifie qu'on a une URL valide (rewritté ou non rewritté)
	    if(self::$_isDebugMode || !self::$_urlRewritingNeeded)
		$this->_isValidUrl = file_exists($c2) && class_exists($c);
	    else
		$this->_isValidUrl = $c != 'Controller' && file_exists($c2) && class_exists($c);
	    
	    // Si l'url n'existe pas on redirige vers la page 404
	    if((!$this->_isValidUrl && (!self::$_databaseNeeded || !self::$_urlRewritingNeeded)) || (!$this->_isValidUrl && $this->_routeUrl->getId() == 0) || ($this->_url["debug"] == "default" && $this->_page != '/')){
		cores\Logger::write("Redirection vers la page 404 sur l'url : " . $this->_page);
		
		// On récupère les objet routeurl et rewrittingurl de la page 404
		if(isset($this->_routeUrlRepository)){
		    $this->_routeUrl = $this->_routeUrlRepository->getByRouteName('error404');
		    $this->_rewrittingUrl = $this->_rewrittingUrlRepository->getByIdRouteUrl($this->_routeUrl->getId());
		}
		
		// Si on a pas le module rewriting alors on redirige vers l'url 404 brute
		// Sinon on redirige vers l'url 404 rewrité
		
		if((!self::$_databaseNeeded || !self::$_urlRewritingNeeded) || $this->_routeUrl->getId() == 0){
		    header('location: ' . __site_url__ . '/Home/error404');
		    die();
		}
		else{
		    header('location:' . cores\Router::ReplacePattern($this->_rewrittingUrl->getUrlMatched(), $this->_page));
		    die();
		}
	    }
	    
	    $this->ManageController();
	}
	
	/**
	 * ManageController -> set le nom du controller
	 * @throws ControllerException
	 */
	public function ManageController(){
	    // Si on est sur une page erreur ou si on a le module rewriting on récpère le nom du controller en brute
	    // Sinon on le récupère via l'objet routeurl

	    if(!self::$_databaseNeeded || !self::$_urlRewritingNeeded || $this->_isInErrorPage || ($this->_isValidUrl && $this->_routeUrl->getId() == 0))
		$this->_controllerName = $this->_CONTROLLER_NAMESPACE . $this->_url['controller'] . "Controller";
	    else
		$this->_controllerName = $this->_CONTROLLER_NAMESPACE . $this->_routeUrl->getController() . 'Controller';
	    
	    try {
		// On vérifie que le fichier de la classe de ce controller existe bien
		// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
		$controllerFile =  ($this->getControllerName()) . '.php';
		if(!file_exists(str_replace($this->_FLF_NAMESPACE, '', $controllerFile))){
		    if(self::$_isDebugMode)
			throw new adapters\ControllerException(adapters\ControllerException::NOT_FOUND, array('file' => $controllerFile));
		    else{
			header('location: /home/error404');
			die();
		    }
		}

		// On vérifie que la classe existe bien
		// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
		if(!class_exists(str_replace('.php', '', $controllerFile))){
		    if(self::$_isDebugMode)
			throw new adapters\ControllerException(adapters\ControllerException::INSTANCE_FAIL, array('controller' => $this->_controllerName));
		    else{
			header('location: /home/error404');
			die();
		    }
		}
	    }
	    catch(adapters\ControllerException $e){
		// On gère les erreur de façon personnalisée
		if($e->getType() == adapters\ControllerException::INSTANCE_FAIL){
		    cores\Logger::write(adapters\ControllerException::INSTANCE_FAIL . " : controllerInstanceFailed " . implode(' ', $e->getParams()));
		    $this->_errorManager->controllerInstanceFailed($e->getParams());
		    die();
		}
		else{
		    cores\Logger::write(adapters\ControllerException::NOT_FOUND . " : controllerClassDoesntExist " . implode(' ', $e->getParams()));
		    $this->_errorManager->controllerClassDoesntExist($e->getParams());
		    die();
		}
	    }
	    
	    $this->ManageAction();
	}
	
	/**
	 * ManageAction -> set le nom de l'action et instancie un nouveau controller
	 */
	public function ManageAction(){
	    // Si on est sur une page erreur ou si on a le module rewriting on récpère le nom de l'action en brute
	    // Sinon on le récupère via l'objet routeurl
	    if(!self::$_databaseNeeded || !self::$_urlRewritingNeeded || $this->_isInErrorPage || ($this->_isValidUrl && $this->_routeUrl->getId() == 0))
		$this->_actionName = $this->_url['action'];
	    else
		$this->_actionName = $this->_routeUrl->getAction();
	    
	    // On instancie le controller
	    $this->_controller = new $this->_controllerName($this->_actionName, $this->_repositoryManager);
	    
	    // On exécute l'action cible du controller et on affiche la vue avec le modèle renvoyé
	    try{
		$this->ExecuteAction();
	    }
	    catch(adapters\ControllerException $e){
		cores\Logger::write(adapters\ControllerException::ACTION_NOT_FOUND . " : actionDoesntExist " . implode(' ', $e->getParams()));
		$this->_errorManager->actionDoesntExist($e->getParams());
		die();
	    }
	    catch(adapters\ViewException $ex){
		if($ex->getType() == adapters\ViewException::NO_MODEL){
		    cores\Logger::write(adapters\ViewException::NO_MODEL . " : noModelProvided " . implode(' ', $ex->getParams()));
		    $this->_errorManager->noModelProvided($ex->getParams());
		    die();
		}
		else {
		    cores\Logger::write(adapters\ViewException::BAD_LAYOUT . " : layoutDoesntExist " . implode(' ', $ex->getParams()));
		    $this->_errorManager->layoutDoesntExist($ex->getParams());
		    die();
		}
	    }
	}
	
	/**
	 * ExecuteAction -> exécute l'action du controller instancié
	 * @throws ControllerException
	 */
	public function ExecuteAction(){
	    $actionName = $this->_actionName;
	    
	    // Si l'action n'existe pas, alors soit on lance une exeption en mode debug, soit on redirige vers la page 404 en mode non debug
	    if(!method_exists($this->_controllerName, $this->_actionName)){
		if(self::$_isDebugMode)
		    throw new adapters\ControllerException(adapters\ControllerException::ACTION_NOT_FOUND, array("controller" => $this->_url['controller'], "action" => $this->_url['action']));
		else{
		    header('location: /home/error404');
		    die();
		}
	    }
	    
	    // Si on a des paramètres dans l'url
	    if(isset($this->_url["params"])){
		// On exécute l'action
		$this->_controller->$actionName($this->_url["params"]);
	    }
	    else{
		// On exécute l'action
		$this->_controller->$actionName();
	    }
	}
	
	/**
	 * ManageAutoload -> gère l'autoload des class
	 * @param string $class
	 */
	public static function ManageAutoload($class){
	    $file = str_replace('fitzlucassen/FLFramework/', '', trim(str_replace(array('\\', '_'), '/', $class), '/')).'.php';
	    if(file_exists($file))
		require_once $file;
	}
	
	/**
	 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
	 * @throws ConnexionException
	 */
	public function ManageModuleException(){
	    // On ne lance les exceptions qu'en mode debug
	    if((self::$_isDebugMode && self::$_urlRewritingNeeded && self::$_databaseNeeded && !$this->_isInErrorPage)){
		if(!$this->_pdo->TableExist("header")){
		    cores\Logger::write(adapters\ConnexionException::NO_HEADER_TABLE_FOUND . " : noHeaderTableFound ");
		    $this->_errorManager->noHeaderTableFound(null);
		    die();
		}
		if(!$this->_pdo->TableExist("routeurl") && !$this->_pdo->TableExist("rewrittingurl")){
		    cores\Logger::write(adapters\ConnexionException::NO_URL_REWRITING_FOUND . " : noRewritingFound ");
		    $this->_errorManager->noRewritingFound(null);
		    die();
		}
		if(!$this->_pdo->TableExist("lang")){
		    cores\Logger::write(adapters\ConnexionException::NO_LANG_FOUND . " : noMultilingueFound ");
		    $this->_errorManager->noMultilingueFound(null);
		    die();
		}
	    }
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public function getRewrittingUrl(){
	    return $this->_rewrittingUrl;
	}
	public function getRouteUrl(){
	    return $this->_rewrittingUrl;
	}
	public function getRouteUrlRepository(){
	    return $this->_routeUrlRepository;
	}
	public function getControllerName(){
	    return $this->_controllerName;
	}
	public function getActionName(){
	    return $this->_actionName;
	}
	public function getIsDebugMode(){
	    return $this->_isDebugMode;
	}
	public function getPdo(){
	    return $this->_pdo;
	}
	public function getPage(){
	    return $this->_page;
	}
	public function getIsInErrorPage(){
	    return $this->_isInErrorPage;
	}
	
	/***********
	 * SETTERS *
	 ***********/
	public static function setIsDebugMode($arg){
	    self::$_isDebugMode = $arg;
	}
	public static function setDatabaseNeeded($arg){
	    self::$_databaseNeeded = $arg;
	}
	public static function setUrlRewritingNeeded($arg){
	    self::$_urlRewritingNeeded = $arg;
	}
    }