<?php
/*-----------------------------------------------------------------------------------*/
/*	SECTION TITLE
/*-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_section_title') ) {
	function eagle_section_title($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'zante_section_title'       => '',
			'zante_section_subtitle'    => '',
			'zante_section_title_align' => '',
			'zante_section_title_wave'  => '',
			'zante_section_title_color' => ''
		), $atts));

		ob_start();
		?>
			<div
				class="main_title  <?php echo esc_attr($zante_section_title_align) . ' ' . esc_attr($zante_section_title_color) . ' ' . esc_attr($zante_section_title_wave); ?>">
				<h2 class="title"><?php echo esc_attr($zante_section_title); ?></h2>
				<?php if ( !empty( $zante_section_subtitle ) ) : ?>
					<p class="main_description"><?php echo esc_attr($zante_section_subtitle); ?></p>
				<?php endif ?>
			</div>
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('zante-section-title', 'eagle_section_title');
}
