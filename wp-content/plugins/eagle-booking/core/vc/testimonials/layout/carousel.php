<?php
/*---------------------------------------------------------------------------------
TESTIMONIALS CAROUSEL
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_testimonials_carousel') ) {
    function eagle_testimonials_carousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'posts_limit' => '',
            'posts_per_row' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'eagle_reviews',
            'posts_per_page' => $posts_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $testi_qry = new WP_Query($args);
        ?>

        <?php
            $token = wp_generate_password(5, false, false); 
        ?>

        <script>
          jQuery(document).ready(function ($) {
            $('#testimonial-carousel-<?php echo esc_attr( $token ); ?>').owlCarousel({
              loop: true,
              margin: 10,
              items: 1,
              nav: false,
            });
           });
        </script>

				<!-- TESTIMONIAL SLIDE ITEM -->
        <div id="testimonial-carousel-<?php echo esc_attr( $token ); ?>" class="testimonials-slider owl-carousel">
            <?php
            if ($testi_qry->have_posts()): while ($testi_qry->have_posts()) : $testi_qry->the_post();
								$testimonial_title = get_the_title();
                $testimonial_quote = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_quote', true);
                $testimonial_name = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author', true);
                $testimonial_location = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author_location', true);
                $testimonial_avatar_file_id = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_image_id', true );
                $testimonial_avatar =  wp_get_attachment_image_url( $testimonial_avatar_file_id);
						 		$testimonial_starnumber = get_post_meta( get_the_ID(), 'eagle_booking_mtb_review_rating', true );
                ?>
                <div class="item">
                    <?php if ( $testimonial_avatar ) : ?>
                        <img src="<?php echo esc_url( $testimonial_avatar ) ?>" alt="<?php echo esc_html( $testimonial_name ) ?>" width="80">
                    <?php endif ?>
                    <div class="review_content">
                        <p><?php echo esc_html( $testimonial_quote ) ?></p>
                        <div class="review_rating">
                          <?php
                              for($x=1;$x<=$testimonial_starnumber;$x++) {
                                  echo '<i class="fa fa-star" aria-hidden="true"></i>';
                              }
                              if (strpos($testimonial_starnumber,'.')) {
                                  echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                                  $x++;
                              }
                              while ($x<=5) {
                                  echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                  $x++;
                              }
                            ?>
                        </div>
                        <div class="review_author"><?php echo $testimonial_name ?> - <?php echo esc_html( $testimonial_location ) ?></div>
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
    add_shortcode('zante-testimonials-carousel', 'eagle_testimonials_carousel');

    // New Shortcode
    add_shortcode('eb-testimonials-carousel', 'eagle_testimonials_carousel');
}
