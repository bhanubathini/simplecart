<?php
	ob_start();
	include_once("functions.php");
	$del = @$_GET['id'];
		if(isset($del))
		{
			deleteService($del);	
			header('location:../services.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Deleting... </title>   
</head>
<body>
Deleting please wait...
</body>
</html>
<?php ob_flush(); ?>