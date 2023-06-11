<?php 
include "connect.php";
session_start();

if(isset($_SESSION["user_id"]))
{
	$req = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
	$req->execute(array($_SESSION["user_id"]));
	echo $req->rowCount();
	
}

?>