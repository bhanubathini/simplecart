<?php
if($_SESSION['user_data']['role'] == 1)
{
    ?>
<ul class="widget widget-menu unstyled">
    <li class="active"><a href="index.php"><i class="menu-icon icon-dashboard"></i>Dashboard
    </a></li>
   
   
</ul>
<!--/.widget-nav-->
<ul class="widget widget-menu unstyled">
    <li><a class="collapsed" data-toggle="collapse" href="#toggleUsers"><i class="menu-icon icon-user">
    </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
    </i>Users </a>
        <ul id="toggleUsers" class="collapse unstyled">
            <li><a href="view-users.php"><i class="icon-lock"></i>Registered users </a></li>
            <li><a href="add-users.php"><i class="icon-rss"></i>Add Retailer </a></li>
           <li><a href="add-store.php"><i class="icon-rss"></i>Add Store </a></li>                                    </ul>
    </li>
    
</ul>
    <?php
}
?>


 
  
 <ul class="widget widget-menu unstyled">
	<li><a class="collapsed" data-toggle="collapse" href="#toggleStore"><i class="menu-icon  icon-shopping-cart">
    </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
    </i>Store </a>
        <ul id="toggleStore" class="collapse unstyled">
             <li><a href="store.php"><i class="menu-icon icon-plus"></i>Add Products </a></li>
             <?php
if($_SESSION['user_data']['role'] == 1)
{
    ?>
             <li><a href="add-category.php"><i class="menu-icon icon-plus"></i>Add Product Categories </a></li>
<?php
}
?>
             <li><a href="orders.php"><i class="menu-search"></i>Orders </a></li>
        </ul>
    </li>
</ul>

 

<ul class="widget widget-menu unstyled">
	<li><a class="collapsed" data-toggle="collapse" href="#toggleSettings"><i class="menu-icon icon-cogs">
    </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
    </i>Settings </a>
        <ul id="toggleSettings" class="collapse unstyled">
            <li><a href="settings.php"><i class="icon-cog"></i>General Settings </a></li>                                    </ul>
    </li>
    
</ul>
  

<!--/.widget-nav-->
<ul class="widget widget-menu unstyled">
    
    <li><a href="logout.php"><i class="menu-icon icon-signout"></i>Logout </a></li>
</ul>