<?php
//admin login
 function signin($email,$pwd)
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	$check = mysqli_query($api->db, "SELECT * FROM n_admin where adm_username='$email' and adm_password='$pwd'")  or die(mysql_error());
    $num_rows = mysqli_num_rows($check);
    if($num_rows > 0)
    {
    	$res = mysqli_fetch_array($check);
		
      	$data = array("id"=>$res['adm_id'],"name"=>$res['adm_name'], "username"=>$res['adm_username'], "password"=>$res['adm_password'], "email"=>$res['adm_email'], "access_date"=>$res['adm_access_date'], "access_ip"=>$res['adm_access_ip']);
		$_SESSION['user_data'] = $data;
		header("location:index.php");
		
     }
     else
     {
		header("location:login.php");
     }
	 mysqli_close($api->db);
      	
}
//admin logout
function logout()
{
	echo "...Logout";
	unset($_SESSION['user_data']);
	session_destroy();
	header('Location: login.php');
}

//add category
function add_category()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$name = mysqli_real_escape_string($api->db, $_POST['category']);
		mysqli_query($api->db, "INSERT INTO n_category(cat_name) VALUES('{$name}')");
}
//add sub category
function add_subcategory()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$name = mysqli_real_escape_string($api->db, $_POST['subcategory']);
		$catsel = $_POST['catsel'];
		mysqli_query($api->db, "INSERT INTO n_subcategory(subcat_name, subcat_parent) VALUES('$name', '$catsel')");
}


//pages add
function addPage()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		/*$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);*/
		$catsel = mysqli_real_escape_string($api->db, $_POST['catsel']);
		$subcatsel = mysqli_real_escape_string($api->db, $_POST['subcatsel']);
		$weeksel = mysqli_real_escape_string($api->db, $_POST['weeksel']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
		mysqli_query($api->db, "INSERT INTO n_page(pg_category, pg_subcategory, pg_week, pg_description) VALUES('$catsel', '$subcatsel', '$weeksel', '$descriptioninput')");
		global $pageId;
		$pageId = mysqli_insert_id($api->db);
		global $destpath;	
		$destpath = "../uploads/large/";
		global $tsrc;
		
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
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
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
				&& */($_FILES["video"]["size"][$key] < 20000000))
			    {

					$vidsrc = $_FILES["video"]["tmp_name"][$key] ;
					$fname = $_FILES["video"]["name"][$key] ;
					global $vidname;
					$vidname = time().$fname;
					if(move_uploaded_file($vidsrc, $videodest . $vidname))
					{	
						
						/*mysqli_query($api->db, "INSERT INTO n_page_images(pgimg_page_id) VALUES('$pageId')");*/
						$query = "INSERT INTO n_page_videos(pagevid_url, pagevid_pgid) VALUES('$vidname', '$pageId')";
				      	mysqli_query($api->db, $query) or die(mysqli_error()."update failed");
						
					}

    			}
				else{echo "error in video upload";}
			}
		}
}
//insert page images
/*function addPageImage($pageId)
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
				
		
}*/

//photo thumbnails
function images($filename, $destpath, $key, $tsrc)
{

//thumbnail creation start//


$n_width=99;
$n_height=66;
// Starting of GIF thumb nail creation//
$add=$destpath . $filename;
if($_FILES["file"]["type"][$key]=="image/gif"){
//echo "hello";
$im=ImageCreateFromGIF($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagegif")) {
Header("Content-type: image/gif");
ImageGIF($newimage,$tsrc);
}
if (function_exists("imagejpeg")) {
Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
    }

// end of gif file thumb nail creation//
$n_width=99;
$n_height=66;    

// starting of JPG thumb nail creation//
if($_FILES["file"]["type"][$key]=="image/jpeg"){
     $_FILES["file"]["name"][$key]."<br>";
$im=ImageCreateFromJPEG($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);               
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
ImageJpeg($newimage,$tsrc);
chmod("$tsrc",0777);
}
//  End of png thumb nail creation ///
if($_FILES["file"]["type"][$key]=="image/png"){
//echo "hello";
$im=ImageCreateFromPNG($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagepng")) {
//Header("Content-type: image/png");
ImagePNG($newimage,$tsrc);
}
if (function_exists("imagejpeg")) {
//Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
    }

// thumbnail creation end---
    


}

//add service
function addService()
{
	require_once("../api.php");
	$api = new API;
	$api->dbConnect();
	//video upload
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

	//image upload
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

		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$categoryinput = mysqli_real_escape_string($api->db, $_POST['categoryinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);

	/*$description = mysqli_real_escape_string($api->db, $_POST['edescription']);*/
	$ins = mysqli_query($api->db, "INSERT INTO n_services(ser_title, ser_cat, ser_front_img, ser_back_img, ser_description) VALUES('$titleinput', '$categoryinput', '$frontimgdir', '$inimgdir', '$descriptioninput') ")  or die(mysqli_error($api->db));
}

//add pride
function addPride()
{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$titleinput = mysqli_real_escape_string($api->db, $_POST['titleinput']);
		$descriptioninput = mysqli_real_escape_string($api->db, $_POST['descriptioninput']);
	
		$ins = mysqli_query($api->db, "INSERT INTO n_pride(pr_title, pr_description) VALUES('$titleinput', '$descriptioninput')")  or die(mysqli_error($api->db));
		$prideId = mysqli_insert_id($api->db);
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

//page
function pageShow()
{
	require_once("../api.php");
	global $api;
	global $pcheck;
	 $api = new API;
	$api->dbConnect();
	if($catid=@$_GET['cat'])
	{
	$pcheck = mysqli_query($api->db, "SELECT * FROM n_page where pg_category='$catid' ORDER BY pg_id")  or die(mysql_error());
    $num_rows = mysqli_num_rows($pcheck);
	
    if($num_rows > 0)
    {
    	
    }
	}
}
?>