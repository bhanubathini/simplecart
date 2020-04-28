<?php
	ob_start();
	include_once("functions.php");
	require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if(isset($_GET['act']))
				{
					if(@$_GET['act']==1)
					{
						$act = @$_GET['act'];
						$statement = "n_experiences WHERE exp_active=1";
					}
					else if(@$_GET['act']==0)
					{
						$act = @$_GET['act'];
						$statement = "n_experiences WHERE exp_active=0";
					}
				}
				else
				{
					$statement = "n_experiences";
				}
		$q = mysqli_query($api->db, "SELECT * FROM {$statement} order by exp_id desc LIMIT {$startpoint} , {$limit}");
		

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Experiences - Admin</title>
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
			  		VIEW ADS
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
								<h3>Ads</h3>
							</div>
							<div class="module-body">

								<div class="stream-list">
                                <?php
									while($row = mysqli_fetch_array($q))
									{
										$user = $row['exp_user_name'];
										$id = $row['exp_id'];
										$description = $row['exp_description'];
										$img = $row['exp_image'];
										$vid =$row['exp_video'];
										$act = $row['exp_active'];
										$upic = $row['exp_user_pic'];
										$date = $row['exp_date_added'];
								?>
                                <div class="media stream">
                                <?php if($upic!="")
								{
								?>
                                	<a href="#" class="media-avatar medium pull-left">
											<img src="../<?php echo $upic; ?>">
									</a>
                                    <?php
									}
									?>
										<div class="media-body">
											<div class="stream-headline">
												<h5 class="stream-author">
													<?php echo $user; ?>
													<small>Added on <?php echo $date; ?></small>
												</h5>
												<div class="stream-text">
													 <?php echo $description; ?> 
                                                </div>
												<div class="stream-attachment photo">
													<div class="responsive-photo">
                                                    <?php if($vid!=""){ ?>
                                                     <video controls>
													  <source src="<?php echo $vid; ?>" type="video/mp4">
  								 						 Your browser does not support the video tag.
													</video><br>
                                                    <?php } 
														if($img!="")
														{
													?>
														<img src="<?php echo '../'.$img; ?>" />
                                                        <?php
														}
														?>
													</div>
												</div>
											</div><!--/.stream-headline-->
												<div class="stream-options">
                                                <?php if($act==1){
												?>
                                                <a href="exp.php?deact=<?php echo $id; ?>" class="btn btn-small">
													Deactivate
												</a>
                                                <?php
                                                } else {
												?>
                                                <a href="exp.php?act=<?php echo $id; ?>" class="btn btn-small">
													Activate
												</a>
                                                <?php
                                                } ?>
												
												<a href="exp.php?del=<?php echo $id; ?>" class="btn btn-small deleteNaani">
													Delete
												</a>
											</div>
										</div>
									</div><!--/.media .stream-->
                                <?php
										
									}
									
								?>
									 <div style="clear:both;"></div>
                    <div class="pagination">
                        <?php echo pagination($api,$statement,$limit,$page); ?>      		
                    </div>
									

								</div><!--/.stream-list-->
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

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="scripts/common.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
     

</body>
</html>
<?php ob_flush(); ?>