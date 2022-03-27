<?php
/* --------------------------------------------------------------------------
 * Email Admin & Customer
 * @since  1.0.0
 * @modified 1.3.3
---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

function eb_send_message(
	$eagle_booking_room_id,
	$eagle_booking_title_post,
	$eagle_booking_date,
	$eagle_booking_checkin,
	$eagle_booking_checkout,
	$eagle_booking_guests,
	$eagle_booking_adults,
	$eagle_booking_children,
	$eagle_booking_final_trip_price,
	$eagle_booking_deposit_amount,
	$eagle_booking_extra_services,
	$eagle_booking_id_user,
	$eagle_booking_user_first_name,
	$eagle_booking_user_last_name,
	$eagle_booking_user_email,
	$eb_user_ip,
	$eagle_booking_user_phone,
	$eagle_booking_user_address,
	$eagle_booking_user_city,
	$eagle_booking_user_country,
	$eagle_booking_user_message,
	$eb_customer_arrival,
	$eagle_booking_user_coupon,
	$eagle_booking_paypal_payment_status,
	$eagle_booking_paypal_currency,
	$eagle_booking_transaction_id,
	$eagle_booking_checkout_payment_type
) {

	// Email Settings
	$eagle_booking_message_admin = eb_get_option('eagle_booking_message')['email_admin'];
	$eagle_booking_message_guest = eb_get_option('eagle_booking_message')['email_guest'];

	// Email Logo
	$eb_hotel_logo = eb_get_option('hotel_logo');

	// Email Details
	$eb_email_customer_text = eb_get_option('email_customer_text');

	// Footer Links
	$eagle_booking_message_facebook_url = eb_get_option( 'eagle_booking_message_template_facebook_url' );
	$eagle_booking_message_twitter_url = eb_get_option( 'eagle_booking_message_template_twitter_url' );
	$eagle_booking_message_instagram_url = eb_get_option( 'eagle_booking_message_template_instagram_url' );

	// Eamil template design
	$eagle_booking_message_template_bg = eb_get_option( 'eagle_booking_message_template_bg' );
	$eagle_booking_message_template_border = eb_get_option( 'eagle_booking_message_template_border' );
	$eagle_booking_message_template_color = eb_get_option( 'eagle_booking_message_template_color' );
	$eagle_booking_message_template_link_color = eb_get_option( 'eagle_booking_message_template_link_color' );
	$eagle_booking_message_template_header_bg = eb_get_option( 'eagle_booking_message_template_header_bg' );
	$eagle_booking_message_template_header_color = eb_get_option( 'eagle_booking_message_template_header_color' );
	$eagle_booking_message_template_footer_bg = eb_get_option( 'eagle_booking_message_template_footer_bg' );
	$eagle_booking_message_template_footer_color = eb_get_option( 'eagle_booking_message_template_footer_color' );
	$eagle_booking_message_template_footer_border = eb_get_option( 'eagle_booking_message_template_footer_border' );

	// Total & Deposit Amount
	$eb_email_total_amount = eb_price( $eagle_booking_final_trip_price, false );
	$eb_email_deposit_amount = eb_price( $eagle_booking_deposit_amount, false );

	/* --------------------------------------------------------------------------
	 * GET HOTEL INFO
	 ---------------------------------------------------------------------------*/
	 $eagle_booking_hotel_name = eb_get_option('eagle_booking_message_sender_name');
	 $eagle_booking_hotel_url = get_site_url();

	if ( eb_get_option('email_hotel_logo') == true && !empty( $eb_hotel_logo )) {
		$eagle_booking_hotel_logo = '<img src="'.esc_url($eb_hotel_logo).'">';
	} else {
		$eagle_booking_hotel_logo = get_bloginfo( 'name' );
	}

	// Sender email
	$eagle_booking_sender_email = eb_get_option('eagle_booking_message_sender_email');

	// Get the booking status text
	if ( $eagle_booking_paypal_payment_status == 'Pending Payment' ) {
		$eb_booking_status = __('Pending Payment', 'eagle-booking');

	} elseif ( $eagle_booking_paypal_payment_status == 'Pending' ){
		$eb_booking_status = __('Pending', 'eagle-booking');

	} elseif ( $eagle_booking_paypal_payment_status == 'Canceled' ){
		$eb_booking_status = __('Canceled', 'eagle-booking');

	} else {
		$eb_booking_status = __('Completed', 'eagle-booking');
	}

	// Get the payment method text
	if( $eagle_booking_checkout_payment_type === 'payment_on_arrive' ) {

		$eagle_booking_checkout_payment_type_text = __('Payment on Arrival', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === '2checkout') {

		$eagle_booking_checkout_payment_type_text = __('2Checkout', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'bank_transfer') {

		$eagle_booking_checkout_payment_type_text = __('Bank Transfer', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'PayU') {

		$eagle_booking_checkout_payment_type_text = __('PayU', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'paystack') {

		$eagle_booking_checkout_payment_type_text = __('Paystack', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'flutterwave') {

		$eagle_booking_checkout_payment_type_text = __('Flutterave', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'razorpay') {

		$eagle_booking_checkout_payment_type_text = __('Razorpay', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'booking_request') {

		$eagle_booking_checkout_payment_type_text = __('Booking Request', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'stripe') {

		$eagle_booking_checkout_payment_type_text = __('Stripe', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'paypal') {

		$eagle_booking_checkout_payment_type_text = __('PayPal', 'eagle-booking');

	} elseif ($eagle_booking_checkout_payment_type === 'vivawallet') {

		$eagle_booking_checkout_payment_type_text = __('Viva Wallet', 'eagle-booking');

	}

	/* --------------------------------------------------------------------------
	 * Additional Services
	 ---------------------------------------------------------------------------*/
	$eb_email_additional_services = '';

	if ( empty($eagle_booking_extra_services) ) {

		$eb_email_additional_services = '';

	} else {

		$eagle_booking_services_array = explode(',', $eagle_booking_extra_services );

        for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array)-1; $eagle_booking_services_array_i++) {

		    $eagle_booking_service_array = explode('[', $eagle_booking_services_array[$eagle_booking_services_array_i] );
			$eagle_booking_service_id  = $eagle_booking_service_array[0];
			$eagle_booking_service_title  = get_the_title($eagle_booking_service_id);
			$eagle_booking_service_price = str_replace(']','', $eagle_booking_service_array[1]);

			$eb_email_additional_services .= '<p>'.$eagle_booking_service_title.'</p>';
		}

	}

	/* --------------------------------------------------------------------------
	 * Admin Email
	 ---------------------------------------------------------------------------*/
	$eagle_booking_admin_email = eb_get_option('eagle_booking_message_admin_email');
	$eagle_booking_admin_subject = __('New Reservation','eagle-booking');

	ob_start();
	include eb_load_template('email/admin.php');
	$eagle_booking_admin_template = ob_get_contents();
	ob_end_clean();

	// Admin email headers
	$eagle_booking_admin_headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: '.$eagle_booking_hotel_name.' <'.$eagle_booking_sender_email.'>',
		'Reply-To: '.$eagle_booking_user_first_name.' '.$eagle_booking_user_last_name.' <'.$eagle_booking_user_email.'>',
	);

	// Send email to admin
	if ( $eagle_booking_message_admin == true ) :
		wp_mail( $eagle_booking_admin_email, $eagle_booking_admin_subject, $eagle_booking_admin_template, $eagle_booking_admin_headers );
	endif;

	/* --------------------------------------------------------------------------
	 * Customer Email
	 ---------------------------------------------------------------------------*/
	$eagle_booking_customer_subject = __('Your Reservation','eagle-booking');
	$eagle_booking_customer_headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: '.$eagle_booking_hotel_name.' <'.$eagle_booking_sender_email.'>',
		'Reply-To: '.$eagle_booking_hotel_name.' <'.$eagle_booking_sender_email.'>',
	);

	ob_start();
	include eb_load_template('email/customer.php');
	$eagle_booking_customer_template = ob_get_contents();
	ob_end_clean();

	// Send email to customer
	if ($eagle_booking_message_guest == true ) :
  		wp_mail( $eagle_booking_user_email, $eagle_booking_customer_subject, $eagle_booking_customer_template, $eagle_booking_customer_headers );
	endif;

}

// Send email after reservation added into the DB
add_action('eb_insert_booking_in_db','eb_send_message', 10 ,27);
