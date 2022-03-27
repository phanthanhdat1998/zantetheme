<?php
/*---------------------------------------------------------------------------------
COUNT UP
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_countup') ) {
    function eagle_countup($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'zante_countup_image' => '',
            'zante_countup_number' => '',
            'zante_countup_text' => '',
        ), $atts));

        ob_start();

      // get images
      $zante_countup_image_src = wp_get_attachment_url( $zante_countup_image );
    ?>

          <div class="countup-item">
            <img draggable="false" src="<?php echo $zante_countup_image_src ?>">
            <span class="number" data-count="<?php echo esc_html( $zante_countup_number ) ?>"><?php echo esc_html( $zante_countup_number ) ?></span>
            <div class="text"><?php echo esc_html( $zante_countup_text ) ?></div>
          </div>


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-countup', 'eagle_countup');
} 
