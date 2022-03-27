<?php

/* --------------------------------------------------------------------------
 * Eagle Booking Manage Booking [Admin]
 * @since  1.2.8
 * @author Jomin Muskaj
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

class EB_ADMIN_BOOKING {

  public function __construct() {

      // Add Javascript and CSS back-end
      add_action('admin_enqueue_scripts', array($this,'enqueue'));

      // Add ajax function that will receive the call back for logged in users
      add_action( 'wp_ajax_admin_availability', array( $this, 'availability') );
      add_action( 'wp_ajax_admin_create', array( $this, 'create') );
      add_action( 'wp_ajax_admin_delete', array( $this, 'delete') );

  }


  /**
   * Enqueue the required scripts
   */
  public function enqueue() {

      // EnqueUE JS
      wp_enqueue_script( 'eb-admin-booking', EB_URL .'assets/js/admin/bookings.js', array( 'jquery' ), EB_VERSION, true );



      // Enqueue AJAX
      wp_localize_script( 'eb-admin-booking', 'booking_variables', array(
          'ajaxurl' => admin_url('admin-ajax.php'),
          'nonce' => wp_create_nonce('nonce')
      ));

  }

  // Check Availability
  function availability() {

    // Check if Ajax response and get Ajax variables
    if (! empty($_POST['room_id'])) {

      $nonce = sanitize_text_field( $_POST['nonce'] );
      $room_id = sanitize_text_field( $_POST['room_id'] );
      $checkin = sanitize_text_field( $_POST['checkin'] );
      $checkout = sanitize_text_field( $_POST['checkout'] );
      $room_title = get_the_title($room_id);

      // Format dates for the system
      $checkin = eagle_booking_system_date_format($checkin);
      $checkout = eagle_booking_system_date_format($checkout);

      // Check nonce
      if ( !wp_verify_nonce($nonce, 'nonce') ) {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

      // // If everything is ok then proceed to the creation
      } else {

        // Let letch check the availability
        if ( eagle_booking_is_qnt_available( eagle_booking_room_availability( $room_id, $checkin, $checkout), $checkin, $checkout, $room_id ) == 1 ) {

          $return_data['status'] = 'available';
          $return_data['heading'] =  __('Room is Available', 'eagle-booking');
          $return_data['text'] =  sprintf( __('The room %1$s is available on the requested dates. Do you want to submit the booking?', 'eagle-booking'), $room_title);

        } else {

          $return_data['status'] = 'notavailable';
          $return_data['heading'] =  __('Room is not Available', 'eagle-booking');
          $return_data['text'] =  sprintf( __('The room %1$s is not available on the requested dates.', 'eagle-booking'), $room_title);

        }

      }

    } else {

      $return_data['status'] = 'failed';
      $return_data['mssg'] = __('No ID', 'eagle-booking');
    }

    // Return all data to json
    wp_send_json( $return_data );
    wp_die();

  }

  // Create Booking
  function create() {

    // Check if Ajax response and get Ajax variables
    if (! empty($_POST['room_id'])) {

      $nonce = sanitize_text_field( $_POST['nonce'] );
      $room_id = sanitize_text_field( $_POST['room_id'] );
      $checkin = sanitize_text_field( $_POST['checkin'] );
      $checkout = sanitize_text_field( $_POST['checkout'] );
      $price = sanitize_text_field( $_POST['price'] );
      $deposit = sanitize_text_field( $_POST['deposit'] );
      $firstname = sanitize_text_field( $_POST['firstname'] );
      $lastname = sanitize_text_field( $_POST['lastname'] );
      $email = sanitize_text_field( $_POST['email'] );
      $phone = sanitize_text_field( $_POST['phone'] );
      $address = sanitize_text_field( $_POST['address'] );
      $city = sanitize_text_field( $_POST['city'] );
      $country = sanitize_text_field( $_POST['country'] );
      $zip = sanitize_text_field( $_POST['zip'] );
      $arrival = sanitize_text_field( $_POST['arrival'] );
      $services = sanitize_text_field( $_POST['services'] );
      $requests = sanitize_text_field( $_POST['requests'] );
      $status = sanitize_text_field( $_POST['status'] );
      $payment = sanitize_text_field( $_POST['payment'] );



      $room_title = get_the_title($room_id);
      $booking_date = date('H:m:s F j Y');
      $transaction_id =  rand(100000000,999999999);
      $user_id = 0;
      $user_ip = 0;
      $coupon = '';
      $currency = '$';

      // Set deposit to 0 if is not set
      if( $deposit == '' ) $deposit = 0;

      // Check guests type
      if( eb_get_option('eb_adults_children') == true ) {

        $adults = sanitize_text_field( $_POST['adults'] );
        $children = sanitize_text_field( $_POST['children'] );
        $guests = $adults + $children;

      } else {

        $adults = '';
        $children = '';
        $guests = sanitize_text_field( $_POST['guests'] );

      }

      // Format dates for the system
      $checkin = eagle_booking_system_date_format( $checkin );
      $checkout = eagle_booking_system_date_format( $checkout );

      // Check nonce
      if ( !wp_verify_nonce($nonce, 'nonce') ) {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

      // // If everything is ok then proceed to the creation
      } else {

        // Let letch check the availability
        if ( eagle_booking_is_qnt_available( eagle_booking_room_availability( $room_id, $checkin, $checkout), $checkin, $checkout, $room_id ) == 1 ) {

            // Enter the reservation into the db
            $insert_booking = eb_insert_booking_into_db(
                $room_id,
                $room_title,
                $booking_date,
                $checkin,
                $checkout,
                $guests,
                $adults,
                $children,
                $price,
                $price,
                $deposit,
                $services,
                $user_id,
                $firstname,
                $lastname,
                $email,
                $user_ip,
                $phone,
                $address.' '.$zip,
                $city,
                $country,
                $requests,
                $arrival,
                $coupon,
                $status,
                $currency,
                $transaction_id,
                $payment
            );

            // Get the last ID
            global $eb_booking_id;

            // if success redirect to edit booking page
            if ( $insert_booking == true ) {

              $return_data['status'] = 'success';
              $return_data['mssg'] =  'Booking Created Successfully';
              $return_data['redirect_url'] = 'admin.php?page=eb_edit_booking&id='.$eb_booking_id;

            } else {

              $return_data['mssg'] =  'Something went wrong';

            }

        } else {

          $return_data['status'] = 'success';
          $return_data['class'] =  'eb-not-available';

        }

      }

    } else {

      $return_data['status'] = 'failed';
      $return_data['mssg'] = __('No ID', 'eagle-booking');

    }

    // Return all data to json
    wp_send_json( $return_data );

    // wp_die();

  }

  // Delete Booking
  function delete() {

    // Check if Ajax response and get Ajax variables
    if (! empty($_POST['booking_id'])) {

      $booking_id = sanitize_text_field( $_POST['booking_id'] ) ;
      $nonce = sanitize_text_field( $_POST['nonce'] );

      // Check nonce
      if ( !wp_verify_nonce($nonce, 'nonce') ) {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

      // // If everything is ok let's proceed to the deletion
      } else {

        global $wpdb;

        $delete_qry = $wpdb->delete( EAGLE_BOOKING_TABLE, array( 'ID' => $booking_id ) );

        if ( $delete_qry == true ) {

            $return_data['status'] = 'success';
            $return_data['mssg'] = __('Booking Deleted Successfully', 'eagle-booking');
            $return_data['redirect_url'] = 'admin.php?page=eb_bookings';



        } else {

            $return_data['status'] = 'success';
            $return_data['mssg'] = __('Oops Something Went Wrong', 'eagle-booking');

        }

      }

    } else {

      $return_data['status'] = 'failed';
      $return_data['mssg'] = __('No ID', 'eagle-booking');

    }

    // Return all data to json
    wp_send_json($return_data);
    wp_die();

  }

}

global $plugin;

$plugin = new EB_ADMIN_BOOKING();
