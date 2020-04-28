<?php
class db {

	const DB_SERVER = "localhost";
	const DB_USER = "root";
	const DB_PASSWORD = ""; 
	const DB = "shopapp";



	public $db = NULL;


	//Database connection
	public function dbConnect(){
		$this->db = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		return $this->db;
	}

		 
	 //Mysql connection close
	 public function close_connection(){
			$close = mysqli_close($this->db);
			/* if($close){
				echo 'Connection Closed';
			}
			else{
				echo 'Not Closed';
			} */
	 }
	 
	//Multiple rows fetching
	function fetchArray($query_result){	
		$array = mysqli_fetch_array($query_result,MYSQLI_ASSOC);
		return $array;
	}
	//Get query result
	function query($get_query){
		$get_result = mysqli_query($this->db,$get_query)or die(mysqli_error($this->db));
		return $get_result;
	}
		
	//getting single record
	function fetchRow($select_query){
		$select_result=mysqli_query($this->db,$select_query)or die(mysqli_error($this->db));
		$select_row = mysqli_fetch_array($select_result);
		return $select_row;
	}	
	//getting selected field in a record
	function fetch_field($select_query){
		$select_result=mysqli_query($this->db,$select_query) or die(mysqli_error($this->db));
		$select_row = mysqli_fetch_array($select_result);
		if($select_row) return $select_row[0]; else return 0;
	}				
	//count records
	function fetchNum($select_result){
		/*$select_result=mysqli_query($this->db,$select_query) or die(mysqli_error($this->db));*/
		$get_num = mysqli_num_rows($select_result);
		return $get_num;
	}

	// records count
	function fetchNumCount($select_query_result){
		$get_num = mysqli_num_rows($select_query_result);
		return $get_num;
	}

	//getting single record
	function fetchRowResult($select_result){
		$select_row = mysqli_fetch_array($select_result);
		return $select_row;
	}

	function escapeString($string){
		$string = mysqli_real_escape_string($this->db,$string);
		return $string;
	}

	function htmlescapeString($string){
		$string = htmlspecialchars(mysqli_real_escape_string($this->db,$string));
		return $string;
	}

	function insertId(){
		$id = mysqli_insert_id($this->db);
		return $id;
	}
}

//$db = new db();
//$conn = $db->dbConnect();
//$db->close_connection();
?>