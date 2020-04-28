<?php
	ob_start();
	include_once("functions.php");

	
	require_once("../config/db.php");
	$api = new db;
	$api->dbConnect();
if (isset($_POST['submit'])) {
	$moved = 0;
    $product_name = mysqli_real_escape_string($api->db,$_POST['product_name']);
	$price = mysqli_real_escape_string($api->db,$_POST['price']);
	$retailprice = mysqli_real_escape_string($api->db,$_POST['retailprice']);
	
	$category = mysqli_real_escape_string($api->db,$_POST['category']);
	//$subcategory = mysqli_real_escape_string($api->db,$_POST['subcategory']);
	$details = mysqli_real_escape_string($api->db,$_POST['details']);
	$storeid = $_SESSION['user_data']['role'];
	if(!empty($_POST['recommend']))
	{
		$rec = 1;
	}
	else
	{
		$rec = 0;
	}
	if(!empty($_POST['instant']))
	{
		$instant = 1;
	}
	else
	{
		$instant = 0;
	}
	if(!empty($_POST['banner']))
	{
		$banner = 1;
	}
	else
	{
		$banner = 0;
	}
	$sql = mysqli_query($api->db,"SELECT productID FROM products WHERE ProductName='$product_name' LIMIT 1");
	$productMatch = mysqli_num_rows($sql); 
    if ($productMatch > 0) {
		echo 'Sorry you tried to place a duplicate "Product Name" into the system. <a href="store.php">Back</a>';
		exit();
	}

	
   //  $pid = mysqli_insert_id($api->db);
	 $newname = "";
	 //image upload
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = pathinfo($_FILES['fileField']['name'], PATHINFO_EXTENSION);
	if ((($_FILES["fileField"]["type"] == "image/png")
	|| ($_FILES["fileField"]["type"] == "image/gif")
	|| ($_FILES["fileField"]["type"] == "image/jpeg"))
	&& ($_FILES["fileField"]["size"] < 2000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["fileField"]["error"] > 0)
	    {
    		echo "Return Code: " . $_FILES["fileField"]["error"] . "<br />";
	    }
		else
		{
			$image=$_FILES['fileField']['name'];
        	$type=$_FILES['fileField']['type'];
	        $size=$_FILES['fileField']['size'];
    	    $tempname=$_FILES['fileField']['tmp_name'];
        	$newname="../uploads/store/".time().$image;
	        $moved = move_uploaded_file($tempname,"$newname");


			
		}
	}
	else
	{
		echo "Invalid file";
		$newname = "";
	}
	$sql = mysqli_query($api->db,"INSERT INTO products (ProductName, Price, retailprice, Description, CategoryId,recommend, instant, banner,storeid, CreatedOn) 
        VALUES('$product_name','$price', '$retailprice', '$details', '$category', $rec, $instant, $banner,$storeid, NOW())") or die (mysqli_error($api->db));
	$inserId = mysqli_insert_id($api->db);
	if($moved){
		$sql = mysqli_query($api->db,"INSERT INTO productimages (ProductId, Image, Status) 
        VALUES('$inserId','$newname','1')") or die (mysqli_error($api->db));
	}
	header("location: store.php"); 
    //exit();
}

if (isset($_POST['add_category'])) {
		$ncategory = $_POST['ncategory'];
		if($ncategory!=''){
			$qry = mysqli_query($api->db,"INSERT INTO productcategories (CategoryName) VALUES ('$ncategory')") or die (mysqli_error($api->db));
		}
		
		header('location: store.php');
	}
	

	if (isset($_POST['remove_category'])) {
		$cat = $_POST['category'];
		$qry = mysqli_query($api->db,"DELETE FROM  productcategories WHERE CategoryName = '$cat' LIMIT 1") or die (mysqli_error());
		header('location: store.php');
	}		

	$category_list ='';
	$category_list .= "<select name='category' id='category'><option value=''>select category</option>";
	$qry = mysqli_query($api->db, "SELECT CategoryId, CategoryName FROM productcategories") or die (mysqli_error($api->db));
		while ($rowCat = mysqli_fetch_array($qry)){
			$CategoryId = $rowCat['CategoryId'];
			$category = $rowCat['CategoryName'];
			$category_list .= "<option value='$CategoryId'>$category</option>"; 
		}
	$category_list .= "</select>";
?>

<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
     

  <!--  <link type="text/css" rel="stylesheet" href="jqte/jquery-te-1.4.0.css">-->
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
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.php">Admin </a>
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
                    </div>
                    <!-- /.nav-collapse -->
                </div>
             </div>
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
						<?php
							if(@$_GET['msg']=='success')
							{
						?>
                        	<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong> Published successfully :)
							</div>
                            <!--<div class="alert alert-fail">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Invalid file :( Upload failed.</strong>
							</div>-->
                        <?php
							}
						?>

                        <div class="module">
                         <div class="pull-right">
                         	<a href="view-products.php" target="_blank" class="btn btn-primary">View all products</a>
                         </div>
							<div class="module-head">
								<h3>Add Product</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" method="post" id="servicesform" enctype="multipart/form-data">
										<div class="control-group">
											<label class="control-label" for="titleinput">Product name</label>
											<div class="controls">
												<input name="product_name" type="text" id="product_name" size="50"  class="span8"/>
                                              
										</div>
                                        </div>
                                        <div class="control-group">
											<label class="control-label" for="titleinput">Price</label>
											<div class="controls">
                                                <input name="price" type="text" id="price" size="12"  class="span8"/>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="titleinput">Retailer Price</label>
											<div class="controls">
                                                <input name="retailprice" type="text" id="retailprice" size="12"  class="span8"/>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="categoryinput">Category</label>
											<div class="controls">
												<?php echo $category_list; ?>
											</div>
										</div>
                                       
                                       
											
                                         <div class="control-group">
											<label class="control-label" for="frontimg">Product Image</label>
											<div class="controls">
                                            	<input type="file" name="fileField" id="fileField" />
											</div>
										</div>
                                        
                                       
                                        
                                         <div class="control-group">
											<label class="control-label" for="descriptioninput">Description</label>
											<div class="controls">
                                            <textarea name="details" id="details" cols="38" rows="5"></textarea>
											</div>
										</div>
										
                                         <div class="control-group">

											<label class="control-label" for="descriptioninput">Tick to add this item to instant products</label>
											<div class="controls">
                                            	<input type="checkbox" name="instant" id="instant" />
											</div>
										<div class="clear"></div>
											<label class="control-label" for="descriptioninput">Tick to add this item to recommended products</label>
											<div class="controls">
                                            	<input type="checkbox" name="recommend" id="recommend" />
											</div>
										<div class="clear"></div>
											<label class="control-label" for="descriptioninput">Tick to add this item to banner</label>
											<div class="controls">
                                            	<input type="checkbox" name="banner" id="banner" />
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submit" id="submitproduct">Save</button>
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
    <?php include 'controllers/tinymce.php'; ?>
<script>
	$(document).ready(function () {
	
	$('#servicesform').on('submit', function()
	{
	
	name = $('#product_name').val();
	price = $('#price').val();
	retailprice = $('#retailprice').val();
	details = $('#details').val();
	
	
	if(name=='' || cat == '' || price == '' || details == '' || retailprice == '')
	{
		alert('Please enter product name, price and details');
		return false;
	}
	else
	{
		return true;
	}
	

	});
});
		</script>

</body>
</html>
<?php ob_flush(); ?>