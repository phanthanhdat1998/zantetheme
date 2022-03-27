<div class="eb-widget eb-services scroll">
  <h2 class="title"><?php echo __('Included Services','eagle-booking') ?> </h2>
  <div class="inner">
      <?php
        // SERVICES QRY
        $eagle_booking_services_args = array(
            'posts_per_page' => -1,
            'post_type'=> 'eagle_services',
            'meta_query' => array(
                array(
                    'key'     => 'eagle_booking_mtb_service_type',
                    'value'   => 'normal',
                    'compare' => '=',
                )
            )
        );
        $eagle_booking_services_query = new WP_Query( $eagle_booking_services_args );
        ?>
        <?php while ( $eagle_booking_services_query->have_posts() ) : $eagle_booking_services_query->the_post(); ?>
            <div class="service">
              <input type="checkbox" id="<?php echo get_the_ID() ?>" class="eb_normal_service" value="<?php echo get_the_ID() ?>,">
              <label for="<?php echo get_the_ID() ?>"> <?php echo get_the_title() ?></label>
            </div>
        <?php endwhile; wp_reset_postdata();  ?>
        <input type="hidden" id="eb_normal_services" value="">
  </div>
</div>
