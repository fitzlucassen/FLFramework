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
    $Paypal->setReturnUrl('http://flframework:81/' . fitzlucassen\FLFramework\Library\Core\Router::GetUrl("home", "testpaypal"));
    $Paypal->setCancelUrl('http://flframework:81/' . fitzlucassen\FLFramework\Library\Core\Router::GetUrl("home", "testpaypal"));
    $Paypal->setPort(10);
    $Paypal->setTotal(73);
    $Paypal->setTotalTTC();
    
    foreach ($products as $k => $pro){
	$params['L_PAYMENTREQUEST_0_NAME' . $k] = $pro['name'];
	$params['L_PAYMENTREQUEST_0_DESC' . $k] = '';
	$params['L_PAYMENTREQUEST_0_AMT' . $k] = $pro['priceTVA'];
	$params['L_PAYMENTREQUEST_0_QTY' . $k] = $pro['quantity'];
    }
    
    $params = http_build_query($params);
    $endpoint = 'https://api-3T.sandbox.paypal.com/nvp';
    $curl = curl_init();
    curl_setopt_array($curl, array(
	CURLOPT_URL => $endpoint,
	CURLOPT_POST => 1,
	CURLOPT_POSTFIELDS => $params,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_VERBOSE => 1
    ));
    $responseArray = array();
    parse_str(curl_exec($curl), $responseArray);

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