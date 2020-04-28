<?php
	ob_start();
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	include_once("functions.php");
	if(isset($_POST['submit_login']))
	{
      	$email = $_POST['semail'];
		$pwd = $_POST['spassword'];
		signin($email,$pwd);
	}
	if(isset($_POST['registernaani']))
	{
		register();
	}
	require_once("../config/db.php");
						$api = new db;
						$api->dbConnect();
						$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
						$limit = 30;
  						$generate_list = "";
						
						$startpoint = ($page * $limit) - $limit;
						if($bycat=@$_GET['cat'])
						{
							$bycat = str_replace("_", " ", $bycat);
							$statement = "products WHERE CategoryId='$bycat'";
							$h = $bycat;
						}

/*						else if(@$_GET['recommended']==1)
						{
							$bycat=@$_GET['recommended'];
							$statement = "products WHERE p_recommend=$bycat";
							$h = "Recommended products";
						}*/
						else
						{
							$statement = "products p";
							$h = "Mom and Kids store";
						}
						$roleCondition = " ";
						if($_SESSION['user_data']['role'] != 1)
						{
							$roleCondition = "INNER JOIN admin a ON (a.role = p.storeid)
							where p.storeid = ".$_SESSION['user_data']['role'];
						}
						$q = mysqli_query($api->db, "select p.*, pi.* from {$statement}
							LEFT JOIN productimages pi ON (pi.ProductId=p.productID)
							".$roleCondition."
							order by p.productID desc LIMIT {$startpoint} , {$limit}")  or die(mysqli_error());
						$pnum = mysqli_num_rows($q);
						
						if($pnum > 0)
						{
							$generate_list = '<ul class="products">';
							$i = 1;
							while($r = mysqli_fetch_array($q))
							{
								$id = $r['productID'];
								$name = $r['ProductName'];
								$price = $r['Price'];
								$retailprice = $r['retailprice'];
								$details = $r['Description'];
								$cat = $r['CategoryId'];

								$dateadded = $r['CreatedOn'];
								$url = $r['Image'];
								if($i==1)
								{
									$li = '<li class="trickstown-one-fifth-product column first">';
								}
								else
								{
									$li = '<li class="trickstown-one-fifth-product column">';
								}
									if(isset($_SESSION['user_data']))
									{
										$generate_list .= $li.'<div><a href="edit-product.php?id='.$id.'">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete-product.php?id='.$id.'" class="deleteNaani">Delete</a></div>';
									}
									else
									{
										$generate_list .= $li.'';
									}
                				
								$generate_list .= '<div class="product-thumb">';
								if($url!="")
								{
			                         $generate_list .= ' <img src="'.$url.'" alt="" title="">';
								}
								else
								{
									 $generate_list .= '<a href="#">
            			                        <img src="img/product-no-image.jpg" alt="" title="">
                        			        </a>';
								}
                              
			                        $generate_list .= '<div class="image-overlay">  
            			                       
            			                    </div>
                        			    </div>
			                            <div class="product-details">
            		                    	<h5>'.$name.'</h5>
	                    		            <span class="price"> Rs.'.$price.' (Retail: Rs.'.$retailprice.') </span>
                            			</div>
    			                    </li>';
               					$i++;
							}
							$generate_list .= '</ul>';
						}
						else
						{
							$generate_list = 'We have no products listed in our store yet';
						}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Products - Admin</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<style type="text/css">
		.products li{
		    line-height: 20px;
		    float: left;
		    margin: 10px;
		    padding: 10px;
		    border: 1px solid #eeeeee;
		    list-style: none;
		}
		.product-thumb{
			width: 100px;
    		height: auto;
    		text-align: center;
		}
		.product-thumb img{
			height: 100px;
		}
	</style>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="index.html">
			  		VIEW PRODUCTS
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
								<h3>Products</h3>
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