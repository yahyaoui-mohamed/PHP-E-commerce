$(function () {

	"use strict";

	// Account Sign Up AJAX Submit

	$("#signup-form").submit(function (e) {
		e.preventDefault();

		let firstname = $("#firstname-signup").val(),
			lastname = $("#lastname-signup").val(),
			email = $("#email-signup").val(),
			password = $("#password-signup").val();

		$.ajax(
			{
				method: "POST",
				url: "backend/signup.php",
				data:
				{
					firstname,
					lastname,
					email,
					password,
				},

				success: function (data) {
					$("form.signup").html(data);
					firstname = $("#firstname-signup").val(""),
						lastname = $("#lastname-signup").val(""),
						email = $("#email-signup").val(""),
						password = $("#password-signup").val("");
				}

			}
		);
	});



	// Add To Wishlist

	$(".product-card .product-icons .fi-rr-heart").click(function () {
		let id = $(this).parent().siblings("input").val();
		$.ajax(
			{
				method: "POST",
				url: "backend/wishlist.php",
				data:
				{
					product_id: id,
				},
				success: function (data) {
					$(".wishlist-count").html(data);
				}
			}
		);
	});




	// Add To Cart

	$(".product-card .product-icons .fi-rr-shopping-cart").click(function () {
		let id = $(this).parent().siblings("input").val();
		let icon = $(this);
		$.ajax(
			{
				method: "POST",
				url: "backend/cart.php",
				data:
				{
					product_id: id,
				},
				beforeSend: function () {
					icon.removeClass("fa-shopping-cart").addClass("fa-spinner fa-spin");
				},
				success: function (data) {
					icon.removeClass("fa-spinner fa-spin").addClass("fa-check");
					$(".orders-count").html(data || 0);
				}

			}
		);

	});

	$.ajax(
		{
			method: "POST",
			url: "backend/showcart.php",
			success: function (data) {
				console.log(data);
				$(".orders-count").html(data || 0);
			}

		}
	);

	$.ajax(
		{
			method: "POST",
			url: "backend/showlist.php",
			success: function (data) {
				$(".wishlist-count").html(data || 0);
			}

		}
	);


	// Add To Cart


	$(".fa-trash").click(function () {

		let id = ($(this).parent().siblings("input").val());

		$.ajax(
			{
				method: "POST",
				url: "backend/removeWishlist.php",
				data: {
					id
				},
				success: function (data) {
					$(".wishlist-count").html(data || 0);
				}
			}
		);

		$(this).parent().parent().remove();
	});

});