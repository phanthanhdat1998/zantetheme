<?php
/* --------------------------------------------------------------------------
 * Checkout Page Shortcode
 * Author: Eagle Themes
 * Package: Eagle-Booking/Core
 * Since:  1.0.0
 * Modified: 1.2.7
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_checkout_shortcode() {

  ob_start();

    // Get checkout page
    if( isset( $_POST['eb_arrive'] ) ) {
      $eagle_booking_arrive = $_POST['eb_arrive'];
    } else {
      $eagle_booking_arrive = '';
    }
    // Get payment method
    if( isset( $_POST['eagle_booking_payment_method'] ) ) {
      $eagle_booking_payment_method = $_POST['eagle_booking_payment_method'];
    } else {
      $eagle_booking_payment_method = '';
    }

    // Payment Details
    if ( $eagle_booking_arrive == 1 ) {

        // Get the the form values from booking page
        $eb_booking_price = sanitize_text_field( $_POST['eb_booking_price'] );
        $eb_room_price = sanitize_text_field( $_POST['eb_room_price'] );

        $eagle_booking_form_date_from = sanitize_text_field( $_POST['eb_date_from'] );
        $eagle_booking_form_date_to = sanitize_text_field( $_POST['eb_date_to'] );
        $eagle_booking_form_guests = sanitize_text_field( $_POST['eb_guests'] );
        $eagle_booking_form_adults = sanitize_text_field( $_POST['eb_adults'] );
        $eagle_booking_form_children = sanitize_text_field( $_POST['eb_children'] );
        $eagle_booking_form_name = sanitize_text_field( $_POST['eb_user_firstname'] );
        $eagle_booking_form_surname = sanitize_text_field( $_POST['eb_user_lastname'] );
        $eagle_booking_form_email = sanitize_text_field( $_POST['eb_user_email'] );
        $eagle_booking_form_phone = sanitize_text_field( $_POST['eb_user_phone'] );
        $eagle_booking_room_id = sanitize_text_field( $_POST['eb_room_id'] );
        $eagle_booking_room_title = sanitize_text_field( $_POST['eb_room_title'] );
        $eagle_booking_form_services = sanitize_text_field( $_POST['eb_additional_services_id'] );

        // Optional Fields
        if( isset( $_POST['eb_user_address'] ) ) {
          $eagle_booking_form_address = sanitize_text_field( $_POST['eb_user_address'] );
        } else {
            $eagle_booking_form_address = '';
        }
        if( isset( $_POST['eb_user_city'] ) ) {
          $eagle_booking_form_city = sanitize_text_field( $_POST['eb_user_city'] );
        } else {
            $eagle_booking_form_city = '';
        }
        if( isset( $_POST['eb_user_country'] ) ) {
          $eagle_booking_form_country = sanitize_text_field( $_POST['eb_user_country'] );
        } else {
            $eagle_booking_form_country = '';
        }
        if( isset( $_POST['eb_user_zip'] ) ) {
          $eagle_booking_form_zip = sanitize_text_field( $_POST['eb_user_zip'] );
        } else {
            $eagle_booking_form_zip = '';
        }
        if( isset( $_POST['eb_user_requests'] ) ) {
            $eagle_booking_form_requests = sanitize_text_field( $_POST['eb_user_requests'] );
        } else {
            $eagle_booking_form_requests = '';
        }
        if( isset( $_POST['eb_user_arrival'] ) ) {
            $eagle_booking_form_arrival = sanitize_text_field( $_POST['eb_user_arrival'] );
        } else {
            $eagle_booking_form_arrival = '';
        }

        // Coupon
        if( isset( $_POST['eb_coupon_code'] ) ) {
            $eagle_booking_form_coupon = sanitize_text_field( $_POST['eb_coupon_code'] );

        } else {
            $eagle_booking_form_coupon = '';
        }

        $eagle_booking_form_final_price = $eb_booking_price;

        /**
        * Deposit Amount
        */
        $eagle_booking_deposit_amount = $eagle_booking_form_final_price * eb_get_option('eagle_booking_deposit_amount') / 100;

        /**
        * Include booking details
        */
        include eb_load_template('checkout/details.php');

        // Check if exist any booking with the same details
        if (eb_booking_exist($eagle_booking_room_id, $eagle_booking_form_date_from, $eagle_booking_form_date_to, $eagle_booking_form_email) == true ) {

          eb_notice( 'error', __('Booking with these details already exists.','eagle-booking') );

        // Check if room is available
        } elseif ( eagle_booking_is_qnt_available(eagle_booking_room_availability($eagle_booking_room_id, $eagle_booking_form_date_from, $eagle_booking_form_date_to), $eagle_booking_form_date_from, $eagle_booking_form_date_to, $eagle_booking_room_id) == 0 ) {

          eb_notice( 'error', __('The room is not available.','eagle-booking') );

        } else {

          /**
          * Include payment details
          */
          include eb_load_template('checkout/payment.php');

        }

    // Details Page (After the payment)
  } elseif ( $eagle_booking_payment_method == 'bank' OR isset($_GET['tx']) OR isset($_GET['order_id']) OR isset($_POST['tx_ref']) OR isset( $_POST['razorpay_payment_id'] ) OR $eagle_booking_payment_method == 'stripe' OR isset($_GET['sid']) OR isset($_POST['paystack_reference']) OR isset($_POST['key']) OR $eagle_booking_payment_method == 'payment_on_arrive' OR $eagle_booking_payment_method == 'booking_request' ) {

          // Get payment method
          foreach ( glob ( EB_PATH . 'core/admin/gateways/*/payment.php' ) as $file ){
            include_once $file;
          }

          /**
          * Include additional services
          */
          include eb_load_template('checkout/additional-services.php');

          // Get the payment method text
          if( $eagle_booking_form_action_type === 'payment_on_arrive' ) {

            $eagle_booking_checkout_payment_type = __('Payment on Arrival', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === '2checkout') {

            $eagle_booking_checkout_payment_type = __('2Checkout', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'bank_transfer') {

            $eagle_booking_checkout_payment_type = __('Bank Transfer', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'PayU') {

            $eagle_booking_checkout_payment_type = __('PayU', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'paystack') {

            $eagle_booking_checkout_payment_type = __('Paystack', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'flutterwave') {

            $eagle_booking_checkout_payment_type = __('Flutterwave', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'razorpay') {

            $eagle_booking_checkout_payment_type = __('Razorpay', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'booking_request') {

            $eagle_booking_checkout_payment_type = __('Booking Request', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'stripe') {

            $eagle_booking_checkout_payment_type = __('Stripe', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'paypal') {

            $eagle_booking_checkout_payment_type = __('PayPal', 'eagle-booking');

          } elseif ($eagle_booking_form_action_type === 'vivawallet') {

            $eagle_booking_checkout_payment_type = __('Viva Wallet', 'eagle-booking');

          }

          // Check if room is still available
          if ( eagle_booking_is_qnt_available( eagle_booking_room_availability($eagle_booking_room_id, $eagle_booking_form_date_from, $eagle_booking_form_date_to), $eagle_booking_form_date_from, $eagle_booking_form_date_to, $eagle_booking_room_id) == 1 ) {

          // User Details
          $eb_user_id = get_current_user_id();
          $eb_user_ip = eb_user_ip();

          if ($eb_user_id == '') {
            $eb_user_id = 0;
          }

          // Translated Rooms - Check if the room is a translated room and if so override the room id with the default one
          $eb_default_room = get_post_meta( $eagle_booking_room_id, 'eagle_booking_mtb_room_default_room_id', true );
          if ( $eb_default_room != '' ) $eagle_booking_room_id = $eb_default_room;

          // Check if payment has been completed
          if ($eagle_booking_payment_completed == true) {

            // Insert the booking into the DB
            $eb_insert_booking_in_db = eb_insert_booking_into_db (
              $eagle_booking_room_id,
              $eagle_booking_room_title,
              $eagle_booking_date,
              $eagle_booking_form_date_from,
              $eagle_booking_form_date_to,
              $eagle_booking_form_guests,
              $eagle_booking_form_adults,
              $eagle_booking_form_children,
              $eb_room_price,
              $eagle_booking_form_final_price,
              $eagle_booking_deposit_amount,
              $eagle_booking_form_extra_services,
              $eb_user_id,
              $eagle_booking_form_name,
              $eagle_booking_form_surname,
              $eagle_booking_form_email,
              $eb_user_ip,
              $eagle_booking_form_phone,
              $eagle_booking_form_address.' '.$eagle_booking_form_zip,
              $eagle_booking_form_city,
              $eagle_booking_form_country,
              $eagle_booking_form_requests,
              $eagle_booking_form_arrival,
              $eagle_booking_form_coupon,
              $eagle_booking_form_payment_status,
              $eagle_booking_form_currency,
              $eagle_booking_transaction_id,
              $eagle_booking_form_action_type

          );

        // Check if booking has been added successfull in the DB
        if ($eb_insert_booking_in_db == true) {

          // Get Dates
          $eagle_booking_checkin_original = DateTime::createFromFormat('m/d/Y', $eagle_booking_form_date_from);
          $eagle_booking_checkout_original = DateTime::createFromFormat('m/d/Y', $eagle_booking_form_date_to);

          /**
          * Include thank you
          */
          include eb_load_template('checkout/thankyou.php');

        } else {

          eb_notice( 'error', __('There was an unexpected error with your booking, please get in touch with us using our','eagle-booking'). ' <a href="'.eagle_booking_contact_page().'">' .__('contact form', 'eagle-booking').' '. '</a>' .__('for more details.', 'eagle-booking') );

        }

    } else {

      eb_notice( 'error', __('Payment failed, please get in touch with us using our','eagle-booking').' '. ' <a href="'.eagle_booking_contact_page().'">' .__('contact form', 'eagle-booking').' '. '</a>' .__('for more details.', 'eagle-booking') );

    }

  } else {

    eb_notice( 'error', __('The room is not available.','eagle-booking') );

  }


  } else {

    eb_notice( 'error', __('Booking with these details already exists.','eagle-booking') );

  }

  return ob_get_clean();

}

// Depracated Shortcode (Will be removed soon)
add_shortcode('eagle_booking_checkout', 'eb_checkout_shortcode');

// Checkout Page Shortcode
add_shortcode('eb_checkout', 'eb_checkout_shortcode');
