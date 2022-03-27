<?php
namespace ElementorEagleThemes\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor rooms
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class Rooms extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'rooms';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'Rooms', 'eagle' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'fas fa-hotel';
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
			'rooms_style',
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


		// Filters
		$this->add_control(
			'rooms_filters',
			[
				'label' => __( 'Show Filters', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle' ),
				'label_off' => __( 'Hide', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'rooms_style',
							'operator' => 'in',
							'value' => [
								'grid',
							],
						],
					],
				],
			]
		);

		// Items to Display
		$this->add_control(
			'rooms_items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
			]
		);


		// Items per Row
		$this->add_control(
			'rooms_items_per_row',
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
							'name' => 'rooms_style',
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
			'rooms_items_per_view',
			[
				'label' => __( 'Items per View', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '3',
				'conditions' => [
					'terms' => [
						[
							'name' => 'rooms_style',
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
			'rooms_order_by',
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
			'rooms_order',
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
			'rooms_offset',
			[
				'label' => __( 'Offset', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
			]
		);

		// Loop (Carousel)
		$this->add_control(
			'rooms_loop',
			[
				'label' => __( 'Loop', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'rooms_style',
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
			'rooms_navigation',
			[
				'label' => __( 'Navigation', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'rooms_style',
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

		// rooms QUERY
		$eagle_query_args = array(
			'post_type' => 'eagle_rooms',
			'posts_per_page' => $settings['rooms_items'],
			'orderby' => $settings['rooms_order_by'],
			'order' => $settings['rooms_order'],
			'offset' =>  $settings['rooms_offset'],
		);

		$eagle_booking_rooms_qry = new \WP_Query($eagle_query_args);
		$eagle_unique_token = wp_generate_password(5, false, false);

		?>

		<script>
			jQuery(document).ready(function ($) {
					jQuery(function($) {
						// =============================================
					// ROOMS - OWL CAROUSEL
					// =============================================
					var owl = $('.rooms-owl');
					owl.owlCarousel({
					loop: false,
					margin: 30,
					nav: <?php echo $settings['rooms_navigation'] ? 'true' : 'false' ?>,
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
						//   items: <?php echo $settings['rooms_items_per_view'] ?>
						// }
					}
					});

					});
			});
		</script>

		<?php

		// Room Column Class
		$eagle_booking_col_class = '4';
		if ($settings['rooms_items_per_row'] === '6') { $eagle_booking_col_class = '2'; }
		if ($settings['rooms_items_per_row'] === '4') { $eagle_booking_col_class = '3'; }
		if ($settings['rooms_items_per_row'] === '3') { $eagle_booking_col_class = '4'; }
		if ($settings['rooms_items_per_row'] === '2') { $eagle_booking_col_class = '6'; }

		// Room Container Class
		if ($settings['rooms_style'] === 'carousel') {
			$eagle_booking_rooms_container = 'rooms-owl owl-carousel';
			$eagle_booking_col_class = '';
		} elseif ($settings['rooms_style'] === 'normal') {
				$eagle_booking_rooms_container = 'row';
				$eagle_booking_col_class = 'col-lg-'.$eagle_booking_col_class;
		} else {
				$eagle_booking_rooms_container = 'row';
				$eagle_booking_col_class = 'col-lg-6';
		}

		$eagle_booking_rooms_counter = '0';

	?>
		<!-- Room Elementor Widget -->
		<div class="<?php echo esc_attr($eagle_booking_rooms_container) ?>">
		<?php

		// Start Loop
		if ($eagle_booking_rooms_qry->have_posts()): while ($eagle_booking_rooms_qry->have_posts()): $eagle_booking_rooms_qry->the_post();

			$eagle_booking_room_id = get_the_ID();
			$eagle_booking_room_title = get_the_title();
			$eagle_booking_room_url = get_permalink();
			$eagle_booking_room_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');
			$eagle_booking_room_price = eagle_booking_room_min_price($eagle_booking_room_id);

			$eagle_booking_rooms_counter++;

		?>

		<?php if ( $settings['rooms_style'] === 'grid' && $eagle_booking_rooms_counter == 2) : ?>
		<div class="col-lg-6">
			<div class="row">
		<?php endif ?>

		<!-- Room Item -->
		<div class="<?php echo esc_attr( $eagle_booking_col_class ) ?>">
			<?php include "room-item.php"; ?>
		</div>

		<?php if ( $settings['rooms_style'] === 'grid' && $eagle_booking_rooms_counter == 5) : ?>
			</div>
		</div>
		<?php endif ?>

		<?php endwhile; endif; ?>
		<?php wp_reset_postdata(); ?>

		</div>

	<?php

	}


}
