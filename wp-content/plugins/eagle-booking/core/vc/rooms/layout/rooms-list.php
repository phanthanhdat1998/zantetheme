<?php
/*---------------------------------------------------------------------------------
ROOMS VC ELEMENT
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_rooms_list') ) {
    function eagle_rooms_list($atts, $content = null) {
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

    <?php if ($rooms_qry->have_posts()): while ($rooms_qry->have_posts()) : $rooms_qry->the_post();

    // Default
    $eb_room_id = get_the_ID();
    $eb_room_title = get_the_title();
    $eb_room_url = get_permalink();
    $eb_room_image = get_the_post_thumbnail_url();

    // MTB
    $eb_room_price = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_price', true);
    $eb_room_header = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_header', true);
    $eagke_booking_room_sidebar = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_sidebar', true);
    $eb_room_similar = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_similar', true);
    $eb_room_description = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_description', true );
    ?>

    <?php

    /**
    * Include room grid
    */
    include eb_load_template('room-list.php');

    ?>

    <?php endwhile; endif; ?>

    <?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
    }

    add_shortcode('eagle-booking-rooms-list', 'eagle_rooms_list');

    }
