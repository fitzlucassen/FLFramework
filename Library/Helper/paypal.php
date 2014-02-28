<?php
    namespace fitzlucassen\FLFramework\Library\Helper;
    
    /*
      Class : Paypal
      Déscription : Permet de gérer le paiement via paypal
     */
    class Paypal extends Helper {
	private $_username = "sell_api1.localhost.fr";
	private $_password = "1393605614";
	private $_signature = "ATM9fpmKSuPGPsQ.TNNoHOvNfnzMAIHsSTo8Ioj7.fhhmklFDRL83E77";
	
	private $_params = array(
	    'METHOD' => 'SetExpressCheckout',
	    'VERSION' => '109',

	    'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
	);
	
	
	
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
    }