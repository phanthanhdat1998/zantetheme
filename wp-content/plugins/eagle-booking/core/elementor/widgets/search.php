<?php
namespace ElementorEagleThemes\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Eagle Booking Elementor Search Widget
* Author: Eagle Themes (Jomin Muskaj)
* Since: 1.0.0
---------------------------------------------------------------------------*/
class Search extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eagle_search_forms';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'Search Forms', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'fas fa-search';
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

		// STYLE TAB
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Form Style
		$this->add_control(
			'form_style',
			[
				'label' => __( 'Style', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => __( 'Horizontal', 'eagle-booking' ),
					'vertical'  => __( 'Vertical', 'eagle-booking' ),
				],
			]
		);

		// Form Label
		$this->add_control(
			'form_label',
			[
				'label' => __( 'Show Labels', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle-booking' ),
				'label_off' => __( 'Hide', 'eagle-booking' ),
				'return_value' => 'true',
			]
		);

		// Form Field Info
		// $this->add_control(
		// 	'form_field_info',
		// 	[
		// 		'label' => __( 'Show Field Info', 'eagle-booking' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => __( 'Show', 'eagle-booking' ),
		// 		'label_off' => __( 'Hide', 'eagle-booking' ),
		// 		'return_value' => 'true',
		// 	]
		// );

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

		// Include form parameters
		include EB_PATH . '/core/admin/form-parameters.php';

		$settings = $this->get_settings_for_display();

		$eb_unique_token = wp_generate_password(5, false, false);

	?>

	<?php if ($settings['form_label'] == false ) : ?>
		<style>
			#<?php echo $eb_unique_token ?> label {
				visibility: hidden;
			}
		</style>
	<?php endif ?>


	<?php if ( $settings['form_style'] === 'horizontal' ) : ?>

	<!-- ========== Horizontal Search Form ========== -->
	<div id="<?php echo esc_attr($eb_unique_token) ?>" class="horizontal-booking-form">
		<div class="container">
			<div class="inner box-shadow-007">
				<!-- Search Form -->
				<form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">
					<div class="row">
						<!-- Custom Parameters -->
						<?php include eb_load_template('elements/custom-parameters.php'); ?>
						<!-- Check-In/Out-->
						<div class="col-md-4">
						<?php include eb_load_template('elements/dates-picker.php'); ?>
						</div>
						<!-- Guests -->
						<div class="col-md-4">
						<?php include eb_load_template('elements/guests-picker.php'); ?>
						</div>
						<!-- Button -->
						<div class="col-md-4">
							<input id="eb_search_form" class="btn btn-book" type="submit" value="<?php echo __('Check Availability','eagle-booking') ?>">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php else : ?>

	<!-- ========== Vertical Search Form ========== -->
	<div id="<?php echo esc_attr($eb_unique_token) ?>" class="vertical-booking-form slider-booking-form">
		<h3 class="form-title">Book Your Stay</h3>
		<div class="inner">
		<form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">
				<!-- Custom Parameters -->
				<?php include eb_load_template('elements/custom-parameters.php'); ?>
				<!-- Check-In/Out-->
				<div class="form-group">
				<?php include eb_load_template('elements/dates-picker.php'); ?>
				</div>
				<!-- Guests -->
				<div class="form-group">
				<?php include eb_load_template('elements/guests-picker.php'); ?>
				</div>
				<!-- Button -->
				<div class="form-group">
					<input id="eb_search_form" class="btn btn-book" type="submit" value="<?php echo __('Check Availability','eagle-booking') ?>">
				</div>
			</form>
		</div>
	</div>

	<?php endif ?>

<?php

 wp_reset_postdata();

	}

}


//add_shortcode('eagle_booking_search_form', 'Search');
