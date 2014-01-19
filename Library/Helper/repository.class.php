<?php
    class Repository{
	private $_pdo;
	private $_lang;
	
	public function __construct($pdo, $lang){
	    $this->_pdo = $pdo;
	    $this->_lang = $lang;
	}
	
	public function get($name){
	    $repName = $name . 'Repository';
	    $rep = new $repName($this->_pdo, $this->_lang);
	    
	    return $rep;
	}
	
	public function getStatic($name){
	    $repName = $name . 'Repository';
	    $rep = $repName::getInstance($this->_pdo, $this->_lang);
	    
	    return $rep;
	}
    }