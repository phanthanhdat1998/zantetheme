<?php
/**
 * The Template for displaying room reviews
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/reviews.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<?php

$eagle_booking_reviews_array = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_reviews', true );

if ( !empty($eagle_booking_reviews_array ) ) :
?>

<div class="room-reviews">
  <h2 class="section-title"><?php echo esc_html__('Room Reviews', 'eagle-booking') ?></h2>

    <?php
      for ($eagle_booking_reviews_array_i = 0; $eagle_booking_reviews_array_i < count($eagle_booking_reviews_array); $eagle_booking_reviews_array_i++) :

      $eagle_booking_page_by_path = get_post($eagle_booking_reviews_array[$eagle_booking_reviews_array_i], OBJECT,' eagle_reviews');
      $eagle_booking_review_id = $eagle_booking_page_by_path->ID;
      $testimonial_title = get_the_title($eagle_booking_review_id);
      $testimonial_quote = get_post_meta($eagle_booking_review_id, 'eagle_booking_mtb_review_quote', true);
      $testimonial_name = get_post_meta($eagle_booking_review_id, 'eagle_booking_mtb_review_author', true);
      $testimonial_location = get_post_meta($eagle_booking_review_id, 'eagle_booking_mtb_review_author_location', true);
      $testimonial_avatar_file_id = get_post_meta($eagle_booking_review_id, 'eagle_booking_mtb_review_image_id', true );
      $testimonial_avatar =  wp_get_attachment_image_url( $testimonial_avatar_file_id);
      $testimonial_starnumber = get_post_meta( $eagle_booking_review_id, 'eagle_booking_mtb_review_rating', true );
    ?>
    <!-- ITEM -->
    <div class="review-box">
      <?php if ($testimonial_avatar) : ?>
      <figure class="review-author">
        <img src="<?php echo esc_url( $testimonial_avatar ) ?>" alt="<?php echo esc_attr( $testimonial_name ) ?>">
      </figure>
      <?php endif ?>
      <div class="review-content">
        <div class="rating">
          <?php
              for($x=1;$x<=$testimonial_starnumber;$x++) {
                  echo '<i class="fa fa-star" aria-hidden="true"></i>';
              }
              if (strpos($testimonial_starnumber,'.')) {
                  echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                  $x++;
              }
              while ($x<=5) {
                  echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                  $x++;
              }
            ?>
        </div>
        <div class="review-info">
          <?php echo esc_html( $testimonial_name ) ?> - <?php echo esc_html( $testimonial_location ) ?>
        </div>
        <div class="review-text">
          <p><?php echo esc_html( $testimonial_quote ) ?></p>
        </div>
      </div>
    </div>

    <?php endfor ?>
    <?php wp_reset_postdata(); ?>

</div>
<?php endif ?>
