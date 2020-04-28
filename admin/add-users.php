<?php
	ob_start();
	include_once("functions.php");
	function isUserExist($params){
		require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$cond = " ";
		$and = 0;
		$email = isset($params['email'])?$params['email']:"";
		$userid = isset($params['userid'])?$params['userid']:"";
		$acivationid = isset($params['acivationid'])?$params['acivationid']:"";

		if($params['email']!=""){
			$cond .= " Email = '$email'";
		}
		
		$check = $api->db->query("SELECT * FROM users WHERE Email='$email'");
		if(mysqli_num_rows($check) > 0){
			return true;
		}else{
			return false;
		}
	}
	if(isset($_POST['signup']))
	{
		require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$params = $_REQUEST;
		foreach ($_REQUEST as $key => $value) {
			$params[$key] = $value;//$api->db->escapeString($value);
		}
		
		$fname = @$params['firstname'];
	    $lname = @$params['lastname'];
	    $email = @$params['email'];
		$password = @$params['password'];
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$cpwd = @$params['confirmpassword'];
		if($fname!="" || $lname!="" || $email!="" || $params['password']!=""){
			if(isUserExist($params)){
				$data['Status'] = 0;
				$data['Message'] = "Email already registered";
			}else{
				//$activate = md5($email);
				$digits = 5;
				$activate = rand(pow(10, $digits-1), pow(10, $digits)-1);
				$ins = $api->db->query("INSERT INTO users(Firstname, Lastname, Email, Password, Retailer, ActivationId, Status, CreatedOn) VALUES('$fname', '$lname', '$email', '$hashed_password', 1, '$activate', 1, NOW()) ")  or die(mysqli_error($api->db));
				$uid = mysqli_insert_id($api->db);
				if($ins){

					$sub = " - Verify your email address";
					$from = "bhanu4funn@gmail.com";
					$msg = "Your account has been successfully created. Enter the code to activate your account. <b>".$activate."</b>";
					$headers='From: no-reply@iambhanu.com'. "\r\n";
					$headers .='To: '.$email. "\r\n";
					$headers .= "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					$message = "
					<html>
						<head>
							<title>HTML email</title>
						</head>
						<body>".$msg."</body>
					</html>";

		
					//mail
					//$sent=mail($from,$sub,$message,$headers);
				}
				$data['Status'] = 1;
				$data['Message'] = "Success";
			}
		}else{
			$data['Status'] = 0;
			$data['Message'] = "Enter all details";
		}
	//	echo json_encode($data);
		$message = $data['Message'];
		if($data['Status'] == 0){
			$em = 'fail';

		}else{
			$em = 'success';
		}
		header("location:add-users.php?em=".$em."&message=".$message);
		exit();
     }
     
	
	
	

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Retailer - Admin</title>
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
			  		Add Retailer - Admin
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
								<h3>Add Retailer</h3>
							</div>
							<div class="module-body">
                             <?php
								if(@$_GET['em']=='fail')
								{
							?>
                            <div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Failed!</strong> <?php echo $_GET['message']; ?>
							</div>
                            <?php
								}
								else if(@$_GET['em']=='success')
								{
							?>
                            	<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong> Retailer added
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
											<label class="control-label" for="firstname">First Name</label>
											<div class="controls">
												<input type="text" id="firstname" name="firstname" value="" class="span6">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="lastname">Last Name</label>
											<div class="controls">
												<input type="text" id="lastname" name="lastname" value="" class="span6">
											</div>
										</div>
                                        
                                         <div class="control-group">
											<label class="control-label" for="email">Email</label>
											<div class="controls">
												<input type="email" id="email" name="email" value="" class="span6">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="password">Password</label>
											<div class="controls">
												<input type="password" id="password" name="password" value="" class="span6">
											</div>
										</div>
                                        
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="signup">Create</button>
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
			<b class="copyright">iambhanu.com</b>
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