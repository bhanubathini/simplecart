<?php
	ob_start();
	
	include_once("functions.php");

	require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;

				$statement = "n_subscribe";
		
		$sql=mysqli_query($api->db, "select * from {$statement} order by subs_id desc LIMIT {$startpoint} , {$limit}") or die (mysqli_error($api->db));
		$countQ = mysqli_query($api->db, "SELECT subs_id FROM n_subscribe");
		$tNum = mysqli_num_rows($countQ);
		$subsList = "<table width='100%' border='5px' cellpadding='5' rules='rows' frame='above'>
		<tr align='left'>
		<th>S.No</th>
		<th>Email</th>
		</tr>";
		$i = 1+$page*$limit-$limit;
		while($sRow = mysqli_fetch_array($sql))
		{
			$subsList .= "<tr align='left' valign='top'><td valign='top' >$i</td><td><a href='mailto:".$sRow['subs_email']."'>".$sRow['subs_email']."</a></td></tr>";
			$i++;
		}
		$subsList .= "</table>";
?>
﻿<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Subscribers - Admin</title>
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
			  		Subscribers - Admin
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
					<ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo $_SESSION['user_data']['name']; ?>
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
								<h3>Subscribers (Total <?php echo $tNum; ?>)</h3>
							</div>
							<div class="module-body">
                                                       	
								<div class="stream-list">
                               		<?php echo $subsList; ?>
								<div style="clear:both;"></div>
                    <div class="pagination">
                        <?php echo pagination($api,$statement,$limit,$page); ?>      		
                    </div>
									

								</div><!--/.stream-list-->		
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
	 <?php include 'controllers/tinymce.php'; ?>
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