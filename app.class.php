<?php
	use fitzlucassen\FLFramework\Library\Adapter;
	use fitzlucassen\FLFramework\Library\Helper;
	use fitzlucassen\FLFramework\Library\Core;
	
	use fitzlucassen\FLFramework\Data;
	
	class App {
		// Url routing vars
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
		private $_userAgent = "";

		// Helpers object
		private $_pdo = null;
		private $_session = null;
		private $_errorManager = null;
		private $_repositoryManager = null;
		private $_urlRewritingObject = null;
		private $_dispatcher = null;
		private $_moduleManager = null;
		
		// Construction des objets et récupération des variables
		public function __construct() {
			$this->initialize();
			
			// Initialisation base de données sauf si on est sur une page d'erreur
			if(!isset($this->_pdo) && self::$_databaseNeeded && !$this->_isInErrorPage){
				try{
					$this->_pdo = new Core\Sql();
					$this->_repositoryManager = new Core\RepositoryManager($this->_pdo, $this->_session->read('lang'));
					$this->_urlRewritingObject = new Core\UrlRewriting($this->_repositoryManager);
					Core\Router::SetRepositoryManager($this->_repositoryManager);

					// Initialise le module manager
					$this->_moduleManager = new Core\ModuleManager($this->_repositoryManager);
				}
				catch(Adapter\ConnexionException $e){
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
			$this->_errorManager = new Core\Error();
			// Initialisation de la session
			$this->_session = new Helper\Session();
			// Booléen permettant de savoir s on est sr une page erreur
			$this->_isInErrorPage = strpos($this->_page, '/Error/') !== false;
			// Initialisation du dispatcher
			$this->_dispatcher = new Core\Dispatcher();
			
			
			// Si on a pas de langue on session on set celle par défaut
			if(!$this->_session->ContainsKey("lang"))
				$this->_session->Write("lang", Core\Router::GetDefaultLanguage());
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
			if(self::$_databaseNeeded && self::$_urlRewritingNeeded && !$this->_isInErrorPage){
				$langInUrl = $this->_urlRewritingObject->loadRoutes($this->_page);
			}
			
			// Si on est pas sur une page de langue spécifique, on set la langue par défaut en session
			if(!$langInUrl)
				$this->_session->Write("lang", Core\Router::GetDefaultLanguage());
			
			// On récupère le controller et l'action de l'url
			if(self::$_databaseNeeded && self::$_urlRewritingNeeded && !$this->_isInErrorPage){
				$this->_url = $this->_urlRewritingObject->getUrl();
			}
			else {
				$this->_url = Core\Router::GetRoute($this->_page);
			}
			
			if(self::$_databaseNeeded && self::$_urlRewritingNeeded && !$this->_isInErrorPage){
				$this->_urlRewritingObject->createRouteUrl();
			}
			$this->Manage404();
			$this->ManageAction();
		}
		
		/**
		 * Manage404Route -> gère le routing vers la page 404 si la page n'existe pas
		 */
		public function Manage404(){
			// On récupèrele nom du controller
			$controllerTemp = (self::$_databaseNeeded && self::$_urlRewritingNeeded && !$this->_isInErrorPage) ? $this->_urlRewritingObject->getController() : "";
			
			// Si on est sur une page erreur OU si on a pas de module rewriting alors on récupère le controller et l'action via l'url directement
			// Sinon on récupère le controller et l'action via l'objet routeurl
			if(empty($controllerTemp)){
				$controllerTemp = $this->_url['controller'];
			}
			$paths = $this->_dispatcher->getControllerFilePath($controllerTemp);
			
			try {
				// On vérifie que le fichier de la classe de ce controller existe bien
				// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
				$this->_dispatcher->manageController();
			}
			catch(Adapter\ControllerException $e){
				if(self::$_isDebugMode){
					// On gère les erreur de façon personnalisée
					if($e->getType() == Adapter\ControllerException::INSTANCE_FAIL){
						Core\Logger::write(Adapter\ControllerException::INSTANCE_FAIL . " : controllerInstanceFailed " . implode(' ', $e->getParams()));
						$this->_errorManager->controllerInstanceFailed($e->getParams());
						die();
					}
					else{
						Core\Logger::write(Adapter\ControllerException::NOT_FOUND . " : controllerClassDoesntExist " . implode(' ', $e->getParams()));
						$this->_errorManager->controllerClassDoesntExist($e->getParams());
						die();
					}
				}
				else {
					// On récupère les objet routeurl et rewrittingurl de la page 404
					if(self::$_databaseNeeded && self::$_urlRewritingNeeded){
						$this->_urlRewritingObject->redirectTo404();
					}
					else {
						$this->_dispatcher->redirectTo404();
					}
				}
			}
		}
		
		/**
		 * ManageAction -> set le nom de l'action et instancie un nouveau controller
		 */
		public function ManageAction(){
			$this->_isValidUrl = $this->_dispatcher->isValidUrl($this->_url);

			// Si on est sur une page erreur ou si on a le module rewriting on récpère le nom de l'action en brute
			// Sinon on le récupère via l'objet routeurl
			if(!self::$_databaseNeeded || !self::$_urlRewritingNeeded || $this->_isInErrorPage || ($this->_isValidUrl && $this->_urlRewritingObject->isWrongRoute()))
				$actionName = $this->_url['action'];
			else
				$actionName = $this->_urlRewritingObject->getAction();

			$this->_dispatcher->manageAction($actionName, $this->_repositoryManager);
			
			// On exécute l'action cible du controller et on affiche la vue avec le modèle renvoyé
			try{
				$this->_dispatcher->executeAction($this->_url);
			}
			catch(Adapter\ControllerException $e){
				if(self::$_isDebugMode){
					Core\Logger::write(Adapter\ControllerException::ACTION_NOT_FOUND . " : actionDoesntExist " . implode(' ', $e->getParams()));
					$this->_errorManager->actionDoesntExist($e->getParams());
					die();
				}
				else {
					// On récupère les objet routeurl et rewrittingurl de la page 404
					if(self::$_databaseNeeded && self::$_urlRewritingNeeded){
						$this->_urlRewritingObject->redirectTo404();
					}
					else {
						$this->_dispatcher->redirectTo404();
					}
				}
			}
			catch(Adapter\ViewException $ex){
				if(self::$_isDebugMode){
					if($ex->getType() == Adapter\ViewException::NO_MODEL){
						Core\Logger::write(Adapter\ViewException::NO_MODEL . " : noModelProvided " . implode(' ', $ex->getParams()));
						$this->_errorManager->noModelProvided($ex->getParams());
						die();
					}
					else {
						Core\Logger::write(Adapter\ViewException::BAD_LAYOUT . " : layoutDoesntExist " . implode(' ', $ex->getParams()));
						$this->_errorManager->layoutDoesntExist($ex->getParams());
						die();
					}
				}
				else {
					// On récupère les objet routeurl et rewrittingurl de la page 404
					if(self::$_databaseNeeded && self::$_urlRewritingNeeded){
						$this->_urlRewritingObject->redirectTo404();
					}
					else {
						$this->_dispatcher->redirectTo404();
					}
				}
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
				$this->_moduleManager->manageNativeModuleException();
			}
		}
		
		/***********
		 * GETTERS *
		 ***********/
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