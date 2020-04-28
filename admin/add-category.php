<?php
	ob_start();
	include_once("functions.php");
	require_once("../config/db.php");
	$api = new db;
	$api->dbConnect();
	if (isset($_POST['remove_category'])) {
		$cat = $_POST['category'];
		$qry = mysqli_query($api->db,"DELETE FROM  productcategories WHERE CategoryId = ".$cat." AND CategoryParentId != 0") or die (mysqli_error());
		header('location: add-category.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
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
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.html">Admin </a>
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
						<div class="module">
							<div class="module-head">
								<h3>Category</h3>
							</div>
							<div class="module-body">
									<br />

									<form class="form-horizontal row-fluid" id="catform" method="post">
										<div class="control-group">
											<label class="control-label" for="basicinput">Category</label>
											<div class="controls">
												<input type="text" id="basicinput" name="category" placeholder="Type category name here..." class="span8">
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submitcategory" id="submitcategory">Save</button>
											</div>
										</div>
									</form>
							</div>
						</div>
                        
                        <div class="module">
							<div class="module-head">
								<h3>Sub Category</h3>
							</div>
							<div class="module-body">
									<br />
									<form class="form-horizontal row-fluid" method="post" id="subcatform">
										<div class="control-group">
											<label class="control-label" for="sbasicinput">Sub Category</label>
											<div class="controls">
												<input type="text" id="sbasicinput" name="subcategory" placeholder="Type sub-category name here..." class="span8">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="scatsel">Parent Category</label>
											<div class="controls">
												<select tabindex="1" data-placeholder="Select here.." class="span8" name="scatsel" id="scatsel">
													<option value="0">Select here..</option>
                                                    <?php
														
														$getQuery = mysqli_query($api->db, "SELECT * FROM productcategories ORDER BY CategoryId") or die(mysqli_error());
														$numrows = mysqli_num_rows($getQuery);
														while($row = mysqli_fetch_array($getQuery))
														{
													?>
                                                    		<option value="<?php echo $row['CategoryId']; ?>"><?php echo $row['CategoryName']; ?></option>                                                    <?php
													 
														}
													?>
							
												</select>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn" name="submitsubcategory" id="submitsubcategory">Save</button>
											</div>
										</div>
									</form>
							</div>
						</div>
						<div class="module">
                         <?php
                         
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
							<div class="module-head">
								<h3>Delete categories</h3>
							</div>
                            <div class="module-body">
                            	<form action='add-category.php' method='post'  class="form-horizontal row-fluid" >
                                        <div class="control-group">
											<label>Remove category:</label>
											<div class="controls"> 	  
   											 <?php echo $category_list; ?>
                                            </div>
                                            </div>
                                       <div class="control-group">
										<div class="controls"> 
										  <input class="btn"   type="submit"  name="remove_category" value="Remove Category" />
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
			 

			<b class="copyright">iambhanu.com
		</div>
	</div>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    	<script>
		$(document).ready(function () {
		$('#catform').on('submit', function(e)
		{
			e.preventDefault();
		var un = $('#basicinput').val();
		
		$.ajax({
			url: 'ajax/adc.php',
			type: 'POST',
			cache: false,
			data: {
				'name':un,
				},
			beforeSend: function(){

				$('#submitcategory').text('Saving...');
			},
			success: function(data){
				$('#submitcategory').text('Save');
				$('#catform').trigger('reset');
				$('#scatsel').html(data);
			},
			error: function(e){
				alert(e);
			}
		});
	return false;
				});
		//subcat		
		$('#subcatform').on('submit', function()
		{
		var un = $('#sbasicinput').val();	
		var scatsel = $('#scatsel').val();	
		$.ajax({
			url: 'ajax/adc.php',
			type: 'POST',
			cache: false,
			data: {
				'sname':un,
				'scatsel':scatsel,
				
				},
			beforeSend: function(){

				$('#submitsubcategory').text('Saving...');
			},
			success: function(data){
				/*alert(data);*/
				$('#submitsubcategory').text('Save');
				$('#subcatform').trigger('reset');
				
			},
			error: function(e){
				alert(e);
			}
		});
	return false;
				});
				
			});
		</script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>

</body>
<?php ob_flush(); ?>