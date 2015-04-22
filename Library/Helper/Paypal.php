<?php
	namespace fitzlucassen\FLFramework\Library\Helper;
	
	/*
		Class : Paypal
		Déscription : Permet de gérer le paiement via paypal
	 */
	class Paypal extends Helper {
		public $_errors = array();
		public $_mainMethods = array(
			'SetExpressCheckout',
			'GetExpressCheckoutDetails',
			'DoExpressCheckoutPayment'
		);
		
		private $_username = "";
		private $_password = "";
		private $_signature = "";
		private $_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
		private $_responseArray = array();
		private $_params = array(
			'VERSION' => '109',
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
		);
		
		
		public function __construct($user, $pwd, $signature, $prod = false) {
			parent::__construct();
			
			$this->_username = $user;
			$this->_password = $pwd;
			$this->_signature = $signature;
			
			if($prod){
				$this->_endpoint = str_replace('sandbox.', '', $this->_endpoint);
			}
			$this->_params['USER'] = $this->_username;
			$this->_params['PWD'] = $this->_password;
			$this->_params['SIGNATURE'] = $this->_signature;
		}
		
		public function request($method, $params){
			$this->_params['METHOD'] = $method;
			$this->_params = array_merge($this->_params, $params);
			
			$params = http_build_query($this->_params);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->_endpoint,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $params,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_VERBOSE => 1
			));
			
			parse_str(curl_exec($curl), $this->_responseArray);
			
			if(curl_errno($curl)){
				$this->_errors = curl_error($curl);
				curl_close($curl);
				return false;
			}
			else {
				if($this->_responseArray['ACK'] == 'Success'){
					curl_close($curl);
					return $this->_responseArray;
				}
				else {
					$this->_errors = $this->_responseArray;
					curl_close($curl);
					return false;
				}
			}
		}
		
		/***********
		 * SETTERS *
		 ***********/
		// SET EXPRESS CHECKOUT
		public function setReturnUrl($arg){
			$this->_params['RETURNURL'] = $arg;
			return $this;
		}
		public function setCancelUrl($arg){
			$this->_params['CANCELURL'] = $arg;
			return $this;
		}
		public function setPort($arg){
			$this->_params['PAYMENTREQUEST_0_SHIPPINGAMT'] = $arg;
			return $this;
		}
		public function setTotal($arg){
			$this->_params['PAYMENTREQUEST_0_ITEMAMT'] = $arg;
			return $this;
		}
		public function setTotalTTC(){
			$this->_params['PAYMENTREQUEST_0_AMT'] = $this->_params['PAYMENTREQUEST_0_SHIPPINGAMT'] + $this->_params['PAYMENTREQUEST_0_ITEMAMT'];
			return $this;
		}
		public function setCart($products){
			foreach ($products as $k => $pro){
				$this->_params['L_PAYMENTREQUEST_0_NAME' . $k] = $pro['name'];
				$this->_params['L_PAYMENTREQUEST_0_DESC' . $k] = $pro['description'];
				$this->_params['L_PAYMENTREQUEST_0_AMT' . $k] = $pro['priceTVA'];
				$this->_params['L_PAYMENTREQUEST_0_QTY' . $k] = $pro['quantity'];
			}
			return $this;
		}
		
		// GET EXPRESS CHECKOUT
		public function setToken($arg){
			$this->_params['TOKEN'] = $arg;
			return $this;
		}
		
		// DO EXPRESS CHECKOUT
		public function setPayerID($arg){
			$this->_params['PAYERID'] = $arg;
			return $this;
		}
		public function setPaymentAction($arg){
			$this->_params['PAYMENTACTION'] = $arg;
			return $this;
		}
		public function setAmount($arg){
			$this->_params['PAYMENTREQUEST_0_AMT'] = $arg;
			return $this;
		}
		
		/***********
		 * GETTERS *
		 ***********/
		public function getPaymentLink(){
			if(isset($this->_responseArray['TOKEN']))
				return 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $this->_responseArray['TOKEN'];
			else
				return '#';
		}
	}
