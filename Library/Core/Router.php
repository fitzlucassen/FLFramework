<?php
	namespace fitzlucassen\FLFramework\Library\Core;

	use fitzlucassen\FLFramework\Data\Repository;
	use fitzlucassen\FLFramework\Library\Adapter;
	
	/*
		Class : Router
		Déscription : Permet de gérer la couche du routing
	 */
	class Router {
		private static $_langs = array();
		private static $_routes = array();
		private static $_defaultController = "home";
		private static $_defaultAction = "index";
		private static $_defaultLang = "fr";
		private static $_regex = "A-Za-z0-9\-\.";

		/**
		 * Add -> Ajoute une route à la collection
		 * @param string $lang
		 * @param string $controller
		 * @param string $action
		 * @param string $pattern
		 */
		public static function add($lang, $name, $controller, $action, $pattern, $order) {
			if (!isset(self::$_routes[$lang]))
				self::$_routes[$lang] = array();
			array_push(self::$_routes[$lang], array("name" => $name, "controller" => $controller, "action" => $action, "pattern" => $pattern, 'order' => $order));
		}
		
		/**
		 * AddRange -> ajoute une collection de route à la collection
		 * @param array $routes
		 * @param string $lang
		 */
		public static function addRange($routes, $lang, $repository) {
			if(!in_array($lang, self::$_langs))
				self::$_langs[] = $lang;

			foreach ($routes as $thisRoute){
				$url = $thisRoute->getRewrittingurls($repository);
				$url = is_array($url) ? $url[0] : $url;

				if(is_array($url)){
					foreach ($url as $value) {
						if($value->getLang() == $lang){
							$url = $value;
							break;
						}
					}
				}

				self::add($lang, $thisRoute->getName(), $thisRoute->getController(), $thisRoute->getAction(), $url->getUrlMatched(), $thisRoute->getOrder() == null ? 0 : $thisRoute->getOrder());
			}
			self::$_routes[$lang] = Adapter\ArrayAdapter::orderBy(self::$_routes[$lang], 'order');
		}

		/**
		 * RedirectTo -> redirige vers l'url précisé
		 * @param string/array $url
		 */
		public static function redirectTo($url) {
			if(is_array($url)) {
				$controller = isset($url["controller"]) ? $url["controller"] : self::$_defaultController;
				$action = isset($url["action"]) ? $url["action"] : self::$_defaultAction;
				$lang = isset($url["lang"]) ? $url["lang"] : self::$_defaultLang;
				
				if(isset($url["params"])) {
					$redirect = GetUrlByLang($controller, $action, $url["params"]);
				}
				else {
					$redirect = GetUrlByLang($controller, $action, null);
				}
				Request::redirectTo($redirect[$lang]);
			}
			else
				Request::redirectTo($url);
		}
		
		/**
		 * ReplacePattern -> remplace dans l'url fournit tous les pattern d'argument par le paramètre replace
		 * @param string $url
		 * @param string $replace
		 * @return string
		 */
		public static function replacePattern($url, $replace, $limit = -1){
			$regex = '/\{[' . self::$_regex . ']+\}/';

			if (preg_match($regex, $url))
				return preg_replace($regex, $replace, $url, $limit);
			else
				return $url;
		}

		/**
		 * ReplaceParamsInUrl --> remplace tous les pattern d'argument d'une url par les vrai paramètres.
		 * @param string $url
		 * @param array $params
		 * @return string
		 */
		private static function replacePatternInUrl($url, $params){
			foreach($params as $thisParam){
				$url = self::replacePattern($url, $thisParam, 1);
			}
			
			return $url;
		}

		/**
		 * FindRoute -> Retrouve une route dans la collection actuelle
		 * @param string $controller
		 * @param string $action
		 * @param string $lang
		 * @return type
		 */
		private static function findRoute($controller, $action, $lang) {
			foreach (self::GetRoutes(null, $lang) as $key => $value) {
				if ($value["controller"] == $controller && $value["action"] == $action)
					return self::getRoutes($key, $lang);
			}
			return false;
		}

		/**
		 * FindPattern -> Retrouve une route grâce à une url
		 * @param string $pattern
		 * @param string $method
		 * @return type
		 */
		private static function findPattern($pattern, $method = false) { // method is for anonymous params
			// Si on a pas de paramètre dans l'url on peut se contenter de comparer les urls entre elles
			// Et renvoyé la route correspondante
			if (!$method) {
				foreach (self::getRoutes() as $key => $value) {
					if ($value["pattern"] == $pattern)
						return self::getRoutes($key);
				}
			}
			else {		
				$langInUrl = "";
				// Si l'url n'est pas vide
				// On récupère la lang de celle-ci
				if(!Adapter\StringAdapter::isNullOrEmpty($pattern)){
					$langInUrl = false;
					
					foreach(self::$_langs as $thisLang){
						if(strpos($pattern, "/" . $thisLang . "/") === 0)
							$langInUrl = $thisLang;
					}
					if(!$langInUrl)
						$langInUrl = self::$_defaultLang;
				}

				// On récupère toutes les routes de cette langue
				$array = self::getRoutes(null, $langInUrl);
				// Et pour chacune d'entre elles
				foreach ($array as $key => $value) {
					// Dans l'url de la route courante,
					// Je remplace quelque chose de cette forme /{login}/profile.html par quelque chose de cette forme /([a-zA-Z0-9]+)/profile.html
					$regex = "#" . preg_replace("#{([" . self::$_regex . "]+)}#i", "([" . self::$_regex . "]+)", $value["pattern"]) . "#i";

					// Si /([a-zA-Z0-9]+)/profile.html matche avec l'url courante
					if (preg_match($regex, $pattern, $matches) && isset($value["pattern"])){
						// S'il y a au moins un match
						if(isset($matches[0])){
							$i = count($matches) - 1;

							if(empty($matches[$i]))
								return false;

							// On récupère l'index du matche dans le pattern (si tout va bien, $index = 0)
							$index = strpos($pattern, $matches[$i]);
							
							// S'il y a bien un match et si les urls correspondent alors on retourne la route
							if(($i > 0 && $index !== false) || $pattern == "/")
								return self::getRoutes($key, $langInUrl);
						}
						if($pattern == "/" || (strpos(substr($regex, 1), $pattern) === 0))
							return self::getRoutes($key, $langInUrl);
					}
				}
			}
			return false;
		}



		/***********
		 * Getters *
		 ***********/


		
		/**
		 * GetRoutes -> retourne la collecion de route actuelle
		 * @param string $key
		 * @param string $lang
		 * @return type
		 */
		public static function getRoutes($key = null, $lang = null) {
			if ($lang === null)
				$lang = self::$_defaultLang;
			
			return 	($key === null) ?
						((isset(self::$_routes[$lang])) ? self::$_routes[$lang] : array() ) :
						((isset(self::$_routes[$lang][$key])) ? self::$_routes[$lang][$key] : false );
		}

		/**
		 * GetRoute -> Récupère une route grâce à une URL rewrité
		 * @param string $pattern
		 * @return type
		 */
		public static function getRoute($pattern) {
			// On ne récupère que l'url sans les paramètres GET
			$pattern = explode("?", $pattern);
			$pattern = $pattern[0];

			// Si on trouve une route correspondant à cette url
			if ($route = self::findPattern($pattern, true)) {
				$tab = preg_split("#[{}]#i", $route["pattern"]);
				// Si on a des paramètres dans l'url
				if (count($tab) > 1) {
					// Pour chacune des occurences
					foreach ($tab as $key => $value) {
						// Si c'est un index impaire alors c'est un paramètre
						// Sinon c'est une partie de l'url
						if ($key % 2 == 1)
							// On ajoute le nom du paramètre au tableau
							$paramsName[] = $value;
						else
							// On remplace la partie d'url par un %
							$pattern = str_replace($value, "%", $pattern);
					}
					// On récupère le tableau équivalent
					$paramsValue = explode("%", $pattern);
					// Pour chaque nom de paramètre
					foreach ($paramsName as $key => $value)
						// On ajoute sa valeur dans le tableau des paramètres
						$params[$value] = $paramsValue[$key + 1];
				}
				else
					$params = array();
				
				return array("controller" => $route["controller"], "action" => $route["action"], "params" => $params, "debug" => "ok");
			}
			// Sinon, on renvoi le couple controller/action supposé être demandé
			else {
				$route = array_values(array_filter(explode("/", $pattern)));
				$debug = array_key_exists(0, $route) && array_key_exists(1, $route) ? "ok" : "default";
				return array(
					"controller" => (array_key_exists(0, $route)) ? $route[0] : self::$_defaultController,
					"action" => (array_key_exists(1, $route)) ? $route[1] : self::$_defaultAction,
					"params" => array_slice($route, 2),
					"debug" => $debug
				);
			}
		}

		/**
		 * GetRouteByName -> Retrouve une route dans la collection actuelle
		 * @param string $name
		 * @param string $lang
		 * @return type
		 */
		public static function getRouteByName($name, $lang) {
			foreach (self::getRoutes(null, $lang) as $key => $value) {
				if ($value["name"] == $name)
					return self::getRoutes($key, $lang);
			}
			return false;
		}

		/**
		 * GetUrlsByLang -> retourne un array contenant pour la langue française et anglaise l'url réecrite.
		 * @param string $controller
		 * @param string $action
		 * @param array $params
		 * @return array
		 */
		public static function getUrlsByLang($controller, $action, $params) {
			$array = array();
			foreach(self::$_langs as $thisLang) {
				$route = self::findRoute($controller, $action, $thisLang);
				if(isset($route)){
					$array[$thisLang] = self::replacePatternInUrl($route['pattern'], $params);
				}
			}
		   return $array;
		}
		
		/**
		 * GetUrl -> récupère une url rewrité grâce à un controller et une action
		 * @param string $controller
		 * @param string $action
		 * @param array $params
		 * @param string $lang
		 * @return type
		 */
		public static function getUrl($controller, $action, $params = null, $lang = null) {
			if ($lang === null)
				$lang = self::$_defaultLang;
			if ($route = self::findRoute($controller, $action, $lang)) {
				return self::replacePatternInUrl($route['pattern'], $params);
			}
			else {
				$url = "/" . $controller . "/" . $action;
				if ($params !== null)
					foreach ($params as $value)
						$url .= "/" . $value;
				
				if($lang === self::$_defaultLang)
					return $url;
				else
					return "/" . $lang . $url;
			}
		}

		/**
		 * GetDefaultLanguage -> retourne la langue par défaut
		 * @return string
		 */
		public static function getDefaultLanguage(){
			return self::$_defaultLang;
		}



		/***********
		 * Setters *
		 ***********/



		/**
		 * SetDefaultsRoutes
		 * @param string $defaultController
		 * @param string $defaultAction
		 */
		public static function setDefaultsRoutes($defaultController, $defaultAction) {
			self::$_defaultController = $defaultController;
			self::$_defaultAction = $defaultAction;
		}
		
		/**
		 * SetRegex
		 * @param string $regex
		 */
		public static function setRegex($regex) {
			self::$_regex = $regex;
		}
		
		/**
		 * SetDefaultLanguage -> set la langue par défaut du site
		 * @param string $code
		 */
		public static function setDefaultLanguage($code){
			self::$_defaultLang = $code;
		}
		
		/**
		 * SetDefaultLanguage -> set la langue par défaut du site
		 * @param string $controller
		 */
		public static function setDefaultController($controller){
			self::$_defaultController = $controller;
		}
		
		/**
		 * SetDefaultLanguage -> set la langue par défaut du site
		 * @param string $action
		 */
		public static function setDefaultAction($action){
			self::$_defaultAction = $action;
		}
	}
