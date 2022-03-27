<div class="eb-widget eb-additional-services scroll">
  <h2 class="title"><?php echo __('Additional Services','eagle-booking') ?></h2>
  <div class="inner">
        <?php
        // ADDITIONAL SERVICES QRY
        $eagle_booking_additional_services_args = array(
            'posts_per_page' => -1,
            'post_type'=> 'eagle_services',
            'meta_query' => array(
                array(
                    'key'     => 'eagle_booking_mtb_service_type',
                    'value'   => 'additional',
                    'compare' => '=',
                )
            )
        );
        $eagle_booking_additional_services_query = new WP_Query( $eagle_booking_additional_services_args );
        ?>
        <?php while ( $eagle_booking_additional_services_query->have_posts() ) : $eagle_booking_additional_services_query->the_post(); ?>
          <div class="service">
              <input id="<?php echo get_the_ID() ?>" class="eb_checkbox_additional_service" type="checkbox" value="<?php echo get_the_ID() ?>,">
            <label for="<?php echo get_the_ID() ?>" ><?php echo get_the_title() ?></label>
          </div>
        <?php endwhile; wp_reset_postdata();  ?>
        <input type="hidden" id="eb_additional_services" value="">

  </div>
</div>
