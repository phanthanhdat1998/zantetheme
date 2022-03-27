<?php
/*
 * Package: Core / PayU Payment Gateway
 * Author:  Eagle Themes (Jomin Muskaj)
 * Version 1.0.0
 */

defined('ABSPATH') || exit;

if (isset($_POST ['key'])) :

    // PayU
    $eb_payu_merchant_key		  = eb_get_option('eb_payu_merchant_key');
    $eb_payu_merchant_salt		  = eb_get_option('eb_payu_merchant_salt');
    $eb_payu_transaction_id 	  = $_POST['txnid'];
    $eagle_booking_deposit_amount = $_POST['amount'];
    $eagle_booking_room_title  	  = $_POST['productinfo'];
    $eagle_booking_form_name      = $_POST['firstname'];
    $eagle_booking_form_email     = $_POST['email'];
    $mihpayid			          = $_POST['mihpayid'];
    $status			              = $_POST['status'];
    $resphash			          = $_POST['hash'];

    // Get custom parameters
    $eb_payu_udf5 = $_POST['udf5'];

    // Explode parameters
    $eb_custom_field_array = explode('[eb]', $eb_payu_udf5);
	$eagle_booking_room_id = $eb_custom_field_array[0];
    $eagle_booking_form_date_from = $eb_custom_field_array[1];
    $eagle_booking_form_date_to = $eb_custom_field_array[2];
    $eagle_booking_form_guests = $eb_custom_field_array[3];
    $eagle_booking_form_adults = $eb_custom_field_array[4];
    $eagle_booking_form_children = $eb_custom_field_array[5];
    $eagle_booking_form_name = $eb_custom_field_array[6];
    $eagle_booking_form_surname = $eb_custom_field_array[7];
    $eagle_booking_form_email = $eb_custom_field_array[8];
    $eagle_booking_form_phone = $eb_custom_field_array[9];
    $eagle_booking_form_address = $eb_custom_field_array[10];
    $eagle_booking_form_zip = $eb_custom_field_array[11];
    $eagle_booking_form_city = $eb_custom_field_array[12];
    $eagle_booking_form_country = $eb_custom_field_array[13];
    $eagle_booking_form_services = $eb_custom_field_array[14];
    $eagle_booking_form_requests = $eb_custom_field_array[15];
    $eagle_booking_form_arrival = $eb_custom_field_array[16];
    $eagle_booking_form_coupon = $eb_custom_field_array[17];
    $eagle_booking_form_final_price = $eb_custom_field_array[18];

    // Defaults
	$eagle_booking_form_currency = eb_currency();
	$eagle_booking_date = date('H:m:s F j Y');
	$eagle_booking_form_payment_status = 'Completed';
	$eagle_booking_transaction_id = $eb_payu_transaction_id;
	$eagle_booking_form_action_type = 'PayU';

    // Calculate response hash to verify
    $keyString 	  		=  	$eb_payu_merchant_key.'|'.$eb_payu_transaction_id.'|'.$eagle_booking_deposit_amount.'|'.$eagle_booking_room_title.'|'.$eagle_booking_form_name.'|'.$eagle_booking_form_email.'|||||'.$eb_payu_udf5.'|||||';
    $keyArray 	  		= 	explode("|",$keyString);
    $reverseKeyArray 	= 	array_reverse($keyArray);
    $reverseKeyString	=	implode("|",$reverseKeyArray);
    $CalcHashString 	= 	strtolower(hash('sha512', $eb_payu_merchant_salt.'|'.$status.'|'.$reverseKeyString));


    if ($status == 'success'  && $resphash == $CalcHashString) {

        $eagle_booking_payment_completed = true;
    }

    else {

        $eagle_booking_payment_completed = false;

    }

endif;
