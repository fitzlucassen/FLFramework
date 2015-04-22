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
		const GROUP_BY = "GROUP BY";
		const SET = "SET";
		const VALUES = "VALUES";
		const LIMIT = "LIMIT";
		
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

			$string .= ' ' . (count($values) > 1 ? implode(', ', $values) : $values[0]);
			
			$this->_query = $string . ' ';
			return $this->_returnObject ? $this : $string;
		}
		
		/**
		 * from --> fill the current query with a from clause
		 * @param array $tables
		 * @return string or object. Depends of returnObject var
		 */
		public function from($tables){
			$string = self::FROM;

			$string .= ' ' . (count($tables) > 1 ? implode(', ', $tables) : $tables[0]);

			$this->_query .= $string . ' ';
			return $this->_returnObject ? $this : $string;
		}
		
		/**
		 * where --> fill the current query with a where clause
		 * @param array $conditions -> array which has to contain "link" (link between each condition), "left" (left operand), "operator" (operator), "right" (right operand). Can contains 'paranthesis'
		 * 			EXEMPLE : 	array(
		 *							"link" => "",
		 *							"left" => "id",
		 *							"operator" => "=",
		 *							"right" => $id,
		 *							"paranthesis" => array ("open" => true, "close" => true)
		 *						)
		 * @return string or object. Depends of returnObject var
		 */
		public function where($conditions){
			$string = self::WHERE;
			
			foreach($conditions as $val){
				$typeR = gettype($val['right']);

				$string .= ' ' . ((isset($val['link']) && !empty($val['link'])) ? $val['link'] . ' ' : '');

				if(isset($val['paranthesis']) && isset($val['paranthesis']['open']))
					$string .= '(';
				$string .= $val['left'] . ' ' . $val['operator'] . ' ' . ($typeR == "string" ? "'" . $val['right'] . "'" : $val['right']);

				if(isset($val['paranthesis']) && isset($val['paranthesis']['close']))
					$string .= ')';
			}
			$this->_query .= $string . ' ';
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
			$this->_query .= $string . ' ';
			return $this->_returnObject ? $this : $string;
		}

		public function groupBy($values){
			$string = self::GROUP_BY;

			$string .= ' ' . (count($values) > 1 ? implode(', ', $values) : $values[0]);
			
			$this->_query = $string . ' ';
		}

		public function limit($limit){
			$this->_query .= self::LIMIT . ' ' . $limit;
		}
		
		/**
		 * delete --> create a new query with a delete
		 * @param string $table
		 * @return string or object. Depends of returnObject var
		 */
		public function delete($table){
			$string = self::DELETE . ' ' . self::FROM;
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
			
			$keys = array_keys($values);
			$string .= count($keys) > 1 ? implode(', ', $keys) : $keys[0];

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
