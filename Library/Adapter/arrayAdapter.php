<?php
    /*
      Class : Array
      Déscription : Permet de gérer les Array
     */
     
    namespace fitzlucassen\FLFramework\Library\Adapter;

    class ArrayAdapter {
		/**
		 * Select -> sélectionne une unique clef parmi un array
		 * @param type $array
		 * @param type $label
		 * @return type
		 */
		public static function Select($array, $label, $level) {
		    $arrayReturn = array();
		    foreach($array as $key => $value){
				if($level == 2){
				    foreach($value as $key => $value){
						if($key === $label){
						    $arrayReturn[] = $value;
						}
				    }
				}
				else {
				    if($key === $label){
						$arrayReturn[] = $value;
				    }
				}
		    }
		    
		    return $arrayReturn;
		}
		
		public static function Order($array){
		    sort($array);
		    
		    return $array;
		}

		public static function OrderBy($array, $key, $order = "ASC"){
			if(is_object($array[0]))
				usort($array, create_function('$a, $b', 'return strcmp($a->get' . ucfirst($key) . '(), $b->get' . ucfirst($key) . '());'));
			else
				usort($array, create_function('$a, $b', 'return strcmp($a["' . $key . '"], $b["' . $key . '"]);'));

			if($order == 'DESC')
				$array = array_reverse($array);
			return $array;
		}
		
		public static function Distinct($array){
		    $a = array();
		    
		    foreach($array as $temp){
				if(in_array($temp, $a)){
				    continue;
				}
				else {
				    $a[] = $temp;
				}
		    }
		    return $a;
		}
    }
