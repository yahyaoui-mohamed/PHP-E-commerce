<?php 

session_start();

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (isset($_SESSION["user_id"])) 
	{
		$product_id =  $_POST["product_id"];
		$req = $connect->prepare("SELECT * FROM wishlist WHERE product_id = ?");
		$req->execute(array($product_id));
		$count = $req->rowCount();
		if($count > 0){
			$req = $connect->prepare("DELETE FROM wishlist WHERE product_id = ?");
			$req->execute(array($product_id));
		}
		else{
			$req1 = $connect->prepare("INSERT INTO wishlist values('','$product_id','$_SESSION[user_id]')");
			$req1->execute();
			$req2 = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
			$req2->execute(array($_SESSION["user_id"]));
		}
		$req = $connect->prepare("SELECT * FROM wishlist");
		$req->execute();
		echo $req->rowCount();

	}
}
?>