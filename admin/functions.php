<?php
include "session.php";



//admin logout
include 'controllers/logout.php';

//category &  sub category

include 'controllers/category.php';

//photo thumbnails
include 'controllers/thumbs.php';

//add service
include 'controllers/service.php';

//add pride
include 'controllers/pride.php';

//page
include 'controllers/page.php';

//pagination
 function pagination($api,$query, $per_page = 10,$page = 1){
   
   $url = '?';
   	//$strReplace1 = str_replace("select * from","",$query);
	//echo $strReplace;
	if(isset($_GET['docsearch']))
	{
	$url = $_SERVER["REQUEST_URI"]."&";
	}
	
          
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
		//echo $query;
    	$row = mysqli_fetch_array(mysqli_query($api->db, $query));
    	$total = $row['num'];
        $adjacents = "2"; 
		$limit = 15;

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
		
		
		$width = 0;
		
		
		if($lastpage < 10)
		{
			$width = ($lastpage * 40) + 54+54+84;
		}
		else
		{
			$width = 540;
		}
		
		
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination' style=\"width:$width\">";
                   /* $pagination .= "<li class='details'>Page $page of $lastpage</li>";*/
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li class='active-page'>$counter</li>";
    				else
    					$pagination.= "<li><a class='btn btn-small' href='{$url}page=$counter'>$counter</a></li>";					
    			}
				
				//echo $counter;
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active-page'>$counter</li>";
    					else
    						$pagination.= "<li><a class='btn btn-small' href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=$lastpage'>$lastpage</a></li>";
					
					
						
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active-page'>$counter</li>";
    					else
    						$pagination.= "<li><a class='btn btn-small' href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=$lastpage'>$lastpage</a></li>";	
					
					
						
    			}
    			else
    			{
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a class='btn btn-small' href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active-page'>$counter</li>";
    					else
    						$pagination.= "<li><a class='btn btn-small' href='{$url}page=$counter'>$counter</a></li>";	
							
									
    				}
					
					
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li class='next-post'><a class='btn btn-small' href='{$url}page=$next'>Next <span class='fa fa-angle-double-right'></span></a></li>";
                $pagination.= "<li><a class='btn btn-small' href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li class='active-page'>Next <span class='fa fa-angle-double-right'></span></li>";
                $pagination.= "<li class='active-page'>Last</li>";
            }
    		$pagination.= "</ul>\n";
			
			//echo $width;		
    	}
		
		else
		{
			//$pagination = "Results Not Found";
		}
    
    
        return $pagination;
    } 

?>