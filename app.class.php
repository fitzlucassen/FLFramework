<?php
	use fitzlucassen\FLFramework\Library\Adapter;
	use fitzlucassen\FLFramework\Library\Helper;
	use fitzlucassen\FLFramework\Library\Core;
	use fitzlucassen\FLFramework\Data;
	
	class App {
		// Url routing vars
		private $_dispatchedUrl = "";
		private $_clientUrl = "";
		
		// Boolean vars
		private $_isInErrorPage = false;
		private $_clientIsOnMobile = false;
		private $_isValidUrl = false;
		private static $_isDebugMode = false;
		private static $_isDatabaseNeeded = true;
		private static $_isUrlRewritingNeeded = true;
		private static $_supportedLanguages = [];
		
		// String vars
		private $_clientUserAgent = "";

		private $_moduleToInclude = [];

		// Helpers object
		private $_pdo = null;
		private $_session = null;
		private $_errorManager = null;
		private $_repositoryManager = null;
		private $_urlRewritingObject = null;
		private $_dispatcher = null;
		private $_moduleManager = null;
		private $_i18n = null;
		
		// Construction des objets et récupération des variables
		public function __construct() {
			$this->initialize();
			
			// Initialisation base de données sauf si on est sur une page d'erreur
			if(!isset($this->_pdo) && self::$_isDatabaseNeeded && !$this->_isInErrorPage){
				try{
					$this->_pdo = new Core\Sql();
					$this->_repositoryManager = new Core\RepositoryManager($this->_pdo, $this->_session->read('lang'));
					$this->_urlRewritingObject = new Core\UrlRewriting($this->_repositoryManager);
					
					// Initialise le module manager
					$this->_moduleManager = new Core\ModuleManager($this->_repositoryManager);
					$this->_moduleToInclude = $this->_moduleManager->getModuleToInclude(dirname(__FILE__) . DIRECTORY_SEPARATOR);
				}
				catch(Adapter\ConnexionException $e){
					$this->_errorManager->noConnexionAvailable();
					die();	
				}
			}
		}
		
		public function initialize(){
			// L'url cible
			$this->_clientUrl = $_SERVER['REQUEST_URI'];
			// Pour gérer les différents devices
			$this->_clientUserAgent = $_SERVER['HTTP_USER_AGENT'];
			$this->_clientIsOnMobile = (	preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$this->_clientUserAgent) || 
											preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($this->_clientUserAgent,0,4)));
			
			// On instancie le manager d'erreur
			$this->_errorManager = new Core\Error();
			// Initialisation de la session
			$this->_session = new Helper\Session();
			// Booléen permettant de savoir s on est sr une page erreur
			$this->_isInErrorPage = strpos($this->_clientUrl, '/Error/') !== false;
			// Initialisation du dispatcher
			$this->_dispatcher = new Core\Dispatcher();
			// Initialisation de l'internationalisation
			$this->_i18n = new Core\I18n('fr_FR', self::$_supportedLanguages);			
			
			// Si on a pas de langue on session on set celle par défaut
			if(!$this->_session->containsKey("lang"))
				$this->_session->write("lang", Core\Router::getDefaultLanguage());
		}
		
		/**
		 * run -> initialisation de l'app
		 */
		public function run(){	
			// On vérifie que tous les modules quasi indispensable sont inclus.
			// Si non on lance les exceptions adaptées
			$this->manageModuleException();
			
			$langInUrl = false;
			
			// On récupère les routes en base de données seulement si a une base de données
			// On vérifie si la langue est dans l'url
			// On initialise le module de traduction
			if(self::$_isDatabaseNeeded && self::$_isUrlRewritingNeeded && !$this->_isInErrorPage){
				$this->_urlRewritingObject->loadRoutes($this->_clientUrl, $this->_i18n);
				$langInUrl = $this->_urlRewritingObject->isLangInUrl();
				$this->_i18n->initialize();
			}
			
			// Si on est pas sur une page de langue spécifique, on set la langue par défaut en session
			if(!$langInUrl)
				$this->_session->write("lang", Core\Router::getDefaultLanguage());
			
			// On récupère le controller et l'action de l'url
			$this->_dispatchedUrl = Core\Router::getRoute($this->_clientUrl);
			$this->_dispatcher->setControllerFilePath($this->_dispatchedUrl['controller']);
			$this->_dispatcher->setAction($this->_dispatchedUrl['action']);
			$this->_isValidUrl = $this->_dispatcher->isValidUrl($this->_dispatchedUrl);

			// Si l'url demandée n'existe pas on redirige vers la 404
			if(!$this->_isValidUrl){
				$this->manage404();
			}
			else {
				if(!$this->_isInErrorPage){
					// On gère le cas ou l'url est '/' et que l'url de la home est différente
					$this->_urlRewritingObject->setDispatchedUrl($this->_dispatchedUrl);
					$this->_urlRewritingObject->manageRootUrl();
				}
				// Sinon on lance l'action du controller
				$this->manageAction();
			}
		}
		
		/**
		 * manage404 -> gère le routing vers la page 404 si la page n'existe pas
		 */
		public function manage404(){			
			try {
				// On vérifie que le fichier de la classe de ce controller existe bien
				// Sinon on lance une exception en mode debug OU on redirige vers la page 404 en mode non debug
				$this->_dispatcher->verifyController();
				$this->_dispatcher->verifyAction();
			}
			catch(Adapter\ControllerException $e){
				if(self::$_isDebugMode){
					// On gère les erreur de façon personnalisée
					if($e->getType() == Adapter\ControllerException::INSTANCE_FAIL){
						Core\Logger::write(Adapter\ControllerException::INSTANCE_FAIL . " : controllerInstanceFailed " . implode(' ', $e->getParams()));
						$this->_errorManager->controllerInstanceFailed($e->getParams());
						die();
					}
					else if($e->getType() == Adapter\ControllerException::ACTION_NOT_FOUND){
						Core\Logger::write(Adapter\ControllerException::ACTION_NOT_FOUND . " : actionDoesntExist " . implode(' ', $e->getParams()));
						$this->_errorManager->actionDoesntExist($e->getParams());
						die();
					}
					else{
						Core\Logger::write(Adapter\ControllerException::NOT_FOUND . " : controllerClassDoesntExist " . implode(' ', $e->getParams()));
						$this->_errorManager->controllerClassDoesntExist($e->getParams());
						die();
					}
				}
				else {
					$this->redirectTo404();
				}
			}
		}
		
		/**
		 * ManageAction -> set le nom de l'action et instancie un nouveau controller
		 */
		private function manageAction(){			
			// On exécute l'action cible du controller et on affiche la vue avec le modèle renvoyé
			try{
				$this->_dispatcher->executeAction($this->_dispatchedUrl, $this->_repositoryManager);
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
					$this->redirectTo404();
				}
			}
		}

		private function redirectTo404(){
			$this->_dispatcher->setControllerFilePath('Home');
			$this->_dispatcher->setAction('error404');
			$this->_dispatcher->dispatch('html', 404);
			die();
		}
		
		/**
		 * ManageAutoload -> gère l'autoload des class
		 * @param string $class
		 */
		public static function manageAutoload($class){
			$file = str_replace('fitzlucassen/FLFramework/', '', trim(str_replace(array('\\', '_'), '/', $class), '/')).'.php';
			if(file_exists($file))
				require_once $file;
		}
		
		/**
		 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
		 * @throws ConnexionException
		 */
		private function manageModuleException(){
			// On ne lance les exceptions qu'en mode debug
			if((self::$_isDebugMode && self::$_isUrlRewritingNeeded && self::$_isDatabaseNeeded && !$this->_isInErrorPage)){
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
		public function getClientUrl(){
			return $this->_clientUrl;
		}
		public function getIsInErrorPage(){
			return $this->_isInErrorPage;
		}
		public function getModuleToInclude(){
			return $this->_moduleToInclude;
		}
		
		/***********
		 * SETTERS *
		 ***********/
		public static function setIsDebugMode($arg){
			self::$_isDebugMode = $arg;
		}
		public static function setDatabaseNeeded($arg){
			self::$_isDatabaseNeeded = $arg;
		}
		public static function setUrlRewritingNeeded($arg){
			self::$_isUrlRewritingNeeded = $arg;
		}
		public static function setSupportedLanguages($args){
			self::$_supportedLanguages = $args;
		}
	}