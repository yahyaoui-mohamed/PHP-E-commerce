<?php

include "../backend/connect.php";

$req = $connect->prepare("UPDATE orders SET order_status = 'canceled' WHERE order_id = ?");
$req->execute(array($_GET["id"]));

header("location: index.php?page=orders");