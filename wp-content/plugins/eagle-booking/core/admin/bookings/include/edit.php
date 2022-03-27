<?php
/* --------------------------------------------------------------------------
 * Edit Booking
 * @ since  1.0.0
 * @ modified 1.3.3
 ---------------------------------------------------------------------------*/
if ( isset($_GET["id"]) && $_GET['id'] != '' ) {

    $eagle_booking_booking_id = $_GET['id'];

    global $wpdb;

    $eagle_booking_table_name = $wpdb->prefix . 'eagle_booking';
    $eb_table_meta_name = $wpdb->prefix . 'eagle_booking_meta';
    $eagle_booking_booking_update = 0;

    // UPDATE BOOKING
    if (isset($_POST['eagle_booking_booking_id'])) {
        $eagle_booking_booking_id = sanitize_text_field($_POST['eagle_booking_booking_id']);
        $eagle_booking_checkin = sanitize_text_field($_POST['eagle_booking_booking_date_from']);
        $eagle_booking_checkout = sanitize_text_field($_POST['eagle_booking_booking_date_to']);

        // Guests
        if (eb_get_option('eb_adults_children') == true) {
            $eagle_booking_adults = sanitize_text_field($_POST['eagle_booking_booking_adults']);
            $eagle_booking_children = sanitize_text_field($_POST['eagle_booking_booking_children']);
            $eagle_booking_guests = $eagle_booking_adults + $eagle_booking_children;
        } else {
            $eagle_booking_adults = 0;
            $eagle_booking_children = 0;
            $eagle_booking_guests = sanitize_text_field($_POST['eagle_booking_booking_guests']);
        }

        // Deposit Amount
        if (eb_get_option('eagle_booking_deposit_amount') < 100) {
            $eb_deposit_amount = sanitize_text_field($_POST['eagle_booking_deposit_amount']);
        } else {
            $eb_deposit_amount = sanitize_text_field($_POST['eagle_booking_booking_final_trip_price']);
        }

        $eagle_booking_edit_booking = $wpdb->update(
            $eagle_booking_table_name,
            array(
              'id' => sanitize_text_field($_POST['eagle_booking_booking_id']),
              'id_post' => sanitize_text_field($_POST['eagle_booking_booking_id_post']),
              'title_post' => sanitize_text_field($_POST['eagle_booking_booking_title_post']),
              'date' => sanitize_text_field($_POST['eagle_booking_booking_date']),
              'date_from' => eagle_booking_system_date_format($eagle_booking_checkin),
              'date_to' => eagle_booking_system_date_format($eagle_booking_checkout),
              'guests' => $eagle_booking_guests,
              'adults' => $eagle_booking_adults,
              'children' => $eagle_booking_children,
              'final_trip_price' => sanitize_text_field($_POST['eagle_booking_booking_final_trip_price']),
              'extra_services' => sanitize_text_field($_POST['eagle_booking_booking_extra_services']),
              'id_user' => sanitize_text_field($_POST['eagle_booking_booking_id_user']),
              'user_ip' => sanitize_text_field($_POST['eb_user_ip']),
              'user_first_name' => sanitize_text_field($_POST['eagle_booking_booking_user_first_name']),
              'user_last_name' => sanitize_text_field($_POST['eagle_booking_booking_user_last_name']),
              'paypal_email' => sanitize_text_field($_POST['eagle_booking_booking_paypal_email']),
              'user_phone' => sanitize_text_field($_POST['eagle_booking_booking_user_phone']),
              'user_address' => sanitize_text_field($_POST['eagle_booking_booking_user_address']),
              'user_city' => sanitize_text_field($_POST['eagle_booking_booking_user_city']),
              'user_country' => sanitize_text_field($_POST['eagle_booking_booking_user_country']),
              'deposit_amount' => $eb_deposit_amount,
              'user_message' => sanitize_text_field($_POST['eagle_booking_booking_user_message']),
              'user_arrival' => sanitize_text_field($_POST['eagle_booking_booking_user_arrival']),
              'user_coupon' => sanitize_text_field($_POST['eagle_booking_booking_user_coupon']),
              'paypal_payment_status' => sanitize_text_field($_POST['eagle_booking_booking_paypal_payment_status']),
              'paypal_currency' => sanitize_text_field($_POST['eagle_booking_booking_paypal_currency']),
              'paypal_tx' => sanitize_text_field($_POST['eagle_booking_booking_paypal_tx']),
              'action_type' => sanitize_text_field($_POST['eagle_booking_booking_action_type']),
            ),
            array( 'ID' => sanitize_text_field($_POST['eagle_booking_booking_id']) )
        );

        $eagle_booking_booking_update = 1;
    }

    // SELECT BOOKINGS
    $bookings = $wpdb->get_results("SELECT * FROM $eagle_booking_table_name WHERE id = $eagle_booking_booking_id");

    if (empty($bookings)) : ?>

    <p><?php echo __('There was a DB error', 'eagle-booking') ?></p>

    <?php else :

  foreach ($bookings as $booking) :

    $eagle_booking_id = $booking->id_post;
    $eagle_booking_image_id = get_post_thumbnail_id($eagle_booking_id);
    $eagle_booking_image_attributes = wp_get_attachment_image_src($eagle_booking_image_id, 'thumbnail');
    $eagle_booking_room_img_src = $eagle_booking_image_attributes[0];

    $eb_user_id = $booking->id_user;
    if ($eb_user_id) {
        $eb_user_name = get_user_by('id', $eb_user_id)->user_login;
    }


    // Get the payment method text
    if ($booking->action_type === 'payment_on_arrive') {
        $eb_new_action_type_text = __('Payment on Arrival', 'eagle-booking');
    } elseif ($booking->action_type === '2checkout') {
        $eb_new_action_type_text = __('2Checkout', 'eagle-booking');
    } elseif ($booking->action_type === 'bank_transfer') {
        $eb_new_action_type_text = __('Bank Transfer', 'eagle-booking');
    } elseif ($booking->action_type === 'PayU') {
        $eb_new_action_type_text = __('PayU', 'eagle-booking');
    } elseif ($booking->action_type === 'paystack') {
        $eb_new_action_type_text = __('Paystack', 'eagle-booking');
    } elseif ($booking->action_type === 'flutterwave') {
        $eb_new_action_type_text = __('Flutterwave', 'eagle-booking');
    } elseif ($booking->action_type === 'vivawallet') {
        $eb_new_action_type_text = __('Viva Wallet', 'eagle-booking');
    } elseif ($booking->action_type === 'razorpay') {
        $eb_new_action_type_text = __('Razorpay', 'eagle-booking');
    } elseif ($booking->action_type === 'booking_request') {
        $eb_new_action_type_text = __('Booking Request', 'eagle-booking');
    } elseif ($booking->action_type === 'stripe') {
        $eb_new_action_type_text = __('Stripe', 'eagle-booking');
    } elseif ($booking->action_type === 'paypal') {
        $eb_new_action_type_text = __('PayPal', 'eagle-booking');
    } ?>

 <div class="eb-wrapper eb-admin-page eb-admin-booking-details">

    <?php

    // Print Logo - too be removed
    $eb_hotel_logo = eb_get_option('hotel_logo'); ?>

    <div class="hotel-logo-print">
      <?php
      if (!empty($eb_hotel_logo)) {
          echo "<img src=".$eb_hotel_logo." height='25px'>";
      } else {
          echo get_bloginfo('name');
      } ?>

    </div>

    <?php include EB_PATH.''."core/admin/bookings/elements/admin-header.php"; ?>

    <div class="eb-admin-title">

        <div>
         <h1 class="wp-heading-inline"><?php echo __('Edit Booking', 'eagle-booking').' #'.$eagle_booking_booking_id ?></h1>
        </div>

        <div class="eb-admin-new-booking">
          <a href="<?php echo admin_url('admin.php?page=eb_new_booking') ?>" class="eb-new-booking-btn"><?php echo __('Add New Booking', 'eagle-booking') ?></a>
        </div>

    </div>

    <form method="POST">
        <div class="eb-booking-details-page">

          <div class="eb-main-details">

            <?php
              if ($eagle_booking_booking_update == 1) { ?>
                  <div class="update-mssg success" style="margin-bottom: 40px">
                    <p>
                      <strong><?php echo __('Booking Updated Successfully', 'eagle-booking') ?></strong>
                    </p>
                    <button type="button" class="notice-dismiss">
                      <span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'eagle-booking') ?></span>
                    </button>
                  </div>

              <?php

            } else {

              //  $wpdb->show_errors();
              //  $wpdb->print_error();

            } ?>

              <input readonly name="eagle_booking_booking_id" style="display: none;" type="text" value="<?php echo $booking->id ?>">
              <input readonly name="eagle_booking_booking_id_post" style="display: none;" type="text" value="<?php echo $booking->id_post ?>">
              <input readonly name="eagle_booking_booking_title_post" style="display: none;" type="text" value="<?php echo $booking->title_post ?>">

              <div class="eb-form">

                  <input readonly name="eagle_booking_booking_date"  type="hidden" value="<?php echo $booking->date ?>">

                  <div class="form-group">
                    <label><?php echo __('Check In', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_date_from" type="text" value="<?php echo eagle_booking_displayd_date_format($booking->date_from) ?>">
                  </div>

                  <div class="form-group">
                    <label><?php echo __('Check Out', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_date_to" type="text" value="<?php echo eagle_booking_displayd_date_format($booking->date_to) ?>">
                  </div>

                  <?php if (eb_get_option('eb_adults_children') == false) : ?>
                    <div class="form-group">
                      <label><?php echo __('Guests', 'eagle-booking') ?></label>
                      <input name="eagle_booking_booking_guests" type="text" value="<?php echo $booking->guests ?>">
                    </div>
                  <?php else : ?>

                    <div class="form-group">
                      <label><?php echo __('Adults', 'eagle-booking') ?></label>
                      <input name="eagle_booking_booking_adults" type="text" value="<?php echo $booking->adults ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __('Children', 'eagle-booking') ?></label>
                      <input name="eagle_booking_booking_children" type="text" value="<?php echo $booking->children ?>">
                    </div>
                  <?php endif ?>

                  <div class="form-group">
                    <label><?php echo __('Arrival', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_arrival" type="text" value="<?php echo $booking->user_arrival ?>">
                  </div>

                  <input readonly name="eagle_booking_booking_id_user"style="display: none;" type="text" value="<?php echo $booking->id_user ?>">
                  <div class="form-group">
                    <label><?php echo __('Name', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_first_name" type="text" value="<?php echo $booking->user_first_name ?>">
                  </div>
                  <div class="form-group">
                    <label><?php echo __('Surname', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_last_name"  type="text" value="<?php echo $booking->user_last_name ?>">
                  </div>
                  <div class="form-group">
                    <label><?php echo __('Email', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_paypal_email" type="text" value="<?php echo $booking->paypal_email ?>">
                  </div>
                  <div class="form-group">
                    <label><?php echo __('Phone', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_phone" type="text" value="<?php echo $booking->user_phone ?>">
                  </div>
                  <div class="form-group">
                    <label><?php echo __('Address', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_address" type="text" value="<?php echo $booking->user_address ?>">
                  </div>
                  <div class="form-group">
                    <label><?php echo __('City', 'eagle-booking') ?></label>
                    <input name="eagle_booking_booking_user_city" type="text" value="<?php echo $booking->user_city ?>">
                  </div>

                <div class="form-group">
                  <label><?php echo __('Country', 'eagle-booking') ?></label>
                  <input name="eagle_booking_booking_user_country" type="text" value="<?php echo $booking->user_country ?>">
                </div>

                <?php if (eb_get_option('eagle_booking_deposit_amount') < 100) : ?>
                <div class="form-group">
                  <label><?php echo __('Deposit Amount', 'eagle-booking') ?></label>
                  <input name="eagle_booking_deposit_amount" type="text" value="<?php echo $booking->deposit_amount ?>">
                </div>
                <?php endif ?>

                <div class="customer-comments" style="clear: both;">
                  <div class="form-group">
                    <label><?php echo __('Requests', 'eagle-booking') ?></label>
                    <textarea style="width: 100%; min-height: 80px;" name="eagle_booking_booking_user_message"><?php echo $booking->user_message ?></textarea>
                  </div>
                </div>

              </div>

            <div class="booking-price">
                <input name="eagle_booking_booking_final_trip_price" type="hidden" value="<?php echo $booking->final_trip_price ?>">
                <input name="eagle_booking_booking_paypal_currency" type="hidden" value="<?php echo $booking->paypal_currency ?>">
                <input name="eagle_booking_booking_extra_services" type="hidden" value="<?php echo $booking->extra_services ?>">

                <table width="100%">
                  <thead>
                    <th style="width:95%;"><?php echo __('Description', 'eagle-booking') ?></th>
                    <th style="width:5%;"><?php echo __('Amount', 'eagle-booking') ?></th>
                  </thead>

                    <?php

                     /**
                     * Additional Service
                     */
                    $eagle_booking_services_array = explode(',', $booking->extra_services);

                    $eagle_booking_tot_services = 0;
                    $eb_services_total_price  = 0;

                    for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array)-1; $eagle_booking_services_array_i++) {

                      $eagle_booking_service_array = explode('[', $eagle_booking_services_array[$eagle_booking_services_array_i]);
                      $eagle_booking_service_id = $eagle_booking_service_array[0];
                      $eagle_booking_service_name = get_the_title($eagle_booking_service_id);
                      $eagle_booking_mtb_service_price_type_1 = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price_type_1', true);
                      $eagle_booking_mtb_service_price_type_2 = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price_type_2', true);

                      $eb_service_price = get_post_meta($eagle_booking_service_id, 'eagle_booking_mtb_service_price', true);

                      $eagle_booking_service_price = str_replace(']', '', $eagle_booking_service_array[1]);

                      if (empty($eagle_booking_service_price)) {
                          $eagle_booking_service_price = 10;
                      }

                      if ($eagle_booking_mtb_service_price_type_1 == 'guest') {
                          $eagle_booking_price_type_1 = $booking->guests;
                      } else {
                          $eagle_booking_price_type_1 = 1;
                      }
                      if ($eagle_booking_mtb_service_price_type_2 == 'night') {
                          $eagle_booking_price_type_2 = eb_total_booking_nights($booking->date_from, $booking->date_to);
                      } else {
                          $eagle_booking_price_type_2 = 1;
                      }

                      $eb_service_price = $eagle_booking_service_price / $eagle_booking_price_type_1 / $eagle_booking_price_type_2;

                      if (empty($eagle_booking_service_price_initial)) {
                          $eagle_booking_service_price_initial = 0;
                      }

                      ?>
                      <tr>
                        <td style="width:70%;">
                            <?php echo $eagle_booking_service_name ?>
                        </td>
                        <td style="width:10%;"><?php echo eb_price( $eagle_booking_service_price ) ?></td>
                      </tr>

                      <?php

                      $eb_services_total_price += $eagle_booking_tot_services + $eagle_booking_service_price;

                    }

                      /**
                       * Fees & Taxes
                       */
                      $fees = get_option('eb_fees');
                      $taxes = get_option('eb_taxes');
                      $booking_taxes = $wpdb->get_results("SELECT * FROM $eb_table_meta_name WHERE booking_id = $eagle_booking_booking_id AND meta_key = 'tax' ");
                      $booking_fees = $wpdb->get_results("SELECT * FROM $eb_table_meta_name WHERE booking_id = $eagle_booking_booking_id AND meta_key = 'fee' ");
                      $room_price = $wpdb->get_row( "SELECT * FROM $eb_table_meta_name WHERE booking_id = $eagle_booking_booking_id AND meta_key = 'room_price' " );

                      $room_price = $room_price->meta_value;

                      ?>

                      <tr>
                        <td><?php echo $booking->title_post ?></td>
                        <td><?php echo eb_price( $room_price ); ?></td>
                      </tr>

                      <?php



                      // echo '<pre>'; print_r($eb_fees); echo '</pre>';

                      if ( $booking_fees ) {

                        $html = '';

                        foreach( $booking_fees  as $key => $booking_fee ) {

                          foreach ( $fees  as $key => $item ) {

                            if ( $booking_fee->meta_value == $item['id'] ) {

                              $type = !empty( $item["type"] ) ? $item["type"] : '';

                              $amount = $item['amount'];

                              // Calculate the fee total
                              if ( $type === 'per_booking' ) {

                                $fee_amount = $amount;

                              } elseif ( $type === 'per_booking_nights' ) {

                                $fee_amount = $amount * eb_total_booking_nights($booking->date_from, $booking->date_to);

                              } elseif ( $type === 'per_booking_nights_guests' ) {

                                $fee_amount = $amount * $booking->guests * eb_total_booking_nights($booking->date_from, $booking->date_to);

                              } else {

                                $fee_amount = $amount * $booking->guests;

                              }

                              $html .= '<td>'.$item['title'].'</td>';
                              $html .= '<td>'.eb_price( $fee_amount ).'</td>';
                              $html .= "</tr>";

                            }

                          }

                          $html .= "<tr>";

                        }

                        echo $html;

                      }

                      if ( $booking_taxes ) {

                        $html = '';

                        foreach( $booking_taxes  as $key => $booking_tax ) {

                          foreach ( $taxes  as $key => $tax ) {

                            if ( $booking_tax->meta_value == $tax['id'] ) {


                              $services = !empty( $tax["services"] ) ? $tax["services"] : '';

                              // Check if the tax is applied on services
                              if ( $services == true ) {

                               $room_tax = round($tax['amount'] * $room_price / 100);
                               $services_tax = round( $tax['amount'] * $eb_services_total_price / 100 );

                               $tax_amount =  $room_tax + $services_tax;

                              } else {

                                $tax_amount = $tax['amount'] * $room_price / 100;

                              }

                              $html .= '<td>'.$tax['title'].'</td>';
                              $html .= '<td>'.eb_price( $tax_amount ).'</td>';
                              $html .= "</tr>";

                            }

                          }

                          $html .= "<tr>";

                        }

                        echo $html;

                      }

                  ?>

                </table>

                <div style="border-top:1px dashed #e3e3e3; margin-top: 10px">
                <table width="100%">
                  <tr>
                    <td style="width:95%;">
                      <h4><?php echo __('Total', 'eagle-booking') ?></h4>
                    </td>
                    <td style="width:5%;"><?php echo eb_price( $booking->final_trip_price ) ?></h4>
                    </td>
                  </tr>
                </table>

              </div>
            </div>
          </div>

        <div class="eb-booking-details">
          <div class="inner">
            <div class="booking-details-header">
              <div class="room-image">
                <img src="<?php echo $eagle_booking_room_img_src ?>">
              </div>
              <div class="room-title">
                <h2><?php echo $booking->title_post ?> <?php if ( eb_room_branch( $eagle_booking_id ) ) echo " - " ?><?php echo eb_room_branch( $eagle_booking_id ) ?></h2>
                <span><?php echo __('on', 'eagle-booking').' '.$booking->date ?> </span>
              </div>
            </div>

            <div class="booking-details-form">

              <?php if (!empty($booking->user_coupon)) : ?>
                <label><?php echo __('Coupon', 'eagle-booking') ?></label>
                <input readonly name="eagle_booking_booking_user_coupon" type="text" value="<?php echo $booking->user_coupon ?>">
              <?php else : ?>
                <input readonly name="eagle_booking_booking_user_coupon" type="hidden" value="<?php echo $booking->user_coupon ?>">
              <?php endif ?>

              <label><?php echo __('Transaction ID', 'eagle-booking') ?></label>
              <input readonly name="eagle_booking_booking_paypal_tx" type="text" value="<?php echo $booking->paypal_tx ?>">

              <label><?php echo __('Customer IP', 'eagle-booking') ?></label>
              <input readonly name="eb_user_ip" type="text" value="<?php echo $booking->user_ip ?>">

              <label><?php echo __('Payment Method', 'eagle-booking') ?></label>
              <input readonly type="text" value="<?php echo $eb_new_action_type_text ?>">
              <input name="eagle_booking_booking_action_type" type="hidden" value="<?php echo $booking->action_type ?>">

              <label><?php echo __('Status', 'eagle-booking') ?></label>
              <select name="eagle_booking_booking_paypal_payment_status">
                  <option <?php if ($booking->paypal_payment_status == 'Pending') echo 'selected="slected"' ?> value="Pending">
                    <?php echo __('Pending', 'eagle-booking') ?>
                  </option>
                  <option <?php if ($booking->paypal_payment_status == 'Pending Payment') echo 'selected="slected"' ?> value="Pending Payment">
                    <?php echo __('Pending Payment', 'eagle-booking') ?>
                  </option>
                  <option <?php if ($booking->paypal_payment_status == 'Completed') echo 'selected="slected"' ?> value="Completed">
                    <?php echo __('Completed', 'eagle-booking') ?>
                  </option>
                  <option <?php if ($booking->paypal_payment_status == 'Canceled') echo 'selected="slected"' ?> value="Canceled">
                    <?php echo __('Canceled', 'eagle-booking') ?>
                  </option>
              </select>
            </div>

            <div class="status-button">
              <button class="btn" type="submit"><?php echo __('Update Booking', 'eagle-booking') ?></button>
              <button class="btn btn-delete" id="eb_delete_booking"><i class="far fa-trash-alt"></i></button>
            </div>

          </div>

          <div class="room-buttons">
            <?php if ($eb_user_id != 0) : ?>
                <a href="<?php echo admin_url('user-edit.php?user_id=' . $eb_user_id); ?>" class="action-button">
                  <i class="fas fa-user"></i>
                  <?php echo __('User Profile', 'eagle-booking') ?>
                </a>
            <?php endif ?>
              <a href="mailto:<?php echo $booking->paypal_email ?>" class="action-button">
                <i class="far fa-envelope"></i>
                <?php echo __('Contact Customer', 'eagle-booking') ?>
              </a>
              <a onClick="window.print()" class="action-button">
                <i class="fa fa-print" aria-hidden="true"></i>
                <?php echo __('Print Booking Details', 'eagle-booking') ?>
              </a>
          </div>

        </div>
      </div>
    </form>
  </div>

  <div class="eb-popup">
    <div class="eb-popup-inner">
        <span class="eb-close-popup"><i class="fas fa-times"></i></span>
        <div class="eb-popup-icon failed">
          <i class="far fa-trash-alt"></i>
        </div>
        <h3 class="title"><?php echo __('Delete Booking', 'eagle-booking') ?> #<span id="eb_booking_id_text"><?php echo $eagle_booking_booking_id ?></span></h3>
        <p><?php echo __('This action cannot be undone. Are you sure you want to delete this booking?', 'eagle-booking') ?></p>
        <button class="btn btn-delete" id="eb_delete_booking_confirmation"  data-booking-id="<?php echo $eagle_booking_booking_id ?>">
          <span class="eb-btn-text"><?php echo __('Yes, delete this booking', 'eagle-booking') ?></span>
        </button>
    </div>
  </div>

<?php

endforeach;

  endif;

} else {
    echo "Please Select Booking";
}
