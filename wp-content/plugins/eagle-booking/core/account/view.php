<?php

// DB QUERY
global $wpdb;

$eb_booking_id = $_GET["view_booking"];
$eb_bookings = $wpdb->get_results( "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id = $eb_booking_id");


$eagle_booking_table_name = $wpdb->prefix . 'eagle_booking';
$eb_table_meta_name = $wpdb->prefix . 'eagle_booking_meta';


// Update Booking
if ( isset($_POST['eb_update_booking_status']) ) {


    // First check if the booking [room] is cancellable
    // If yes create a entry on the Eagle Booking Meta Table 'is_cancellable' and set it to true
    // After the response of the admin to the cancellation request create a new entry called 'cancelled' booleand

    $eb_update_booking_status = $_POST['eb_update_booking_status'];
    $wpdb->update(EAGLE_BOOKING_TABLE, array("paypal_payment_status" => $eb_update_booking_status), array("id" => $eb_booking_id));

?>

<!-- <div class="eb-alert success mb50" role="alert">
      <i class="fa fa-check" aria-hidden="true"></i>Cancellation Requst submitted ducessfully. We will get back to you as soon as possible.
</div> -->

<?php

}

foreach ( $eb_bookings as $eb_booking ) {

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

    // Services Total Prices
    $eb_booking_services_price = 0;
    $eb_booking_services_array = explode(',', $eb_booking->extra_services );
    for ($eb_booking_services_array_i = 0; $eb_booking_services_array_i < count($eb_booking_services_array)-1; $eb_booking_services_array_i++) {
        $eb_booking_services = explode('[', $eb_booking_services_array[$eb_booking_services_array_i] );
        $eb_booking_service_id = $eb_booking_services[0];
        $eb_booking_service_price = str_replace(']','',$eb_booking_services[1]);
        $eb_booking_services_price = $eb_booking_services_price + $eb_booking_service_price;
    }

    // Total Price - Services Price
    $eb_booking_room_price = $eb_booking->final_trip_price - $eb_booking_services_price;

    // Room Image & URL
    $eb_booking_room_id = $eb_booking->id_post;
    $eb_booking_image_id = get_post_thumbnail_id($eb_booking_room_id);
    $eb_booking_image_attributes = wp_get_attachment_image_src( $eb_booking_image_id, 'thumbnail' );
    $eb_booking_room_img_src = $eb_booking_image_attributes[0];
    $eb_booking_room_url = get_the_permalink($eb_booking_room_id)

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

    <div class="row">
        <div class="col-md-6">
            <strong><?php echo __('Booking ID', 'eagle-booking'). ': ' .$eb_booking_id; ?></strong><br>
            <span><small><?php echo $eb_booking->date ?></small></span>
        </div>

        <div class="col-md-6">
            <form method="POST">
                <input type="hidden" name="eb_update_booking_status" value="cancellation_requested">
                <!-- <button class="btn eb-btn btn-border btn-small pull-right" type="submit"><?php echo __('Request Cancellation', 'eagle-booking')?></button> -->
            </form>
            <button class="btn eb-btn btn-border btn-small pull-right" onClick="window.print()"><?php echo __('Print Booking Details', 'eagle-booking') ?></button>
        </div>
    </div>

    <div class="eb-printable">

        <div class="eb-main-booking-details mt50">

            <div class="eb-hotel-logo eb-only-printable">
                <?php
                if (!empty( eb_get_option('hotel_logo') )) {
                    echo "<img src=".eb_get_option('hotel_logo')." height='25px'>";
                } else {
                    echo get_bloginfo( 'name' );
                }
                ?>
            </div>

            <div class="eb-main-booking-details-head">
                <div class="row">
                    <div class="col-md-2">
                        <span><?php echo __('Arrival Date', 'eagle-booking') ?></span>
                        <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_from) ?> </span>
                    </div>
                    <div class="col-md-2">
                        <span><?php echo __('Departure Date', 'eagle-booking') ?></span>
                        <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_to) ?> </span>
                    </div>
                    <div class="col-md-2">
                        <span><?php echo __('Guests', 'eagle-booking') ?></span>
                        <span> <?php echo $eb_booking->guests ?> </span>
                    </div>
                    <div class="col-md-3">
                        <span><?php echo __('Payment Method', 'eagle-booking') ?></span>
                        <span><?php echo $eb_booking_payment_method_text ?> </span>
                    </div>
                    <div class="col-md-3">
                        <span><?php echo __('Status', 'eagle-booking') ?></span>
                        <span class="eb-booking-status eb-<?php echo esc_attr($eb_booking_status_class) ?>"> <?php echo $eb_booking_status_text ?> </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="eb-booking-details-footer">

            <div class="row">

                <div class="col-md-6">
                    <div class="pull-left">
                        <p>
                            <span><?php echo __('Transaction ID', 'eagle-booking') ?></span>
                            <span><?php echo $eb_booking->paypal_tx ?></span>
                        </p>
                        <p>
                            <span><?php echo __('Phone', 'eagle-booking') ?></span>
                            <span><?php echo $eb_booking->user_phone ?></span>
                        </p>
                        <p>
                            <span><?php echo __('Email', 'eagle-booking') ?></span>
                            <span><?php echo $eb_booking->paypal_email ?></span>
                        </p>
                        <p>
                            <span><?php echo __('Adress', 'eagle-booking') ?></span>
                            <span><?php echo $eb_booking->user_address. ' ' .$eb_booking->user_city . ', ' .$eb_booking->user_country ?></span>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">

                        <div class="eb-booking-synopsis">

                            <?php

                            /**
                             * Additional Service
                             */
                            $eagle_booking_services_array = explode(',', $eb_booking->extra_services);

                            $eagle_booking_tot_services = 0;
                            $eb_services_total_price  = 0;

                            for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array)-1; $eagle_booking_services_array_i++) :

                            $eagle_booking_service_array = explode('[', $eagle_booking_services_array[$eagle_booking_services_array_i]);
                            $eagle_booking_service_id = $eagle_booking_service_array[0];
                            $eagle_booking_service_name = get_the_title($eagle_booking_service_id);
                            $eagle_booking_mtb_service_price_type_1 = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price_type_1', true);
                            $eagle_booking_mtb_service_price_type_2 = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price_type_2', true);

                            $eb_service_price = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price', true);

                            $eagle_booking_service_price = str_replace(']', '', $eagle_booking_service_array[1]);

                            if (empty($eagle_booking_service_price)) {
                                $eagle_booking_service_price = 10;
                            }

                            if ($eagle_booking_mtb_service_price_type_1 == 'guest') {
                                $eagle_booking_price_type_1 = $eb_booking->guests;
                            } else {
                                $eagle_booking_price_type_1 = 1;
                            }
                            if ($eagle_booking_mtb_service_price_type_2 == 'night') {
                                $eagle_booking_price_type_2 = eb_total_booking_nights($eb_booking->date_from, $eb_booking->date_to);
                            } else {
                                $eagle_booking_price_type_2 = 1;
                            }

                            $eb_service_price = $eagle_booking_service_price / $eagle_booking_price_type_1 / $eagle_booking_price_type_2;

                            if (empty($eagle_booking_service_price_initial)) {
                                $eagle_booking_service_price_initial = 0;
                            }

                            ?>
                            <div class="eb-booking-synopsis-tem">
                                <span><?php echo $eagle_booking_service_name ?></span>
                                <span><?php echo eb_price( $eagle_booking_service_price ) ?></span>
                            </div>

                            <?php

                            $eb_services_total_price = $eagle_booking_tot_services + $eagle_booking_service_price;

                            endfor;

                            /**
                             * Fees & Taxes
                             */
                            $fees = get_option('eb_fees');
                            $taxes = get_option('eb_taxes');
                            $booking_taxes = $wpdb->get_results("SELECT * FROM $eb_table_meta_name WHERE booking_id = $eb_booking_id AND meta_key = 'tax' ");
                            $booking_fees = $wpdb->get_results("SELECT * FROM $eb_table_meta_name WHERE booking_id = $eb_booking_id AND meta_key = 'fee' ");
                            $room_price = $wpdb->get_row( "SELECT * FROM $eb_table_meta_name WHERE booking_id = $eb_booking_id AND meta_key = 'room_price' " );

                            $room_price = $room_price->meta_value;

                            ?>

                            <div class="eb-booking-synopsis-item">
                                <span><?php echo $eb_booking->title_post ?></span>
                                <span><?php echo eb_price( $room_price ); ?></span>
                            </div>

                            <?php



                            //   Fees

                            if ( $booking_fees ) {

                                $html = '<div class="eb-booking-synopsis-item">';

                                foreach( $booking_fees  as $key => $booking_fee ) {

                                foreach ( $fees  as $key => $item ) {

                                    if ( $booking_fee->meta_value == $item['id'] ) {

                                    $type = !empty( $item["type"] ) ? $item["type"] : '';

                                    $amount = $item['amount'];

                                    // Calculate the fee total
                                    if ( $type === 'per_booking' ) {

                                        $fee_amount = $amount;

                                    } elseif ( $type === 'per_booking_nights' ) {

                                        $fee_amount = $amount * eb_total_booking_nights($eb_booking->date_from, $eb_booking->date_to);

                                    } elseif ( $type === 'per_booking_nights_guests' ) {

                                        $fee_amount = $amount * $eagle_booking_guests * eb_total_booking_nights($eb_booking->date_from, $eb_booking->date_to);

                                    } else {

                                        $fee_amount = $amount * $eagle_booking_guests;

                                    }

                                    $html .= '<span>'.$item['title'].'</span>';
                                    $html .= '<span>'.eb_price( $fee_amount ).'</span>';

                                    }

                                }

                                $html .= "</div>";

                                }

                                echo $html;

                            }

                            //   Taxes
                            if ( $booking_taxes ) {

                                foreach( $booking_taxes  as $key => $booking_tax ) {

                                foreach ( $taxes  as $key => $tax ) {

                                    if ( $booking_tax->meta_value == $tax['id'] ) {

                                    $tax_amount = $tax['amount'] * $room_price / 100;

                                    $html = '<div class="eb-booking-synopsis-item">';
                                    $html .= '<span>'.$tax['title'].'</span>';
                                    $html .= '<span>'.eb_price( round( $tax_amount ) ).'</span>';
                                    $html .= "</div>";

                                    }

                                }

                                }

                                echo $html;

                            }

                        ?>

                        <div class="eb-booking-synopsis-item total">
                            <span><?php echo __('Total Price', 'eagle-booking') ?></span>
                            <span><?php echo eb_price($eb_booking->final_trip_price) ?></span>
                        </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php

}

?>