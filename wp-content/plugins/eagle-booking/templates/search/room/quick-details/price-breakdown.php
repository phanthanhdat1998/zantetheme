<?php
/**
 * The Template for displaying price breakdown
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/quick-details/price-breakdown.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.7
 */

defined('ABSPATH') || exit;

?>

<?php if ( eb_get_option('eb_search_quick_details_elements')['price_breakdown'] == true ) : ?>

  <div class="eb-room-price-breakdown">
      <h6 class="section-title"><?php echo esc_html__('Price Breakdown', 'eagle-booking') ?></h6>

      <?php

      // Get Room Additional exceptions
      $eb_price_exception_array = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_price_exceptions', true );

      if($eb_price_exception_array) :

        // Start Loop
        for ($eb_price_exception_array_i = 0; $eb_price_exception_array_i < count($eb_price_exception_array); $eb_price_exception_array_i++) {

          $eb_page_by_path = get_post($eb_price_exception_array[$eb_price_exception_array_i],OBJECT,'eagle_exception');
          $price_id = $eb_page_by_path->ID;
          $eb_exception_title = get_the_title($price_id);
          $price_exception_start = get_post_meta( $price_id, 'eagle_booking_mtb_exception_date_from', true );
          $price_exception_end = get_post_meta( $price_id, 'eagle_booking_mtb_exception_date_to', true );
          $price_exception_price = get_post_meta( $price_id, 'eagle_booking_mtb_exception_price', true );

          echo '<div class="room-breakdown-item eg-g-1-1">';
          echo '<span>'.$eb_exception_title.'</span>';
          echo '<span>'.eagle_booking_displayd_date_format( $price_exception_start ).' &nbsp; → &nbsp; ';
          echo eagle_booking_displayd_date_format( $price_exception_end ).'</span>';

          if( eb_currency_position() === 'before' ) {

            echo '<span class="value">'.eb_currency().''.eb_formatted_price($price_exception_price, false).'</span>';

          } else {

            echo '<span class="value">'.eb_formatted_price($price_exception_price, false).''.eb_currency().'</span>';

          }

          echo '</div>';

        } ?>

    <?php endif ?>

    <?php

      // Get room extra guests option
      $eb_room_price_type = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_price_type', true );

      if( $eb_room_price_type == 'room_price_nights_guests' || $eb_room_price_type == 'room_price_nights_guests_custom' ) :

    ?>

    <div class="price-breakdown-item mt20">
      <i class="fas fa-exclamation-circle"></i> <?php echo __('The displayed price is referred to the room normal price. Pricing based on guests number applied to this room.', 'eagle-booking') ?>
    </div>

    <?php endif ?>

  </div>

<?php endif;
