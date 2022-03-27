<?php
/**
 * The Template for displaying quick details
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/quick-details.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<div class="room-quick-details">
  <?php
    $eb_search_filters = eb_get_option('eb_search_quick_details_elements');
    if ($eb_search_filters): foreach ($eb_search_filters as $eb_search_filter=>$value) {

      switch($eb_search_filter) {

        case 'room_availability': include eb_load_template('search/room/quick-details/availability.php');
        break;

        case 'included_services': include eb_load_template('search/room/quick-details/services.php');
        break;

        case 'additional_services': include eb_load_template('search/room/quick-details/additional-services.php');
        break;

        case 'price_breakdown': include eb_load_template('search/room/quick-details/price-breakdown.php');
        break;
      }

    }

    endif;
  ?>
</div>
