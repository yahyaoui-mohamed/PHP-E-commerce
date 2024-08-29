<?php 
session_start();

include "connect.php";

if(isset($_POST["id"])){
    $id = $_POST["id"];
    $query = $connect->prepare("DELETE FROM wishlist WHERE wishlist_id = ? AND user_id = ?");
    $query->execute(array($id, $_SESSION["user_id"]));
    $query1 = $connect->prepare("INSERT INTO cart VALUES ('', '$id', '$_SESSION[user_id]')");
    $query1->execute();
}
