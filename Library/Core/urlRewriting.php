<?php
	 
	namespace fitzlucassen\FLFramework\Library\Core;

	use fitzlucassen\FLFramework\Data;
	use fitzlucassen\FLFramework\Library\Helper;
	use fitzlucassen\FLFramework\Library\Adapter;

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

		private $_clientUrl;
		private $_dispatchedUrl;

		public function __construct($repositoryManager){
			$this->_session = new Helper\Session();
			$this->_repositoryManager = $repositoryManager;
			
			$this->_langRepository = $this->_repositoryManager->get('Lang');
			$this->_rewrittingUrlRepository = $this->_repositoryManager->get('Rewrittingurl');
			$this->_routeUrlRepository = $this->_repositoryManager->get('Routeurl');
		}

		public function loadRoutes($clientUrl){
			$this->_clientUrl = $clientUrl;
			
			// Si les langues ne sont pas encore en cache on requête en BDD
			if(!$langs = Cache::read("lang")){
				$langs = Data\Repository\LangRepository::getAll($this->_repositoryManager->getConnection());
				// On ecrit le résultat en cache
				Cache::write("lang", $langs);
				// Si on a pas de module multilingue on insère la langue par défaut
				if(count($langs) == 0)
					$langs = array(array('id' => 1, 'code' => Router::GetDefaultLanguage()));
			}
		
			// Si les routes ne sont pas encore en cache on requête en BDD
			if(!$routes = Cache::read("routeurl")){
				$routes = Data\Repository\RouteUrlRepository::getAll($this->_repositoryManager->getConnection());
				// On ecrit le résultat en cache
				Cache::write("routeurl", $routes);
			}

			// On ajoute toutes les routes présentes en base de données au router
			foreach($langs as $thisLang){
				Router::AddRange($routes, $thisLang->getCode(), $this->_repositoryManager->get('Rewrittingurl'));
				
				// Si on est sur une page de langue spécifique alors on change la langue en session
				if(strpos($this->_clientUrl, "/" . $thisLang->getCode() . "/") === 0){
					$this->_session->Write("lang", $thisLang->getCode());
					$this->_langInUrl = true;
				}
			}
		}

		public function isWrongRoute(){
			return !isset($this->_routeUrl) || !is_object($this->_routeUrl) || $this->_routeUrl->getId() == 0;
		}

		public function createRouteUrl(){				
			// S'il n'y a aucune route en base matchant l'url, ou que l'url est '/'
			if($this->_dispatchedUrl["debug"] == "default" && $this->_clientUrl == '/'){
				// On récupère la route de la homepage et on en déduit l'objet rewritting
				$this->_routeUrl = $this->_routeUrlRepository->getBy('name', 'home');
				$this->_routeUrl = is_array($this->_routeUrl) ? $this->_routeUrl[0] : $this->_routeUrl;
				$this->_rewrittingUrl = $this->_rewrittingUrlRepository->getBy('idRouteUrl', $this->_routeUrl->getId());
				$this->_rewrittingUrl = is_array($this->_rewrittingUrl) ? $this->_rewrittingUrl[0] : $this->_rewrittingUrl;
				
				Request::redirectTo($this->_rewrittingUrl->getUrlMatched());
			}
			// Sinon on récupère la route grâce à l'url rewritté
			else {
				// Via cette url on récupère l'objet route correspondant
				$this->_routeUrl = $this->_routeUrlRepository->getByControllerAction($this->_dispatchedUrl['controller'], $this->_dispatchedUrl['action']);
			}
		}

		public function redirectTo404(){
			// On récupère les objet routeurl et rewrittingurl de la page 404
			$this->_routeUrl = $this->_routeUrlRepository->getBy('name', 'error404');
			$this->_routeUrl = is_array($this->_routeUrl) ? $this->_routeUrl[0] : $this->_routeUrl;
			$this->_rewrittingUrl = $this->_rewrittingUrlRepository->getBy('idRouteUrl', $this->_routeUrl->getId());
			$this->_rewrittingUrl = is_array($this->_rewrittingUrl) ? $this->_rewrittingUrl[0] : $this->_rewrittingUrl;

			// TODO: debug this line
			Request::redirectTo(Router::ReplacePattern($this->_rewrittingUrl->getUrlMatched(), $this->_clientUrl), 404);
		}

		/***********
		 * GETTERS *
		 ***********/
		public function isLangInUrl(){
			return $this->_langInUrl;
		}
		public function getDispatchedUrl(){
			$this->_dispatchedUrl = Router::GetRoute($this->_clientUrl);
			return $this->_dispatchedUrl;
		}
		public function getClientUrl(){
			return $this->_clientUrl;
		}
		public function getController(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getController() : "";
		}

		public function getAction(){
			return isset($this->_routeUrl) ? $this->_routeUrl->getAction() : "";
		}
	}