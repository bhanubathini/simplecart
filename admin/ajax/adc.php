<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include("../../config/db.php");
	$api = new db;
	$api->dbConnect();
	if (!empty($_POST['name'])) {
		$name = mysqli_real_escape_string($api->db, $_POST['name']);
		//$l = strtolower($name);
		//$s = str_replace(' ', '-', $l);
		if($name != ""){
			$q = mysqli_query($api->db, "INSERT INTO productcategories(CategoryName) VALUES('$name')");
		}
		
		
		//mysqli_query($api->db, "INSERT INTO n_menu(menu_title, menu_slug) VALUES('$name', '$s')");
		$g = mysqli_query($api->db, "SELECT * FROM productcategories WHERE CategoryParentId=0");
?>
		<select tabindex="1" data-placeholder="Select here.." class="span8" name="scatsel" id="scatsel">
			<option value="0">Select here..</option>
<?php	
		while($row = mysqli_fetch_array($g))
		{
			echo '<option value="'.$row['CategoryId'].'">'.$row['CategoryName'].'</option>';
		}
?>
		</select>
<?php
	}
	
	if (!empty($_POST['sname']) && !empty($_POST['scatsel'])) {
		$sname = mysqli_real_escape_string($api->db, $_POST['sname']);
		$scatsel = mysqli_real_escape_string($api->db, $_POST['scatsel']);
		if($sname != ""){
			$q = mysqli_query($api->db, "INSERT INTO productcategories(CategoryName, CategoryParentId) VALUES('$sname','$scatsel')");
		}
			
	}
	


}
?>
