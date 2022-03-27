<?php
/**
 * The Template for displaying room sidebar
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/sidebar.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<div class="eb-column">
    <div class="room-sidebar <?php if (eb_get_option('eb_room_page_sticky_sidebar') == true ) echo esc_attr('sticky-sidebar'); ?>">

    <?php

      // Load hotel branch if enabled
      if ( eb_get_option('room_hotel_branch') == true ) include eb_load_template('single-room/branch.php');

      // Load booking form if enabled
      if (eb_get_option('eagle_booking_room_booking_form') == true ) include eb_load_template('single-room/booking-form.php');

      // Get sidebar widgets
      dynamic_sidebar("eagle_booking_single_room_sidebar");

    ?>

    </div>

</div>