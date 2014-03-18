<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Controller;
    
    use fitzlucassen\FLFramework\Website\MVC\Model;
    use fitzlucassen\FLFramework\Library\Helper;
    
     /*
	Class : TestController
	Déscription : Permet de tester les helpers
     */
    class TestController extends Controller {
		public function __construct($action, $manager) {
		    parent::__construct("home", $action, $manager);
		}
		
		public function TestAuth(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    	
		    $Auth = new Helper\Auth($this->_repositoryManager, array(
				'table' => 'user',
				'primaryKeyField' => 'id',
				'loginField' => 'login',
				'passwordField' => 'password',
				'adminField' => 'isAdmin',
				'encryptedPassword' => true
			));

		    if(!$Auth->connect('root','root')){
		    	// Not a valid account
		    }
		    else {
		    	if($Auth->isAdmin()){
		    		// He's administrator
		    	}
		    	else {
		    		// He's not an administrator
		    	}
		    	var_dump($Auth->getUser());die();
		    }


		    $this->_view->ViewCompact($Model);
		}
		
		public function TestEmail(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    $Email = new Heper\Email();

		    // On configure l'email
		    $Email->from("example@exe.fr")
		    		->to("example2@exe.fr")
		    		->subject("Test d'envoie d'email")
		    		->fromName("MYSELF")
		    		->layout("email")
		    		->view("default")
		    		->vars(array(
		    			"text" => "this is a test"
		    		));

		    // Puis on construit le header et on l'envoi
		    $Email->buildHeaders()->send();

		    $this->_view->ViewCompact($Model);
		}

		public function TestForm(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    $Form = new Helper\Form();

		    if($Form->isGet() || $Form->isPost()){
		    	// It's a form validation
		    	// Clean all vars
		    	$Form->cleanRequest();

		    	// Process request...
		    }
		    else {
		    	// On créée notre formulaire
		    	$html = "";
		    	$html .= $Form->open();
		    	$html .= $Form->input("text", "title", "", true, true, array("class" => "textField", "placeholder" => "placeholder test"), true);
		    	$html .= $Form->textarea("description", "", true, true, array("class" => "textareaField", "placeholder" => "placeholder test"), true);
		    	$html .= $Form->select("country", array("France" => "1"), true, true, array("class" => "selectField"), true);
		    	$html .= $Form->input("submit", "validation", "Ok", true, true, array("class" => "btnField"), true);
		    	$html .= $Form->close();

		    	var_dump($html);die();
		    }
		    
		    $this->_view->ViewCompact($Model);
		}

		public function TestPaginator(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    // Initialize the paginator
		    $Paginator = new Helper\Paginator(60, array(
	    		'paramPage' => 'p',
	    		'paramItemPerPar' => 'nb',
	    		'itemPerPage' => 20
	    	));

		    // Print the default paginator
	    	var_dump($Paginator->getPagination(false));die();
		    
		    $this->_view->ViewCompact($Model);
		}

		public function TestPaypal(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    // Initialize paypal with your dev account
		    $Paypal = new Helper\Paypal("login", "password", "signature", false);
		    
		    $this->_view->ViewCompact($Model);
		}

		public function TestRss(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    $Rss = new Helper\Rss();
		    
		    $this->_view->ViewCompact($Model);
		}

		public function TestSession(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    $Session = new Helper\Session();

		    // Test an existing key
		    if($Session->ContainsKey("test")){
		    	// If true, get it
		    	$test = $Session->Read("test");
		    }
		    else{
		    	// Else, write it in session
		    	$Session->Write("test" => "this is a test");
		    }
		    
		    $this->_view->ViewCompact($Model);
		}

		public function TestUpload(){
		    $Model = new Model\HomeModel($this->_repositoryManager);
		    
		    
		    
		    $this->_view->ViewCompact($Model);
		}
    }