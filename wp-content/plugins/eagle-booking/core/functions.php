<?php

/* --------------------------------------------------------------------------
 * Get nights number
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout) {

    $eagle_booking_get_nights_number = 0;

    $eagle_booking_checkin = DateTime::createFromFormat("m/d/Y", $eagle_booking_checkin)->format('Y/m/d');
    $eagle_booking_checkout = DateTime::createFromFormat("m/d/Y", $eagle_booking_checkout)->format('Y/m/d');

    while ($eagle_booking_checkin <= $eagle_booking_checkout) {

        $eagle_booking_checkin = date('Y/m/d', strtotime($eagle_booking_checkin . ' + 1 days'));
        $eagle_booking_get_nights_number = $eagle_booking_get_nights_number + 1;

    }

    return $eagle_booking_get_nights_number - 1;

}

/* --------------------------------------------------------------------------
 * @ Get PHP Date format
 * @ Return Date
 * @ since  1.0.6
---------------------------------------------------------------------------*/
function eagle_booking_get_php_date_format() {

    $eagle_booking_date_format = eb_get_option('eagle_booking_date_format');

    if ($eagle_booking_date_format == 'dd/mm/yyyy') {
        $eagle_booking_php_date_format = 'd/m/Y';
    } elseif ($eagle_booking_date_format == 'mm/dd/yyyy') {
        $eagle_booking_php_date_format = 'm/d/Y';
    } else {
        $eagle_booking_php_date_format = 'Y/m/d';
    }

    return $eagle_booking_php_date_format;

}

/* --------------------------------------------------------------------------
 * @ Get Displayd Date String and format it to system format
 * @ Return Date
 * @ since  1.0.6
---------------------------------------------------------------------------*/
function eagle_booking_system_date_format($eagle_booking_orginal_date) {

    $eagle_booking_date = DateTime::createFromFormat(eagle_booking_get_php_date_format(), $eagle_booking_orginal_date);
    $eagle_booking_system_date = $eagle_booking_date->format('m/d/Y');

    // Return system date format m/d/Y
    return $eagle_booking_system_date;
}

/* --------------------------------------------------------------------------
 * @ Get System Date String and format it to displayd date
 * @ Return Date
 * @ since  1.0.6
---------------------------------------------------------------------------*/
function eagle_booking_displayd_date_format($eagle_booking_orginal_date) {

    if (!empty($eagle_booking_orginal_date)) {

        $eagle_booking_date = DateTime::createFromFormat('m/d/Y', $eagle_booking_orginal_date);

        $eagle_booking_displayd_date = $eagle_booking_date->format(eagle_booking_get_php_date_format());

        return $eagle_booking_displayd_date;

    }

}

/* --------------------------------------------------------------------------
 * Check room quantity availability
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_is_qnt_available($eagle_booking_strings_dates_orders, $eagle_booking_checkin, $eagle_booking_checkout, $eagle_booking_id) {

    // range date
    $eagle_booking_range_night = eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout);

    // get room qnt
    $eagle_booking_meta_box_qnt = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_quantity', true);
    if ($eagle_booking_meta_box_qnt == '') {
        $eagle_booking_meta_box_qnt = 1;
    }

    // DATE FORMAT
    $eagle_booking_date_count = DateTime::createFromFormat("m/d/Y", $eagle_booking_checkin)->format('Y/m/d');

    if ($eagle_booking_strings_dates_orders != '') {

        for ($eagle_booking_i = 1; $eagle_booking_i <= $eagle_booking_range_night; $eagle_booking_i++) {

            $eagle_booking_num_reservations_per_day = substr_count($eagle_booking_strings_dates_orders, $eagle_booking_date_count);

            if ($eagle_booking_num_reservations_per_day >= $eagle_booking_meta_box_qnt) {
                return 0;
            }

            $eagle_booking_date_count = date('Y/m/d', strtotime($eagle_booking_date_count . ' + 1 days'));

        }

    }

    return 1;

}

/* --------------------------------------------------------------------------
 * Get room image
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_get_room_img_url($eagle_booking_id, $image_size) {

    $eagle_booking_image_id = get_post_thumbnail_id($eagle_booking_id);
    $eagle_booking_image_attributes = wp_get_attachment_image_src($eagle_booking_image_id, $image_size);
    $eagle_booking_img_src = $eagle_booking_image_attributes[0];

    return esc_url($eagle_booking_img_src);

}

/* --------------------------------------------------------------------------
 * Check if booking exist (protect multiple bookings)
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eb_booking_exist(
    $eagle_booking_room_id,
    $eagle_booking_checkin,
    $eagle_booking_checkout,
    $eagle_booking_user_email
) {

    global $wpdb;

    $eagle_booking_table_name = $wpdb->prefix . 'eagle_booking';

    // QUERY
    $eagle_booking_booking_ids = $wpdb->get_results("SELECT id FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eagle_booking_room_id AND date_from = '$eagle_booking_checkin' AND date_to = '$eagle_booking_checkout' AND paypal_email = '$eagle_booking_user_email'");

    // NO RESULTS
    if (empty($eagle_booking_booking_ids)) {

        return 0;

    } else {

        return 1;

    }

}

/* --------------------------------------------------------------------------
 * Get plugin options
 * @since  1.0.0
---------------------------------------------------------------------------*/
if ( !function_exists('eb_get_option') ):
    function eb_get_option($option) {

        global $eagle_booking;

        if (empty($eagle_booking_settings)) {
            $eagle_booking_settings = get_option('eagle_booking_settings');
        }

        if (isset($eagle_booking_settings[$option])) {
            return is_array($eagle_booking_settings[$option]) && isset($eagle_booking_settings[$option]['url']) ? $eagle_booking_settings[$option]['url'] : $eagle_booking_settings[$option];
        } else {
            return false;
        }

    }
endif;

/* --------------------------------------------------------------------------
 * Create Sidebar
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_single_cause_sidebar() {

    // Sidebar Main
    register_sidebar(array(
        'name' => esc_html__('Eagle Booking Sidebar', 'eagle-booking'),
        'id' => 'eagle_booking_single_room_sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

}
add_action('widgets_init', 'eagle_booking_single_cause_sidebar');

/* --------------------------------------------------------------------------
 * Get post id in edit page
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_get_the_edit_post_id() {

    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } elseif (isset($_POST['post_ID'])) {
        $post_id = $_POST['post_ID'];
    } else {
        $post_id = '';
    }

    return $post_id;

}

/* --------------------------------------------------------------------------
 * Get Currency
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eb_currency() {

    $eagle_booking_currency = eb_get_option('eagle_booking_currency');

    return $eagle_booking_currency;

}

/* --------------------------------------------------------------------------
 * Get Currency Position
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eb_currency_position() {

    $eagle_booking_currency_position = eb_get_option('eagle_booking_currency_position');

    return $eagle_booking_currency_position;

}

/* --------------------------------------------------------------------------
 * Get room min price
 * @since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_room_min_price($eagle_booking_id) {

    $eagle_booking_room_min_price = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price', true);
    $eagle_booking_room_min_price_mon = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_mon', true);if (empty($eagle_booking_room_min_price_mon)) {$eagle_booking_room_min_price_mon = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_tue = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_tue', true);if (empty($eagle_booking_room_min_price_tue)) {$eagle_booking_room_min_price_tue = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_wed = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_wed', true);if (empty($eagle_booking_room_min_price_wed)) {$eagle_booking_room_min_price_wed = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_thu = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_thu', true);if (empty($eagle_booking_room_min_price_thu)) {$eagle_booking_room_min_price_thu = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_fri = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_fri', true);if (empty($eagle_booking_room_min_price_fri)) {$eagle_booking_room_min_price_fri = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_sat = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_sat', true);if (empty($eagle_booking_room_min_price_sat)) {$eagle_booking_room_min_price_sat = $eagle_booking_room_min_price;}
    $eagle_booking_room_min_price_sun = get_post_meta($eagle_booking_id, 'eagle_booking_mtb_room_price_sun', true);if (empty($eagle_booking_room_min_price_sun)) {$eagle_booking_room_min_price_sun = $eagle_booking_room_min_price;}

    $eagle_booking_room_min_price = min($eagle_booking_room_min_price, $eagle_booking_room_min_price_mon, $eagle_booking_room_min_price_tue, $eagle_booking_room_min_price_wed, $eagle_booking_room_min_price_thu, $eagle_booking_room_min_price_fri, $eagle_booking_room_min_price_sat, $eagle_booking_room_min_price_sun);

    return $eagle_booking_room_min_price;

}

/* --------------------------------------------------------------------------
 * Get room formatted price
 * @since  1.0.7
 * @modified 1.3.3.1
---------------------------------------------------------------------------*/
function eb_formatted_price($eb_original_price, $echo = true, $decimals = true) {

    $eb_decimal_number = eb_get_option('eagle_booking_decimal_number');
    $eb_decimal_separator = eb_get_option('eagle_booking_decimal_separator');
    $eb_thousands_separator = eb_get_option('eagle_booking_thousands_separator');

    if ( $decimals == true ) {

        // Bug: if no additional service is selected
        $eb_format_price = number_format( $eb_original_price, $eb_decimal_number, $eb_decimal_separator, $eb_thousands_separator );

    } else {

        $eb_format_price = $eb_original_price;

    }

    if ($echo == true) {

        echo $eb_format_price;

    } else {

        return $eb_format_price;
    }

}

