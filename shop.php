<?php
   include "backend/connect.php";
   include "includes/navbar.php";
   $req = $connect->prepare("SELECT * from products");
   $req->execute();
   $count = $req->rowCount();
   $req = $connect->prepare("SELECT * FROM products");
   $req->execute(); 
   ?>
<?php 
   if(isset($_GET["product"])){
      $product_id = $_GET["product"];
      $req = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
      $req->execute(array($product_id));
?>

      <div class="product-show">
         
      </div>

<?php
      

   }

   else{
?>
<div class="shop-content">
   <div class="container">
      <div class="bread-crumb"><a href="./">Home</a> | <a href="shop" class="active">Shop</a></div>
      <div class="content-wrap">
         <div class="row">
            <div class="col-lg-3">
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
                        <h4>Price <i class="fi fi-rr-minus"></i></h4>
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
            </div>
            <div class="col-lg-9">
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
                           $wished = "";
                           $ordered = 0;
                           while ($row = $req->fetch()) {
                           	// Start Fetching Products
                           	if(isset($_SESSION['user_id'])){
                           		$wished = $connect->prepare("SELECT * FROM wishlist WHERE product_id = ? AND user_id = ?");
                           		$wished->execute(array($row["product_id"], $_SESSION["user_id"]));
                           		$wished = $wished->rowCount() > 0 ? true : false;
                           
                           		$ordered = $connect->prepare("SELECT * FROM orders WHERE product_id = ? AND user_id = ?");
                           		$ordered->execute(array($row["product_id"], $_SESSION["user_id"]));
                           		$ordered = $ordered->rowCount() > 0 ? true : false;
                           	}
                           	
                           ?>
                        <div class="product-card">
													<div class="overlay">
														<div class="quick-view">
															<div class="close">X</div>
															<div class="row">
																<div class="col-lg-6">
																	<img src="<?php echo $row["product_src"]; ?>" />
																</div>
																<div class="col-lg-6">
																<div class="product-des">
																	<h1 class="product-title"><?php echo $row["product_name"]; ?></h1>
																	<p class="desc">Item description</p>
																	<span class="price">$<?php echo $row["product_price"]; ?></span>
																</div>		

																</div>
															</div>

														</div>
													</div>
                           <div class="product-icons">
                              <div class="icon">
                                 <i class='fi fi-rr-heart <?php if($wished) echo "active" ?>'></i>
                                 <span>
                                 <?php 
                                    echo $wished ? "Remove from wishlist" : "Add to wishlist";
                                    ?>
                                 </span>
                              </div>
                              <div class="icon">
                                 <i class="fi fi-rr-shopping-cart <?php if($ordered) echo "active" ?>"></i>
                                 <span>
                                 <?php 
                                    echo $ordered ? "Remove from cart" : "Add to cart";
                                    ?>	
                                 </span>
                              </div>
                              <div class="icon">
                                 <i class="fi fi-rr-eye"></i>
                                 <span>Quick view</span>
                              </div>
                              <input type="hidden" value="<?php echo $row["product_id"]; ?>">
                           </div>
                           <img src="<?php echo $row["product_src"]; ?>" alt="" />
                           <div class="product-caption">
                              <p>
                                 <a href="shop.php?product=<?php echo $row["product_id"] ?>"><?php echo $row["product_name"]; ?></a>
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
   </div>
</div>
<?php
   }
   include "includes/footer.php";
   ?>