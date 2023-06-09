<?php

include "connect.php";

if( $_SERVER["REQUEST_METHOD"] === "POST" )
{
	$firstname = $_POST["firstname"];
	$lastname  = $_POST["lastname"];
	$email     = $_POST["email"];
	$password  = $_POST["password"];

	$stat = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
	$stat->execute(array($email));
	$count = $stat->rowCount();
	$date = date("Y-m-d");
	if($count == 0)
	{
		$stat1 = $connect->prepare("INSERT INTO users VALUES ('','$firstname','$lastname','$email','$password','0', '$date')");
		$stat1->execute();
		echo "
			<form action=' class='signup' method='POST' id='signup-form'>
			<div class='alert alert-success'>User registered successfully !</div>
			
			<div class='form-group'>
				<input 
				 type='text' 
				 placeholder='First Name' 
				 name='firstname'
				 id='firstname-signup'
				 autocomplete='off'>
			</div>
			
			<div class='form-group'>
				<input
				 type='text' 
				 placeholder='Last Name' 
				 name='lastname' 
				 id='lastname-signup'
				 autocomplete='off'>
			</div>

			<div class='form-group'>
				<input 
				 type='email' 
				 placeholder='Email' 
				 name='email' 
				 id='email-signup'
				 autocomplete='off'>
			</div>
			
			<div class='form-group'>
				<input 
				 type='password' 
				 placeholder='Password' 
				 name='password' 
				 id='password-signup'
				 autocomplete='off'>
			</div>

			<div class='form-group'>
				<input 
				 type='submit'
				 value='Sign Up' 
				 id='account-signup'>
			</div>

		</form>";
	}
	else{
		echo "
			<form action=' class='signup' method='POST' id='signup-form'>
				<div class='alert alert-danger'>This email is already registered!<div>
				
				<div class='form-group'>
					<input 
					 type='text' 
					 placeholder='First Name' 
					 name='firstname'
					 id='firstname-signup'
					 autocomplete='off'>
				</div>

				<div class='form-group'>
					<input
					 type='text' 
					 placeholder='Last Name' 
					 name='lastname' 
					 id='lastname-signup'
					 autocomplete='off'>
				</div>

				<div class='form-group'>
					<input 
					 type='email' 
					 placeholder='Email' 
					 name='email' 
					 id='email-signup'
					 autocomplete='off'>
				</div>

				<div class='form-group'>
					<input 
					 type='password' 
					 placeholder='Password' 
					 name='password' 
					 id='password-signup'
					 autocomplete='off'>
				</div>

				<div class='form-group'>
					<input 
					 type='submit'
					 value='Sign Up' 
					 id='account-signup'>
				 </div>
				 
			</form>";
	}
}

?>