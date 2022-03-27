<?php

/* --------------------------------------------------------------------------
 * Insert booking into the db
 * @since  1.0.0
 * modified 1.3.3
---------------------------------------------------------------------------*/
function eb_insert_booking_into_db(
    $eb_room_id,
    $eb_room_title,
    $eb_date,
    $eb_checkin,
    $eb_checkout,
    $eb_guests,
    $eb_adults,
    $eb_children,
    $eb_room_price,
    $eb_final_trip_price,
    $eb_deposit_amount,
    $eb_extra_services,
    $eb_user_id,
    $eb_user_first_name,
    $eb_user_last_name,
    $eb_user_email,
    $eb_user_ip,
    $eb_user_phone,
    $eb_user_address,
    $eb_user_city,
    $eb_user_country,
    $eb_user_message,
    $eb_user_arrival,
    $eb_user_coupon,
    $eb_payment_status,
    $eb_payment_currency,
    $eb_transaction_id,
    $eb_action_type

) {

    if ( eb_booking_exist($eb_room_id, $eb_checkin, $eb_checkout, $eb_user_email ) == 0) {

        global $wpdb;

        // Tables
        $eb_main_table = $wpdb->prefix . 'eagle_booking';
        $eb_meta_table = $wpdb->prefix . 'eagle_booking_meta';

        /**
         * Insert Booking Details into the Eagle Booking Main Table
         */
        $eb_insert_booking_into_db = $wpdb->insert(

            $eb_main_table,

            array(
                'id_post' => $eb_room_id,
                'title_post' => $eb_room_title,
                'date' => $eb_date,
                'date_from' => $eb_checkin,
                'date_to' => $eb_checkout,
                'guests' => $eb_guests,
                'adults' => $eb_adults,
                'children' => $eb_children,
                'final_trip_price' => $eb_final_trip_price,
                'deposit_amount' => $eb_deposit_amount,
                'extra_services' => $eb_extra_services,
                'id_user' => $eb_user_id,
                'user_first_name' => $eb_user_first_name,
                'user_last_name' => $eb_user_last_name,
                'paypal_email' => $eb_user_email,
                'user_ip' => $eb_user_ip,
                'user_phone' => $eb_user_phone,
                'user_address' => $eb_user_address,
                'user_city' => $eb_user_city,
                'user_country' => $eb_user_country,
                'user_message' => $eb_user_message,
                'user_arrival' => $eb_user_arrival,
                'user_coupon' => $eb_user_coupon,
                'paypal_payment_status' => $eb_payment_status,
                'paypal_currency' => $eb_payment_currency,
                'paypal_tx' => $eb_transaction_id,
                'action_type' => $eb_action_type,
            )

        );

        global $eb_booking_id;

         /**
         * Insert Booking Details into the Eagle Booking Meta Table
         */
        $eb_booking_id = $wpdb->insert_id;
        $eb_taxes = eb_room_taxes( $eb_room_id );
        $eb_fees = eb_room_fees( $eb_room_id );

        // Insert Room Taxes
        if ( $eb_taxes ) foreach( $eb_taxes as $key => $tax ) {

            $entry_id = $tax;

            $eb_insert_booking_into_db = $wpdb->insert(

                $eb_meta_table,
                array(
                    'booking_id' => $eb_booking_id,
                    'meta_key' => 'tax',
                    'meta_value' => $entry_id,
                )

            );

        }

        // Insert Room Fees into the Eagle Booking Meta Table
        if ( $eb_fees ) foreach( $eb_fees as $key => $fee ) {

            $entry_id =  $fee[0];

            $eb_insert_booking_into_db = $wpdb->insert(

                $eb_meta_table,
                array(
                    'booking_id' => $eb_booking_id,
                    'meta_key' => 'fee',
                    'meta_value' => $entry_id,
                )

            );

        }

        // Insert Room Price Without Taxes/Fees into the Eagle Booking Meta Table
        if ( $eb_room_price ) {

            $eb_insert_booking_into_db = $wpdb->insert(

                $eb_meta_table,
                array(
                    'booking_id' => $eb_booking_id,
                    'meta_key' => 'room_price',
                    'meta_value' => $eb_room_price,
                )

            );
        }

        // Add booking into DB
        if ($eb_insert_booking_into_db) {
            do_action(
                'eb_insert_booking_in_db',
                $eb_room_id,
                $eb_room_title,
                $eb_date,
                $eb_checkin,
                $eb_checkout,
                $eb_guests,
                $eb_adults,
                $eb_children,
                $eb_final_trip_price,
                $eb_deposit_amount,
                $eb_extra_services,
                $eb_user_id,
                $eb_user_first_name,
                $eb_user_last_name,
                $eb_user_email,
                $eb_user_ip,
                $eb_user_phone,
                $eb_user_address,
                $eb_user_city,
                $eb_user_country,
                $eb_user_message,
                $eb_user_arrival,
                $eb_user_coupon,
                $eb_payment_status,
                $eb_payment_currency,
                $eb_transaction_id,
                $eb_action_type
            );

            return 1;

        } else {

            // Add a debug option in the plugin settings

            // // Debug
            // $wpdb->print_error();
            // $wpdb->show_errors();
            //
            //

			//  echo $wpdb->last_query;
			// echo $wpdb->last_error;

			// foreach ( $wpdb->get_col( "DESC " . $eb_main_table, 0 ) as $column_name ) {
			// 	echo $column_name;
			// 	echo "<br/>";
			// }

            // if($wpdb->get_var("SHOW TABLES LIKE '$eb_main_table'") != $eb_main_table) {
            //     echo "Table Doesn't Exist";
            // }


            return 0;

        }

    }

}