/* --------------------------------------------------------------------------
 * Get price
 * Return formatted, currency, currency position
 * @since  1.3.3
---------------------------------------------------------------------------*/
function eb_price( $price = '', $html = true ) {

    if ( !empty ( $price) ) {

            if ( eb_currency_position() == 'before') {

                if ( $html == true ) {

                    $price = '<span class="price-currency">'.eb_currency().'</span>'.'<span class="price-amount">'.eb_formatted_price( $price, false ).'</span>';

                } else {

                    $price = eb_currency().eb_formatted_price( $price, false );
                }

            } else {

                if( $html == true ) {

                    $price = '<span class="price-amount">'.eb_formatted_price( $price, false ).'</span>'.'<span class="price-currency">'.eb_currency().'</span>';

                } else {

                    $price = eb_formatted_price( $price, false ).eb_currency();

                }

            }


        return $price;


    } else {

        return;
    }


}

/* --------------------------------------------------------------------------
 * @ Get Rooms List
 * @ Return array
 * @ since  1.0.9
---------------------------------------------------------------------------*/
function eagle_booking_rooms_list() {

    $args = array(
        'post_type' => 'eagle_rooms',
        'lang' => '',
        'posts_per_page' => -1,
    );
    $rooms = get_posts($args);
    $rooms_array = array();

    if ($rooms) {
        foreach ($rooms as $room) {
            $rooms_array[$room->ID] = $room->post_title;
        }
    }

    return $rooms_array;
}

/* --------------------------------------------------------------------------
 * @ Get Room Normal Services
 * @ Return array
 * @ since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_normal_services() {

    $args = array(
        'post_type' => 'eagle_services',
        'posts_per_page' => -1,
        'suppress_filters' => false
    );

    $posts = get_posts($args);
    $normal_services = array();

    if ($posts) {
        foreach ($posts as $post) {

            if ($post->eagle_booking_mtb_service_type == 'normal') {

                $normal_services[$post->ID] = $post->post_title;

            }

        }
    }

    return $normal_services;
}

/* --------------------------------------------------------------------------
 * @ Get Room Additional Services
 * @ Return array
 * @ since  1.0.0
---------------------------------------------------------------------------*/
function eagle_booking_additional_services() {

    $args = array(
        'post_type' => 'eagle_services',
        'posts_per_page' => -1,
        'suppress_filters' => false
    );

    $posts = get_posts($args);
    $additional_services = array();

    if ($posts) {
        foreach ($posts as $post) {

            if ($post->eagle_booking_mtb_service_type == 'additional') {

                $additional_services[$post->ID] = $post->post_title;

            }

        }
    }

    return $additional_services;
}

/* --------------------------------------------------------------------------
 * @ Get Room Price Exceptions
 * @ Return array
 * @ since  1.0.4
---------------------------------------------------------------------------*/
function eagle_booking_get_price_exceptions() {

    $args = array(
        'post_type' => 'eagle_exceptions',
        'posts_per_page' => -1,
    );

    $posts = get_posts($args);
    $price_exceptions = array();

    if ($posts) {
        foreach ($posts as $post) {

            if ($post->eagle_booking_mtb_exception_type == 'price') {

                $price_exceptions[$post->ID] = $post->post_title.' ('.$post->eagle_booking_mtb_exception_date_from.' → '.$post->eagle_booking_mtb_exception_date_to.' ' .__('New Price', 'eagle-booking').': '.  $post->eagle_booking_mtb_exception_price.')';

            }

        }
    }

    return $price_exceptions;

}

/* --------------------------------------------------------------------------
 * @ Get Room Taxes
 * @ Return array
 * @ since  1.3.3
---------------------------------------------------------------------------*/
function eb_taxes() {

    $taxes = get_option('eb_taxes');

    $not_gloabl_taxes = array();

    if ( $taxes ) {

        foreach( $taxes as $key => $item ) {

            $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
            $entry_title = !empty( $item["title"] ) ? $item["title"] :  '';

            // Global Taxes are included by default
            if ( $item["global"] != true ) {

                $not_gloabl_taxes[$entry_id] = $entry_title;

            }

        }

    } else {

        $not_gloabl_taxes = "No Entries";

    }

    return $not_gloabl_taxes;

}

/* --------------------------------------------------------------------------
 * @ Get Room Fees
 * @ Return array
 * @ since  1.3.3
---------------------------------------------------------------------------*/
function eb_fees() {

    $fees = get_option('eb_fees');

    $not_gloabl_fees = array();

    if ( $fees ) {

        foreach( $fees as $key => $item ) {

            $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
            $entry_title = !empty( $item["title"] ) ? $item["title"] :  '';

            // Global Fees are included by default
            if ( $item["global"] != true ) {

                $not_gloabl_fees[$entry_id] = $entry_title;

            }

        }

    } else {

        $not_gloabl_fees = "No Entries";

    }

    return $not_gloabl_fees;

}

/* --------------------------------------------------------------------------
 * @ Get Room Reviews
 * @ Return array
 * @ since  1.0.4
---------------------------------------------------------------------------*/
function eagle_booking_get_reviews() {

    $args = array(
        'post_type' => 'eagle_reviews',
        'posts_per_page' => -1,
        'suppress_filters' => false
    );

    $posts = get_posts($args);
    $eagle_booking_reviews = array();

    if ($posts) {
        foreach ($posts as $post) {

            $eagle_booking_reviews[$post->ID] = $post->post_title.' - '.$post->ID;
        }
    }

    return $eagle_booking_reviews;

}

/* --------------------------------------------------------------------------
 * @ Get Room Block Exceptions
 * @ Return array
 * @ since  1.0.4
---------------------------------------------------------------------------*/
function eagle_booking_get_block_exceptions() {

    $args = array(
        'post_type' => 'eagle_exceptions',
        'posts_per_page' => -1,
    );

    $posts = get_posts($args);
    $block_exceptions = array();

    if ($posts) {
        foreach ($posts as $post) {

            if ($post->eagle_booking_mtb_exception_type == 'block') {

                $block_exceptions[$post->ID] = $post->post_title.' ( '.$post->eagle_booking_mtb_exception_date_from.' → '.$post->eagle_booking_mtb_exception_date_to. ' )';

            }

        }
    }

    return $block_exceptions;

}

