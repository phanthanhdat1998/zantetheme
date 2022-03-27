<?php

/* --------------------------------------------------------------------------
 * Eagle Booking Options
 * @since  1.0.0
---------------------------------------------------------------------------*/

if ( ! class_exists( 'Redux' ) ) {
    return;
}

$opt_name = 'eagle_booking_settings';

/*-----------------------------------------------------------------------------------*/
//  Redux Framework options
/*-----------------------------------------------------------------------------------*/
$args = array(
    'opt_name'             => $opt_name,
    'display_name'         => 'Eagle Booking',
    'display_version'      => EB_VERSION,
    'menu_type'            => 'submenu',
    'allow_sub_menu'       => false,
    'menu_title'           => esc_html__( 'Settings', 'eagle-booking' ),
    'page_title'           => esc_html__( 'Eagle Booking Options', 'eagle-booking' ),
    'page_parent'          => 'eb_bookings',
    'google_api_key'       => '',
    'google_update_weekly' => false,
    'async_typography'     => false,
    'admin_bar'            => false,
    'admin_bar_icon'       => 'dashicons-admin-generic',
    'admin_bar_priority'   => '100',
    'global_variable'      => '',
    'dev_mode'             => false,
    'update_notice'        => false,
    'customizer'           => false,
    'allow_tracking'       => false,
    'ajax_save'            => true,
    'page_priority'        => '75',
    'page_permissions'     => 'manage_options',
    'menu_icon'            =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/icons/eagle_booking.png',
    'last_tab'             => '',
    'page_icon'            => 'icon-themes',
    'page_slug'            => 'eb_settings',
    'save_defaults'        => true,
    'default_show'         => false,
    'default_mark'         => '',
    'show_import_export'   => true,
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => false,
    'output_tag'           => true,
    'database'             => '',
    'system_info'          => false,
    'footer_credit'        => ' ',
);

$GLOBALS['redux_notice_check'] = 1;
$args['intro_text'] = '';
$args['footer_text'] = '';

/*-----------------------------------------------------------------------------------*/
//  Initialize Redux
/*-----------------------------------------------------------------------------------*/
Redux::setArgs( $opt_name , $args );

/*-----------------------------------------------------------------------------------*/
//  Load Custom CSS
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'eagle_booking_redux_custom_css' ) ):
    function eagle_booking_redux_custom_css() {
        wp_register_style( 'eagle-booking-redux-custom', plugin_dir_url( dirname(__DIR__ )).'/assets/css/admin/options.css' );
        wp_enqueue_style( 'eagle-booking-redux-custom' );
    }
endif;

add_action( 'redux/page/eagle_booking_settings/enqueue', 'eagle_booking_redux_custom_css' );

/*-----------------------------------------------------------------------------------*/
// Remove redux framework admin page
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'eb_remove_redux_page' ) ):
    function eb_remove_redux_page() {
        remove_submenu_page( 'tools.php', 'redux-framework' );
    }
endif;

add_action( 'admin_menu', 'eb_remove_redux_page', 99 );

/*-----------------------------------------------------------------------------------*/
// Remove the demo link and the notice
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'remove_redux_demo' ) ) {
    function remove_redux_demo() { // Be sure to rename this function to something more unique
        if ( class_exists('ReduxFrameworkPlugin') ) {
            remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
        }
        if ( class_exists('ReduxFrameworkPlugin') ) {
            remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
        }
    }
}

add_action('init', 'remove_redux_demo');

/*-----------------------------------------------------------------------------------*/
// Remove plugin redirect
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'remove_redux_plugin_redirect' ) ) {
    function remove_redux_plugin_redirect() {
        ReduxFramework::$_as_plugin = false;
    }
}

add_action( 'redux/construct', 'remove_redux_plugin_redirect' );

/*-----------------------------------------------------------------------------------*/
// Add repetable dynamic field
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'eb_sidgen_field_path' ) ):
    function eb_sidgen_field_path($field) {
        return EB_PATH . '/include/redux-custom/dynamic-field.php';
    }
    endif;

    add_filter( "redux/eagle_booking_settings/field/class/sidgen", "eb_sidgen_field_path" );

