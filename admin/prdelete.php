<?php
	ob_start();
	include_once("functions.php");
	$del = @$_GET['id'];
	if(isset($del))
	{
		deletePride($del);	
		header('location:index.php');
	}

?>
<!DOCTYPE html>
<html lang="en">
<title>Deleting please wait...</title>
<head>

    
</head>
<body>
Deleting please wait...
</body>
</html>
<?php ob_flush(); ?>