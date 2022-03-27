<?php
/**
 * The Template for displaying room info
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/info.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.
 */

defined('ABSPATH') || exit;
?>

<div class="room-info">

<?php $eb_room_info_elements = eb_get_option('room_info_elements');

foreach ($eb_room_info_elements as $eb_room_info_element=>$value) {

  switch ($eb_room_info_element) {

    case 'guests' : if ($value == true) : ?>
    <div class="item">
      <i class="flaticon-child"></i>
      <div class="room-info-content">
        <?php echo __('Max. Guests', 'eagle-booking') ?>
        <div>
          <?php
          if (eb_get_option('eb_adults_children') == true) {
              echo esc_html($eb_mtb_room_max_adults).' '.__('Adults', 'eagle-booking').' / ' .esc_html($eb_mtb_room_max_children).' '.__('Children', 'eagle-booking');
          } else {
              echo esc_html($eb_mtb_room_max_guests).' '.__('Guests', 'eagle-booking');
          }
          ?>
        </div>
      </div>
    </div>
    <?php endif; break; ?>

    <?php case 'booking_nights' : if ($value == true) : ?>
    <div class="item">
      <i class="flaticon-calendar"></i>
      <div class="room-info-content">
        <?php echo __('Booking Nights', 'eagle-booking') ?>
        <div>
        <?php echo esc_html( $eb_mtb_room_min_booking_nights ) ?> <?php echo __('Min.', 'eagle-booking') ?>
        <?php if ( $eb_mtb_room_max_booking_nights != '' ) echo ' / '.esc_html( $eb_mtb_room_max_booking_nights ).' '. __('Max.', 'eagle-booking') ?>
        </div>
      </div>
    </div>
    <?php endif; break; ?>

    <?php case 'bed_type' : if ($value == true) : ?>
    <div class="item">
      <i class="flaticon-bed"></i>
      <div class="room-info-content">
        <?php echo __('Bed Type', 'eagle-booking')?>
        <div>
        <?php echo esc_html( $eb_mtb_room_bed_type ) ?>
        </div>
      </div>
    </div>
    <?php endif; break; ?>

    <?php case 'area' : if ($value == true) : ?>
    <div class="item">
      <i class="flaticon-map"></i>
      <div class="room-info-content">
        <?php echo __('Area', 'eagle-booking') ?>
        <div>
        <?php echo esc_html( $eb_mtb_room_size ) ?> <?php echo eb_get_option('eagle_booking_units_of_measure') ?>
        </div>
      </div>
    </div>
    <?php endif; break ?>

  <?php } } ?>

</div>