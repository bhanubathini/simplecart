<?php
	ob_start();
	include_once("functions.php");
	require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		
		if($adid=$_GET['id'])
		{
			$q = mysqli_query($api->db, "SELECT * FROM n_ads WHERE ad_id = $adid");
			$row = mysqli_fetch_array($q);
									
										$title = $row['ad_title'];
										$id = $row['ad_id'];
										$description = $row['ad_description'];
										$url = $row['ad_url'];
										$img =$row['ad_image'];
										$act = $row['ad_act'];
										$date = $row['ad_date_added'];
		}
	if(isset($_POST['save']))
	{
		/*require_once("../api.php");
		$api = new API;
		$api->dbConnect();*/
		$title = mysqli_real_escape_string($api->db, $_POST['title']);
		$description = mysqli_real_escape_string($api->db, $_POST['description']);
		$url = mysqli_real_escape_string($api->db, $_POST['url']);
		$adid = $_POST['adid'];
		//img upload
	if(isset($_FILES["file"]["name"])){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	if ((($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg"))

	&& ($_FILES["file"]["size"] < 2000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
	    {
    		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			$file=$_FILES['file']['name'];
	        $type=$_FILES['file']['type'];
    	    $size=$_FILES['file']['size'];
        	$tempname=$_FILES['file']['tmp_name'];
	        $filedir="../uploads/ads/".str_replace(' ', '-', $title).$file;
    	    if(move_uploaded_file($tempname,"$filedir"))
			{
				$filedir = str_replace('../', '', $filedir);
			}
			else
			{
				$filedir = '';
			}
		}
	}
	}
	else if(isset($_POST['file']))
	{
		$filedir = mysqli_real_escape_string($api->db, $_POST['file']);
	}
		mysqli_query($api->db, "UPDATE n_ads SET ad_title='$title', ad_description='$description', ad_url='$url', ad_image='$filedir' WHERE ad_id=$adid");
		header('location:ad-edit.php?id='.$id);
	}

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ad management - Admin</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="index.html">
			  		Ad management - Admin
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
					<ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            hi <?php echo $_SESSION['user_data']['name']; ?>
                                <i class="icon-user"></i>
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="span3">
					<div class="sidebar">
						<?php include "side-menu.php"; ?>
					</div><!--/.sidebar-->
				</div><!--/.span3-->

				<div class="span9">
					<div class="content">
						<div class="module">
							<div class="module-head">
								<h3>Ad management</h3>
							</div>
							<div class="module-body">
									<form class="form-horizontal row-fluid" method="post" enctype="multipart/form-data">
										<div class="control-group">
											<label class="control-label" for="title">Title:</label>
											<div class="controls"><input type="hidden" name="adid" value="<?php echo $id; ?>">
                                            	<input type="text" value="<?php echo $title; ?>" name="title" id="title" class="span8">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="description">Description:</label>
											<div class="controls">
                                            	<textarea name="description" id="description" class="span8"><?php echo $description; ?></textarea>
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="url">Ad URL:</label>
											<div class="controls">
                                            	<input type="text" value="<?php echo $url; ?>" name="url" id="url" class="span8">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="file">Image</label>
                                            <div class="controls">
                                            <?php
											if($img!='')
											{
											?>
                                            <a class="btn btn-mini btn-danger rmv" id="filermv">Remove image</a>
                                            </div>
											<div class="controls">
                                             <input type="hidden" id="adid" value="<?php echo $id; ?>">
                                            <input type="hidden" name="file" id="fileimg" value="<?php echo $img; ?>" class="span8">
                                                <img src="../<?php echo $img; ?>" class="img-ser">
                                             <?php
											 }
											 else
											{
											?>
                                            <input type="file" id="file" name="file" class="span8">
                                            
                                            <?php
											}
											?> 
											</div>
										</div>
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="save">Save ad</button>
											</div>
                                            
										</div>
                                      
									</form>
							</div>
                            
						</div>

					
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			<b class="copyright">TricksTown.com</b>
		</div>
	</div>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
   	<script>
	$(document).ready(function () {
	
    	$('.rmv').click(function()
        {
			var cur = this.id;
        	var cid = $('#fileimg').val();
			var adid = $('#adid').val();
			//alert(cid);alert(adid);
			        	
		$.ajax({
			url: 'ajax/deleteAImage.php',
			type: 'POST',
			cache: false,
			data: {
				'name':cid,
				'adid':adid,
				},
			beforeSend: function(){

				$('#'+cur).text('deleting...');
			},
			success: function(data){
				
				$('#fileimg').val('');
				$('#fileimg').attr('type', 'file');
				$('.img-ser').hide();
				$('#'+cur).hide();
			},
			error: function(e){
				alert(e);
			}
		});
	return false;
        });
    });
		</script>
</body>
</html>
<?php ob_flush(); ?>