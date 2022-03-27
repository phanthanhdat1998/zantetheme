<?php if ( eb_get_option('eagle_booking_payment_method')['2checkout'] ) : ?>
<div id="eagle_booking_checkout_payment_2checkout_tab">
  <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('eagle_booking_2checkout_mssg')) ?></p>

  <?php eb_get_option('eagle_booking_2checkout_sandbox_mode') == true ? $eb_demo_mode = 'Y' :  $eb_demo_mode = ''; ?>

  <form accept-charset="UTF-8" action="https://www.2checkout.com/checkout/purchase" id="2checkout" method="post">

      <!-- Booking Details -->
      <input type="hidden" name="eagle_booking_payment_method" value="2checkout">
      <input type="hidden" name="eagle_booking_checkout_form_date_from" value="<?php echo $eagle_booking_form_date_from ?>">
      <input type="hidden" name="eagle_booking_checkout_form_date_to" value="<?php echo $eagle_booking_form_date_to ?>">
      <input type="hidden" name="eagle_booking_checkout_form_guests" value="<?php echo $eagle_booking_form_guests ?>">
      <input type="hidden" name="eagle_booking_checkout_form_adults" value="<?php echo $eagle_booking_form_adults ?>">
      <input type="hidden" name="eagle_booking_checkout_form_children" value="<?php echo $eagle_booking_form_children ?>">

      <input type="hidden" name="eb_room_price" value="<?php echo $eb_room_price ?>">

      <input type="hidden" name="eagle_booking_checkout_form_final_price" value="<?php echo $eagle_booking_form_final_price ?>">
      <input type="hidden" name="eagle_booking_deposit_amount" value="<?php echo $eagle_booking_deposit_amount ?>">
      <input type="hidden" name="eagle_booking_room_id" value="<?php echo $eagle_booking_room_id ?>">
      <input type="hidden" name="eagle_booking_room_title" value="<?php echo $eagle_booking_room_title ?>">
      <input type="hidden" name="eagle_booking_checkout_form_name" value="<?php echo $eagle_booking_form_name ?>">
      <input type="hidden" name="eagle_booking_checkout_form_surname" value="<?php echo $eagle_booking_form_surname ?>">
      <input type="hidden" name="eagle_booking_checkout_form_email" value="<?php echo $eagle_booking_form_email ?>">
      <input type="hidden" name="eagle_booking_checkout_form_phone" value="<?php echo $eagle_booking_form_phone ?>">
      <input type="hidden" name="eagle_booking_checkout_form_address" value="<?php echo $eagle_booking_form_address ?>">
      <input type="hidden" name="eagle_booking_checkout_form_city" value="<?php echo $eagle_booking_form_city ?>">
      <input type="hidden" name="eagle_booking_checkout_form_country" value="<?php echo $eagle_booking_form_country ?>">
      <input type="hidden" name="eagle_booking_checkout_form_zip" value="<?php echo $eagle_booking_form_zip ?>">
      <input type="hidden" name="eagle_booking_checkout_form_requets" value="<?php echo $eagle_booking_form_requests ?>">
      <input type="hidden" name="eagle_booking_checkout_form_arrival" value="<?php echo $eagle_booking_form_arrival ?>">
      <input type="hidden" name="eagle_booking_form_services" value="<?php echo $eagle_booking_form_services ?>">
      <input type="hidden" name="eagle_booking_form_coupon" value="<?php echo $eagle_booking_form_coupon ?>">
      <input type="hidden" name="eagle_booking_form_action_type" value="2checkout">
      <input type="hidden" name="eagle_booking_form_payment_status" value="Pending Payment">

      <!-- 2Checkout Parameters -->
      <input id="sid" name="sid" type="hidden" value="<?php echo esc_html(eb_get_option('eagle_booking_2checkout_account_number')) ?>" />
      <input type='hidden' name='demo' value='<?php echo $eb_demo_mode ?>' />
      <input id="mode" name="mode" type="hidden" value="2CO" />
      <input id="merchant_order_id" name="merchant_order_id" type="hidden" value="<?php echo $eagle_booking_room_id ?>" />
      <input id="li_0_product_id" name="li_0_product_id" type="hidden" value="<?php echo $eagle_booking_room_id ?>" />
      <input id="li_0_name" name="li_0_name" type="hidden" value="<?php echo $eagle_booking_room_title ?>" />
      <input id="li_0_price" name="li_0_price" type="hidden" value="<?php echo $eagle_booking_deposit_amount ?>" />
      <input type='hidden' name='currency_code' value='<?php echo esc_html( eb_get_option('eagle_booking_2checkout_currency') ) ?>' >
      <input id="card_holder_name" name="card_holder_name" type="hidden" value="<?php echo $eagle_booking_form_name .' '.$eagle_booking_form_surname ?>" />
      <input id="street_address" name="street_address" type="hidden" value="<?php echo $eagle_booking_form_address ?>" />
      <input id="city" name="city" type="hidden" value="<?php echo $eagle_booking_form_city ?>" />
      <input id="zip" name="zip" type="hidden" value="<?php echo $eagle_booking_form_zip ?>" />
      <input id="country" name="country" type="hidden" value="<?php echo $eagle_booking_form_country ?>" />
      <input id="email" name="email" type="hidden" value="<?php echo $eagle_booking_form_email ?>" />
      <input id="phone" name="phone" type="hidden" value="<?php echo $eagle_booking_form_phone ?>" />
      <input type='hidden' name='x_receipt_link_url' value='<?php echo esc_url( eb_checkout_page() ) ?>' />
      <button type="submit" class="btn eb-btn btn-2checkout"><?php echo esc_html__('Checkout Now','eagle-booking') ?></button>
  </form>
  <script src="https://www.2checkout.com/static/checkout/javascript/direct.min.js"></script>
</div>
<?php endif ?>
