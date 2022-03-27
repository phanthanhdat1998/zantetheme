<?php
   /**
    * The Template for the additional services
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/checkout/additional-services.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.5
    */

   defined('ABSPATH') || exit;

?>

<?php

$eagle_booking_form_extra_services = '';

if ( $eagle_booking_form_services ) :

    $eagle_booking_additional_services_array = explode(',', $eagle_booking_form_services );

    for ($eagle_booking_additional_services_array_i = 0; $eagle_booking_additional_services_array_i < count($eagle_booking_additional_services_array)-1; $eagle_booking_additional_services_array_i++) {

        $eagle_booking_service_id = $eagle_booking_additional_services_array[$eagle_booking_additional_services_array_i];

        // SERVICE MTB
        $eagle_booking_mtb_service_price = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_price', true );

        $eagle_booking_mtb_service_price_type_1 = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_price_type', true );
        $eagle_booking_mtb_service_price_type_2 = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_price_type_2', true );


        if ( $eagle_booking_mtb_service_price_type_1 == 'guest' ) {
            $eagle_booking_operator_1 = $eagle_booking_form_guests;
        } else {
            $eagle_booking_operator_1 = 1;
        }

        if ( $eagle_booking_mtb_service_price_type_2 == 'night' ) {
            $eagle_booking_operator_2 = eb_total_booking_nights($eagle_booking_form_date_from, $eagle_booking_form_date_to);
        } else {
            $eagle_booking_operator_2 = 1;
        }

        $eagle_booking_additional_service_total_price = $eagle_booking_mtb_service_price*$eagle_booking_operator_1*$eagle_booking_operator_2;
        $eagle_booking_form_extra_services .= $eagle_booking_service_id.'['.$eagle_booking_additional_service_total_price.'],';

    }

endif;