/* --------------------------------------------------------------------------
 * @ Get Date Format
 * @ Return string
 * @ since  1.0.6
---------------------------------------------------------------------------*/
function eagle_booking_get_date_format($eagle_booking_date_letters = NULL) {

    if (isset($eagle_booking_date_letters) && $eagle_booking_date_letters === 'uppercase') {

        $eagle_booking_date_format = strtoupper(eb_get_option('eagle_booking_date_format'));

    } else {

        $eagle_booking_date_format = eb_get_option('eagle_booking_date_format');
    }

    echo $eagle_booking_date_format;

}

/* --------------------------------------------------------------------------
 * @ Get User Details
 * @ Since  1.1.6
---------------------------------------------------------------------------*/
function eb_user($eb_user_info) {

    if ( is_user_logged_in() && $eb_user_info != '' ) {

        $eb_current_user = wp_get_current_user();

        echo esc_html($eb_current_user->$eb_user_info);

    } else {

        return false;

    }

}

/* --------------------------------------------------------------------------
 * @ Update cookie after user login (set cookies after login otherwise causes invalid nonce on sign out)
 * @ Since  1.1.6
---------------------------------------------------------------------------*/

function eb_update_user_cookie( $logged_in_cookie ){

    $_COOKIE[LOGGED_IN_COOKIE] = $logged_in_cookie;
}

add_action( 'set_logged_in_cookie', 'eb_update_user_cookie' );


/* --------------------------------------------------------------------------
 * @ User Sign In AJAX
 * @ Since  1.1.6
---------------------------------------------------------------------------*/
function eb_user_sing_in() {

    // Recover value form AJAX Request
    $eb_user_sign_in_username = sanitize_text_field( $_GET['eb_user_sign_in_username'] );
    $eb_user_sign_in_password = sanitize_text_field( $_GET['eb_user_sign_in_password'] );

    // Verify nonce
    $eb_sign_in_nonce = $_GET['eb_user_sign_in_nonce'];

    if ( !wp_verify_nonce($eb_sign_in_nonce, 'eb_nonce') ) {

        $eb_return_data['status'] = 'failed';
        $eb_return_data['message'] = 'Invalid Nonce';

    } else {

        $info = array();
        $info['user_login'] = $eb_user_sign_in_username;
        $info['user_password'] = $eb_user_sign_in_password;
        $info['remember'] = true;

        $user_signon = wp_signon($info, false);

        if (is_wp_error($user_signon)) {

            $eb_return_data['status'] = 'failed';
            $eb_return_data['message'] = __('Wrong username or password.', 'eagle-booking');

        } else {

            wp_set_current_user($user_signon->ID);
            wp_set_auth_cookie($user_signon->ID);
            $eb_current_user_id = get_current_user_id();
            $eb_current_user = wp_get_current_user();

            $eb_return_data['status'] = 'success';
            $eb_return_data['message'] = __('Logged in as', 'eagle-booking').', '.wp_get_current_user()->user_login .'!';
            $eb_return_data['logout_text'] = __('Log Out', 'eagle-booking');
            $eb_return_data['redirect_mssg'] = __('Signed in successfully, redirecting...', 'eagle-booking');
            $eb_return_data['redirect_url'] = eb_account_page().'?dashboard';
            $eb_return_data['firstname'] = get_user_meta($eb_current_user_id, 'first_name', true);
            $eb_return_data['lastname'] = get_user_meta($eb_current_user_id, 'last_name', true);
            $eb_return_data['phone'] = get_user_meta($eb_current_user_id, 'user_phone', true);
            $eb_return_data['address'] = get_user_meta($eb_current_user_id, 'user_address', true);
            $eb_return_data['city'] = get_user_meta($eb_current_user_id, 'user_city', true);
            $eb_return_data['country'] = get_user_meta($eb_current_user_id, 'user_country', true);
            $eb_return_data['zip'] = get_user_meta($eb_current_user_id, 'user_zip', true);
            $eb_return_data['email'] = $eb_user_email = $eb_current_user->user_email;

            // Re-create nonce on sign in tu be used on sign out
            $eb_return_data['new_nonce'] = wp_create_nonce('eb_nonce');
        }
    }

    wp_send_json($eb_return_data);

}

// Actions
add_action( 'wp_ajax_eb_user_sign_in_action', 'eb_user_sing_in' );
add_action( 'wp_ajax_nopriv_eb_user_sign_in_action', 'eb_user_sing_in' );


/* --------------------------------------------------------------------------
 * @ User Sign Out AJAX
 * @ Since  1.1.6
---------------------------------------------------------------------------*/
function eb_user_sing_out() {

        // Verify nonce
        $eb_logout_nonce = $_GET['eb_sign_out_nonce'];

        if ( !wp_verify_nonce($eb_logout_nonce, 'eb_nonce') ) {

            $eb_return_data['status'] = 'failed';
            $eb_return_data['message'] = 'Invalid Nonce';

        } else {

            // Check if user is signed in
            if (is_user_logged_in()) {

                wp_logout();

                // Fix: the user is still not logged out, clear cookies otherwise causes invalid nonce on sing in
                $_COOKIE[LOGGED_IN_COOKIE] = 0;

                $eb_return_data['status'] = 'success';
                $eb_return_data['message'] = 'Successfully logged out';

                // Re-create nonce on logout to be used on sign in
                $eb_return_data['new_nonce'] = wp_create_nonce('eb_nonce');

            } else {

                $eb_return_data['status'] = 'failed';
                $eb_return_data['message'] = 'You are not logged in';

            }
        }

  wp_send_json($eb_return_data);

}

// Actions
add_action( 'wp_ajax_eb_user_sign_out_action', 'eb_user_sing_out' );
add_action( 'wp_ajax_nopriv_eb_user_sign_out_action', 'eb_user_sing_out' );


/* --------------------------------------------------------------------------
 * @ User Sign Up AJAX
 * @ Since  1.1.6
---------------------------------------------------------------------------*/

function eb_user_sing_up() {

    $new_user_name = stripcslashes($_GET['eb_user_sign_up_username']);
    $new_user_email = stripcslashes($_GET['eb_user_sign_up_email']);
    $new_user_password = stripcslashes($_GET['eb_user_sign_up_password']);
    $new_user_first_name = stripcslashes($_GET['eb_user_sign_up_first_name']);
    $new_user_last_name = stripcslashes($_GET['eb_user_sign_up_last_name']);

    empty($new_user_first_name) ?? '';
    empty($new_user_last_name) ?? '';

    $user_nice_name = strtolower($GETT['eb_user_sign_up_email']);

    $user_data = array(
        'user_login' => $new_user_name,
        'user_email' => $new_user_email,
        'user_pass' => $new_user_password,
        'user_nicename' => $user_nice_name,
        'display_name' => $new_user_first_name,

         // New Fields
        'first_name' => $new_user_first_name,
        'last_name' => $new_user_last_name,

    );

    $user_id = wp_insert_user($user_data);

    if (!is_wp_error($user_id)) {

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        $user = get_user_by( 'id', $user_id );
        do_action( 'wp_login', $user->user_login );

        // Set new user role (created on plugin installation)
        $user->set_role('eb_guest');

        $eb_return_data['status'] = 'success';
        $eb_return_data['mssg'] = __('Sign up successful, redirecting...', 'eagle-booking');
        $eb_return_data['redirect_url'] = eb_account_page().'?account_details&form_fill_required';

    } else {

        $eb_return_data['status'] = 'failed';

        if (isset($user_id->errors['empty_user_login'])) {

            $eb_return_data['mssg'] = __('User Name and Email are mandatory', 'eagle-booking');

        } elseif (isset($user_id->errors['existing_user_login'])) {

            $eb_return_data['mssg'] = __('User name already exixts.', 'eagle-booking');

        } elseif (isset($user_id->errors['existing_user_email'])) {

            $eb_return_data['mssg'] = __('Sorry, that email address is already used!', 'eagle-booking');

        } else {

            $eb_return_data['mssg'] = __('Error Occured please fill up the sign up form carefully.', 'eagle-booking');

        }
    }

    wp_send_json($eb_return_data);

}


