<?php

// Include configuration file
include_once 'config.php';

// Include database connection file
include_once 'dbConnect.php';

// Include PayPalPro PHP library
require_once 'PaypalPro.class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    ////echo '<pre>';print_r($_POST);die;
    // Buyer information
	$name = $_POST['name_on_card'];
	$nameArr = explode(' ', $name);
    $firstName = !empty($nameArr[0])?$nameArr[0]:'';
    $lastName = !empty($nameArr[1])?$nameArr[1]:'';
    $city = 'Charleston';
    $zipcode = '25301';
    $countryCode = 'US';
	
	// Card details
	$creditCardNumber = trim(str_replace(" ","",$_POST['card_number']));
	$creditCardType = $_POST['card_type'];
	$expYear = $_POST['expiry_year'];
	$expMonth = $_POST['expiry_month'];
	$cvv = $_POST['cvv'];
    
    // Create an instance of PaypalPro class
	$paypal = new PaypalPro();
	
	// Payment details
    $paypalParams = array(
        'paymentAction' => 'Sale',
		'itemNumber' => $itemNumber,
		'itemName' => $itemName,
        'amount' => $payableAmount,
        'currencyCode' => $currency,
        'creditCardType' => $creditCardType,
        'creditCardNumber' => $creditCardNumber,
        'expMonth' => $expMonth,
        'expYear' => $expYear,
        'cvv' => $cvv,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'city' => $city,
        'zip'	=> $zipcode,
        'countryCode' => $countryCode
    );
	
	// Call PayPal API
    $response = $paypal->paypalCall($paypalParams);
    $paymentStatus = strtoupper($response["ACK"]);
	echo '<pre>';print_r($response);die;
    if($paymentStatus == "SUCCESS"){
		// Transaction info
		$transactionID = $response['TRANSACTIONID'];
		$paidAmount = $response['AMT'];
		
		// Insert tansaction data into the database
        $sql = "INSERT INTO orders(item_number,item_name,item_price,item_price_currency,buyer_name,card_num,card_exp_month,card_exp_year,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$itemNumber."','".$itemName."','".$payableAmount."','".$currency."','".$name."','".$creditCardNumber."','".$expMonth."','".$expYear."','".$paidAmount."','".$currency."','".$transactionID."','".$paymentStatus."',NOW(),NOW())";
        $insert = $db->query($sql);
        $last_insert_id = $db->insert_id;
		
		$data['status'] = 1;
        $data['orderID'] = $last_insert_id;
    }else{
         $data['status'] = 0;
    }
	
	// Transaction status
    echo json_encode($data);
}
?>