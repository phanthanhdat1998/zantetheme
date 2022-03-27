<?php
/*---------------------------------------------------------------------------------
ROOMS VC ELEMENT
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_rooms') ) {
    function eagle_rooms($atts, $content = null)
    {
        extract(shortcode_atts(array(

          'branch_id' => '',
          'rooms_limit' => '',
          'rooms_per_row' => '',
          'offset' => '',
          'orderby' => '',
          'order' => '',

        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'eagle_rooms',
            'posts_per_page' => $rooms_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );

        // Sort by branch
        if ( isset($branch_id) && $branch_id != '' && $branch_id != '0'  ) {

          $args['tax_query'][] = array(
            'taxonomy' => 'eagle_branch',
            'field' => 'term_id',
            'terms' => $branch_id,
          );

        }

        $rooms_qry = new WP_Query($args);

        ?>

            <div class="row flex-row">
	                <?php
	                if ($rooms_qry->have_posts()): while ($rooms_qry->have_posts()): $rooms_qry->the_post();
                      $eb_room_id = get_the_ID();
											$eb_room_title = get_the_title();
											$eb_room_url = get_permalink();
											$eb_room_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
                      $eb_room_price = eagle_booking_room_min_price($eb_room_id);

											$col_class = '4';
											if ($rooms_per_row == '6') { $col_class = '2'; }
											if ($rooms_per_row == '4') { $col_class = '3'; }
											if ($rooms_per_row == '3') { $col_class = '4'; }
											if ($rooms_per_row == '2') { $col_class = '6'; }
											if ($rooms_per_row == '1') { $col_class = '12'; }
                   ?>
                      <!-- Room Item -->
                      <div class="col-lg-<?php echo esc_attr( $col_class ) ?> col-sm-6">

                      <?php

                        /**
                        * Include room grid
                        */
                        include eb_load_template('room-grid.php');

                      ?>

                    </div>
	                <?php endwhile; endif; ?>
	                <?php wp_reset_postdata(); ?>
            </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('eagle-booking-rooms', 'eagle_rooms');

}
