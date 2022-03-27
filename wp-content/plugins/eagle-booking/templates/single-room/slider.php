<?php
/**
 * The Template for displaying room slider
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/slider.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;

?>

<?php if ($room_slider) : ?>

<div class="room-slider">

	<div id="eb-room-slider" class="swiper-container">
			<div class="swiper-wrapper eb-image-gallery">
        <?php
        $files = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_slider_images', true );
        foreach ( (array) $files as $attachment_id => $attachment_url ) :

          $room_images_url = wp_get_attachment_image_url( $attachment_id, 'eagle_booking_image_size_1170_680' ); ?>
          <div class="swiper-slide" style="background-image:url(<?php echo esc_url( $room_images_url ) ?>)">
              <a href="<?php echo esc_url( $room_images_url ) ?>"></a>
              <img src="<?php echo get_the_post_thumbnail_url('', 'eagle_booking_image_size_1170_680')  ?>" alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?>" title="<?php echo get_the_title( $attachment_id ) ?>" height="0" width="0">
          </div>
        <?php endforeach ?>
      </div>
      <?php if ( eb_get_option('eb_room_slider_nav') == true ) : ?>
        <div class="swiper-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
        <div class="swiper-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
      <?php endif ?>
  </div>

</div>

<div class="room-slider-thumbs">
  <div id="eb-room-slider-thumbs" class="swiper-container">
        <div class="swiper-wrapper">
            <?php
              $files = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_slider_images', true );
              foreach ( (array) $files as $attachment_id => $attachment_url ) :
                $room_images_url = wp_get_attachment_image_url( $attachment_id, 'eagle_booking_image_size_1170_680' ); ?>
                <div class="swiper-slide" style="background-image:url(<?php echo esc_url( $room_images_url ) ?>)"></div>
              <?php endforeach ?>
        </div>
    </div>
  </div>

<?php else : ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure>
        <img src="<?php echo get_the_post_thumbnail_url('', 'eagle_booking_image_size_1170_680')  ?>" class="img-responsive" alt="<?php echo the_title() ?>">
      </figure>
    <?php endif ?>

<?php endif ?>