<?php

/* --------------------------------------------------------------------------
 * Get final price
 * @ since  1.0.0
 * @ modified 1.3.3
 * return room total price (without taxes, fees, additional services)
---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_room_total_price($room_id, $dates) {

    // Initialize
    $room_total_price = '';

    // Date Format
    $eagle_booking_new_date = new DateTime($dates);

    $eagle_booking_new_date_format_n = date_format($eagle_booking_new_date, 'N');

    // Rooms Price
    $room_price = get_post_meta($room_id, 'eagle_booking_mtb_room_price', true);

    // Room Week Price
    $room_price_mon = get_post_meta($room_id, 'eagle_booking_mtb_room_price_mon', true);
    $room_price_tue = get_post_meta($room_id, 'eagle_booking_mtb_room_price_tue', true);
    $room_price_wed = get_post_meta($room_id, 'eagle_booking_mtb_room_price_wed', true);
    $room_price_thu = get_post_meta($room_id, 'eagle_booking_mtb_room_price_thu', true);
    $room_price_fri = get_post_meta($room_id, 'eagle_booking_mtb_room_price_fri', true);
    $room_price_sat = get_post_meta($room_id, 'eagle_booking_mtb_room_price_sat', true);
    $room_price_sun = get_post_meta($room_id, 'eagle_booking_mtb_room_price_sun', true);

    $room_price_week = array($room_price_mon, $room_price_tue, $room_price_wed, $room_price_thu, $room_price_fri, $room_price_sat, $room_price_sun);

    /**
    * Check Room Exceptions
    */
    $room_price_exceptions = get_post_meta($room_id, 'eagle_booking_mtb_room_price_exceptions', true);

    if (!empty($room_price_exceptions)) {

        for ($eagle_booking_exceptions_array_i = 0; $eagle_booking_exceptions_array_i < count($room_price_exceptions); $eagle_booking_exceptions_array_i++) {

            $eagle_booking_page_by_path = get_post($room_price_exceptions[$eagle_booking_exceptions_array_i], OBJECT, 'eagle_exceptions');
            $eagle_booking_exception_id = $eagle_booking_page_by_path->ID;

            // EXCEPTION MTB
            $eagle_booking_mbt_exception_type = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_type', true);
            if (empty($eagle_booking_mbt_exception_type)) {
                $eagle_booking_mbt_exception_type = 'price';
            }

            $eagle_booking_mtb_exception_price = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_price', true);
            $eagle_booking_mtb_exception_date_from = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_date_from', true);
            $eagle_booking_mtb_exception_date_to = get_post_meta($eagle_booking_exception_id, 'eagle_booking_mtb_exception_date_to', true);

            // DATE FORMAT
            $eagle_booking_new_date_from = new DateTime($eagle_booking_mtb_exception_date_from);
            $eagle_booking_new_date_from_format = date_format($eagle_booking_new_date_from, 'm/d');
            $eagle_booking_new_date_to = new DateTime($eagle_booking_mtb_exception_date_to);
            $eagle_booking_new_date_to = date_modify($eagle_booking_new_date_to, '-1 day');
            $eagle_booking_new_date_to_format = date_format($eagle_booking_new_date_to, 'm/d');
            $eagle_booking_date_new = new DateTime($dates);
            $eagle_booking_date_new_format = date_format($eagle_booking_date_new, 'm/d');

            if ($eagle_booking_date_new_format >= $eagle_booking_new_date_from_format && $eagle_booking_date_new_format <= $eagle_booking_new_date_to_format and $eagle_booking_mbt_exception_type == 'price') {

                $room_total_price = $eagle_booking_mtb_exception_price;

                return $room_total_price;

            } else {

                if ($room_price_week[$eagle_booking_new_date_format_n - 1] != '') {

                    $room_total_price = $room_price_week[$eagle_booking_new_date_format_n - 1];

                } else {

                    $room_total_price = $room_price;

                }
            }

        }

        return $room_total_price;

    } else {

        if ($room_price_week[$eagle_booking_new_date_format_n - 1] != '') {

            $room_total_price = $room_price_week[$eagle_booking_new_date_format_n - 1];

        } else {

            $room_total_price = $room_price;

        }

        return $room_total_price;

    }


}
