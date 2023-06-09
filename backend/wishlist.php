<?php 

session_start();

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (isset($_SESSION["user_email"])) 
	{
		$product_id =  $_POST["product_id"];
		$req1 = $connect->prepare("INSERT INTO wishlist values('','$product_id','$_SESSION[user_id]')");
		$req1->execute();
		$req2 = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
		$req2->execute(array($_SESSION["user_id"]));
		echo $req2->rowCount();
	}
}

?>