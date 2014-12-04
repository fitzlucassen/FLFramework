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
    	private $_rewrittingUrlRepository = null;
    	private $_routeUrl = null;
    	private $_rewrittingUrl = null;

    	private $_repositoryManager = null;

    	private $_langInUrl = false;

    	private $_page;
    	private $_url;

    	public function __construct($repo){
    		$this->_session = new Helper\Session();
    		$this->_repositoryManager = $repo;
    		
    		$this->_langRepository = $this->_repositoryManager->get('Lang');
    		$this->_rewrittingUrlRepository = $this->_repositoryManager->get('Rewrittingurl');
    		$this->_routeUrlRepository = $this->_repositoryManager->get('Routeurl');
    	}

		public function loadRoutes($page){
			
			$this->_page = $page;
			
			// Si les langues ne sont pas encore en cache on requête en BDD
			if(!$langs = Cache::read("lang")){
			    $langs = Data\Repository\LangRepository::getAll($this->_repositoryManager->getConnection());
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
					$routes = Data\Repository\RouteUrlRepository::getAll($this->_repositoryManager->getConnection());
					// On ecrit le résultat en cache
					Cache::write("routeurl", $routes);
			    }
			    Router::AddRange($routes, $thisLang->getCode());
			    
			    // Si on est sur une page de langue spécifique alors on change la langue en session
			    if(strpos($this->_page, "/" . $thisLang->getCode() . "/") === 0){
					$this->_session->Write("lang", $thisLang->getCode());
					$this->_langInUrl = true;
			    }
			}
			return $this->_langInUrl;
		}

		public function isWrongRoute(){
			return $this->_routeUrl->getId() == 0;
		}

		public function createRouteUrl(){				
			// S'il n'y a aucune route en base matchant cette url, ou que l'url est '/'
			if(!isset($this->_url['controller']) || empty($this->_url['controller']) || ($this->_url["debug"] == "default" && $this->_page == '/')){
			    // On récupère la route de la homepage et on en déduit l'objet rewritting
			    $this->_routeUrl = $this->_routeUrlRepository->getBy('name', 'home');
			    $this->_routeUrl = $this->_routeUrl[0];
			    $this->_rewrittingUrl = $this->_rewrittingUrlRepository->getBy('idRouteUrl', $this->_routeUrl->getId());
			    $this->_rewrittingUrl = $this->_rewrittingUrl[0];
			    
			    header('location: ' . $this->_rewrittingUrl->getUrlMatched());
			    die();
			}
			// Sinon on récupère la route grâce à l'url rewritté
			else {
			    // Via cette url on récupère l'objet route correspondant
			    $this->_routeUrl = $this->_routeUrlRepository->getByControllerAction($this->_url['controller'], $this->_url['action']);
			}
		}

		public function redirectTo404(){
			// On récupère les objet routeurl et rewrittingurl de la page 404
		    $this->_routeUrl = $this->_routeUrlRepository->getBy('name', 'error404');
		    $this->_rewrittingUrl = $this->_rewrittingUrlRepository->getBy('idRouteUrl', $this->_routeUrl->getId());

		    header('location:' . Router::ReplacePattern($this->_rewrittingUrl->getUrlMatched(), $this->_page));
		    die();
		}

		/***********
		 * GETTERS *
		 ***********/
		public function getUrl(){
			$this->_url = $this->_rewrittingUrlRepository->getByUrlMatched($this->_page);
		    return $this->_url;
		}
		public function getPage(){
			return $this->_page;
		}
		public function getController(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getController() : "";
		}

		public function getAction(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getAction() : "";
		}

		/***********
		 * SETTERS *
		 ***********/

	}