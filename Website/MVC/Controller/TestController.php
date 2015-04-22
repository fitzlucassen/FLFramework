<?php

	namespace fitzlucassen\FLFramework\Website\MVC\Controller;
	
	use fitzlucassen\FLFramework\Website\MVC\Model;
	use fitzlucassen\FLFramework\Library\Helper;
	use fitzlucassen\FLFramework\Library\Core;
	
	/*
		Class : TestController
		Déscription : Permet de tester les helpers
	*/
	class TestController extends Controller {
		public function __construct($action, $manager) {
			parent::__construct("test", $action, $manager);
		}

		public function JSLibraries(){
			$Model = new Model\HomeModel($this->_repositoryManager);

			$this->_view->view($Model);
		}

		public function TestCdiscount(){
			$Model = new Model\HomeModel($this->_repositoryManager);
				
			$Cdiscount = new Helper\Cdiscount($this->_repositoryManager, '[YOUR-API-KEY]');

			$Cdiscount->request('Search', array(
				"SearchRequest" => array(
					"Keyword" => "tablette",
					"SortBy" => "relevance",
					"Pagination" => array(
						"ItemsPerPage" => 5,
						"PageNumber" => 0
					)
				)
			));
			die();
			$this->_view->view($Model);
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


			$this->_view->view($Model);
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

			$this->_view->view($Model);
		}

		public function TestForm(){
			$Model = new Model\HomeModel($this->_repositoryManager);
			
			$Form = new Helper\Form();

			if(Core\Request::isPost() || Core\Request::isPost()){
				// It's a form validation
				// Clean all vars
				$data = Core\Request::cleanRequest();

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
			
			$this->_view->view($Model);
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
			
			$this->_view->view($Model);
		}

		public function TestPaypal(){
			$Model = new Model\HomeModel($this->_repositoryManager);
			
			// Initialize a cart of 2 products just to test
			$products = array(
				array(
					"name" => "produit1",
					"price" => 10.0,
					"priceTVA" => 12.0,
					"quantity" => 1
				),
				array(
					"name" => "produit2",
					"price" => 25.5,
					"priceTVA" => 30.50,
					"quantity" => 2
				)
			);

			/****************************
			 * INITIALIZE TO GO PAYMENT *
			 ****************************/
			
			// Initialization of the API
			$Paypal = new Helper\Paypal("sell_api1.localhost.fr", "1393605614", "ATM9fpmKSuPGPsQ.TNNoHOvNfnzMAIHsSTo8Ioj7.fhhmklFDRL83E77", false);
			// Iniialize the url vars for the return of the first request
			$Paypal->setReturnUrl('http://[YOUR-URL]/' . Core\Router::GetUrl("home", "testpaypal"));
			$Paypal->setCancelUrl('http://[YOUR-URL]/' . Core\Router::GetUrl("home", "testpaypal"));
			// Fraix de port
			$Paypal->setPort(10);
			// total amount ttc without port
			$Paypal->setTotal(73);
			// total amount ttc with port
			$Paypal->setTotalTTC();
			// set the cart
			$Paypal->setCart($products);
			// first request
			$Paypal->request("SetExpressCheckout");
			// Get the link to pay
			$linkToPay = $Paypal->getPaymentLink();


			/*****************************
			 * GET THE RESULT OF PAYMENT *
			 *****************************/


			
			$this->_view->view($Model);
		}

		public function TestRss(){
			$Model = new Model\HomeModel($this->_repositoryManager);
			
			// Initialize your rss flux
			$Rss = new Helper\Rss();
			$Rss->setTitle("Test RSS")
				->setLink("http://www.thibaultdulon.com")
				->setDescription("This is a description");

			// And then fill it with your items
			$Rss->setItems(array(
				array(
					"title" => "item1",
					"description" => "description item1",
					"link" => "http://www.thibaultdulon.com"
				),
				array(
					"title" => "item2",
					"description" => "description item2",
					"link" => "http://www.thibaultdulon.com"
				)
			));

			// You need to change your layout before sending the view
			$this->setLayout("rss");

			var_dump($Rss->display(false));die();

			$this->_view->view($Model, 'xml');
		}

		public function TestSession(){
			$Model = new Model\HomeModel($this->_repositoryManager);
			
			$Session = new Helper\Session();

			// Test an existing key
			if($Session->containsKey("test")){
				// If true, get it
				$test = $Session->read("test");
			}
			else{
				// Else, write it in session
				$Session->write("test", "this is a test");
			}
			
			$this->_view->view($Model);
		}

		public function TestUpload(){
			$Model = new Model\HomeModel($this->_repositoryManager);
			
			if(Core\Request::isFile()){
				// Initialize the upload helper with the upload directory path
				$Upload = new Helper\Upload("upload_test");
				// Give the file and then upload
				$Upload->file($_FILES["file"]);
				$Upload->upload();
			}
			
			$this->_view->view($Model);
		}
	}