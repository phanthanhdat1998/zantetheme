<?php
   /**
    * The Template for the booking details
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/details.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.7
    */

   defined('ABSPATH') || exit;

?>

<div class="booking-sidebar <?php if ( eb_get_option('eb_booking_page_sticky_sidebar') == true  ) echo 'sticky-sidebar'; ?>">
  <div class="eb-widget no-title">
    <div class="inner">

      <!-- Selected Room -->
      <?php
      $eagle_booking_selected_room_image = eagle_booking_get_room_img_url($eb_room_id, 'eagle_booking_image_size_720_470');
      $eagle_booking_selected_room_url = get_permalink( $eb_room_id );
        if ( !empty($eagle_booking_selected_room_image) ) : ?>
          <div class="selected-room">
            <a href="<?php echo esc_url($eagle_booking_selected_room_url) ?>" target="_blank">
              <img src="<?php echo $eagle_booking_selected_room_image ?>" class="img-responsive">
            </a>
          </div>
      <?php endif ?>

      <div class="booking-info">

      <!-- Booking Details -->
      <div class="booking-details">

      <div class="title"> <?php echo __('Booking Details', 'eagle-booking') ?> </div>

        <?php if ( eb_room_has_branch( $eb_room_id ) ) : ?>
          <div class="item branch">
            <span class="desc"><?php echo esc_html__('Branch', 'eagle-booking') ?></span>
            <span class="value"><strong><?php echo eb_room_branch( $eb_room_id, true, true ) ?></strong></span>
          </div>
        <?php endif ?>

          <div class="item checkin">
            <span class="desc"><?php echo esc_html__('Check In', 'eagle-booking') ?></span>
            <span class="value"><strong><?php echo eagle_booking_displayd_date_format($eb_checkin); ?></strong><?php eb_checkin_checkout_time('checkin') ?></span>
          </div>

          <div class="item checkout">
            <span class="desc"> <?php echo esc_html__('Check Out', 'eagle-booking') ?></span>
            <span class="value"><strong><?php echo eagle_booking_displayd_date_format($eb_checkout); ?></strong><?php eb_checkin_checkout_time('checkout') ?></span>
          </div>
          <div class="item booking-nights">
            <span class="desc"><?php echo esc_html__('Nights', 'eagle-booking') ?></span>
            <span class="value"><strong><?php echo eb_total_booking_nights($eb_checkin, $eb_checkout) ?></strong></span>
          </div>

          <div class="item guests">
            <span class="desc"><?php echo esc_html__('Guests', 'eagle-booking') ?></span>
            <span class="value">
              <strong>
                <?php if ( eb_get_option('eb_adults_children') == true ) : ?>
                  <?php echo $eb_adults.' '. esc_html__('Adults', 'eagle-booking'). ', ' .$eb_children.' '.esc_html__('Children', 'eagle-booking') ?>
                <?php else : ?>
                  <?php echo $eb_guests ?>
                <?php endif ?>
            </strong>
            </span>
          </div>

          <div id="eb_services_info" class="title" style="display: none"> <?php echo __('Additional Services', 'eagle-booking') ?> </div>

          <?php if ( eb_get_option('show_price') == true ) : ?>
            <div class="eb-price-summary">
              <div class="title"><?php echo __('Price Summary', 'eagle-booking') ?></div>

                <div class="item room">
                  <span class="desc"><a href="<?php echo esc_url($eagle_booking_selected_room_url) ?>" target="_blank"><?php echo get_the_title($eb_room_id) ?></a></span>
                  <span class="value">
                    <strong>
                      <?php if ( eb_currency_position() == 'before' ) : ?>
                      <?php echo eb_currency() ?><?php eb_formatted_price($eb_room_total_price) ?>
                      <?php else : ?>
                      <?php eb_formatted_price($eb_room_total_price) ?><?php echo eb_currency() ?>
                      <?php endif ?>
                    </strong>
                  </span>
                </div>

              <?php include eb_load_template('booking/taxesfees.php');  ?>

            </div>
          <?php endif ?>

        <?php if ( eb_get_option('show_price') == true ) : ?>
        <div id="eb_total_price_text" class="item total-price">
          <span class="desc"><strong><?php echo esc_html__('Total Price', 'eagle-booking') ?></strong></span>
          <span class="value">

            <strong><?php echo eb_price( eb_total_price($eb_room_id, $eb_room_total_price, $eb_booking_nights, $eb_guests, true) ); ?></strong>

          </span>
        </div>
        <?php endif ?>

      </div>
      <button id="submit_booking_form" class="btn eb-btn mt10" type="submit">
          <span class="eb-btn-text"><?php echo __('Proceed to Checkout','eagle-booking') ?></span>
      </button>

    </div>

    </div>
  </div>
</div>
