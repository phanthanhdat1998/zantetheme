<?php
/*---------------------------------------------------------------------------------
GALLERY
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_image_gallery') ) {
    function eagle_image_gallery($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'image_gallery_images' => '',
            'image_gallery_action' => '',
            'image_gallery_per_row' => '',
        ), $atts));

        ob_start();
 ?>
           <?php
             $image_ids = explode(',', $image_gallery_images);

             $col_class = '4';
             if ($image_gallery_per_row == '6') { $col_class = '2'; }
             if ($image_gallery_per_row == '4') { $col_class = '3'; }
             if ($image_gallery_per_row == '3') { $col_class = '4'; }
             if ($image_gallery_per_row == '2') { $col_class = '6'; }
            ?>

            <div class="row">
	            <div class="image-gallery">

                   <?php
                   $image_no = 1;
                   foreach( $image_ids as $image_id ){
                  	$images = wp_get_attachment_image_src( $image_id, 'full' );
                  	$gallery_url = $images[0];
                    ?>

                    <!-- GALLERY ITEM -->
                    <div class="col-lg-<?php echo esc_attr( $col_class ) ?> col-sm-6">
                      <figure class="gradient-overlay-hover icon-zoom-hover zoom-image-hover">
                        <?php if ( $image_gallery_action != 'none' ) : ?>
                        <a href="<?php echo esc_url( $gallery_url ) ?>">
                          <img src="<?php echo esc_url( $gallery_url ) ?>" class="img-responsive">
                        </a>
                      <?php else: ?>
                        <img src="<?php echo esc_url( $gallery_url ) ?>" class="img-responsive">
                      <?php endif ?>
                      </figure>
                    </div>

                    <?php $image_no++;  } ?>

	                <?php wp_reset_postdata(); ?>
	            </div>
            </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-image-gallery', 'eagle_image_gallery');
} 
