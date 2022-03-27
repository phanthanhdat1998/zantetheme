<?php if ( eb_get_option('eagle_booking_payment_method')['paystack'] ) : ?>
<div id="eagle_booking_checkout_payment_paystack_tab">

  <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('paystack_mssg')) ?></p>

  <form accept-charset="UTF-8" action="<?php echo eb_checkout_page() ?>" id="paystack" method="POST">

      <!-- Booking Details -->
      <input type="hidden" name="eagle_booking_payment_method" value="paystack">
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
      <input type="hidden" name="eagle_booking_form_action_type" value="paystack">
      <input type="hidden" name="eagle_booking_form_payment_status" value="Completed">

      <!-- Paystack Parameters -->
      <input type="hidden" id="email-address" value="<?php echo $eagle_booking_form_email ?>" />
      <input type="hidden" id="amount" value="<?php echo $eagle_booking_deposit_amount ?>" />
      <button id="card-button" class="btn eb-btn" type="submit" onclick="payWithPaystack(event)"><?php echo __('Checkout Now','eagle-booking') ?></button>

  </form>

  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script>

    var Form = document.getElementById('paystack');
    Form.addEventListener('submit', payWithPaystack, false);
    function payWithPaystack(event) {

        event.preventDefault();

        let handler = PaystackPop.setup({
          key: '<?php echo eb_get_option('paystack_public_key') ?>',
          email: document.getElementById("email-address").value,
          amount: document.getElementById("amount").value * 100,
          currency: '<?php echo eb_get_option('paystack_currency') ?>',
          onClose: function(){
          },
          callback: function(response){

            //Create Token
            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "paystack_reference");
            hiddenInput.setAttribute("value",  response.reference);
            Form.appendChild(hiddenInput);

            // Submit Form
            Form.submit();

          }
        });

        handler.openIframe();
      }

  </script>

</div>
<?php endif ?>
