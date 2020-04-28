<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include('../api.php');
	$api = new API;
	$api->dbConnect();
	if (!empty($_POST['week']) && !empty($_POST['catid']) && !empty($_POST['subcat'])) {
		$week = mysqli_real_escape_string($api->db, $_POST['week']);
		$catid = mysqli_real_escape_string($api->db, $_POST['catid']);
		$subcat = mysqli_real_escape_string($api->db, $_POST['subcat']);
		$q = mysqli_query($api->db, "SELECT * FROM n_page WHERE pg_category='$catid' and pg_subcategory='$subcat' and pg_week='$week' ORDER BY pg_id LIMIT 1");	
	
		while($row = mysqli_fetch_array($q))
		{
?>
		<h3><?php echo $prow['pg_subcategory']; ?></h3>
<?php
			echo $row['pg_description'];
		}
	}

}
?>
