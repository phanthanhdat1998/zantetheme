<?php
/*-----------------------------------------------------------------------------------*/
/*	SECTION TITLE
/*-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_restaurant_menu') ) {
	function eagle_restaurant_menu($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'restaurant_menu_title'       => '',
			'restaurant_menu_desc'    => '',
			'restaurant_menu_price' => '',
			'restaurant_menu_image'  => '',
		), $atts));

		ob_start();
		?>

		<?php $resturant_menu_url = wp_get_attachment_url( $restaurant_menu_image ); ?>

			<!-- RESTAURANT MENU ITEM -->
			<div class="restaurant-menu-item">
				<div class="row">
						<div class="col-lg-4 col-md-6">
							<figure>
								<img src="<?php echo esc_url( $resturant_menu_url ) ?>" class="img-responsive full_width" alt="<?php echo esc_html( $restaurant_menu_title ) ?>">
							</figure>
						</div>
						<div class="col-lg-8 col-md-6">
							<div class="info">
								<div class="title">
								<span class="name"><?php echo esc_html( $restaurant_menu_title ) ?></span>
									<span class="price">
									<span class="amount"><?php echo esc_html( $restaurant_menu_price ) ?></span>
									</span>
								</div>
								<p><?php echo esc_html( $restaurant_menu_desc ) ?></p>
							</div>
						</div>
				</div>
			</div>

		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('zante-restaurant-menu', 'eagle_restaurant_menu');
}
