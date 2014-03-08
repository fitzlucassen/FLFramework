<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    /*
      Class : ModuleManager
      Déscription : 
     */
    class ModuleManager {
   		private $_errorManager;

    	public function __construct(){
			$this->_errorManager = new Error();
    	}

    	/**
		 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
		 * @throws ConnexionException
		 */
		public function manageNativeModuleException($pdo){
		    // On ne lance les exceptions qu'en mode debug
			if(!$pdo->TableExist("header")){
			    Logger::write(Adapter\ConnexionException::NO_HEADER_TABLE_FOUND . " : noHeaderTableFound ");
			    $this->_errorManager->noHeaderTableFound(null);
			    die();
			}
			if(!$pdo->TableExist("routeurl") && !$this->_pdo->TableExist("rewrittingurl")){
			    Logger::write(Adapter\ConnexionException::NO_URL_REWRITING_FOUND . " : noRewritingFound ");
			    $this->_errorManager->noRewritingFound(null);
			    die();
			}
			if(!$pdo->TableExist("lang")){
			    Logger::write(Adapter\ConnexionException::NO_LANG_FOUND . " : noMultilingueFound ");
			    $this->_errorManager->noMultilingueFound(null);
			    die();
			}
		}
	}