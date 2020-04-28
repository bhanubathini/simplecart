<?php
class Users{
	function __construct(){
		$this->db = new db();
		$this->db->dbConnect();
	}

	function __destruct() {
    	$this->db->close_connection();
	}

	function isValidEmail($email){
		if(preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email)){
			return true;
		}else{
			return false;
		}	
	}

	function isUserExist($params){
		$cond = " ";
		$and = 0;
		$email = isset($params['email'])?$params['email']:"";
		$userid = isset($params['userid'])?$params['userid']:"";
		$acivationid = isset($params['acivationid'])?$params['acivationid']:"";
		if($params['email']!=""){
			($and>0)?' AND ':' ';
			$cond .= $and."Email = '$email'";
		}
		if($params['email']!=""){
			$cond .= " Email = '$email'";
		}
		if($params['email']!=""){
			$cond .= " Email = '$email'";
		}
		
		$check = $this->db->query("SELECT * FROM users WHERE Email='$email'");
		if($this->db->fetchNum($check) > 0){
			return true;
		}else{
			return false;
		}
	}

	function signup($params){
		$fname = @$params['firstname'];
	    $lname = @$params['lastname'];
	    $email = @$params['email'];
		$password = @$params['password'];
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$cpwd = @$params['confirmpassword'];
		if($fname!="" || $lname!="" || $email!="" || $params['password']!=""){
			if($this->isUserExist($params)){
				$data['Status'] = 0;
				$data['Message'] = "Email already registered";
			}else{
				//$activate = md5($email);
				$digits = 5;
				$activate = rand(pow(10, $digits-1), pow(10, $digits)-1);
				$ins = $this->db->query("INSERT INTO users(Firstname, Lastname, Email, Password, ActivationId, Status, CreatedOn) VALUES('$fname', '$lname', '$email', '$hashed_password', '$activate', 1, NOW()) ")  or die(mysqli_error($this->db));
				$uid = $this->db->insertId();
				if($ins){

					$sub = " - Verify your email address";
					$from = "bhanu4funn@gmail.com";
					$msg = "Your account has been successfully created. Enter the code to activate your account. <b>".$activate."</b>";
					$headers='From: no-reply@iambhanu.com'. "\r\n";
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
					//$sent=mail($from,$sub,$message,$headers);
				}
				$data['Status'] = 1;
				$data['Message'] = "Success";
			}
		}else{
			$data['Status'] = 0;
			$data['Message'] = "Enter all details";
		}
		echo json_encode($data);
	}

	function activateaccount($params)
	{
		$uid = isset($params['userid'])?$params['userid']:"";
		$actid = isset($params['ActivationId'])?$params['ActivationId']:"";
		$check = $this->db->query("SELECT * FROM users where UserId='$uid' and ActivationId='$actid'")  or die(mysqli_error());
	    $num_rows = $this->db->fetchNum($check);
		if($num_rows==1)
		{
			 $this->db->query("UPDATE users SET Status=1 WHERE UserId='$uid' AND ActivationId='$actid'")  or die(mysqli_error());
			 $data['Status'] = 1;
			 $data['Message'] = "Your email is verified successfully";
		}
		else
		{
			$data['Status'] = 0;
			$data['Message'] = "Link expired or invalid";
		}
		echo json_encode($data);
	}



	function signin($params)
	{
		$email = $params['email'];
		$pwd = $params['password'];

		$check = $this->db->query("SELECT * FROM users where (Email='$email' or Username='$email')")  or die(mysqli_error());
	    $num_rows = $this->db->fetchNum($check);
	  
	    if($num_rows > 0  && $email!="" && $pwd!="")
	    {
	    	$res = $this->db->fetchRowResult($check);
	    	if(password_verify($pwd, $res['Password'])){

	    	

	    	
			if($res['Status']==1)
			{ 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 		 	
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['ProfileImage'], "retailer" => $res['Retailer'], "IsActive"=>$res['Status'], "ActivationId"=>$res['ActivationId']);
	      		//$_SESSION['usr_data'] = $data;
	      		$data['Message'] = "Success";
	      		$data['Status'] = 1;
			}
			else
			{
				$data['Status'] = 0;
				$data['Message'] = "Verify your email";
			}
		}
	else{
			$data['Message'] = "Login failed";
			$data['Status'] = 0;
	     }
			//header("Location:$url"); // perform correct redirect.
	     }
	     else
	     {
			$data['Message'] = "Login failed";
			$data['Status'] = 0;
	     }
		echo json_encode($data);
	}

	function forgot($email)
	{
		/*require_once("api.php");
		$api = new API;
		$this->connConnect();*/
		
		$check = $this->db->query("SELECT * FROM users where (Email='$email' or Username='$email')")  or die(mysqli_error($this->conn));
	    $num_rows = $this->db->fetchNum($check);
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
			
	    	$res = $this->db->fetchRowResult($check);
			$id = $res['UserId'];
			$this->db->query("UPDATE users SET ResetAuthKey='$key' WHERE UserId=$id");
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
			$data['Message'] = "Success";
			//exit();	
	     }
	     else
	     {
			$data['Message'] = "Failed";
	     }
	     echo json_encode($data);
	      	
	}

	function updateAddress($params){
		$updateQry = $this->db->query("UPDATE addressbook SET Status=0 where UserId='".$params['userid']."' AND Status=1") or die(mysqli_error());
		$addrQry = $this->db->query("INSERT INTO addressbook (UserId, Street, City, PinCode, State, Country, Mobile, Status, CreatedOn) VALUES ('".$params['userid']."', '".$params['Street']."', '".$params['City']."', '".$params['PinCode']."', '".$params['State']."', '".$params['Country']."', '".$params['Mobile']."', 1, NOW()) ") or die(mysqli_error());
		//$data['AddressId'] = $this->db->insertId();
		//$data['Status'] = 1;
		//echo json_encode($data);
		return $this->db->insertId();
	}

	function getAddresses($params){
		$addrQry = $this->db->query("SELECT * FROM addressbook where UserId='".$params['userid']."' AND Status=1 AND Billing=0 ORDER BY AddressId DESC LIMIT 1") or die(mysqli_error());
	    $addrCount = $this->db->fetchNum($addrQry);
	  
	    if($addrCount > 0){
	    	$res = $this->db->fetchRowResult($addrQry);
	    	$data['Status'] = 1;
	    	$data['AddressId'] = $res['AddressId'];
	    	$data['Street'] = $res['Street'];
	    	$data['City'] = $res['City'];
	    	$data['PinCode'] = $res['PinCode'];
	    	$data['State'] = $res['State'];
	    	$data['Country'] = $res['Country'];
	    	$data['Mobile'] = $res['Mobile'];
	    	$data['Message']  = "";
	    }else{
	    	$data['Status'] = 0;
	    	$data['Message'] = "Set address";
	    }
	    echo json_encode($data);
	}

	function profilePic()
	{
		/*require_once("api.php");
		$api = new API;
		$this->connConnect();
		$id = $_SESSION['usr_data']['id'];*/
		$id = $params['userid'];
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
	    		/*$_SESSION['pic'] = "Return Code: " . $_FILES["ppic"]["error"] . "<br />";*/
				$data['Message'] = "Upload failed";
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
					$this->db->query("UPDATE users SET ProfileImage='$imgdir' WHERE UserId=$id");
					$check = $this->db->query("SELECT * FROM users where UserId='$id'")  or die(mysqli_error($this->conn));
	   		$num_rows = $this->db->fetchNum($check);
		    if($num_rows > 0)
	    	{
	    		$res = mysqli_fetch_array($check);
	      		$data = array("id"=>$res['UserId'],"fname"=>$res['Firstname'], "lname"=>$res['Lastname'], "username"=>$res['Username'],  "email"=>$res['Email'], "gender"=>$res['Gender'], "dob"=>$res['Dob'], "phone"=>$res['Phone'], "photo"=>$res['ProfileImage'],"street"=>$res['usr_street'], "postal"=>$res['usr_postal'], "city"=>$res['usr_city'], "state"=>$res['usr_state'], "country"=>$res['usr_country'], "bfname"=>$res['usr_bill_fname'], "blname"=>$res['usr_bill_lname'], "bstreet"=>$res['usr_bill_street'], "bpostal"=>$res['usr_bill_postal'], "bcity"=>$res['usr_bill_city'], "bstate"=>$res['usr_bill_state'], "bcountry"=>$res['usr_bill_country'], "active"=>$res['usr_active'], "act_id"=>$res['ActivationId'], "access_ip"=>$res['usr_access_ip']);
	      			$data['Message'] = "Profile picture uploaded";
	    	}
				}
			}
		}
		echo json_encode($data);

	}


	function changePassword()
	{
		/*require_once("api.php");
		$api = new API;
		$this->connConnect();
		$id = $_SESSION['usr_data']['id'];*/
		$id = $params['userid'];
		if($params['opass']!="" || $params['npass']!="" || $params['cnpass']!="" )
		{
			if($params['cnpass']==$params['npass'])
			{
				$opwd = md5($params['opass']);
				$npwd = md5($params['npass']);
				$check = mysqli_query($this->conn, "SELECT * FROM users WHERE UserId=$id AND Password='$opwd'");
				$num = $this->db->fetchNum($check);
				if($num==1)
				{
					mysqli_query($this->conn, "UPDATE users SET Password='$npwd' WHERE UserId=$id ");
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
					$this->connConnect();
				$key = @$_GET['id'];
				$user = @$_GET['user'];
				$fcheckq = mysqli_query($this->conn, "SELECT * FROM users WHERE UserId=$user AND ResetAuthKey='$key'") or die(mysqli_error($this->conn));
				$num = $this->db->fetchNum($fcheckq);
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
		$this->connConnect();
		$id = $params['uid'];
		$pkey = $params['pkey'];
		if($params['newpass']!="" && $params['cnewpass']!="")
		{
			if($params['cnewpass']==$params['newpass'])
			{
				$npwd = md5($params['newpass']);
				$check = mysqli_query($this->conn, "SELECT * FROM users WHERE UserId=$id AND ResetAuthKey='$pkey'");
				$num = $this->db->fetchNum($check);
				if($num==1)
				{
					mysqli_query($this->conn, "UPDATE users SET Password='$npwd', ResetAuthKey='' WHERE UserId=$id ");
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
		$this->connConnect();
		$id = $_SESSION['usr_data']['id'];
		$email = mysqli_real_escape_string($this->conn, $params['email']);
		$check = mysqli_query($this->conn, "SELECT * FROM users WHERE Email='$email'");
		$this->db->fetchNum($check);
		if ($this->db->fetchNum($check) > 0)
				{
	  				header("location:myaccount.php?email=exist");
				}
				else
				{
				//$activate = rand();
		$ins = mysqli_query($this->conn, "UPDATE users SET Email='$email' WHERE UserId=$id")  or die(mysqli_error());
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


	
	


	//save username
	function saveUname()
	{
		require_once("api.php");
		$api = new API;
		$this->connConnect();
		$uname = $params['uname'];
		$email = $_SESSION['usr_data']['email'];
		$id = $_SESSION['usr_data']['id'];
		$check = mysqli_query($this->conn, "SELECT * FROM users WHERE Username='$uname'");
		$this->db->fetchNum($check);
		if ($this->db->fetchNum($check) > 0)
		{
	  		header("location:myaccount.php?uname=exist");
			exit();
		}
		else
		{
			//$activate = rand();
			$ins = mysqli_query($this->conn, "UPDATE users SET Username='$uname' WHERE UserId=$id")  or die(mysqli_error($this->conn));
			$check = mysqli_query($this->conn, "SELECT * FROM users where Email='$email'")  or die(mysqli_error($this->conn));
	   		$num_rows = $this->db->fetchNum($check);
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

$usersObj = new Users();

?>