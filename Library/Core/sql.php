<?php

    namespace fitzlucassen\FLFramework\Library\Core;
    
    use fitzlucassen\FLFramework\Library\Adapter;

    /*
      Class : SQL
      Déscription : Permet de gérer les données en base
     */
    class Sql{
		private static $_db = '';					// base de données 
		private static $_host = '';					// adresse de la base 
		private static $_user = '';					// nom 
		private static $_pwd = '';					// mot de passe 
		private $_con = '';							// connexion PDO
		private $_email = 'contact@flframework.fr';	// email de l'admin du site 
		
		/*
		 * Constructeur
		 */
		public function __construct() {
		    try  
		    {
				$this->_con = new \PDO($this->GetDns(), self::$_user, self::$_pwd, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

				// pour mysql on active le cache de requête 
				if($this->_con->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'mysql') 
				    $this->_con->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
		    } 
		    catch(\PDOException $e) { 
				//On indique par email qu'on n'a plus de connection disponible 
				throw new Adapter\ConnexionException(Adapter\ConnexionException::getNO_DB_FOUND(), null);
		    } 
		}
		
		/**
		 * Select -> Pour un select simple (un seul résultat)
		 * @param string $reqSelect
		 * @return array
		 */
		public function Select($reqSelect) { 
		    try 
		    { 
				$this->_con->beginTransaction();
				$result = $this->_con->prepare($reqSelect); 
				$result->execute(); 
				$this->_con->commit();
				
				return $result->fetch(\PDO::FETCH_ASSOC); 
		    } 
		    catch (\Exception $e)  
		    { 
				//On indique par email que la requête n'a pas fonctionné. 
				$this->_con->rollBack(); 
				throw new Adapter\ConnexionException(Adapter\ConnexionException::getQUERY_FAILED(), array("message" => $e->getMessage()));
		    } 
		}
		
		/**
		 * SelectTable -> Pour un select multiple (plusieurs résultat)
		 * @param string $reqSelect
		 * @return array
		 */
		public function SelectTable($reqSelect) {
			try 
		    { 
			    $this->_con->beginTransaction();
			    $result = $this->_con->prepare($reqSelect); 
			    $result->execute();
			    $this->_con->commit();
			    
			    /* Récupération de toutes les lignes d'un jeu de résultats "équivalent à mysql_num_row() " */ 
			    $resultat = $result->fetchAll(); 
			    return $resultat; 
			}
			catch (\Exception $e)  
		    { 
				//On indique par email que la requête n'a pas fonctionné. 
				$this->_con->rollBack(); 
				throw new Adapter\ConnexionException(Adapter\ConnexionException::getQUERY_FAILED(), array("message" => $e->getMessage()));
		    } 
		} 
		
		/**
		 * TableExist --> Retourne vrai si la table existe en bdd, faux sinon
		 * @param string $table
		 * @return boolean
		 */
		public function TableExist($table){
		    $all_tables = $this->SelectTable("SHOW TABLES FROM " . self::$_db);
		    $found = false;
		    
		    foreach($all_tables as $thisTable){
				$found = $thisTable['Tables_in_' . self::$_db] == $table;
				if($found)
				    break;
		    }

		    return $found;
		}
		
		/***********
		 * GETTERS *
		 ***********/
		/**
		 * GetConnection -> Retourne l'objet connexion
		 * @return type
		 */
		public function GetConnection() {
		    return $this->_con;
		}
		/**
		 * GetDns -> On récupète l'host ici
		 * @return type
		 */
		public function GetDns() { 
		    return 'mysql:host=' . self::$_host . ';dbname=' . self::$_db; 
		}
		/**
		 * GetDb -> On récupère la db
		 * @return type
		 */
		public static function GetDb() { 
		    return $this->_db; 
		}
		/**
		 * GetHost -> On récupère l'host
		 * @return type
		 */
		public static function GetHost() { 
		    return $this->_host; 
		}
		/**
		 * GetUser -> On récupère l'user
		 * @return type
		 */
		public static function GetUser() { 
		    return $this->_user; 
		}
		/**
		 * GetPwd -> On récupère le pwd
		 * @return type
		 */
		public static function GetPwd() { 
		    return $this->_pwd; 
		}
		
		/***********
		 * SETTERS *
		 ***********/
		/**
		 * SetDb -> set la base de donnée
		 * @param type $arg
		 */
		public static function SetDb($arg){
		    self::$_db = $arg;
		}
		/**
		 * SetHost -> set l'host
		 * @param type $arg
		 */
		public static function SetHost($arg){
		    self::$_host = $arg;
		}
		/**
		 * SetUser -> set le user
		 * @param type $arg
		 */
		public static function SetUser($arg){
		    self::$_user = $arg;
		}
		/**
		 * SetPwd -> set le mot de passe
		 * @param type $arg
		 */
		public static function SetPwd($arg){
		    self::$_pwd = $arg;
		}
    }
