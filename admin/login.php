<?php
	ob_start();
	session_start();
	include 'controllers/login.php';
	//admin login
	if(isset($_SESSION['user_data']))
	{
		 header("location:index.php");
		 exit();
	}
	else
	{
		
	}
	if(isset($_POST['login']))
    {
		$email = $_POST['aemail'];
      	$pwd = md5($_POST['apwd']);
		signin($email,$pwd);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NaaniKaGhar</title>
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
			  		NaaniKaGhar
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					<ul class="nav pull-right">	

						<li><a href="#">
							Forgot your password?
						</a></li>
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
               	   <?php
					if(@$_GET['msg']=='fail')
					{
					?>
                   <div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						You have entered invalid username or password. 
					</div>
                    <?php
					}
					?>
                    <div class="alert alert-error" style="display: none;" id="errorShow">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Please enter username and password. 
					</div>
					<form class="form-vertical" method="post" id="loginform">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
                                <div class="input-prepend">
                                <span class="add-on icon-user"></span>
									<input class="span10" type="text" id="inputEmail" name="aemail" placeholder="Username">
                                    </div>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
                                <div class="input-prepend">
									<span class="add-on icon-lock"></span><input class="span10" type="password" id="inputPassword" name="apwd" placeholder="Password">
                                   </div>
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary pull-right" name="login">Login</button>
									<label class="checkbox">
										<!--<input type="checkbox"> Remember me-->
									</label>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright">iambhanu.com </b>
		</div>
	</div>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
	$(document).ready(function () {
				$('#loginform').submit(function()
				{
				var email = $('#inputEmail').val();
				var pwd = $('#inputPassword').val();
				
					if(email!='' || pwd != '')
					{
						
					}
					else if(email=='' || pwd == '')
					{
						$('#errorShow').show();
						return false;
					}
				});
				
			});
	</script>
</body>
 </html>
 <?php ob_flush(); ?>