<?php
	ob_start();
	include_once("functions.php");
	if(isset($_POST['users']))
	{
		require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$user = $_POST['uninput'];
		$id = $_SESSION['user_data']['id'];
		$email = $_POST['emailinput'];

		mysqli_query($api->db, "UPDATE admin SET adminEmail = '$email', adminUsername = '$user' WHERE adminId = '$id'");
/*		$check = mysqli_query($api->db, "SELECT * FROM admin WHERE adminEmail = '$email'  OR adminUsername = '$user'");
		$num = mysqli_num_rows($check);
		if($num==0)
		{
			
			
		}*/
		$check = mysqli_query($api->db, "SELECT * FROM admin where (adminUsername='$user' or adminEmail='$email') LIMIT 1")  or die(mysqli_error($api->db));
    $num_rows = mysqli_num_rows($check);
    if($num_rows == 1)
    {
    	$res = mysqli_fetch_array($check);
      	$data = array("id"=>$res['adminId'],"name"=>$res['adminName'], "username"=>$res['adminUsername'], "password"=>$res['adminPassword'], "email"=>$res['adminEmail']);
		$_SESSION['user_data'] = $data;
		header("location:settings.php?em=success");
		exit();
     }
     
	
	}
	if(isset($_POST['pwds']))
	{
		require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$opwd = md5($_POST['oldpwd']);
		$email = $_SESSION['user_data']['email'];
		$id = $_SESSION['user_data']['id'];
		$npwd = md5($_POST['npwd']);
		$cpwd = md5($_POST['cpwd']);
		if($cpwd==$npwd && $npwd!='')
		{
		$check = mysqli_query($api->db, "SELECT * FROM admin WHERE adminEmail = '$email'  AND adminPassword = '$opwd'");
		$num = mysqli_num_rows($check);
		if($num==1)
		{
			mysqli_query($api->db, "UPDATE admin SET adminPassword = '$npwd' WHERE adminId = $id");
			/*$_SESSION['user_data']['email']=$email;
			$_SESSION['user_data']['username']=$user;*/
			header("location:settings.php?msg=success");
		}
		else
		{
			header("location:settings.php?msg=fail");
		}
		}
		else
		{
			header("location:settings.php?msg=nomatch");
		}
	

	}

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>General Settings - Admin</title>
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
			  		General Settings - Admin
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
								<h3>General settings</h3>
							</div>
							
                            <div class="module-body">

                            <?php
								 if(@$_GET['em']=='success')
								{
							?>
                            	<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong>
								</div>
                            <?php
								}

							?>									<form class="form-horizontal row-fluid" method="post">
                                        <div class="control-group">
											<label class="control-label" for="uninput">Username</label>
											<div class="controls">
												<input type="text" id="uninput" name="uninput" value="<?php echo $_SESSION['user_data']['username']; ?>" class="span6">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="emailinput">Email</label>
											<div class="controls">
												<input type="text" id="emailinput" name="emailinput" value="<?php echo $_SESSION['user_data']['email']; ?>" class="span6">
											</div>
										</div>
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="users">Save changes</button>
											</div>
										</div>
									</form>
							</div>
                            
						</div>

					<div class="module">
							<div class="module-head">
								<h3>Change password</h3>
							</div>
							<div class="module-body">
                             <?php
								if(@$_GET['msg']=='fail')
								{
							?>
                            <div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Failed!</strong> Invalid password 
							</div>
                            <?php
								}
								else if(@$_GET['msg']=='success')
								{
							?>
                            	<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong> Password changed
								</div>
                            <?php
								}
							else if(@$_GET['msg']=='nomatch')
								{
							?>
                            	<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Error!</strong> Passwords doesn't match
								</div>
                            <?php
								}
							?>			
									<form class="form-horizontal row-fluid" method="post">
                                        <div class="control-group">
											<label class="control-label" for="oldpwd">Old Password</label>
											<div class="controls">
												<input type="password" id="oldpwd" name="oldpwd" value="" class="span6">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="npwd">New Password</label>
											<div class="controls">
												<input type="password" id="npwd" name="npwd" value="" class="span6">
											</div>
										</div>
                                        
                                         <div class="control-group">
											<label class="control-label" for="cpwd">Confirm New Password</label>
											<div class="controls">
												<input type="password" id="cpwd" name="cpwd" value="" class="span6">
											</div>
										</div>
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="pwds">Save changes</button>
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
			
		});
	</script>
</body>
</html>
<?php ob_flush(); ?>