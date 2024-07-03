<?php 
include "./backend/connect.php";
$wishList = 0;
$order = 0;
session_start();
	if(isset($_SESSION["user_id"])){
		$req = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
		$req->execute(array($_SESSION["user_id"]));
		$wishList = $req->rowCount();
		$req1 = $connect->prepare("SELECT * FROM cart WHERE user_id = ?");
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
	<link rel="stylesheet" href="./includes/bootstrap.min.css">
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
		<div class="container-fluid">
			<div class="row">
				<div class="contact col-lg-6 col-md-12">
						<div class="contact-item">
							<i class="fi fi-rr-envelope"></i><span>exmeple@email.com</span>
						</div>

						<div class="contact-item">
							<i class="fi fi-rr-phone-flip"></i><span>+125-54-84-52</span>	
						</div>
				</div>

				<div class="account col-lg-6 col-md-12">
					<a href="account"><i class="fi fi-rr-user"></i>
					<?php
					if(!isset($_SESSION["user_id"])){
						echo "Login / Register";
					}
					?>
				</a>
				</div>

			</div>
		</div>
	</div>

	<div class="search-bar">
		<div class="container-fluid">
			<div class="row align-items-center justify-content-center text-center">
				<div class="navbar-brand col-lg-3 col-sm-6">
					<a href="./">
						<img src="img/logo.png" alt="" draggable="false">
					</a>
				</div>	

				<form action="" class="home-search col-lg-6" method="GET">
					
						<input type="search" placeholder="Search products...">
						<input type="submit" value="Search">

				</form>
				<div class="cart col-lg-3 col-sm-6">
					<a href="account?page=wishlist">
						<i class="fi fi-rr-heart"></i>
						<span class="wishlist-count"><?php echo $wishList; ?></span>
					</a>
					<a href="account?page=orders">
						<i class="fi fi-rr-shopping-cart"></i>
						<span class="orders-count"><?php echo $order; ?></span>
					</a>
				</div>
			</div>	
			

		</div>	
	</div>


<nav class="navbar navbar-expand-lg bg-body-tertiary animate__animated">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
    
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav m-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="./">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="shop">Shop</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Men</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Women</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
				</li>
			</ul>
		</div>
	</div>
</nav>