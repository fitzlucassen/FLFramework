<?php
    namespace fitzlucassen\FLFramework\Library\Helper;
    
    /*
      Class : Paypal
      Déscription : Permet de gérer le paiement via paypal
     */
    class Paypal extends Helper {
	private $_username = "";
	private $_password = "";
	private $_signature = "";
	private $_endpoint = 'https://api-3T.sandbox.paypal.com/nvp';
	private $_responseArray = array();
	private $_params = array(
	    'METHOD' => 'SetExpressCheckout',
	    'VERSION' => '109',

	    'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
	);
	
	public function SetExpressCheckout(){
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
	}
	
	public function setUsername($arg){
	    $this->_username = $arg;
	    $this->_params['USER'] = $arg;
	}
	public function setPassword($arg){
	    $this->_password = $arg;
	    $this->_params['SIGNATURE'] = $arg;
	}
	public function setSignature($arg){
	    $this->_signature = $arg;
	    $this->_params['PWD'] = $arg;
	}
	public function setReturnUrl($arg){
	    $this->_params['RETURNURL'] = $arg;
	}
	public function setCancelUrl($arg){
	    $this->_params['CANCELURL'] = $arg;
	}
	public function setPort($arg){
	    $this->_params['PAYMENTREQUEST_0_SHIPPINGAMT'] = $arg;
	}
	public function setTotal($arg){
	    $this->_params['PAYMENTREQUEST_0_ITEMAMT'] = $arg;
	}
	public function setTotalTTC(){
	    $this->_params['PAYMENTREQUEST_0_ITEMAMT'] = $this->_params['PAYMENTREQUEST_0_SHIPPINGAMT'] + $this->_params['PAYMENTREQUEST_0_ITEMAMT'];
	}
	public function setCart($products){
	    foreach ($products as $k => $pro){
		$this->_params['L_PAYMENTREQUEST_0_NAME' . $k] = $pro['name'];
		$this->_params['L_PAYMENTREQUEST_0_DESC' . $k] = '';
		$this->_params['L_PAYMENTREQUEST_0_AMT' . $k] = $pro['priceTVA'];
		$this->_params['L_PAYMENTREQUEST_0_QTY' . $k] = $pro['quantity'];
	    }
	}
    }