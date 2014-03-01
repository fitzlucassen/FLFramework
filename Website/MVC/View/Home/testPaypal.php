<link type="text/css" rel="stylesheet" href="<?php echo __css_directory__;?>/home.css" />
<title>FLFramework - Le framework PHP français</title>

<?php
    // inclure ci-dessus les balises à inclure dans la balise <head> du layout
    $head = $this->RegisterViewHead();
    // START CONTENT

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
    
    $Paypal = new \fitzlucassen\FLFramework\Library\Helper\Paypal();
    $Paypal->setUsername("sell_api1.localhost.fr");
    $Paypal->setPassword("1393605614");
    $Paypal->setSignature("ATM9fpmKSuPGPsQ.TNNoHOvNfnzMAIHsSTo8Ioj7.fhhmklFDRL83E77");
    $Paypal->setReturnUrl('http://flframework:81/' . fitzlucassen\FLFramework\Library\Core\Router::GetUrl("home", "testpaypal"));
    $Paypal->setCancelUrl('http://flframework:81/' . fitzlucassen\FLFramework\Library\Core\Router::GetUrl("home", "testpaypal"));
    $Paypal->setPort(10);
    $Paypal->setTotal(73);
    $Paypal->setTotalTTC();
    $Paypal->setCart($products);
    
    $Paypal->SetExpressCheckout();

    if(curl_errno($curl)){
	var_dump(curl_error($curl));
	curl_close($curl);
	die();
    }
    else {
	if($responseArray['ACK'] == 'Success'){
	    curl_close($curl);
	}
	else {
	    var_dump($responseArray);
	    curl_close($curl);
	    die();
	}
    }
    $paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $responseArray['TOKEN'];
    
?>

<div id="cart">
    <?php
	foreach($products as $p){
	    echo "<h2>" . $p['name'] . "</h2>";
	    echo "<p>" . $p['price'] . "</p>";
	    echo "<p>" . $p['priceTVA'] . "</p>";
	    echo "<p>" . $p['quantity'] . "</p>";
	}
	echo '<h3>' . $totalttc . '</h3>';
    ?>
    <a href="<?php echo $paypal; ?>">payer</a>
</div>