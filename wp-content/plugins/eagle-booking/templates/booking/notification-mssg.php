<?php
   /**
    * The Template for the notification mssg
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/notification-mssg.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.0
    */

   defined('ABSPATH') || exit;
?>

<?php

if ( eb_get_option('booking_page_mssg') ) : ?>

    <div class="eb-alert eb-alert-info eb-alert-icon mb50" role="alert">
        <div class="alert-inner">
            <?php echo wp_kses_post(eb_get_option('booking_page_mssg')) ?>
        </div>
    </div>

<?php endif ?>