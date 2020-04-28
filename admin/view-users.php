<?php
	ob_start();
	include_once("functions.php");

	require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;

				$statement = "users";
		
		$sql=mysqli_query($api->db, "select * from {$statement} order by UserId desc LIMIT {$startpoint} , {$limit}") or die (mysqli_error($api->db));
		$countQ = mysqli_query($api->db, "SELECT UserId FROM users");
		$tNum = mysqli_num_rows($countQ);
		$generate_list = '<table width="100%" border="10px" cellpadding="3" rules="rows" frame="above">
<tr align="left"> 
<th width="5%">User id</th>
<th>Name</th>


<th>Email</th>
<th>Mobile</th>
<th>Date joined</th>
<th>Active</th>

</tr>';

$ordersCount = mysqli_num_rows($sql); // count the output amount
if ($ordersCount > 0) {
	while($row = mysqli_fetch_array($sql)){

		 	 $UserId = $row["UserId"]; 
             $Firstname = $row["Firstname"];
			 $Lastname = $row["Lastname"];
			 $Username = $row["Username"];
			 $Email = $row["Email"];
			 $Gender = $row["Gender"];
			 $Dob = $row["Dob"];
			 $Phone = $row["Phone"];
			 $ProfileImage = $row["ProfileImage"];
			 
			 if($row["Status"]==1)
			 {
				 $Status = "Active";
			 }
			 elseif($row["Status"]==2)
			 {
				 $Status = "Not activated";
			 }elseif($row["Status"]==3)
			 {
				 $Status = "Blocked";
			 }elseif($row["Status"]==0)
			 {
				 $Status = "Not activated";
			 }
			 
			 $CreatedOn = $row["CreatedOn"];
			
			 $generate_list .= "<tr align='left' valign='top'><td valign='top' > $UserId</td> <td>".$Firstname." ".$Lastname."</td>
			 <td><a href='mailto:$Email'>$Email</a> </td><td>$Phone</td><td>$CreatedOn<br /></td><td>$Status</td><td>";
			 
			
			 $generate_list .="</td></tr>";
		 
    }
	 $generate_list .= "</table>". '';
 ;	
} else {
	$generate_list = "No more users exists";
} 
	
?>
﻿<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Users - Admin</title>
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
			  		VIEW USERS
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
								<h3>Users (Total <?php echo $tNum; ?>)</h3>
							</div>
							<div class="module-body">
								
								<div class="stream-list">
                               		<?php echo $generate_list; ?>
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
			<b class="copyright">iambhanu.com</b>
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