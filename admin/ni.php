<?php
if (preg_match("/vidr/i", "vidr")) {
    echo "A match was found.";
} else {
    echo "A match was not found.";
}
$length = 7;
$password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }
echo $password;
?>
<select>
<option>hi</option>
<option  id="bhanu">bhanu</option>
</select>
<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="jqte/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    	<script>
	$('.jqte-test').jqte();
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
id = $('#bhanu').val();
$('#bhanu').attr('selected','selected');
if(id=='bhanu')
{
 
/*alert(id);*/
}
/*$('#bhanu').atrr('selected', 'selected');*/
	
	});
</script>