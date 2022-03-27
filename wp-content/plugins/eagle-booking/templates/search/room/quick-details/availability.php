<?php
/**
 * The Template for displaying availability
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/quick-details/availability.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<?php if ( eb_get_option('eb_search_quick_details_elements')['room_availability'] == true ) : ?>
  <?php   $eb_end_period = "+".eb_get_option('eb_calendar_availability_period'). " months" ?>
  <div id="availability-calendar-<?php echo $eb_room_id ?>"></div>

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
        $("#availability-calendar-<?php echo $eb_room_id ?>").simpleCalendar({
            fixedStartDay: false,
            events: [<?php eb_room_availability_calendar($eb_room_id, date('Y/m/d'), date('Y/m/d', strtotime($eb_end_period)) ) ?>]
        });
    });
    })(jQuery);
  </script>
<?php endif ?>
