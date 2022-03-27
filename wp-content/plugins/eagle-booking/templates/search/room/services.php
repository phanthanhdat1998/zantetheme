<?php
/**
 * The Template for displaying services
 * This template can be overridden by copying it to yourtheme/eb-templates/search/services.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<div class="room-services">
  <div class="dragscroll">
  <?php

  // Get Room Services
  $eagle_booking_services_array = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_services', true ) ;

  if ( !empty($eagle_booking_services_array) ) :

    $eagle_booking_services_counter = count($eagle_booking_services_array);

    if ( !empty(get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_services', true ) ) ) :

      for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < $eagle_booking_services_counter; $eagle_booking_services_array_i++) {

      $eagle_booking_page_by_path = get_post($eagle_booking_services_array[$eagle_booking_services_array_i],OBJECT,'eagle_services');

      $eagle_booking_service_id = $eagle_booking_page_by_path->ID;
      $eagle_booking_service_name = get_the_title($eagle_booking_service_id);
      $eagle_booking_service_icon_type = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon_type', true );

      // Fontawesome 4 or 5
      if ($eagle_booking_service_icon_type == 'fontawesome') {
        $eagle_booking_service_icon = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon_fontawesome', true );
      } else {
        $eagle_booking_service_icon = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon', true );
      }

      $eagle_booking_mtb_service_image = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_image', true );
      $eagle_booking_mtb_service_image_class_original = str_replace(' ', '-', $eagle_booking_service_name);
      $eagle_booking_mtb_service_image_class = strtolower($eagle_booking_mtb_service_image_class_original);
      $eagle_booking_service_description = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_description', true );
      ?>
      <div class="room-service-item" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $eagle_booking_service_description ?>" data-original-title="<?php echo $eagle_booking_service_name ?>">
      <?php if ($eagle_booking_service_icon_type == 'customicon') : ?>
        <img src="<?php echo esc_url($eagle_booking_mtb_service_image) ?>" class="<?php echo esc_attr($eagle_booking_mtb_service_image_class) ?>">
      <?php else : ?>
        <i class="<?php echo $eagle_booking_service_icon ?>"></i>
      <?php endif ?>
      </div>
      <?php  } ?>

    <?php  endif ?>
  <?php endif ?>

</div>
</div>
