<?php

defined('ABSPATH') || exit;

/**
 * Include payment content - Sorting
*/

$eb_payment_methods = eb_get_option('eagle_booking_payment_method');

foreach ($eb_payment_methods as $eb_payment_method=>$value) {
  switch($eb_payment_method) {

    case 'paypal': include_once 'paypal/tab-content.php';
    break;
    case 'stripe': include_once 'stripe/tab-content.php';
    break;
    case '2checkout': include_once '2checkout/tab-content.php';
    break;
    case 'payu': include_once 'payu/tab-content.php';
    break;
    case 'paystack': include_once 'paystack/tab-content.php';
    break;
    case 'flutterwave': include_once 'flutterwave/tab-content.php';
    break;
    case 'razorpay': include_once 'razorpay/tab-content.php';
    break;
    case 'vivawallet': include_once 'vivawallet/tab-content.php';
    break;
    case 'bank': include_once 'bank/tab-content.php';
    break;
    case 'arrive': include_once 'arrive/tab-content.php';
    break;
    case 'request': include_once 'request/tab-content.php';
    break;

  }
}
