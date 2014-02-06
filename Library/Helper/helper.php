<?php
     
    namespace fitzlucassen\FLFramework\Library\Helper;

    class Helper {
	protected $_controller;

	public function __construct($controller, $params = null) {
	    $this->setController($controller);
	}

	public function SetController($controller) {
	    $this->_controller = $controller;
	}

	public function GetController() {
	    return $this->_controller;
	}

	public function __transmit($params) {
	    return array();
	}
    }