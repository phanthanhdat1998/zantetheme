<?php
/**
 * The Template for displaying room additional services
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/additional-services.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;


$eb_additional_services_array = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_additional_services', true );

if ( $eb_additional_services_array ) :

?>

<div class="room-services-list">
  <h2 class="section-title"><?php echo esc_html__('Additional Services', 'eagle-booking') ?></h2>
  <div class="eb-g-3 -2">
    <?php

    // START LOOP
    for ($eb_additional_services_array_i = 0; $eb_additional_services_array_i < count($eb_additional_services_array); $eb_additional_services_array_i++) :
    $eagle_booking_page_by_path = get_post($eb_additional_services_array[$eb_additional_services_array_i],OBJECT,'eagle_services');
    $eb_additional_service_id = $eagle_booking_page_by_path->ID;
    $eb_additional_service_name = get_the_title($eb_additional_service_id);

    // FONT ICON & CUSTOM IMAGE
    $eb_additional_service_icon_type = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_icon_type', true );
    if ($eb_additional_service_icon_type == 'fontawesome') {
      $eb_additional_service_icon = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_icon_fontawesome', true );
    } else {
      $eb_additional_service_icon = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_icon', true );
    }

    $eb_mtb_service_image = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_image', true );
    $eb_mtb_service_image_class_original = str_replace(' ', '-', $eb_additional_service_name);
    $eb_mtb_service_image_class = strtolower($eb_mtb_service_image_class_original);
    // DESCRIPTION
    $eb_additional_service_description = get_post_meta( $eb_additional_service_id, 'eagle_booking_mtb_service_description', true );
    ?>

    <div class="room-services-item">
      <?php if ($eb_additional_service_icon_type == 'customicon') : ?>
        <img src="<?php echo esc_url($eb_mtb_service_image) ?>" class="<?php echo esc_attr($eb_mtb_service_image_class) ?>">
      <?php else : ?>
        <i class="<?php echo $eb_additional_service_icon ?>" data-original-title="<?php echo $eb_additional_service_name ?>"></i>
      <?php endif ?>
      <?php echo esc_html($eb_additional_service_name) ?>
    </div>
    <?php  endfor ?>
  </div>
</div>

<?php endif ?>
