<?php 
include "./backend/connect.php";
$wishList = 0;
$order = 0;
session_start();
	if(isset($_SESSION["user_id"])){
		$req = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
		$req->execute(array($_SESSION["user_id"]));
		$wishList = $req->rowCount();

		$req1 = $connect->prepare("SELECT * FROM orders WHERE user_id = ?");
		$req1->execute(array($_SESSION["user_id"]));
		$order = $req1->rowCount();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Store</title>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
	<link rel="stylesheet" href="css/animate.min.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<a href="#" class="scroll-top">
		<i class="fi fi-rr-arrow-up"></i>
	</a>
	
	<div class="loader">
		<div class="loader-inner">
			<span>X</span><span>M</span>
		</div>
	</div>

	<div class="upper-nav">
		<div class="container">
			<div class="row">
				<div class="contact">
						<div class="contact-item">
							<i class="fi fi-rr-envelope"></i><span>exmeple@email.com</span>
						</div>

						<div class="contact-item">
							<i class="fi fi-rr-phone-flip"></i><span>+125-54-84-52</span>	
						</div>
				</div>

				<div class="account">
					<a href="account">My Account</a>
					<a href="account?page=wishlist">
						My Wishlist
						<span class="wishlist-count"><?php echo $wishList; ?></span>
					</a>
					<a href="?page=orders">
						My Orders
						<span class="orders-count"><?php echo $order; ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="search-bar">
		<div class="container">
			<div class="navbar-brand">
				<a href="./">
					<img src="img/logo.png" alt="" draggable="false">
				</a>
			</div>	

			<form action="" class="home-search" method="GET">
				
					<input type="search" placeholder="Type to search...">
					<input type="submit" value="Search">

			</form>

		</div>	
	</div>

	<nav class="animate__animated">
		<div class="container">
			<ul class="navbar">
				<li class="nav-item">
					<a href="./" class="nav-link">Home</a>
				</li>

				<li class="nav-item dropdown">
					<a href="shop" class="nav-link">Shop</a>
					<div class="drop-down">
						<ul>
							<li><a href="#">Accessoires</a></li>
							<li><a href="#">Casual</a></li>
							<li><a href="#">Clothing</a></li>
							<li><a href="#">Women</a></li>
							<li><a href="#">Men</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="nav-link">Men</a>
					<div class="drop-down">
						<ul>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="nav-link">Women</a>
					<div class="drop-down">
						<ul>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
							<li><a href="#">Shop1</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item">
					<a href="contact" class="nav-link">Contact</a>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">About</a>
				</li>

			</ul>
		</div>
	</nav>