<?php 

include "includes/navbar.php";

?>
	<div class="contact-us text-center">
		<div class="container">
			<h1>Contact Us</h1>
			<div class="row">
				<div class="contact-sidebar">
					<div class="contact-item">
						<i class="fas fa-map-marker-alt"></i><span>Location:</span>
						<p>A108 Adam Street, New York, NY 535022</p>
					</div>
					<div class="contact-item">
						<i class="fas fa-envelope"></i><span>Email:</span>
						<p>exmeple@email.com</p>
					</div>
					<div class="contact-item">
						<i class="fas fa-phone-alt"></i><span>Call:</span>
						<p>+125-54-84-52</p>
					</div>

					<div class="contact-item">
						<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d408870.74819877!2d10.253618556445327!3d36.81126526966927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2stn!4v1593867331354!5m2!1sfr!2stn" width="100%" height="400px" frameborder="0" style="border:0;"></iframe>
					</div>

				</div>

				<div class="contact-form">
					<form action="" method="POST">
						<div class="row">
							<input type="text" placeholder="First Name">
							<input type="text" placeholder="Last Name">
						</div>
						<input type="text" placeholder="Subject">
						<textarea placeholder="Message"></textarea>
						<input type="submit" value="Send">
					</form>
				</div>
			</div>
		</div>

	</div>


<?php 
include "includes/footer.php";
?>