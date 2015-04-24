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
			
			$this->_rewrittingUrlRepository = $this->_repositoryManager->get('Rewrittingurl');
			$this->_routeUrlRepository = $this->_repositoryManager->get('Routeurl');
		}

		public function loadRoutes($clientUrl, $i18n){
			$this->_clientUrl = $clientUrl;
			
			// Si les langues ne sont pas encore en cache on requête en BDD
			if(!$langs = Cache::read("lang")){
				$langs = Data\Repository\LangRepository::getAll($this->_repositoryManager->getConnection());
				// On ecrit le résultat en cache
				Cache::write("lang", $langs);
				// Si on a pas de module multilingue on insère la langue par défaut
				if(count($langs) == 0)
					$langs = array(array('id' => 1, 'code' => Router::getDefaultLanguage()));
			}
		
			// Si les routes ne sont pas encore en cache on requête en BDD
			if(!$routes = Cache::read("routeurl")){
				$routes = Data\Repository\RouteUrlRepository::getAll($this->_repositoryManager->getConnection());
				// On ecrit le résultat en cache
				Cache::write("routeurl", $routes);
			}

			// On ajoute toutes les routes présentes en base de données au router
			foreach($langs as $thisLang){
				Router::addRange($routes, $thisLang->getCode(), $this->_repositoryManager->get('Rewrittingurl'));
				
				// Si on est sur une page de langue spécifique alors on change la langue en session
				if(strpos($this->_clientUrl, "/" . $thisLang->getCode() . "/") === 0){
					$this->_session->write("lang", $thisLang->getCode());
					$i18n->setLocale(Locale::getLocale($this->_session->read('lang')));
					$this->_langInUrl = true;
				}
			}
		}

		public function manageRootUrl(){				
			// S'il n'y a aucune route en base matchant l'url, ou que l'url est '/'
			if($this->_dispatchedUrl["debug"] == "default" && $this->_clientUrl == '/'){
				// On récupère la route de la homepage et on en déduit l'objet rewritting
				$this->_routeUrl = $this->_routeUrlRepository->getBy('name', 'home');
				$this->_routeUrl = is_array($this->_routeUrl) ? $this->_routeUrl[0] : $this->_routeUrl;
				$this->_rewrittingUrl = $this->_rewrittingUrlRepository->getBy('idRouteUrl', $this->_routeUrl->getId());
				$this->_rewrittingUrl = is_array($this->_rewrittingUrl) ? $this->_rewrittingUrl[0] : $this->_rewrittingUrl;
				
				Request::redirectTo($this->_rewrittingUrl->getUrlMatched());
			}
		}

		/***********
		 * GETTERS *
		 ***********/
		public function isLangInUrl(){
			return $this->_langInUrl;
		}

		/***********
		 * SETTERS *
		 ***********/

		public function setDispatchedUrl($url){
			$this->_dispatchedUrl = $url;
		}
	}
