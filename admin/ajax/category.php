<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include('../../api.php');
	$api = new API;
	$api->dbConnect();
	if (!empty($_POST['catid'])) {
		$catid = mysqli_real_escape_string($api->db, $_POST['catid']);
		$q = mysqli_query($api->db, "SELECT * FROM n_subcategory WHERE subcat_parent='$catid'");	
?>
		<select tabindex="1" data-placeholder="Select here.." class="span8" id="subcatsel" name="subcatsel">
        <option value="0">Select here..</option>
<?php	
		while($row = mysqli_fetch_array($q))
		{
			echo '<option value="'.$row['subcat_name'].'">'.$row['subcat_name'].'</option>';
		}
	}
?>
		</select>
<?php
}
?>
