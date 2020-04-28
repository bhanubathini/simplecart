<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include('../../api.php');
	$api = new API;
	$api->dbConnect();
	if (!empty($_POST['name'])) {
	 $name = mysqli_real_escape_string($api->db, $_POST['name']);
	 $adid = mysqli_real_escape_string($api->db, $_POST['adid']);
unlink('../'.$name);
		$q = mysqli_query($api->db, "UPDATE n_products SET p_url='' WHERE p_id=$adid");	
	
		
	}

}
?>
