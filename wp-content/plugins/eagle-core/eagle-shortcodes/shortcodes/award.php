<?php
/*---------------------------------------------------------------------------------
AWARD
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_award') ) {
    function eagle_award($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'zante_award_image' => '',
            'zante_award_text' => '',
        ), $atts));

        ob_start();

      // get images
      $zante_award_image_src = wp_get_attachment_url( $zante_award_image );
    ?>

            <div class="award-item">
              <figure>
                <img src="<?php echo esc_url( $zante_award_image_src ) ?>" class="img-fluid" alt="Award">
                <figcaption>
                  <?php echo esc_html( $zante_award_text ) ?>
                </figcaption>
              </figure>
            </div>


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-award', 'eagle_award');
} 
