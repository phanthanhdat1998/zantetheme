<?php
/**
 * The Template for displaying filters
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/filters.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<div class="search-filters <?php if ( eb_get_option('eb_search_page_sticky_sidebar') == true  ) echo 'sticky-sidebar'; ?>">

  <div class="eb-widget eb-search-form">
    <h2 class="title"><?php echo __('Booking Details','eagle-booking') ?></h2>
    <div class="inner">
      <form id="search_form" class="booking-search-form">
        <div class="">
          <?php
          /**
          * Include Dates Picker
          */
          include eb_load_template('elements/dates-picker.php');
          ?>
        </div>
        <div class="">
          <?php
          /**
          * Include Guests Picker
          */
          include eb_load_template('elements/guests-picker.php');
          ?>
        </div>
      </form>
    </div>
  </div>

<?php

  /**
  * Include Sortable Filters
  */
  $eb_search_filters = eb_get_option('eagle_booking_search_page_settings');

  if ( $eb_search_filters ) { foreach ($eb_search_filters as $eb_search_filter=>$value) {

      switch($eb_search_filter) {

        case 'price_range_filter': if ($value == 1) include eb_load_template('search/filters/price.php');
        break;

        case 'services_filter': if ($value == 1) include eb_load_template('search/filters/services.php');
        break;

        case 'additional_services_filter': if ($value == 1) include eb_load_template('search/filters/additional-services.php');
        break;

        case 'branches': if ($value == 1) include eb_load_template('search/filters/branches.php');
        break;

      }

  }

}

?>

</div>