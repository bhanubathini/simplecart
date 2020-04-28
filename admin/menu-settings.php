<?php
	ob_start();
	include_once("functions.php");
	
	if(isset($_POST['savemenu']))
	{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		if(!empty($_POST['catcheck'])){
		foreach($_POST['catcheck'] as $selected){
		
		mysqli_query($api->db, "UPDATE n_menu SET menu_active = 1 WHERE menu_slug='$selected'");
	}
	}
	}
	if(isset($_POST['remmenu']))
	{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
	if(!empty($_POST['catchecks'])){
	foreach($_POST['catchecks'] as $selected){
		
		mysqli_query($api->db, "UPDATE n_menu SET menu_active = 0 WHERE menu_slug='$selected'");
	}
	}
	

	}
	if(isset($_POST['addmenu']))
	{
		require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$menutitle = $_POST['menutitle'];
		$menuurl = $_POST['menuurl'];
		if(!empty($_POST['actmenu'])){
		$selected = $_POST['actmenu'];
	}
	else{
		$selected =0;
	}
		mysqli_query($api->db, "INSERT INTO n_menu(menu_slug, menu_title, menu_active) VALUES('$menuurl', '$menutitle', $selected)");
		header('location:menu-settings.php');
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Menu Settings - Admin</title>
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
			  		Menu Settings - Admin
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
								<h3>Menu settings</h3>
							</div>
							<div class="module-body">
									<form class="form-horizontal row-fluid" method="post">
										<div class="control-group">
											<label class="control-label">These menu items are hidden. Select items to show</label>
											<div class="controls">
                                            <?php
														require_once("../api.php");
														$api = new API;
														$api->dbConnect();
														$getQuery = mysqli_query($api->db, "SELECT * FROM n_menu WHERE menu_hide = 0 AND menu_active = 0 ORDER BY menu_id") or die(mysqli_error());
														mysqli_num_rows($getQuery);
														$i = 1;
														while($row = mysqli_fetch_array($getQuery, MYSQLI_ASSOC))
														{
														
													?>
                                                    		<label class="checkbox inline">
																<input type="checkbox" id="menuchk<?php echo $i; ?>" class="menuchk" value="<?php echo $row['menu_slug']; ?>" name="catcheck[]" <?php if($row['menu_active']==1){ echo 'checked'; } ?>>
                                                                
																	<?php echo $row['menu_title']; ?>
															</label>
                                                    <?php
													 $i++;
														}
														
													?>
											</div>
										</div>
                                        
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="savemenu">Show menu options</button>
											</div>
                                            
										</div>
                                      
									</form>
							</div>
                            <div class="module-body">
									<form class="form-horizontal row-fluid" method="post">
										
                                        
                                        <div class="control-group">
											<label class="control-label">These items are already showing. Select to hide</label>
											<div class="controls">
                                            <?php
														require_once("../api.php");
														$api = new API;
														$api->dbConnect();
														$getQuery = mysqli_query($api->db, "SELECT * FROM n_menu WHERE menu_hide = 0 AND menu_active = 1 ORDER BY menu_id") or die(mysqli_error());
														mysqli_num_rows($getQuery);
														$i = 1;
														while($row = mysqli_fetch_array($getQuery, MYSQLI_ASSOC))
														{
														
													?>
                                                    		<label class="checkbox inline">
																<input type="checkbox" id="menuchk<?php echo $i; ?>" class="menuchk" value="<?php echo $row['menu_slug']; ?>" name="catchecks[]" >
                                                                
																	<?php echo $row['menu_title']; ?>
															</label>
                                                    <?php
													 $i++;
														}
														
													?>
											</div>
										</div>
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="remmenu">Hide menu options</button>
											</div>
                                            
										</div>
                                      
									</form>
							</div>
						</div>

					<!--<div class="module">
							<div class="module-head">
								<h3>Add custom menu</h3>
							</div>
							<div class="module-body">
									<form class="form-horizontal row-fluid" method="post">
										<div class="control-group">
											<label class="control-label" for="url">URL</label>
											<div class="controls">
												<input type="text" id="url" name="menuurl" placeholder="Type url. Ex: http://naanikaghar.com/something" class="span8">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="title">Link Title</label>
											<div class="controls">
												<input type="text" id="title" name="menutitle" placeholder="Type title here..." class="span8" >
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<label class="checkbox inline">
													<input type="checkbox" value="1" name="actmenu">
													Show in menu
												</label>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="addmenu">Add</button>
											</div>
										</div>
									</form>
							</div>
						</div>-->
						
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
			/*$('.menuchk').change(function()
			{
				var id = this.id;
				
				check = $('#'+id).attr('checked');
				if(check=='checked')
				{
					$('#'+id).removeAttr('checked');
				}
				else
				{
					$('#'+id).attr('checked', 'checked');
				}
				alert(check);
				
			});*/
		});
	</script>
</body>
</html>
<?php ob_flush(); ?>