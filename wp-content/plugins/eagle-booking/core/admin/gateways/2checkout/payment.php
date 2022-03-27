<?php
/*
 * 2Checkout Payment Gateway
 * Author  Eagle Themes (Jomin Muskaj)
 * Package Eagle Booking
 * Version 1.0.0
 */

defined('ABSPATH') || exit;

if ( isset($_GET['sid']) ) :

    // Data
    $eagle_booking_form_date_from = $_GET['eagle_booking_checkout_form_date_from'];
    $eagle_booking_form_date_to = $_GET['eagle_booking_checkout_form_date_to'];
    $eagle_booking_form_guests = $_GET['eagle_booking_checkout_form_guests'];
    $eagle_booking_form_adults = $_GET['eagle_booking_checkout_form_adults'];
    $eagle_booking_form_children = $_GET['eagle_booking_checkout_form_children'];

    $eb_room_price = $_GET['eb_room_price'];

    $eagle_booking_form_final_price = $_GET['eagle_booking_checkout_form_final_price'];
    $eagle_booking_deposit_amount = $_GET['eagle_booking_deposit_amount'];
    $eagle_booking_room_id = $_GET['eagle_booking_room_id'];
    $eagle_booking_room_title = $_GET['eagle_booking_room_title'];
    $eagle_booking_form_name = $_GET['eagle_booking_checkout_form_name'];
    $eagle_booking_form_surname = $_GET['eagle_booking_checkout_form_surname'];
    $eagle_booking_form_email = $_GET['eagle_booking_checkout_form_email'];
    $eagle_booking_form_phone = $_GET['eagle_booking_checkout_form_phone'];
    $eagle_booking_form_address = $_GET['eagle_booking_checkout_form_address'];
    $eagle_booking_form_city = $_GET['eagle_booking_checkout_form_city'];
    $eagle_booking_form_country = $_GET['eagle_booking_checkout_form_country'];
    $eagle_booking_form_zip = $_GET['eagle_booking_checkout_form_zip'];
    $eagle_booking_form_requests = $_GET['eagle_booking_checkout_form_requets'];
    $eagle_booking_form_arrival = $_GET['eagle_booking_checkout_form_arrival'];
    $eagle_booking_form_coupon = $_GET['eagle_booking_form_coupon'];
    $eagle_booking_form_services = $_GET['eagle_booking_form_services'];
    $eagle_booking_form_action_type = $_GET['eagle_booking_form_action_type'];
    $eagle_booking_form_payment_status = $_GET['eagle_booking_form_payment_status'];


    // Defaults
    $eagle_booking_form_currency = eb_currency();
    $eagle_booking_date = date('H:m:s F j Y');

    $hashSecretWord = eb_get_option('eagle_booking_2checkout_secret_word'); // 2Checkout Secret Word
    $hashSid = eb_get_option('eagle_booking_2checkout_account_number'); // 2Checkout account number

    // 2Ceckout Mode
    if ($_REQUEST['demo'] == 'Y') {
        $order_number = 1;
    } else {
        $order_number = $_REQUEST['order_number'];
    }

    // Transaction ID
    $eagle_booking_transaction_id = $order_number;

    // Status
    $compare_string = $hashSecretWord . $hashSid . $order_number . $_REQUEST['total'];
    $compare_hash1 = strtoupper(md5($compare_string));
    $compare_hash2 = $_REQUEST['key'];

    if ($compare_hash1 == $compare_hash2) {

        $eagle_booking_form_payment_status = 'Completed';
        $eagle_booking_payment_completed = true;

    } else {

        $eagle_booking_payment_completed = false;

    }

endif;
