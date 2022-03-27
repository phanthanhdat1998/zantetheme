<?php
/**
 * The Template for displaying room price
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/price.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.8

 */

defined('ABSPATH') || exit;
?>

<div class="room-price-details">
  <div class="room-price-search">

    <?php

      eb_room_price( $eb_room_id, __('per night', 'eagle-booking') );

      // Translated Rooms - Check if the room is a translated room and if so override the room id with the default one (used only to check availability)
      $eb_default_room = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_default_room_id', true );

      if ( $eb_default_room != '' ) {

         $eb_room_id_availability = $eb_default_room;

      } else {

         $eb_room_id_availability = get_the_ID() ;
      }

      // Room Availability
      if ( eb_room_is_available_block( $eb_room_id_availability, $eagle_booking_checkin, $eagle_booking_checkout ) && eagle_booking_is_qnt_available( eagle_booking_room_availability( $eb_room_id_availability, $eagle_booking_checkin, $eagle_booking_checkout ), $eagle_booking_checkin, $eagle_booking_checkout, $eb_room_id ) == 1  ) {

        $eb_booking_nights = eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout);

        // Room is Available
        if ( $eb_booking_nights >= $eb_min_booking_nights && $eb_booking_nights <= $eb_max_booking_nights ) {

            $eb_trip_price = 0;
            $eagle_booking_index = 1;
            $eagle_booking_date_cicle = $eagle_booking_checkin;

            while ($eagle_booking_index <= eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout)) :

              // Price Type
              $eb_room_price_type = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_price_type', true);

            // Charge based on room price x booking nights x guests number
            if ($eb_room_price_type === 'room_price_nights_guests') {

                // Adults & children option is enabled
                if ( eb_get_option('eb_adults_children') == true ) {

                  // Calculate the total price
                  $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle) * ($eagle_booking_adults + $eagle_booking_children);

                } else {

                  // Calculate the total price
                  $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle) * $eagle_booking_guests;
                }

                // Charge bades on guests or adults & children price
            } elseif ($eb_room_price_type === 'room_price_nights_guests_custom') {

                // Adults & children option is enabled
                if ( eb_get_option('eb_adults_children') == true ) {

                    $eb_adults_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_adult_price', true) ?: 0;
                    $eb_adults_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_adults_price_start', true) ?: 0;
                    $eb_children_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_children_price', true) ?: 0;
                    $eb_children_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_children_price_start', true) ?: 0;

                    // Adults total custom price
                    if ($eagle_booking_adults < $eb_adults_price_start) {
                        $eb_adults_price_total = 0;
                    } else {
                        $eb_adults_price_total = $eb_adults_price * ($eagle_booking_adults - $eb_adults_price_start);
                    }

                    // Children total custom price
                    if ($eagle_booking_children < $eb_children_price_start) {
                        $eb_children_price_total = 0;
                    } else {
                        $eb_children_price_total = $eb_children_price * ($eagle_booking_children - $eb_children_price_start);
                    }

                    // Calculate the total price
                    $eb_trip_price = ($eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle)) + ($eb_adults_price_total) + ($eb_children_price_total);
                } else {
                    $eb_guests_price = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_guests_price', true) ?: 0;
                    $eb_guests_price_start = get_post_meta($eb_room_id, 'eagle_booking_mtb_room_guests_price_start', true) ?: 0;

                    // Guests total custom price
                    if ($eagle_booking_guests < $eb_guests_price_start) {
                        $eb_guests_price_total = 0;
                    } else {
                        $eb_guests_price_total = $eb_guests_price * ($eagle_booking_guests - $eb_guests_price_start);
                    }


                    // Calculate the total price
                    $eb_trip_price = ($eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle)) + ($eb_guests_price_total);
                }

                // Charge based on room price x booking nights
            } else {

                // Calculate the total price
                $eb_trip_price = $eb_trip_price + eb_room_total_price($eb_room_id, $eagle_booking_date_cicle);
            }

            $eagle_booking_date_cicle = date('Y/m/d', strtotime($eagle_booking_date_cicle.' + 1 days'));

            $eagle_booking_index++;

            endwhile; ?>
            <form method="post" action="<?php echo eb_booking_page() ?>">
                <input type="hidden" name="eb_room_id" value="<?php echo get_the_ID() ?>">
                <input type="hidden" name="eb_checkin" value="<?php echo $eagle_booking_checkin ?>">
                <input type="hidden" name="eb_checkout" value="<?php echo $eagle_booking_checkout ?>">
                <input type="hidden" name="eb_guests" value="<?php echo $eagle_booking_guests ?>">
                <input type="hidden" name="eb_adults" value="<?php echo $eagle_booking_adults ?>">
                <input type="hidden" name="eb_children" value="<?php echo $eagle_booking_children ?>">
                <button class="eb-btn btn" name="submit" type="submit">

                <?php if ( eb_get_option('show_price') == true ) : ?>

                  <?php if ( eb_get_option('total_price') === 'mouseover' ) : ?>

                    <span class="booking-text"><?php echo __('Book Now', 'eagle-booking') ?></span>
                    <span class="total-price-text"><?php echo __('For', 'eagle-booking') ?>
                      <?php echo eb_price( eb_total_price( get_the_ID(), $eb_trip_price, $eb_booking_nights, $eagle_booking_guests ) ); ?>
                    </span>

                  <?php else: ?>

                    <span><?php echo __('Book For', 'eagle-booking') ?>
                    <?php echo eb_price( eb_total_price( get_the_ID(), $eb_trip_price, $eb_booking_nights, $eagle_booking_guests ) ) ?>
                    </span>

                  <?php endif ?>

                <?php else : ?>

                  <span><?php echo __('Book Now', 'eagle-booking') ?></span>

                <?php endif ?>

                </button>

                <?php if ( eb_room_has_taxes_fees( get_the_ID() ) == true && eb_get_option('show_price') == true ) echo "<small class='eb-price-excludes-tax'><i>".__('Price Excludes Taxes & Fees', 'eagle-booking')."</i></small>";  ?>

            </form>
      <?php

        // Room is not Available - Maximum Booking Nights
        } elseif ( $eb_booking_nights > $eb_max_booking_nights ) { ?>

          <div class="min-max-booking-nights-notice">
            <?php echo __('Max. Booking Nights','eagle-booking') ?>: <?php echo $eb_max_booking_nights ?>
          </div>

      <?php

        // Room is not Available - MInimum Booking Nights
        } else { ?>

          <div class="min-max-booking-nights-notice">
            <?php echo __('Min. Booking Nights','eagle-booking') ?>: <?php echo $eb_min_booking_nights ?>
          </div>

      <?php } ?>

      <?php } else { ?>

          <?php if ( empty($eagle_booking_checkin) || empty($eagle_booking_checkout) ) : ?>

          <div class="select-booking-dates-notice" id="select-booking-dates"><?php echo __('Select Booking Dates','eagle-booking') ?></div>
          <?php else: ?>

          <div class="not-available-notice"><?php echo __('Those dates are not available','eagle-booking') ?></div>
          <?php endif ?>

      <?php } ?>

      </div>

      <?php if ( eb_get_option('eb_search_quick_details') == true ) : ?>
        <div class="toggle-room-breakpoint room-more-details">
          <?php echo __('Availability & Details', 'eagle-booking') ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
        </div>
      <?php endif ?>

    </div>
