<?php
/*---------------------------------------------------------------------------------
VC Places
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_places') ) {
    function eb_places($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'eagle_places',
            'posts_per_page' => 4,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $places_qry = new WP_Query($args);
        ?>

  <div class="row">

    <?php

    // Counter
    $eb_places_counter = '0';

    // Start Loop
		if ($places_qry->have_posts()): while ($places_qry->have_posts()): $places_qry->the_post();

			$eb_place_id = get_the_ID();
			$eb_place_title = get_the_title();
			$eb_place_url = get_permalink();
      $eb_place_img = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');

      // Counter
      $eb_places_counter++;

      // Item Class
      if ( $eb_places_counter == 1 ) {

        $eb_place_class = 'first-place';

      } elseif($eb_places_counter == 2) {

        $eb_place_class = 'second-place';

      } elseif($eb_places_counter == 3) {

        $eb_place_class = 'third-place';

      } else {
        $eb_place_class = 'fourth-place';
      }

		?>

      <?php if ( $eb_places_counter == 3) : ?>
        <div class="col-lg-6">
          <div class="row">
      <?php endif ?>

          <div class="col-md-6 <?php echo esc_attr($eb_place_class) ?>">
            <div class="place-item">
              <figure class="gradient-overlay zoom-hover">
                <a href="<?php echo esc_url( $eb_place_url ) ?>">
                  <img src="<?php echo esc_url( $eb_place_img ) ?>" class="img-responsive" alt="<?php echo esc_html( $eb_place_title ) ?>">

                    <h3 class="place-title"><?php echo esc_html( $eb_place_title ) ?></h3>

                </a>
              </figure>
            </div>
          </div>

      <?php if ( $eb_places_counter == 4) : ?>
          </div>
        </div>
      <?php endif ?>

		<?php endwhile; endif; ?>

  </div>

    <?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

    // Depracated Shortcode
    add_shortcode('zante-places', 'eb_places');

    // New Shortcode
    add_shortcode('eb-places', 'eb_places');

    add_shortcode('eb_places', 'eb_places');
}
