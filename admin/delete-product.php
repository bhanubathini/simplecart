<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['user_data']))
	{
		 header("location:login.php");
	}
	else
	{
		$id = @$_GET['id'];
		require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$dsq = mysqli_query($api->db, "SELECT Image FROM productimages WHERE ProductId=$id");
		$rd = mysqli_fetch_array($dsq);
		if($rd['Image']!="")
		{
			unlink($rd['Image']);
		}
		mysqli_query($api->db, "DELETE FROM productimages WHERE ProductId=$id");
		mysqli_query($api->db, "DELETE FROM products WHERE productID=$id");
		header('location:view-products.php');
		exit();
	}
	ob_flush();
?>