<?php
/* --------------------------------------------------------------------------
 * EAGLE BOOKING INSTALL CLASS
 ---------------------------------------------------------------------------*/
class Eagle_Booking_Install {

  // Install Eagle Booking
  public static function install() {

    // Create Table
    self::create_tables();

    // Create user role 'eb_guest'
    self::create_user_role();

  }

  // On Update Eagle Booking
  public static function update() {

    // Check if there is a new version of the DB
    if ( get_site_option( 'eagle_booking_db_version' ) != EB_DB_VERSION ) {

      // Update Table (Re-create Table)
      self::create_tables();

      // Create user role 'eb_guest'
      self::create_user_role();

      // Update DB Version
      update_option( 'eagle_booking_db_version', EB_DB_VERSION );

    }

  }

  // Set up the database tables which Eagle Booking needs to function.
  private static function create_tables() {

    global $wpdb;

   // $wpdb->hide_errors();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( self::get_schema() );

    // Set DB Version
    add_option( 'eagle_booking_db_version', EB_DB_VERSION );

  }

  // Create 'Hotel Guest' user role
  private static function create_user_role() {

    add_role(
      'eb_guest',
      __( 'Hotel Guest', 'eagle-booking' ),
      array(
            'read'         => true,
            'edit_posts'   => false,
        )
    );

  }

  // Eagle Booking Create/Update Table
  public static function get_schema() {

      global $wpdb;

      // Tables
      $eb_main_table = $wpdb->prefix . 'eagle_booking';
      $eb_meta_table = $wpdb->prefix . 'eagle_booking_meta';

      // Create the Booking Main Table
      $eb_meta_sql = "CREATE TABLE $eb_main_table (

        id int(11) NOT NULL AUTO_INCREMENT,
        id_post int(11) NOT NULL,
        title_post varchar(255) NOT NULL,
        date varchar(255) NOT NULL,
        date_from varchar(255) NOT NULL,
        date_to varchar(255) NOT NULL,
        guests int(11) NOT NULL,
        adults int(11) NOT NULL,
        children int(11) NOT NULL,
        final_trip_price int(11) NOT NULL,
        deposit_amount int(11) NOT NULL,
        extra_services varchar(255) NOT NULL,
        id_user int(11) NOT NULL,
        user_first_name varchar(255) NOT NULL,
        user_last_name varchar(255) NOT NULL,
        paypal_email varchar(255) NOT NULL,
        user_ip varchar(45) NOT NULL,
        user_phone varchar(255) NOT NULL,
        user_address varchar(255) NOT NULL,
        user_city varchar(255) NOT NULL,
        user_country varchar(255) NOT NULL,
        user_message text(1000) NOT NULL,
        user_arrival varchar(255) NOT NULL,
        user_coupon varchar(255) NOT NULL,
        paypal_payment_status varchar(255) NOT NULL,
        paypal_currency varchar(255) NOT NULL,
        paypal_tx varchar(255) NOT NULL,
        action_type varchar(255) NOT NULL,
        UNIQUE KEY id (id)

      ) DEFAULT CHARACTER SET $wpdb->charset COLLATE $wpdb->collate;";

      // Create the Booking Meta Table
      $eb_meta_sql .= "CREATE TABLE $eb_meta_table (

        meta_id int(11) NOT NULL AUTO_INCREMENT,
        booking_id int(11) NOT NULL,
        meta_key varchar(255) NOT NULL,
        meta_value varchar(255) NOT NULL,
        UNIQUE KEY meta_id (meta_id)

     ) DEFAULT CHARACTER SET $wpdb->charset COLLATE $wpdb->collate;";

      return $eb_meta_sql;

  }

}
