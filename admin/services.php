<?php
	ob_start();
	include_once("functions.php");
	if(isset($_POST['submitservice']))
	{
		addService();	
	}
	
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
     

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
										<strong>Success!</strong> Published successfully :)
							</div>
                            <!--<div class="alert alert-fail">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Invalid file :( Upload failed.</strong>
							</div>-->
                        <?php
							}
						?>

                        
                        <div class="module">
                         <div class="pull-right">
                         	<a href="../services.php" class="btn btn-primary">View all services</a>
                         </div>
							<div class="module-head">
								<h3>Add service</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="servicesform" enctype="multipart/form-data">
										<div class="control-group">
											<label class="control-label" for="titleinput">Title</label>
											<div class="controls">
												<input type="text" id="titleinput" name="titleinput" placeholder="Type title here..." class="span8">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="categoryinput">Category</label>
											<div class="controls">
												<input type="text" id="categoryinput" name="categoryinput" placeholder="Type category here..." class="span8">
											</div>
										</div>
                                        
                                       
											
                                         <div class="control-group">
											<label class="control-label" for="frontimg">Front Image</label>
											<div class="controls">
                                            <input type="file" id="frontimg" name="frontimg" class="span8">
												260x400 px
											</div>
										</div>
                                        
                                        <div class="control-group">
											<label class="control-label" for="inimg">Inner Image</label>
											<div class="controls">
                                            <input type="file" id="inimg" name="inimg" class="span8">
												260x195 px
											</div>
										</div>
                                        
                                         <div class="control-group">
											<label class="control-label" for="descriptioninput">Description</label>
											<div class="controls">
                                            <textarea name="descriptioninput" id="descriptioninput" rows="5" class="span8"></textarea>
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
	
	$('#servicesform').on('submit', function()
	{
	
	title = $('#titleinput').val();
	cat = $('#categoryinput').val();
	frontimg = $('#frontimg').val();
	inimg = $('#inimg').val();
	description = $('#descriptioninput').val();
	if(title=='' || cat == '' || frontimg == '' || inimg == '' || description == '')
	{
		alert('Please fill all input fields');
		return false;
	}
	else
	{
		return true;
	}
	

	});
	/*
				$('#catsel').on('change', function()
				{
				var un = $('#catsel').val();	

		$.ajax({
			url: 'ajax/category.php',
			type: 'POST',
			cache: false,
			data: {
				'catid':un,
				},
			beforeSend: function(){

				$('#subcategoryt').html('loading...');
			},
			success: function(data){
				$('#subcategoryt').html('');
				$('#subcatsel').removeAttr('disabled');
				$('#subcatsel').html(data).show();
			},
			error: function(e){
				alert(e);
			}
		});
	return false;
				});
				
			*/});
		</script>

</body>
</html>
<?php ob_flush(); ?>