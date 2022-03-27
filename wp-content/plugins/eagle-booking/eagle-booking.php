<?php
/*
Plugin Name:       Eagle Booking
Description:       Eagle Booking is a Hotel Booking WordPress Plugin that includes a complete hotel booking system and everything you need to manage your hotel.
Version:           1.3.3.4
Requires at least: 5.7
Requires PHP: 	   7.0
Plugin URI:        https://eagle-booking.com/
Author:            Eagle Themes
Author URI:        https://eagle-booking.com/
Text Domain:       eagle-booking
*/

/* --------------------------------------------------------------------------
 * EAGLE BOOKING VERSION
 ---------------------------------------------------------------------------*/
define('EB_VERSION', '1.3.3.4');
define('EB_DB_VERSION', '1.2.6');

/* --------------------------------------------------------------------------
 * EB Main Class
 ---------------------------------------------------------------------------*/
 final class Eagle_Booking {

	// The single instance of the class
	private static $_instance = null;

	// Eagle Booking Instance
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	// Eagle Booking Constructor
	public function __construct() {
		$this->init_hooks();
		$this->setup_constants();
		$this->includes();
	}

	// Hook into actions and filters
	function init_hooks() {

		register_activation_hook( __FILE__, array( 'Eagle_Booking_Install', 'install' ));
		add_action('plugins_loaded', array( 'Eagle_Booking_Install', 'update' ));
		add_action('plugins_loaded', array( $this, 'eagle_booking_load_textdomain' ));
		add_filter('single_template', array( $this, 'eagle_booking_get_room_template' ));
		add_filter('archive_template', array( $this, 'eagle_booking_get_room_archive_template' ));
		add_filter('single_template', array( $this, 'eagle_booking_get_place_template' ));

		// Taxonomy Detail Page
		add_filter('taxonomy_template', array( $this, 'eb_branch_taxonomy' ));

	}

	// Setup plugin constants
	public function setup_constants() {
   		 // Get Current File URL
		define('EB_PATH', plugin_dir_path( __FILE__ ));
  		// Get Plugin Base URL
		define('EB_URL', plugin_dir_url( __FILE__ ));

		// Plugin Custom DB Table
		global $wpdb;
		define('EAGLE_BOOKING_TABLE', $wpdb->prefix . 'eagle_booking');
		define('EAGLE_BOOKING_TABLE_META', $wpdb->prefix . 'eagle_booking_meta');

	}

	// Required Files
	private function includes() {

		require_once EB_PATH. '/core/admin/class-install.php';
		require_once EB_PATH. '/include/redux/framework.php';
		include_once EB_PATH. '/core/admin/template-loader.php';
		require_once EB_PATH. '/include/upgrader/upgrade-checker.php';
		require_once EB_PATH. '/core/functions.php';
		require_once EB_PATH. '/core/enqueue.php';
		require_once EB_PATH. '/core/vc/index.php';
		require_once EB_PATH. '/core/shortcodes/shortcodes.php';
		require_once EB_PATH. '/core/elementor/elementor-widgets.php';
		require_once EB_PATH. '/core/booking/booking.php';
		require_once EB_PATH. '/core/booking/checkout.php';
		require_once EB_PATH. '/core/booking/search.php';
		require_once EB_PATH. '/core/account/account.php';
		require_once EB_PATH. '/include/metabox/metabox.php';
		require_once EB_PATH. '/core/admin/plugin-options.php';
		require_once EB_PATH. '/core/admin/license.php';
		include_once EB_PATH. '/core/admin/function-insert-booking.php';
		include_once EB_PATH. '/core/admin/function-room-availability.php';
		include_once EB_PATH. '/core/admin/function-calendar-availability.php';
		include_once EB_PATH. '/core/admin/function-room-available-dates.php';
		include_once EB_PATH. '/core/admin/function-price-exceptions.php';
		include_once EB_PATH. '/core/admin/function-date-exceptions.php';
		include_once EB_PATH. '/core/admin/function-room-price.php';
		require_once EB_PATH. '/core/admin/admin-menu.php';
		require_once EB_PATH. '/core/admin/taxesfees.php';
		require_once EB_PATH. '/core/admin/bookings/index.php';
		require_once EB_PATH. '/core/admin/email.php';
		require_once EB_PATH. '/core/admin/metabox/metaboxes.php';
		require_once EB_PATH. '/core/admin/cpt/cpts.php';
		require_once EB_PATH. '/core/admin/taxonomies/taxonomies.php';
		require_once EB_PATH. '/core/admin/calendar.php';
		require_once EB_PATH. '/core/admin/bookings/booking.php';

	}

	// Text Domain
	function eagle_booking_load_textdomain() {
		load_plugin_textdomain("eagle-booking", false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	// Single Room Template
	function eagle_booking_get_room_template($eagle_booking_single_room) {
	     global $post;
	     if ($post->post_type == 'eagle_rooms') {
	          $eagle_booking_single_room = eb_load_template('single-room/single-room.php');
	     }
	     return $eagle_booking_single_room;
	}

	// Archive Rooms Template
	function eagle_booking_get_room_archive_template($eagle_booking_archive_room) {
	     global $post;
	     if ($post->post_type == 'eagle_rooms') {
			  $eagle_booking_archive_room = eb_load_template('archive-room/archive-room.php');
	     }
	     return $eagle_booking_archive_room;
	}

	// Single Place Template
	function eagle_booking_get_place_template($eagle_booking_single_place) {
	     global $post;
	     if ($post->post_type == 'eagle_places') {
	          $eagle_booking_single_place = eb_load_template('single-place/single-place.php');
	     }
	     return $eagle_booking_single_place;
	}

	// Branches Taxonomy Archive
	function eb_branch_taxonomy( $eb_branches_template ) {

		global $post;
		if ( is_tax('eagle_branch')  ) {

			 $eb_branches_template = eb_load_template('taxonomies/taxonomy-eagle_branch.php');
		}

		return $eb_branches_template;
   }

}

/* --------------------------------------------------------------------------
 * EB Main Function
 ---------------------------------------------------------------------------*/
function Eagle_Booking() {

	return Eagle_Booking::instance();

}

/* --------------------------------------------------------------------------
 * Check PHP Version and Load Plugin
 ---------------------------------------------------------------------------*/
if ( version_compare( PHP_VERSION, '7.0', '<' ) ) {

    function eb_fail_php_version() {

        echo '<div class="error"><h3>Eagle Booking</h3><p>To run Eagle Booking plugin <strong>PHP 7.0.0</strong> or higher is required. <a href="https://docs.eagle-booking.com/kb/requirements/" target="_blank">More details about server requirements.</a></p></div>';
	}

    add_action( is_network_admin() ? 'network_admin_notices' : 'admin_notices', 'eb_fail_php_version' );

} else {

	Eagle_Booking();
}
