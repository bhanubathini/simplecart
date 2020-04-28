<?php
function addService()
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	//front img upload
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = pathinfo($_FILES['frontimg']['name'], PATHINFO_EXTENSION);
	if ((($_FILES["frontimg"]["type"] == "image/png")
	|| ($_FILES["frontimg"]["type"] == "image/gif")
	|| ($_FILES["frontimg"]["type"] == "image/jpeg"))

	&& ($_FILES["frontimg"]["size"] < 2000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["frontimg"]["error"] > 0)
	    {
    		echo "Return Code: " . $_FILES["frontimg"]["error"] . "<br />";
		}
		else
		{
			$frontimg=$_FILES['frontimg']['name'];
	        $type=$_FILES['frontimg']['type'];
    	    $size=$_FILES['frontimg']['size'];
        	$tempname=$_FILES['frontimg']['tmp_name'];
	        $frontimgdir="../uploads/services/front/".time().$frontimg;
    	    if(move_uploaded_file($tempname,"$frontimgdir"))
			{
				$frontimgdir = str_replace('../', '', $frontimgdir);
			}
			else
			{
				$frontimgdir = '';
			}
		}
	}

	//back image upload
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = pathinfo($_FILES['inimg']['name'], PATHINFO_EXTENSION);
	if ((($_FILES["inimg"]["type"] == "image/png")
	|| ($_FILES["inimg"]["type"] == "image/gif")
	|| ($_FILES["inimg"]["type"] == "image/jpeg"))

	&& ($_FILES["inimg"]["size"] < 2000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["inimg"]["error"] > 0)
	    {
    		echo "Return Code: " . $_FILES["inimg"]["error"] . "<br />";
	    }
		else
		{
			$inimg=$_FILES['inimg']['name'];
	        $type=$_FILES['inimg']['type'];
    	    $size=$_FILES['inimg']['size'];
        	$tempname=$_FILES['inimg']['tmp_name'];
	        $inimgdir="../uploads/services/back/".time().$inimg;
			if(move_uploaded_file($tempname,"$inimgdir"))
			{
				$inimgdir = str_replace('../', '', $inimgdir);
			}
			else
			{
				$inimgdir = '';	
			}
		}
	}

		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$categoryinput = mysqli_real_escape_string($api->db, $_POST['categoryinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);

	/*$description = mysqli_real_escape_string($api->db, $_POST['edescription']);*/
	$ins = mysqli_query($api->db, "INSERT INTO n_services(ser_title, ser_cat, ser_front_img, ser_back_img, ser_description) VALUES('$titleinput', '$categoryinput', '$frontimgdir', '$inimgdir', '$descriptioninput') ")  or die(mysqli_error($api->db));
}

//edit
function editService()
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	if(isset($_FILES["frontimg"]["name"]))
	{
	//front img upload
	$frontimg=$_FILES['frontimg']['name'];
        $type=$_FILES['frontimg']['type'];
        $size=$_FILES['frontimg']['size'];
        $tempname=$_FILES['frontimg']['tmp_name'];
        $frontimgdir="../uploads/services/front/".time().$frontimg;
        if(move_uploaded_file($tempname,"$frontimgdir"))
		{
			$frontimgdir = str_replace('../', '', $frontimgdir);
		}
		else
		{
			$frontimgdir = '';
		}
	}
	elseif(isset($_POST['frontimg']))
	{
		$frontimgdir = mysqli_real_escape_string($api->db, $_POST['frontimg']);
	}
	if(isset($_FILES["inimg"]["name"]))
	{
	//back image upload
	$inimg=$_FILES['inimg']['name'];
        $type=$_FILES['inimg']['type'];
        $size=$_FILES['inimg']['size'];
        $tempname=$_FILES['inimg']['tmp_name'];
        $inimgdir="../uploads/services/back/".time().$inimg;
		if(move_uploaded_file($tempname,"$inimgdir"))
		{
			$inimgdir = str_replace('../', '', $inimgdir);
		}
		else
		{
			$inimgdir = '';	
		}
	}
	elseif(isset($_POST['inimg']))
	{
		$inimgdir = mysqli_real_escape_string($api->db, $_POST['inimg']);
	}

		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$categoryinput = mysqli_real_escape_string($api->db, $_POST['categoryinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);

	
	$ins = mysqli_query($api->db, "UPDATE n_services SET ser_title='$titleinput', ser_cat='$categoryinput', ser_front_img='$frontimgdir', ser_back_img='$inimgdir', ser_description='$descriptioninput'")  or die(mysqli_error($api->db));
}
//GET SERVICE
function getService($id)
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$get = mysqli_query($api->db, "SELECT * FROM n_services WHERE ser_id = '$id'")  or die(mysqli_error($api->db));
	global $r;
	$r = mysqli_fetch_array($get);
}
//delete
function deleteService($del)
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$get = mysqli_query($api->db, "SELECT * FROM n_services WHERE ser_id = '$del'")  or die(mysqli_error($api->db));
	
	$r = mysqli_fetch_array($get);
	unlink("../".$r['ser_front_img']);
	unlink("../".$r['ser_back_img']);
	
	$get = mysqli_query($api->db, "DELETE FROM n_services WHERE ser_id = '$del'")  or die(mysqli_error($api->db));
}
?>