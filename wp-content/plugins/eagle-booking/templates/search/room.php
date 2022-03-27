<?php
/**
 * The Template for displaying room
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/room.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.7
 */

defined('ABSPATH') || exit;

// Defaults
$eb_room_title = get_the_title();
$eb_room_id = get_the_ID();
$eb_room_url = get_permalink( $eb_room_id );

// Metabaxes
$eb_room_description = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_description', true );
$eb_room_featured = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_featured', true );
$eb_min_booking_nights = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_min_booking_nights', true );
$eb_max_booking_nights = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_max_booking_nights', true );

if ( empty($eb_min_booking_nights) ) $eb_min_booking_nights = 1;
if ( empty($eb_max_booking_nights) ) $eb_max_booking_nights = 1000;

?>

<div id="eb-search-room-<?php echo esc_attr($eb_room_id) ?>" class="room-list-item">
  <div class="room-list-item-grid">
      <figure>
        <a href="<?php echo esc_url($eb_room_url) ?>">

          <?php if ($eb_room_featured == true) : ?>
            <span class="featured-room"><i class="fa fa-star"></i><?php echo __('Featured', 'eagle-booking') ?></span>
          <?php endif ?>

          <?php if ( has_post_thumbnail() ) : ?>
            <img src="<?php echo eagle_booking_get_room_img_url($eb_room_id, 'eagle_booking_image_size_720_470') ?>" alt="<?php echo esc_html($eb_room_title) ?>" loading="lazy">
          <?php else : ?>
            <div class="room-no-image"><?php echo __('No image available', 'eagle-booking' ) ?></div>
          <?php endif ?>

        </a>
      </figure>

      <div class="room-details">
        <h2 class="title">
          <a href="<?php echo get_permalink($eb_room_id) ?>"><?php echo esc_html($eb_room_title) ?></a>
        </h2>
        <p><?php echo esc_html($eb_room_description) ?></p>
        <?php

        /**
         * Include Services
        */
        if ( eb_get_option('eb_search_services') == true ) {
          include eb_load_template('search/room/services.php');
        }

        ?>
      </div>
      <?php

        /**
        * Include Price
        */
        include eb_load_template('search/room/price.php')

      ?>
  </div>
  <?php
    /**
   * Include Quick Details
   */
    if ( eb_get_option('eb_search_quick_details') == true ) {
      include eb_load_template('search/room/quick-details.php');
    }
  ?>
</div>
