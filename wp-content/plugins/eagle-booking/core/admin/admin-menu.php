<?php
/* --------------------------------------------------------------------------
 * Eagle Booking Admin Menu Class
 * @since  1.2.8
 * @modified 1.2.8.5
 * @author Jomin Muskaj
 ---------------------------------------------------------------------------*/

class EB_ADMIN_MENU {

  /**
   * Autoload method
   * @return void
   */
  public function __construct() {

      add_action('admin_menu',  array($this, 'eb_register_menu_sub_menu') );
   //   add_action('admin_pages',  array($this, 'eb_load_admin_pages') );

  }

  /**
   * Load Submenu Pages
   * @return void
   */

  // public function eb_load_admin_pages() {

    // $this-> eb_taxes_fees_page();

    // $this-> eb_bookings_page();
    // $this-> eb_calendar_page();
    // $this-> eb_edit_page();
    // $this-> eb_new_page();
    // $this-> eb_sync_calendars_page();

  // }

  /**
   * Register Menu & Sub Menus
   * @return void
   */

  public function eb_register_menu_sub_menu() {

    // Main Menu
    add_menu_page(
      'Eagle Booking',
      'Eagle Booking',
      'edit_pages',
      'eb_bookings',
      array($this, 'eb_bookings_page'),
      plugin_dir_url(dirname( __DIR__ )). '/assets/images/icons/eagle_booking.png',
      75
    );

    // Sub Menu - Bookings
    add_submenu_page(
      'eb_bookings',
      __('Bookings', 'eagle-booking'),
      __('Bookings', 'eagle-booking'),
      'edit_pages',
      'eb_bookings',
      array($this, 'eb_register_menu_sub_menu')
    );

    // Sub Menu - Calendar
    add_submenu_page(
      'eb_bookings',
      __('Calendar', 'eagle-booking'),
      __('Calendar', 'eagle-booking'),
      'edit_pages',
      'eb_calendar',
      array($this, 'eb_calendar_page')
    );

    // Sub Menu - Rooms
    add_submenu_page(
      'eb_bookings',
      __('Rooms', 'eagle-booking'),
      __('Rooms', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_rooms'
    );

    // Sub Menu - Branches
    add_submenu_page(
      'eb_bookings',
      __('Branches', 'eagle-booking'),
      __('Branches', 'eagle-booking'),
      'edit_pages',
      'edit-tags.php?taxonomy=eagle_branch'
    );

    // Sub Menu - Services
    add_submenu_page(
      'eb_bookings',
      __('Services', 'eagle-booking'),
      __('Services', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_services'
    );

    // Sub Menu - Exceptions
    add_submenu_page(
      'eb_bookings',
      __('Exceptions', 'eagle-booking'),
      __('Exceptions', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_exceptions'
    );

    // Coupons
    add_submenu_page(
      'eb_bookings',
      __('Coupons', 'eagle-booking'),
      __('Coupons', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_coupons'
    );

    // Sub Menu - Reviews
    add_submenu_page(
      'eb_bookings',
      __('Reviews', 'eagle-booking'),
      __('Reviews', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_reviews'
    );

    // Sub Menu - Places
    add_submenu_page(
      'eb_bookings',
      __('Places', 'eagle-booking'),
      __('Places', 'eagle-booking'),
      'edit_pages',
      'edit.php?post_type=eagle_places'
    );

    // Edit Booking (Hidden)
    add_submenu_page(
      null,
      __('Edit Booking', 'eagle-booking'),
      __('Edit Booking', 'eagle-booking'),
      'edit_pages',
      'eb_edit_booking',
      array($this, 'eb_edit_page')
    );

    // New Booking (Hidden)
    add_submenu_page(
      null,
      __('New Booking', 'eagle-booking'),
      __('New Booking', 'eagle-booking'),
      'edit_pages',
      'eb_new_booking',
      array($this, 'eb_new_page')
    );

  }

  // Calendar Page Callback
  public function eb_calendar_page() {
    include EB_PATH."/core/admin/bookings/include/calendar.php";
  }

  // Bookings Page Callback
  public function eb_bookings_page() {
    include EB_PATH."/core/admin/bookings/include/bookings.php";
  }

  // Edit Booking Page Callback
  public function eb_edit_page() {
    include EB_PATH."/core/admin/bookings/include/edit.php";
  }

  // New Booking Page Callback
  public function eb_new_page() {
    include EB_PATH."/core/admin/bookings/include/new.php";
  }


}

new EB_ADMIN_MENU;