<?php
	ob_start();
	include_once("functions.php");
	require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
  
				$startpoint = ($page * $limit) - $limit;
				$statement = "n_ads";
				
		$q = mysqli_query($api->db, "SELECT * FROM {$statement} order by ad_id desc LIMIT {$startpoint} , {$limit}");
		

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ad management - Admin</title>
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
										$title = $row['ad_title'];
										$id = $row['ad_id'];
										$description = $row['ad_description'];
										$url = $row['ad_url'];
										$img =$row['ad_image'];
										$act = $row['ad_act'];
										$date = $row['ad_date_added'];
								?>
                                <div class="media stream">
										<div class="media-body">
											<div class="stream-headline">
												<h5 class="stream-author">
													<?php echo $title; ?>
													<small><?php echo $date; ?></small>
												</h5>
												<div class="stream-text">
													 <?php echo $description; ?> 
                                                </div>
												<div class="stream-attachment photo">
													<div class="responsive-photo">
														<img src="<?php echo '../'.$img; ?>" />
													</div>
												</div>
											</div><!--/.stream-headline-->
												<div class="stream-options">
												<a href="ad-edit.php?id=<?php echo $id; ?>" class="btn btn-small">
													
													Edit
												</a>
												<a href="ad-delete.php?id=<?php echo $id; ?>" class="btn btn-small deleteNaani">
													
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