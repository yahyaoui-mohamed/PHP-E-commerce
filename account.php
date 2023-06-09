<?php
include "includes/navbar.php";
include "backend/connect.php";
if (isset($_SESSION["user_id"])) {
	
	if (isset($_GET["page"])) {
		

		if ($_GET["page"] === "profile") {
			?>

<!-- Start Profile Page -->
<?php
				include "backend/connect.php";
				$stat = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
				$stat->execute(array($_SESSION["user_email"]));
				$row = $stat->fetch();
				$firstname = $row[1];
				$lastname = $row[2];
				$email = $row[3];
				$password = $row[4];
			?>
			<div class="profile text-center">
				<h1>My Profile</h1>
				<div class="container">
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="profile-info">

						<div class="form-group">
							<label for="firstname">First Name</label>
							<input type="text" id="profile-firstname" value="<?php echo $firstname; ?>">
						</div>

						<div class="form-group">
							<label for="lastname">Last Name</label>
							<input type="text" id="profile-lastname" value="<?php echo $lastname; ?>">
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" id="profile-email" value="<?php echo $email; ?>">
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" id="profile-password" value="<?php echo $password; ?>">
							<span id="profile-pass">Show</span>
						</div>

						<div class="form-group">
							<label for="new-password">New Password</label>
							<input type="password" id="new-password" name="new-password">
							<span id="profile-new-pass">Show</span>
						</div>

						<div class="form-group">
							<input type="submit" value="Save" id="submit-profile">
						</div>

					</form>
				</div>
			</div>

			<!-- End Profile Page -->






		<?php
		} else if ($_GET["page"] === "wishlist") {
			// Wishlist Page
			echo "<h1 class='wish-list-title'>Wishlist</h1>";
			$req = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ?");
			$req->execute(array($_SESSION["user_id"]));
			
			if ($req->rowCount() > 0) 
			{
				echo 
				"
				<table class='wishlist-table'>
				<tr>
					<td></td>
					<td>Product</td>
					<td>Description</td>
					<td>Price</td>
				</tr>
				";	
				$total = 0;
				while ($t = $req->fetch()) 
				{
					$req1 = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
					$req1->execute(array($t[0]));
					while ($t1 = $req1->fetch()) 
					{
						$total += (float)substr($t1['product_price'], 1);
					?>

					<tr>
						<td><i class="fas fa-trash"></i></td>
						<td><img src="<?php echo $t1['product_src']; ?>" alt=></td>
						<td><?php echo $t1['product_name']; ?></td>
						<td><?php echo $t1['product_price']; ?></td>
						<input type="hidden" value=<?php echo $t1['product_id']; ?>>
						<td><a href=# class="add-to-cart">Add To Cart</a></td>
					</tr>
					

					<?php
					}
				}
				$floatTotal= (float)$total;
				echo "
				<tr>
				<td colspan=3>Total:</td>
				<td>$$floatTotal.00</td>
				<td><button>Proceed to check out</button></td>
				</tr>
				</table>
				";
			}
			else{
				echo 
				"
				<table class='wishlist-table'>
				<tr>Wishlist is empty.</tr>
				</table>
				";	
			}
		?>



		<?php
		} else if ($_GET["page"] === "cart") {
			$req = $connect->prepare("SELECT * FROM orders WHERE user_id = ?");
			$req->execute(array($_SESSION["user_id"]));
			if ($req->rowCount() > 0) {
				while ($t = $req->fetch()) {
					$req1 = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
					$req1->execute(array($t[0]));
					while ($t1 = $req1->fetch()) {
						echo $t1[0] . " " . $t1[1];
					}
				}
			}
		}
	} else {


		// Start Account Page
		?>
		<div class="account-page text-center">
			<h1>My Account</h1>
			<div class="container">
				<div class="row">

					<a href="?page=profile">
						<div class="account-item">
							<i class="fas fa-user"></i>
							<span>Profile</span>
						</div>
					</a>

					<a href="?page=wishlist">
						<div class="account-item">
							<i class="fas fa-heart"></i>
							<span>Wishlist</span>
						</div>
					</a>

					<a href="?page=cart">
						<div class="account-item">
							<i class="fas fa-shopping-cart"></i>
							<span>Cart</span>
						</div>
					</a>

				</div>
				<a href="backend/logout" class="logout-btn">Logout</a>
			</div>
		</div>


	<?php
		// End Account Page



	}
} else {
	// Start Login Page
	?>

	<div class="account-login text-center">
	<?php 
		if(isset($_SESSION["admin"])){
			header("location:admin/index.php");
		}
	?>
		<h1>
			<span class="login active" data-class="login" title="Login">Login</span> |
			<span class="signup" data-class="signup" title="Sign Up">Signup</span>
		</h1>

		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="login active" method="POST">
			<?php

			include "backend/connect.php";

			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$username = $_POST["username"];
				$password = $_POST["password"];
				// $hashedPass = sha1($password);

				$stat = $connect->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ?");

				$stat->execute(array($username, $password));

				$count = $stat->rowCount();

				if ($count > 0) {
					$stat1 = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
					$stat1->execute(array($username));

					$row = $stat1->fetch();
					$_SESSION["user_id"]        =     $row[0];
					$_SESSION["user_firstname"] = 	   $row[1];
					$_SESSION["user_lastname"]  =  	 $row[2];
					$_SESSION["user_email"] 	  =  	 $row[3];
					$_SESSION["user_pass"] 	    =  	 $row[4];
					if($row[5] === 1){
						$_SESSION["admin"] = true;
						header("location:admin/index.php");
					}
					else{
						header("location:account.php");
					}
				} 
				else {
					echo "<div class='alert alert-danger'>User not found!</div>";
				}
			}

			?>
			<div class="form-group">
				<input type="text" placeholder="Username or Email" name="username" autocomplete="off">
			</div>

			<div class="form-group">
				<input type="password" placeholder="Password" id="password" name="password" autocomplete="off">

				<span id="toggle-pass-login">Show</span>
			</div>


			<input type="submit" value="Login" id="account-login">

			<a href="#">Forgot Password?</a>

		</form>

		<form action="" class="signup" method="POST" id="signup-form">

			<div class="form-group">
				<input type="text" placeholder="First Name" name="firstname" id="firstname-signup" autocomplete="off">
			</div>

			<div class="form-group">
				<input type="text" placeholder="Last Name" name="lastname" id="lastname-signup" autocomplete="off">
			</div>

			<div class="form-group">
				<input type="email" placeholder="Email" name="email" id="email-signup" autocomplete="off">
			</div>

			<div class="form-group">
				<input type="password" placeholder="Password" name="password" id="password-signup" autocomplete="off">
			</div>

			<div class="form-group">
				<input type="submit" value="Sign Up" id="account-signup">
			</div>


		</form>

	</div>


<?php
}
// End Login Page

?>


<?php
include "includes/footer.php";
?>