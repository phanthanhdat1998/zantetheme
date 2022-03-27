<?php
/*---------------------------------------------------------------------------------
IMAGE
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_image') ) {
    function eagle_image($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'zante_image_front_image' => '',
            'zante_image_back_image' => '',
        ), $atts));

        ob_start();

      // get images
      $zante_image_front_image_src = wp_get_attachment_url( $zante_image_front_image );
      $zante_image_back_image_src = wp_get_attachment_url( $zante_image_back_image );

    ?>

        <div class="image-3d-effect">
          <div class="side left"></div>
          <div class="side right"></div>
          <div class="images">
            <?php if( !empty( $zante_image_front_image_src ) ) : ?>
            <div class="front-image" style="background-image: url(<?php echo $zante_image_front_image_src ?>)"></div>
            <?php endif ?>
            <?php if( !empty( $zante_image_back_image_src ) ) : ?>
            <div class="back-image" style="background-image: url(<?php echo $zante_image_back_image_src ?>)"></div>
            <?php endif ?>
          </div>
        </div>



        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-image', 'eagle_image');
}
