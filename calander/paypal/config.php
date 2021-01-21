<?php
/*
 * Basic Site Settings and API Configuration
 */

// Product details
$itemName   = "Demo Product";
$itemNumber = "P123456";
$payableAmount = 1;
$currency   = "USD";

 
 $mode=0;

 if($mode==1){
// PayPal API configuration
	define('PAYPAL_API_USERNAME', 'chauhan.shivam190_api1.gmail.com
	'); 
	define('PAYPAL_API_PASSWORD', 'YAESH3H5UTXR9UVB'); 
	define('PAYPAL_API_SIGNATURE', 'AgVPt9FQ4SgGMTZj24.Y4Vq41Z20AsrADjxIJyFDxr11Y.cq2w-jg-gN
	'); 
	define('PAYPAL_SANDBOX', FALSE); //TRUE or FALSE

}else{
	define('PAYPAL_API_USERNAME', 'merchant_api8.codexworld.com'); 
	define('PAYPAL_API_PASSWORD', 'JAHSDK9SIDQMW8XA'); 
	define('PAYPAL_API_SIGNATURE', 'KAjs87DHSJmdISK6qKA12jsAHYTWo95-KAjs7.aks-Ksja8Sis-KsinV'); 
	define('PAYPAL_SANDBOX', TRUE); //TRUE or FALSE
}
//businessmanage/account/accountAccess
// Database configuration
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', '123456'); 
define('DB_NAME', 'paypal'); 