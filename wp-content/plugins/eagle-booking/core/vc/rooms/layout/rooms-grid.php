<?php
/*---------------------------------------------------------------------------------
ROOMS VC ELEMENT
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_rooms_grid') ) {

    function eagle_rooms_grid($atts, $content = null) {

        extract( shortcode_atts ( array(

          'branch_id' => '',
          'rooms_limit' => '5',
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
            'offset' => $offset,
        );

        /**
        * Sort by branch
        */
        if ( isset($branch_id) && $branch_id != '' && $branch_id != '0'  ) {

          $args['tax_query'][] = array(
            'taxonomy' => 'eagle_branch',
            'field' => 'term_id',
            'terms' => $branch_id,
          );
        }

        $eb_rooms_qry = new WP_Query($args);

        ?>

        <div class="eb-rooms-grid">

          <?php

          $eb_rooms_counter = 0;

          if ( $eb_rooms_qry->have_posts() ): while ( $eb_rooms_qry->have_posts() ): $eb_rooms_qry->the_post();

            $eb_room_id = get_the_ID();
            $eb_room_title = get_the_title();
            $eb_room_url = get_permalink();
            $eb_room_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
            $eb_room_price = eagle_booking_room_min_price($eb_room_id);

            $eb_rooms_counter++;

            /**
            * Add container class
            */
            if ( $eb_rooms_counter == 1 ) {

              $eb_rooms_columns_class = 'first';

            } else {

              $eb_rooms_columns_class = 'second';

            }

            $eb_room_item_class = '';

            /**
            * Add 'small' class to all items except the 1st one
            */
            if ( $eb_rooms_counter != 1 ) $eb_room_item_class .= 'small-item';

            /**
            * Open before 1st and on 2nd item
            */
            if ( $eb_rooms_counter == 1 || $eb_rooms_counter == 2 ) echo '<div class="'.$eb_rooms_columns_class.'-col">';


            /**
            * Include room grid
            */
            include eb_load_template('room-grid.php');

            /**
            * Close after 1st and 5th item
            */
            if ( $eb_rooms_counter == 1 || $eb_rooms_counter == 5 ) echo '</div>';

          ?>

          <?php endwhile; endif; wp_reset_postdata();

          ?>

        </div>

    <?php

    $result = ob_get_contents();
    ob_end_clean();
    return $result;

    }


    // Old shortcode
    add_shortcode('eagle-booking-rooms-grid', 'eagle_rooms_grid');


}
