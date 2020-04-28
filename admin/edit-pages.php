<?php
	ob_start();
	include_once("functions.php");
	
	$id = @$_GET['subcat'];
	$cid = @$_GET['cat'];
	pageShow();
	if(isset($_POST['submitpage']))
	{
		editPage();	
	}
	
	
	
	if($id==1)
	{
		$title = 'Expecting Parents';
	}
	else if($id==2)
	{
		$title = 'Parents of new born';
	}
	else if($id==3)
	{
		$title = 'Parents of toddler';
	}
													 
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php  echo $title; ?></title>
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
                                <a class="btn btn-info" style="float: right;" href="view.php?cat=<?php  echo $id; ?>">View all (<?php  echo $title; ?>)</a>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="pagesform" enctype="multipart/form-data">
										<!--<div class="control-group">
											<label class="control-label" for="titleinput">Title</label>
											<div class="controls">
												<input type="text" id="titleinput" name="titleinput" placeholder="Type title here..." class="span8">
											</div>
										</div>-->
										<div class="control-group">
											<label class="control-label" for="catsel">Page Name:</label>
											<div class="controls">
                                            	<?php  echo $title; ?>
                                            	<input type="hidden" value="<?php echo $_GET['id']; ?>" name="catsel" id="catsel">
											</div>
										</div>
                                        
                                        <div class="control-group">
											<label class="control-label" for="subcatsel">Tab name</label>
											<div class="controls">
                                        <?php
											require_once("../api.php");
											$api = new API;
											$api->dbConnect();
											$q = mysqli_query($api->db, "SELECT * FROM n_subcategory WHERE subcat_parent='$id'");	
										?>
										<select tabindex="1" data-placeholder="Select here.." class="span8" id="subcatsel" name="subcatsel">
									        <option value="0">Select here..</option>
										<?php	
											while($row = mysqli_fetch_array($q))
											{
												echo '<option value="'.$row['subcat_name'].'">'.$row['subcat_name'].'</option>';
											}
										?>
										</select>
											</div>
										</div>
                                        <?php
										if($id==1)
										{
										?>
                                         <div class="control-group">
											<label class="control-label" for="weeksel">Week</label>
											<div class="controls">
												<select tabindex="1" data-placeholder="Select week.." class="span8" name="weeksel" id="weeksel">
													<option value="0">Select week..</option>
                                                    <?php
														for($i=1; $i<=41; $i++)
														{
													?>
                                                    		<option value="<?php echo "week". $i; ?>"><?php echo "Week ". $i; ?></option>
                                                    <?php
													 
														}
													?>
							
												</select>
											</div>
										</div>
                                        <?php
										}
										else
										{
										?>
                                        <input type="hidden" name="weeksel" value="0">
                                        <div class="control-group">
											
                                        
                                       		
                                        </div>
                                       <?php
									   }
									   ?>
											
                                         <div class="control-group">
											<label class="control-label" for="topimg">Images</label>
											<div class="controls">
                                            <input type="file" id="topimg" name="file[]" class="span8" multiple="multiple">
												
											</div>
										</div>
                                         <div class="control-group">
											<label class="control-label" for="vids">Video</label>
											<div class="controls">
                                            <input type="file" id="vids" name="video[]" class="span8" multiple="multiple">
												
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
	$(document).ready(function () {});
		</script>
</body>
</html>
<?php ob_flush(); ?>