add_action('wp_ajax_eb_user_sign_up_action', 'eb_user_sing_up');
add_action('wp_ajax_nopriv_eb_user_sign_up_action', 'eb_user_sing_up');


/* --------------------------------------------------------------------------
 * @ Redirect to account page after reset password for guests role
 * @ Since  1.2.8.2
---------------------------------------------------------------------------*/
function eb_redirect_guest_after_password_reset() {

        // Check if account page has been set
        if ( eb_account_page() != '' ) {
            wp_redirect(eb_account_page());
        }
}

add_action('after_password_reset', 'eb_redirect_guest_after_password_reset');

/* --------------------------------------------------------------------------
 * @ Disable Admin Bar for hotel guests role
 * @ Since  1.2.5
---------------------------------------------------------------------------*/
function eb_remove_admin_bar_for_eb_guest() {

    if ( current_user_can('eb_guest') ) {

        show_admin_bar(false);
    }

}

add_action('after_setup_theme', 'eb_remove_admin_bar_for_eb_guest');

/* --------------------------------------------------------------------------
 * @ Get Coupon Value
 * @ Return array
 * @ Since  1.0.5
 * @ Modified 1.1.6
---------------------------------------------------------------------------*/
function eb_get_coupon_value($eb_coupon_code) {

    // Recover value form AJAX Request
    $eb_coupon_code = sanitize_text_field( $_GET['eb_coupon_code'] );

    // Verify nonce
    $eb_coupon_nonce = $_GET['eb_coupon_nonce'];

    if ( !wp_verify_nonce($eb_coupon_nonce, 'eb_nonce') ) {

        $eb_return_data['status'] = 'failed';
        $eb_return_data['message'] = 'Invalid Nonce';

    } else {

         $args = array(
            'post_type' => 'eagle_coupons',
            'meta_query' => array(
                array(
                    'key' => 'eagle_booking_mtb_coupon_code',
                    'value' => $eb_coupon_code,
                    'compare' => '=',
                ),
            ),
        );

        $the_query = new WP_Query($args);

        $eb_coupon_query = $the_query->found_posts;

        if ($eb_coupon_query == 0) {
            $eb_return_data['status'] = 'failed';
            $eb_return_data['message'] = sprintf(__('Coupon code %s does not exist', 'eagle-booking'), strtoupper($eb_coupon_code));
        } else {
            while ($the_query->have_posts()): $the_query->the_post();

            $eb_return_data['coupon_percent'] = get_post_meta(get_the_ID(), 'eagle_booking_mtb_coupon_value', true);
            $eb_return_data['coupon_code'] = get_post_meta(get_the_ID(), 'eagle_booking_mtb_coupon_code', true);

            endwhile;

            $eb_return_data['status'] = 'success';
            $eb_return_data['message'] = sprintf(__('Coupon code %s applied successfully', 'eagle-booking'), strtoupper($eb_coupon_code));
        }

     }

     wp_send_json($eb_return_data);

}


// Actions
add_action( 'wp_ajax_eb_coupon_code_action', 'eb_get_coupon_value' );
add_action( 'wp_ajax_nopriv_eb_coupon_code_action', 'eb_get_coupon_value' );


/* --------------------------------------------------------------------------
 * @ Get price before coupon
 * @ Return array
 * @ since  1.0.5
---------------------------------------------------------------------------*/
function eagle_booking_get_price_before_coupon($eagle_booking_form_coupon, $eagle_booking_form_final_price) {

    $eagle_booking_coupon_value = eagle_booking_get_coupon_value($eagle_booking_form_coupon);

    $eagle_booking_get_price_before_coupon = ($eagle_booking_form_final_price * 100) / (100 - $eagle_booking_coupon_value);

    return number_format($eagle_booking_get_price_before_coupon, 2);
}

/* --------------------------------------------------------------------------
 * Return the page permalink for the current language - Polylang
 * @since  1.1.0
---------------------------------------------------------------------------*/
function eagle_booking_get_permalink_current_language($page_id) {

    // Polylang (Get the id of the current language)
    if (function_exists('pll_get_post')) {
        $eagle_booking_page_id = pll_get_post($page_id);
    } else {
        $eagle_booking_page_id = '';
    }

    return empty($eagle_booking_page_id) ? get_permalink($page_id) : get_permalink($eagle_booking_page_id);
}

/* --------------------------------------------------------------------------
 * Return search page url
 * @since  1.0.0
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eb_search_page() {

    $eagle_booking_search_page_id = eb_get_option('eagle_booking_search_page');
    $eagle_booking_search_page_url = eagle_booking_get_permalink_current_language($eagle_booking_search_page_id);

    return $eagle_booking_search_page_url;
}

/* --------------------------------------------------------------------------
 * Return booking page url
 * @since  1.0.0
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eb_booking_page() {

    $eagle_booking_booking_page_id = eb_get_option('eagle_booking_page');
    $eagle_booking_booking_page_url = eagle_booking_get_permalink_current_language($eagle_booking_booking_page_id);

    return $eagle_booking_booking_page_url;
}

/* --------------------------------------------------------------------------
 * Return checkout page url
 * @since  1.0.0
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eb_checkout_page() {

    $eagle_booking_checkout_page_id = eb_get_option('eagle_booking_checkout_page');
    $eagle_booking_checkout_page_url = eagle_booking_get_permalink_current_language($eagle_booking_checkout_page_id);

    return $eagle_booking_checkout_page_url;

}

/* --------------------------------------------------------------------------
 * Return account page url
 * @since  1.0.0
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eb_account_page() {

    $eagle_booking_checkout_page_id = eb_get_option('account_page');
    $eagle_booking_checkout_page_url = eagle_booking_get_permalink_current_language($eagle_booking_checkout_page_id);

    return $eagle_booking_checkout_page_url;

}

/* --------------------------------------------------------------------------
 * Return terms page url
 * @since  1.0.0
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eagle_booking_terms_page() {

    $eagle_booking_terms_page_id = eb_get_option('eagle_booking_terms_page');
    $eagle_booking_terms_page_url = eagle_booking_get_permalink_current_language($eagle_booking_terms_page_id);

    return $eagle_booking_terms_page_url;

}
/* --------------------------------------------------------------------------
 * Return contact page url
 * @since  1.0.5
 * @modified 1.1.0
---------------------------------------------------------------------------*/
function eagle_booking_contact_page() {

    $eagle_booking_contact_page_id = eb_get_option('eagle_booking_contact_page');
    $eagle_booking_contact_page_url = eagle_booking_get_permalink_current_language($eagle_booking_contact_page_id);

    return $eagle_booking_contact_page_url;
}

/* --------------------------------------------------------------------------
 * Add page state to the Eagle Booking Pages (Applied only the new shortcodes)
 * @since  1.1.6
---------------------------------------------------------------------------*/
function eb_pages_state( $post_states, $post ) {

	if (has_shortcode( $post->post_content, 'eb_search') ) {

        $post_states[] = 'Eagle Booking Search Page';

    } elseif ( has_shortcode( $post->post_content, 'eb_booking') ) {

        $post_states[] = 'Eagle Booking Booking Page';

    } elseif ( has_shortcode( $post->post_content, 'eb_checkout') ) {

        $post_states[] = 'Eagle Booking Checkout Page';

    } elseif ( has_shortcode( $post->post_content, 'eb_account') ) {

        $post_states[] = 'Eagle Booking Account Page';

    }

	return $post_states;
}

add_filter( 'display_post_states', 'eb_pages_state', 10, 2 );

