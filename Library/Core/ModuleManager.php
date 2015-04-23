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

		public function getModuleToInclude($root){
			$dir = $root . __module_directory__;
			$array = [];

			foreach (scandir($dir) as $path) {
				if(file_exists($dir . '/' . $path . '/main.php')){
					array_push($array, $dir . '/' . $path . '/main.php');
				}
			}
			return $array;
		}

		/**
		 * ManageModuleException -> vérifie que les modules quasi indispensable sont bien inclus
		 * @throws ConnexionException
		 */
		public function manageNativeModuleException(){
			$pdo = $this->_repositoryManager->getConnection();
			// On ne lance les exceptions qu'en mode debug
			if(!$pdo->tableExist("header")){
				Logger::write(Adapter\ConnexionException::NO_HEADER_TABLE_FOUND . " : noHeaderTableFound ");
				$this->_errorManager->noHeaderTableFound(null);
				die();
			}
			if(!$pdo->tableExist("routeurl") && !$this->_pdo->tableExist("rewrittingurl")){
				Logger::write(Adapter\ConnexionException::NO_URL_REWRITING_FOUND . " : noRewritingFound ");
				$this->_errorManager->noRewritingFound(null);
				die();
			}
			if(!$pdo->tableExist("lang")){
				Logger::write(Adapter\ConnexionException::NO_LANG_FOUND . " : noMultilingueFound ");
				$this->_errorManager->noMultilingueFound(null);
				die();
			}
		}
	}
