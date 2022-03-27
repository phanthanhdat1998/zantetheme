<?php

   /**
    * The Template for the booking form
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/form.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.5
    */

   defined('ABSPATH') || exit;
?>

<div class="eb-section eb-checkout-form">

    <h2 class="title"><?php echo __('Billing Details','eagle-booking') ?></h2>

    <?php

    $eb_current_user_id = get_current_user_id();
    $eb_current_user = wp_get_current_user();
    $eb_booking_forms = eb_get_option('checkout_form');

    // check if signin & signup option is enabled
    if ( $eb_booking_forms['signin'] == true || $eb_booking_forms['signup'] == true || $eb_booking_forms['guest'] == true ) {

        include eb_load_template('booking/form/signedin.php');

    ?>

    <div id="eb_billing_tabs" class="eb-tabs" style="<?php if (is_user_logged_in()) { echo esc_attr('display: none;');  } ?>">

        <div class="eb-tabs-titles">

            <?php

            foreach ($eb_booking_forms as $eb_booking_form => $value) :

                switch ($eb_booking_form) :

                    case 'signin': if ($value == 1) : ?>
                        <div class="eb-tab" data-tab="signin">
                            <input class="tab-radio" id="eb_signin" name="eb_billing_tab" type="radio" value="signin">
                            <label for="eb_signin" class="radio-label"><?php echo __('Existing Customer Login', 'eagle-booking') ?></label>
                        </div>
                    <?php endif;
                    break; ?>

                    <?php case 'signup': if ($value == 1) : ?>
                        <div class="eb-tab" data-tab="signup">
                            <input class="tab-radio" id="eb_signup" name="eb_billing_tab" type="radio" value="signup">
                            <label for="eb_signup" class="radio-label"><?php echo __('Create a New Account', 'eagle-booking') ?></label>
                        </div>
                    <?php endif;
                    break; ?>

                    <?php case 'guest': if ($value == 1) : ?>
                        <div class="eb-tab" data-tab="guest">
                            <input class="tab-radio" id="eb_guest" name="eb_billing_tab" type="radio" value="guest">
                            <label for="eb_guest" class="radio-label"><?php echo __('Checkout as Guest', 'eagle-booking') ?></label>
                        </div>
                    <?php endif;
                    break;

                endswitch;

            endforeach; ?>
        </div>

        <div id="eb_billing_tabs_content" class="eb-tabs-content">
        <?php

            foreach ($eb_booking_forms as $eb_booking_form => $value) {

                switch ($eb_booking_form) {

                    case 'signin': if ($value == 1) {
                        include eb_load_template('booking/form/signin.php');
                    }
                    break;

                    case 'signup': if ($value == 1) {
                        include eb_load_template('booking/form/signup.php');
                    }
                    break;

                    case 'guest': if ($value == 1) {
                            include eb_load_template('booking/form/guest.php');
                    }
                    break;

                }
            }

        ?>
        </div>

    </div>

    <?php

        } else {

            echo '<div id="eb_billing_tabs_content" class="eb-tabs-content">';

            include eb_load_template('booking/form/guest.php');

            echo '</div>';
        }
    ?>



    <form id="eb_booking_form" method="post" class="eagle-booking-booking-form" action="<?php echo eb_checkout_page() ?>">
        <input type="hidden" id="eb_security" value="<?php echo wp_create_nonce('eb_nonce', 'security'); ?>">
        <input type="hidden" id="eb_arrive" name="eb_arrive" value="1">
        <input type="hidden" id="eb_booking_price" name="eb_booking_price" data-initial-amount="<?php echo eb_total_price($eb_room_id, $eb_trip_price, $eb_booking_nights, $eb_guests, true); ?>" value="<?php echo eb_total_price($eb_room_id, $eb_trip_price, $eb_booking_nights, $eb_guests, true); ?>">
        <input type="hidden" id="eb_room_price" name="eb_room_price" value="<?php echo $eb_room_total_price ?>">
        <input type="hidden" id="eb_services_taxes">
        <input type="hidden" id="eb_date_from" name="eb_date_from" value="<?php echo $eb_checkin ?>">
        <input type="hidden" id="eb_date_to" name="eb_date_to" value="<?php echo $eb_checkout ?>">
        <input type="hidden" id="eb_guests" name="eb_guests" value="<?php echo $eb_guests ?>">
        <input type="hidden" id="eb_adults" name="eb_adults" value="<?php echo $eb_adults ?>">
        <input type="hidden" id="eb_children" name="eb_children" value="<?php echo $eb_children ?>">
        <input type="hidden" id="eb_id" name="eb_room_id" value="<?php echo $eb_room_id ?>">
        <input type="hidden" id="eb_title" name="eb_room_title" value="<?php echo get_the_title($eb_room_id) ?>">
        <input type="hidden" id="eb_additional_services_id" name="eb_additional_services_id">
        <input type="hidden" id="eb_user_first_name" name="eb_user_firstname">
        <input type="hidden" id="eb_user_last_name" name="eb_user_lastname">
        <input type="hidden" id="eb_user_email" name="eb_user_email">
        <input type="hidden" id="eb_user_phone" name="eb_user_phone">
        <input type="hidden" id="eb_user_country" name="eb_user_country">
        <input type="hidden" id="eb_user_city" name="eb_user_city">
        <input type="hidden" id="eb_user_address" name="eb_user_address">
        <input type="hidden" id="eb_user_zip" name="eb_user_zip">

        <?php

            /**
            * Include booking details
            */
            if ( eb_get_option('eb_booking_form_fields')['requests'] == true ) include eb_load_template('booking/form/details.php');

            /**
            * Include arrival time
            */
            if ( eb_get_option('eb_booking_form_fields')['arrival'] == true ) include eb_load_template('booking/form/arrival.php');

            /**
            * Include coupon code
            */
            if ( eb_get_option('eb_booking_form_fields')['coupon'] == true ) include eb_load_template('booking/form/coupon.php');

            /**
            * Include terms & condition checkbox
            */
            if ( eb_get_option('eb_booking_form_fields')['terms_conditions'] == true ) include eb_load_template('booking/form/terms.php');

            /**
            * Include phone field translation
            */
            include eb_load_template('elements/phone-field.php');
        ?>

    </form>

</div>
