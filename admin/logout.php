<?php
	ob_start();
	/*session_start();*/
	include_once("functions.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
</head>

<body>
Logging out. Please wait...
<?php
	 logout();
?>
</body>
</html>
<?php ob_flush(); ?>