<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    use fitzlucassen\FLFramework\Data;
    use fitzlucassen\FLFramework\Library\Helper;

    /*
      Class : UrlRewriting
      Déscription : 
     */
    class UrlRewriting {
    	private $_langRepository = null;
    	private $_routeUrlRepository = null;
    	private $_routeUrl = null;
    	private $_rewrittingUrl = null;
    	private $_repositoryManager = null;
    	private $_langInUrl = false;
    	private $_pdo = null;

    	private static $_rewrittingUrlRepository = null;
    	private $_page;

    	public function __construct($pdo){
    		$this->_pdo = $pdo;
    		$this->_session = new Helper\Session();
    		$this->_repositoryManager = new RepositoryManager($pdo, $this->_session->Read("lang"));
    	}

		public function loadRoutes($page){
			$this->_langRepository = $this->_repositoryManager->get('Lang');
			$this->_page = $page;
			
			// Si les langues ne sont pas encore en cache on requête en BDD
			if(!$langs = Cache::read("lang")){
			    $langs = Data\Repository\LangRepository::getAll($this->_pdo);
			    // On ecrit le résultat en cache
			    Cache::write("lang", $langs);
			    // Si on a pas de module multilingue on insère la langue par défaut
			    if(count($langs) == 0)
					$langs = array(array('id' => 1, 'code' => Router::GetDefaultLanguage()));
			}
		
			// On ajoute toutes les routes présentes en base de données au router
			foreach($langs as $thisLang){
			    // Si les routes ne sont pas encore en cache on requête en BDD
			    if(!$routes = Cache::read("routeurl")){
					$routes = Data\Repository\RouteUrlRepository::getAll($this->_pdo);
					// On ecrit le résultat en cache
					Cache::write("routeurl", $routes);
			    }
			    Router::AddRange($routes, $thisLang->getCode(), $this->_pdo);
			    
			    // Si on est sur une page de langue spécifique alors on change la langue en session
			    if(strpos($this->_page, "/" . $thisLang->getCode() . "/") === 0){
					$this->_session->Write("lang", $thisLang->getCode());
					$this->_langInUrl = true;
			    }
			}
		}

		public function manageLang(){
			// Si on est pas sur une page de langue spécifique, on set la langue par défaut en session
		    if(!$this->_langInUrl)
				$this->_session->Write("lang", Router::GetDefaultLanguage());
		    
		    return $this->_session->Read("lang");
		}

		public function isValidUrl($c, $c2, $debug, $urlRewritingNeeded){
			if($debug || !$urlRewritingNeeded)
				return file_exists($c2) && class_exists($c);
		    else
				return $c != 'Controller' && file_exists($c2) && class_exists($c);
		}

		public function isWrongRoute(){
			return $this->_routeUrl->getId() == 0;
		}

		public function redirectTo404IfNeeded($isValidUrl, $databaseNeeded, $urlRewritingNeeded, $url){
			// Si l'url n'existe pas on redirige vers la page 404
		    if((!$isValidUrl && (!$databaseNeeded || !$urlRewritingNeeded)) || (!$isValidUrl && $this->_routeUrl->getId() == 0) || ($url["debug"] == "default" && $this->_page != '/')){
				Logger::write("Redirection vers la page 404 sur l'url : " . $this->_page);
			
				// On récupère les objet routeurl et rewrittingurl de la page 404
				if(isset($this->_routeUrlRepository)){
				    $this->_routeUrl = $this->_routeUrlRepository->getByRouteName('error404');
				    $this->_rewrittingUrl = $this->_rewrittingUrlRepository->getByIdRouteUrl($this->_routeUrl->getId());
				}
				
				// Si on a pas le module rewriting alors on redirige vers l'url 404 brute
				// Sinon on redirige vers l'url 404 rewrité
				
				if((!$databaseNeeded || !$urlRewritingNeeded) || $this->_routeUrl->getId() == 0){
				    header('location: ' . __site_url__ . '/Home/error404');
				    die();
				}
				else{
				    header('location:' . Router::ReplacePattern($this->_rewrittingUrl->getUrlMatched(), $this->_page));
				    die();
				}
		    }
		}

		/***********
		 * GETTERS *
		 ***********/
		public static function getUrl($page, $db, $errorPage, $repositoryManager){
			$url = "";
			// On récupère le controller et l'action de l'url
		    if($db && !$errorPage){
				self::$_rewrittingUrlRepository = $repositoryManager->get('RewrittingUrl');
				$url = self::$_rewrittingUrlRepository->getByUrlMatched($page);
		    }
		    else {
				$url = Router::GetRoute($page);
		    }
		    return $url;
		}

		public function getRouteUrl($url){
			$this->_routeUrlRepository = $this->_repositoryManager->get('RouteUrl');
				
			// S'il n'y a aucune route en base matchant cette url, ou que l'url est '/'
			if(!isset($url['controller']) || empty($url['controller']) || ($url["debug"] == "default" && $this->_page == '/')){
			    // On récupère la route de la homepage et on en déduit l'objet rewritting
			    $this->_routeUrl = $this->_routeUrlRepository->getByRouteName('home');
			    $this->_rewrittingUrl = self::$_rewrittingUrlRepository->getByIdRouteUrl($this->_routeUrl->getId());
			    
			    header('location: ' . $this->_rewrittingUrl->getUrlMatched());
			    die();
			}
			// Sinon on récupère la route grâce à l'url rewritté
			else {
			    // Via cette url on récupère l'objet route correspondant
			    $this->_routeUrl = $this->_routeUrlRepository->getByControllerAction($url['controller'], $url['action']);
			}
		}

		public function getController(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getController() : "";
		}

		public function getAction(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getAction() : "";
		}

		public function getControllerName($validUrl, $db, $rewriteNeeded, $errorPage){
			if(!$db || !$rewriteNeeded || $errorPage || ($validUrl && $this->_routeUrl->getId() == 0))
				return $this->_CONTROLLER_NAMESPACE . $url['controller'] . "Controller";
		    else
				return $this->_CONTROLLER_NAMESPACE . $this->_routeUrl->getController() . 'Controller';
		}
	}