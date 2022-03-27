<?php

/**
* The Template for the additional services
*
* This template can be overridden by copying it to yourtheme/eb-templates/booking/additional-services.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.1.7
*/

defined('ABSPATH') || exit;

$eb_room_additional_services = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_additional_services', true );

if ( $eb_room_additional_services ) : ?>

<div class="eb-section eb-checkout-form">
  <h2 class="title"><?php echo __('Additional Services','eagle-booking') ?></h2>
  <div class="inner">
  <?php

    $eb_room_additional_services = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_additional_services', true );

    for ( $eb_i = 0; $eb_i < count($eb_room_additional_services); $eb_i++) :

        // Get service mtb
        $eb_room_additional_service = get_post($eb_room_additional_services[$eb_i],OBJECT,'eagle_services');
        $eb_additional_service_id = $eb_room_additional_service->ID;
        $eb_additional_service_name = get_the_title($eb_additional_service_id);
        $eb_service_price = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_price', true );
        $eb_additional_service_description = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_description', true );

        // Get service type
        $eb_additional_service_price_type = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_price_type', true );

        // Get service type 2
        $eb_additional_service_price_type_2 = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_price_type_2', true );

        // Check service price type
        if ( $eb_additional_service_price_type == 'guest' ) {

          $eb_additional_service_price_operator = $eb_guests;
          $eb_additional_service_price_word = __('Guest','eagle-booking');

        } elseif ($eb_additional_service_price_type == 'adult') {

          $eb_additional_service_price_operator = $eb_adults ;
          $eb_additional_service_price_word = __('Adult','eagle-booking');

        } elseif ($eb_additional_service_price_type == 'children') {

          $eb_additional_service_price_operator = $eb_children ;
          $eb_additional_service_price_word = __('Children','eagle-booking');

        } elseif ($eb_additional_service_price_type == 'adult_children') {

          $eb_additional_service_price_operator = $eb_adults + $eb_children;
          $eb_additional_service_price_word = __('Adults + Children','eagle-booking');

        } else {

          $eb_additional_service_price_operator = 1;
          $eb_additional_service_price_word = __('Room','eagle-booking');
        }

        // Check service price type 2
        if ( $eb_additional_service_price_type_2 == 'night' ) {

            $eb_additional_service_price_operator_2 = eb_total_booking_nights($eb_checkin, $eb_checkout);
            $eb_additional_service_price_word_2 = __('Night','eagle-booking');

        } else {

            $eb_additional_service_price_operator_2 = 1;
            $eb_additional_service_price_word_2 = __('Trip','eagle-booking');
        }

        /**
         * Calculate Additional Services Price
         */
        $eb_service_price_before_tax = $eb_service_price * $eb_additional_service_price_operator * $eb_additional_service_price_operator_2;

        /**
         * Add Taxes to Additional Services
         */
        $eb_taxes = get_option('eb_taxes');
        $eb_room_taxes = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_taxes', true );
        if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();

        $entry_id = '';

        if ( $eb_taxes ) {

          $eb_tax_percentage = 0;
          $out = array();

          foreach( $eb_taxes as $key => $item ) {

              $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
              $global = !empty( $item["global"] ) ? $item["global"] : '';
              $services = !empty( $item["services"] ) ? $item["services"] : '';
              $amount = !empty( $item["amount"] ) ? $item["amount"] : '';

              // Lets check if the tax is global or if is asigned to the room and if tax is aplied on services
              if ( ( $global == true || in_array( $entry_id, $eb_room_taxes) ) && $services == true  ) {

                $eb_tax_percentage += $amount;
                array_push($out, $entry_id);

              }

          }

          // Add the tax price to the service price
          $eb_service_price =  $eb_service_price + $eb_tax_percentage * $eb_service_price / 100;
          $eb_service_total_price =  $eb_service_price_before_tax + ( $eb_service_price_before_tax * $eb_tax_percentage / 100 );
          $eb_applied_taxes = implode(', ', $out);

        } else {

          $eb_service_price = $eb_service_price;
          $eb_service_total_price = $eb_service_price_before_tax;
          $eb_applied_taxes = '';

        }

        /**
         * Additional Services Display
         */
        if ( eb_get_option('price_taxes') === 'excluding' ){

           $eb_service_total_price = $eb_service_price_before_tax;

        } else {

          $eb_service_total_price = $eb_service_total_price;

        }

        /**
         * Services Price
         */
        if ( $eb_service_total_price == 0 ) {

          $eb_service_total_price = $eb_service_price = __('Free', 'eagle-booking');

        } else if ( eb_currency_position() == 'before' ) {

          $eb_service_displayed_price = eb_currency().''.eb_formatted_price( $eb_service_price, false );
          $eb_service_displayed_total_price = eb_currency().''.eb_formatted_price( $eb_service_total_price, false );


        } else {

          $eb_service_displayed_price = eb_formatted_price( $eb_service_price, false ).''.eb_currency();
          $eb_service_displayed_total_price = eb_formatted_price( $eb_service_total_price, false ).''.eb_currency();

        }

    ?>
      <div class="additional-service-item" data-service-id="<?php echo $eb_additional_service_id ?>">

        <input type="checkbox" data-id="<?php echo $eb_additional_service_id ?>" data-amount="<?php echo $eb_service_price_before_tax ?>" data-aplied-taxes="<?php echo $eb_applied_taxes?>" value="<?php echo $eb_service_price_before_tax ?>" >

        <div class="additional-service-details">
          <span class="eb-booking-service-title"><strong><?php echo $eb_additional_service_name ?></strong></span>
          <?php if ( eb_get_option( 'show_price' ) == true ) : ?>
          <span><?php echo $eb_service_displayed_price ?> (<?php echo $eb_additional_service_price_word ?> / <?php echo $eb_additional_service_price_word_2 ?>)</span>
          <span class="eb-booking-service-price"><strong><?php echo $eb_service_displayed_total_price ?></strong></span>
          <?php endif ?>
        </div>
        <?php if( $eb_additional_service_description ) : ?> <span class="toggle-service-full-details"> <i class="far fa-question-circle"></i> </span> <?php endif ?>
        <?php if( $eb_additional_service_description ) : ?> <div class="additional-service-full-details"> <?php echo $eb_additional_service_description ?> </div><?php endif ?>
      </div>

    <?php endfor ?>

    <input type="hidden" id="eb_services_amount" value="0">

  </div>
</div>

<?php endif ?>
