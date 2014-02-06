<?php

    /*
      Class : RouteUrl
      Déscription : Permet de gérer les url brutes du sites
     */

    namespace fitzlucassen\FLFramework\Data\Repository;
    
    use fitzlucassen\FLFramework\Library\Helper as helpers;
    use fitzlucassen\FLFramework\Data\Entity as entities;

    class RouteUrlRepository {

	private $_pdo = null;
	private $_pdoHelper = null;
	private $_lang = null;
	private $_queryBuilder = null;

	/**
	 * Constructor 
	 * @param $pdo 
	 * @param $lang
	 */
	public function __construct($pdo, $lang) {
	    /** Set les données de connexion * */
	    $this->_pdo = $pdo->GetConnection();
	    $this->_pdoHelper = $pdo;
	    $this->_lang = $lang;
	    $this->_queryBuilder = new helpers\QueryBuilder(true);
	}

	/**
	 * 
	 * @param type $route
	 * @return \RouteUrl
	 */
	public function getByRouteName($route) {
	    $request = $this->_queryBuilder->select()
					    ->from(array("routeurl"))
					    ->where(array(array("link" => "", "left" => "name", "operator" => "=", "right" => "'" . $route . "'")))
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
					    ->where(array(array("link" => "", "left" => "controller", "operator" => "=", "right" => "'" . $controller . "'"),
							    array("link" => "AND", "left" => "action", "operator" => "=", "right" => "'" . $action . "'")))
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
	 * @param type $id
	 * @return \RouteUrl
	 */
	public function getById($id) {
	    $request = $this->_queryBuilder->select()
					    ->from(array("routeurl"))
					    ->where(array(array("link" => "", "left" => "id", "operator" => "=", "right" => $id )))
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
	 * @param type $Connexion
	 * @return type
	 */
	public static function getAll($Connexion) {
	    $qb = new helpers\QueryBuilder(true);
	    $request = $qb->select()->from(array("routeurl"))->getQuery();
	    try {
		return $Connexion->SelectTable($request);
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/**
	 * 
	 * @param type $id
	 * @return type
	 */
	public function delete($id) {
	    $query = "DELETE FROM routeurl WHERE id=" . $id;
	    try {
		return $this->_pdo->Query($query);
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/**
	 * 
	 * @param type $properties
	 * @return type
	 */
	public function add($properties) {
	    $query = "INSERT INTO routeurl('id', 'name', 'controller', 'action', 'order')
				    VALUES(" . $properties["id"] . ", '" . $properties["name"] . "', '" . $properties["controller"] . "', '" . $properties["action"] . "', " . $properties["order"] . ")";
	    try {
		return $this->_pdo->Query($query);
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/**
	 * 
	 * @param type $id
	 * @param type $properties
	 * @return type
	 */
	public function update($id, $properties) {
	    $query = "UPDATE routeurl 
				    SET id = " . $properties["id"] . ", name = '" . $properties["name"] . "', controller = '" . $properties["controller"] . "', action = '" . $properties["action"] . "', order = " . $properties["order"] . "
				    WHERE id=" . $id;
	    try {
		return $this->_pdo->Query($query);
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/*******
	 * END *
	 *******/
    }