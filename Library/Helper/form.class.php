<?php
    class Form extends Helper{
	
	public function __construct($controller, $params = null) {
	    parent::__construct($controller, $params);
	}
	
	/**
	 * IsPost
	 * @return boolean
	 */
	public function IsPost(){
	    return isset($_POST) && !empty($_POST);
	}
	
	/**
	 * IsGet
	 * @return boolean
	 */
	public function IsGet(){
	    return isset($_GET) && !empty($_GET);
	}
	
	/**
	 * CleanPost
	 * @return array
	 */
	public function CleanPost(){
	    $params = array();
	    $vars = $this->IsPost() ? $_POST : $_GET;
	    
	    foreach($vars as $key => $value){
		if(gettype($value) == "string"){
		    $params[$key] = htmlspecialchars($value);
		}
		else if(in_array(gettype($value), array('integer', 'double'))){
		    $params[$key] = intval($value);
		}
	    }
	    
	    return $params;
	}
	
	/**
	 * Open -> open a new html form
	 * @param string $action
	 * @param string $method
	 * @param string $enctype
	 * @return string -> the html
	 */
	public static function Open($action = "", $method = "post", $enctype = ""){
	    $form = '';
	    $form = '<form action="' . $action . '" method="' . $method . '" enctype="' . $enctype . '">';
	    return $form;
	}
	
	/**
	 * Close -> close a html form
	 * @return string
	 */
	public static function Close(){
	    return '</form>';
	}
	
	/**
	 * Input -> return the html of a input element
	 * @param string $type
	 * @param string $name
	 * @param string $value
	 * @param string $label -> false if we don't want any label. The wording if we want a label
	 * @param booleen $withBr -> if we want a carriage return after the label
	 * @param array $params -> all other params
	 * @param booleen $required
	 * @return string -> the html
	 */
	public static function Input($type, $name, $value = "", $label = false, $withBr = true, $params = array(), $required = false){
	    $form = "";
	    if($label){
		$form .= '<label class="label" for="' . $name . 'Field">' . $label . '</label>';
		if($withBr)
		    $form .= '<br/>';
	    }
	    $form .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . 'Field" ';
	    
	    foreach($params as $key => $val){
		$form .= $key . '="' . $val . '" ';
	    }
	    $form .= 'value="' . $value . '" ' . ($required ? 'required' : '') . ' />';
	    
	    return $form;
	}
	
	/**
	 * Textarea -> return the html of a textarea element
	 * @param string $name
	 * @param string $value
	 * @param string $label -> false if we don't want any label. The wording if we want a label
	 * @param booleen $withBr -> if we want a carriage return after the label
	 * @param array $params -> all other params
	 * @param booleen $required
	 * @return string -> the html
	 */
	public static function Textarea($name, $value = "", $label = false, $withBr = true, $params = array(), $required = false){
	    $form = "";
	    if($label){
		$form .= '<label class="label" for="' . $name . 'Field">' . $label . '</label>';
		if($withBr)
		    $form .= '<br/>';
	    }
	    $form .= '<textarea name="' . $name . '" id="' . $name . 'Field" ';
	    
	    foreach($params as $key => $val){
		$form .= $key . '="' . $val . '" ';
	    }
	    $form .= ($required ? 'required' : '') . ' >' . $value . '</textarea>';
	    
	    return $form;
	}
	
	/**
	 * Select -> return the html of a select element
	 * @param string $name
	 * @param array $value
	 * @param string $label -> false if we don't want any label. The wording if we want a label
	 * @param booleen $withBr -> if we want a carriage return after the label
	 * @param array $params -> all other params
	 * @param booleen $required
	 * @return string -> the html
	 */
	public static function Select($name, $value = "", $label = false, $withBr = true, $params = array(), $required = false){
	    $form = "";
	    if($label){
		$form .= '<label class="label" for="' . $name . 'Field">' . $label . '</label>';
		if($withBr)
		    $form .= '<br/>';
	    }
	    $form .= '<select name="' . $name . '" id="' . $name . 'Field" ';
	    
	    foreach($params as $key => $val){
		$form .= $key . '="' . $val . '" ';
	    }
	    $form .= ($required ? 'required' : '') . ' >';
	    
	    foreach($value as $thisValueKey => $thisValueValue){
		$form .= '<option value="' . $thisValueValue . '">' . $thisValueKey . '</option>';
	    }
	    
	    $form .= '</select>';
	    
	    return $form;
	}
    }