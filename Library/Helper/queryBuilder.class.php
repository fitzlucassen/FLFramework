<?php
    class QueryBuilder{
	const SELECT = "SELECT";
	const FROM = "FROM";
	const WHERE = "WHERE";
	const ORDER_BY = "ORDER BY";
	
	private $_query = "";
	private $_returnObject = false;
	
	public function __construct($returnObject){
	    $this->_query = "";
	    $this->_returnObject = $returnObject;
	}
	
	/**
	 * select
	 * @param array $values
	 * @return string or object. Depends of returnObject var
	 */
	public function select($values = array("*")){
	    $string = self::SELECT;
	    
	    $cpt = 0;
	    foreach($values as $thisValue){
		$string .= ' ' . $thisValue;
		if(($cpt+1) < count($values)){
		    $string .= ', ';
		}
		else
		    $string .= ' ';
	    }
	    
	    $this->_query = $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/**
	 * from
	 * @param array $tables
	 * @return string or object. Depends of returnObject var
	 */
	public function from($tables){
	    $string = self::FROM;
	    
	    $cpt = 0;
	    foreach($tables as $thisTable){
		$string .= ' ' . $thisTable;
		if(($cpt+1) < count($tables)){
		    $string .= ', ';
		}
		else
		    $string .= ' ';
	    }
	    $this->_query .= $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/**
	 * where
	 * @param array $conditions -> array which has to contain "link" (link between each condition), "left" (left operand), "operator" (operator), "right" (right operand)
	 * @return string or object. Depends of returnObject var
	 */
	public function where($conditions){
	    $string = self::WHERE;
	    
	    foreach($conditions as $val){
		$string .= ' ' . ((isset($val['link']) && !empty($val['link'])) ? $val['link'] . ' ' : '') . $val['left'] . ' ' . $val['operator'] . ' ' . $val['right'];
	    }
	    $this->_query .= $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/**
	 * orderBy
	 * @param array $vars -> the vars to order the query
	 * @return string or object. Depends of returnObject var
	 */
	public function orderBy($vars){
	    $string = self::ORDER_BY;
	    
	    $cpt = 0;
	    foreach($vars as $var){
		$string .= ' ' . $var;
		if(($cpt+1) < count($vars)){
		    $string .= ', ';
		}
	    }
	    $this->_query .= $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public function getQuery(){
	    return $this->_query;
	}
    }