<?php
define('SITE_NAME','WSS');
define('SITE_URL','http://'.$_SERVER['HTTP_HOST'].'/shopping/'); 

/*$sub = " - Verify your email address";
					$to = "bhanu.cse12@gmail.com";
					$msg = "Please activate your account to login";
					$headers='From: no-reply@iambhanu.com'. "\r\n";
					//$headers .='To: bhanu.cse12@gmail.com'. "\r\n";
					$headers .= "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					$message = "
					<html>
						<head>
							<title>HTML email</title>
						</head>
						<body>".$msg."</body>
					</html>";

		
					//mail
					$sent=mail($to,$sub,$message,$headers);
					die();*/

define('SITE_TITLE','WSS');
include 'config/db.php';
/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/phpmailer/src/Exception.php';
require 'config/phpmailer/src/PHPMailer.php';
require 'config/phpmailer/src/SMTP.php';*/
ini_set('display_errors', 1);
$db = new db();
$conn = $db->dbConnect();

include 'Users1.php';
include 'Products.php';
date_default_timezone_set('Asia/Kolkata');

$method = $_REQUEST['method'];
$params = $_REQUEST;
foreach ($_REQUEST as $key => $value) {
	$params[$key] = $db->escapeString($value);
}

switch ($method) {
	case 'signup':
		$usersObj->signup($params);
		break;
	case 'activateaccount':$usersObj->activateaccount($params);
	break;
	case 'signin':$usersObj->signin($params);
	break;
	case 'getAddresses':$usersObj->getAddresses($params);
	break;

	case 'updateAddress':$usersObj->updateAddress($params);
	break;

	case 'home':$productsObj->home($params);
	break;
	case 'categories':$productsObj->categories($params);
	break;
	case 'getproducts':$productsObj->getproducts($params);
	break;
	case 'getproductsby':$productsObj->getproductsby($params);
	break;
	case 'addToCart':$productsObj->addToCart($params);
	break;
	case 'getCart':$productsObj->getCart($params);
	break;
	case 'checkout':$productsObj->checkout($params);
	break;
	case 'confirmOrder':$productsObj->confirmOrder($params);
	break;
	case 'getorders':$productsObj->getOrders($params);
	break;
	
	default:
		# code...
		break;
}


?>