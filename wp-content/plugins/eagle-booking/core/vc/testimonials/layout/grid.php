<?php
/*---------------------------------------------------------------------------------
TESTIMONIALS GRID
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_testimonials') ) {
    function eagle_testimonials($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'posts_limit' => '',
            'posts_per_row' => '',
            'offset' => '',
            'orderby' => '',
            'order' => '',
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

        <div class="row flex-row">
            <?php
            if ($testi_qry->have_posts()): while ($testi_qry->have_posts()): $testi_qry->the_post();

								$testimonial_title = get_the_title();
                $testimonial_quote = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_quote', true);
                $testimonial_name = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author', true);
                $testimonial_location = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author_location', true);
                $testimonial_avatar_file_id = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_image_id', true );
                $testimonial_avatar =  wp_get_attachment_image_url( $testimonial_avatar_file_id);
						 		$testimonial_starnumber = get_post_meta( get_the_ID(), 'eagle_booking_mtb_review_rating', true );

								$col_class = '4';
								if ($posts_per_row == '6') { $col_class = '2'; }
								if ($posts_per_row == '4') { $col_class = '3'; }
								if ($posts_per_row == '3') { $col_class = '4'; }
								if ($posts_per_row == '2') { $col_class = '6'; }
             ?>
								<!-- TESTIMONIAL GRID ITEM -->
                <div class="col-lg-<?php echo esc_attr( $col_class ); ?> col-sm-6 ">
                    <div class="testimonial-item">
		                  <div class="review">
		                        <h3><?php echo esc_html( $testimonial_title ) ?></h3>
                                <div class="rating">
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
		                        <p><?php echo esc_html( $testimonial_quote ) ?></p>
		                    </div>
		                    <div class="author">
                                <?php if ( $testimonial_avatar ) : ?>
                                    <img src="<?php echo esc_url( $testimonial_avatar ) ?>" alt="<?php echo esc_html( $testimonial_name ) ?>" width="80">
                                <?php endif ?>
		                        <div class="author-info">
		                            <h5><?php echo esc_html( $testimonial_name ) ?></h5>
		                            <span class="author-loacation"><?php echo esc_html( $testimonial_location ) ?></span>
		                        </div>
		                    </div>
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
    add_shortcode('zante-testimonials', 'eagle_testimonials');

    // New Shortcode
    add_shortcode('eb-testimonials', 'eagle_testimonials');

    add_shortcode('eb_testimonials', 'eagle_testimonials');
}
