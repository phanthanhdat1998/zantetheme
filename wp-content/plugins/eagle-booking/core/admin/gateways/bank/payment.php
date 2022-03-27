<?php
/*
 * Bank Transfer
 * author  Eagle Themes (Jomin Muskaj)
 * package Eagle Booking
 * version 1.0.0
 */

defined('ABSPATH') || exit;

if ( $eagle_booking_payment_method == 'bank') :

  // PAYPAL VALUES
  $eagle_booking_transaction_id = rand(100000000,999999999);

  // FORM VALUES
  $eagle_booking_form_date_from = $_POST['eagle_booking_checkout_form_date_from'];
  $eagle_booking_form_date_to = $_POST['eagle_booking_checkout_form_date_to'];
  $eagle_booking_form_guests = $_POST['eagle_booking_checkout_form_guests'];
  $eagle_booking_form_adults = $_POST['eagle_booking_checkout_form_adults'];
  $eagle_booking_form_children = $_POST['eagle_booking_checkout_form_children'];

  $eb_room_price = $_POST['eb_room_price'];

  $eagle_booking_form_final_price = $_POST['eagle_booking_checkout_form_final_price'];
  $eagle_booking_deposit_amount = $_POST['eagle_booking_deposit_amount'];
  $eagle_booking_room_id = $_POST['eagle_booking_room_id'];
  $eagle_booking_room_title = $_POST['eagle_booking_room_title'];
  $eagle_booking_form_name = $_POST['eagle_booking_checkout_form_name'];
  $eagle_booking_form_surname = $_POST['eagle_booking_checkout_form_surname'];
  $eagle_booking_form_email = $_POST['eagle_booking_checkout_form_email'];
  $eagle_booking_form_phone = $_POST['eagle_booking_checkout_form_phone'];
  $eagle_booking_form_address = $_POST['eagle_booking_checkout_form_address'];
  $eagle_booking_form_city = $_POST['eagle_booking_checkout_form_city'];
  $eagle_booking_form_country = $_POST['eagle_booking_checkout_form_country'];
  $eagle_booking_form_zip = $_POST['eagle_booking_checkout_form_zip'];
  $eagle_booking_form_requests = $_POST['eagle_booking_checkout_form_requets'];
  $eagle_booking_form_arrival = $_POST['eagle_booking_checkout_form_arrival'];
  $eagle_booking_form_coupon = $_POST['eagle_booking_form_coupon'];
  $eagle_booking_form_services = $_POST['eagle_booking_form_services'];
  $eagle_booking_form_action_type = $_POST['eagle_booking_form_action_type'];
  $eagle_booking_form_payment_status = $_POST['eagle_booking_form_payment_status'];

  // DEFAULTS
  $eagle_booking_form_currency = eb_currency();
  $eagle_booking_date = date('H:m:s F j Y');

	// PAYMENT COMPLETED
	$eagle_booking_payment_completed = true;

 endif;