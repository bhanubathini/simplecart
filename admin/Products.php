<?php

class Products{
	
	function __construct(){
		$this->db = new db();
		$this->db->dbConnect();
	}

	function __destruct() {
    	$this->db->close_connection();
	}

	function addProduct(){

	}

	function updateProduct(){
		//type update and delete
	}

	function addCategory(){

	}

	function deleteCategory(){
		//type update and delete
	}

	function uploadProductImages(){

	}

	function getProducts(){

	}

	function addToCart(){

	}



	function checkout(){

	}

	function placeOrder(){

	}

	function getOrders(){
		//by orderid, by userid, all orders
	}
}

?>