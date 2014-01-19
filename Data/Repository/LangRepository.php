<?php

/*
  Class : LangRepository
  Déscription : Permet de gérer les langues du site
 */

class LangRepository {

    private $_pdo = null;
    private $_pdoHelper = null;

    /**
     * Constructor 
     * @param $pdo 
     * @param $lang
     */
    public function __construct($pdo) {
	/** Set les données de connexion * */
	$this->_pdo = $pdo->GetConnection();
	$this->_pdoHelper = $pdo;
    }

    /**
     * GetAll
     * Permet de récupérer toutes les langues
     * @return array $result ( assoc )
     */
    public function getAll() {
	$request = "SELECT *
			    FROM lang";

	try {
	    return $this->_pdoHelper->SelectTable($request);
	} catch (PDOException $e) {
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
	$query = "DELETE FROM lang WHERE id=" . $id;
	try {
	    return $this->_pdo->Query($query);
	} catch (PDOException $e) {
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
	$query = "INSERT INTO lang('id', 'code') 
				VALUES(" . $properties["id"] . ", '" . $properties["code"] . "')";
	try {
	    return $this->_pdo->Query($query);
	} catch (PDOException $e) {
	    print $e->getMessage();
	}
	return array();
    }

    /**
     * 
     * @param type $params
     * @return boolean
     */
    public function update($id, $params = array()) {
	if (array_key_exists("code", $params)) {
	    $request = "UPDATE lang
			    SET code='" . htmlspecialchars($params['code']) . "'
			    WHERE id =" . $id;
	    $this->_pdo->execute($request);

	    return true;
	}
	else
	    return false;
    }

}