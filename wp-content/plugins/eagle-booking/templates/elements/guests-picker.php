<?php
   /**
    * The Template for the guests picker
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/elements/guests-picker.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.5
    */

   defined('ABSPATH') || exit;

  // Include form parameters
  include_once EB_PATH . '/core/admin/form-parameters.php';

?>

<label for="eagle_booking_guests"><?php echo __('Guests','eagle-booking') ?></label>
<div class="eb-guestspicker">

  <div class="form-control guestspicker">
    <?php echo __('Guests','eagle-booking') ?> <span class="gueststotal"></span>
  </div>

  <div class="eb-guestspicker-content">

    <?php if  (eb_get_option('eb_adults_children') == true ) : ?>

    <!-- Adults -->
    <div class="guests-buttons">
      <div class="description">
        <label><?php echo __('Adults','eagle-booking') ?></label>
        <?php if (!empty(eb_get_option('eb_adult_age'))) : ?>
          <div class="ages"><?php echo esc_html__('Ages', 'eagle-booking') .' ' .eb_get_option('eb_adult_age') ?></div>
        <?php endif ?>
      </div>
      <div class="guests-button">
        <div class="minus"></div>
        <input type="text" id="eagle_booking_adults" name="<?php echo $eagle_booking_adults_param ?>" class="booking-guests" value="<?php echo $eagle_booking_adults ?>" min="1" max="<?php echo esc_html($eb_max_adults) ?>">
        <div class="plus"></div>
      </div>
    </div>
    <!-- Children -->
    <div class="guests-buttons">
      <div class="description">
        <label><?php echo __('Children','eagle-booking') ?></label>
        <?php if (!empty(eb_get_option('eb_child_age'))) : ?>
        <div class="ages"><?php echo esc_html__('Ages', 'eagle-booking') .' ' .eb_get_option('eb_child_age') ?></div>
        <?php endif ?>
      </div>
      <div class="guests-button">
        <div class="minus"></div>
        <input type="text" id ="eagle_booking_children" name="<?php echo $eagle_booking_children_param ?>" class="booking-guests" value="<?php echo $eagle_booking_children ?>" min="0" max="<?php echo esc_html($eb_max_children) ?>">
        <div class="plus"></div>
      </div>
    </div>

    <!-- Infants -->
    <!-- <div class="guests-buttons">
      <div class="description">
        <label><?php echo __('Infants','eagle-booking') ?></label>
        <?php if (!empty(eb_get_option('eb_child_age'))) : ?>
        <div class="ages"><?php echo esc_html__('Ages', 'eagle-booking') .' ' .eb_get_option('eb_child_age') ?></div>
        <?php endif ?>
      </div>
      <div class="guests-button">
        <div class="minus"></div>
        <input type="text" id ="eagle_booking_children" name="<?php echo $eagle_booking_children_param ?>" class="booking-guests" value="<?php echo $eagle_booking_children ?>" min="0" max="<?php echo esc_html($eb_max_children) ?>">
        <div class="plus"></div>
      </div>
    </div> -->

    <?php else : ?>

    <!-- Guests -->
    <div class="guests-buttons">
      <div class="description">
        <label><?php echo __('Guests','eagle-booking') ?></label>
      </div>
      <div class="guests-button">
        <div class="minus"></div>
        <input type="text" id ="eagle_booking_guests" name="<?php echo $eagle_booking_guests_param ?>" class="booking-guests" value="<?php echo $eagle_booking_guests ?>" min="1" max="<?php echo esc_html($eb_max_guests) ?>">
        <div class="plus"></div>
      </div>
    </div>

    <?php endif ?>

  </div>
</div>
