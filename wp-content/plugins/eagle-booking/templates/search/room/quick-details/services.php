<?php
/**
 * The Template for displaying services
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/quick-details/services.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<?php

if ( eb_get_option('eb_search_quick_details_elements')['included_services'] == true ) :

  // Get Room Included Services
  $eagle_booking_services_array = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_services', true );

  if( $eagle_booking_services_array ) :

?>

  <div class="room-services-list">
    <h6 class="section-title"><?php echo esc_html__('Included Services', 'eagle-booking') ?></h6>
    <div class="eb-g-3 eb-g-m-2 mt30">
      <?php

        // Start Loop
        for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array); $eagle_booking_services_array_i++) {

          $eagle_booking_page_by_path = get_post($eagle_booking_services_array[$eagle_booking_services_array_i],OBJECT,'eagle_services');
          $eagle_booking_service_id = $eagle_booking_page_by_path->ID;
          $eagle_booking_service_name = get_the_title($eagle_booking_service_id);

          // Service Icon
          $eagle_booking_service_icon_type = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon_type', true );
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
        <div class="room-services-item">
          <?php if ($eagle_booking_service_icon_type == 'customicon') : ?>
            <img src="<?php echo esc_url($eagle_booking_mtb_service_image) ?>" class="<?php echo esc_attr($eagle_booking_mtb_service_image_class) ?>">
          <?php else : ?>
            <i class="<?php echo $eagle_booking_service_icon ?>"></i>
          <?php endif ?>
          <?php echo esc_html($eagle_booking_service_name) ?>
        </div>
        <?php } ?>
    </div>
  </div>

  <?php endif ?>
<?php endif ?>
