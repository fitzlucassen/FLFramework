<?php
    class Router {
	private static $_routes = array();
	private static $_defaultController = "home";
	private static $_defaultAction = "index";
	private static $_defaultLang = "fr";
	private static $_regex = "A-Za-z0-9\-\.";
	private static $_langs = array();

	/**
	 * Add -> Ajoute une route à la collection
	 * @param type $lang
	 * @param type $controller
	 * @param type $action
	 * @param type $pattern
	 */
	public static function Add($lang, $controller, $action, $pattern) {
	    if (!isset(self::$_routes[$lang]))
		self::$_routes[$lang] = array();
	    array_push(self::$_routes[$lang], array("controller" => $controller, "action" => $action, "pattern" => $pattern));
	}
	
	/**
	 * AddRange -> ajoute une collection de route à la collection
	 * @param type $routes
	 * @param type $lang
	 * @param type $pdo
	 */
	public static function AddRange($routes, $lang, $pdo) {
	    if(!in_array($lang, self::$_langs)){
		self::$_langs[] = $lang;
	    }
	    foreach ($routes as $thisRoute){
		$url = RewrittingUrlRepository::getByIdRouteStatic($thisRoute['id'], $lang,$pdo);
		self::Add($lang, $thisRoute['controller'], $thisRoute['action'], $url->getUrlMatched());
	    }
	}
	
	/**
	 * FindRoute -> Retrouve une route dans la collection actuelle
	 * @param type $controller
	 * @param type $action
	 * @param type $lang
	 * @return boolean
	 */
	public static function FindRoute($controller, $action, $lang) {
	    foreach (self::GetRoutes(null, $lang) as $key => $value) {
		if ($value["controller"] == $controller && $value["action"] == $action)
		    return self::GetRoutes($key, $lang);
	    }
	    return false;
	}
	
	/**
	 * FindPattern -> Retrouve un pattern d'url selon une url réelle données
	 * @param type $pattern
	 * @param type $method
	 * @return boolean
	 */
	public static function FindPattern($pattern, $method = false) { // method is for anonymous params
	    if (!$method) {
		foreach (self::GetRoutes() as $key => $value) {
		    if ($value["pattern"] == $pattern)
			return self::GetRoutes($key);
		}
	    }
	    else {		
		$langInUrl = "";
		if(isset($pattern) && !empty($pattern)){
		    $langInUrl = false;
		    
		    foreach(self::$_langs as $thisLang){
			if(strpos($pattern, "/" . $thisLang . "/") === 0)
			    $langInUrl = $thisLang;			    
		    }
		    if(!$langInUrl)
			$langInUrl = self::$_defaultLang;
		}
		
		$array = self::GetRoutes(null, $langInUrl);
		foreach ($array as $key => $value) {
		    $regex = "#" . preg_replace("#{([" . self::$_regex . "]+)}#i", "([" . self::$_regex . "]+)", $value["pattern"]) . "#i";
		    if (preg_match($regex, $pattern, $matches)){
			if(isset($matches[1]) || isset($matches[0])){
			    $i = 1;
			    if(!isset($matches[1])){
				$i = 0;
			    }
			    if(empty($matches[$i]))
				return false;
			    
			    $index = strpos($pattern, $matches[$i]);
			    
			    if($i > 0){
				if($pattern == "/" || (strpos(substr($regex, 1), substr($pattern, 0, $index)) === 0))
				    return self::GetRoutes($key, $langInUrl);
			    }
			    else {
				if($pattern == "/" || (strpos(substr($regex, 1), $pattern) === 0)){
				    return self::GetRoutes($key, $langInUrl);
				}
			    }
			}
			else {
			    if($pattern == "/" || (strpos(substr($regex, 1), $pattern) === 0))
				return self::GetRoutes($key, $langInUrl);
			}
		    }
		}
	    }
	    return false;
	}
	
	/**
	 * ReplacePattern -> remplace dans l'url fournit tous les pattern d'argument par le paramètre replace
	 * @param type $url
	 * @param type $replace
	 * @return type
	 */
	public static function ReplacePattern($url, $replace){
	    $regex = '/\{[' . self::$_regex . ']+\}/';
	    
	    if (preg_match($regex, $url, $match)){
		return preg_replace($regex, $replace, $url);
	    }
	    else{
		return $url;
	    }
	}
	
	/**
	 * ReplaceParamsInUrl --> remplace tous les pattern d'argument d'une url par les vrai paramètres.
	 * @param type $url
	 * @param type $params
	 * @return type
	 */
	private static function ReplaceParamsInUrl($url, $params){
	    $newUrl = $url;
	    $regex = '/\{[' . self::$_regex . ']+\}/';
	    
	    foreach($params as $thisParam){
		$newUrl = preg_replace($regex, $thisParam, $newUrl, 1);	
	    }
	    
	    return $newUrl;
	}
	
	/**
	 * GetUrlByLang -> retourne un array contenant pour la langue française et anglaise l'url rewwritté.
	 * @param type $controller
	 * @param type $action
	 * @param type $params
	 * @return type
	 */
	public static function GetUrlByLang($controller, $action, $params){
	    $array = array();
	    foreach(self::$_langs as $thisLang){
		
		$array[$thisLang] = self::ReplaceParamsInUrl(self::FindRoute($controller, $action, $thisLang), $params);
	    }
	   return $array;
	}
	
	/***********
	 * Setters *
	 ***********/
	/**
	 * SetDefaultsRoutes
	 * @param type $defaultController
	 * @param type $defaultAction
	 */
	public static function SetDefaultsRoutes($defaultController, $defaultAction) {
	    self::$_defaultController = $defaultController;
	    self::$_defaultAction = $defaultAction;
	}
	
	/**
	 * SetRegex
	 * @param type $regex
	 */
	public static function SetRegex($regex) {
	    self::$_regex = $regex;
	}
	
	/**
	 * SetDefaultLanguage -> set la langue par défaut du site
	 * @param string $code
	 */
	public static function SetDefaultLanguage($code){
	    self::$_defaultLang = $code;
	}
	
	/**
	 * SetDefaultLanguage -> set la langue par défaut du site
	 * @param string $controller
	 */
	public static function SetDefaultController($controller){
	    self::$_defaultController = $controller;
	}
	
	/**
	 * SetDefaultLanguage -> set la langue par défaut du site
	 * @param string $action
	 */
	public static function SetDefaultAction($action){
	    self::$_defaultAction = $action;
	}

	/***********
	 * Getters *
	 ***********/
	/**
	 * GetDefaultLanguage -> retourne la langue par défaut
	 * @return type
	 */
	public static function GetDefaultLanguage(){
	    return self::$_defaultLang;
	}
	
	/**
	 * GetRoutes -> retourne la collecion de route actuelle
	 * @param type $key
	 * @param string $lang
	 * @return type
	 */
	public static function GetRoutes($key = null, $lang = null) {
	    if ($lang === null)
		$lang = self::$_defaultLang;
	    
	    return ($key === null) ?
		    ((isset(self::$_routes[$lang])) ? self::$_routes[$lang] : array() ) :
		    ((isset(self::$_routes[$lang][$key])) ? self::$_routes[$lang][$key] : false );
	}
	
	/**
	 * GetUrl -> récupère une url rewrité grâce à un controller et une action
	 * @param type $controller
	 * @param type $action
	 * @param type $params
	 * @param string $lang
	 * @return type
	 */
	public static function GetUrl($controller, $action, $params = null, $lang = null) {
	    if ($lang === null)
		$lang = self::$_defaultLang;
	    if ($route = self::FindRoute($controller, $action, $lang)) {
		$url = $route["pattern"];
		if ($params !== null)
		    foreach ($params as $key => $value)
			$url = str_replace("{" . $key . "}", $value, $url);
		return "/" . $lang . $url;
	    }
	    else {

		$url = "/" . $controller . "/" . $action;
		if ($params !== null)
		    foreach ($params as $value)
			$url .= "/" . $value;
		return "/" . $lang . $url;
	    }
	}

	/**
	 * GetRoute -> Récupère une route grâce à une URL rewrité
	 * @param type $pattern
	 * @return type
	 */
	public static function GetRoute($pattern) {
	    $pattern = explode("?", $pattern);
	    $pattern = $pattern[0];

	    if ($route = self::FindPattern(preg_replace("#{([" . self::$_regex . "]+)}#i", "{}", $pattern), true)) {
		$tab = preg_split("#[{}]#i", $route["pattern"]);
		if (count($tab) > 1) {
		    foreach ($tab as $key => $value) {
			if ($key % 2 == 1)
			    $paramsName[] = $value;
			else
			    $pattern = str_replace($value, "%", $pattern);
		    }
		    $paramsValue = explode("%", $pattern);
		    foreach ($paramsName as $key => $value)
			$params[$value] = $paramsValue[$key + 1];
		}
		else
		    $params = array();
		return array("controller" => $route["controller"], "action" => $route["action"], "params" => $params, "debug" => "ok");
	    }
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
    }