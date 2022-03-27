<?php
/*---------------------------------------------------------------------------------
SERVICES GRID
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_room_services') ) {
    function eagle_room_services($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'posts_limit' => '',
            'posts_per_row' => '',
            'offset' => '',
            'orderby' => '',
            'order' => '',
            'type' => '',
        ), $atts));

        ob_start();

        if ( $type === 'all' || $type === '' ) $type = array ( 'normal', 'additional' );

        $args = array(
            'post_type' => 'eagle_services',
            'posts_per_page' => $posts_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset,

            'meta_query'=> array(

              array(
                  'key' => 'eagle_booking_mtb_service_type',
                  'compare' => 'IN',
                  'value' => $type,
              )
            )

        );

        $service_qry = new WP_Query($args);

        ?>


        <div class="room-services-list room-services-list-page">
          <div class="row">
            <?php
            if ($service_qry->have_posts()): while ($service_qry->have_posts()): $service_qry->the_post();

              $eagle_booking_service_id = get_the_ID();
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

								$col_class = '4';
								if ($posts_per_row == '6') { $col_class = '2'; }
								if ($posts_per_row == '4') { $col_class = '3'; }
								if ($posts_per_row == '3') { $col_class = '4'; }
                if ($posts_per_row == '2') { $col_class = '6'; }

             ?>
								<!-- SERVICE GRID ITEM -->
                <div class="col-lg-<?php echo esc_attr( $col_class ) ?>">
                  <div class="room-services-item">
                    <?php if ($eagle_booking_service_icon_type == 'customicon') : ?>
                      <img src="<?php echo esc_url($eagle_booking_mtb_service_image) ?>" class="<?php echo esc_attr($eagle_booking_mtb_service_image_class) ?>">
                    <?php else : ?>
                      <i class="<?php echo $eagle_booking_service_icon ?>"></i>
                    <?php endif ?>
                    <?php echo esc_html($eagle_booking_service_name) ?>
                  </div>
                </div>

            <?php endwhile; endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    // Depracated Shortcode
    add_shortcode('zante-room-services', 'eagle_room_services');

    // New Shortcode
    add_shortcode('eb-services', 'eagle_room_services');

    add_shortcode('eb_services', 'eagle_room_services');
}
