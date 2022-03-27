<?php
/*
 * Stripe
 * author  Eagle Themes (Jomin Muskaj)
 * package Eagle Booking Stripe Gateway
 * version 1.0.0
 */

defined('ABSPATH') || exit;

if ( $eagle_booking_payment_method == 'stripe' ) :

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

  // Include Stripe API
  require_once EB_PATH . '/core/admin/gateways/stripe/api/init.php';

  // Retrive Stripe Token
  $eagle_booking_stripe_token = $_POST['stripeToken'];

    if( !empty( $eagle_booking_stripe_token ) ){

      \Stripe\Stripe::setApiKey( eb_get_option('eagle_booking_stripe_secret_key') );
      $intent = \Stripe\PaymentIntent::retrieve(trim($eagle_booking_stripe_token));

      if( $intent['status'] == 'succeeded' ){

        $eagle_booking_payment_completed = true;

        $eagle_booking_form_currency = eb_currency();
        $eagle_booking_date = date('H:m:s F j Y');
        $eagle_booking_form_payment_status = 'Completed';
        $eagle_booking_transaction_id = $intent['id'];

      } else {


        $eagle_booking_payment_completed = false;

      }

    } else {

        $eagle_booking_payment_completed = false;

    }


endif;
