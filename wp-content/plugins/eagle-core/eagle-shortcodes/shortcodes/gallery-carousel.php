<?php
/*---------------------------------------------------------------------------------
Gallery
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_gallery_carousel') ) {
    function eagle_gallery_carousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'gallery_carousel_limit' => '',
            'gallery_carousel_per_view' => '',
            'gallery_carousel_details' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'eagle_gallery',
            'posts_per_page' => $gallery_carousel_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $gallery_qry = new WP_Query($args);
        ?>

				<?php
				$token = wp_generate_password(5, false, false);
				if (is_rtl()) {
						$zante_rtl = "true";
				} else {
						$zante_rtl = "false";
				}
				?>

        <script>
          jQuery(document).ready(function ($) {
            function gallery_carousel() {
              $('#gallery-carousel-<?php echo esc_attr( $token ); ?>').owlCarousel({
                rtl: <?php echo esc_attr( $zante_rtl ); ?>,
                loop: false,
                margin: 0,
                nav: false,
                autoplay: true,
                responsive:{
                   0:{
                       items: 1
                   },
                   600:{
                       items: 3
                   },
                   1200:{
                       items:<?php echo esc_attr( $gallery_carousel_per_view ); ?>
                   }
                 }
              });
          }
          setTimeout(gallery_carousel, 1)
          });
        </script>


				<div id="gallery-carousel-<?php echo esc_attr( $token ); ?>" class="gallery-slider image-gallery owl-carousel">
						<?php
						if ($gallery_qry->have_posts()): while ($gallery_qry->have_posts()): $gallery_qry->the_post();
								$gallery_title = get_the_title();
								$gallery_thumb_url = get_the_post_thumbnail_url('', 'zante_image_size_480_480');
								$gallery_url = get_the_post_thumbnail_url();
								?>
								<!-- TESTIMONIAL SLIDE ITEM -->
								<div class="item">
                  <figure class="gradient-overlay-hover icon-zoom-hover zoom-image-hover">
										<a href="<?php echo esc_url( $gallery_url ) ?>">
												<img src="<?php echo esc_url( $gallery_thumb_url ) ?>" alt="<?php echo esc_html( $gallery_title ) ?>">
										</a>
                  </figure>
                    <?php if ( $gallery_carousel_details ) : ?>
                      <div class="gallery_item_info">
  												<h4><?php echo esc_html( $gallery_title ) ?></h4>
  										</div>
                  <?php endif ?>
								</div>

						<?php endwhile; endif; ?>
						<?php wp_reset_postdata(); ?>
				</div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-gallery-carousel', 'eagle_gallery_carousel');
} 
