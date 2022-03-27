<?php

defined('ABSPATH') || exit;

/**
 * Include payment tabs - Sorting
*/

$eb_payment_methods = eb_get_option('eagle_booking_payment_method');

foreach ($eb_payment_methods as $eb_payment_method=>$value) {
  switch($eb_payment_method) {

    case 'paypal': include_once 'paypal/tab.php';
    break;
    case 'stripe': include_once 'stripe/tab.php';
    break;
    case '2checkout': include_once '2checkout/tab.php';
    break;
    case 'payu': include_once 'payu/tab.php';
    break;
    case 'paystack': include_once 'paystack/tab.php';
    break;
    case 'flutterwave': include_once 'flutterwave/tab.php';
    break;
    case 'razorpay': include_once 'razorpay/tab.php';
    break;
    case 'vivawallet': include_once 'vivawallet/tab.php';
    break;
    case 'bank': include_once 'bank/tab.php';
    break;
    case 'arrive': include_once 'arrive/tab.php';
    break;
    case 'request': include_once 'request/tab.php';
    break;

  }
}
