<?php
	ob_start();
	include_once("functions.php");
	require_once("../config/db.php");
		$api = new db;
		$api->dbConnect();
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;

				$statement = "orders o ";
		
		$sql=mysqli_query($api->db, "select o.*, u.*, ab.*, o.CreatedOn OrderDate from {$statement} 
			INNER JOIN users u ON (o.UserId=u.UserId)
			INNER JOIN addressbook ab ON (ab.UserId=u.UserId AND ab.AddressId=o.AddressId) order by o.CreatedOn desc LIMIT {$startpoint} , {$limit}");
		$generate_list = '<table width="100%" border="10px" cellpadding="3" rules="rows" frame="above">
<tr align="left"> 
<th width="5%">Order ID</th>

<th width="30%">Customer Details</th>
<th>Shipping Address</th>
<th>Date Ordered</th>
<th>Products</th>
</tr>';

$roleCondition = " ";
if($_SESSION['user_data']['role'] != 1)
{
	$roleCondition = "INNER JOIN admin a ON (a.role = p.storeid AND p.storeid = ".$_SESSION['user_data']['role'].")";
}

$ordersCount = mysqli_num_rows($sql); // count the output amount
if ($ordersCount > 0) {
	while($row = mysqli_fetch_array($sql)){
		 	 $oid = $row["orderId"]; 
             $cid = $row["UserId"];
			 $name = $row["Firstname"]." ".$row['Lastname'];
			 $street = $row["Street"];
			 $city = $row["City"];
			 $postcode = $row["PinCode"];
			 $state = $row["State"];
			 $country = $row["Country"];
			 $tel = $row["Mobile"];
			 $email = $row["Email"];
			 /*$bname = $row["o_bname"];
			 $bstreet = $row["o_bstreet"];
			 $bcity = $row["o_bcity"];
			 $bpostcode = $row["o_bpostal"];
			 $bstate = $row["o_bstate"];
			 $bcountry = $row["o_bcountry"];*/
			 $total = $row["TotalAmount"];
			 $date = $row["OrderDate"];
			 $generate_list .= "<tr align='left' valign='top'><td valign='top' > $oid</td>  <td>$name </td><td>$street <br />$city, $postcode<br />$state, $country<br/>$email <br />$tel</td><!--<td valign='top'>$total</td>--><td valign='top'>$date</td><td>";
			 
			 $pq = mysqli_query($api->db, "SELECT op.*, p.* FROM orderedproducts op
			 INNER JOIN products p ON (p.productID=op.ProductId)
			 ".$roleCondition."
			 WHERE orderId=$oid") or die(mysqli_error($api->db));
			 while($rp = mysqli_fetch_array($pq))
			 {
			 	$generate_list .= 'Product id:'.$rp['ProductId'].'<br>Product name:'.$rp['ProductName'].'<br>Quantity:'.$rp['Quantity'].'<br>Price:Rs.'.$rp['Price'].'<br><hr>';
			 }
			 $generate_list .="</td></tr>";
		 
    }
	 $generate_list .= "</table>". '';
 ;	
} else {
	$generate_list = "We have no orders in our your store yet";
} 
	
?>
﻿<!DOCTYPE html>
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