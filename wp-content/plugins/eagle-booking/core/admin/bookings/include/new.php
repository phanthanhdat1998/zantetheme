<?php

/* --------------------------------------------------------------------------
 * Add new booking (Admin)
 * Author: Eagle Themes
 * Since  1.0.0
 * Modified 1.2.9
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

?>

<div class="eb-wrapper eb-admin-page">

  <?php include EB_PATH.''."core/admin/bookings/elements/admin-header.php"; ?>
  <div class="eb-admin-title">
    <div>
      <h1 class="wp-heading-inline"><?php echo __('New Booking','eagle-booking') ?></h1>
    </div>
    <div class="eb-admin-new-booking">
        <a href="<?php echo admin_url( 'admin.php?page=eb_new_booking') ?>" class="eb-new-booking-btn"><?php echo __('Add New Booking','eagle-booking') ?></a>
    </div>
  </div>

  <form method="POST">
    <div class="eb-new-booking-page">
      <div class="eb-main-details">
        <input type="hidden" name="eb_new_booking_added" value="1">
        <div class="eb-form">
          <div class="form-group">
            <label><?php echo __('Room','eagle-booking') ?></label>
            <select id="eb_room_id">
              <?php
                $eagle_booking_rooms_args = array( 'posts_per_page' => -1, 'post_type'=> 'eagle_rooms', 'suppress_filters' => false );

                    $eagle_rooms = get_posts($eagle_booking_rooms_args);
                    $eagle_booking_dates = '';
                    $eagle_booking_guests = 2;
                    $eagle_booking_adults = 1;
                    $eagle_booking_children = 0;
                    $eagle_booking_checkin_param = 'eagle_booking_checkin';
                    $eagle_booking_checkout_param = 'eagle_booking_checkout';

                foreach ($eagle_rooms as $eagle_booking_room) : ?>

                    <option value="<?php echo $eagle_booking_room->ID; ?>">
                        <?php

                          if ( eb_room_has_branch( $eagle_booking_room->ID ) ) {

                            echo $eagle_booking_room->post_title.' - '.eb_room_branch( $eagle_booking_room->ID );

                          } else {

                            echo $eagle_booking_room->post_title;

                          }


                        ?>
                    </option>

                <?php endforeach; ?>

            </select>

          </div>
          <div class="form-group">
              <?php include EB_PATH . 'templates/elements/dates-picker.php' ?>
          </div>
          <div class="form-group">
            <?php include EB_PATH . 'templates/elements/guests-picker.php' ?>
          </div>
          <div class="form-group">
            <label><?php echo __('Name','eagle-booking') ?></label>
            <input id="eb_firstname" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Surname','eagle-booking') ?></label>
            <input id="eb_lastname" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Email','eagle-booking') ?></label>
            <input id="eb_email" type="email">
          </div>
          <div class="form-group">
            <label><?php echo __('Total Price','eagle-booking') ?></label>
            <input id="eb_price" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Deposit Amount','eagle-booking') ?></label>
            <input id="eb_deposit" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Phone','eagle-booking') ?></label>
            <input id="eb_phone" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Address','eagle-booking') ?></label>
            <input id="eb_address" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('City','eagle-booking') ?></label>
            <input id="eb_city" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('Country','eagle-booking') ?></label>
            <input id="eb_country" type="text">
          </div>
          <div class="form-group">
            <label><?php echo __('ZIP','eagle-booking') ?></label>
            <input id="eb_zip" type="text">
          </div>

          <!-- Arrival -->
          <div class="form-group">
            <label><?php echo __('Arrival','eagle-booking') ?></label>
            <select id="eb_arrival">
              <option><?php echo __('I do not know','eagle-booking'); ?></option>
              <option>12:00 - 1:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>1:00 - 2:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>2:00 - 3:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>3:00 - 4:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>4:00 - 5:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>5:00 - 6:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>6:00 - 7:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>7:00 - 8:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>8:00 - 9:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>9:00 - 10:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>10:00 - 11:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>11:00 - 12:00 <?php echo __('am','eagle-booking'); ?></option>
              <option>12:00 - 1:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>1:00 - 2:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>2:00 - 3:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>3:00 - 4:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>4:00 - 5:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>5:00 - 6:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>6:00 - 7:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>7:00 - 8:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>8:00 - 9:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>9:00 - 10:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>10:00 - 11:00 <?php echo __('pm','eagle-booking'); ?></option>
              <option>11:00 - 12:00 <?php echo __('pm','eagle-booking'); ?></option>
            </select>
          </div>

          <div class="form-group">
            <label><?php echo __('Requests','eagle-booking') ?></label>
            <textarea id="eb_requests"></textarea>
          </div>

          </div>

          <div class="form-group" style="margin-top: 30px;">
            <label><?php echo __('Additional Services','eagle-booking') ?> :</label>
              <?php
                $eagle_booking_services_args = array( 'posts_per_page' => -1, 'post_type'=> 'eagle_services', 'suppress_filters' => false );
                $eagle_booking_services = get_posts($eagle_booking_services_args);
              ?>
              <?php foreach ($eagle_booking_services as $eagle_booking_service) : ?>
                <?php
                  $eagle_booking_service_type = get_post_meta( $eagle_booking_service->ID, 'eagle_booking_mtb_service_type', true );
                  if ( $eagle_booking_service_type == 'additional' ) :
                ?>
                  <div class="eb-new-booking-service">
                    <input id="<?php echo $eagle_booking_service->ID; ?>" class="eb-additional-service" type="checkbox" value="<?php echo $eagle_booking_service->ID; ?><?php echo '[0]' ?>, ">
                    <label for="<?php echo $eagle_booking_service->ID; ?>"><?php echo $eagle_booking_service->post_title; ?></label>
                  </div>
              <?php endif ?>
              <?php endforeach; ?>
              <input type="hidden" id="eb_services">
          </div>

        </div>

        <div class="eb-booking-details">
          <div class="inner">
            <div class="booking-details-form">

                <label><?php echo __('Status','eagle-booking') ?></label>
                <select id="eb_status">
                  <option value="Pending Payment"><?php echo __('Pending Payment','eagle-booking'); ?></option>
                  <option value="Pending"><?php echo __('Pending','eagle-booking'); ?></option>
                  <option value="Completed"><?php echo __('Completed','eagle-booking'); ?></option>
                </select>

                <label><?php echo __('Payment Method','eagle-booking') ?></label>
                <select id="eb_payment_method">
                  <option value="bank_transfer"><?php echo __('Bank Transfer','eagle-booking'); ?></option>
                  <option value="payment_on_arrive"><?php echo __('Payment on Arrival','eagle-booking'); ?></option>
                  <option value="booking_request"><?php echo __('Booking Request','eagle-booking'); ?></option>
                  <option value="paypal"><?php echo __('Paypal','eagle-booking'); ?></option>
                  <option value="stripe"><?php echo __('Stripe','eagle-booking'); ?></option>
                  <option value="PayU"><?php echo __('PayU','eagle-booking'); ?></option>
                  <option value="paystack"><?php echo __('Paystack','eagle-booking'); ?></option>
                  <option value="razorpay"><?php echo __('Razorpay','eagle-booking'); ?></option>
                </select>

              </div>

              <div class="status-button" style="display: block">

                <button id="eb_check_availability" class="btn" value="true">
                  <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking'); ?></span>
                </button>

              </div>

        </div>

        <p class="eb-admin-warning"> <?php echo __('Please note: min/max guests number and min/max booking nights restrictions are not taken into consideration on the admin submission. The cost of the additional services is included in the total price.', 'eagle-booking') ?> </p>

      </div>
    </div>
  </form>
</div>

<!-- Popup -->
<div class="eb-popup">
   <div class="eb-popup-inner">
      <span class="eb-close-popup"><i class="fas fa-times"></i></span>
      <h3 id="eb_popup_heading" class="title"></h3>
      <p id="eb_popup_text"></p>
      <button class="btn btn-create" id="eb_create_booking_confirmation">
        <span class="eb-btn-text"><?php echo __('Yes, submit new booking', 'eagle-booking') ?></span>
     </button>
   </div>
</div>