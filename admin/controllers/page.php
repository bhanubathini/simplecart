<?php
//add
function addPage()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		/*$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);*/
		$catsel = mysqli_real_escape_string($api->db, $_POST['catsel']);
		$subcatsel = mysqli_real_escape_string($api->db, $_POST['subcatsel']);
		if($catsel==1)
		{
			if($subcatsel=='Welcome to pregnancy')
			{
				$order = 1;
			}
			else if($subcatsel=='Nutrition')
			{
				$order = 2;
			}
			else if($subcatsel=='Health issues')
			{
				$order = 3;
			}
			else if($subcatsel=='Emotional change')
			{
				$order = 4;
			}
			else if($subcatsel=='Fitness')
			{
				$order = 5;
			}
			else { $order = ''; }
			
		}
		else if($catsel==2)
		{
			if($subcatsel=='Recover from child birth')
			{
				$order = 1;
			}
			else if($subcatsel=='Vaccination')
			{
				$order = 2;
			}
			else if($subcatsel=='Baby nutrition')
			{
				$order = 3;
			}
			else if($subcatsel=='Baby bathing and body care')
			{
				$order = 4;
			}
			else if($subcatsel=='Feeding')
			{
				$order = 5;
			}
			else { $order = ''; }
			
		}
		else if($catsel==3)
		{
			if($subcatsel=='Bathing and grooming')
			{
				$order = 1;
			}
			else if($subcatsel=='Nutrition')
			{
				$order = 2;
			}
			else if($subcatsel=='Training')
			{
				$order = 3;
			}
			else if($subcatsel=='Illness and condition')
			{
				$order = 4;
			}
			else { $order = ''; }
			
			
		}
		$weeksel = mysqli_real_escape_string($api->db, $_POST['weeksel']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
		$vlist = mysqli_real_escape_string($api->db, $_POST['video']);
		
		$checkq = mysqli_query($api->db, "SELECT * FROM n_page WHERE pg_category='$catsel' AND pg_subcategory='$subcatsel' AND pg_week = '$weeksel'");
		$num = mysqli_num_rows($checkq); //echo $num;
		if($num<1)
		{
		mysqli_query($api->db, "INSERT INTO n_page(pg_order, pg_category, pg_subcategory, pg_week, pg_description) VALUES('$order', '$catsel', '$subcatsel', '$weeksel', '$descriptioninput')");
		global $pageId;
		$pageId = mysqli_insert_id($api->db);
		global $destpath;	
		$destpath = "../uploads/large/";
		global $tsrc;
		
		$vlist = str_replace(" ", "", $vlist);
		$videos = explode(",", $vlist);
		foreach($videos as $values)
		{
			$query = "INSERT INTO n_page_videos(pagevid_url, pagevid_pgid) VALUES('$values', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
		}
		while(list($key,$value) = each($_FILES["file"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "image/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				&& ($_FILES["file"]["size"][$key] < 2000000))
			    {

					$source = $_FILES["file"]["tmp_name"][$key] ;
					$fname = $_FILES["file"]["name"][$key] ;
					global $filename;
					$filename = time().$fname;
					if(move_uploaded_file($source, $destpath . $filename))
					{	
						$tsrc="../uploads/thumbs/".$filename;
						images($filename, $destpath, $key, $tsrc);
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO n_page_images(pgimg_url, pgimg_page_id) VALUES('$filename', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
						
					}

    			}
				else{echo "error in upload";}
			}
		}
//		/video

$videodest = "../uploads/video/";
		while(list($key,$value) = each($_FILES["video"]["name"])) 
		{
			if(!empty($value))
			{
				if (/*($_FILES["video"]["type"][$key] == "video/mp4")*/
				/*|| ($_FILES["video"]["type"][$key] == "video/jpeg")
				|| ($_FILES["video"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["video"]["type"][$key] == "image/png")
				&& */
				($_FILES["video"]["type"][$key] == "video/mp4")
				&& ($_FILES["video"]["size"][$key] < 20000000))
			    {

					$vidsrc = $_FILES["video"]["tmp_name"][$key] ;
					$fname = $_FILES["video"]["name"][$key] ;
					global $vidname;
					$vidname = time().$fname;
					if(move_uploaded_file($vidsrc, $videodest . $vidname))
					{	
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO n_page_videos(pagevid_url, pagevid_pgid) VALUES('$vidname', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
					}

    			}
				else{echo "error in video upload";}
			}
		}
			header('location:main-pages.php?id='.$catsel.'&msg=success');
		}
		else
		{
			header('location:main-pages.php?id='.$catsel.'&error=exist');
		}
}
//show
function pageShow()
{
	require_once("../api.php");
	global $api;
	global $pcheck;
	 $api = new API;
	$api->dbConnect();
	if($catid=@$_GET['subcat'])
	{
	/*$pcheck = mysqli_query($api->db, "SELECT * FROM n_page where pg_subcategory='$catid' ORDER BY pg_id")  or die(mysql_error());*/
	$pcheck = mysqli_query($api->db, "SELECT * FROM n_page p
							join n_subcategory s on p.pg_subcategory = s.subcat_name
							where s.subcat_id='$catid'")  or die(mysql_error($api->db));
    $num_rows = mysqli_num_rows($pcheck);
	
    if($num_rows > 0)
    {
    	
    }
	else
	{
		header('location:../404.php');
	}
	}
}


//get page
function getShow($id)
{
	require_once("../api.php");
	global $api;
	global $pcheck;
	 $api = new API;
	$api->dbConnect();
	
	$pcheck = mysqli_query($api->db, "SELECT * FROM n_page 
							where pg_id='$id'")  or die(mysql_error($api->db));
    $num_rows = mysqli_num_rows($pcheck);
	
    if($num_rows > 0)
    {
    	
    }
	else
	{
		header('location:pedit.php?msg=404');
	}
	
}

//delete
function deletePage($del)
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$getimg = mysqli_query($api->db, "SELECT * FROM n_page_images WHERE pgimg_page_id = '$del'")  or die(mysqli_error($api->db));
	
	while($r = mysqli_fetch_array($getimg))
	{
		if($r['pgimg_url']!='')
		{
			unlink("../uploads/large/".$r['pgimg_url']);
			unlink("../uploads/thumbs/".$r['pgimg_url']);
		}
		mysqli_query($api->db, "DELETE FROM n_page_images WHERE pgimg_page_id = '$del'")  or die(mysqli_error($api->db));
	}
	
	
	$getvid = mysqli_query($api->db, "SELECT * FROM n_page_videos WHERE pagevid_pgid = '$del'")  or die(mysqli_error($api->db));
	
	while($r = mysqli_fetch_array($getvid))
	{
		if($r['pagevid_url']!='')
		{
			unlink("../uploads/video/".$r['pagevid_url']);
		}
		mysqli_query($api->db, "DELETE FROM n_page_videos WHERE pagevid_pgid = '$del'")  or die(mysqli_error($api->db));
		
	}

	$delete = mysqli_query($api->db, "DELETE FROM n_page WHERE pg_id = '$del'")  or die(mysqli_error($api->db));
}

//add
function editPage()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		/*$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);*/
		global $pageId;
		$pageId =  mysqli_real_escape_string($api->db, $_POST['pageid']);
		$catsel = mysqli_real_escape_string($api->db, $_POST['catsel']);
		$subcatsel = mysqli_real_escape_string($api->db, $_POST['subcatsel']);
		if($catsel==1)
		{
			if($subcatsel=='Welcome to pregnancy')
			{
				$order = 1;
			}
			else if($subcatsel=='Nutrition')
			{
				$order = 2;
			}
			else if($subcatsel=='Health issues')
			{
				$order = 3;
			}
			else if($subcatsel=='Emotional change')
			{
				$order = 4;
			}
			else if($subcatsel=='Fitness')
			{
				$order = 5;
			}
			else { $order = ''; }
			
		}
		else if($catsel==2)
		{
			if($subcatsel=='Recover from child birth')
			{
				$order = 1;
			}
			else if($subcatsel=='Vaccination')
			{
				$order = 2;
			}
			else if($subcatsel=='Baby nutrition')
			{
				$order = 3;
			}
			else if($subcatsel=='Baby bathing and body care')
			{
				$order = 4;
			}
			else if($subcatsel=='Feeding')
			{
				$order = 5;
			}
			else { $order = ''; }
			
		}
		else if($catsel==1)
		{
			if($subcatsel=='Bathing and grooming')
			{
				$order = 1;
			}
			else if($subcatsel=='Nutrition')
			{
				$order = 2;
			}
			else if($subcatsel=='Training')
			{
				$order = 3;
			}
			else if($subcatsel=='Illness and condition')
			{
				$order = 4;
			}
			else { $order = ''; }
			
			
		}
		$weeksel = mysqli_real_escape_string($api->db, $_POST['weeksel']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
		mysqli_query($api->db, "UPDATE n_page SET pg_order='$order', pg_category='$catsel', pg_subcategory='$subcatsel', pg_week='$weeksel', pg_description='$descriptioninput' WHERE pg_id='$pageId'");
		
		global $destpath;	
		$destpath = "../uploads/large/";
		global $tsrc;
		$vlist = mysqli_real_escape_string($api->db, $_POST['video']);
		$vlist = str_replace(" ", "", $vlist);
		$videos = explode(",", $vlist);
		foreach($videos as $values)
		{
			$query = "INSERT INTO n_page_videos(pagevid_url, pagevid_pgid) VALUES('$values', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
		}
		while(list($key,$value) = each($_FILES["file"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "image/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				&& ($_FILES["file"]["size"][$key] < 2000000))
			    {

					$source = $_FILES["file"]["tmp_name"][$key] ;
					$fname = $_FILES["file"]["name"][$key] ;
					global $filename;
					$filename = time().$fname;
					if(move_uploaded_file($source, $destpath . $filename))
					{	
						$tsrc="../uploads/thumbs/".$filename;
						images($filename, $destpath, $key, $tsrc);
						
						$query = "INSERT INTO n_page_images(pgimg_url, pgimg_page_id) VALUES('$filename', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
						
					}

    			}
				else{echo "error in upload";}
			}
		}
//		/video

$videodest = "../uploads/video/";
		while(list($key,$value) = each($_FILES["video"]["name"])) 
		{
   
			if(!empty($value))
			{
				if (($_FILES["video"]["type"][$key] == "video/mp4")
				&& ($_FILES["video"]["size"][$key] < 20000000))
			    {

					$vidsrc = $_FILES["video"]["tmp_name"][$key] ;
					$fname = $_FILES["video"]["name"][$key] ;
					global $vidname;
					$vidname = time().$fname;
					if(move_uploaded_file($vidsrc, $videodest . $vidname))
					{	
						
						$query = "INSERT INTO n_page_videos(pagevid_url, pagevid_pgid) VALUES('$vidname', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error($api->db)."update failed");
						
					}

    			}
				else{echo "error in video upload";}
			}
		}
}
?>