<?php
     
    namespace fitzlucassen\FLFramework\Library\Core;

    /*
      Class : QueryBuilder
      Déscription : Permet de gérer la couche de construction de requête
     */
    class QueryBuilder{
	const SELECT = "SELECT";
	const INSERT = "INSERT INTO";
	const DELETE = "DELETE";
	const UPADTE = "UPDATE";
	const FROM = "FROM";
	const WHERE = "WHERE";
	const ORDER_BY = "ORDER BY";
	const SET = "SET";
	const VALUES = "VALUES";
	
	private $_query = "";
	private $_returnObject = false;
	
	public function __construct($returnObject){
	    $this->_query = "";
	    $this->_returnObject = $returnObject;
	}
	
	/**
	 * select --> create a new query with a select
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
	 * from --> fill the current query with a from clause
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
	 * where --> fill the current query with a where clause
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
	 * orderBy --> fill the current query with an order by clause
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
	
	/**
	 * delete --> create a new query with a delete
	 * @param string $table
	 * @return string or object. Depends of returnObject var
	 */
	public function delete($table){
	    $string = self::DELETE;
	    $string .= " " . $table . " ";
	    
	    $this->_query = $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/**
	 * insert --> create a new query with an insert
	 * @param string $table
	 * @param array $values
	 * @return string or object. Depends of returnObject var
	 */
	public function insert($table, $values){
	    $string = self::INSERT;
	    $string .= " " . $table . " (";
	    
	    $cpt = 0;
	    foreach(array_keys($values) as $key){
		$string .= $key;
		
		if($cpt < (count($values) - 1))
		    $string .=  ", ";
		$cpt++;
	    }
	    $string .= ") ";
	    $string .= self::VALUES . ' (';
	    $cpt = 0;
	    foreach($values as $value){
		$type = gettype($value);
		if($type == "string")
		    $string .= "'" . $value . "'";
		else
		    $string .= $value;
		
		if($cpt < (count($values) - 1))
		    $string .=  ", ";
		$cpt++;
	    }
	    $string .= ')';
	    
	    $this->_query = $string;
	    return $this->_returnObject ? $this : $string;
	}
	
	/**
	 * update --> create a new query with an update
	 * @param string $table
	 * @param array $values
	 * @return string or object. Depends of returnObject var
	 */
	public function update($table, $values){
	    $string = self::UPADTE;
	    $string .= " " . $table . " ";
	    $string .= self::SET . " ";
	    
	    $cpt = 0;
	    foreach($values as $key => $value){
		$type = gettype($value);
		if($type == "string")
		    $string .= $key . "='" . $value . "'";
		else
		    $string .= $key . "=" . $value;
		
		if($cpt < (count($values) - 1))
		    $string .=  ", ";
		$cpt++;
	    }
	    $this->_query = $string . " ";
	    return $this->_returnObject ? $this : $string;
	}
	
	/***********
	 * GETTERS *
	 ***********/
	public function getQuery(){
	    return $this->_query;
	}
    }