<?php
	ob_start();
	include_once("functions.php");
	
		$del = @$_GET['id'];
		if(isset($del))
		{
			deletePage($del);	
			header('location:view.php');
		}
?>
<!DOCTYPE html>
<html lang="en">


<head>

  <title>Deleting please wait...</title> 
</head>
<body>
Deleting please wait...
</body>
</html>
<?php ob_flush(); ?>