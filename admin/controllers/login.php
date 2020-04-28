<?php
 function signin($email,$pwd)
{
	require_once("../config/db.php");
	$api = new db;
	$api->dbConnect();
	$check = mysqli_query($api->db, "SELECT * FROM admin where (adminUsername='$email' or adminEmail='$email') and adminPassword='$pwd' LIMIT 1")  or die(mysqli_error($api->db));
    $num_rows = mysqli_num_rows($check);
    if($num_rows == 1)
    {
    	$res = mysqli_fetch_array($check);
      	$data = array("id"=>$res['adminId'],"name"=>$res['adminName'], "username"=>$res['adminName'], "password"=>$res['adminPassword'], "email"=>$res['adminEmail'], "role"=>$res['role']);
		$_SESSION['user_data'] = $data;
		header("location:index.php");
		exit();
     }
     else
     {
		header("location:login.php?msg=fail");
		exit();
     }
	mysqli_close($api->db);
      	
}

?>