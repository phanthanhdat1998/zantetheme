<?php
/**
 * The Template for displaying room similar rooms
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/similar-rooms.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<?php
$args = array(
    'post_type' => 'eagle_rooms',
    'post__not_in' => array( $eagle_booking_id ),
    'posts_per_page' => 3,
    'suppress_filters' => false
);
$similar_rooms_qry = new WP_Query($args);
?>

<div class="similar-rooms">
  <h2 class="section-title"><?php echo esc_html__('Similar Rooms', 'eagle-booking')?></h2>
  <div class="eb-g-3 eb-g-sm-1">
    <?php
    if ( $similar_rooms_qry->have_posts() ) : while ($similar_rooms_qry->have_posts()) : $similar_rooms_qry->the_post();
        $eagle_booking_room_id = get_the_id();
				$room_title = get_the_title();
        $room_thumbnail = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
        $room_url = get_permalink();
        $eagle_booking_room_price = eagle_booking_room_min_price($eagle_booking_room_id);
    ?>
        <div class="eb-col">
            <div class="similar-room-item" style="background-image: url('<?php echo $room_thumbnail ?>');">
              <a href="<?php echo esc_url( $room_url ) ?>">
                <div class="room-details">
                  <h4 class="room-title"><?php echo esc_html( $room_title ) ?> </h4>
                  <?php eb_room_price( get_the_ID(), ' / '.__('night', 'eagle-booking') ) ?>

                </div>
              </a>
            </div>
        </div>

      <?php endwhile; endif; ?>
      <?php wp_reset_postdata(); ?>
  </div>
</div>