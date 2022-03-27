<?php if ( eb_get_option('eagle_booking_payment_method')['flutterwave'] ) : ?>
<div id="eagle_booking_checkout_payment_flutterwave_tab">

  <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('flutterwave_mssg')) ?></p>

  <form accept-charset="UTF-8" action="<?php echo eb_checkout_page() ?>" id="flutterwave" method="POST">

      <!-- Booking Details -->
      <input type="hidden" name="eagle_booking_payment_method" value="flutterwave">
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
      <input type="hidden" name="eagle_booking_form_action_type" value="flutterwave">
      <input type="hidden" name="eagle_booking_form_payment_status" value="Completed">

      <input type="hidden" id="tx_ref" name="tx_ref">
      <input type="hidden" id="transaction_id" name="transaction_id">

      <!-- Flutterwave Parameters -->
      <button class="btn eb-btn" type="button" onClick="makePayment()"><?php echo __('Checkout Now','eagle-booking') ?></button>

  </form>

  <script src="https://checkout.flutterwave.com/v3.js"></script>
  <script>

      function makePayment() {

          FlutterwaveCheckout({

            public_key: "<?php echo eb_get_option('flutterwave_public_key') ?>",
            tx_ref: "eb-<?php echo rand( )?>",
            amount: "<?php echo $eagle_booking_deposit_amount ?>",
            currency: "<?php echo eb_get_option('flutterwave_currency')?>",
            customer: {
              email: "<?php echo $eagle_booking_form_email ?>",
              phone_number: "<?php echo $eagle_booking_form_phone ?>",
              name: "<?php echo $eagle_booking_form_name.' '.$eagle_booking_form_surname ?>",
            },

            callback: function (data) {

              jQuery('#tx_ref').val(data.tx_ref);
              jQuery('#transaction_id').val(data.transaction_id);

              // Form Submit
              jQuery('#flutterwave').submit();

            },

            // close modal
            onclose: function() {

            },

            customizations: {
              title: "<?php echo get_bloginfo( 'name' ); ?>",
              description: "<?php __('Payment for Booking', 'eagle-booking') ?>",
              logo: "<?php echo eb_get_option( 'hotel_logo' ); ?>",
            },
          });
        }

  </script>

</div>
<?php endif ?>
