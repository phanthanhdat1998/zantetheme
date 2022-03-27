<?php

namespace ElementorEagleThemes;

/* Class Plugin */
class EagleBookingPlugin {

 	/* Instance */
	private static $_instance = null;
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/* widget_scripts */
	public function widget_scripts() {
	//	wp_register_script( 'core-js', plugins_url( '/assets/js/core.js', __FILE__ ), [ 'jquery' ], false, true );
	//	wp_enqueue_style( 'core-css', plugins_url( '/assets/css/style.css', __FILE__ ), false, false);
	}


	/* Include Widgets files */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/search.php' );
		require_once( __DIR__ . '/widgets/rooms/rooms.php' );
		require_once( __DIR__ . '/widgets/places/places.php' );
		require_once( __DIR__ . '/widgets/testimonials.php' );
		require_once( __DIR__ . '/widgets/services.php' );
	}

	/* Register Widgets */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Search() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Rooms() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Places() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\RoomServices() );
	}

	/* Plugin class constructor */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}


}

// Instantiate Plugin Class
EagleBookingPlugin::instance();
