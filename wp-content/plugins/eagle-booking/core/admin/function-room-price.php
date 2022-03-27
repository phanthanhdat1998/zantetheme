<?php
/* --------------------------------------------------------------------------
* Package: Room Price / Eagle Booking Core
* Since  1.2.2
* Modified: 1.3.3
^ Author: Eagle Themes (Jomin Muskaj)
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_room_price' ) ) {

    function eb_room_price( $eb_room_id, $eb_room_per_night_text ) {

        if( eagle_booking_room_min_price( $eb_room_id ) && eb_get_option('show_price') == true && eb_get_option('eb_show_room_price') == true ) {

            $eb_text_before_price = eb_get_option('eagle_booking_before_price');
            $room_price = eagle_booking_room_min_price( $eb_room_id );

            /**
             * Add Taxes to Room Normal Price
             */
            $eb_taxes = get_option('eb_taxes');
            $eb_room_taxes = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_taxes', true );
            if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();

            if ( $eb_taxes && eb_get_option('price_tax') === 'including' ) {

                $eb_tax_price = 0;
                $entry_id = '';

                foreach( $eb_taxes as $key => $item ) {

                    $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
                    $global = !empty( $item["global"] ) ? $item["global"] : '';
                    $amount = !empty( $item["amount"] ) ? $item["amount"] : '';

                    // Lets check if the tax is global or if is asigned to the room and if tax is aplied on services
                    if (  ( $global == true || in_array( $entry_id, $eb_room_taxes) ) ) {

                        $eb_tax_price += $amount;

                    }

                }

                // Add the tax price to the normal price
                $room_price =  $room_price + $eb_tax_price * $room_price / 100;

            } else {

            $room_price = $room_price;

            }

            $eb_room_price = '<span class="normal-price"><strong>'.eb_price( $room_price ).'</strong></span>';

            if ( $eb_text_before_price != '' ) {

                $eb_room_text = '<span class="text-before-price">'.$eb_text_before_price.'</span>'.' ';

            } else {

                $eb_room_text = '';

            }

            echo '<div class="room-price">';
            echo $eb_room_text.$eb_room_price;
            echo '<span class="per-night-text">'.' ' .$eb_room_per_night_text. '</span>';
            echo '</div>';

        }

    }

}