/* --------------------------------------------------------------------------
 * Append booking button to the main menu
 * Since  1.0.0
 * Modified 1.2.8.2
---------------------------------------------------------------------------*/
if (!function_exists('eagle_booking_append_booking_button_menu') && eb_get_option('eb_header_button')):

    add_filter('wp_nav_menu_items', 'eagle_booking_append_booking_button_menu', 12, 2);

    function eagle_booking_append_booking_button_menu($items, $args) {

    // BUTTON ACTION BASED ON BOOKING SYSTEM
    if (eb_get_option('booking_type') == 'builtin') {
        $eagle_booking_button_action = eb_search_page();

    } elseif (eb_get_option('booking_type') == 'custom') {
        $eagle_booking_button_action = eb_get_option('booking_type_custom_action');

    } elseif (eb_get_option('booking_type') == 'booking') {
        $eagle_booking_button_action = eb_get_option('booking_type_booking_action');

    } elseif (eb_get_option('booking_type') == 'airbnb') {
        $eagle_booking_button_action = eb_get_option('booking_type_airbnb_action');

    } elseif (eb_get_option('booking_type') == 'tripadvisor') {
        $eagle_booking_button_action = eb_get_option('booking_type_tripadvisor_action');
    }

    // BUTTON TARGET
    if (eb_get_option('eagle_booking_external_target') == true && eb_get_option('booking_type') !== 'builtin') {
        $eagle_booking_button_target = '_blank';
    } else {
        $eagle_booking_button_target = '_self';
    }

    if ( isset($args->menu->term_id) ) {
        $eb_menu_id = $args->menu->term_id;
    } else {
        $eb_menu_id = '';
    }

    $eb_menu_tr_id = 0;
    $eb_menu_tr_button = 1;

    // Check if Polylang has benn isntalled & activated
    if ( function_exists('pll_get_post') ) {
        $eb_menu_tr_id = pll_get_post($eb_menu_id);
        $eb_menu_tr_button = pll_get_post(eb_get_option('button_menu'));
    }

    // Check if WPML has been installed & activated
    if ( function_exists('icl_object_id') ) {
        $eb_menu_tr_id  = icl_object_id( $eb_menu_id, 'nav_menu', false, ICL_LANGUAGE_CODE );
        $eb_menu_tr_button  = icl_object_id( eb_get_option('button_menu'), 'nav_menu', false, ICL_LANGUAGE_CODE );
    }

    if ( $eb_menu_id != '') {

        if ( $eb_menu_id == eb_get_option('button_menu') || $eb_menu_tr_id == $eb_menu_tr_button ) {
            $items .= '<li class="menu_button"><a href="' . $eagle_booking_button_action . '" class="btn eb-btn" target="' . $eagle_booking_button_target . '"><i class="fa fa-calendar"></i>' . esc_html__('BOOK ONLINE', 'eagle-booking') . '</a></li>';
        }
    }

    return $items;

}

endif;


/* --------------------------------------------------------------------------
 * CPT Pagination WordPress Bug Fix
 * @since  1.0.9
---------------------------------------------------------------------------*/
function eagle_booking_fix_custom_posts_per_page($query_string) {
    if (is_admin() || !is_array($query_string)) {
        return $query_string;
    }

    $post_types_to_fix = array(
        array(
            'post_type' => 'eagle_rooms',
            'posts_per_page' => eb_get_option('eagle_booking_rooms_per_page'),
        ),
    );

    foreach ($post_types_to_fix as $fix) {
        if (array_key_exists('post_type', $query_string)
            && $query_string['post_type'] == $fix['post_type']
        ) {
            $query_string['posts_per_page'] = $fix['posts_per_page'];
            return $query_string;
        }
    }

    return $query_string;
}

add_filter('request', 'eagle_booking_fix_custom_posts_per_page');

/* --------------------------------------------------------------------------
 * Default Screen Options
 * @since  1.0.9
---------------------------------------------------------------------------*/
add_action('admin_init', 'eagle_booking_screen_options');
function eagle_booking_screen_options($user_id = NULL) {

    $meta_key['hidden'] = 'metaboxhidden_nav-menus';

    if ($user_id) {
        $user_id = get_current_user_id();
    }

    if (get_user_meta($user_id, $meta_key['hidden'], true)) {
        $meta_value = array('');
        update_user_meta($user_id, $meta_key['hidden'], $meta_value);
    }

}

/* --------------------------------------------------------------------------
 * Get JS options
 * @since  1.1.6
---------------------------------------------------------------------------*/
if (!function_exists('eb_get_js_settings')):
    function eb_get_js_settings() {

        $js_settings = array();

        $js_settings['eb_booking_type'] = eb_get_option('booking_type');
        $js_settings['eagle_booking_date_format'] = eb_get_option('eagle_booking_date_format');
        $js_settings['eb_custom_date_format'] = eb_get_option('booking_type_custom_date_format');
        $js_settings['eb_terms_conditions'] = eb_get_option('eb_booking_form_fields')['terms_conditions'];
        $js_settings['eb_calendar_availability_period'] = eb_get_option('eb_calendar_availability_period');
        $js_settings['eb_room_slider_autoplay'] = eb_get_option('room_slider_autoplay');
        $js_settings['eagle_booking_price_range_min'] = eb_rooms_min_max_price('min');
        $js_settings['eagle_booking_price_range_max'] = eb_rooms_min_max_price('max');
        $eagle_booking_price_range_min = eb_get_option('eb_price_range_min');
        $eagle_booking_price_range_max = eb_get_option('eb_price_range_max');
        $js_settings['eb_decimal_numbers'] = eb_get_option('eagle_booking_decimal_number');
        $js_settings['eb_decimal_seperator'] = eb_get_option('eagle_booking_decimal_separator');
        $js_settings['eb_thousands_seperator'] = eb_get_option('eagle_booking_thousands_separator');

        if (empty($eagle_booking_price_range_min)) {
            $eagle_booking_price_range_min = eb_rooms_min_max_price('min');
        }

        if (empty($eagle_booking_price_range_max)) {
            $eagle_booking_price_range_max = eb_rooms_min_max_price('max');
        }

        $js_settings['eagle_booking_price_range_default_min'] = $eagle_booking_price_range_min;
        $js_settings['eagle_booking_price_range_default_max'] = $eagle_booking_price_range_max;
        $js_settings['eb_discount_text'] = __('Discount', 'eagle-booking');
        $js_settings['eb_currency'] = eb_currency();
        $js_settings['eb_currency_position'] = eb_currency_position();
        $js_settings['eb_booking_nights'] = __('Booking Nights', 'eagle-booking');
        $js_settings['eb_calendar_sunday'] = __('Su', 'eagle-booking');
        $js_settings['eb_calendar_monday'] = __('Mo', 'eagle-booking');
        $js_settings['eb_calendar_tuesday'] = __('Tu', 'eagle-booking');
        $js_settings['eb_calendar_wednesday'] = __('We', 'eagle-booking');
        $js_settings['eb_calendar_thursday'] = __('Th', 'eagle-booking');
        $js_settings['eb_calendar_friday'] = __('Fr', 'eagle-booking');
        $js_settings['eb_calendar_saturday'] = __('Sa', 'eagle-booking');
        $js_settings['eb_calendar_january'] = __('January', 'eagle-booking');
        $js_settings['eb_calendar_february'] = __('February', 'eagle-booking');
        $js_settings['eb_calendar_march'] = __('March', 'eagle-booking');
        $js_settings['eb_calendar_april'] = __('April', 'eagle-booking');
        $js_settings['eb_calendar_may'] = __('May', 'eagle-booking');
        $js_settings['eb_calendar_june'] = __('June', 'eagle-booking');
        $js_settings['eb_calendar_july'] = __('July', 'eagle-booking');
        $js_settings['eb_calendar_august'] = __('August', 'eagle-booking');
        $js_settings['eb_calendar_september'] = __('September', 'eagle-booking');
        $js_settings['eb_calendar_october'] = __('October', 'eagle-booking');
        $js_settings['eb_calendar_november'] = __('November', 'eagle-booking');
        $js_settings['eb_calendar_december'] = __('December', 'eagle-booking');
        $js_settings['eb_magnific_close'] = __('Close (Esc)', 'eagle-booking');
        $js_settings['eb_magnific_loading'] = __('Loading...', 'eagle-booking');
        $js_settings['eb_magnific_previous'] = __('Previous (Left arrow key)', 'eagle-booking');
        $js_settings['eb_magnific_next'] = __('Next (Right arrow key)', 'eagle-booking');
        $js_settings['eb_magnific_counter'] = __('of', 'eagle-booking');

        return $js_settings;
    }
