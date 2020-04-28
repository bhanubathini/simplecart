<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include('../../api.php');
	$api = new API;
	$api->dbConnect();
	if (!empty($_POST['name'])) {
	$catid = mysqli_real_escape_string($api->db, $_POST['name']);
unlink('../../'.$catid);
	
		echo $serid = $_POST['serid'];
		echo $_POST['imgtype'];
	if($_POST['imgtype']=='frontimg')
	{
		
		$q = mysqli_query($api->db, "UPDATE n_services SET ser_front_img='' WHERE ser_id='$serid'");	
	}
	elseif($_POST['imgtype']=='inimg')
	{
		
		$q = mysqli_query($api->db, "UPDATE n_services SET ser_back_img='' WHERE ser_id='$serid'");	
	}
	
		
	}

}
?>