/* BOOKING SETTINGS */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-calendar',
    'title'           => esc_html__( 'Booking System', 'eagle-booking' ),
    'fields'          => array(

       array(
        'id'          => 'booking_type',
        'type'        => 'image_select',
        'title'       => esc_html__( 'Booking System', 'eagle-booking' ),
        'subtitle'       => esc_html__( 'Choose your preferred booking system', 'eagle-booking' ),
        'options'     => array(
            'builtin'       => array( 'title' => esc_html__('Built-in', 'eagle-booking'), 'img' =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/admin/builtin.png' ),
            'booking'       => array( 'title' => esc_html__('Booking.com', 'eagle-booking'), 'img' =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/admin/booking.png' ),
            'airbnb'        => array( 'title' => esc_html__('Airbnb', 'eagle-booking'), 'img' =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/admin/airbnb.png' ),
            'tripadvisor'   => array( 'title' => esc_html__('Tripadvisor', 'eagle-booking'), 'img' =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/admin/tripadvisor.png' ),
            'custom'        => array( 'title' => esc_html__('Custom', 'eagle-booking'), 'img' =>  plugin_dir_url(dirname( __DIR__ )). '/assets/images/admin/custom.png' ),
        ),
        'default'     => 'builtin',
        ),

       // BOOKING.COM OPTIONS
       array(
           'id'         => 'booking_type_booking_action',
           'type'        => 'text',
           'title'      => esc_html__('Booking.com Hotel URL', 'eagle-booking'),
           'required'   => array( 'booking_type', '=', 'booking' )
       ),

       // AIR B&B OPTIONS
       array(
           'id'         => 'booking_type_airbnb_action',
           'type'        => 'text',
           'title'      => esc_html__('Airbnb Hotel URL', 'eagle-booking'),
           'required'   => array( 'booking_type', '=', 'airbnb' )
       ),

       // TRIPADVISOR OPTIONS
       array(
           'id'         => 'booking_type_tripadvisor_action',
           'type'        => 'text',
           'title'      => esc_html__('Tripadvisor Hotel URL', 'eagle-booking'),
           'required'   => array( 'booking_type', '=', 'tripadvisor' )
       ),

     // CUSTOM OPTIONS
     array(
         'id'         => 'booking_type_custom_action',
         'type'        => 'text',
         'title'      => esc_html__('Form Action', 'eagle-booking'),
         'required'   => array( 'booking_type', '=', 'custom' )
     ),

     array(
           'id'       => 'booking_type_custom_checkin_param',
           'type'     => 'text',
           'title'    => __('Check In Parameter', 'eagle-booking'),
           'default'  => '',
           'required'   => array( 'booking_type', '=', 'custom' )
       ),

       array(
             'id'       => 'booking_type_custom_checkout_param',
             'type'     => 'text',
             'title'    => __('Check Out Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

       array(
             'id'       => 'booking_type_custom_guests_param',
             'type'     => 'text',
             'title'    => __('Guests Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),
       array(
             'id'       => 'booking_type_custom_adults_param',
             'type'     => 'text',
             'title'    => __('Adults Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),
       array(
             'id'       => 'booking_type_custom_children_param',
             'type'     => 'text',
             'title'    => __('Children Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

       array(
             'id'       => 'booking_type_custom_hotel_id_param',
             'type'     => 'text',
             'title'    => __('Hotel ID/Name Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

       array(
             'id'       => 'booking_type_custom_hotel_id',
             'type'     => 'text',
             'title'    => __('Hotel ID/Name', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

       array(
             'id'       => 'booking_type_custom_additional_param',
             'type'     => 'text',
             'title'    => __('Additional Parameter', 'eagle-booking'),
             'default'  => '',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

         array(
               'id'       => 'booking_type_custom_additional_id',
               'type'     => 'text',
               'title'    => __('Additional Parameter Value', 'eagle-booking'),
               'default'  => '',
               'required'   => array( 'booking_type', '=', 'custom' )
           ),
         array(
               'id'       => 'booking_type_custom_room_param',
               'type'     => 'text',
               'title'    => __('Room Parameter', 'eagle-booking'),
               'default'  => '',
               'required'   => array( 'booking_type', '=', 'custom' )
           ),

       array(
             'id'       => 'booking_type_custom_date_format',
             'type'     => 'text',
             'title'    => __('Date Format', 'eagle-booking'),
             'default'  => 'DD-MM-YYYY',
             'required'   => array( 'booking_type', '=', 'custom' )
         ),

       // Open external booking system in new tab
       array(
           'id'         => 'eagle_booking_external_target',
           'type'       => 'switch',
           'title'      => esc_html__( 'New Tab', 'eagle-booking' ),
           'subtitle'        => esc_html__( 'Open external booking system in new tab', 'eagle-booking' ),
           'default'    => false,
           'required'   => array( 'booking_type', '!=', 'builtin' )
       ),

      array(
          'id'         => 'eagle_booking_search_page',
          'type'        => 'select',
          'class'       => 'small-text',
          'title'      => esc_html__('Search Page', 'eagle-booking'),
          'desc'        => wp_kses_post( 'Select the page where you have added the shortcode <pre>[eb_search]</pre>', 'eagle-booking' ),
          'subtitle'      => esc_html__('Choose the search page', 'eagle-booking'),
          'data'       => 'pages',
          'required'   => array( 'booking_type', '=', 'builtin' )
      ),

      array(
          'id'         => 'eagle_booking_page',
          'type'        => 'select',
          'class'       => 'small-text',
          'title'      => esc_html__('Booking Page', 'eagle-booking'),
          'desc'        => wp_kses_post( 'Select the page where you have added the shortcode <pre>[eb_booking]</pre>', 'eagle-booking' ),
          'subtitle'      => esc_html__('Choose the booking page', 'eagle-booking'),
          'data'       => 'pages',
          'required'   => array( 'booking_type', '=', 'builtin' )
      ),

      array(
        'id'         => 'eagle_booking_checkout_page',
        'type'        => 'select',
        'class'       => 'small-text',
        'title'      => esc_html__('Checkout Page', 'eagle-booking'),
        'desc'        => wp_kses_post( 'Select the page where you have added the shortcode <pre>[eb_checkout]</pre>', 'eagle-booking' ),
        'subtitle'      => esc_html__('Choose the checkout page', 'eagle-booking'),
        'data'       => 'pages',
        'required'   => array( 'booking_type', '=', 'builtin' )
     ),

      array(
          'id'         => 'account_page',
          'type'        => 'select',
          'class'       => 'small-text',
          'title'      => esc_html__('Account Page', 'eagle-booking'),
          'desc'        => wp_kses_post( 'Select the page where you have added the shortcode <pre>[eb_account]</pre>', 'eagle-booking' ),
          'subtitle'      => esc_html__('Choose the account page', 'eagle-booking'),
          'data'       => 'pages',
          'required'   => array( 'booking_type', '=', 'builtin' )
      ),

      array(
          'id'         => 'eagle_booking_terms_page',
          'type'        => 'select',
          'class'       => 'small-text',
          'title'      => esc_html__('Terms and Conditions Page', 'eagle-booking'),
          'desc'        => esc_html__( 'Select the page where you have added your terms and conditions informations', 'eagle-booking' ),
          'subtitle'      => esc_html__('Choose the terms and conditions page', 'eagle-booking'),
          'data'       => 'pages',
          'required'   => array( 'booking_type', '=', 'builtin' )
      ),
      array(
          'id'         => 'eagle_booking_contact_page',
          'type'        => 'select',
          'class'       => 'small-text',
          'title'      => esc_html__('Contact Page', 'eagle-booking'),
          'desc'        => esc_html__( 'Select the page where you have added your contact form', 'eagle-booking' ),
          'subtitle'      => esc_html__('Choose the contact page', 'eagle-booking'),
          'data'       => 'pages',
          'required'   => array( 'booking_type', '=', 'builtin' )
      ),

    )
));

/* General Settings */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-cog',
    'title'           => esc_html__( 'General Settings', 'eagle-booking' ),
    'fields'          => array(

        array(
            'id'          => 'hotel_logo',
            'type'        => 'media',
            'url'         => false,
            'title'       => esc_html__( 'Hotel Logo', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Used for the email template and for the print page of the booking details.', 'eagle-booking' ),
        ),

        array(
            'id'         => 'eb_header_button',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Booking Button', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Display the booking button in the main menu', 'eagle-booking' ),
            'default'    => true,
        ),

        array(
            'id' => 'button_menu',
            'class'     => 'small-text',
            'type' => 'select',
            'title' => __('Booking Button Menu', 'eagle-booking'),
            'subtitle' => __('Choose on which menu you want to show the booking button', 'eagle-booking'),
            'data' => 'menus',
            'default' => '',
            'required'   => array( 'eb_header_button', '=', true )
        ),

        array(
            'id'         => 'eb_stepline',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Step Line', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Show/Hide Step Line on search, booking and checkout page.', 'eagle-booking' ),
            'default'    => false,
        ),

        array(
              'id'           => 'eagle_booking_date_format',
              'type'         => 'radio',
              'title'        => esc_html__( 'Date Format', 'eagle-booking' ),
              'subtitle'     => esc_html__( 'Set the displayed date format', 'eagle-booking' ),
              'options'      => array(
                'dd/mm/yyyy' => ''.date('d/m/Y').' &nbsp;&nbsp; DD/MM/YYYY',
                'mm/dd/yyyy' => ''.date('m/d/Y').' &nbsp;&nbsp; MM/DD/YYYY',
                'yyyy/mm/dd' => ''.date('Y/m/d').' &nbsp;&nbsp; YYYY/MM/DD',
              ),
              'default'  => 'dd/mm/yyyy',
          ),

        array(
              'id'           => 'time_format',
              'type'         => 'radio',
              'title'        => esc_html__( 'Time Format', 'eagle-booking' ),
              'subtitle'     => esc_html__( 'Set the displayed time format', 'eagle-booking' ),
              'options'      => array(
                '12hour' => ''.date('g:i a').' &nbsp;&nbsp; 12-hour format',
                '24hour' => ''.date('G:i').' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 24-hour format'
              ),
              'default'  => '12hour',
        ),


        array(
            'id'       => 'eb_calendar_availability_period',
            'type'     => 'text',
            'class'     => 'small-text',
            'title'    => __('Calendar Availability Period', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the max period of the calendar availability in months, today + {number} months.', 'eagle-booking' ),
            'default'  => '24',
        ),


        array(
            'id'       => 'checkin_time_12hour',
            'type'     => 'select',
            'title'      => esc_html__('Check In Time', 'eagle-booking'),
            'subtitle'   => esc_html__('Set a check in time.', 'eagle-booking'),
            'class'    => 'small-select',
            'options'  => array(
                '00:00' => '12:00'.' '.__('am', 'eagle-booking'),
                '01:00' => '1:00'.' '.__('am', 'eagle-booking'),
                '02:00' => '2:00'.' '.__('am', 'eagle-booking'),
                '03:00' => '3:00'.' '.__('am', 'eagle-booking'),
                '04:00' => '4:00'.' '.__('am', 'eagle-booking'),
                '05:00' => '5:00'.' '.__('am', 'eagle-booking'),
                '06:00' => '6:00'.' '.__('am', 'eagle-booking'),
                '07:00' => '7:00'.' '.__('am', 'eagle-booking'),
                '08:00' => '8:00'.' '.__('am', 'eagle-booking'),
                '09:00' => '9:00'.' '.__('am', 'eagle-booking'),
                '10:00' => '10:00'.' '.__('am', 'eagle-booking'),
                '11:00' => '11:00'.' '.__('am', 'eagle-booking'),
                '12:00' => '12:00'.' '.__('pm', 'eagle-booking'),
                '13:00' => '1:00'.' '.__('pm', 'eagle-booking'),
                '14:00' => '2:00'.' '.__('pm', 'eagle-booking'),
                '15:00' => '3:00'.' '.__('pm', 'eagle-booking'),
                '16:00' => '4:00'.' '.__('pm', 'eagle-booking'),
                '17:00' => '5:00'.' '.__('pm', 'eagle-booking'),
                '18:00' => '6:00'.' '.__('pm', 'eagle-booking'),
                '19:00' => '7:00'.' '.__('pm', 'eagle-booking'),
                '20:00' => '8:00'.' '.__('pm', 'eagle-booking'),
                '21:00' => '9:00'.' '.__('pm', 'eagle-booking'),
                '22:00' => '10:00'.' '.__('pm', 'eagle-booking'),
                '23:00' => '11:00'.' '.__('pm', 'eagle-booking'),
            ),
            'default'  => '',
            'required'   => array( 'time_format', '=', '12hour' )
        ),

        array(
            'id'       => 'checkout_time_12hour',
            'type'     => 'select',
            'title'      => esc_html__('Check Out Time', 'eagle-booking'),
            'subtitle'   => esc_html__('Set a check out time.', 'eagle-booking'),
            'class'    => 'small-select',
            'options'  => array(
                '00:00' => '12:00'.' '.__('am', 'eagle-booking'),
                '01:00' => '1:00'.' '.__('am', 'eagle-booking'),
                '02:00' => '2:00'.' '.__('am', 'eagle-booking'),
                '03:00' => '3:00'.' '.__('am', 'eagle-booking'),
                '04:00' => '4:00'.' '.__('am', 'eagle-booking'),
                '05:00' => '5:00'.' '.__('am', 'eagle-booking'),
                '06:00' => '6:00'.' '.__('am', 'eagle-booking'),
                '07:00' => '7:00'.' '.__('am', 'eagle-booking'),
                '08:00' => '8:00'.' '.__('am', 'eagle-booking'),
                '09:00' => '9:00'.' '.__('am', 'eagle-booking'),
                '10:00' => '10:00'.' '.__('am', 'eagle-booking'),
                '11:00' => '11:00'.' '.__('am', 'eagle-booking'),
                '12:00' => '12:00'.' '.__('pm', 'eagle-booking'),
                '13:00' => '1:00'.' '.__('pm', 'eagle-booking'),
                '14:00' => '2:00'.' '.__('pm', 'eagle-booking'),
                '15:00' => '3:00'.' '.__('pm', 'eagle-booking'),
                '16:00' => '4:00'.' '.__('pm', 'eagle-booking'),
                '17:00' => '5:00'.' '.__('pm', 'eagle-booking'),
                '18:00' => '6:00'.' '.__('pm', 'eagle-booking'),
                '19:00' => '7:00'.' '.__('pm', 'eagle-booking'),
                '20:00' => '8:00'.' '.__('pm', 'eagle-booking'),
                '21:00' => '9:00'.' '.__('pm', 'eagle-booking'),
                '22:00' => '10:00'.' '.__('pm', 'eagle-booking'),
                '23:00' => '11:00'.' '.__('pm', 'eagle-booking'),
                ),
                'default'  => '',
                'required'   => array( 'time_format', '=', '12hour' )
        ),


        array(
            'id'       => 'checkin_time_24hour',
            'type'     => 'select',
            'title'      => esc_html__('Check In Time', 'eagle-booking'),
            'subtitle'   => esc_html__('Set a check in time.', 'eagle-booking'),
            'class'    => 'small-select',
            'options'  => array(
                '0:00' => '00:00',
                '1:00' => '01:00',
                '2:00' => '02:00',
                '3:00' => '03:00',
                '4:00' => '04:00',
                '5:00' => '05:00',
                '6:00' => '06:00',
                '7:00' => '07:00',
                '8:00' => '08:00',
                '9:00' => '09:00',
                '10:00' => '10:00',
                '11:00' => '11:00',
                '12:00' => '12:00',
                '13:00' => '13:00',
                '14:00' => '14:00',
                '15:00' => '15:00',
                '16:00' => '16:00',
                '17:00' => '17:00',
                '18:00' => '18:00',
                '19:00' => '19:00',
                '20:00' => '20:00',
                '21:00' => '21:00',
                '22:00' => '22:00',
                '23:00' => '23:00',
            ),
            'default'  => '',
            'required'   => array( 'time_format', '=', '24hour' )
        ),

        array(
            'id'       => 'checkout_time_24hour',
            'type'     => 'select',
            'title'      => esc_html__('Check Out Time', 'eagle-booking'),
            'subtitle'   => esc_html__('Set a check out time.', 'eagle-booking'),
            'class'    => 'small-select',
            'options'  => array(
                '0:00' => '00:00',
                '1:00' => '01:00',
                '2:00' => '02:00',
                '3:00' => '03:00',
                '4:00' => '04:00',
                '5:00' => '05:00',
                '6:00' => '06:00',
                '7:00' => '07:00',
                '8:00' => '08:00',
                '9:00' => '09:00',
                '10:00' => '10:00',
                '11:00' => '11:00',
                '12:00' => '12:00',
                '13:00' => '13:00',
                '14:00' => '14:00',
                '15:00' => '15:00',
                '16:00' => '16:00',
                '17:00' => '17:00',
                '18:00' => '18:00',
                '19:00' => '19:00',
                '20:00' => '20:00',
                '21:00' => '21:00',
                '22:00' => '22:00',
                '23:00' => '23:00',
            ),
            'default'  => '',
            'required'   => array( 'time_format', '=', '24hour' )
        ),

        array(
            'id'         => 'eb_adults_children',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Adults & Children', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Display adults & children selector or use only guests selector', 'eagle-booking' ),
            'default'    => false,
        ),

        array(
            'id'          => 'eb_default_guests',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Default Guests', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form default guests number.', 'eagle-booking' ),
            'default'     => '1',
            'required'    => array( 'eb_adults_children', '=', false ),
        ),

        array(
            'id'          => 'eb_max_guests',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Max Guests', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form max guests', 'eagle-booking' ),
            'default'     => '4',
            'required'    => array( 'eb_adults_children', '=', false ),
        ),

        array(
            'id'          => 'eb_default_adults',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Default Adults', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form default guests number.', 'eagle-booking' ),
            'default'     => '1',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),

        array(
            'id'          => 'eb_default_children',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Default Children', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form default guests', 'eagle-booking' ),
            'default'     => '0',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),

        array(
            'id'          => 'eb_max_adults',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Max Adults', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form max adults', 'eagle-booking' ),
            'default'     => '4',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),

        array(
            'id'          => 'eb_max_children',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Search Form Max Children', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the search form max children', 'eagle-booking' ),
            'default'     => '4',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),

        array(
            'id'          => 'eb_adult_age',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Age of Adult', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Description of the "Adults" field.', 'eagle-booking' ),
            'default'     => '18+ ',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),

        array(
            'id'          => 'eb_child_age',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Age of Child', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Description of the "Children" field.', 'eagle-booking' ),
            'default'     => '4 - 18',
            'required'    => array( 'eb_adults_children', '=', true ),
        ),


        array(
            'id'         => 'show_price',
            'type'       => 'switch',
            'title'      => esc_html__( 'Price', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Show/Hide the price during the booking process. ', 'eagle-booking' ),
            'default'    => true
        ),

        array(
            'id'         => 'eb_show_room_price',
            'type'       => 'switch',
            'title'      => esc_html__( 'Room Normal Price', 'eagle-booking' ),
            'subtitle'        => esc_html__( 'Show/Hide the room normal price', 'eagle-booking' ),
            'default'    => true,
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'price_taxes',
            'type'       => 'button_set',
            'title'      => esc_html__('Display Price', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Choose how to display prices like room normal price and additional services price', 'eagle-booking' ),
            'multi'      => false,
            'options'    => array(
                'including'   => 'Including Taxes & Fees',
                'excluding'  => 'Excluding Taxes & Fees',
            ),
            'default'    => 'including',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_currency',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Currency', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set your currency', 'eagle-booking' ),
            'default'    => '$',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_currency_position',
            'type'       => 'button_set',
            'title'      => esc_html__('Currency Position', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Currency to left or right side of price', 'eagle-booking' ),
            'multi'      => false,
            'options'    => array(
                'before'   => 'Before Price',
                'after'  => 'After Price',
            ),
            'default'    => 'before',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_thousands_separator',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Thousands Separator', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the thousands seperator (usually , or .) of displayed prices.', 'eagle-booking' ),
            'default'    => '.',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_decimal_number',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Number of Decimals', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the number of decimals points shown in displayed prices.', 'eagle-booking' ),
            'default'    => '2',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_decimal_separator',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Decimal Separator', 'eagle-booking'),
            'subtitle'   => esc_html__('Set the decimal seperator (usually , or .) of displayed prices.', 'eagle-booking'),
            'default'    => ',',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_before_price',
            'type'       => 'text',
            'class'      => 'small-text',
            'title'      => esc_html__('Text Before the Price', 'eagle-booking'),
            'subtitle'   => esc_html__('Set a text before the price', 'eagle-booking'),
            'default'    => '',
            'required'    => array( 'show_price', '=', true ),
        ),

        array(
            'id'         => 'eagle_booking_units_of_measure',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Units of Measure', 'eagle-booking'),
            'subtitle'   => esc_html__('Set the units of measure', 'eagle-booking'),
            'default'    => 'm²',
        ),

        array(
            'id'    => 'lp_info_warning',
            'type'  => 'info',
            'title' => esc_html__('URL Rewrite', 'eagle-booking'),
            'style' => 'warning',
            'desc'  => esc_html__('Please update permalinks ( under Settings menu ) after any changes you make in following slugs ( to avoid a 404 error )', 'eagle-booking')
        ),

        array(
            'id'         => 'eagle_booking_rooms_slug',
            'type'       => 'text',
            'title'      => esc_html__('Rewrite Rooms Slug', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Rewrite the rooms slug', 'eagle-booking' ),
            'default'    => 'rooms',
        ),

        array(
            'id'         => 'eagle_booking_places_slug',
            'type'       => 'text',
            'title'      => esc_html__('Rewrite Places Slug', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Rewrite the places slug', 'eagle-booking' ),
            'default'    => 'places',
        ),

        array(
            'id'         => 'branches_slug',
            'type'       => 'text',
            'title'      => esc_html__('Rewrite Branches Slug', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Rewrite the branches slug', 'eagle-booking' ),
            'default'    => 'branch',
        ),

    )
));


/* Search Page */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-search',
    'title'           => esc_html__( 'Search Page', 'eagle-booking' ),
    'fields'          => array(

      array(
          'id'         => 'eagle_booking_search_page_settings',
          'type'     => 'sortable',
          'mode'        => 'checkbox',
          'title'      => esc_html__('Filters', 'eagle-booking'),
          'subtitle'        => esc_html__( 'Set the elements for the search page', 'eagle-booking' ),
          'options'  => array(
                'price_range_filter' => 'Price Range',
                'services_filter' => 'Included Services',
                'additional_services_filter' => 'Additional Services',
                'branches' => 'Branches',
            ),
            'default' => array(
                  'price_range_filter' => '1',
                  'services_filter' => '1',
                  'additional_services_filter' => '1',
                  'branches' => '0',
              ),
      ),

      array(
        'id'         => 'eb_search_page_sticky_sidebar',
        'type'       => 'switch',
        'class'       => 'small-text',
        'title'      => esc_html__('Sticky Sidebar', 'eagle-booking'),
        'subtitle'   => esc_html__( 'Sticky option for the search page sidebar', 'eagle-booking' ),
        'default'    => true,
    ),

        array(
            'id'         => 'total_price',
            'type'       => 'button_set',
            'class'       => 'small-text',
            'title'      => esc_html__('Total Price', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Choose how to display the total price on the search page.', 'eagle-booking' ),
            'options'    => array(
                'mouseover'   => 'Mouseover',
                'default'  => 'By Default',
            ),
            'default'    => 'mouseover',
        ),

        array(
            'id'         => 'eb_price_range_min',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Price Range - Default Min Value', 'eagle-booking'),
            'subtitle'      => esc_html__('Set the minimum price', 'eagle-booking'),
            'default'    => '1',
            'required'  => array('eagle_booking_search_page_settings','contains',array('price_range_filter' => '1')),
        ),

        array(
            'id'         => 'eb_price_range_max',
            'type'        => 'text',
            'class'       => 'small-text',
            'title'      => esc_html__('Price Range - Default Max Value', 'eagle-booking'),
            'subtitle'      => esc_html__('Set the maximum price', 'eagle-booking'),
            'default'    => '700',
            'required'  => array('eagle_booking_search_page_settings','contains',array('price_range_filter' => '1')),
        ),

      array(
          'id'          => 'eagle_booking_rooms_per_page',
          'type'        => 'text',
          'class'       => 'small-text',
          'title'       => esc_html__( 'Rooms per Page', 'eagle-booking' ),
          'subtitle'       => esc_html__( 'Set rooms per page for the search rooms page', 'eagle-booking' ),
          'default'     => '10',
      ),

      array(
          'id'         => 'eb_search_services',
          'type'       => 'switch',
          'title'      => esc_html__( 'Services', 'eagle-booking' ),
          'subtitle'        => esc_html__( 'Show/Hide the room services', 'eagle-booking' ),
          'default'    => true,
      ),

      array(
          'id'         => 'eb_search_quick_details',
          'type'       => 'switch',
          'title'      => esc_html__( 'Quick Details', 'eagle-booking' ),
          'subtitle'        => esc_html__( 'Show/Hide the room availability & details', 'eagle-booking' ),
          'default'    => true,
      ),

      array(
          'id'         => 'eb_search_quick_details_elements',
          'type'     => 'sortable',
          'mode'        => 'checkbox',
          'title'      => esc_html__('Quick Details Elements', 'eagle-booking'),
          'subtitle'        => esc_html__( 'Set the elements for the quick details', 'eagle-booking' ),
          'options'  => array(
                'room_availability' => 'Availability',
                'included_services' => 'Included Services',
                'additional_services' => 'Additional Services',
                'price_breakdown' => 'Price Breakdown',
            ),
          'default' => array(
                'room_availability' => '1',
                'included_services' => '1',
                'additional_services' => '1',
                'price_breakdown' => '1',
            ),
          'required'    => array( 'eb_search_quick_details', '=', true ),

      ),


    )
));


/* Booking Page */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-lines',
    'title'           => esc_html__( 'Booking Page', 'eagle-booking' ),
    'fields'          => array(

    array(
        'id'         => 'booking_page_mssg',
        'type'        => 'textarea',
        'title'      => esc_html__('Notification Message on the Booking Page.', 'eagle-booking'),
        'subtitle'   => esc_html__( 'Set a notification message on the booking page', 'eagle-booking' ),
        'required'   => array( 'booking_type', '=', 'builtin' )
    ),

    array(
        'id'         => 'checkout_form',
        'type'     => 'sortable',
        'mode'        => 'checkbox',
        'title'      => esc_html__('Booking Form Checkout Options', 'eagle-booking'),
        'subtitle'   => esc_html__('Display the registration and login forms on the booking page for non-logged-in users.', 'eagle-booking'),
        'options'  => array(
              'signin' => 'Sign In Form',
              'signup' => 'Sign Up Form',
              'guest' => 'Guest Checkout Form',
          ),

        'default' => array(
                'signin' => '0',
                'signup' => '0',
                'guest' => '0',
        )
    ),


    array(
        'id'         => 'eb_booking_form_fields',
        'type'        => 'checkbox',
        'title'      => esc_html__('Booking Form Fields', 'eagle-booking'),
        'subtitle'        => esc_html__( 'Set the fields of the booking form', 'eagle-booking' ),
        'options'  => array(
              'address' => esc_html__('Address', 'eagle-booking'),
              'city' => esc_html__('City', 'eagle-booking'),
              'country' => esc_html__('Country', 'eagle-booking'),
              'zip' => esc_html__('ZIP', 'eagle-booking'),
              'requests' => esc_html__('Requests', 'eagle-booking'),
              'arrival' => esc_html__('Arrival Time', 'eagle-booking'),
              'coupon' => esc_html__('Coupon', 'eagle-booking'),
              'terms_conditions' => esc_html__('Terms & Conditions', 'eagle-booking'),
          ),
          'default' => array(
              'address' => '1',
              'city' => '1',
              'country' => '1',
              'zip' => '1',
              'requests' => '1',
              'arrival' => '1',
              'coupon' => '1',
              'terms_conditions' => '1',
            ),

            'required'   => array( 'booking_type', '=', 'builtin' )
    ),

    // array(
    //     'id'         => 'eb_booking_form_dynamic_fields',
    //     'type'       => 'sidgen',
    //     // 'type'     => 'sortable',
    //     // 'mode'        => 'sidgen',
    //     'title'      => esc_html__( 'New Field (Currently in Beta)', 'eagle-booking' ),
    //     'subtitle'   => esc_html__( 'Add new field', 'eagle-booking' ),
    // ),

    array(
        'id'       => 'arrival_slots',
        'type'     => 'multi_text',
        'add_text' => __('Add New Slot', 'eagle-booking'),
        'title'      => __('Arrival Time Slots', 'eagle-booking'),
        'subtitle'   => __('Set the available arrival slots', 'eagle-booking' ),
        'required'  => array( 'eb_booking_form_fields', 'contains',array( 'arrival' => '1' ) ),
    ),

    array(
        'id'         => 'geo_ip_lookup',
        'type'       => 'switch',
        'class'       => 'small-text',
        'title'      => esc_html__('Phone Number geoIpLookup', 'eagle-booking'),
        'subtitle'   => esc_html__( 'Enable geoIpLookup for the phone number field. Please note that this option is disabled by default on some hosting providers.', 'eagle-booking' ),
        'default'    => true,
    ),


    array(
        'id'         => 'eb_booking_page_sticky_sidebar',
        'type'       => 'switch',
        'class'       => 'small-text',
        'title'      => esc_html__('Sticky Sidebar', 'eagle-booking'),
        'subtitle'   => esc_html__( 'Sticky option for the booking page sidebar', 'eagle-booking' ),
        'default'    => true,
    ),



    )
));

/* Room Details Page */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-key',
    'title'           => esc_html__( 'Room Page', 'eagle-booking' ),
    'fields'          => array(

        array(
            'id'         => 'room_breadcrumbs',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Breadcrumbs', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Show/Hide breadcrumbs on the room page header.', 'eagle-booking' ),
            'default'    => false
        ),

        array(
            'id'         => 'eagle_booking_room_page_settings',
            'type'     => 'sortable',
            'mode'        => 'checkbox',
            'title'      => esc_html__('Elements', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Manage the room details page elements', 'eagle-booking' ),
            'options'  => array(
                'basic_info' => 'Basic Info',
                'room_content' => 'Content',
                'room_availability' => 'Availability Calendar',
                'room_services' => 'Services',
                'room_additional_services' => 'Additional Services',
                'room_reviews' => 'Reviews',
                'similar_rooms' => 'Similar Rooms',
            ),
            'default' => array(
                'basic_info' => '1',
                'room_content' => '1',
                'room_availability' => '0',
                'room_services' => '1',
                'room_additional_services' => '0',
                'room_reviews' => '1',
                'similar_rooms' => '1',
            ),
        ),

        array(
            'id'         => 'room_hotel_branch',
            'type'       => 'switch',
            'title'      => esc_html__( 'Hotel Branch', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Show/Hide the hotel branch on the room details page', 'eagle-booking' ),
            'default'    => false,
        ),

        array(
            'id'         => 'eagle_booking_room_booking_form',
            'type'       => 'switch',
            'title'      => esc_html__( 'Booking Form', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Show/Hide the booking form on the room details page', 'eagle-booking' ),
            'default'    => true,
        ),

        array(
            'id'         => 'eb_room_page_sticky_sidebar',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Sticky Sidebar', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Sticky option for the room page sidebar', 'eagle-booking' ),
            'default'    => true,
        ),


        array(
            'id'         => 'room_info_elements',
            'type'     => 'sortable',
            'mode'        => 'checkbox',
            'title'      => esc_html__( 'Basic Info Elements', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Manage the basic info elements', 'eagle-booking' ),
            'options'  => array(
                  'guests' => 'Max Guests',
                  'booking_nights' => 'Max/Min Booking Nights',
                  'bed_type' => 'Bed Type',
                  'area' => 'Area',
                ),
                'default' => array(
                    'guests' => '1',
                    'booking_nights' => '1',
                    'bed_type' => '1',
                    'area' => '1',
                ),
            'required'  => array( 'eagle_booking_room_page_settings', 'contains',array( 'basic_info' => '1' ) ),
        ),

        array(
            'id'         => 'eb_room_slider_nav',
            'type'       => 'switch',
            'title'      => esc_html__( 'Slider Navigation', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Show/Hide the slider navigation on room details page', 'eagle-booking' ),
            'default'    => false,
        ),

        array(
            'id'         => 'room_slider_autoplay',
            'type'       => 'switch',
            'title'      => esc_html__( 'Slider Autoplay', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Enable/Disable the slider autoplay on room details page', 'eagle-booking' ),
            'default'    => true,
        ),

    )
));


/* Archive Rooms Page */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-th-list',
    'title'           => esc_html__( 'Rooms Archive Page', 'eagle-booking' ),
    'fields'          => array(

        array(
            'id'         => 'rooms_archive_header',
            'type'       => 'switch',
            'title'      => esc_html__( 'Header', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Show/Hide the rooms archive page title', 'eagle-booking' ),
            'default'    => true,
        ),

        array(
            'id'         => 'rooms_archive_header_type',
            'type'       => 'button_set',
            'title'      => esc_html__('Header Style', 'eagle-booking'),
            'subtitle'   => esc_html__('Choose rooms archive page header style', 'eagle-booking'),
            'multi'      => false,
            'options'    => array(
                'color'  => 'Color Background',
                'image'  => 'Image Background',
            ),
            'default'    => 'color',
            'required'   => array( 'rooms_archive_header', '=', true )
        ),

        array(
            'id'         => 'rooms_archive_header_image',
            'type'       => 'media',
            'title'      => esc_html__('Background Image', 'eagle-booking'),
            'subtitle'   => esc_html__('Upload your background image', 'eagle-booking'),
            'default'    => array( 'url' => esc_url(EB_URL.'/assets/images/page-header-bg.jpg') ),
            'required'   => array( 'rooms_archive_header_type', '=', 'image' )
        ),

        array(
            'id'         => 'rooms_archive_breadcrumbs',
            'type'       => 'switch',
            'class'       => 'small-text',
            'title'      => esc_html__('Breadcrumbs', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Show/Hide breadcrumbs on the rooms archive page header.', 'eagle-booking' ),
            'default'    => true,
            'required'   => array( 'rooms_archive_header', '=', true )
        ),

        array(
            'id'          => 'eagle_booking_rooms_archive_rooms_per_page',
            'type'     => 'text',
            'class'       => 'small-text',
            'title'    => __('Rooms per Page', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the rooms per page for the rooms archive page.', 'eagle-booking' ),
            'default'     => '10',
        ),

        array(
            'id'          => 'eagle_booking_rooms_archive_rooms_orderby',
            'type'     => 'select',
            'title'    => __('Sort by', 'eagle-booking'),
            'subtitle'     => esc_html__( 'Set the sort by for the rooms archive page.', 'eagle-booking' ),
            'class'    => 'small-select',
            'options'  => array(
              'none' => 'None',
              'ID' => 'ID',
              'title' => 'Title',
              'date' => 'Date',
              'rand' => 'Random',
              'menu_order' => 'Menu Order'
            ),
            'default'  => 'date',
        ),

    )
));


/* Payment Settings */
Redux::setSection( $opt_name, array(

        'icon'        => 'el el-usd',
        'title'       => esc_html__( 'Payment Settings', 'eagle-booking' ),
        'fields'      => array(

          array(
              'id'         => 'eagle_booking_payment_method',
              'type'     => 'sortable',
              'mode'        => 'checkbox',
              'title'      => esc_html__('Payment Gateways', 'eagle-booking'),
              'subtitle'   => esc_html__( 'Manage your payment gateways', 'eagle-booking' ),
              'options'  => array(
                    'paypal' => 'PayPal',
                    'stripe' => 'Stripe',
                    '2checkout' => '2Checkout',
                    'payu' => 'PayU India',
                    'paystack' => 'Paystack',
                    'razorpay' => 'Razorpay',
                    'flutterwave' => 'Flutterwave',
                    'vivawallet' => 'Viva Wallet',
                    'bank' => 'Bank Transfer',
                    'arrive' => 'Payment On Arrival',
                    'request' => 'Booking Request'
                ),
                'default' => array(
                      'paypal' => '1',
                      'stripe' => '0',
                      '2checkout' => '0',
                      'payu' => '0',
                      'paystack' => '0',
                      'razorpay' => '0',
                      'flutterwave' => '0',
                      'vivawallet' => '0',
                      'bank' => '0',
                      'arrive' => '1',
                      'request' => '1',
                  )
          ),

          array(
              'id'         => 'eagle_booking_deposit_amount',
              'type'       => 'text',
              'class'      => 'small-text',
              'title'      => esc_html__('Deposit Amount', 'eagle-booking'),
              'subtitle'   => esc_html__( 'Set the % of the total price (Only Number)', 'eagle-booking' ),
              'default'    => '100'
          ),

         array(
            'id'           => 'eb_room_price_type',
            'type'         => 'radio',
            'title'    => __('Room Price Type', 'eagle-booking'),
            'subtitle'     => esc_html__( "Set the room price type. This option can be overridden under each room's price settings.", 'eagle-booking' ),
            'options'  => array(
                'room_price_nights' => __( 'Room Price x Booking Nights', 'eagle-booking' ),
                'room_price_nights_guests' => __( 'Room Price x Booking Nights x Guests (or adults + children) Number', 'eagle-booking' ),
                'room_price_nights_guests_custom' => __( 'Room Price x Booking Nights + Price per guest (or adults + children) x Booking Nights', 'eagle-booking'  ),
              ),

            'default'  => 'room_price_nights',
        ),
    )
));


// PayPal
$section = array(
    'title'      => 'PayPal',
    'id'         => 'paypal',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(


      array(
          'id'         => 'eagle_booking_paypal_id',
          'type'        => 'text',
          'title'      => esc_html__('PayPal Email', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set your PayPal email', 'eagle-booking' ),
          'desc'       => wp_kses_post( 'Insert your paypal email (business account)', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
      ),

      array(
          'id'         => 'eagle_booking_paypal_token',
          'type'        => 'text',
          'title'      => esc_html__('PDT identity token Paypal', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the PDT', 'eagle-booking' ),
          'desc'       => wp_kses_post( 'Insert your PDT identity token - <a href="https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/paymentdatatransfer/" target="_blank">more details</a>', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
      ),


      array(
            'id'       => 'eagle_booking_paypal_currency',
            'type'     => 'select',
            'title'    => __('Paypal Currency', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the PayPal currency', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Select your PayPal Currency - <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">more details</a>', 'eagle-booking' ),
            'options'  => array(
                'AUD' => 'AUD',
                'BRL' => 'BRL',
                'CAD' => 'CAD',
                'CZK' => 'CZK',
                'DKK' => 'DKK',
                'EUR' => 'EUR',
                'HKD' => 'HKD',
                'HUF' => 'HUF',
                'ILS' => 'ILS',
                'JPY' => 'JPY',
                'MYR' => 'MYR',
                'MXN' => 'MXN',
                'NOK' => 'NOK',
                'NZD' => 'NZD',
                'PHP' => 'PHP',
                'PLN' => 'PLN',
                'GBP' => 'GBP',
                'RUB' => 'RUB',
                'SGD' => 'SGD',
                'SEK' => 'SEK',
                'CHF' => 'CHF',
                'TWD' => 'TWD',
                'THB' => 'THB',
                'TRY' => 'TRY',
                'USD' => 'USD',
                'INR' => 'INR',
            ),
            'default'  => 'EUR',
            'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
        ),

      array(
          'id'         => 'eagle_booking_paypal_developer_mode',
          'type'       => 'switch',
          'title'      => esc_html__( 'PayPal Developer Mode', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'PayPal Sandbox', 'eagle-booking' ),
          'desc'       => wp_kses_post( 'Payment will be processed via PayPal Sandbox for test purpose - <a href="https://developer.paypal.com/docs/classic/lifecycle/sb_about-accounts/" target="_blank">more details</a>', 'eagle-booking' ),
          'default'    => false,
          'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
      ),

      array(
          'id'         => 'eagle_booking_paypal_mssg',
          'type'        => 'textarea',
          'title'      => esc_html__('Paypal Message on Checkout', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the PayPal message in the checkout page', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
      ),

    )
);

Redux::setSection($opt_name, $section);

// Stripe
$section = array(
    'title'      => 'Stripe',
    'id'         => 'stripe',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'eagle_booking_stripe_public_key',
            'type'        => 'text',
            'title'      => esc_html__('Stripe Publishable Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Stripe publishable key', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your Stripe publishable key - <a href="https://stripe.com/docs/keys" target="_blank">more details</a>', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('stripe' => '1')),
        ),

        array(
            'id'         => 'eagle_booking_stripe_secret_key',
            'type'        => 'text',
            'title'      => esc_html__('Stripe Secret Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Stripe secret key', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your Stripe secret key - <a href="https://stripe.com/docs/keys" target="_blank">more details</a>', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('stripe' => '1')),
        ),

        array(
            'id'         => 'stripe_create_customer',
            'type'       => 'switch',
            'title'      => esc_html__( 'Create a customer', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Choose if you want to create a Stripe customer for every new user/payment.', 'eagle-booking' ),
            'default'    => false,
            'required'  => array('eagle_booking_payment_method','contains',array('paypal' => '1')),
        ),

        array(
            'id'       => 'eagle_booking_stripe_currency',
            'type'     => 'select',
            'title'    => __('Stripe Currency', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Stripe currency', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Select your Stripe Currency - <a href="https://stripe.com/docs/currencies" target="_blank">more details</a>', 'eagle-booking'),
            'options'  => array(
            'USD' => 'USD',
            'AED' => 'AED',
            'AFN' => 'AFN',
            'ALL' => 'ALL',
            'AMD' => 'AMD',
            'ANG' => 'ANG',
            'AOA' => 'AOA',
            'ARS' => 'ARS',
            'AUD' => 'AUD',
            'AWG' => 'AWG',
            'AZN' => 'AZN',
            'BAM' => 'BAM',
            'BBD' => 'BBD',
            'BDT' => 'BDT',
            'BGN' => 'BGN',
            'BIF' => 'BIF',
            'BMD' => 'BMD',
            'BND' => 'BND',
            'BOB' => 'BOB',
            'BRL' => 'BRL',
            'BSD' => 'BSD',
            'BWP' => 'BWD',
            'BZD' => 'BZD',
            'CAD' => 'CAD',
            'CDF' => 'CDF',
            'CHF' => 'CHF',
            'CLP' => 'CLP',
            'CNY' => 'CNY',
            'COP' => 'COP',
            'CRC' => 'CRC',
            'CVE' => 'CVE',
            'CZK' => 'CZK',
            'DJF' => 'DJK',
            'DKK' => 'DKK',
            'DOP' => 'DOP',
            'DZD' => 'DZP',
            'EGP' => 'EGP',
            'ETB' => 'ETB',
            'EUR' => 'EUR',
            'FJD' => 'FJD',
            'FKP' => 'FKP',
            'GBP' => 'BGP',
            'GEL' => 'GEL',
            'GIP' => 'GIP',
            'GMD' => 'GMD',
            'GNF' => 'GNF',
            'GTQ' => 'GTQ',
            'GYD' => 'GYD',
            'HKD' => 'HKD',
            'HNL' => 'HNL',
            'HRK' => 'HRK',
            'HTG' => 'HTG',
            'HUF' => 'HUF',
            'IDR' => 'IDR',
            'ILS' => 'ILS',
            'INR' => 'INR',
            'ISK' => 'ISK',
            'JMD' => 'JMD',
            'JPY' => 'JPY',
            'KES' => 'KES',
            'KGS' => 'KGS',
            'KHR' => 'KHR',
            'KMF' => 'KMF',
            'KRW' => 'KRW',
            'KYD' => 'KYD',
            'KZT' => 'KZT',
            'LAK' => 'LAK',
            'LBP' => 'LBP',
            'LKR' => 'LKR',
            'LSL' => 'LSL',
            'MAD' => 'MAD',
            'MDL' => 'MDL',
            'MGA' => 'MGA',
            'MKD' => 'MKD',
            'MMK' => 'MMK',
            'MNT' => 'MNT',
            'MOP' => 'MOP',
            'MRO' => 'MRO',
            'MUR' => 'MUR',
            'MVR' => 'MVR',
            'MWK' => 'MWK',
            'MXN' => 'MXN',
            'MYR' => 'MYR',
            'MZN' => 'MZN',
            'NAD' => 'NAD',
            'NGN' => 'NGN',
            'NIO' => 'NIO',
            'NOK' => 'NOK',
            'NPR' => 'NPR',
            'NZD' => 'NZD',
            'PAB' => 'PAB',
            'PEN' => 'PEN',
            'PGK' => 'PGK',
            'PHP' => 'PHP',
            'PKR' => 'PKR',
            'PLN' => 'PLN',
            'PYG' => 'PYG',
            'QAR' => 'QAR',
            'RON' => 'RON',
            'RSD' => 'RSD',
            'RUB' => 'RUB',
            'RWF' => 'RWF',
            'SAR' => 'SAR',
            'SBD' => 'SBD',
            'SCR' => 'SCR',
            'SEK' => 'SEK',
            'SGD' => 'SGD',
            'SHP' => 'SHP',
            'SLL' => 'SLL',
            'SOS' => 'SOS',
            'SRD' => 'SRD',
            'STD' => 'STD',
            'SVC' => 'SVC',
            'SZL' => 'SZL',
            'THB' => 'THB',
            'TJS' => 'TJS',
            'TOP' => 'TOP',
            'TRY' => 'TRY',
            'TTD' => 'TTD',
            'TWD' => 'TWD',
            'TZS' => 'TZS',
            'UAH' => 'UAH',
            'UGX' => 'UGX',
            'UYU' => 'UYU',
            'UZS' => 'UZS',
            'VND' => 'VND',
            'VUV' => 'VUV',
            'WST' => 'WST',
            'XAF' => 'XAF',
            'XCD' => 'XCD',
            'XOF' => 'XOF',
            'XPF' => 'XPF',
            'YER' => 'YER',
            'ZAR' => 'ZAR',
            'ZMW' => 'ZMW'
        ),
            'default'  => 'USD',
            'required'  => array('eagle_booking_payment_method','contains',array('stripe' => '1')),
    ),

        array(
            'id'         => 'eagle_booking_stripe_mssg',
            'type'        => 'textarea',
            'title'      => esc_html__('Stripe Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Stripe message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('stripe' => '1')),
        ),

    )
);


Redux::setSection($opt_name, $section);


// 2Checkout
$section = array(
    'title'      => '2Checkout',
    'id'         => '2checkout',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'eagle_booking_2checkout_account_number',
            'type'        => 'text',
            'title'      => esc_html__('2Checkout Merchant Code', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the 2Checkout Merchant Code', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your 2Checkout account number - <a href="https://knowledgecenter.2checkout.com/Documentation" target="_blank">more details</a>', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('2checkout' => '1')),
        ),

        array(
            'id'         => 'eagle_booking_2checkout_secret_word',
            'type'        => 'text',
            'title'      => esc_html__('2Checkout Secret Word', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the 2Checkout secret key', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your 2Checkout secret word - <a href="https://knowledgecenter.2checkout.com/Documentation" target="_blank">more details</a>', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('2checkout' => '1')),
        ),

        array(
              'id'       => 'eagle_booking_2checkout_currency',
              'type'     => 'select',
              'title'    => __('2Checkout Currency', 'eagle-booking'),
              'subtitle'   => esc_html__( 'Set the 2Checkout currency', 'eagle-booking' ),
              'desc'       => wp_kses_post( 'Select your 2Checkout Currency - <a href="https://knowledgecenter.2checkout.com/Documentation" target="_blank">more details</a>', 'eagle-booking'),
              'options'  => array(
                'USD' => 'USD',
                'AED' => 'AED',
                'AFN' => 'AFN',
                'ALL' => 'ALL',
                'AMD' => 'AMD',
                'ANG' => 'ANG',
                'AOA' => 'AOA',
                'ARS' => 'ARS',
                'AUD' => 'AUD',
                'AWG' => 'AWG',
                'AZN' => 'AZN',
                'BAM' => 'BAM',
                'BBD' => 'BBD',
                'BDT' => 'BDT',
                'BGN' => 'BGN',
                'BIF' => 'BIF',
                'BMD' => 'BMD',
                'BND' => 'BND',
                'BOB' => 'BOB',
                'BRL' => 'BRL',
                'BSD' => 'BSD',
                'BWP' => 'BWD',
                'BZD' => 'BZD',
                'CAD' => 'CAD',
                'CDF' => 'CDF',
                'CHF' => 'CHF',
                'CLP' => 'CLP',
                'CNY' => 'CNY',
                'COP' => 'COP',
                'CRC' => 'CRC',
                'CVE' => 'CVE',
                'CZK' => 'CZK',
                'DJF' => 'DJK',
                'DKK' => 'DKK',
                'DOP' => 'DOP',
                'DZD' => 'DZP',
                'EGP' => 'EGP',
                'ETB' => 'ETB',
                'EUR' => 'EUR',
                'FJD' => 'FJD',
                'FKP' => 'FKP',
                'GBP' => 'BGP',
                'GEL' => 'GEL',
                'GIP' => 'GIP',
                'GMD' => 'GMD',
                'GNF' => 'GNF',
                'GTQ' => 'GTQ',
                'GYD' => 'GYD',
                'HKD' => 'HKD',
                'HNL' => 'HNL',
                'HRK' => 'HRK',
                'HTG' => 'HTG',
                'HUF' => 'HUF',
                'IDR' => 'IDR',
                'ILS' => 'ILS',
                'INR' => 'INR',
                'ISK' => 'ISK',
                'JMD' => 'JMD',
                'JPY' => 'JPY',
                'KES' => 'KES',
                'KGS' => 'KGS',
                'KHR' => 'KHR',
                'KMF' => 'KMF',
                'KRW' => 'KRW',
                'KYD' => 'KYD',
                'KZT' => 'KZT',
                'LAK' => 'LAK',
                'LBP' => 'LBP',
                'LKR' => 'LKR',
                'LSL' => 'LSL',
                'MAD' => 'MAD',
                'MDL' => 'MDL',
                'MGA' => 'MGA',
                'MKD' => 'MKD',
                'MMK' => 'MMK',
                'MNT' => 'MNT',
                'MOP' => 'MOP',
                'MRO' => 'MRO',
                'MUR' => 'MUR',
                'MVR' => 'MVR',
                'MWK' => 'MWK',
                'MXN' => 'MXN',
                'MYR' => 'MYR',
                'MZN' => 'MZN',
                'NAD' => 'NAD',
                'NGN' => 'NGN',
                'NIO' => 'NIO',
                'NOK' => 'NOK',
                'NPR' => 'NPR',
                'NZD' => 'NZD',
                'PAB' => 'PAB',
                'PEN' => 'PEN',
                'PGK' => 'PGK',
                'PHP' => 'PHP',
                'PKR' => 'PKR',
                'PLN' => 'PLN',
                'PYG' => 'PYG',
                'QAR' => 'QAR',
                'RON' => 'RON',
                'RSD' => 'RSD',
                'RUB' => 'RUB',
                'RWF' => 'RWF',
                'SAR' => 'SAR',
                'SBD' => 'SBD',
                'SCR' => 'SCR',
                'SEK' => 'SEK',
                'SGD' => 'SGD',
                'SHP' => 'SHP',
                'SLL' => 'SLL',
                'SOS' => 'SOS',
                'SRD' => 'SRD',
                'STD' => 'STD',
                'SVC' => 'SVC',
                'SZL' => 'SZL',
                'THB' => 'THB',
                'TJS' => 'TJS',
                'TOP' => 'TOP',
                'TRY' => 'TRY',
                'TTD' => 'TTD',
                'TWD' => 'TWD',
                'TZS' => 'TZS',
                'UAH' => 'UAH',
                'UGX' => 'UGX',
                'UYU' => 'UYU',
                'UZS' => 'UZS',
                'VND' => 'VND',
                'VUV' => 'VUV',
                'WST' => 'WST',
                'XAF' => 'XAF',
                'XCD' => 'XCD',
                'XOF' => 'XOF',
                'XPF' => 'XPF',
                'YER' => 'YER',
                'ZAR' => 'ZAR',
                'ZMW' => 'ZMW'
            ),
              'default'  => 'USD',
              'required'  => array('eagle_booking_payment_method','contains',array('2checkout' => '1')),
          ),


        array(
            'id'         => 'eagle_booking_2checkout_sandbox_mode',
            'type'       => 'switch',
            'title'      => esc_html__( '2Checkout Sandbox', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Enable 2Checkout Sandbox', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Payment will be processed via 2Checkout Sandbox for test purpose - <a href="https://sandbox.2checkout.com" target="_blank">more details</a>', 'eagle-booking' ),
            'default'    => false,
            'required'  => array('eagle_booking_payment_method','contains',array('2checkout' => '1')),
        ),

        array(
            'id'         => 'eagle_booking_2checkout_mssg',
            'type'        => 'textarea',
            'title'      => esc_html__('2Checkout Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the 2Checkout message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('2checkout' => '1')),
        ),

    )
);


Redux::setSection($opt_name, $section);

// PayU
$section = array(
    'title'      => 'PayU',
    'id'         => 'payu',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(


        array(
            'id'         => 'eb_payu_merchant_key',
            'type'        => 'text',
            'title'      => esc_html__('PayU Merchant Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the PayU merchant key', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your PayU merchant key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('payu' => '1')),
        ),

        array(
            'id'         => 'eb_payu_merchant_salt',
            'type'        => 'text',
            'title'      => esc_html__('PayU Merchant Salt', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the PayU merchant salt', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Insert your PayU merchant salt', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('payu' => '1')),
        ),

        array(
            'id'         => 'eb_payu_sandbox',
            'type'       => 'switch',
            'title'      => esc_html__( 'PayU Sandbox', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Enable PayU Sandbox', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Payment will be processed via PayU Sandbox for test purpose.', 'eagle-booking' ),
            'default'    => false,
            'required'  => array('eagle_booking_payment_method','contains',array('payu' => '1')),
        ),

        array(
            'id'         => 'eb_payu_checkout_mssg',
            'type'        => 'textarea',
            'title'      => esc_html__('PayU Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the PayU message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('payu' => '1')),
        ),


    )
);

Redux::setSection($opt_name, $section);

// Paystack
$section = array(
    'title'      => 'Paystack',
    'id'         => 'paystack',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'paystack_public_key',
            'type'        => 'text',
            'title'      => esc_html__('Paystack Public Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Paystack public key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('paystack' => '1')),
        ),

        array(
            'id'         => 'paystack_secret_key',
            'type'        => 'text',
            'title'      => esc_html__('Paystack Secret Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Paystack secret key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('paystack' => '1')),
        ),

        array(
            'id'         => 'paystack_message',
            'type'        => 'textarea',
            'title'      => esc_html__('Paystack Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the paystack message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('paystack' => '1')),
        ),

        array(
            'id'       => 'paystack_currency',
            'type'     => 'select',
            'title'    => __('Paystack Currency', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the paystack currency', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Select your Paystack Currency - <a href="https://support.paystack.com/hc/en-us/articles/360009973779-What-currency-is-available-to-my-business-" target="_blank">more details</a>', 'eagle-booking'),
            'options'  => array(
              'GHS' => 'GHS',
              'NGN' => 'NGN',
              'USD' => 'USD',
              'ZAR' => 'ZAR',
          ),
            'default'  => 'GHS',
            'required'  => array('eagle_booking_payment_method','contains',array('paystack' => '1')),
        ),

    )
);

Redux::setSection($opt_name, $section);

// Flutterwave
$section = array(
    'title'      => 'Flutterwave',
    'id'         => 'flutterwave',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'flutterwave_public_key',
            'type'        => 'text',
            'title'      => esc_html__('Flutterwave Public Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Flutterwave public key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('flutterwave' => '1')),
        ),

        array(
            'id'         => 'flutterwave_secret_key',
            'type'        => 'text',
            'title'      => esc_html__('Flutterwave Secret Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Flutterwave secret key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('flutterwave' => '1')),
        ),

        array(
            'id'         => 'flutterwave_title',
            'type'        => 'text',
            'title'      => esc_html__('Flutterwave Title', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Flutterwave title', 'eagle-booking' ),
            'default'  => 'Flutterwave',
            'required'  => array('eagle_booking_payment_method','contains',array('flutterwave' => '1')),
        ),

        array(
            'id'         => 'flutterwave_message',
            'type'        => 'textarea',
            'title'      => esc_html__('Flutterwave Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the flutterwave message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('flutterwave' => '1')),
        ),

        array(
            'id'       => 'flutterwave_currency',
            'type'     => 'select',
            'title'    => __('Flutterwave Currency', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Flutterwave currency', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'Select your Flutterwave Currency - <a href="https://support.flutterwave.com/en/articles/3632719-accepted-currencies" target="_blank">more details</a>', 'eagle-booking'),
            'options'  => array(
              'GBP' => 'GBP',
              'CAD' => 'CAD',
              'CVE' => 'CVE',
              'CLP' => 'CLP',
              'CDF' => 'CDF',
              'EGP' => 'EGP',
              'EUR' => 'EUR',
              'GMD' => 'GMD',
              'GHS' => 'GHS',
              'GNF' => 'GNF',
              'KES' => 'KES',
              'LRD' => 'LRD',
              'MWK' => 'MWK',
              'MAD' => 'MAD',
              'MZN' => 'MZN',
              'SOL' => 'SOL',
              'NGN' => 'NGN',
              'RWF' => 'RWF',
              'SLL' => 'SLL',
              'STD' => 'STD',
              'ZAR' => 'ZAR',
              'TZS' => 'TZS',
              'UGX' => 'UGX',
              'USD' => 'USD',
              'XAF' => 'XAF',
              'XOF' => 'XOF',
              'ZMK' => 'ZMK',
              'BRL' => 'BRL',
              'ZMW' => 'ZMW',
              'MXN' => 'MXN',
              'ARS' => 'ARS',
          ),
            'default'  => 'GBP',
            'required'  => array('eagle_booking_payment_method','contains',array('flutterwave' => '1')),
        ),

    )
);


Redux::setSection($opt_name, $section);

// Viva Wallet
$section = array(
    'title'      => 'Viva Wallet',
    'id'         => 'vivawallet',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'vivawallet_public_key',
            'type'        => 'text',
            'title'      => esc_html__('Viva Wallet Client ID', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Viva Wallet public key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

        array(
            'id'         => 'vivawallet_secret_key',
            'type'        => 'text',
            'title'      => esc_html__('Viva Wallet Client Secret ', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Viva Wallet secret key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

        array(
            'id'         => 'vivawallet_source_code',
            'type'        => 'text',
            'title'      => esc_html__('Viva Wallet Source Code', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Viva Wallet source code', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

        array(
            'id'         => 'vivawallet_title',
            'type'        => 'text',
            'title'      => esc_html__('Viva Wallet Title', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Viva Wallet title', 'eagle-booking' ),
            'default'  => 'Viva Wallet',
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

        array(
            'id'         => 'vivawallet_demo_mode',
            'type'       => 'switch',
            'title'      => esc_html__( 'Viva Wallet Demo Mode', 'eagle-booking' ),
            'subtitle'   => esc_html__( 'Viva Wallet Demo Mode', 'eagle-booking' ),
            'desc'       => wp_kses_post( 'If Demo Mode is enabled, please use the credentials you got from <a href="https://demo.vivapayments.com/" target="_blank">demo.vivapayments.com</a>', 'eagle-booking' ),
            'default'    => false,
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

        array(
            'id'         => 'vivawallet_message',
            'type'        => 'textarea',
            'title'      => esc_html__('Viva Wallet Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Viva Wallet message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('vivawallet' => '1')),
        ),

    )
);

Redux::setSection($opt_name, $section);

// Razorpay
$section = array(
    'title'      => 'Razorpay',
    'id'         => 'razorpay',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

        array(
            'id'         => 'razorpay_public_key',
            'type'        => 'text',
            'title'      => esc_html__('Razorpay Public Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the razorpay public key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('razorpay' => '1')),
        ),

        array(
            'id'         => 'razorpay_secret_key',
            'type'        => 'text',
            'title'      => esc_html__('Razorpay Secret Key', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the razorpay secret key', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('razorpay' => '1')),
        ),

        array(
            'id'         => 'razorpay_title',
            'type'        => 'text',
            'title'      => esc_html__('Razorpay Title', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the Razorpay title', 'eagle-booking' ),
            'default'  => 'Razorpay',
            'required'  => array('eagle_booking_payment_method','contains',array('razorpay' => '1')),
        ),

        array(
            'id'         => 'razorpay_message',
            'type'        => 'textarea',
            'title'      => esc_html__('Razorpay Message on Checkout', 'eagle-booking'),
            'subtitle'   => esc_html__( 'Set the razorpay message in the checkout page', 'eagle-booking' ),
            'required'  => array('eagle_booking_payment_method','contains',array('razorpay' => '1')),
        ),

    )
);


Redux::setSection($opt_name, $section);

// Bank
$section = array(
    'title'      => 'Bank',
    'id'         => 'bank',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

      array(
          'id'         => 'eagle_booking_bank_mssg',
          'type'        => 'textarea',
          'title'      => esc_html__('Bank Transfer Message on Checkout', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the Bank Transer message in the checkout page', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('bank' => '1')),
      ),


    )
);

Redux::setSection($opt_name, $section);

// Arrive
$section = array(
    'title'      => 'Payment on Arrival',
    'id'         => 'arrive',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

      array(
          'id'         => 'eagle_booking_arrive_mssg',
          'type'        => 'textarea',
          'title'      => esc_html__('Payment On Arrival Message on Checkout', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the Payment On Arrival message in the checkout page', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('arrive' => '1')),
      ),


    )
);
Redux::setSection($opt_name, $section);

// Booking Request
$section = array(
    'title'      => 'Booking Request',
    'id'         => 'request',
    'subsection' => true,
    'desc'       => '',
    'fields'     => array(

      array(
          'id'         => 'eagle_booking_request_mssg',
          'type'        => 'textarea',
          'title'      => esc_html__('Booking Request Message on Checkout', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the Booking Request message in the checkout page', 'eagle-booking' ),
          'required'  => array('eagle_booking_payment_method','contains',array('request' => '1')),
      ),


    )
);
Redux::setSection($opt_name, $section);




/* Email Settings */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-envelope',
    'title'           => esc_html__( 'Email Settings', 'eagle-booking' ),
    'fields'          => array(

      array(
          'id'         => 'eagle_booking_message',
          'type'        => 'checkbox',
          'title'      => esc_html__('Booking Confirmation', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the email booking confirmation', 'eagle-booking' ),
          'options'  => array(
                'email_guest' => 'Email Guest on Booking',
                'email_admin' => 'Email Admin on Booking',
            ),
            'default' => array(
                  'email_guest' => '1',
                  'email_admin' => '1',
              )
      ),

      array(
          'id'         => 'eagle_booking_message_sender_name',
          'type'        => 'text',
          'title'      => esc_html__('Sender Name', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the sender name', 'eagle-booking' ),
          'default'    => get_option('blogname'),
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'eagle_booking_message_sender_email',
          'type'        => 'text',
          'title'      => esc_html__('Sender Email', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the sender email', 'eagle-booking' ),
          'default'    => get_option('admin_email'),
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'eagle_booking_message_admin_email',
          'type'        => 'text',
          'title'      => esc_html__('Receiver Email', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the receiver email', 'eagle-booking' ),
          'desc'      => esc_html__('For multiple emails separate them by comma.', 'eagle-booking'),
          'default'    => get_option('admin_email'),
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'email_customer_text',
          'type'        => 'textarea',
          'title'      => __('Customer Email Text', 'eagle-booking'),
          'subtitle'   => __( 'Add additional text for the customer email', 'eagle-booking' ),
          'default'    => '',
          'required'   => array( 'eagle_booking_message', '=', true )
      ),

      array(
        'id'         => 'email_hotel_logo',
        'type'       => 'switch',
        'class'       => 'small-text',
        'title'      => esc_html__('Hotel Logo on Email', 'eagle-booking'),
        'subtitle'   => esc_html__( 'Please Note: Most email providers block the automatic image downloads by default, which could cause your recipients to delete your email or even mark it as spam. Hotel Logo can be set under: General Settings > Hotel Logo', 'eagle-booking' ),
        'default'    => true,
        'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
    ),


      array(
          'id'          => 'eagle_booking_message_template_bg',
          'type'        => 'color',
          'title'       => esc_html__( 'Background', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template background color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#f5f3f0',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_border',
          'type'        => 'color',
          'title'       => esc_html__( 'Border Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template border color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#f0f0f0',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_color',
          'type'        => 'color',
          'title'       => esc_html__( 'Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template text color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#858a99',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_link_color',
          'type'        => 'color',
          'title'       => esc_html__( 'Links Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template links color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#deb666',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_header_bg',
          'type'        => 'color',
          'title'       => esc_html__( 'Header Background', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template header background color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#deb666',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_header_color',
          'type'        => 'color',
          'title'       => esc_html__( 'Header Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template header text color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#ffffff',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_footer_bg',
          'type'        => 'color',
          'title'       => esc_html__( 'Footer Background Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template footer background color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#f5f5f5',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_footer_border',
          'type'        => 'color',
          'title'       => esc_html__( 'Footer Top Border Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template footer top border color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#f5f5f5',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'          => 'eagle_booking_message_template_footer_color',
          'type'        => 'color',
          'title'       => esc_html__( 'Footer Color', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Set the email template footer text color', 'eagle-booking' ),
          'transparent' => false,
          'default'     => '#777777',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'eagle_booking_message_template_facebook_url',
          'type'        => 'text',
          'title'      => esc_html__('Facebook URL', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the email template Facebook URL', 'eagle-booking' ),
          'default'    => '',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'eagle_booking_message_template_twitter_url',
          'type'        => 'text',
          'title'      => esc_html__('Twitter URL', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the email template Twitter URL', 'eagle-booking' ),
          'default'    => '',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

      array(
          'id'         => 'eagle_booking_message_template_instagram_url',
          'type'        => 'text',
          'title'      => esc_html__('Instagram URL', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the email template Instagram URL', 'eagle-booking' ),
          'default'    => '',
          'required'  => array('eagle_booking_message','contains',array('email_admin' => '1', 'email_guest' => '1' )),
      ),

    )
));



/* Admin Settngs */
Redux::setSection( $opt_name , array(

    'icon'            => 'el el-wrench',
    'title'           => esc_html__( 'Admin Settings', 'eagle-booking' ),
    'fields'          => array(


        array(
            'id'    => 'license_link',
            'type'  => 'info',
            'title' => esc_html__('License', 'eagle-booking'),
            'style' => 'info',
            'desc'      =>  wp_kses_post( 'Manage your <a href="admin.php?page=eb_license">Eagle Booking License</a>', 'eagle-booking'),
        ),

      array(
          'id'         => 'eb_admin_booking_stats',
          'type'       => 'switch',
          'title'      => esc_html__( 'Booking Stats', 'eagle-booking' ),
          'subtitle'   => esc_html__( 'Show/Hide the booking stats on the admin bookings page', 'eagle-booking' ),
          'default'    => true,
      ),

      array(
          'id'         => 'eb_bookings_per_page',
          'type'       => 'text',
          'class'      => 'small-text',
          'title'      => esc_html__('Bookings per Page', 'eagle-booking'),
          'subtitle'   => esc_html__( 'Set the bookings per page for the admin bookings page', 'eagle-booking' ),
          'default'    => '20'
      ),

      array(
        'id'         => 'eb_image_sizes',
        'type'       => 'checkbox',
        'multi'      => true,
        'title'      => esc_html__('Disable additional image sizes', 'eagle-booking'),
        'subtitle'   => esc_html__('By default, Eagle Booking generates additional image size for each of the layouts it offers. You can use this option to avoid creating additional sizes if you are not using particular layout in order to save your server space.', 'eagle-booking'),
        'options'    => array(
            'eagle_booking_image_size_720_470'     => esc_html__('720 x 470 (Rooms, Places and Blog Posts Elements)', 'eagle-booking'),
            'eagle_booking_image_size_1170_680'    => esc_html__('1170 x 680 (Room Details Page)', 'eagle-booking'),
            'eagle_booking_image_size_1920_800'    => esc_html__('1920 x 800 (Place Details Page)', 'eagle-booking'),
        ),

        'default' => array()
        ),

)
));
