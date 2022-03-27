<?php
/* --------------------------------------------------------------------------
 * Eagle Booking / Calendar Availability
 * Author: Eagle Themes (Jomin Muskaj)
 * Since: 1.1.5
 * Modified: 1.2.4
---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_room_availability_calendar($eb_room_id, $eb_checkin, $eb_checkout) {

    global $wpdb;

    // Translated Rooms - Check if the room is a translated room and if so override the room id with the default one
    $eb_default_room = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_default_room_id', true );
    if ( $eb_default_room != '' ) $eb_room_id = $eb_default_room;

    // Get Room Exceptions
    $eagle_booking_exceptions_array = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_block_exceptions', true);

    // Room Quantity
    $eagle_booking_meta_box_qnt = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_quantity', true);
    if (empty($eagle_booking_meta_box_qnt)) {
        $eagle_booking_meta_box_qnt = 1;
    }

    // Set the check circle
    $eagle_booking_check_start_date_format = DateTime::createFromFormat("Y/m/d", $eb_checkin)->format('m/d/Y');
    $eagle_booking_check_end_date_format = DateTime::createFromFormat("Y/m/d", $eb_checkout)->format('m/d/Y');
    $eagle_booking_check_circle = eb_total_booking_nights($eagle_booking_check_start_date_format, $eagle_booking_check_end_date_format);

    // DB Query
    $eagle_booking_booked_dates = $wpdb->get_results("SELECT date_from, date_to FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eb_room_id AND (paypal_payment_status = 'Completed' OR paypal_payment_status = 'Pending Payment') ");

    $eagle_booking_avaiability_string = '';

    if ($eagle_booking_booked_dates) {

        foreach ($eagle_booking_booked_dates as $eagle_booking_booked_date) {

            // Checked Checkin
            $eagle_booking_check_start_date = DateTime::createFromFormat("Y/m/d", $eb_checkin)->format('Y/m/d');

            // Booked Checkin & Checkout
            $eagle_booking_booked_checkin = $eagle_booking_booked_date->date_from;
            $eagle_booking_booked_checkout = $eagle_booking_booked_date->date_to;

            // Set the booked circle
            $eagle_booking_booked_circle = eb_total_booking_nights($eagle_booking_booked_checkin, $eagle_booking_booked_checkout);
            $eagle_booking_booked_start_date = DateTime::createFromFormat("m/d/Y", $eagle_booking_booked_checkin)->format('Y/m/d');
            $eagle_booking_booked_end_date = DateTime::createFromFormat("m/d/Y", $eagle_booking_booked_checkout)->format('Y/m/d');

            // Start loop the sheck dates
            for ($eagle_booking_i_1 = 1; $eagle_booking_i_1 <= $eagle_booking_check_circle; $eagle_booking_i_1++) {

                $eagle_booking_booked_start_date = DateTime::createFromFormat("m/d/Y", $eagle_booking_booked_checkin)->format('Y/m/d');

                // Start Check the booked date
                for ($eagle_booking_i_2 = 1; $eagle_booking_i_2 <= $eagle_booking_booked_circle; $eagle_booking_i_2++) {

                    if ($eagle_booking_check_start_date == $eagle_booking_booked_start_date) {

                        $eagle_booking_avaiability_string .= $eagle_booking_booked_start_date . '-';

                    }

                    // Add 1 day to check the next booked date
                    $eagle_booking_booked_start_date = date('Y/m/d', strtotime($eagle_booking_booked_start_date . ' + 1 days'));

                }

                // Add 1 day to check the next check date
                $eagle_booking_check_start_date = date('Y/m/d', strtotime($eagle_booking_check_start_date . ' + 1 days'));

            }
        }

        $eagle_booking_avaiability_count = $eagle_booking_avaiability_string;

    } else {

        $eagle_booking_avaiability_count = '';

    }

	// Check the Room Quantity
    $eagle_booking_quantity_availability = $eb_checkin;

    for ($eagle_booking_i = 1; $eagle_booking_i <= $eagle_booking_check_circle; $eagle_booking_i++) {

        $eagle_booking_num_reservations_per_day = substr_count($eagle_booking_avaiability_count, $eagle_booking_quantity_availability);

        if ($eagle_booking_num_reservations_per_day >= $eagle_booking_meta_box_qnt) {

            echo "'" . $eagle_booking_quantity_availability . "', ";
        }

        $eagle_booking_quantity_availability = date('Y/m/d', strtotime($eagle_booking_quantity_availability . ' + 1 days'));
    }

	// Check the Room Blocks
    if (!empty($eagle_booking_exceptions_array)) {

        for ($eagle_booking_exceptions_array_i = 0; $eagle_booking_exceptions_array_i < count($eagle_booking_exceptions_array); $eagle_booking_exceptions_array_i++) {

            // Get exception path
            $eagle_booking_page_by_path = get_post($eagle_booking_exceptions_array[$eagle_booking_exceptions_array_i], OBJECT, 'eagle_exceptions');

            // Exceptions MTB
            $eagle_booking_exception_id = $eagle_booking_page_by_path->ID;
            $eagle_booking_exception_name = get_the_title($eagle_booking_exception_id);
            $eagle_booking_mtb_exception_date_from = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_date_from', true);
            $eagle_booking_mtb_exception_date_to = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_date_to', true);
           // $eagle_booking_mbt_exception_repeat = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_repeat', true);

            // Get the total blocked booking nights
            $eagle_booking_blocked_booking_nights = eb_total_booking_nights($eagle_booking_mtb_exception_date_from, $eagle_booking_mtb_exception_date_to);

            // Format Exception Dates
            $eagle_booking_new_date_from_ex_format = DateTime::createFromFormat("m/d/Y", $eagle_booking_mtb_exception_date_from)->format('Y/m/d');
            $eagle_booking_new_date_to_ex_format = DateTime::createFromFormat("m/d/Y", $eagle_booking_mtb_exception_date_to)->format('Y/m/d');

            // Set the check circle
            $eagle_booking_checked_date = DateTime::createFromFormat("Y/m/d", $eb_checkin)->format('m/d/Y');


            //Bug: Further investigation needed (it check checkin + 1)
            $eagle_booking_checked_date = date('m/d/Y', strtotime($eagle_booking_checked_date . ' - 1 days'));

            for ($eagle_booking_i_1 = 0; $eagle_booking_i_1 <= $eagle_booking_check_circle; $eagle_booking_i_1++) {

                $eagle_booking_blocked_date = $eagle_booking_new_date_from_ex_format;

                for ($eagle_booking_i_2 = 0; $eagle_booking_i_2 <= $eagle_booking_blocked_booking_nights; $eagle_booking_i_2++) {


                    if ($eagle_booking_checked_date == $eagle_booking_blocked_date) {

                        echo "'" . $eagle_booking_checked_date . "', ";

                    }

                    $eagle_booking_blocked_date = date('Y/m/d', strtotime($eagle_booking_blocked_date . ' + 1 days'));

                }

                $eagle_booking_checked_date = date('Y/m/d', strtotime($eagle_booking_checked_date . ' + 1 days'));

            }

        }

    }

}
