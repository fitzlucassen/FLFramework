<?php

	namespace fitzlucassen\FLFramework\Website\MVC\Model;
	
	 /*
		Class : WebserviceModel
		Déscription : Model de donnée pour les résultat du webservice
	 */
	class WebserviceModel extends Model{
		public $result = "";

		public function __construct($manager) {
			parent::__construct($manager);
		}
	}
