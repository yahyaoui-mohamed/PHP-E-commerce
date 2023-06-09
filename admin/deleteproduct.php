<?php 
  include "../backend/connect.php";
  $req = $connect->prepare("DELETE FROM products WHERE product_id = ?");
  $req->execute(array($_GET["id"]));
  header("location:index.php?page=products");
?>