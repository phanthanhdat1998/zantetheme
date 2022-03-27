<?php if ( eb_get_option('eagle_booking_payment_method')['vivawallet'] ) : ?>

  <div id="eagle_booking_checkout_payment_vivawallet_tab">

    <?php if ( eb_get_option('vivawallet_message') ) : ?>
      <p class="checkout-mssg"><?php echo do_shortcode( eb_get_option('vivawallet_message') ) ?></p>
    <?php endif ?>

    <?php

    $client_id = eb_get_option('vivawallet_public_key');
    $client_secret = eb_get_option('vivawallet_secret_key');
    $source_code = eb_get_option('vivawallet_source_code');
    $demo_mode = eb_get_option('vivawallet_demo_mode');

    if ( $demo_mode == true ) {

      $token_api = "https://demo-accounts.vivapayments.com/connect/token";
      $order_api = "https://demo-api.vivapayments.com/checkout/v2/orders";
      $button_action = "https://demo.vivapayments.com/web2?ref=";

    } else {


      $token_api = "https://api.vivapayments.com/connect/token";
      $order_api = "https://api.vivapayments.com/checkout/v2/orders";
      $button_action = "https://vivapayments.com/web2?ref=";

    }

    $credentials = $client_id.':'.$client_secret;

    $token_curl = curl_init();

    curl_setopt_array( $token_curl, array(
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

  $response = curl_exec($token_curl);
  $response = json_decode($response, true);
  $access_token = $response['access_token'];

  curl_close($token_curl);

  $amount = $eagle_booking_deposit_amount * 100;
  $booking_info = $eagle_booking_form_date_from.'[eb]'.$eagle_booking_form_date_to.'[eb]'.$eagle_booking_form_guests.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_name.'[eb]'.$eagle_booking_form_surname.'[eb]'.$eagle_booking_form_email.'[eb]'.$eagle_booking_form_phone.'[eb]'.$eagle_booking_form_address.'[eb]'.$eagle_booking_form_zip.'[eb]'.$eagle_booking_form_city.'[eb]'.$eagle_booking_form_country.'[eb]'.$eagle_booking_form_services.'[eb]'.$eagle_booking_form_requests.'[eb]'.$eagle_booking_form_arrival.'[eb]'.$eagle_booking_form_coupon.'[eb]'.$eagle_booking_form_final_price.'[eb]'.$eb_room_price.'[eb]'.$eagle_booking_room_id;

  $order_curl = curl_init();

  curl_setopt_array($order_curl, array(
    CURLOPT_URL => $order_api,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
      "amount": '.$amount.',
      "customerTrns": "'.$eagle_booking_room_title.'",
      "customer": {
        "email": "'.$eagle_booking_form_email.'",
        "fullName": "'.$eagle_booking_form_name.' '.$eagle_booking_form_surname.'",
        "phone": "'.$eagle_booking_form_phone.'",
        "countryCode": "",
        "requestLang": ""
      },
      "paymentTimeout": 0,
      "preauth": true,
      "allowRecurring": true,
      "maxInstallments": 0,
      "paymentNotification": true,
      "tipAmount": 0,
      "disableExactAmount": false,
      "disableCash": false,
      "disableWallet": false,
      "sourceCode": "'.$source_code.'",
      "merchantTrns": "'.$booking_info.'",

      }',
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $access_token",
      "Content-Type: application/json"
    ),
  ));

  $response = curl_exec($order_curl);
  $response = json_decode($response, true);
  $order_code = $response['orderCode'];

  curl_close($order_curl);

  ?>

  <a href="<?php echo $button_action.''.$order_code ?>" target="_blank" class="btn eb-btn btn-vivawallet"><?php echo __('Checkout Now', 'eagle-booking') ?></a>

  </div>
<?php endif ?>
