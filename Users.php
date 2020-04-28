<?php
class Users(){
	
	function signup($params){
		$fname = mysqli_real_escape_string($api->db, $_POST['firstname']);
	    $lname = mysqli_real_escape_string($api->db, $_POST['lastname']);
		if (!empty($_POST['gender']))   
		{
			$gender = mysqli_real_escape_string($api->db, $_POST['gender']);
		}
	    $email = mysqli_real_escape_string($api->db, $_POST['email']);
		$pwd = md5(mysqli_real_escape_string($api->db, $_POST['password']));
		$cpwd = $_POST['confirmpassword'];
	if(preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email))
	{
		if($cpwd==$_POST['password'])
		{
			if($fname!="" || $lname!="" || $email!="" || $_POST['password']!="" || $gender!="")
			{
				$check = mysqli_query($api->db, "SELECT * FROM users WHERE Email='$email'");
				mysqli_num_rows($check);
				if (mysqli_num_rows($check) > 0)
				{
	  				header("location:register.php?msg=fail");
					exit();
				}
				else
				{
					$activate = md5($email);
					$ins = mysqli_query($api->db, "INSERT INTO users(Firstname, Lastname, Email, Gender, Password, ActivationId) VALUES('$fname', '$lname', '$email', '$gender', '$pwd', '$activate') ")  or die(mysql_error($api->db));
					$uid = mysqli_insert_id($api->db);
				    if($ins)
				    {
						$sub = "Activation link from Naani Kar Ghar";
						$msg = "Please activate your account to login.<a href='http://naanikaghar.com/register.php?activate=".$activate."&user=".$uid."'>Activate now</a>";
						$headers='From: no-reply@naanikaghar.com'. "\r\n";
						$headers .='To: '.$email. "\r\n";
						$headers .= "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
						$message = "
						<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>".$msg."</body>
						</html>";

			
						//mail
						$sent=mail($from,$sub,$message,$headers);
	    	
						header("location:register.php?msg=success");	
						exit();	
				    }
				}
			}
			else
			{
				header("location:register.php?in=fail");
				exit();
			}
		}
		else
		{
			header("location:register.php?pwd=fail");
			exit();
		}
	}
	else
	{
		header("location:register.php?email=fail");
		exit();
	}
	      	

	}


	function activateaccount($uid, $actid)
	{
		$check = mysqli_query($api->db, "SELECT * FROM Users where UserId='$uid' and ActivationId='$actid'")  or die(mysql_error());
	    $num_rows = mysqli_num_rows($check);
		if($num_rows==1)
		{
			 mysqli_query($api->db, "UPDATE Users SET Status=1 WHERE UserId='$uid' AND ActivationId='$actid'")  or die(mysql_error());
			 header('location:register.php?act=success');
		}
		else
		{
			header('location:register.php?act=invalid');
		}
		
	}

	function signin($email,$pwd)
	{
		$pwd = md5($pwd);
		$check = mysqli_query($api->db, "SELECT * FROM users where (Email='$email' or Username='$email') and Password='$pwd'")  or die(mysql_error());
	    $num_rows = mysqli_num_rows($check);
	    if($num_rows > 0 && $email!="" && $pwd!="")
	    {
	    	$res = mysqli_fetch_array($check);
			if($res['usr_active']==1)
			{ 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 		 	
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['ProfileImage'], "active"=>$res['Status'], "act_id"=>$res['ActivationId']);
	      		$_SESSION['usr_data'] = $data;
			}
			else
			{
				header("location:register.php?act=fail");
				exit();
			}
			if(isset($_SESSION['url'])) {
	   $url = $_SESSION['url']; // holds url for last page visited.
	   }
	else{ 
	   $url = "index.php"; // default page for 
	   }
	header("Location:$url"); // perform correct redirect.
	     }
	     else
	     {
			header("location:register.php?signin=fail");
			exit();
	     }
	      	
	}

	function forgot($email)
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		
		$check = mysqli_query($api->db, "SELECT * FROM users where (Email='$email' or Username='$email')")  or die(mysql_error($api->db));
	    $num_rows = mysqli_num_rows($check);
	    if($num_rows == 1)
	    {
			$length = 7;
			$key = "";
			$possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
	  
			$i = 0; 
	    
			while ($i < $length) { 
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	       		if (!strstr($key, $char)) { 
					$key .= $char;
					$i++;
				}
			}
			
	    	$res = mysqli_fetch_array($check);
			$id = $res['UserId'];
			mysqli_query($api->db, "UPDATE users SET ResetAuthKey='$key' WHERE UserId=$id");
			$name = $res['Firstname']." ".$res['Lastname'];		
			$user = $res['Username'];
			$email = $res['Email'];
			$password = $res['Password'];
			$res['usr_active'];
			$res['usr_access_ip'];
			$sub = "Reset your password on NaaniKaGhar";
			$msg = "Hi ".$name."You are receiving this email because you have requested for password.<br/>
			Your NaaniKaGhar account details are given below.
			Your email: ".$email."<br/>
			Your username: ".$user."<br/>
			Click the below link to change your password now<br/>
			<a href='http://naanikaghar.com/change.php?id=".$key."&user=".$id."'>Change youre password now</a>";
			$headers='From: no-reply@naanikaghar.com'. "\r\n";
			$headers .='To: '.$email. "\r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$message = "
			<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>".$msg."</body>
			</html>";
			//mail
			$sent=mail($from,$sub,$message,$headers);
			header("location:register.php?forgot=success");
			exit();	
	     }
	     else
	     {
			header("location:register.php?forgot=fail");
	     }
	      	
	}

	function profilePic()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$id = $_SESSION['usr_data']['id'];
		//image upload
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$extension = pathinfo($_FILES['ppic']['name'], PATHINFO_EXTENSION);
		if ((($_FILES["ppic"]["type"] == "image/png")
		|| ($_FILES["ppic"]["type"] == "image/gif")
		|| ($_FILES["ppic"]["type"] == "image/jpeg"))
		&& ($_FILES["ppic"]["size"] < 20000000)
		&& in_array($extension, $allowedExts))
		{
			if ($_FILES["ppic"]["error"] > 0)
		    {
	    		$_SESSION['pic'] = "Return Code: " . $_FILES["ppic"]["error"] . "<br />";
				header('location:myaccount.php?pic=fail');
		    }
			else
			{
				$image=$_FILES['ppic']['name'];
	        	$type=$_FILES['ppic']['type'];
		        $size=$_FILES['ppic']['size'];
	    	    $tempname=$_FILES['ppic']['tmp_name'];
	        	$imgdir="uploads/users/".$id.".".$extension;
		        if(move_uploaded_file($tempname,"$imgdir"))
				{
					mysqli_query($api->db, "UPDATE users SET ProfileImage='$imgdir' WHERE UserId=$id");
					$check = mysqli_query($api->db, "SELECT * FROM users where UserId='$id'")  or die(mysqli_error($api->db));
	   		$num_rows = mysqli_num_rows($check);
		    if($num_rows > 0)
	    	{
	    		$res = mysqli_fetch_array($check);
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['ProfileImage'],"street"=>$res['usr_street'], "postal"=>$res['usr_postal'], "city"=>$res['usr_city'], "state"=>$res['usr_state'], "country"=>$res['usr_country'], "bfname"=>$res['usr_bill_fname'], "blname"=>$res['usr_bill_lname'], "bstreet"=>$res['usr_bill_street'], "bpostal"=>$res['usr_bill_postal'], "bcity"=>$res['usr_bill_city'], "bstate"=>$res['usr_bill_state'], "bcountry"=>$res['usr_bill_country'], "active"=>$res['usr_active'], "act_id"=>$res['ActivationId'], "access_ip"=>$res['usr_access_ip']);
	      			$_SESSION['usr_data'] = $data;
	    	}
			header("location:myaccount.php?details=success");
			exit();
				}
			}
		}

	}


	function changePassword()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$id = $_SESSION['usr_data']['id'];
		if($_POST['opass']!="" || $_POST['npass']!="" || $_POST['cnpass']!="" )
		{
			if($_POST['cnpass']==$_POST['npass'])
			{
				$opwd = md5($_POST['opass']);
				$npwd = md5($_POST['npass']);
				$check = mysqli_query($api->db, "SELECT * FROM users WHERE UserId=$id AND Password='$opwd'");
				$num = mysqli_num_rows($check);
				if($num==1)
				{
					mysqli_query($api->db, "UPDATE users SET Password='$npwd' WHERE UserId=$id ");
					header('location:myaccount.php?pwd=success');
				}
				else
				{
					header('location:myaccount.php?pwd=fail');
				}
			}
			else
			{
				header('location:myaccount.php?pwd=nomatch');
			}
		}
		else
		{
			header('location:myaccount.php?pwd=fail');
		}
	}


	function forgotChange()
	{
	require_once("api.php");
					$api = new API;
					$api->dbConnect();
				$key = @$_GET['id'];
				$user = @$_GET['user'];
				$fcheckq = mysqli_query($api->db, "SELECT * FROM users WHERE UserId=$user AND ResetAuthKey='$key'") or die(mysqli_error($api->db));
				$num = mysqli_num_rows($fcheckq);
				$rc = mysqli_fetch_array($fcheckq);
				if($num==1)
				{
				global $form;
	       $form ='<div class="modal-example-header">
	            <h4 id="modalregh4">Change Password</h4>
	        </div>
		    <div class="leftfloat w60 modal-example-body">
	        <div class="berror">
			</div>
	        <form action="cp.php" method="post" id="bhanureg">
	           <input type="password" id="newpass" name="newpass" placeholder="Enter new password" ><br /><br />
	           <input type="password" id="cnewpass" name="cnewpass" placeholder="Confirm new password" ><br /><br />
	           <input type="hidden" id="pkey" name="pkey" value="'.$key.'">
			   <input type="hidden" id="uid" name="uid" value="'.$user.'">
	           <button type="submit" class="trickstown-button small pink" name="pchangenaani">Change</button>
	        </form>
	            
	        </div>
	        <div>
	        Change your password now or login to your account if you know your old password.
	        </div>';
				}
				
				else
				{
					header('location:change.php?forgot=invalid');
					exit();
				}
	}
	function changeFPwd()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$id = $_POST['uid'];
		$pkey = $_POST['pkey'];
		if($_POST['newpass']!="" && $_POST['cnewpass']!="")
		{
			if($_POST['cnewpass']==$_POST['newpass'])
			{
				$npwd = md5($_POST['newpass']);
				$check = mysqli_query($api->db, "SELECT * FROM users WHERE UserId=$id AND ResetAuthKey='$pkey'");
				$num = mysqli_num_rows($check);
				if($num==1)
				{
					mysqli_query($api->db, "UPDATE users SET Password='$npwd', ResetAuthKey='' WHERE UserId=$id ");
					header('location:change.php?forgot=success');
				}
				else
				{
					header('location:change.php?pwd=fail');
				}
			}
			else
			{
				header('location:change.php?id='.$pkey.'&user='.$id.'&pwd=nomatch');
			}
		}
		else
		{
			header('location:change.php?id='.$pkey.'&user='.$id.'&pwd=fail');
		}
	}

	//save account email, username
	function saveAcc()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$id = $_SESSION['usr_data']['id'];
		$email = mysqli_real_escape_string($api->db, $_POST['email']);
		$check = mysqli_query($api->db, "SELECT * FROM users WHERE Email='$email'");
		mysqli_num_rows($check);
		if (mysqli_num_rows($check) > 0)
				{
	  				header("location:myaccount.php?email=exist");
				}
				else
				{
				//$activate = rand();
		$ins = mysqli_query($api->db, "UPDATE users SET Email='$email' WHERE UserId=$id")  or die(mysql_error());
	    if($ins)
	    {
			$message = "
			<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>".$msg."</body>
			</html>";

			$sub = "Activation link from Naani Kar Ghar";
			$message = "Please activate your account to login.";
			$headers='From: no-reply@naanikaghar.com'. "\r\n";
			$headers .='To: '.$email. "\r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			//mail
			$sent=mail($from,$sub,$message,$headers);
	    	
			header("location:register.php?email=success");		
	    }
		}
		
	}


	//save personal
	function savePDetails()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$id = $_SESSION['usr_data']['id'];
		$fname = mysqli_real_escape_string($api->db, $_POST['fname']);
		$lname = mysqli_real_escape_string($api->db, $_POST['lname']);
		if(!empty($_POST['gender']))
		{
			$gender = mysqli_real_escape_string($api->db, $_POST['gender']);
		}
		$dob = date("Y-m-d", strtotime(mysqli_real_escape_string($api->db, $_POST['dob'])));
		$phone = mysqli_real_escape_string($api->db, $_POST['phone']);
		$street = mysqli_real_escape_string($api->db, $_POST['street']);
		$city = mysqli_real_escape_string($api->db, $_POST['city']);
		$state = mysqli_real_escape_string($api->db, $_POST['state']);
		$country = mysqli_real_escape_string($api->db, $_POST['country']);
		$postal = mysqli_real_escape_string($api->db, $_POST['postal']);
		
		
			//$activate = rand();
			$ins = mysqli_query($api->db, "UPDATE users SET Firstname='$fname', Lastname='$lname', Gender='$gender', Dob='$dob', Phone='$phone', usr_street='$street', usr_postal='$postal', usr_city='$city', usr_state='$state', usr_country='$country', usr_bill_fname='$fname', usr_bill_lname='$lname', usr_bill_street='$street', usr_bill_postal='$postal', usr_bill_city='$city', usr_bill_state='$state', usr_bill_country='$country' WHERE UserId=$id")  or die(mysqli_error($api->db));
			$check = mysqli_query($api->db, "SELECT * FROM users where UserId='$id'")  or die(mysqli_error($api->db));
	   		$num_rows = mysqli_num_rows($check);
		    if($num_rows > 0)
	    	{
	    		$res = mysqli_fetch_array($check);
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['usr_photo'],"street"=>$res['usr_street'], "postal"=>$res['usr_postal'], "city"=>$res['usr_city'], "state"=>$res['usr_state'], "country"=>$res['usr_country'], "bfname"=>$res['usr_bill_fname'], "blname"=>$res['usr_bill_lname'], "bstreet"=>$res['usr_bill_street'], "bpostal"=>$res['usr_bill_postal'], "bcity"=>$res['usr_bill_city'], "bstate"=>$res['usr_bill_state'], "bcountry"=>$res['usr_bill_country'], "active"=>$res['usr_active'], "act_id"=>$res['ActivationId'], "access_ip"=>$res['usr_access_ip']);
	      			$_SESSION['usr_data'] = $data;
	    	}
			header("location:myaccount.php?details=success");
			exit();
		
	}


	//save username
	function saveUname()
	{
		require_once("api.php");
		$api = new API;
		$api->dbConnect();
		$uname = $_POST['uname'];
		$email = $_SESSION['usr_data']['email'];
		$id = $_SESSION['usr_data']['id'];
		$check = mysqli_query($api->db, "SELECT * FROM users WHERE Username='$uname'");
		mysqli_num_rows($check);
		if (mysqli_num_rows($check) > 0)
		{
	  		header("location:myaccount.php?uname=exist");
			exit();
		}
		else
		{
			//$activate = rand();
			$ins = mysqli_query($api->db, "UPDATE users SET Username='$uname' WHERE UserId=$id")  or die(mysqli_error($api->db));
			$check = mysqli_query($api->db, "SELECT * FROM users where Email='$email'")  or die(mysqli_error($api->db));
	   		$num_rows = mysqli_num_rows($check);
		    if($num_rows > 0 && $email!="")
	    	{
	    		$res = mysqli_fetch_array($check);
					 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 		 	
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['usr_photo'],"street"=>$res['usr_street'], "postal"=>$res['usr_postal'], "city"=>$res['usr_city'], "state"=>$res['usr_state'], "country"=>$res['usr_country'], "bfname"=>$res['usr_bill_fname'], "blname"=>$res['usr_bill_lname'], "bstreet"=>$res['usr_bill_street'], "bpostal"=>$res['usr_bill_postal'], "bcity"=>$res['usr_bill_city'], "bstate"=>$res['usr_bill_state'], "bcountry"=>$res['usr_bill_country'], "active"=>$res['usr_active'], "act_id"=>$res['ActivationId'], "access_ip"=>$res['usr_access_ip']);
	      			$_SESSION['usr_data'] = $data;
	    	}
			header("location:myaccount.php?uname=success");
			exit();
		}
	}

}

?>