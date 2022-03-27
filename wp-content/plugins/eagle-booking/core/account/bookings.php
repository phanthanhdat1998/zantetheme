<?php

if (isset($_GET["bookings"])) {

// DB QUERY
global $wpdb;

$eb_booking_id = get_the_ID();
$eb_current_user_id = get_current_user_id();
$eb_current_user = wp_get_current_user();

$eb_bookings = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_user = '$eb_current_user_id' ORDER BY id DESC LIMIT 30");
$eb_bookings_all = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_user = '$eb_current_user_id'");
$eb_bookings_pending = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE paypal_payment_status = 'Pending' AND id_user = '$eb_current_user_id'");
$eb_bookings_pending_payment = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE paypal_payment_status = 'Pending Payment' AND id_user = '$eb_current_user_id'");
$eb_bookings_canceled = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE paypal_payment_status = 'Canceled' AND id_user = '$eb_current_user_id'");
$eb_bookings_completed = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE paypal_payment_status = 'Completed' AND id_user = '$eb_current_user_id'");

?>

<!-- User Menu -->
<nav class="eb-account-menu">
    <ul class="short">
        <li class="menu-item"><a href="<?php echo esc_url( eb_account_page() ) ?>" aria-current="page"><?php echo __('Dashboard', 'eagle-booking') ?></a></li>
        <li class="menu-item active"><a href="<?php echo esc_url( eb_account_page() ) ?>?bookings"><?php echo __('Bookings', 'eagle-booking') ?></a></li>
        <li class="menu-item"><a href="<?php echo esc_url( eb_account_page() ) ?>?account_details"><?php echo __('Account Details', 'eagle-booking') ?></a></li>
        <li class="menu-item"><a href="<?php echo wp_logout_url( eb_account_page().'?sign_in' ) ?>"><?php echo __('Log Out', 'eagle-booking') ?></a></li>
    </ul>
</nav>

<h5 class="mt50"><?php echo __('My Bookings', 'eagle-booking') ?></h5>

<!-- Bookings -->
<table class="eb-user-bookings-table mt30">
    <tbody>
        <tr>
            <th width="5%"><?php echo __('ID', 'eagle-booking') ?></th>
            <th width="25%"><?php echo __('Room Title', 'eagle-booking') ?></th>
            <th width="25%"><?php echo __('Dates', 'eagle-booking') ?></th>
            <th width="7%"><?php echo __('Price', 'eagle-booking') ?></th>
            <th width="6%"><?php echo __('Guests', 'eagle-booking') ?></th>
            <th width="14%"><?php echo __('Payment Method', 'eagle-booking') ?></th>
            <th width="13%"><?php echo __('Status', 'eagle-booking') ?></th>
            <th width="5%"><?php echo __('Action', 'eagle-booking') ?></th>
        </tr>

        <?php if( $eb_bookings ) : ?>

            <?php foreach ( $eb_bookings as $eb_booking ) :

                // Booking Status & Class
                if ( $eb_booking->paypal_payment_status == 'Pending Payment' ) {
                    $eb_booking_status_text = __('Pending Payment', 'eagle-booking');
                    $eb_booking_status_class = 'pending-payment';

                } elseif ( $eb_booking->paypal_payment_status == 'Pending' ){
                    $eb_booking_status_text = __('Pending', 'eagle-booking');
                    $eb_booking_status_class = 'pending';

                } elseif ( $eb_booking->paypal_payment_status == 'Canceled' ){
                    $eb_booking_status_text = __('Canceled', 'eagle-booking');
                    $eb_booking_status_class = 'canceled';

                } else {
                    $eb_booking_status_text = __('Completed', 'eagle-booking');
                    $eb_booking_status_class = 'completed';
                }


                // Get the payment method text
                if( $eb_booking->action_type === 'payment_on_arrive' ) {

                    $eb_booking_payment_method_text = __('Payment on Arrival', 'eagle-booking');

                } elseif ($eb_booking->action_type === '2checkout') {

                    $eb_booking_payment_method_text = __('2Checkout', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'bank_transfer') {

                    $eb_booking_payment_method_text = __('Bank Transfer', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'PayU') {

                    $eb_booking_payment_method_text = __('PayU', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'paystack') {

                    $eb_booking_payment_method_text = __('Paystack', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'flutterwave') {

                    $eb_booking_payment_method_text = __('Flutterwave', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'vivawallet') {

                    $eb_booking_payment_method_text = __('Viva Wallet', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'razorpay') {

                    $eb_booking_payment_method_text = __('Razorpay', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'booking_request') {

                    $eb_booking_payment_method_text =  __('Booking Request', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'stripe') {

                    $eb_booking_payment_method_text = __('Stripe', 'eagle-booking');

                } elseif ($eb_booking->action_type === 'paypal') {

                    $eb_booking_payment_method_text = __('PayPal', 'eagle-booking');

                }

                // Room URL
                $eb_booking_room_id = $eb_booking->id_post;
                $eb_booking_room_url = get_the_permalink($eb_booking_room_id)

            ?>

            <tr>
                <td><?php echo esc_html( $eb_booking->id ) ?></td>
                <td>
                <div style="display:flex; align-items: center;">
                    <a href="<?php echo esc_url($eb_booking_room_url) ?>" target="_blank">
                        <?php echo esc_html( $eb_booking->title_post ) ?>
                    </a>
                </div>
                </td>
                <td>
                <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_from) ?> </span> →
                <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_to) ?> </span>
                </td>
                <td>
                <?php if ( eb_currency_position() == 'before' ) : ?>
                <?php echo eb_currency() ?><?php eb_formatted_price($eb_booking->final_trip_price) ?>
                <?php else : ?>
                <?php eb_formatted_price($eb_booking->final_trip_price) ?><?php echo eb_currency() ?>
                <?php endif ?>
                </td>
                <td> <?php echo $eb_booking->guests ?></td>
                <td><span><?php echo $eb_booking_payment_method_text ?></span></td>
                <td><span class="eb-booking-status eb-<?php echo esc_attr($eb_booking_status_class) ?>"><?php echo $eb_booking_status_text ?></span></td>
                <td><a href="?view_booking=<?php echo $eb_booking->id ?>" class="view-booking-link"><?php echo __('View', 'eagle-booking')?></a></td>
            </tr>

            <?php endforeach ?>

        <?php else : ?>

            <tr>
                <td colspan="8">
                    <div class="no-bookings">
                        <i class="far fa-frown"></i>
                        <?php echo __('You do not have any booking yet.', 'eagle-booking') ?> <a href="<?php echo eb_search_page() ?>"><?php echo __('Add New Booking', 'eagle-booking') ?></a>
                    </div>
                </td>
            </tr>

        <?php endif ?>

    </tbody>
</table>

<?php } ?>