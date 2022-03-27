<?php
/* --------------------------------------------------------------------------
 * Booking Page Shortcode
 * @since  1.0.0
 * modified 1.2.5
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eagle_booking_shortcode_booking() {

  ob_start();

    /**
    * Include Stepline
    */
    if ( eb_get_option('eb_stepline' ) == true ) include eb_load_template('elements/stepline.php');

    // Check if rooms has been selected
    if( isset( $_POST['submit'] ) ) {

      if( isset( $_POST['eb_single_room'] ) ) {
        $eb_arrive_from_single_room = $_POST['eb_single_room'];
      } else {
        $eb_arrive_from_single_room = 0;
      }

      // ARRIVE FROM SINGLE ROOM
      if ( $eb_arrive_from_single_room == 1 ) {

        // PARAMETERS
        $eb_room_id = $_POST['eb_room_id'];
        $eb_checkin = $_POST['eagle_booking_checkin'];
        $eb_checkout = $_POST['eagle_booking_checkout'];

        // Guests
        if ( eb_get_option('eb_adults_children') == true ) {
          $eb_adults = $_POST['eagle_booking_adults'];
          $eb_children = $_POST['eagle_booking_children'];
          $eb_guests = $eb_adults + $eb_children;

        } else {
          $eb_adults = '';
          $eb_children = '';
          $eb_guests = $_POST['eagle_booking_guests'];
        }


      // ARRIVE FROM SEARCH PAGE
      } else {

        // GET DATA
        $eb_room_id= $_POST['eb_room_id'];
        $eb_checkin = $_POST['eb_checkin'];
        $eb_checkout = $_POST['eb_checkout'];
        $eb_guests = $_POST['eb_guests'];
        $eb_adults = $_POST['eb_adults'];
        $eb_children = $_POST['eb_children'];
      }

      // IF ROOM IS AVAILABLE
      if ( eb_room_is_available_block($eb_room_id, $eb_checkin, $eb_checkout) && eagle_booking_is_qnt_available( eagle_booking_room_availability($eb_room_id, $eb_checkin, $eb_checkout), $eb_checkin, $eb_checkout, $eb_room_id) == 1  ) {

        /**
        * Check min & max booking night
        */
        $eb_booking_nights = eb_total_booking_nights($eb_checkin, $eb_checkout);
        $eb_min_booking_nights = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_min_booking_nights', true );
        $eb_max_booking_nights = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_max_booking_nights', true );

        if ( empty($eb_min_booking_nights) ) $eb_min_booking_nights = 1;
        if ( empty($eb_max_booking_nights) ) $eb_max_booking_nights = 1000;

        if ( $eb_booking_nights >= $eb_min_booking_nights && $eb_booking_nights <= $eb_max_booking_nights ) {


            /**
            * Price ( include it as a external function )
            */

            // Move it to eb_room_total function and retrunr the room total price
            $eb_trip_price = 0;
            $eagle_booking_index = 1;
            $eagle_booking_date_cicle = $eb_checkin;


            // Sart Cecking price
            while ($eagle_booking_index <= eb_total_booking_nights($eb_checkin, $eb_checkout)) {

            /**
            * Calculate the booking price based on room price type
            */
            $eb_room_price_type = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_price_type', true);

            // Charge based on room price x booking nights x guests number
            if ($eb_room_price_type === 'room_price_nights_guests') {

                // Adults & children option is enabled
                if ( eb_get_option('eb_adults_children') == true ) {

                    // Calculate the total price
                    $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle) * ($eb_adults + $eb_children);

                } else {

                     // Calculate the total price
                    $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle) * $eb_guests;
                }

            // Charge bades on guests or adults & children price
            } elseif ($eb_room_price_type === 'room_price_nights_guests_custom') {

                // Adults & children option is enabled
                if (eb_get_option('eb_adults_children') == true) {

                    $eb_adults_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_adult_price', true) ?: 0;
                    $eb_adults_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_adults_price_start', true) ?: 0;
                    $eb_children_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_children_price', true) ?: 0;
                    $eb_children_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_children_price_start', true) ?: 0;

                    // Adults total custom price
                    if ($eb_adults < $eb_adults_price_start) {
                        $eb_adults_price_total = 0;
                    } else {
                        $eb_adults_price_total = $eb_adults_price * ($eb_adults - $eb_adults_price_start);
                    }

                    // Children total custom price
                    if ($eb_children < $eb_children_price_start) {
                        $eb_children_price_total = 0;
                    } else {
                        $eb_children_price_total = $eb_children_price * ( $eb_children - $eb_children_price_start );
                    }

                    // Calculate the total price
                     $eb_trip_price = ($eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle)) + ($eb_adults_price_total) + ($eb_children_price_total);

                } else {

                    $eb_guests_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_guests_price', true) ?: 0;
                    $eb_guests_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_guests_price_start', true) ?: 0;

                    // Guests total custom price
                    if ($eb_guests < $eb_guests_price_start) {
                        $eb_guests_price_total = 0;
                    } else {
                        $eb_guests_price_total = $eb_guests_price * ($eb_guests - $eb_guests_price_start);
                    }

                    // Calculate the total price
                    $eb_trip_price = ($eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle)) + ($eb_guests_price_total);
                }

            // Charge based on room price x booking nights
            } else {

              // Calculate the total price
                $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle);
            }

            // Room Total Price Excluding Taxes, Fees and Additional Services
            $eb_room_total_price = $eb_trip_price;
            $eagle_booking_date_cicle = date('Y/m/d', strtotime( $eagle_booking_date_cicle.' + 1 days' ));
            $eagle_booking_index++;

           }

            ?>

            <div class="eb-g-6-2 eb-g-m-1-1 eb-g-c-g-40 eb-sticky-sidebar-container">
                <div>
                <?php

                  /**
                  * Include notification mssg
                  */
                  include eb_load_template('booking/notification-mssg.php');

                  /**
                  * Include additional services
                  */
                  include eb_load_template('booking/additional-services.php');

                  /**
                  * Include booking form
                  */
                  include eb_load_template('booking/form.php'); ?>
                </div>
                <div>
                <?php
                  /**
                  * Include booking details
                  */
                  include eb_load_template('booking/details.php'); ?>
                </div>
            </div>

        <?php

        } elseif ( $eb_booking_nights > $eb_max_booking_nights ) {

          eb_notice( 'error', __('Max. Booking Nights', 'eagle-booking').' '.$eb_max_booking_nights.' <a href="'.eb_search_page().'">'.__('Return to search page','eagle-booking').'</a>' );

        } elseif (  $eb_booking_nights <= $eb_min_booking_nights ) {

          eb_notice( 'error', __('Min. Booking Nights', 'eagle-booking').' '.$eb_min_booking_nights.' <a href="'.eb_search_page().'">'.__('Return to search page','eagle-booking').'</a>' );

        }

      } else {

        eb_notice( 'error', __('The room is not available.','eagle-booking').' <a href="'.eb_search_page().'">'.__('Return to search page','eagle-booking').'</a>' );

      }

    } else {

      eb_notice( 'error', __('Please select a room to make a reservation.','eagle-booking').' <a href="'.eb_search_page().'">'.__('Return to search page','eagle-booking').'</a>' );

  }

  /**
  * Enqueue Booking Page JS & AJAX
  */
  wp_enqueue_script( 'eb-checkout', EB_URL .'assets/js/checkout.js', array( 'jquery' ), EB_VERSION, true );
  wp_localize_script(

    'eb-checkout', 'eb_checkout',

    array(
        'eb_user_sign_in_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_user_sign_up_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_user_sign_out_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_coupon_code_ajax' => admin_url( 'admin-ajax.php' ),

        // Used for static Ajax requests
        'eb_ajax_nonce' => wp_create_nonce( 'eb_nonce' ),
    )

  );

  // Clean Buffer
  return ob_get_clean();

}

// Depracated Shortcode (Will be removed soon)
add_shortcode('eagle_booking_booking', 'eagle_booking_shortcode_booking');

// Booking Page Shortcode
add_shortcode('eb_booking', 'eagle_booking_shortcode_booking');
