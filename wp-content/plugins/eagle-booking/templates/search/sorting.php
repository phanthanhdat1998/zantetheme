<?php
/**
 * The Template for displaying sorting
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/sorting.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<div class="rooms-bar">
  <span class="total-rooms">
  <?php echo sprintf( __('You found <strong id="results-number">%s</strong> rooms from', 'eagle-booking'), $eagle_booking_results_qnt ) ?>
    <?php echo eb_price( eb_rooms_min_max_price('min') ) ?>
  </span>

  <span class="rooms-view-sorting">
    <!-- <span class="rooms-view">
      <a href="#" class="grid-btn"><i class="fa fa-list" aria-hidden="true"></i></a>
      <a href="#" class="grid-btn active"><i class="fa fa-th" aria-hidden="true"></i></a>
    </span> -->
    <span class="eb-dropdown eb-rooms-sorting">

      <div id="eagle_booking_active_sorting" class="eb-dropdown-toggle"><?php echo __('Sort by: Default','eagle-booking') ?></div>

      <ul id="eagle_booking_search_sorting" class="eb-dropdown-menu">
        <li class="sorting_option">
          <a class="search_sorting" data-meta-key="eagle_booking_mtb_room_price_min" data-order="ASC"><?php echo __('Sort by: Lowest Price','eagle-booking') ?></a>
        </li>
        <li class="sorting_option">
          <a class="search_sorting" data-meta-key="eagle_booking_mtb_room_price_min" data-order="DESC"><?php echo __('Sort by: Highest Price','eagle-booking') ?></a>
        </li>
        <li class="sorting_option">
          <a class="search_sorting" data-meta-key="" data-order=""><?php echo __('Sort by: Default','eagle-booking') ?></a>
        </li>
      </ul>

    </span>
  </span>
</div>
