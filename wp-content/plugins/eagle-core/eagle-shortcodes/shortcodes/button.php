<?php
/*---------------------------------------------------------------------------------
BUTTON
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_shortcode_button') ) {
    function eagle_shortcode_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'eagle_button_text' => 'Button',
            'eagle_button_url' => '#',
            'eagle_button_target' => '_self',
            'eagle_button_before_text' => 'Button',
            'eagle_button_after_text' => 'Button',
            'eagle_button_icon' => '',
            'eagle_button_before_text' => '',
            'eagle_button_after_text' => '',
            'eagle_button_bg_color' => '#1dc1f8',
            'eagle_button_hover_bg_color' => '#2c88c0',
            'eagle_button_border_color' => '#1dc1f8',
            'eagle_button_hover_border_color' => '#2c88c0',
            'eagle_button_color' => '#ffffff',
            'eagle_button_hover_color' => '#ffffff',
            'eagle_button_icon_bg_color' => '#1dc1f8',
            'eagle_button_icon_hover_bg_color' => '#ffffff',
            'eagle_button_icon_color' => '#ffffff',
            'eagle_button_icon_hover_color' => '#1dc1f8',


            'eagle_button_top_bottom_padding' => '10',
            'eagle_button_left_right_padding' => '20',
            'eagle_button_border_width' => '2',
            'eagle_button_border_radius' => '2',
            'eagle_button_font_size' => '15',
            'eagle_button_width' => false,
            'eagle_button_box_shadow' => false,
            'eagle_button_box_shadow_hover' => false,
            'eagle_button_animation_hover' => false,
            'eagle_button_align' => 'left',
            'eagle_button_extra_class' => '',


        ), $atts));

        ob_start();

        ?>

        <?php $token = wp_generate_password(5, false, false); ?>

        <style>
				#btn-container-<?php echo esc_attr( $token ) ?> {
					font-size: <?php echo esc_html( $eagle_button_font_size ) ?>px;
					font-weight: bold;
				}
        #btn-<?php echo esc_attr( $token ) ?> {
        	background: <?php echo esc_html( $eagle_button_bg_color ) ?>;
					border-style: solid;
        	border-color: <?php echo esc_html( $eagle_button_border_color ) ?>;
					border-width: <?php echo esc_html( $eagle_button_border_width ) ?>px;
        	color: <?php echo esc_html( $eagle_button_color ) ?>;
					padding: <?php echo esc_html( $eagle_button_top_bottom_padding ) ?>px <?php echo esc_html( $eagle_button_left_right_padding ) ?>px;
					border-radius: <?php echo esc_html( $eagle_button_border_radius ) ?>px;
					font-size: <?php echo esc_html( $eagle_button_font_size ) ?>px;
					line-height: <?php echo esc_html( $eagle_button_font_size ) ?>px;
					<?php if ( $eagle_button_width == true ) : ?>
					width: 100%;
					<?php endif ?>
					<?php if ( $eagle_button_box_shadow == true ) : ?>
					box-shadow: 0 15px 30px rgba(0, 0, 0, 0.10);
					<?php endif ?>
					font-weight: bold;
        }

				#btn-<?php echo esc_attr( $token ) ?>:hover {
					background: <?php echo esc_html( $eagle_button_hover_bg_color ) ?>;
					border-color: <?php echo esc_html( $eagle_button_hover_border_color ) ?>;
					color: <?php echo esc_html( $eagle_button_hover_color ) ?>;
					<?php if ( $eagle_button_box_shadow_hover == true ) : ?>
					box-shadow: 0 15px 30px rgba(0, 0, 0, 0.10);
					<?php endif ?>
					<?php if ( $eagle_button_box_shadow == true && $eagle_button_box_shadow_hover == false ) : ?>
					box-shadow: none;
					<?php endif ?>
					<?php if ( $eagle_button_animation_hover == true ) : ?>
					-ms-transform: translateY(-2px);
					transform: translateY(-2px);
					-webkit-transform: translateY(-2px);
					<?php endif ?>

				}

		    #btn-<?php echo esc_attr( $token ) ?> i {
					right: 14px;
					margin-top: 0;
					vertical-align: middle;
					border-radius: 50%;
					line-height: 20px;
					height: 20px;
					width: 20px;
					background: <?php echo esc_html( $eagle_button_icon_bg_color ) ?>;
					margin-left: 8px;
					margin-right: 0;
					color: <?php echo esc_html( $eagle_button_icon_color ) ?>;
					font-size: 8px;
					text-align: center;
				}

				 #btn-<?php echo esc_attr( $token ) ?>:hover i {
				 	background: <?php echo esc_html( $eagle_button_icon_hover_bg_color ) ?>;
					color: <?php echo esc_html( $eagle_button_icon_hover_color ) ?>;
				 }

        </style>

		<!-- BUTTON -->
        <div id="btn-container-<?php echo esc_attr( $token ) ?>" class="text-<?php echo esc_attr( $eagle_button_align ) ?>">
			<?php if ($eagle_button_before_text) : ?>
			<span><?php echo esc_html( $eagle_button_before_text ) ?></span>
			  	<?php endif ?>

					<a href="<?php echo esc_url( $eagle_button_url ) ?>" id="btn-<?php echo esc_attr($token) ?>" class="btn <?php echo esc_attr( $eagle_button_extra_class ) ?>" target="<?php echo esc_html( $eagle_button_target ) ?>">
						<?php echo esc_html( $eagle_button_text ) ?>
						<?php if (!empty( $eagle_button_icon )) : ?>
						<i class="fa <?php echo esc_attr( $eagle_button_icon ) ?>"></i>
						<?php endif ?>
					</a>
					<?php if ($eagle_button_after_text) : ?>
					<span><?php echo esc_html( $eagle_button_after_text ) ?></span>
			<?php endif ?>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('eagle-shortcode-button', 'eagle_shortcode_button');
}
