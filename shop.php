<?php
	include "backend/connect.php";
	include "includes/navbar.php";
	$req = $connect->prepare("SELECT * from products");
	$req->execute();
	$count = $req->rowCount();
	if (isset($_GET["page"])) {
		session_start();
		if ($_GET["page"] === "orders")
			$req = $connect->prepare("SELECT * from cart WHERE user_id = ?");
			$req->execute(array($_SESSION["user_id"]));
			echo $req->rowCount();
	} else {
		if (isset($_SESSION['user_id'])){
			$req = $connect->prepare("SELECT p.product_id,p.product_name,p.product_price,p.product_src,p.product_sale,w.wishlist_id from products p LEFT JOIN wishlist w ON (w.product_id = p.product_id AND w.user_id = ?);");
			$req->execute(array($_SESSION["user_id"]));

		}
?>
	
	<div class="shop-content">

		<div class="container">
			<div class="bread-crumb"><a href="./">Home</a> | <a href="shop" class="active">Shop</a></div>

			<div class="content-wrap">
				<div class="side-bar">
					<div class="filter">
						<div class="filter-item">
							<h4>Categories <i class="fi fi-rr-minus"></i></h4>
							<ul>
								<li>Men</li>
								<li>Women</li>
								<li>Kids</li>
							</ul>
						</div>

						<div class="filter-item">
							<h4>Vendor <i class="fi fi-rr-minus"></i></h4>
							<ul>
								<li>Adidas</li>
								<li>Nike</li>
								<li>Lacoste</li>
							</ul>
						</div>

						<div class="filter-item">
							<h4>Pirce <i class="fi fi-rr-minus"></i></h4>
							<ul>
								<li>$0 - $100</li>
								<li>$100 - $200</li>
								<li>$200 - $500</li>
								<li>$500 - $1000</li>
								<li>$1000 - $10000</li>
							</ul>
						</div>

						<div class="filter-item">
							<h4>Color <i class="fi fi-rr-minus"></i></h4>
							<ul>
								<li><span></span>White</li>
								<li><span></span>Black</li>
								<li><span></span>Gray</li>
								<li><span></span>Green</li>
								<li><span></span>Yellow</li>
								<li><span></span>Blue</li>
							</ul>
						</div>

						<div class="filter-item">
							<h4>Size <i class="fi fi-rr-minus"></i></h4>
							<ul>
								<li>XS</li>
								<li>S</li>
								<li>M</li>
								<li>L</li>
								<li>XL</li>
								<li>XXL</li>
							</ul>
						</div>
					</div>

				</div>

				<div class="content text-center">
					<div class="content-title">
						<span class="title">Shop (<?php echo $count; ?>)</span>
						<span class="data-result">
							Sort By
							<select name="" id="">
								<option value="default">Default</option>
								<option value="price-l">Price: low to high</option>
								<option value="price-h">Price: high to low</option>
								<option value="sell">Most sell</option>
								<option value="name">Name: A to Z</option>
							</select>
						</span>
						<span class="icons">
							<i class="fas fa-th active"></i>
							<i class="fas fa-list"></i>
						</span>
					</div>
					<div class="products">
						<div class="row">

							<?php
							while ($row = $req->fetch()) {
								// Start Fetching Products
							?>
								<div class="product-card">
									<div class="product-icons">
										<div class="icon">
											<?php 
											$class = "";
											if(isset($row["wishlist_id"])){
											if  ($row["wishlist_id"]!= NULL)
												$class = "fi fi-rr-heart-crack";
											else
												$class = "fi fi-rr-heart";
											}
											else
												$class = "fi fi-rr-heart";
											?>
											<i class="<?php echo $class ?>"></i>
											<span>Add to wishlist</span>
										</div>

										<div class="icon">
											<i class="fi fi-rr-shopping-cart"></i>
											<span>Add to cart</span>
										</div>

										<div class="icon">
											<i class="fi fi-rr-eye"></i>
											<span>Quick view</span>
										</div>

										<input type="hidden" value="<?php echo $row["product_id"]; ?>">
									</div>
									<img src="<?php echo $row["product_src"]; ?>" alt="">
									<div class="product-caption">
										<p>
											<a href="#"><?php echo $row["product_name"]; ?></a>
										</p>
										<span class="price"><?php echo $row["product_price"]; ?></span>
									</div>
									<?php if (isset($row["product_sale"])) {
									?>
										<div class="sale">
											<span>Sale</span>
										</div>
									<?php
									} ?>

								</div>
							<?php
							}

							?>

						</div>
					</div>
				</div>

			</div>

		</div>

	</div>

<?php
}
include "includes/footer.php";
?>