<?php
/*---------------------------------------------------------------------------------
GALLERY
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_gallery') ) {
    function eagle_gallery($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'gallery_filters' => '',
            'gallery_details' => '',
            'gallery_limit' => '',
            'gallery_per_row' => '',
            'offset' => '',
            'orderby' => '',
            'order' => '',
        ), $atts));

        ob_start();


        $args = array(
            'post_type' => 'eagle_gallery',
            'posts_per_page' => $gallery_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $gallery_qry = new WP_Query($args);
        ?>
        <?php if ($gallery_filters == 'filters') { ?>
          <div class="grid_filters">
              <a href="#" data-filter="*" class="button btn_sm btn_blue active"><?php echo esc_html__('All', 'eagle') ?></a>
              <?php
               $terms = get_terms('eagle_gallery_category');
               foreach ($terms as $term) :
              ?>
              <a href="#" data-filter=".<?php echo esc_attr($term->slug); ?>" class="button btn_sm btn_blue"><?php echo esc_html( $term->name ); ?></a>
              <?php endforeach; ?>
            </div>

        <?php } ?>

            <div class="row">
	            <div class="grid gallery_items image-gallery">
	                <?php
	                if ($gallery_qry->have_posts()): while ($gallery_qry->have_posts()): $gallery_qry->the_post();
                      $gallery_title = get_the_title();
                      $gallery_thumb_url = get_the_post_thumbnail_url('', '');
                      $gallery_url = get_the_post_thumbnail_url();

                      $gallery_more_link = get_post_type_archive_link( 'eagle_gallery' );
                      $terms = get_the_terms(get_the_id(), 'eagle_gallery_category');
                      $term_slug = array();
                      $term_name = array();
                      if (is_array($terms) || is_object($terms)) {
                        foreach ($terms as $term) {
                          $term_slug[] = $term->slug;
                          $term_name[] = $term->name;
                        }
                      }
											$col_class = '4';
											if ($gallery_per_row == '6') { $col_class = '2'; }
											if ($gallery_per_row == '4') { $col_class = '3'; }
											if ($gallery_per_row == '3') { $col_class = '4'; }
											if ($gallery_per_row == '2') { $col_class = '6'; }
                   ?>
                      <!-- GALLERY ITEM -->
                      <div class="col-lg-<?php echo esc_attr( $col_class ) ?> col-sm-6 g_item <?php echo join( " ", $term_slug) ?>">
                        <div class="gallery-item">
                          <figure class="gradient-overlay-hover icon-zoom-hover zoom-image-hover">
                            <a href="<?php echo esc_url( $gallery_url ) ?>">
                              <img src="<?php echo esc_url( $gallery_thumb_url ) ?>" class="img-responsive" alt="<?php echo esc_html( $gallery_title ) ?>">
                            </a>
                          </figure>
                          <?php if ( $gallery_details ) : ?>
                          <div class="details">
                              <h5><?php echo esc_html( $gallery_title ) ?></h5>
                          </div>
                        <?php endif ?>
                        </div>
                      </div>

	                <?php endwhile; endif; ?>
	                <?php wp_reset_postdata(); ?>
	            </div>
            </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-gallery', 'eagle_gallery');
}
