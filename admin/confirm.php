<?php

include "../backend/connect.php";

$query = $connect->prepare("UPDATE orders SET order_status = 'complete' WHERE order_id = ?");
$query->execute(array($_GET["id"]));
header("location:index.php?page=orders");