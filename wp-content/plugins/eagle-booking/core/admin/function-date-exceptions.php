<?php
/* --------------------------------------------------------------------------
 * Eagle Booking / Dates Exceptions
 * Author: Eagle Themes
 * Since: 1.0.4
 * Modified: 1.2.4.4
---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_room_is_available_block($eb_room_id, $eb_checkin, $eb_checkout) {

    if ( $eb_checkin && $eb_checkout ) {

        // Get Room Exceptions
        $eb_exceptions_array = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_block_exceptions', true);

        // Set the check circle
        $eb_check_start_date_format =  DateTime::createFromFormat("m/d/Y", $eb_checkin)->format('m/d/Y');
        $eb_check_end_date_format = DateTime::createFromFormat("m/d/Y", $eb_checkout)->format('m/d/Y');
        $eb_check_circle = eb_total_booking_nights($eb_check_start_date_format, $eb_check_end_date_format);

        // Initialize
        $eb_is_available_block = true;

        // Check the Room Blocks
        if (!empty($eb_exceptions_array)) {

            for ($eb_exceptions_array_i = 0; $eb_exceptions_array_i < count($eb_exceptions_array); $eb_exceptions_array_i++) {

                // Get exception path
                $eb_page_by_path = get_post($eb_exceptions_array[$eb_exceptions_array_i], OBJECT, 'eagle_exceptions');

                // Exceptions MTB
                $eb_exception_id = $eb_page_by_path->ID;
                $eb_exception_name = get_the_title($eb_exception_id);
                $eb_mtb_exception_date_from = get_post_meta($eb_exception_id, 'eagle_booking_mtb_exception_date_from', true);
                $eb_mtb_exception_date_to = get_post_meta($eb_exception_id, 'eagle_booking_mtb_exception_date_to', true);
                //$eb_mbt_exception_repeat = get_post_meta($eb_exception_id, 'eagle_booking_mtb_exception_repeat', true);

                // Get the total blocked booking nights
                $eb_blocked_booking_nights = eb_total_booking_nights($eb_mtb_exception_date_from, $eb_mtb_exception_date_to);

                // Format Exception Dates
                $eb_new_date_from_ex_format = DateTime::createFromFormat("m/d/Y", $eb_mtb_exception_date_from)->format('Y/m/d');
                $eb_new_date_to_ex_format = DateTime::createFromFormat("m/d/Y", $eb_mtb_exception_date_to)->format('Y/m/d');

                // Set the check circle
                $eb_checked_date = DateTime::createFromFormat("m/d/Y", $eb_checkin)->format('m/d/Y');


                //Bug: Further investigation needed (it check checkin + 1)
                $eb_checked_date = date('m/d/Y', strtotime($eb_checked_date . ' - 1 days'));

                for ($eb_i_1 = 0; $eb_i_1 <= $eb_check_circle; $eb_i_1++) {


                    $eb_blocked_date = $eb_new_date_from_ex_format;

                    for ($eb_i_2 = 0; $eb_i_2 <= $eb_blocked_booking_nights; $eb_i_2++) {


                        if ($eb_checked_date == $eb_blocked_date) {

                         // echo $eb_checked_date .' = '. $eb_blocked_date;
                         $eb_is_available_block = false;

                        }

                        $eb_blocked_date = date('Y/m/d', strtotime($eb_blocked_date . ' + 1 days'));

                    }

                    $eb_checked_date = date('Y/m/d', strtotime($eb_checked_date . ' + 1 days'));

                }


            }


        }

        return $eb_is_available_block;

    }

}
