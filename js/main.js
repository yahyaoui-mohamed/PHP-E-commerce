$(function () {

	"use strict";


	///////////// Hide The Preloader On Page Load

	$(document).ready(function () {

		$(".loader").fadeOut();

	});

	///////////// Hide The Preloader On Page Load



	$(".page").click(function(){
		$(this).siblings().removeClass('page-selected');
		$(this).addClass().addClass('page-selected');
		})

	$(this).scroll(function () {

		if ($(this).scrollTop() > 500) {
			$(".scroll-top").fadeIn();
			$("nav").addClass("fixed");
			$("nav").addClass("animate__fadeInDown");
		}
		else {
			$(".scroll-top").fadeOut();
			$("nav").removeClass("fixed");
			$("nav").removeClass("animate__fadeInDown");
			// $("nav").addClass("animate__fadeOutUp");
		}
	});


	$(".scroll-top").click(function (e) {

		e.preventDefault();

		$("html,body").animate({

			scrollTop: 0

		}, 1500);

	});


	$(".side-bar .filter h4").click(function () {

		$(this).parent().find("ul").slideToggle();

		if ($(this).find("i").hasClass("fi-rr-minus")) {
			$(this).find("i").removeClass("fi-rr-minus");
			$(this).find("i").addClass("fi-rr-plus");

		}

		else {
			$(this).find("i").removeClass("fi-rr-plus");
			$(this).find("i").addClass("fi-rr-minus");
		}

	});


	$(".side-bar .filter li").click(function () {

		$(this).toggleClass("active");

	});



	$(".account-login h1 span").click(function (e) {

		$(this).addClass("active").siblings().removeClass("active");
		$(".account-login form").hide();
		$("." + $(this).data("class")).fadeIn(100);

	});

	$("#toggle-pass-login").click(function () {

		if ($(this).text() === "Show") {
			$(this).text("Hide");
			$(".account-login form.login #password").attr("type", "text");
		}
		else {
			$(this).text("Show");
			$(".account-login form.login #password").attr("type", "password");
		}

	});



	$("#toggle-pass").click(function () {

		if ($(this).text() === "Show") {
			$(this).text("Hide");
			$(".profile .profile-info #password").attr("type", "text");
		}
		else {
			$(this).text("Show");
			$(".profile .profile-info #password").attr("type", "password");
		}

	});

	/////////////////////// Update Profile Page

	$("#submit-profile").click(function () {
		let firstname = $("#profile-firstname").val(),
			lastname = $("#profile-lastname").val(),
			email = $("#profile-email").val(),
			password = $("#profile-password").val(),
			newpass = $("#new-password").val();

		$.ajax({
			method: "POST",
			url: "backend/updateprofile.php",
			data: {
				firstname,
				lastname,
				email,
				password,
				newpass
			},
			success: function (data) {
				$(".profile-info").html(data);
				$("<div class='alert alert-success'>Profile Saved Successfully !<div>").insertAfter(".profile h1");
			}
		});
	});

	/////////////////////// Update Profile Page


	$("#profile-pass").click(function () {
		if ($(this).text() === "Show") {
			$(this).text("Hide");
			$("#profile-password").attr("type", "text");
		}
		else {
			$(this).text("Show");
			$("#profile-password").attr("type", "password");
		}
	});

	$("#profile-new-pass").click(function () {
		if ($(this).text() === "Show") {
			$(this).text("Hide");
			$("#new-password").attr("type", "text");
		}
		else {
			$(this).text("Show");
			$("#new-password").attr("type", "password");
		}
	});


	$(".product-card .product-icons .fa-heart").click(function () {
		$(this).addClass("active");
	});




	// End
});
// End