<?php
/*-----------------------------------------------------------------------------------*/
/*	SOCIAL MEDIA
/*-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_social_media') ) {
	function eagle_social_media($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'zante_social_media_facebook'       => '',
			'zante_social_media_twitter'       => '',
			'zante_social_media_pinterest'       => '',
			'zante_social_media_linkedin'       => '',
			'zante_social_media_youtube'       => '',
			'zante_social_media_instagram'       => '',
		), $atts));

		ob_start();
		?>
    <div class="social_media">
      <?php if ( !empty( $zante_social_media_facebook ) ) : ?>
        <a class="facebook" href="<?php echo esc_url($zante_social_media_facebook) ?>"><i class="fa fa-facebook"></i></a>
      <?php endif ?>
      <?php if ( !empty( $zante_social_media_twitter ) ) : ?>
        <a class="twitter" href="<?php echo esc_url($zante_social_media_twitter) ?>"><i class="fa fa-twitter"></i></a>
      <?php endif ?>
      <?php if ( !empty( $zante_social_media_pinterest ) ) : ?>
        <a class="pinterest" href="<?php echo esc_url($zante_social_media_pinterest) ?>"><i class="fa fa-pinterest"></i></a>
      <?php endif ?>
      <?php if ( !empty( $zante_social_media_linkedin ) ) : ?>
        <a class="linkedin" href="<?php echo esc_url($zante_social_media_linkedin) ?>"><i class="fa fa-linkedin"></i></a>
      <?php endif ?>
      <?php if ( !empty( $zante_social_media_youtube ) ) : ?>
        <a class="youtube" href="<?php echo esc_url($zante_social_media_youtube) ?>"><i class="fa fa-youtube"></i></a>
      <?php endif ?>
      <?php if ( !empty( $zante_social_media_instagram ) ) : ?>
        <a class="instagram" href="<?php echo esc_url($zante_social_media_instagram) ?>"><i class="fa fa-instagram"></i></a>
      <?php endif ?>
    </div>

		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('zante-social-media', 'eagle_social_media');
}
