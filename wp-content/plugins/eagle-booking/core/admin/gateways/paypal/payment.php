<?php
/*
 * PayPal Payment Gateway
 * author  Eagle Themes (Jomin Muskaj)
 * package Eagle Booking
 * version 1.0.0
 */

defined('ABSPATH') || exit;

if ( isset($_GET['tx']) ) :

  // PLUGIN OPTIONS
  $eagle_booking_paypal_email = eb_get_option('eagle_booking_paypal_id');
  $eagle_booking_paypal_currency = eb_currency();
  $eagle_booking_paypal_token =  eb_get_option('eagle_booking_paypal_token');
  $eagle_booking_paypal_developer = eb_get_option('eagle_booking_paypal_developer_mode');

  if ( $eagle_booking_paypal_developer == true) {
  $eagle_booking_paypal_action_1 = 'https://www.sandbox.paypal.com/cgi-bin';
  $eagle_booking_paypal_action_2 = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
  } else {
  $eagle_booking_paypal_action_1 = 'https://www.paypal.com/cgi-bin';
  $eagle_booking_paypal_action_2 = 'https://www.paypal.com/cgi-bin/webscr';
  }

  // PAYPAL DEFAULTS
  $eagle_booking_transaction_id = $_GET['tx'];
  $eagle_booking_request = curl_init();

  // PAYPAL REQUEST OPTIONS
  curl_setopt_array($eagle_booking_request, array
  (
    CURLOPT_URL => $eagle_booking_paypal_action_2,
    CURLOPT_POST => TRUE,
    CURLOPT_POSTFIELDS => http_build_query(array
      (
        'cmd' => '_notify-synch',
        'tx' => $eagle_booking_transaction_id,
        'at' => $eagle_booking_paypal_token,
      )),
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER => FALSE,
  ));

  $eagle_booking_response = curl_exec($eagle_booking_request);
  $eagle_booking_status   = curl_getinfo($eagle_booking_request, CURLINFO_HTTP_CODE);

  // CLOSE CONNECTION
  curl_close($eagle_booking_request);

  // PAYPAL PAYMENT STATUS
  if($eagle_booking_status == 200 AND strpos($eagle_booking_response, 'SUCCESS') === 0){

    // DECODE RESPONSE
    $eagle_booking_response = substr($eagle_booking_response, 7);
    $eagle_booking_response = urldecode($eagle_booking_response);
    preg_match_all('/^([^=\s]++)=(.*+)/m', $eagle_booking_response, $m, PREG_PATTERN_ORDER);
    $eagle_booking_response = array_combine($m[1], $m[2]);

    $eagle_booking_room_id = $eagle_booking_response['item_number'];
    $eagle_booking_room_title = $eagle_booking_response['item_name'];

    // PAYPAL USER INFO
    $eagle_booking_paypal_name = $eagle_booking_response['first_name'];
    $eagle_booking_paypal_surname = $eagle_booking_response['last_name'];
    $eagle_booking_paypal_email = $eagle_booking_response['payer_email'];
    $eagle_booking_paypal_address = $eagle_booking_response['address_street'];
    $eagle_booking_paypal_city = $eagle_booking_response['address_city'];
    $eagle_booking_paypal_country = $eagle_booking_response['address_country'];
    $eagle_booking_paypal_zip = $eagle_booking_response['address_zip'];

    // PAYPAL PAYMENT DETAILS
    $eagle_booking_date = $eagle_booking_response['payment_date'];
    $eagle_booking_deposit_amount = $eagle_booking_response['mc_gross'];
    $eagle_booking_form_currency = $eagle_booking_response['mc_currency'];
    $eagle_booking_form_action_type = 'paypal';
    $eagle_booking_form_payment_status = $eagle_booking_response['payment_status'];

    // EXTRACT CUSTOM FIELD FROM 'CUSTOM'
    $eagle_booking_custom_field_array = explode('[eb]', $eagle_booking_response['custom']);
    $eagle_booking_form_date_from = $eagle_booking_custom_field_array[0];
    $eagle_booking_form_date_to = $eagle_booking_custom_field_array[1];
    $eagle_booking_form_guests = $eagle_booking_custom_field_array[2];
    $eagle_booking_form_adults = $eagle_booking_custom_field_array[3];
    $eagle_booking_form_children = $eagle_booking_custom_field_array[4];
    $eagle_booking_form_name = $eagle_booking_custom_field_array[5];
    $eagle_booking_form_surname = $eagle_booking_custom_field_array[6];
    $eagle_booking_form_email = $eagle_booking_custom_field_array[7];
    $eagle_booking_form_phone = $eagle_booking_custom_field_array[8];
    $eagle_booking_form_address = $eagle_booking_custom_field_array[9];
    $eagle_booking_form_zip = $eagle_booking_custom_field_array[10];
    $eagle_booking_form_city = $eagle_booking_custom_field_array[11];
    $eagle_booking_form_country = $eagle_booking_custom_field_array[12];
    $eagle_booking_form_services = $eagle_booking_custom_field_array[13];
    $eagle_booking_form_requests = $eagle_booking_custom_field_array[14];
    $eagle_booking_form_arrival = $eagle_booking_custom_field_array[15];
    $eagle_booking_form_coupon = $eagle_booking_custom_field_array[16];
    $eagle_booking_form_final_price = $eagle_booking_custom_field_array[17];

    $eb_room_price = $eagle_booking_custom_field_array[18];

		// PAYMENT COMPLETED
		$eagle_booking_payment_completed = true;

  } else {

		$eagle_booking_payment_completed = false;

	}

endif;
