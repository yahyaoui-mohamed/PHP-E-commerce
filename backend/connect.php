<?php 

$host 	 = "mysql:host=sql8.freemysqlhosting.net;dbname=sql8625353";
$user 	 = "sql8625353";
$pass 	 = "E63MBXRNu6";
$connect = new PDO($host,$user,$pass);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>