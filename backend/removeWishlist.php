<?php
session_start();

include "connect.php";

if(isset($_POST["id"]))
{
    $req = $connect->prepare("DELETE FROM wishlist WHERE product_id = ? AND user_id = ?");
    $req->execute(array($_POST["id"],$_SESSION["user_id"]));
}

?>