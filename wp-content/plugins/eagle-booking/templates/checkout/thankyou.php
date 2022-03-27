<?php
   /**
    * The Template for the thank you page
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/checkout/thankyou.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.7
    */

   defined('ABSPATH') || exit;

  /**
  * Include Stepline
  */
  if ( eb_get_option('eb_stepline' ) == true ) include eb_load_template('elements/stepline.php');

?>

<div id="thankyou-page" class="thankyou-page">

    <div class="eb-alert eb-alert-success eb-alert-icon mb50" role="alert"> <?php echo __('Your booking has been submitted successfully.', 'eagle-booking') ?>
      <?php if (eb_get_option('eagle_booking_message')['email_guest'] == true) : ?>
        <?php echo __('We just sent you a confirmation email to', 'eagle-booking') ?>
       <?php echo $eagle_booking_form_email ?>
      <?php endif ?>
    </div>

    <div class="eb-printable eb-thank-details">

       <div class="eb-hotel-logo eb-only-printable">
          <?php
          if (!empty( eb_get_option('hotel_logo') )) {
              echo "<img src=".eb_get_option('hotel_logo')." height='20px'>";
          } else {
              echo get_bloginfo( 'name' );
          }
          ?>
      </div>

      <h4 class="title"><?php echo __('Booking Details', 'eagle-booking') ?></h4>
      <ul>

        <li>
          <span><?php echo __('Transaction ID', 'eagle-booking') ?></span>
          <strong><?php echo $eagle_booking_transaction_id ?></strong>
        </l1>

        <li>
          <span><?php echo __('Full Name', 'eagle-booking') ?></span>
          <strong><?php echo $eagle_booking_form_name .' '.$eagle_booking_form_surname ?></strong>
        </li>

        <li>
          <span><?php echo __('Email', 'eagle-booking') ?></span>
          <strong><?php echo $eagle_booking_form_email ?></strong>
        </li>

        <li>
          <span><?php echo __('Phone', 'eagle-booking') ?></span>
          <strong><?php echo $eagle_booking_form_phone ?></strong>
        </li>

        <?php if ( !empty( $eagle_booking_form_address.$eagle_booking_form_zip.$eagle_booking_form_city.$eagle_booking_form_country ) ) : ?>

        <li>
            <span><?php echo __('Address', 'eagle-booking') ?></span>
            <strong> <?php echo $eagle_booking_form_address . ', ' .$eagle_booking_form_zip . ', ' .$eagle_booking_form_city . ', ' . $eagle_booking_form_country ?> </strong>
        </li>

        <?php endif ?>

        <li>
            <span><?php echo __('Room', 'eagle-booking') ?></span>
            <strong><?php echo $eagle_booking_room_title ?></strong>
        </li>

        <?php if ( eb_room_branch( $eagle_booking_room_id ) ) : ?>
        <li>
            <span><?php echo __('Branch','eagle-booking') ?></span>
            <strong><?php echo eb_room_branch( $eagle_booking_room_id )  ?></strong>
        </li>
        <?php endif ?>

        <li>
            <span><?php echo __('Check In/Out', 'eagle-booking') ?></span>
            <strong><?php echo eagle_booking_displayd_date_format($eagle_booking_form_date_from) ?><?php eb_checkin_checkout_time('checkin') ?> &nbsp; → &nbsp; <?php echo eagle_booking_displayd_date_format($eagle_booking_form_date_to) ?><?php eb_checkin_checkout_time('checkout') ?></strong>
        </li>

        <li>
            <span><?php echo __('Guests','eagle-booking') ?></span>
            <strong>
            <?php if ( eb_get_option('eb_adults_children') == true ) : ?>
              <?php echo $eagle_booking_form_adults . ' ' .__('Adults', 'eagle-booking'). ', ' . $eagle_booking_form_children . ' ' .__('Children', 'eagle-booking') ?>
            <?php else : ?>
              <?php echo $eagle_booking_form_guests ?>
            <?php endif ?>
            </strong>
        </li>

        <?php if ( !empty($eagle_booking_form_arrival)) : ?>
        <li>
            <span><?php echo __('Arrival', 'eagle-booking') ?></span>
            <strong><?php echo $eagle_booking_form_arrival ?></strong>
        </li>
        <?php endif ?>

        <li>
          <span><?php echo __('Payment', 'eagle-booking') ?></span>
          <strong><?php echo $eagle_booking_checkout_payment_type ?></strong>
        </li>

        <?php if (!empty($eagle_booking_form_services)) : ?>
        <li>
            <span><?php echo __('Additional Services', 'eagle-booking') ?></span>
            <strong>
              <?php
                  $eagle_booking_services_array = explode(',', $eagle_booking_form_services);
                  for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array)-1; $eagle_booking_services_array_i++) :

                    $eagle_booking_service_id = $eagle_booking_services_array[$eagle_booking_services_array_i];
                    $eagle_booking_service_name = get_the_title($eagle_booking_service_id);

                    echo $eagle_booking_service_name;
                    if (next($eagle_booking_services_array)) :
                        echo ', ';
                    endif;

                  endfor;
                ?>
              </strong>
          </li>
        <?php endif ?>

        <?php if (!empty($eagle_booking_form_requests)) : ?>
        <li>
            <span><?php echo __('Requests', 'eagle-booking') ?></span>
            <strong><?php echo $eagle_booking_form_requests ?></strong>
        </li>

        <?php endif ?>

        <?php if ( eb_get_option('show_price') == true ) : ?>
        <li>
            <span><?php echo __('Total Price', 'eagle-booking') ?></span>
            <strong>
              <?php if (eb_currency_position() == 'before') : ?>
              <?php echo eb_currency()?><?php eb_formatted_price($eagle_booking_form_final_price) ?>
              <?php else : ?>
              <?php eb_formatted_price($eagle_booking_form_final_price) ?><?php echo eb_currency()?>
              <?php endif ?>
            </strong>
          </li>
        <?php endif ?>

        <?php if ( eb_get_option('eagle_booking_deposit_amount') < 100 ) : ?>
        <li>
            <span><?php echo __('Deposit Amount','eagle-booking') ?></span>
            <strong>
              <?php if ( eb_currency_position() == 'before' ) : ?>
              <?php echo eb_currency()?><?php eb_formatted_price($eagle_booking_deposit_amount) ?>
              <?php else : ?>
              <?php eb_formatted_price($eagle_booking_deposit_amount) ?><?php echo eb_currency()?>
              <?php endif ?>
            </strong>
        </li>
        <?php endif ?>

      </ul>

  </div>

  <div class="thankyou-buttons">
      <?php if ( is_user_logged_in() ) : ?>
      <a href="<?php echo eb_account_page() ?>"  class="btn eb-btn btn-light"><?php echo __('Manage Your Bookings', 'eagle-booking') ?></a>
      <?php endif ?>
      <a class="btn eb-btn btn-light print-booking-details" onClick="window.print()"><?php echo __('Print Booking Details', 'eagle-booking') ?></a>
  </div>

</div>
