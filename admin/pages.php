<?php 
	ob_start();
	include_once("functions.php");
	if(isset($_POST['submitpage']))
	{
		addPage();	
		
		images($pageId);
		header('location:pages.php?msg=success');

	}	
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
    <link type="text/css" rel="stylesheet" href="jqte/jquery-te-1.4.0.css">
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
										<strong>Success!</strong> Your page has been published successfully :) 
							</div>
                        <?php
							}
						?>

                        
                        <div class="module">
							<div class="module-head">
								<h3>Add page</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="pagesform" enctype="multipart/form-data">
										<div class="control-group">
											<label class="control-label" for="titleinput">Title</label>
											<div class="controls">
												<input type="text" id="titleinput" name="titleinput" placeholder="Type title here..." class="span8">
											</div>
										</div>
										
                                        
                                       
											
                                         <div class="control-group">
											<label class="control-label" for="topimg">Images</label>
											<div class="controls">
                                            <input type="file" id="topimg" name="file[]" class="span8" multiple="multiple">
												
											</div>
										</div>
                                        
                                        <!-- <div class="control-group">
											<label class="control-label" for="bottomimg">Bottom images</label>
											<div class="controls">
                                            <input type="file" id="bottomimg" name="bottomimg[]" class="span8" multiple="multiple">
											</div>
										</div>-->
                                        
                                         <div class="control-group">
											<label class="control-label" for="descriptioninput">Description</label>
											<div class="controls">
                                            <textarea name="descriptioninput" id="descriptioninput" rows="5" class="jqte-test span8"></textarea>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submitpage" id="submitpage">Save</button>
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
	<script type="text/javascript" src="jqte/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    	<script>
	$('.jqte-test').jqte();
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
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
				
			});
		</script>
</body>
</html>
<?php ob_flush(); ?>