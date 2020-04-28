<?php
function logout()
{
	echo "...Logout";
	session_start();
	unset($_SESSION['user_data']);
	session_destroy();
	header('Location: login.php');
	exit();
}
?>