<?php

include "connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$firstname = $_POST["firstname"];
	$lastname  = $_POST["lastname"];
	$email     = $_POST["email"];
	$password  = $_POST["password"];

	if ($_POST["newpass"] !== "") {
		$newpass = $_POST["newpass"];
	} else {
		$newpass = $_POST["password"];
	}

	$stat = $connect->prepare(
		"UPDATE users 
		SET user_firstname = ?, user_lastname = ?, user_email = ?,user_password = ? 
		WHERE user_email = ?"
	);
	$stat->execute(array($firstname, $lastname, $email, $newpass, $email));
	$stat1 = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
	$stat1->execute(array($_SESSION["user_email"]));
	while ($row = $stat1->fetch()) {
?>
		<div class="form-group">
			<label for="firstname">First Name</label>
			<input type="text" id="profile-firstname" value="<?php echo $row[1]; ?>">
		</div>

		<div class="form-group">
			<label for="lastname">Last Name</label>
			<input type="text" id="profile-lastname" value="<?php echo $row[2]; ?>">
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" id="profile-email" value="<?php echo $row[3]; ?>">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" id="profile-password" value="<?php echo $row[4]; ?>"><span id="profile-pass">Show</span>
		</div>

		<div class="form-group">
			<label for="new-password">New Password</label>
			<input type="password" id="new-password" name="new-password">
			<span id="profile-new-pass">Show</span>
		</div>

		<div class="form-group">
			<input type="submit" value="Save" id="submit-profile">
		</div>

<?php
	}
}
?>