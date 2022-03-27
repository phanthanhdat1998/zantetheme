<?php
/*
 * Viva Wallet Payment Gateway
 * Author  Eagle Themes (Jomin Muskaj)
 * Package Eagle Booking
 * Version 1.0.0
 */

defined('ABSPATH') || exit;

if ( isset($_GET['order_id']) && isset( $_GET['t'] ) ) :

   $order_id = $_GET['order_id'];
   $transaction_id = $_GET['t'];

	$client_id = eb_get_option('vivawallet_public_key');
	$client_secret = eb_get_option('vivawallet_secret_key');
	$demo_mode = eb_get_option('vivawallet_demo_mode');

	if ( $demo_mode == true ) {

		$token_api = "https://demo-accounts.vivapayments.com/connect/token";
		$transaction_api = "https://demo-api.vivapayments.com/checkout/v2/transactions/";
		$button_action = "https://demo.vivapayments.com/web2?ref=";

    } else {

		$token_api = "https://api.vivapayments.com/connect/token";
		$transaction_api = "https://api.vivapayments.com/checkout/v2/transactions/";
		$button_action = "https://vivapayments.com/web2?ref=";
    }

	$credentials = $client_id.':'.$client_secret;

	$curl = curl_init();
	curl_setopt_array( $curl, array(

		CURLOPT_URL => $token_api,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => false,
		CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERPWD => $credentials,

		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/x-www-form-urlencoded'
		),

		CURLOPT_POSTFIELDS => "grant_type=client_credentials"

	)

	);

	$response = curl_exec($curl);
	$response = json_decode($response, true);
	$access_token = $response['access_token'];


	curl_close($curl);

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $transaction_api.''.$transaction_id.'/',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer $access_token"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$response = json_decode($response, true);
	$booking_details = $response['merchantTrns'];

	if( $response['statusId'] == 'F' ){

		$eagle_booking_room_title = $response['customerTrns'];
		$eagle_booking_form_action_type = 'vivawallet';
		$eagle_booking_deposit_amount = $response['amount'];

		$eb_field_array = explode('[eb]', $booking_details);
		$eagle_booking_form_date_from = $eb_field_array[0];
		$eagle_booking_form_date_to = $eb_field_array[1];
		$eagle_booking_form_guests = $eb_field_array[2];
		$eagle_booking_form_adults = $eb_field_array[3];
		$eagle_booking_form_children = $eb_field_array[4];
		$eagle_booking_form_name = $eb_field_array[5];
		$eagle_booking_form_surname = $eb_field_array[6];
		$eagle_booking_form_email = $eb_field_array[7];
		$eagle_booking_form_phone = $eb_field_array[8];
		$eagle_booking_form_address = $eb_field_array[9];
		$eagle_booking_form_zip = $eb_field_array[10];
		$eagle_booking_form_city = $eb_field_array[11];
		$eagle_booking_form_country = $eb_field_array[12];
		$eagle_booking_form_services = $eb_field_array[13];
		$eagle_booking_form_requests = $eb_field_array[14];
		$eagle_booking_form_arrival = $eb_field_array[15];
		$eagle_booking_form_coupon = $eb_field_array[16];
		$eagle_booking_form_final_price = $eb_field_array[17];
		$eb_room_price = $eb_field_array[18];
		$eagle_booking_room_id = $eb_field_array[19];

		$eagle_booking_payment_completed = true;
		$eagle_booking_form_currency = eb_currency();
		$eagle_booking_date = date('H:m:s F j Y');
		$eagle_booking_form_payment_status = 'Completed';
		$eagle_booking_transaction_id = $response['orderCode'];

	} else {

		$eagle_booking_payment_completed = false;
	}


endif;