endif;

/* --------------------------------------------------------------------------s
 * Get the highest or lowest price of the rooms
 * since  1.1.6
 * modified 1.3.3.3.1
 * TD: Return only rooms of the current Language
---------------------------------------------------------------------------*/
function eb_rooms_min_max_price( $type = 'max' ){

    global $wpdb;

    $key = "eagle_booking_mtb_room_price";
    $results = wp_cache_get($key);

    $eb_meta_table = $wpdb->prefix . 'postmeta';
    $eb_posts_table = $wpdb->prefix . 'posts';

    if( $results === false ) {

        $sql = "SELECT " . $type .

        "( cast( meta_value as UNSIGNED ) )

            FROM $eb_meta_table
            LEFT JOIN $eb_posts_table
            ON $eb_posts_table.ID = $eb_meta_table.post_id
            WHERE $eb_posts_table.post_type = 'eagle_rooms'
            AND $eb_posts_table.post_status = 'publish'
            AND meta_key='%s'
        ";

        $query = $wpdb->prepare( $sql, $key);

        return $wpdb->get_var( $query );

    }

    return $results;
}

/* --------------------------------------------------------------------------s
 * Get the total earnings
 * @since  1.1.6
---------------------------------------------------------------------------*/
function eagle_booking_total_earnings() {

    global $wpdb;

    $eagle_booking_table_name = $wpdb->prefix . 'eagle_booking';

    $eagle_booking_total_earnings = $wpdb->get_results("SELECT sum(final_trip_price) as result_value FROM $eagle_booking_table_name WHERE paypal_payment_status = 'Completed'");

    return $eagle_booking_total_earnings[0]->result_value;

}

/* --------------------------------------------------------------------------s
 * Add custom class to body tag for all EB pages
 * Since  1.1.6
 * Modified: 1.2.5.2
---------------------------------------------------------------------------*/
function eb_body_class( $class ) {

    // Get EB pages
    $eb_search_page_id = eb_get_option('eagle_booking_search_page');
    $eb_booking_page_id = eb_get_option('eagle_booking_page');
    $eb_checkout_page_id = eb_get_option('eagle_booking_checkout_page');
    $eb_account_page_id = eb_get_option('account_page');

    // Defaults if Polylang and WPML are not installed & activated
    $eb_search_tr_page_id = '';
    $eb_booking_tr_page_id = '';
    $eb_checkout_tr_page_id = '';
    $eb_account_tr_page_id = '';

    // Check if Polylang has benn isntalled & activated
    if ( function_exists('pll_get_post') ) {
        $eb_search_tr_page_id = pll_get_post($eb_search_page_id);
        $eb_booking_tr_page_id = pll_get_post($eb_booking_page_id);
        $eb_checkout_tr_page_id = pll_get_post($eb_checkout_page_id);
        $eb_account_tr_page_id = pll_get_post($eb_account_page_id);
    }

    // Check if WPML has been installed & activated
    if ( function_exists('icl_object_id') ) {
        $eb_search_tr_page_id = icl_object_id($eb_search_page_id, 'page', false, ICL_LANGUAGE_CODE);
        $eb_booking_tr_page_id = icl_object_id($eb_booking_page_id, 'page', false, ICL_LANGUAGE_CODE);
        $eb_checkout_tr_page_id = icl_object_id($eb_checkout_page_id, 'page', false, ICL_LANGUAGE_CODE);
        $eb_account_tr_page_id = icl_object_id($eb_account_page_id, 'page', false, ICL_LANGUAGE_CODE);
    }

    // Current page ID
    $eb_current_page_id = get_the_ID();

    // EB pages and their translations in array
    $eb_pages = array(
        $eb_search_page_id,
        $eb_booking_page_id,
        $eb_checkout_page_id,
        $eb_account_page_id,
        $eb_search_tr_page_id,
        $eb_booking_tr_page_id,
        $eb_checkout_tr_page_id,
        $eb_account_tr_page_id

    );


    if ( in_array( $eb_current_page_id, $eb_pages ) || is_singular( 'eagle_rooms' ) || is_post_type_archive('eagle_rooms') ) {

        $class[] = 'eb-page';
    }

    return $class;
}

add_filter('body_class', 'eb_body_class');

/* --------------------------------------------------------------------------
 * Image Sizes
 * @since  1.2
 ---------------------------------------------------------------------------*/
 if ( !function_exists( 'eb_image_sizes' ) ):
	function eb_image_sizes() {

		$sizes = array(
            'eagle_booking_image_size_720_470' => array( 'title' => esc_html__('720 x 470', 'eagle-booking'), 'w' => 720, 'h' => 470, 'crop' => true),
            'eagle_booking_image_size_1170_680' => array( 'title' => esc_html__('1170 x 680', 'eagle-booking'), 'w' => 1170, 'h' => 680, 'crop' => true),
            'eagle_booking_image_size_1920_800' => array( 'title' => esc_html__('1920 x 800', 'eagle-booking'), 'w' => 1920, 'h' => 800, 'crop' => true),
		);

		$disable_img_sizes = eb_get_option('eb_image_sizes');
		if(!empty( $disable_img_sizes )){
			$disable_img_sizes = array_keys( array_filter( $disable_img_sizes ) );
		}
		if(!empty($disable_img_sizes) ){
			foreach($disable_img_sizes as $size_id ){
				unset( $sizes[$size_id]);
			}
		}
		$sizes = apply_filters( 'eb_modify_image_sizes', $sizes );
		return $sizes;
    }

    /* Add image sizes */
    $image_sizes = eb_image_sizes();
    if ( !empty( $image_sizes ) ) {
        foreach ( $image_sizes as $id => $size ) {
            add_image_size( $id, $size['w'], $size['h'], $size['crop'] );
        }
    }


endif;


/* --------------------------------------------------------------------------
* Share social media
* @since  1.2
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_social_share' ) ) {
    function eb_social_share() {
        global $post;
        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
        ?>
            <div class="social_media">
                <span><i class="fa fa-share-alt"></i><?php echo __('Share', 'eagle-booking') ?></span>
                <a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo esc_html__('Share this post on Facebook', 'eagle-booking') ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo esc_html__('Share this post on Facebook', 'eagle-booking') ?>"><i class="fa fa-facebook"></i></a>
                <a class="twitter" href="https://twitter.com/share?url=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo esc_html__('Share this post on Twitter', 'eagle-booking') ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo esc_html__('Share this post on Twitter', 'eagle-booking') ?>"><i class="fa fa-twitter"></i></a>
                <a class="pinterest" href="https://pinterest.com/pin/create/button/?url=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo esc_html__('Share this post on Pinterest', 'eagle-booking') ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo esc_html__('Share this post on Pinterest', 'eagle-booking') ?>"><i class="fa fa-pinterest"></i></a>
            </div>

        <?php
    }
   }



/* --------------------------------------------------------------------------
* Show room mtb on Adults & Children
* @since  1.2.3
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_show_adults_children_room_mtb' ) ) {

    function eb_show_adults_children_room_mtb() {

        if ( eb_get_option('eb_adults_children') == true) {

            return true;

        } else {

            return false;
        }

    }

}

/* --------------------------------------------------------------------------
* Show room mtb on Guests
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_show_guests_room_mtb' ) ) {

    function eb_show_guests_room_mtb() {

        if ( eb_get_option('eb_adults_children') == false) {

            return true;

        } else {

            return false;
        }

    }

}

/* --------------------------------------------------------------------------
* Show/Hide room header image mtb based on plugin option
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_show_header_image_mtb' ) ) {

    function eb_show_header_image_mtb() {

        if ( eb_get_option('room_header_type') == 'image') {

            return true;

        } else {

            return false;
        }

    }

}


/* --------------------------------------------------------------------------
* Check In/Out time
---------------------------------------------------------------------------*/

