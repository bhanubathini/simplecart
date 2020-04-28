<?php
	ob_start();
	include_once("functions.php");
	if(isset($_POST['submitpride']))
	{
	
		editPride();	
				
		/*header('location:pride.php?msg=success');*/
	}
	$id = @$_GET['id'];
	getPride($id);
	$prow = mysqli_fetch_array($pcheck);
	$title = $prow['pr_title'];
	
	
	
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?> | Naani's pride</title>
   

  <!--  <link type="text/css" rel="stylesheet" href="jqte/jquery-te-1.4.0.css">-->
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
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.php">Naani's pride </a>
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
                    </div>
                    <!-- /.nav-collapse -->
                </div>
             </div>
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
						<?php
							if(@$_GET['msg']=='success')
							{
						?>
                        	<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong> Your page has been published successfully :) 
							</div>
                        <?php
							}
						?>

                        
                        <div class="module">
                        	<div class="pull-right">
                         	<a href="pride-view.php" class="btn btn-primary">View all</a>
                       		</div>
							<div class="module-head">
								<h3><?php echo $title; ?> | Naani's pride</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="prideform" enctype="multipart/form-data">
                                    <input type="hidden" name="prid" id="prid" value="<?php echo $id; ?>">
										<div class="control-group">
											<label class="control-label" for="titleinput">Title</label>
											<div class="controls">
												<input type="text" id="titleinput" name="titleinput" value="<?php echo $title;  ?>" class="span8">
											</div>
										</div>
										
                                        
                                       
											
                                         <div class="control-group">
											<label class="control-label" for="pics">Photos</label>
											<div class="controls">
                                            <input type="file" id="pics" name="file[]" class="span8" multiple="multiple">
												Any multiple of 600x300 px
											</div>
										</div>
                                         <div class="control-group">
                                             <?php
											 $pid = $prow['pr_id'];
											 $fq = mysqli_query($api->db, "SELECT * FROM pr_images where pr_id='$pid'")  or die(mysql_error($api->db));
											 $fi = 1;
											 while($fr = mysqli_fetch_array($fq))
											 {
											if($fr['primg_url']!='')
											{
											?>
                                           <div class="control-group-image" id="<?php echo $fi; ?>imgrcont">
                                            <div class="controls">
                                             <a class="btn btn-mini btn-danger rmv" id="<?php echo $fi; ?>imgr">Remove image</a>
                                            
											<input type="hidden" id="<?php echo $fi; ?>imgrmv" name="imgrmv" value="<?php echo $fr['primg_url']; ?>">
											<img src="../uploads/pride/thumbs/<?php echo $fr['primg_url']; ?>" class="img-pg">
                                             </div>
                                              </div>	
                                            
                                            <?php
											}
											$fi++;
											}
											?>
                                        </div>
                                        
                                        <div class="control-group">
											<label class="control-label" for="vids">Video</label>
											<div class="controls">
                                            <input type="file" id="vids" name="video[]" class="span8" multiple="multiple">
												
											</div>
                                            <br>
                                            <div class="controls">Or</div><br>
                                            <div class="controls">
                                            <input type="text" id="" name="video" class="span8" placeholder="Youtube url's separated by commas">
											</div>
										</div>
                                        
                                        <div class="control-group">
                                             <?php
											 $pid = $prow['pr_id'];
											 $fq = mysqli_query($api->db, "SELECT * FROM n_pr_videos where pr_id='$pid'")  or die(mysql_error($api->db));
											 $fi = 1;
											 while($fr = mysqli_fetch_array($fq))
											 {
											if($fr['prvid_url']!='')
											{
											?>
                                           <div class="control-group-image" id="<?php echo $fi; ?>vidrcont">
                                            <div class="controls">
                                             <a class="btn btn-mini btn-danger rmv" id="<?php echo $fi; ?>vidr">Remove image</a>
                                            
											<input type="hidden" id="<?php echo $fi; ?>vidrmv" name="vidrmv" value="<?php echo $fr['prvid_url']; ?>">
                                            <video width="100%" controls>
					  							<source src="../uploads/pride/video/<?php echo $fr['prvid_url']; ?>" type="video/mp4">
  					  							Your browser does not support the video tag.
											</video>
											
                                             </div>
                                              </div>	
                                            
                                            <?php
											}
											$fi++;
											}
											?>
                                        </div>
                                        
                                         <div class="control-group">
											<label class="control-label" for="descriptioninput">Description</label>
											<div class="controls">
                                            <textarea name="descriptioninput" id="descriptioninput" rows="5" > <?php echo $prow['pr_description']; ?></textarea>
                                           
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submitpride" id="submitpride">Save</button>
                                                <div id="err"></div>
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
   <?php include 'controllers/tinymce.php'; ?>
	<script>
	$(document).ready(function () {
	
    	$('.rmv').click(function()
        {
			var cur = this.id;
        	var cid = $('#'+cur+'mv').val();
			var pid = $('#prid').val();
			        	
		$.ajax({
			url: 'ajax/deletePImage.php',
			type: 'POST',
			cache: false,
			data: {
				'prname':cid,
				'prcur':cur,
				'pid':pid,
				},
			beforeSend: function(){

				$('#'+cur).text('deleting...');
			},
			success: function(data){
				
				$('#'+cur+'cont').hide();
				$('#'+cur).hide();
				$('#err').html(data);
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