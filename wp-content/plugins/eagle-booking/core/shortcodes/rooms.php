<?php
/*---------------------------------------------------------------------------------
* Eagle Booking Rooms Shortcodes
* Since: 1.3.2
* Modified: 1.3.3
* Author: Eagle Themes
* Shortcode: [eb_rooms]
* Parameters: view, branch_id, items, items_per_row, items_per_view, order_by, offset
* View: Normal, Grid, List, Carousel
-----------------------------------------------------------------------------------*/
if ( !function_exists('eb_rooms_shortcode') ) {

  function eb_rooms_shortcode($atts, $content = null) {

    extract( shortcode_atts ( array(
      'view' => '', // Normal, Grid, List, Carousel
      'branch_id' => '',
      'items' => '5',
      'items_per_row' => '', // Only for Normal
      'items_per_view' => '', // Only for Carousel
      'carousel_nav' => '', // Only for Carousel default: true
      'offset' => '',
      'orderby' => '',
      'order' => '',

    ), $atts));

    ob_start();

    $args = array(
        'post_type' => 'eagle_rooms',
        'posts_per_page' => $items,
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

    /**
    * Rooms Layout View
    */
    switch ($view) {

      case 'normal':

        $eb_rooms_room_view = 'grid';
        $eb_rooms_view_class = 'normal'.' items-per-row-'.$items_per_row;

        break;

      case 'grid':

        $eb_rooms_room_view = 'grid';
        $eb_rooms_view_class = 'grid';

        break;

      case 'list':

        $eb_rooms_room_view = 'list';
        $eb_rooms_view_class = 'list';

        break;

      default:

        $eb_rooms_room_view = 'grid';
        $eb_rooms_view_class = 'carousel'. ' owl-carousel ' .wp_generate_password(5, false, false);

        break;
    }

    ?>

    <?php

    /**
    * Load Carousel Script
    */
    if ( $view == 'carousel' ) :

    ?>

      <script>
          jQuery(document).ready(function ($) {
              jQuery(function($) {
              var owl = $('.eb-rooms-carousel <?php wp_generate_password(5, false, false) ?>');
              owl.owlCarousel({
                loop: false,
                margin: 30,
                nav: <?php if ( $carousel_nav != '' && $carousel_nav == 'false' ) { echo 'false'; } else { echo 'true'; } ?>,
                dots: false,
                navText: [
                  "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                  "<i class='fa fa-angle-right' aria-hidden='true'></i>"
                ],
                responsive: {

                  0: {
                    items: 1
                  },

                  480: {
                    items: 2
                  },

                  768: {
                    items: 3
                  },

                  992: {
                    items: <?php echo $items_per_view ? $items_per_view : '4' ?>
                  }
                }

              });

              });
          });
        </script>

    <?php endif; ?>

    <?php

    if ( $view == 'grid' && $eb_rooms_qry->found_posts < 5 ) {

      if( current_user_can('administrator') ) {

        echo "<div class='eb-alert eb-alert-error eb-alert-admin-only eb-alert-icon'>";
        echo __('The selected style requires at least 5 items', 'eagle-booking' );
        echo "</div>";

      }

    } else {

    ?>
    <div class="eb-rooms-<?php echo $eb_rooms_view_class ?>">

      <?php

        $eb_rooms_counter = 0;

        if ( $eb_rooms_qry->have_posts() ): while ( $eb_rooms_qry->have_posts() ): $eb_rooms_qry->the_post();

          $eb_room_id = get_the_ID();
          $eb_room_title = get_the_title();
          $eb_room_url = get_permalink();
          $eb_room_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
          $eb_room_price = eagle_booking_room_min_price($eb_room_id);
          $eb_room_description = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_description', true );

          $eb_rooms_counter++;

          /**
          * Add container class
          */
          if ( $eb_rooms_counter == 1 ) {

            $eb_rooms_columns_class = 'first';

          } else {

            $eb_rooms_columns_class = 'second';

          }

          /**
          * Add 'small' class to all items except the 1st one
          */
          $eb_room_item_class = '';

          if ( $view == 'grid' && $eb_rooms_counter != 1 ) $eb_room_item_class .= 'small-item';

          /**
          * Open before 1st and on 2nd item
          */
          if ( $view == 'grid' && ( $eb_rooms_counter == 1 || $eb_rooms_counter == 2 ) ) echo '<div class="'.$eb_rooms_columns_class.'-col">';


          /**
          * Include room grid
          */
          include eb_load_template('room-'.$eb_rooms_room_view.'.php');


          /**
          * Close after 1st and 5th item
          */
          if ( $view == 'grid' && ( $eb_rooms_counter == 1 || $eb_rooms_counter == 5 ) ) { echo '</div>'; }

          /**
          * End loop and reset it
          */
          endwhile; endif; wp_reset_postdata();

        ?>

      </div>

    <?php

    }

    $result = ob_get_contents();
    ob_end_clean();
    return $result;

  }

  add_shortcode('eb_rooms', 'eb_rooms_shortcode');

}
