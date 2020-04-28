<?php
function add_subcategory()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$name = mysqli_real_escape_string($api->db, $_POST['subcategory']);
		$catsel = $_POST['catsel'];
		mysqli_query($api->db, "INSERT INTO n_subcategory(subcat_name, subcat_parent) VALUES('$name', '$catsel')");
}
function add_category()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$name = mysqli_real_escape_string($api->db, $_POST['category']);
		mysqli_query($api->db, "INSERT INTO n_category(cat_name) VALUES('{$name}')");
}
?>