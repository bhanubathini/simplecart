<?php
	ob_start();
	include_once("functions.php");
	if(isset($_POST['submitservice']))
	{
		editService();	
		
		header('location:services-edit.php?msg=success');
	}
	
	
	$id = @$_GET['id'];
	getService($id);
	
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Service</title>
     

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
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.php">Admin </a>
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
										<strong>Success!</strong> Edited successfully :) 
							</div>
                        <?php
							}
						?>

                        
                        <div class="module">
                         <div class="pull-right">
                         	<a href="../services.php" class="btn btn-primary">View all services</a>
                         </div>
							<div class="module-head">
								<h3>Add page</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="servicesform" enctype="multipart/form-data">
                                    <input type="hidden" id="serid" name="serid" value="<?php echo $r['ser_id']; ?>" >
										<div class="control-group">
											<label class="control-label" for="titleinput">Title</label>
											<div class="controls">
												<input type="text" id="titleinput" name="titleinput" value="<?php echo $r['ser_title']; ?>" class="span8">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="categoryinput">Category</label>
											<div class="controls">
												<input type="text" id="categoryinput" name="categoryinput" value="<?php echo $r['ser_cat']; ?>" class="span8">
											</div>
										</div>
                                        
                                       
											
                                         <div class="control-group">
											<label class="control-label" for="frontimg">Front Image</label>
                                            <div class="controls">
                                            <?php
											if($r['ser_front_img']!='')
											{
											?>
                                             <a class="btn btn-mini btn-danger rmv" id="frontim">Remove image</a>
                                             </div>
											<div class="controls">
                                            
                                            <input type="hidden" id="frontimg" name="frontimg" value="<?php echo $r['ser_front_img']; ?>" >
                                           
											<img src="../<?php echo $r['ser_front_img']; ?>" class="img-ser">	
                                            <?php
											}
											else
											{
											?>
                                            <input type="file" id="frontimg" name="frontimg" class="span8">
                                            260x400 px
                                            <?php
											}
											?>
											</div>
										</div>
                                        
                                        <div class="control-group">
											<label class="control-label" for="inimg">Inner Image</label>
                                            <div class="controls">
                                            <?php
											if($r['ser_back_img']!='')
											{
											?>
                                            <a class="btn btn-mini btn-danger rmv" id="inim">Remove image</a>
                                            </div>
											<div class="controls">
                                             
                                            <input type="hidden" id="inimg" name="inimg" value="<?php echo $r['ser_back_img']; ?>" class="span8">
												
                                                <img src="../<?php echo $r['ser_back_img']; ?>" class="img-ser">
                                             <?php
											 }
											 else
											{
											?>
                                            <input type="file" id="inimg" name="inimg" class="span8">
                                            260x195 px
                                            <?php
											}
											?> 
											</div>
										</div>
                                        
                                         <div class="control-group">
											<label class="control-label" for="descriptioninput">Description</label>
											<div class="controls">
                                            <textarea name="descriptioninput" id="descriptioninput" rows="5" class="jqte-test span8"><?php echo $r['ser_description']; ?></textarea>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submitservice" id="submitservice">Save</button>
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
        	var cid = $('#'+cur+'g').val();
			var serid = $('#serid').val();
        	
		$.ajax({
			url: 'ajax/deleteImage.php',
			type: 'POST',
			cache: false,
			data: {
				'name':cid,
				'imgtype':cur+'g',
				'serid':serid,
				},
			beforeSend: function(){

				$('#'+cur).text('deleting...');
			},
			success: function(data){
				/*alert(data);*/
				/*$('#'+cur).text('Save');
				$('#catform').trigger('reset');
				$('#scatsel').html(data);*/
				$('#'+cur+'g').val('');
				$('#'+cur+'g').attr('type', 'file');
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