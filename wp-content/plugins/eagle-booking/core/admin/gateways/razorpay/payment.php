<?php
/*
 * Razorpay Payment Gateway
 * author  Eagle Themes (Jomin Muskaj)
 * package Eagle Booking Razorpay Gateway
 * version 1.0.0
 */

defined('ABSPATH') || exit;

// Include Razorpay API
require_once EB_PATH . '/core/admin/gateways/razorpay/api/razorpay.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$razorpay_public_key = eb_get_option('razorpay_public_key');
$razorpay_secret_key = eb_get_option('razorpay_secret_key');

if ( $eagle_booking_payment_method == 'razorpay' ) :

  $eagle_booking_form_date_from = $_POST['eb_checkout_form_date_from'];
  $eagle_booking_form_date_to = $_POST['eb_checkout_form_date_to'];
  $eagle_booking_form_guests = $_POST['eb_checkout_form_guests'];
  $eagle_booking_form_adults = $_POST['eb_checkout_form_adults'];
  $eagle_booking_form_children = $_POST['eb_checkout_form_children'];

  $eb_room_price = $_POST['eb_room_price'];

  $eagle_booking_form_final_price = $_POST['eb_checkout_form_final_price'];
  $eagle_booking_deposit_amount = $_POST['eb_deposit_amount'];
  $eagle_booking_room_id = $_POST['eb_room_id'];
  $eagle_booking_room_title = $_POST['eb_room_title'];
  $eagle_booking_form_name = $_POST['eb_checkout_form_name'];
  $eagle_booking_form_surname = $_POST['eb_checkout_form_surname'];
  $eagle_booking_form_email = $_POST['eb_checkout_form_email'];
  $eagle_booking_form_phone = $_POST['eb_checkout_form_phone'];
  $eagle_booking_form_address = $_POST['eb_checkout_form_address'];
  $eagle_booking_form_city = $_POST['eb_checkout_form_city'];
  $eagle_booking_form_country = $_POST['eb_checkout_form_country'];
  $eagle_booking_form_zip = $_POST['eb_checkout_form_zip'];
  $eagle_booking_form_requests = $_POST['eb_checkout_form_requets'];
  $eagle_booking_form_arrival = $_POST['eb_checkout_form_arrival'];
  $eagle_booking_form_coupon = $_POST['eb_form_coupon'];
  $eagle_booking_form_services = $_POST['eb_form_services'];
  $eagle_booking_form_action_type = $_POST['eb_form_action_type'];

  $success = true;

  if ( empty($_POST['razorpay_payment_id']) === false ) {

      $api = new Api($razorpay_public_key, $razorpay_secret_key);

      try {

          $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
          );

          $api->utility->verifyPaymentSignature($attributes);

      } catch(SignatureVerificationError $e) {

          $success = false;
          // $error = 'Razorpay Error : ' . $e->getMessage();
      }

  } else {

    $success = false;

  }

  // Check Status
  if ($success === true) {

    // Payment was successful
    $eagle_booking_payment_completed = true;

    $eagle_booking_form_currency = eb_currency();
    $eagle_booking_date = date('H:m:s F j Y');
    $eagle_booking_form_payment_status = 'Completed';
    $eagle_booking_transaction_id = $_POST['razorpay_payment_id'];

  } else {

    // Payment faild
    $eagle_booking_payment_completed = false;
  }


endif;
