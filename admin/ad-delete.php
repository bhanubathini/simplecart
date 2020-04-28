<?php
	ob_start();
	include_once("functions.php");
	$del = @$_GET['id'];
	function deleteAd($del)
	{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$get = mysqli_query($api->db, "SELECT * FROM n_ads WHERE ad_id = '$del'")  or die(mysqli_error($api->db));
	
	$r = mysqli_fetch_array($get);
	unlink("../".$r['ad_image']);
	
	
	$get = mysqli_query($api->db, "DELETE FROM n_ads WHERE ad_id = '$del'")  or die(mysqli_error($api->db));
	}
		if(isset($del))
		{
			deleteAd($del);	
			//delete

			header('location:view-ads.php');
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