if ( ! function_exists( 'eb_checkin_checkout_time' ) ) {

    function eb_checkin_checkout_time($eb_required_time = NULL) {

        $eb_checkin_out_time_format = eb_get_option('time_format');
        $eb_checkin_time_12hour = eb_get_option('checkin_time_12hour');
        $eb_checkout_time_12hour = eb_get_option('checkout_time_12hour');
        $eb_checkin_time_24hour = eb_get_option('checkin_time_24hour');
        $eb_checkout_time_24hour = eb_get_option('checkout_time_24hour');

        if( $eb_required_time == 'checkin') {

            // Check the time format
            if ( $eb_checkin_out_time_format === '24hour' && $eb_checkin_time_24hour) {

                $eb_checkin_time_string = $eb_checkin_time_24hour;

            } elseif ($eb_checkin_out_time_format === '12hour' && $eb_checkin_time_12hour) {

                // 12hour formatS (Get 24hour format and convert it to 12hour)
                $eb_checkin_time_string = (new DateTime($eb_checkin_time_12hour))->format('h:i a');

                // Make the "am" & "pm" translatable
                $eb_checkin_time_string = str_replace(array('am', 'pm'), array( __('am', 'eagle-booking'), __('pm', 'eagle-booking') ), $eb_checkin_time_string);

            }

            if( isset($eb_checkin_time_string )) echo ', '.__('from', 'eagle-booking').' '.$eb_checkin_time_string;


        } else {

            // Check the time format
            if ( $eb_checkin_out_time_format === '24hour' && $eb_checkin_time_24hour) {

                $eb_checkout_time_string = $eb_checkout_time_24hour;

            } elseif ($eb_checkin_out_time_format === '12hour' && $eb_checkin_time_12hour) {

                // 12hour formatS (Get 24hour format and convert it to 12hour)
                $eb_checkout_time_string = (new DateTime($eb_checkout_time_12hour))->format('h:i a');

                // Make the "am" & "pm" translatable
                $eb_checkout_time_string = str_replace(array('am', 'pm'), array( __('am', 'eagle-booking'), __('pm', 'eagle-booking') ), $eb_checkout_time_string);

            }

            if( isset($eb_checkout_time_string) ) echo ', '.__('until', 'eagle-booking').' '.$eb_checkout_time_string;

        }

    }

}


/* --------------------------------------------------------------------------
* Services Price Type
* @since  1.2.3
---------------------------------------------------------------------------*/
if ( ! function_exists( 'eb_service_price_type' ) ) {

    function eb_service_price_type() {

        if (eb_get_option('eb_adults_children') == true ) {

            $eb_price_type = array(
                'room' => __('Room', 'eagle-booking'),
                'adult' => __('Adult', 'eagle-booking'),
                'children' => __('Children', 'eagle-booking'),
                'adult_children' => __('Adult + Children', 'eagle-booking')
            );

        } else {

            $eb_price_type = array(
                'room' => __('Room', 'eagle-booking'),
                'guest' => __('Guest', 'eagle-booking'),
            );
        }

        return $eb_price_type;
    }

}

/* --------------------------------------------------------------------------
* Breadcrumb
* @since  1.2.3
---------------------------------------------------------------------------*/
if ( !function_exists('eb_breadcrumb') ) {

    function eb_breadcrumb() {

        echo '<ul class="eb-breadcrumbs">';

        echo '<li><a href="'.get_home_url().'">'.__('Home', 'eagle-booking').'</a></li>';

        if ( is_post_type_archive('eagle_rooms') ) {

            echo '<li class="item item-current">'. post_type_archive_title() .'</li>';

        } elseif ( is_singular('eagle_rooms') ) {

            echo '<li class="item"><a href="'.get_post_type_archive_link('eagle_rooms').'">'.__('Rooms', 'eagle-booking').'</a></li>';

            echo '<li class="item item-current">'.get_the_title().'</li>';
        }

        echo "</ul>";
    }

}

/* --------------------------------------------------------------------------
* Notice
* $type [info, success, error]
* @since  1.2.6
---------------------------------------------------------------------------*/
if (! function_exists('eb_notice')) {

    function eb_notice($type, $message) {

        if ($type == '') {

            $eb_notice_class = 'eb-alert';

        } else {

            $eb_notice_class = 'eb-alert'.' '.'eb-alert-'.$type;

        }

        $eb_notice = '<div class="'.$eb_notice_class.' eb-alert-icon" role="alert">';
        $eb_notice .= $message;
        $eb_notice .= '</div>';

        echo $eb_notice;

    }

}

/* --------------------------------------------------------------------------
* Get user IP
* @since  1.2.9.2
---------------------------------------------------------------------------*/
if (! function_exists('eb_user_ip')) {

    function eb_user_ip() {

        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

            $ip = $_SERVER['HTTP_CLIENT_IP'];

        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } else {

            $ip = $_SERVER['REMOTE_ADDR'];

        }

        return $ip;

    }

}

