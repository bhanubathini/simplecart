
<!DOCTYPE html>
<?php 
	ob_start();
	include_once("functions.php");
	require_once("../api.php");
		$api = new API;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;

				$statement = "n_orders";
		
		$sql=mysqli_query($api->db, "select * from {$statement} order by o_date_purchased desc LIMIT {$startpoint} , {$limit}");
		$generate_list = '<table width="100%" border="10px" cellpadding="3" rules="rows" frame="above">
<tr align="left"> 
<th width="5%">OId</th>
<th width="5%">CId</th>
<th width="30%">Customer Details</th>
<th>Billing Address</th>
<th>Date Ordered</th>
<th>Products</th>
</tr>';

$ordersCount = mysqli_num_rows($sql); // count the output amount
if ($ordersCount > 0) {
	while($row = mysqli_fetch_array($sql)){
		 	 $oid = $row["o_id"]; 
             $cid = $row["o_uid"];
			 $name = $row["o_uname"];
			 $street = $row["o_ustreet"];
			 $city = $row["o_ucity"];
			 $postcode = $row["o_upostal"];
			 $state = $row["o_ustate"];
			 $country = $row["o_ucountry"];
			 $tel = $row["o_umobile"];
			 $email = $row["o_uemail"];
			 $bname = $row["o_bname"];
			 $bstreet = $row["o_bstreet"];
			 $bcity = $row["o_bcity"];
			 $bpostcode = $row["o_bpostal"];
			 $bstate = $row["o_bstate"];
			 $bcountry = $row["o_bcountry"];
			 $total = $row["o_total_amt"];
			 $date = $row["o_date_purchased"];
			 $generate_list .= "<tr align='left' valign='top'><td valign='top' > $oid</td> <td valign='top'> $cid</td> <td>$name <br />$street <br />$city, $postcode<br />$state, $country<br/>$email <br />$tel</td><td>$bname<br />$bstreet<br />$bcity, $bpostcode<br />$bstate, $bcountry</td><!--<td valign='top'>$total</td>--><td valign='top'>$date</td><td>";
			 
			 $pq = mysqli_query($api->db, "SELECT * FROM n_basket WHERE b_oid=$oid") or die(mysqli_error($api->db));
			 while($rp = mysqli_fetch_array($pq))
			 {
			 	$generate_list .= 'Product id:'.$rp['b_pid'].'<br>Product name:'.$rp['b_pname'].'<br>Quantity:'.$rp['b_quantity'].'<br>Price:Rs.'.$rp['b_final_price'].'<br><hr>';
			 }
			 $generate_list .="</td></tr>";
		 
    }
	 $generate_list .= "</table>". '';
 ;	
} else {
	$generate_list = "We have no orders in our your store yet";
} 
	
?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orders - Admin</title>
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
			  		VIEW ORDERS
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
								<h3>Orders</h3>
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