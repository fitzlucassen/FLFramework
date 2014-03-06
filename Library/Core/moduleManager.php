<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    use fitzlucassen\FLFramework\Library\Core;

    /*
      Class : ModuleManager
      Déscription : 
     */
    class ModuleManager {
    	private $_isDebugMode = false;
    	private $_urlRewritingNeeded = true;
    	private $_databaseNeeded = true;
    	private $_isInErrorPage = false;
    	private $_pdo;
   		private $_errorManager;

    	public function __construct($debug = false, $urlrewrite = true, $db = true, $errorpage = false){
			$this->_isDebugMode = $debug;
			$this->_urlRewritingNeeded = $urlrewrite;
			$this->_databaseNeeded = $db;
			$this->_isInErrorPage = $errorpage;

			$_errorManager = new Error();

			if($this->_urlRewritingNeeded && $this->_databaseNeeded)
				$this->_pdo = new Sql();
    	}

    	/**
		 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
		 * @throws ConnexionException
		 */
		public function manageModuleException(){
		    // On ne lance les exceptions qu'en mode debug
		    if(($this->_isDebugMode && $this->_urlRewritingNeeded && $this->_databaseNeeded && !$this->_isInErrorPage)){
				if(!$this->_pdo->TableExist("header")){
				    Core\Logger::write(Adapter\ConnexionException::NO_HEADER_TABLE_FOUND . " : noHeaderTableFound ");
				    $this->_errorManager->noHeaderTableFound(null);
				    die();
				}
				if(!$this->_pdo->TableExist("routeurl") && !$this->_pdo->TableExist("rewrittingurl")){
				    Core\Logger::write(Adapter\ConnexionException::NO_URL_REWRITING_FOUND . " : noRewritingFound ");
				    $this->_errorManager->noRewritingFound(null);
				    die();
				}
				if(!$this->_pdo->TableExist("lang")){
				    Core\Logger::write(Adapter\ConnexionException::NO_LANG_FOUND . " : noMultilingueFound ");
				    $this->_errorManager->noMultilingueFound(null);
				    die();
				}
		    }
		}
	}