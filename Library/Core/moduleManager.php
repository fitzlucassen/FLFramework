<?php
	 
	namespace fitzlucassen\FLFramework\Library\Core;

	use fitzlucassen\FLFramework\Library\Adapter;

	/*
		Class : ModuleManager
		Déscription : 
	 */
	class ModuleManager {
		private $_errorManager;
		private $_repositoryManager;

		public function __construct($repo){
			$this->_errorManager = new Error();
			$this->_repositoryManager = $repo;
		}

		/**
		 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
		 * @throws ConnexionException
		 */
		public function manageNativeModuleException(){
			$pdo = $this->_repositoryManager->getConnection();
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