<?php
	ob_start();
	include_once("functions.php");
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
 if(isset($_GET['del']))
 {
 	$did=$_GET['del'];
 	mysqli_query($api->db,"DELETE FROM n_experiences WHERE exp_id=$did");
	header('location:view-exp.php');
 }
 if(isset($_GET['act']))
 {
 	$aid=$_GET['act'];
 	mysqli_query($api->db,"UPDATE n_experiences SET exp_active=1 WHERE exp_id=$aid");
	header('location:view-exp.php');
 }
 if(isset($_GET['deact']))
 {
 	$aid=$_GET['deact'];
 	mysqli_query($api->db,"UPDATE n_experiences SET exp_active=0 WHERE exp_id=$aid");
	header('location:view-exp.php');
 }
 ob_flush();
?>