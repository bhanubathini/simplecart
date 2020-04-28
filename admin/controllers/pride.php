<?php
function addPride()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
	
		$ins = mysqli_query($api->db, "INSERT INTO n_pride(pr_title, pr_description) VALUES('$titleinput', '$descriptioninput')")  or die(mysqli_error($api->db));
		$prideId = mysqli_insert_id($api->db);
		$vlist = mysqli_real_escape_string($api->db, $_POST['video']);
		$vlist = str_replace(" ", "", $vlist);
		$videos = explode(",", $vlist);
		foreach($videos as $values)
		{
				if(!empty($values))
				{
					$query = "INSERT INTO n_pr_videos(prvid_url, pr_id) VALUES('$values', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
				}
		}
		$videodest = "../uploads/pride/video/";
		while(list($key,$value) = each($_FILES["video"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (/*($_FILES["video"]["type"][$key] == "video/mp4")*/
				/*|| ($_FILES["video"]["type"][$key] == "video/jpeg")
				|| ($_FILES["video"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["video"]["type"][$key] == "image/png")
				&& */($_FILES["video"]["size"][$key] < 20000000))
			    {

					$vidsrc = $_FILES["video"]["tmp_name"][$key] ;
					$fname = $_FILES["video"]["name"][$key] ;
					global $vidname;
					$vidname = time().$fname;
					if(move_uploaded_file($vidsrc, $videodest . $vidname))
					{	
						
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO n_pr_videos(prvid_url, pr_id) VALUES('$vidname', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
					}

    			}
				else{echo "error in video upload";}
			}
		}
		//image upload
		$picdest = "../uploads/pride/large/";
		while(list($key,$value) = each($_FILES["file"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (/*($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "video/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				&& */($_FILES["file"]["size"][$key] < 20000000))
			    {

					$picsrc = $_FILES["file"]["tmp_name"][$key] ;
					$fname = $_FILES["file"]["name"][$key] ;
					global $picname;
					$picname = time().$fname;
					if(move_uploaded_file($picsrc, $picdest . $picname))
					{	
						$tsrc="../uploads/pride/thumbs/".$picname;
						images($picname, $picdest, $key, $tsrc);
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO pr_images(primg_url, pr_id) VALUES('$picname', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
					}

    			}
				else{echo "error in image upload";}
			}
		}
}

//edit
function editPride()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$prideId = mysqli_real_escape_string($api->db, $_POST['prid']);
		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
	
		$ins = mysqli_query($api->db, "UPDATE n_pride SET pr_title='$titleinput', pr_description='$descriptioninput' WHERE pr_id=$prideId") or die(mysqli_error($api->db));
		$vlist = mysqli_real_escape_string($api->db, $_POST['video']);
		$vlist = str_replace(" ", "", $vlist);
		$videos = explode(",", $vlist);
		foreach($videos as $values)
		{
				if(!empty($values))
				{
					$query = "INSERT INTO n_pr_videos(prvid_url, pr_id) VALUES('$values', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
				}
		}
		$videodest = "../uploads/pride/video/";
		while(list($key,$value) = each($_FILES["video"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (/*($_FILES["video"]["type"][$key] == "video/mp4")*/
				/*|| ($_FILES["video"]["type"][$key] == "video/jpeg")
				|| ($_FILES["video"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["video"]["type"][$key] == "image/png")
				&& */($_FILES["video"]["size"][$key] < 20000000))
			    {

					$vidsrc = $_FILES["video"]["tmp_name"][$key] ;
					$fname = $_FILES["video"]["name"][$key] ;
					global $vidname;
					$vidname = time().$fname;
					if(move_uploaded_file($vidsrc, $videodest . $vidname))
					{	
						
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO n_pr_videos(prvid_url, pr_id) VALUES('$vidname', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
					}

    			}
				else{echo "error in video upload";}
			}
		}
		//image upload
		$picdest = "../uploads/pride/large/";
		while(list($key,$value) = each($_FILES["file"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (/*($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "video/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				&& */($_FILES["file"]["size"][$key] < 20000000))
			    {

					$picsrc = $_FILES["file"]["tmp_name"][$key] ;
					$fname = $_FILES["file"]["name"][$key] ;
					global $picname;
					$picname = time().$fname;
					if(move_uploaded_file($picsrc, $picdest . $picname))
					{	
						$tsrc="../uploads/pride/thumbs/".$picname;
						images($picname, $picdest, $key, $tsrc);
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO pr_images(primg_url, pr_id) VALUES('$picname', '$prideId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
					}

    			}
				else{echo "error in image upload";}
			}
		}
}
//view
function prideShow()
{
	require_once("../api.php");
	global $api;
	global $pcheck;
	 $api = new API;
	$api->dbConnect();
	
	$pcheck = mysqli_query($api->db, "SELECT * FROM n_pride ORDER BY pr_id DESC")  or die(mysql_error($api->db));
    $num_rows = mysqli_num_rows($pcheck);
	
    if($num_rows > 0)
    {
    	
    }
	else
	{
		header('location:../404.php');
	}
	
}
//delete
function deletePride($del)
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$getimg = mysqli_query($api->db, "SELECT * FROM pr_images WHERE pr_id = '$del'")  or die(mysqli_error($api->db));
	
	while($r = mysqli_fetch_array($getimg))
	{
		if($r['primg_url']!='')
		{
			unlink("../uploads/pride/large/".$r['primg_url']);
			unlink("../uploads/pride/thumbs/".$r['primg_url']);
		}
	}
	$getvid = mysqli_query($api->db, "SELECT * FROM n_pr_videos WHERE pr_id = '$del'")  or die(mysqli_error($api->db));
	
	while($r = mysqli_fetch_array($getvid))
	{
		if($r['prvid_url']!='')
		{
			unlink("../uploads/pride/video/".$r['prvid_url']);
			
		}
	}
	mysqli_query($api->db, "DELETE FROM pr_images WHERE pr_id = '$del'")  or die(mysqli_error($api->db));
	mysqli_query($api->db, "DELETE FROM n_pr_videos WHERE pr_id = '$del'")  or die(mysqli_error($api->db));
	
	
	
	$delete = mysqli_query($api->db, "DELETE FROM n_pride WHERE pr_id = '$del'")  or die(mysqli_error($api->db));
}
//get

function getPride($id)
{
	require_once("../api.php");
	global $api;
	global $pcheck;
	 $api = new API;
	$api->dbConnect();
	
	$pcheck = mysqli_query($api->db, "SELECT * FROM n_pride 
							where pr_id='$id'")  or die(mysql_error($api->db));
    $num_rows = mysqli_num_rows($pcheck);
	
    if($num_rows > 0)
    {
    	
    }
	else
	{
		header('location:pedit.php?msg=404');
	}
	
}
?>