/* --------------------------------------------------------------------------
* Check if room has branch
* Since  1.2.9.6
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_has_branch') ) {

    function eb_room_has_branch( $room_id ) {

        $branches = get_the_terms( $room_id, 'eagle_branch' );

        if ( $branches ) {

            return true;

        } else {

            return false;
        }

    }

}

/* --------------------------------------------------------------------------
* Get Room Branch
* Since  1.2.9.6
* Modified 1.3.3
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_branch') ) {

    function eb_room_branch( $room_id, $branch_url = '', $target = '' ) {

        $branches = get_the_terms( $room_id, 'eagle_branch' );

        if ( $target == true ) $target = "_blank";

        if ( $branches ) {

            $html = '';

            foreach ( $branches as $branch ) {

                $eb_branch_id = $branch->term_id;
                $eb_branch_name = get_term_field( 'name', $branch );
                $eb_branch_url = get_term_link($eb_branch_id);

                if ( $branch_url == true ) {

                    $html .= '<a href="'.esc_html( $eb_branch_url ).'" target="'.$target.'">';
                    $html .= esc_html( $eb_branch_name );
                    $html .= '</a>';

                } else {

                    $html .= esc_html( $eb_branch_name );

                }

            }

            return $html;

        } else {

            return false;
        }

    }

}

/* --------------------------------------------------------------------------
* Get Branches to sort rooms by branch
* Since  1.2.9.6
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_sort_by_branch') ) {

    function eb_sort_by_branch() {

        $args = array(
            'taxonomy'               => 'eagle_branch',
            'hide_empty'             => false,
        );

        $branch_query = new WP_Term_Query($args);

        if ( !empty( $branch_query->terms ) ) {

           // Add an extra option to the array
           $new_array[] = array('0', 'All');

            foreach ( $branch_query->terms as $eb_branch ) {

                $eb_branch_id = $eb_branch->term_id;
                $eb_branch_name = get_term_field( 'name', $eb_branch );

                $new_array[] = array( $eb_branch_id, $eb_branch_name );

            }

        } else {

            $new_array[] = array( '0', 'No Branch' );

        }

        return $new_array;

    }

}

/* --------------------------------------------------------------------------
* Return the total booking price (including taxes & fees)
* Since  1.3.3
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_total_price') ) {

    function eb_total_price($room_id, $trip_price, $booking_nights, $guests, $include_taxes_fees = false) {

        if ( eb_get_option('price_taxes') === 'including' || $include_taxes_fees == true ) {

            $eb_taxes = get_option('eb_taxes');
            $eb_fees = get_option('eb_fees');
            $eb_room_taxes = get_post_meta( $room_id, 'eagle_booking_mtb_room_taxes', true );
            $eb_room_fees = get_post_meta( $room_id, 'eagle_booking_mtb_room_fees', true );

            if ( empty( $eb_taxes ) ) $eb_taxes = array();
            if ( empty( $eb_fees ) ) $eb_fees = array();
            if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();
            if ( empty( $eb_room_fees ) ) $eb_room_fees = array();

            // Merge Taxes & Fees
            $eb_entries = array_merge( $eb_taxes, $eb_fees );
            $eb_room_entries = array_merge( $eb_room_taxes, $eb_room_fees );

            if ( empty( $eb_room_entries ) ) $eb_room_entries = array();

            $taxes_fees_total = 0;
            $taxes_fees_amount = 0;
            $fees_taxes = 0;

            if ( $eb_entries ) {

                foreach( $eb_entries as $key => $item ) {

                    $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
                    $type = !empty( $item["type"] ) ? $item["type"] : '';
                    $amount = !empty( $item["amount"] ) ? $item["amount"] : '';
                    $global = !empty( $item["global"] ) ? $item["global"] : '';
                    $include_fee = !empty( $item["fees"] ) ? $item["fees"] : '';

                    // lets check if the tax is global or if is asigned to the room
                    if ( $global == true || in_array( $entry_id, $eb_room_entries)  ) {

                        // Calculate the tax & fees total based on the type
                        if ( $type === 'per_booking' ) {

                            $taxes_fees_amount = $amount;

                        } elseif ( $type === 'per_booking_nights' ) {

                            $taxes_fees_amount = $amount * $booking_nights;

                        } elseif ( $type === 'per_booking_nights_guests' ) {

                            $taxes_fees_amount = $amount * $guests * $booking_nights;

                        } elseif ( $type === 'per_guests' ) {

                            $taxes_fees_amount = $amount * $guests;

                        // is tax
                        } else {

                            $taxes_fees_amount = $amount * $trip_price / 100;

                        }

                        // TO DO: Check if the tax is applied on the fee and add the tax fee amount to the total price (to be added)
                        // if ( $include_fee == true ) {

                        //     $total_price = $taxes_fees_amount + $fees_taxes;

                        // } else {

                        //     $total_price = $taxes_fees_amount;

                        // }

                        // Round each tax & fee amount separately
                        $taxes_fees_total += round( $taxes_fees_amount );

                    }

                }

            }

            // Price including taxes & fees
            $price = $trip_price + $taxes_fees_total;

        } else {

            // Price excluding taxes & fees
            $price = $trip_price;

        }


        return $price;

    }

}

/* --------------------------------------------------------------------------
* Check if room has taxes (global or asigned)
* Return: Boolean
* Since  1.3.2
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_has_taxes_fees') ) {

    function eb_room_has_taxes_fees( $room_id ) {

        $eb_taxes = get_option('eb_taxes');
        $eb_fees = get_option('eb_fees');

        $eb_room_taxes = get_post_meta( $room_id, 'eagle_booking_mtb_room_taxes', true );
        $eb_room_fees = get_post_meta( $room_id, 'eagle_booking_mtb_room_fees', true );

        if ( empty( $eb_taxes ) ) $eb_taxes = array();
        if ( empty( $eb_fees ) ) $eb_fees = array();
        if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();
        if ( empty( $eb_room_fees ) ) $eb_room_fees = array();

        // Merge taxees & fees
        $eb_entries = array_merge( $eb_taxes, $eb_fees );
        $eb_room_entries = array_merge( $eb_room_taxes, $eb_room_fees );

        if ( empty( $eb_room_entries ) ) $eb_room_entries = array();

        // if ( eb_get_option('total_price_taxes_fees') === 'excluding' && $eb_entries ) {
        if ( eb_get_option('price_taxes') === 'excluding' && $eb_entries ) {

            foreach( $eb_entries as $key => $item ) {

                $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
                $global = !empty( $item["global"] ) ? $item["global"] : '';

                // lets check if the tax is global or if is asigned to the room
                if ( $global == true || in_array( $entry_id, $eb_room_entries)  ) {

                    return true;

                    break;

                }

            }

        }

    }

}

/* --------------------------------------------------------------------------
* Get Room Taxes (Global & Assigned)
* Return: Array
* Since  1.3.2
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_taxes') ) {

    function eb_room_taxes( $room_id ) {

        $eb_taxes = get_option('eb_taxes');
        $eb_room_taxes = get_post_meta( $room_id, 'eagle_booking_mtb_room_taxes', true );

        if ( empty( $eb_taxes ) ) $eb_taxes = array();
        if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();

        $taxes = array();

        if ( $eb_taxes ) {

            foreach( $eb_taxes as $key => $item ) {

                $entry_id = isset( $item["id"] ) ? $item["id"] : 0;
                $global = isset( $item["global"] ) ? $item["global"] : 0;

                // lets check if the tax is global or if is asigned to the room
                if ( $global == true || in_array( $entry_id, $eb_room_taxes)  ) {

                    $taxes[$key] = $entry_id;

                }

            }

             return $taxes;

        } else {

            return;

        }

    }

}

/* --------------------------------------------------------------------------
* Get Room Fees (Global or Assigned)
* Return: Array
* Since  1.3.2
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_fees') ) {

    function eb_room_fees( $room_id ) {

        $eb_fees = get_option('eb_fees');
        $eb_room_fees = get_post_meta( $room_id, 'eagle_booking_mtb_room_fees', true );

        if ( empty( $eb_fees ) ) $eb_fees = array();
        if ( empty( $eb_room_fees ) ) $eb_room_fees = array();

        if ( $eb_fees ) {

            foreach( $eb_fees as $key => $item ) {

                $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
                $global = !empty( $item["global"] ) ? $item["global"] : '';

                // lets check if the fee is global or if is asigned to the room
                if ( $global == true || in_array( $entry_id, $eb_room_fees)  ) {

                    $fees[$key] = $entry_id;

                }

            }

            return $fees;

        } else {

            return;

        }

    }

}

/* --------------------------------------------------------------------------
* Get Room Fees Amount (Global or Assigned)
* Return: Array
* Since  1.3.2
---------------------------------------------------------------------------*/
if ( ! function_exists('eb_room_fees_amount') ) {

    function eb_room_fees_amount( $room_id, $booking_nights, $guests ) {

        $eb_fees = get_option('eb_fees');
        $eb_room_fees = get_post_meta( $room_id, 'eagle_booking_mtb_room_fees', true );

        if ( empty( $eb_fees ) ) $eb_fees = array();
        if ( empty( $eb_room_fees ) ) $eb_room_fees = array();

        $total_amount = 0;
        $fees_amount = 0;

        if ( $eb_fees ) {

            foreach( $eb_fees as $key => $item ) {

                $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
                $type = !empty( $item["type"] ) ? $item["type"] :  '';
                $global = !empty( $item["global"] ) ? $item["global"] : '';
                $amount = !empty( $item["amount"] ) ? $item["amount"] : '';

                // lets check if the fee is global or if is asigned to the room
                if ( $global == true || in_array( $entry_id, $eb_room_fees)  ) {

                    // Calculate the tax & fees total based on the type
                    if ( $type === 'per_booking' ) {

                        $fees_amount = $amount;

                    } elseif ( $type === 'per_booking_nights' ) {

                        $fees_amount = $amount * $booking_nights;

                    } elseif ( $type === 'per_booking_nights_guests' ) {

                        $fees_amount = $amount * $guests * $booking_nights;

                    } elseif ( $type === 'per_guests' ) {

                        $fees_amount = $amount * $guests;

                    }

                }

                $total_amount += $fees_amount;

            }

            return $total_amount;

        } else {

            return;

        }

    }

}
