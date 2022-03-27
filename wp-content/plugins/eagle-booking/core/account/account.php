<?php
/* --------------------------------------------------------------------------
 * Account Page Shortcode
 * Author: Eagle Themes
 * Package: Eagle-Booking/Core
 * Since:  1.0.0
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_account_shortcode() {

    ob_start();

    echo '<div class="eb-user-dashboard">';

    if ( is_user_logged_in() ) {

        if (isset($_GET["view_booking"])) {

            // View Booking Details
            require_once EB_PATH . '/core/account/view.php';

        } elseif (isset($_GET["bookings"])) {

            // Bookings
            require_once EB_PATH . '/core/account/bookings.php';

        } elseif (isset($_GET["account_details"])) {

            // Bookings
            require_once EB_PATH . '/core/account/account-details.php';

        } else {

            // Dashboard
            require_once EB_PATH . '/core/account/dashboard.php';

        }

    } elseif ( isset( $_GET['sign_up'] ) ) {

        // Signup
        require_once EB_PATH . '/core/account/signup.php';


    // Redirect to login Page
    } else {

        // Login
        require_once EB_PATH . '/core/account/signin.php';

    }

    echo '</div>';

    /**
     * Enqueue Booking Page JS & AJAX (to be remove and create a account.js file to use only the user js)
    */
    wp_enqueue_script( 'eb-checkout', EB_URL .'assets/js/checkout.js', array( 'jquery' ), EB_VERSION, true );
    wp_localize_script(

    'eb-checkout', 'eb_checkout',

    array(
        'eb_user_sign_in_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_user_sign_up_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_user_sign_out_ajax' => admin_url( 'admin-ajax.php' ),
        'eb_coupon_code_ajax' => admin_url( 'admin-ajax.php' ),

        // Used for static Ajax requests
        'eb_ajax_nonce' => wp_create_nonce( 'eb_nonce' ),
    )

  );

    return ob_get_clean();

}


// Account Page Shortcode
add_shortcode('eb_account', 'eb_account_shortcode');
