<?php
/**
 * The Template for displaying room availability
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/availability.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<?php   $eb_end_period = "+".eb_get_option('eb_calendar_availability_period'). " months" ?>
  <h2 class="section-title"><?php echo esc_html__('Room Availability', 'eagle-booking') ?></h2>
  <div id="availability-calendar"></div>

  <ul class="availability-calendar-list-availability">
    <li>
      <span class="available"></span>
      <?php echo __('Available', 'eagle-booking') ?>
    </li>
    <li>
      <span class="not-available"></span>
      <?php echo __('Not Available', 'eagle-booking') ?>
    </li>
  </ul>

  <script>
    (function($) {
      "use strict";
      $(document).ready(function() {

        $("#availability-calendar").simpleCalendar({
          events: eb_booked_dates
        });
    });
    })(jQuery);
  </script>