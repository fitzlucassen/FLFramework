<?php 
	/**********************************************************
	 **** File generated by fitzlucassen\DALGenerator tool ****
	 * All right reserved to fitzlucassen repository on github*
	 ************* https://github.com/fitzlucassen ************
	 **********************************************************/
	namespace fitzlucassen\FLFramework\Data\Repository;

	use fitzlucassen\FLFramework\Library\Core as cores;
	use fitzlucassen\FLFramework\Data\Entity as entities;

	class RouteurlRepository {
		private $_pdo;
		private $_lang;
		private $_pdoHelper;
		private $_queryBuilder;

		public function __construct($pdo, $lang){
			$this->_pdoHelper = $pdo;
			$this->_pdo = $pdo->GetConnection();
			$this->_queryBuilder = new cores\QueryBuilder(true);
			$this->_lang = $lang;
		}
		/**
		 * 
		 * @param type $route
		 * @return \RouteUrl
		 */
		public function getByRouteName($route) {
			$request = $this->_queryBuilder->select()
							->from(array("routeurl"))
							->where(array(array("link" => "", "left" => "name", "operator" => "=", "right" => $route)))
							->getQuery();
			try {
				$resultat = $this->_pdoHelper->Select($request);

				$RouteUrl = new entities\RouteUrl($resultat["id"], $resultat["name"], $resultat["controller"], $resultat["action"], $resultat["order"]);

				return $RouteUrl;
			} catch (\PDOException $e) {
				print $e->getMessage();
			}
			return array();
		}

		/**
		 * 
		 * @param type $controller
		 * @param type $action
		 * @return \RouteUrl
		 */
		public function getByControllerAction($controller, $action) {
			$request = $this->_queryBuilder->select()
							->from(array("routeurl"))
							->where(array(array("link" => "", "left" => "controller", "operator" => "=", "right" => $controller),
									array("link" => "AND", "left" => "action", "operator" => "=", "right" => $action)))
							->getQuery();
			try {
				$resultat = $this->_pdoHelper->Select($request);

				$RouteUrl = new entities\RouteUrl($resultat["id"], $resultat["name"], $resultat["controller"], $resultat["action"], $resultat["order"]);

				return $RouteUrl;
			} catch (\PDOException $e) {
				print $e->getMessage();
			}
			return array();
		}
	
		/**************************
		 * REPOSITORIES FUNCTIONS *
		 **************************/
		public static function getAll($Connection){
			$qb = new cores\QueryBuilder(true);
			$query = $qb->select()->from(array("routeurl"))->getQuery();
			try {
				$result = $Connection->SelectTable($query);
				$array = array();
				foreach ($result as $object){
					$o = new entities\RouteUrl();
					$o->fillObject($object);
					$array[] = $o;
				}
				return $array;
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}

		public function getById($id){
			$query = $this->_queryBuilder->select()->from(array("routeurl"))
										->where(array(array("link" => "", "left" => "id", "operator" => "=", "right" => $id)))->getQuery();
			try {
				$properties = $this->_pdoHelper->Select($query);
				$object = new entities\RouteUrl();
				$object->fillObject($properties);
				return $object;
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}

		public function delete($id) {
			$query = $this->_queryBuilder->delete("routeurl")
										->where(array(array("link" => "", "left" => "id", "operator" => "=", "right" => $id )))
										->getQuery();
			try {
				return $this->_pdo->Query($query);
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}

		public function add($properties) {
			$query = $this->_queryBuilder->insert("routeurl", array('name' => $properties["name"], 'controller' => $properties["controller"], 'action' => $properties["action"], 'order' => $properties["order"], ))->getQuery();
			try {
				return $this->_pdo->Query($query);
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}

		public function update($id, $properties) {
			$query = $this->_queryBuilder->update("routeurl", array('name' => $properties["name"], 'controller' => $properties["controller"], 'action' => $properties["action"], 'order' => $properties["order"], ))->where(array(array("link" => "", "left" => "id", "operator" => "=", "right" => $id )))->getQuery();
			try {
				return $this->_pdo->Query($query);
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}

		public function getBy($key, $value){
			$query = $this->_queryBuilder->select()->from(array("routeurl"))->where(array(
				array(
					"link" => "", "left" => $key, "operator" => "=", "right" => $value
				)))->getQuery();
			
			try {
				$result = $this->_pdo->SelectTable($query);
				$array = array();
				foreach ($result as $object){
				    $o = new entities\RouteUrl();
				    $o->fillObject($object);
				    $array[] = $o;
				}
				return $array;
			}
			catch(PDOException $e){
				print $e->getMessage();
			}
			return array();
		}
		/*******
		 * END *
		 *******/

	}
