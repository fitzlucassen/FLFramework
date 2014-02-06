<?php
    /*
      Class : RewrittingUrl
      Déscription : Permet de gérer les url rewrittées du sites
     */

    namespace fitzlucassen\FLFramework\Data\Repository;
    
    use fitzlucassen\FLFramework\Data\Entity as entities;
    use fitzlucassen\FLFramework\Library\Helper as helpers;

    class RewrittingUrlRepository {

	private $_pdo = null;
	private $_pdoHelper = null;
	private $_lang = null;

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
	}

	/**
	 * 
	 * @param type $idRoute
	 * @return \RewrittingUrl
	 */
	public function getByIdRouteUrl($idRoute) {
	    $request = "SELECT *
			    FROM rewrittingurl
			    WHERE lang='" . $this->_lang . "' AND idRouteUrl=" . intval($idRoute);
	    try {
		$resultat = $this->_pdoHelper->Select($request);

		$RewrittingUrl = new entities\RewrittingUrl($resultat["id"], $resultat["idRouteUrl"], $resultat["urlMatched"], $resultat["lang"]);

		return $RewrittingUrl;
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/**
	 * 
	 * @param type $idRoute
	 * @param type $lang
	 * @param type $Connexion
	 * @return \RewrittingUrl
	 */
	public static function getByIdRouteStatic($idRoute, $lang, $Connexion) {
	    $request = "SELECT *
			    FROM rewrittingurl
			    WHERE lang='" . $lang . "' AND idRouteUrl=" . intval($idRoute);
	    try {
		$resultat = $Connexion->Select($request);

		$RewrittingUrl = new entities\RewrittingUrl($resultat["id"], $resultat["idRouteUrl"], $resultat["urlMatched"], $resultat["lang"]);

		return $RewrittingUrl;
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	public function getByUrlMatched($url) {
	    return helpers\Router::GetRoute($url);
	}

	/**************************
	 * REPOSITORIES FUNCTIONS *
	 **************************/
	/**
	 * 
	 * @return type
	 */
	public function getAll() {
	    $query = "SELECT * FROM rewrittingurl";
	    try {
		return $this->_pdo->SelectTable($query);
	    } catch (\PDOException $e) {
		print $e->getMessage();
	    }
	    return array();
	}

	/**
	 * 
	 * @param type $id
	 * @return \Rewrittingurl
	 */
	public function getById($id) {
	    $query = "SELECT * FROM rewrittingurl WHERE id=" . $id;
	    try {
		$properties = $this->_pdo->Select($query);
		$object = new entities\Rewrittingurl();
		$object->fillObject($properties);
		return $object;
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
	    $query = "DELETE FROM rewrittingurl WHERE id=" . $id;
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
	    $query = "INSERT INTO rewrittingurl('id', 'idRouteUrl', 'urlMatched', 'lang')
				    VALUES(" . $properties["id"] . ", " . $properties["idRouteUrl"] . ", '" . $properties["urlMatched"] . "', '" . $properties["lang"] . "')";
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
	    $query = "UPDATE rewrittingurl 
				    SET id = " . $properties["id"] . ", idRouteUrl = " . $properties["idRouteUrl"] . ", urlMatched = '" . $properties["urlMatched"] . "', lang = '" . $properties["lang"] . "'
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