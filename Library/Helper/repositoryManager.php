<?php
    namespace fitzlucassen\FLFramework\Library\Helper;

    /*
      Class : RepositoryManager
      Déscription : Permet de gérer la couche repository
     */
    class RepositoryManager{
	private $_REPOSITORY_NAMESPACE = "fitzlucassen\FLFramework\Data\Repository\\";
	private $_pdo;
	private $_lang;
	
	public function __construct($pdo, $lang){
	    $this->_pdo = $pdo;
	    $this->_lang = $lang;
	}
	
	/**
	 * get --> retourne l'objet repository cible
	 * @param string $name
	 * @return \fitzlucassen\FLFramework\Data\Repository
	 */
	public function get($name){
	    $repName = $this->_REPOSITORY_NAMESPACE . $name . "Repository";
	    $rep = new $repName($this->_pdo, $this->_lang);
	    
	    return $rep;
	}
	
	/**
	 * getStatic --> retourne l'objet repository cible
	 * @param string $name
	 * @return \fitzlucassen\FLFramework\Data\Repository
	 */
	public function getStatic($name){
	    $repName = $this->_REPOSITORY_NAMESPACE . $name . 'Repository';
	    $rep = $repName::getInstance($this->_pdo, $this->_lang);
	    
	    return $rep;
	}
    }