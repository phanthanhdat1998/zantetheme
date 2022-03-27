<?php

/**
* The Template for the step line during the booking process
*
* This template can be overridden by copying it to yourtheme/eb-templates/elements/stepline.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.1.5
*/

defined('ABSPATH') || exit;

if ( get_permalink() == eb_search_page()  ) {

    $search_page = 'completed active';
    $booking_page = 'disabled';
    $checkout_page = 'disabled';
    $thankyou_page = 'disabled';

} elseif  ( get_permalink() == eb_booking_page() ) {

    $search_page = 'completed';
    $booking_page = 'completed active';
    $checkout_page = 'disabled';
    $thankyou_page = 'disabled';

} elseif  ( get_permalink() == eb_checkout_page() &&  $eagle_booking_arrive == 1 ) {

    $search_page = 'completed';
    $booking_page = 'completed';
    $checkout_page = 'completed active';
    $thankyou_page = 'disabled';

} else {

    $search_page = 'completed';
    $booking_page = 'completed';
    $checkout_page = 'completed';
    $thankyou_page = 'completed active';
}

?>

<div class="eb-stepline">
    <div class="eb-stepline-steps">
        <div class="eb-stepline-step <?php echo $search_page ?> ">
            <div class="eb-stepline-progress">
                <div class="eb-stepline-progress-bar"></div>
            </div>
            <div class="eb-stepline-dot"></div>
            <div class="text-center bs-wizard-stepnum"><?php echo __('Search', 'eagle-booking') ?></div>
            <div class="bs-wizard-info text-center"><?php echo __('Choose your favorite room', 'eagle-booking') ?></div>
        </div>
        <div class="eb-stepline-step <?php echo $booking_page ?>">
            <div class="eb-stepline-progress">
                <div class="eb-stepline-progress-bar"></div>
            </div>
            <div class="eb-stepline-dot"></div>
            <div class="text-center bs-wizard-stepnum"><?php echo __('Booking', 'eagle-booking') ?></div>
            <div class="bs-wizard-info text-center"><?php echo __('Enter your booking details', 'eagle-booking') ?></div>
        </div>
        <div class="eb-stepline-step <?php echo $checkout_page ?>">
            <div class="eb-stepline-progress">
                <div class="eb-stepline-progress-bar"></div>
            </div>
            <div class="eb-stepline-dot"></div>
            <div class="text-center bs-wizard-stepnum"><?php echo __('Checkout', 'eagle-booking') ?></div>
            <div class="bs-wizard-info text-center"><?php echo __('Use your preferred payment method', 'eagle-booking') ?></div>
        </div>
        <div class="eb-stepline-step <?php echo $thankyou_page ?>">
            <div class="eb-stepline-progress">
                <div class="eb-stepline-progress-bar"></div>
            </div>
            <div class="eb-stepline-dot"></div>
            <div class="text-center bs-wizard-stepnum"><?php echo __('Confirmation', 'eagle-booking' ) ?></div>
            <div class="bs-wizard-info text-center"><?php echo __('Receive a confirmation email', 'eagle-booking') ?></div>
        </div>
    </div>
</div>