<?php
/*---------------------------------------------------------------------------------
ROOMS CAROUSEL VC ELEMENT
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_rooms_carousel') ) {
    function eagle_rooms_carousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'branch_id' => '',
            'rooms_limit' => '',
            'rooms_per_view' => '',
            'gallery_carousel_nav' => '',
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

        <?php
          $token = wp_generate_password(5, false, false);
        ?>

        <script>
          jQuery(document).ready(function ($) {
            function gallery_carousel() {
              $('#rooms-carousel-<?php echo esc_attr( $token ); ?>').owlCarousel({
                loop: false,
                margin: 30,
                <?php if( $gallery_carousel_nav == true) : ?>
                nav: true,
                <?php endif ?>
                navText: [
                 "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                 "<i class='fa fa-angle-right' aria-hidden='true'></i>"
                ],

                responsiveClass:true,
                responsive:{

                    0:{
                        items: 1,
                        nav: false
                    },

                    600:{
                        items: 2,
                        nav: true
                    },

                    1000:{
                        items: <?php echo esc_attr( $rooms_per_view ); ?>,
                        nav: true,
                    }
                }

              });
          }
          setTimeout(gallery_carousel, 1)
          });
        </script>

         <div id="rooms-carousel-<?php echo esc_attr( $token ); ?>" class="rooms-carousel owl-carousel">
             <?php
             if ($rooms_qry->have_posts()): while ($rooms_qry->have_posts()): $rooms_qry->the_post();

               $eb_room_id = get_the_ID();
               $eb_room_title = get_the_title();
               $eb_room_url = get_permalink();
               $eb_room_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
               $eb_room_price = eagle_booking_room_min_price($eb_room_id);

               ?>

              <?php

             /**
            * Include room grid
            */
            include eb_load_template('room-grid.php');

            ?>

             <?php endwhile; endif; ?>
             <?php wp_reset_postdata(); ?>
         </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('eagle-booking-rooms-carousel', 'eagle_rooms_carousel');
}
