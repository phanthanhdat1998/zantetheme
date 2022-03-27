<?php
/**
* The Template for the calendar
*
* This template can be overridden by copying it to yourtheme/eb-templates/single-room/booking-form.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.1.6
*/

defined('ABSPATH') || exit;
?>

<div class="eb-widget eb-widget-border calendar">
  <h2 class="title"><?php echo __('Book Your Room','eagle-booking') ?></h2>
  <div class="inner">
      <form id="room-booking-form" action="<?php echo $eagle_booking_action ?>" class="room-booking-form" method="<?php echo $eagle_booking_action_method ?>" target="<?php echo esc_attr( $eagle_booking_target ) ?>">
        <div class="row">
            <?php include eb_load_template('elements/custom-parameters.php') ?>

            <input type="hidden" name="eb_room_id" value="<?php echo get_the_ID() ?>" />
            <input type="hidden" name="eb_single_room" value="1">

            <?php if (eb_get_option('booking_type') == 'custom' ) : ?>
            <input type="hidden" name="<?php echo esc_html( $eagle_booking_room_param ) ?>" value="<?php echo esc_html( $eagle_booking_room_external_id ) ?>" >
            <?php endif ?>

            <!-- CHECK IN/OUT -->
            <div class="col-md-12">
              <?php include eb_load_template('elements/dates-picker.php') ?>
            </div>
            <!-- GUESTS -->
            <div class="col-md-12">
              <?php include eb_load_template('elements/guests-picker.php') ?>
            </div>
            <!--SUBMIT -->
            <div class="col-md-12">
              <?php
                  $eagle_booking_meta_box_room_custom_link = get_post_meta( get_the_ID(), 'eagle_booking_room_custom_link', true );
                  if ( empty($eagle_booking_meta_box_room_custom_link) ) { ?>

                      <button id="eb_search_form" name="submit" class="button eb-btn mt30" type="submit">
                        <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking') ?></span>
                      </button>

              <?php } else { ?>
              <a target="_blank" class="btn eb-btn" href="<?php echo $eagle_booking_meta_box_room_custom_link ?>"><?php echo __('Book Now','eagle-booking') ?></a>
              <?php } ?>
            </div>
        </div>
      </form>
  </div>
</div>