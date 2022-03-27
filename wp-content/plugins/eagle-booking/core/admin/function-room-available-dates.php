<?php

/* --------------------------------------------------------------------------
 * Check room date availability
 * Return Room Available Dates (String)
 * @since  1.0.0
---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eagle_booking_room_availability($eb_room_id, $eagle_booking_checkin, $eagle_booking_checkout) {

   global $wpdb;

    // DB Query
    $eagle_booking_booked_dates = $wpdb->get_results("SELECT date_from, date_to FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eb_room_id AND (paypal_payment_status = 'Completed' OR paypal_payment_status = 'Pending Payment') ");

    // Checked Period
    $eagle_booking_checked_period = eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout);

    $eagle_booking_room_available_dates = '';

    if (!empty($eagle_booking_booked_dates)) {

        foreach ($eagle_booking_booked_dates as $eagle_booking_booked_date) {

            // Checked Checkin
            $eagle_booking_checked_checkin = DateTime::createFromFormat("m/d/Y", $eagle_booking_checkin)->format('Y/m/d');

            // Booked Checkin & Checkout
            $eagle_booking_booked_checkin = $eagle_booking_booked_date->date_from;
            $eagle_booking_booked_checkout = $eagle_booking_booked_date->date_to;

            // Booked Period
            $eagle_booking_booked_period = eb_total_booking_nights($eagle_booking_booked_checkin, $eagle_booking_booked_checkout);

            // Start Checked Period
            for ($eagle_booking_checked_period_count = 1; $eagle_booking_checked_period_count <= $eagle_booking_checked_period; $eagle_booking_checked_period_count++) {

                $eagle_booking_booked_checkin_new = DateTime::createFromFormat("m/d/Y", $eagle_booking_booked_checkin)->format('Y/m/d');

                // Start Booked Period
                for ($eagle_booking_booked_period_count = 1; $eagle_booking_booked_period_count <= $eagle_booking_booked_period; $eagle_booking_booked_period_count++) {

                    if ($eagle_booking_checked_checkin == $eagle_booking_booked_checkin_new) {
                        $eagle_booking_room_available_dates .= $eagle_booking_checked_checkin . '-';
                    }

                    $eagle_booking_booked_checkin_new = date('Y/m/d', strtotime($eagle_booking_booked_checkin_new . ' + 1 days'));

                }

                $eagle_booking_checked_checkin = date('Y/m/d', strtotime($eagle_booking_checked_checkin . ' + 1 days'));

            }

        }

        return $eagle_booking_room_available_dates;

    }

}
