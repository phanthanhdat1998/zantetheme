<?php
/*---------------------------------------------------------------------------------
places
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_places_grid') ) {
    function eb_places_grid($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'places_filters' => '',
            'places_limit' => '',
            'places_per_row' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'eagle_places',
            'posts_per_page' => $places_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $places_qry = new WP_Query($args);
        ?>

            <div class="row">
	                <?php
	                if ($places_qry->have_posts()): while ($places_qry->have_posts()): $places_qry->the_post();
											$places_title = get_the_title();
											$places_url = get_permalink();
											$places_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');

											$col_class = '4';
											if ($places_per_row == '6') { $col_class = '2'; }
											if ($places_per_row == '4') { $col_class = '3'; }
											if ($places_per_row == '3') { $col_class = '4'; }
											if ($places_per_row == '2') { $col_class = '6'; }
											if ($places_per_row == '1') { $col_class = '12'; }
                   ?>
                      <!-- places ITEM -->
                      <div class="col-lg-<?php echo esc_attr( $col_class ) ?> col-sm-6">
                        <div class="place-item">
                        <figure class="gradient-overlay zoom-hover">
                          <a href="<?php echo esc_url( $places_url ) ?>">
                            <img src="<?php echo esc_url( $places_img_url ) ?>" class="img-responsive">
                            <div class="place-name">
                              <h3><?php echo esc_html( $places_title ) ?></h3>
                            </div>
                          </a>
                        </figure>
                      </div>
                    </div>

	                <?php endwhile; endif; ?>
	                <?php wp_reset_postdata(); ?>
            </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    // Depracated Shortcode
    add_shortcode('zante-places-grid', 'eb_places_grid');

    // New Shortcode
    add_shortcode('eb-places-grid', 'eb_places_grid');

}
