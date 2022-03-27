<?php
namespace ElementorEagleThemes\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor Places
* Author: Eagle Themes (Jomin Muskaj)
* Since: 1.0.0s
---------------------------------------------------------------------------*/
class Places extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'places';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'Places', 'eagle' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'fas fa-image';
	}

	/* Retrieve the list of categories the widget belongs to.*/
	public function get_categories() {
		return [ 'eaglebooking' ];
	}

	/*Retrieve the list of scripts the widget depended on. */
	public function get_script_depends() {
		return [ 'core-js', 'core-css' ];
	}

	/* Register the widget controls. */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Settings', 'eagle-booking' ),
			]
		);

		// Style
		$this->add_control(
			'places_style',
			[
				'label' => __( 'Style', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => __( 'Normal', 'eagle' ),
					'grid'  => __( 'Grid', 'eagle' ),
					'carousel'  => __( 'Carousel', 'eagle' ),
				],
			]
		);


		// Gradient Overlay
		$this->add_control(
			'places_gradient_overlay',
			[
				'label' => __( 'Gradient Overlay', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle' ),
				'label_off' => __( 'Hide', 'eagle' ),
				'return_value' => 'true',
				'default' => true,
			]
		);

		// Items to Display
		$this->add_control(
			'places_items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
			]
		);


		// Items per Row
		$this->add_control(
			'places_items_per_row',
			[
				'label' => __( 'Items per Row', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1'  => __( '1', 'eagle' ),
					'2'  => __( '2', 'eagle' ),
					'3'  => __( '3', 'eagle' ),
					'4'  => __( '4', 'eagle' ),
					'6'  => __( '6', 'eagle' ),
					'12'  => __( '12', 'eagle' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'places_style',
							'operator' => 'in',
							'value' => [
								'grid',
							],
						],
					],
				],
			]
		);

		// Items per View (Carousel)
		$this->add_control(
			'places_items_per_view',
			[
				'label' => __( 'Items per View', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '3',
				'conditions' => [
					'terms' => [
						[
							'name' => 'places_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);


				// Order By
				$this->add_control(
					'places_order_by',
					[
						'label' => __( 'Order By', 'eagle-booking' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'ID',
						'options' => [
							'none'  => __( 'None', 'eagle' ),
							'ID'  => __( 'ID', 'eagle' ),
							'title'  => __( 'Title', 'eagle' ),
							'date'  => __( 'Date', 'eagle' ),
							'rand'  => __( 'Random', 'eagle' ),
							'menu_order'  => __( 'Menu Order', 'eagle' ),
						],
					]
				);

				// Order
				$this->add_control(
					'places_order',
					[
						'label' => __( 'Order', 'eagle-booking' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'ASC',
						'options' => [
							'ASC'  => __( 'ASC', 'eagle' ),
							'DESC'  => __( 'DESC', 'eagle' ),
						],
					]
				);

				// Offset
				$this->add_control(
					'places_offset',
					[
						'label' => __( 'Offset', 'eagle-booking' ),
						'type' => Controls_Manager::NUMBER,
						'default' => '',
					]
				);

		// Loop (Carousel)
		$this->add_control(
			'places_loop',
			[
				'label' => __( 'Loop', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'places_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		// Navigation (Carousel)
		$this->add_control(
			'places_navigation',
			[
				'label' => __( 'Navigation', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'places_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// Places QUERY
		$eagle_query_args = array(
			'post_type' => 'eagle_places',
			'posts_per_page' => $settings['places_items'],
			'orderby' => $settings['places_order_by'],
			'order' => $settings['places_order'],
			'offset' =>  $settings['places_offset'],
		);

		$eb_places_qry = new \WP_Query($eagle_query_args);
		$eagle_unique_token = wp_generate_password(5, false, false);

		?>

		<script>
			jQuery(document).ready(function ($) {
				// =============================================
				// Places - Owl Carousel
				// =============================================
				var owl = $('.places-owl');
				owl.owlCarousel({
				loop: false,
				margin: 30,
				nav: <?php echo $settings['places_navigation'] ? 'true' : 'false' ?>,
				dots: false,
				navText: [
					"<i class='fa fa-angle-left' aria-hidden='true'></i>",
					"<i class='fa fa-angle-right' aria-hidden='true'></i>"
				],
				responsive: {
					0: {
					items: 1
					},
					480: {
					items: 2
					},
					768: {
					items: 3
					},
					// 992: {
					//   items: <?php echo $settings['places_items_per_view'] ?>
					// }
				}
				});
			});
		</script>

		<?php

		// Places Column Class
		$eb_col_class = '4';
		if ($settings['places_items_per_row'] === '6') { $eb_col_class = '2'; }
		if ($settings['places_items_per_row'] === '4') { $eb_col_class = '3'; }
		if ($settings['places_items_per_row'] === '3') { $eb_col_class = '4'; }
		if ($settings['places_items_per_row'] === '2') { $eb_col_class = '6'; }

		// Places Container Class
		if ($settings['places_style'] === 'carousel') {
			$eb_places_container = 'places-owl owl-carousel';
			$eb_col_class = '';
			$eb_place_img_size = 'large';

		} elseif ($settings['places_style'] === 'normal') {
				$eb_places_container = 'row';
				$eb_col_class = 'col-lg-'.$eb_col_class;
				$eb_place_img_size = 'large';

		} else {
				$eb_places_container = 'row';
				$eb_col_class = 'col-lg-6';
				$eb_place_img_size = 'eagle_booking_image_size_720_470';

		}

		$eb_places_counter = '0';

	?>

		<div class="<?php echo esc_attr($eb_places_container) ?>">
		<?php

		// Start Loop
		if ($eb_places_qry->have_posts()): while ($eb_places_qry->have_posts()): $eb_places_qry->the_post();

			$eb_place_id = get_the_ID();
			$eb_place_title = get_the_title();
			$eb_place_url = get_permalink();
			$eb_place_img_url = get_the_post_thumbnail_url('', $eb_place_img_size);

			$eb_places_counter++;

			if ( $eb_places_counter == 1 || $eb_places_counter == 10 ) {
				$eb_place_class = 'big-item';
			  } else {
				$eb_place_class = 'small-item';
			  }

		?>


		<?php if ( $settings['places_style'] === 'grid' && ( in_array( $eb_places_counter, ( array( 2, 6 ) ) ) ) ): ?>
		<div class="col-lg-6">
			<div class="row">
		<?php endif ?>

		<!-- Places Item -->
		<div class="<?php echo esc_attr( $eb_col_class ) ?>">
				<?php include "place-item.php"; ?>
		</div>

		<?php if ( $settings['places_style'] === 'grid' && ( in_array( $eb_places_counter, ( array( 5, 9 ) ) ) ) ) : ?>
		</div>

		</div>

		<?php endif ?>

		<?php endwhile; endif; ?>
		<?php wp_reset_postdata(); ?>

		</div>

	<?php

	}


}
