<?php

session_start();

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (isset($_SESSION["user_id"])) {
		$product_id =  $_POST["product_id"];
		$date = date("Y-m-d");
		$req1 = $connect->prepare("INSERT INTO orders values('','$product_id','$_SESSION[user_id]','$date','pending')");
		$req1->execute();
		$req2 = $connect->prepare("SELECT * FROM orders WHERE user_id = ?");
		$req2->execute(array($_SESSION["user_id"]));
		echo $req2->rowCount();
	}
}

?>
