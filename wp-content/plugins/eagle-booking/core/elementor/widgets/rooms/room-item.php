<!-- GRID LAYOUT -->
<?php if ( $eagle_booking_rooms_counter !== 1 ) {
  $eagle_booking_small_col_class = 'small';
} else {
  $eagle_booking_small_col_class = '';
}
?>

<div class="room-grid-item <?php echo esc_attr( $eagle_booking_small_col_class ) ?>">
  <figure class="gradient-overlay-hover link-icon">
    <a href="<?php echo esc_url( $eagle_booking_room_url ) ?>">
        <img src="<?php echo esc_url( $eagle_booking_room_img_url ) ?>" class="img-responsive" alt="<?php echo esc_html( $eagle_booking_room_title ) ?>">
    </a>
    <!-- SERVICES -->
    <div class="room-services">
    <?php
    $eagle_booking_services_array = get_post_meta( $eagle_booking_room_id, 'eagle_booking_mtb_room_services', true ) ;
    $eagle_booking_services_counter = count($eagle_booking_services_array);

    if ($eagle_booking_services_counter >= '5') { $eagle_booking_services_counter = '5'; }

    if ( !empty(get_post_meta( $eagle_booking_room_id, 'eagle_booking_mtb_room_services', true ) ) ) :
    for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < $eagle_booking_services_counter; $eagle_booking_services_array_i++) :
      $eagle_booking_page_by_path = get_post($eagle_booking_services_array[$eagle_booking_services_array_i],OBJECT,'eagle_services');
      $eagle_booking_service_id = $eagle_booking_page_by_path->ID;
      $eagle_booking_service_name = get_the_title($eagle_booking_service_id);
      $eagle_booking_service_icon_type = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon_type', true );
      $eagle_booking_service_icon = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_icon', true );
      $eagle_booking_mtb_service_image = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_image', true );
      $eagle_booking_mtb_service_image_class_original = str_replace(' ', '-', $eagle_booking_service_name);
      $eagle_booking_mtb_service_image_class = strtolower($eagle_booking_mtb_service_image_class_original);
      $eagle_booking_service_description = get_post_meta( $eagle_booking_service_id, 'eagle_booking_mtb_service_description', true );
      ?>
      <div class="room-service-item" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="<?php echo $eagle_booking_service_description ?>" data-original-title="<?php echo $eagle_booking_service_name ?>">
      <?php if ($eagle_booking_service_icon_type == 'customicon') : ?>
        <img src="<?php echo esc_url($eagle_booking_mtb_service_image) ?>" class="<?php echo esc_attr($eagle_booking_mtb_service_image_class) ?>">
      <?php else : ?>
        <i class="<?php echo $eagle_booking_service_icon ?>"></i>
      <?php endif ?>
      </div>
    <?php  endfor ?>
    <?php  endif; ?>
    </div>
    <!-- ROOM PRICE -->
    <?php if ( $eagle_booking_room_price ) : ?>
    <div class="room-price">
     <span class="before-price"><?php echo esc_html(eb_get_option('eagle_booking_before_price')) ?></span>
    <?php if( eb_currency_position() == 'before') : ?>
      <?php echo eb_currency() ?><?php eb_formatted_price($eagle_booking_room_price) ?> <span>/ <?php echo esc_html__('night', 'eagle-booking') ?></span>
    <?php else: ?>
    <?php eb_formatted_price($eagle_booking_room_price) ?><?php echo eb_currency() ?> <span>/ <?php echo esc_html__('night', 'eagle-booking') ?></span>
    <?php endif ?>
    </div>
    <?php endif ?>
    </figure>
    <!-- ROOM INFO -->
    <div class="room-info">
      <h4 class="room-title"><a href="<?php echo esc_url( $eagle_booking_room_url ) ?>"><?php echo esc_html( $eagle_booking_room_title ) ?></a></h4>
    </div>
</div>
