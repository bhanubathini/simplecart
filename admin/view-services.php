<?php
	ob_start();
	
	include_once("functions.php");
	$id = @$_GET['subcat'];
	$cid = @$_GET['cat'];
	pageShow();
	
	
	if($cid==1)
	{
		$title = 'Expecting Parents';
	}
	else if($cid==2)
	{
		$title = 'Parents of new born';
	}
	else if($cid==3)
	{
		$title = 'Parents of toddler';
	}
													 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php  echo $title; ?></title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
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
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="module message">
                                <div class="module-head">
                                    <h3>
                                        <?php  echo $title; ?></h3>
                                </div>
                                <div class="module-option clearfix">
                                    <div class="pull-left">
                                        Select items to delete
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-primary">Delete</a>
                                    </div>
                                </div>
                                <div class="module-body table">
                                    <table class="table table-message">
                                        <tbody>
                                            <?php
											while($prow = mysqli_fetch_array(@$pcheck))
											{
											?>
                                            <tr class="unread">
                                                <td class="cell-check">
                                                    <input type="checkbox" name="checked" class="inbox-checkbox">
                                                </td>
                                               
                                                <td class="cell-author hidden-phone hidden-tablet">
                                                    <?php echo $prow['pg_subcategory']; ?>
                                                </td>
                                                <?php
												if($id==1)
												{
												?>
                                                <td class="cell-title">
                                                <?php echo $prow['pg_week']; ?>
                                                </td>
												<?php
												}
												?>
                                               <!-- <td class="cell-title">
                                                    <?php echo $prow['pg_description']; ?>
                                                </td>-->
                                                <td class="cell-icon hidden-phone hidden-tablet">
                                                    <a href="#" class="btn btn-primary">View</a>
                                                    <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="btn btn-primary">Delete</a>
                                                </td>
                                                
                                            </tr>
                                            <?php
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="module-foot">
                                </div>
                            </div>
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
               <b class="copyright">TricksTown.com</b>
            </div>
        </div>
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
    </html>
<?php ob_flush(); ?>