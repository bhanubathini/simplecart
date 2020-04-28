<?php
	ob_start();
	error_reporting(E_ALL);
ini_set('display_errors', 'On');
	include_once("functions.php");
	require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		
		if(isset($_POST['sendmsg']))
		{
			$sub = mysqli_real_escape_string($api->db, $_POST['sub']);
			$msg = mysqli_real_escape_string($api->db, $_POST['message']);
			
			$bcc = "";
			if(!empty($_POST['indmsg']))
			{
				$indemails = mysqli_real_escape_string($api->db, $_POST['indmsg']);
				$bcc .= $indemails.",";
			}
			$countQ = mysqli_query($api->db, "SELECT usr_email FROM n_users");
			/*$tNum = mysqli_num_rows($countQ);*/
			while($rowu = mysqli_fetch_array($countQ))
			{
				$bcc .= $rowu['usr_email'].",";
			}
			$countS = mysqli_query($api->db, "SELECT subs_email FROM n_subscribe");
			/*$tNum = mysqli_num_rows($countQ);*/
			while($rows = mysqli_fetch_array($countS))
			{
				$bcc .= $rows['subs_email'].",";
			}
			/*if(!empty*/
			
		
		$headers="From: no-reply@naanikaghar.com". "\r\n";
		$headers .="To: no-reply@naanikaghar.com"."\r\n";
		$headers .="Bcc: ".$bcc. "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$message = "
		<html>
			<head>
				<title>HTML email</title>
			</head>
			<body>".$msg."</body>
		</html>";
		$from = "info@naanikaghar.com";
		//mail
		$sent=mail($from,$sub,$message,$headers);
		header("location:message.php?msg=success");	
		exit();
		}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Send message | News letter - Admin</title>
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
			  		Send message
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
								<h3>Send message</h3>
							</div>
							<div class="module-body">
								<h3>Send message to users</h3>
                            	<form class="form-horizontal row-fluid" method="post">
                                		<div class="control-group">
											
											
                                              
                                             <!-- <label class="control-label" for="title">Users:</label>
                                             <div class="controls">
                                              <input type="checkbox" value="" name="usermsg" id="usermsg" class="span2">
                                              </div>
                                              
                                              <label class="control-label" for="title">Subscribers:</label>
                                              <div class="controls">
                                              <input type="checkbox" value="" name="subsmsg" id="subsmsg" class="span2">
                                              </div>-->
                                              <label class="control-label" for="title">Inviduals:</label>
                                              <div class="controls">
                                              <input type="text" name="indmsg" id="indmsg" placeholder="Add individual email id's separated by comma(optional)" class="span8">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="title">Subject:</label>
											<div class="controls">
                                            	<input type="text" value="" name="sub" id="sub" class="span8">
											</div>
										</div>
                                        <div class="control-group">
											<label class="control-label" for="description">Message:</label>
											<div class="controls">
                                            	<textarea name="message" id="message" class="span8"></textarea>
											</div>
										</div>
                                       
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="sendmsg">Send message</button>
											</div>
										</div>
                                      
									</form>
								
							</div><!--/.module-body-->
						</div><!--/.module-->
						
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
	<?php include 'controllers/tinymce.php'; ?>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script>
	   $(document).ready(function () {
		
    });
	</script> 
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="scripts/common.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	    

</body>
</html>
<?php ob_flush(); ?>