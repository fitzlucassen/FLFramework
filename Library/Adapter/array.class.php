<?php
    /*
      Class : Array
      Déscription : Permet de gérer les Array
     */

    class ArrayHelper {
	/**
	 * Select -> sélectionne une unique clef parmi un array
	 * @param type $array
	 * @param type $label
	 * @return type
	 */
	public static function Select($array, $label) {
	    $arrayReturn = array();
	    
	    foreach($array as $key => $value){
		if($key == $label){
		    $arrayReturn[$key] = $value;
		}
	    }
	    
	    return $arrayReturn;
	}
    }
