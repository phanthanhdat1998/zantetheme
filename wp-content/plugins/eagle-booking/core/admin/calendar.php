<?php

/* --------------------------------------------------------------------------
 * @ EB Admin
 * @ Bookings Calendar View [Admin]
 * @ Since  1.1.6
 * @ Author: Eagle Themes
 * @ Developer: Jomin Muskaj
---------------------------------------------------------------------------*/
function eb_calendar_availability() {

    // Data
    $eb_date = $_GET['eb_date'];
    $eb_room_id = $_GET['eb_room_id'];

    // Verify nonce
    $eb_calendar_nonce = $_GET['eb_calendar_nonce'];

    if ( !wp_verify_nonce($eb_calendar_nonce, 'eb_admin_nonce') ) {

        $eb_return_data['message'] = 'Invalid Nonce';

    } else {

        global $wpdb;

        // Get the bookings
        $eb_calendar_bookings = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eb_room_id");

        if ( $eb_calendar_bookings ) {

            $eb_output = '<table class="eb-popover-bookings">';
            $eb_output .= '<thead>';
            $eb_output .= '<tr>';
            $eb_output .= '<th>'.__('ID', 'eagle-booking').'</th>';
            $eb_output .= '<th>'.__('Booking Dates', 'eagle-booking').'</th>';
            $eb_output .= '<th>'.__('Status', 'eagle-booking').'</th>';
            $eb_output .= '<th>'.__('Action', 'eagle-booking').'</th>';
            $eb_output .= '</tr>';
            $eb_output .= '</thead>';
            $eb_output .= '<tbody id="bookings">';

            foreach ( $eb_calendar_bookings as $eb_calendar_booking ) {

                // Get the booking details
                $eb_booking_id = $eb_calendar_booking->id;
                $eb_booking_checkin = $eb_calendar_booking->date_from;
                $eb_booking_checkout = $eb_calendar_booking->date_to;
                $eb_booking_status_class = strtolower( preg_replace('/\s+/', '-', $eb_calendar_booking->paypal_payment_status) );

                // Get the total number of booking nights based on the checkin & checkout
                $eb_nights = eb_total_booking_nights($eb_booking_checkin, $eb_booking_checkout);

                $eb_checked_date = $eb_booking_checkin;

                // Loop for each date that is included in the booking range
                for ($eb_i = 1; $eb_i <= $eb_nights; $eb_i++ ) {

                    if ( $eb_date == $eb_checked_date ) {

                          $eb_booking = '<tr class="eb-popover-booking" data-booking-id="'.$eb_booking_id.'">';
                          $eb_booking .= '<td>' .$eb_booking_id. '</td>';
                          $eb_booking .= '<td>' .eagle_booking_displayd_date_format($eb_booking_checkin). ' →  ' .eagle_booking_displayd_date_format($eb_booking_checkout).  '</td>';
                          $eb_booking .= '<td> <span class="status '.esc_attr($eb_booking_status_class).'"></span> </td>';
                          $eb_booking .= '<td>';
                          $eb_booking .= '<a href="admin.php?page=eb_edit_booking&id='.$eb_booking_id.'" class="action-icon" target="_blank"><i class="far fa-edit"></i></a>';
                          $eb_booking .= '<a href="#" id="eb_delete_booking" data-booking-id="'.$eb_booking_id.'" class="action-icon" target="_blank"><i class="far fa-trash-alt"></i></a>';
                          $eb_booking .= '</td>';
                          $eb_booking .= '</tr>';

                          $eb_bookings[] = $eb_booking;

                    }

                    // Check the next date
                    $eb_checked_date = date('m/d/Y', strtotime($eb_checked_date.' + 1 days'));

                }

            }

        }

        $eb_output .= '</tbody>';
        $eb_output .= '</table>';

        $eb_return_data['output']  = $eb_output;
        $eb_return_data['bookings']  = $eb_bookings;

    }

    wp_send_json($eb_return_data);

}

add_action( 'wp_ajax_eb_admin_calendar_action', 'eb_calendar_availability' );
