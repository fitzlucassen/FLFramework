<?php

	namespace fitzlucassen\FLFramework\Library\Helper;

	/*
	  Class : CdisountAPI
	  Déscription : Permet d'utiliser l'api cdiscount
	 */
	class Cdiscount extends Helper{
		private $_url = "https://api.cdiscount.com/OpenApi/json/";
		private $_apiKey = "a78c612c-79aa-46ab-a3b7-84d3ef2cdeb3";
		private $_responseArray = array();
		private $_errors = array();
		private $_params = array();

		/**
		 * Constructeur
		 * @param $manager
		 * @param $params
		 */
		public function __construct($manager, $apikey = null){
			if(isset($apikey))
				$this->_apiKey = $apikey;

			$this->_params["ApiKey"] = $this->_apiKey;
		}

		public function request($methode, $params){
			$this->_params = array_merge($this->_params, $params);
			
			$params = json_encode($this->_params);

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->_url . $methode,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $params,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_VERBOSE => 1
			));

			$this->_responseArray = json_decode(curl_exec($curl));
			
			if(curl_errno($curl)){
				$this->_errors = curl_error($curl);
				curl_close($curl);
				return false;
			}
			else {
				curl_close($curl);
				return $this->_responseArray;
			}
		}
	}