<?php
  

  require_once("config/db.php");
            $api = new db;
            $api->dbConnect();
            $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
            $limit = 30;
              $plist = "";
            
            $startpoint = ($page * $limit) - $limit;
            if($bycat=@$_GET['cat'])
            {
              $bycat = str_replace("_", " ", $bycat);
              $statement = "n_products WHERE p_cat='$bycat'";
              $h = $bycat;
            }
            else if($bycat=@$_GET['scat'])
            {
              $bycat = str_replace("-", " ", $bycat);
              $statement = "n_products WHERE p_subcat='$bycat'";
              $h = $bycat;
            }
            else if(@$_GET['recommended']==1)
            {
              $bycat=@$_GET['recommended'];
              $statement = "n_products WHERE p_recommend=$bycat";
              $h = "Recommended products";
            }
            else
            {

              $statement = "products";
              $h = "Mom and Kids store";
            }
            $q = mysqli_query($api->db, "select * from {$statement} order by prodcutID desc LIMIT {$startpoint} , {$limit}")  or die(mysql_error());
            $pnum = mysqli_num_rows($q);
            
            if($pnum > 0)
            {
              $plist = '<ul class="products">';
              $i = 1;
              while($r = mysqli_fetch_array($q))
              {
                $id = $r['prodcutID'];
                $name = $r['ProductName'];
                $price = $r['Price'];
                $details = $r['Description'];

                $dateadded = $r['CreatedOn'];

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
                    $plist .= $li.'<div><a href="admin/edit-product.php?id='.$id.'">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin/delete-product.php?id='.$id.'" class="deleteNaani">Delete</a></div>';
                  }
                  else
                  {
                    $plist .= $li.'';
                  }
                        
                $plist .= '<div class="product-thumb">';
           
                              $plist .= '<div class="image-overlay">  
                                          <div class="product-button">
                                              <a href="cart.php?pid='.$id.'" class="add-cart-btn"> Add to cart </a>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="product-details">
                                      <h5><a href="product.php?id='.$id.'"> '.$name.' </a></h5>
                                      <span class="price"> Rs.'.$price.' </span>
                                  </div>
                              </li>';
                        $i++;
              }
              $plist .= '</ul>';
            }
            else
            {
              $plist = 'We have no products listed in our store yet';
            }
echo $plist;
?>