<?php
/*---------------------------------------------------------------------------------
TESTIMONIALS GRID
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_video') ) {
    function eagle_video($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'video_url' => '',
        ), $atts));

        ob_start();

        ?>

        <div class="video_popup">
            <a class="popup-vimeo" href="<?php echo esc_url ( $video_url ) ?>"><i class="las la-play"></i></a>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-video', 'eagle_video');
}
