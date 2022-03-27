<?php if ( eb_get_option('eagle_booking_payment_method')['stripe'] && eb_get_option('eagle_booking_stripe_secret_key') != '' ) : ?>

<div id="eagle_booking_checkout_payment_stripe_tab">

  <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('eagle_booking_stripe_mssg')) ?></p>

  <?php
  // Stripe API
  require_once EB_PATH . '/core/admin/gateways/stripe/api/init.php';
  wp_enqueue_script('stripe', 'https://js.stripe.com/v3/');

  $eagle_booking_amount = $eagle_booking_deposit_amount*100;
  $eagle_booking_currency = eb_get_option('eagle_booking_stripe_currency');
  $eagle_booking_description = $eagle_booking_room_title.' - '.$eagle_booking_form_name.' '.$eagle_booking_form_surname.' - '.$eagle_booking_form_date_from.' - '.$eagle_booking_form_date_to;

  // Set payment intent
  \Stripe\Stripe::setApiKey( eb_get_option('eagle_booking_stripe_secret_key') );

  // Create the customer if options is enabled
  if ( eb_get_option( 'stripe_create_customer' ) == true ) {

      $customer = \Stripe\Customer::create([
      'email' => $eagle_booking_form_email,
      'name' => $eagle_booking_form_name.' '.$eagle_booking_form_surname,
      'phone' => $eagle_booking_form_phone,
      'address[line1]' => $eagle_booking_form_address,
      'address[city]' => $eagle_booking_form_city,
      'address[postal_code]' => $eagle_booking_form_zip,
      'address[state]' => $eagle_booking_form_country
    ]);
  }

  // Cretate the payment
  $intent = \Stripe\PaymentIntent::create([
    'customer' => $customer->id,
    'amount' => $eagle_booking_amount,
    'currency' => $eagle_booking_currency,
    'description' => $eagle_booking_description,
    'metadata[checkin]' => $eagle_booking_form_date_from,
    'metadata[checkout]' => $eagle_booking_form_date_to,
    'metadata[guests]' => $eagle_booking_form_guests,
    'metadata[name]' => $eagle_booking_form_name.' '.$eagle_booking_form_surname,
    'metadata[email]' => $eagle_booking_form_email,
    'metadata[phone]' => $eagle_booking_form_phone,
    'metadata[address]' => $eagle_booking_form_address.' '.$eagle_booking_form_city.' '.$eagle_booking_form_zip.' '.$eagle_booking_form_country,
    'metadata[requests]' => $eagle_booking_form_requests,
  ]);

  ?>

  <!-- Stripe Form -->
  <form action="<?php echo eb_checkout_page() ?>" method="POST" id="payment-form">
    <div class="form-row">
      <div id="card-element"></div>
      <div id="card-errors" role="alert"></div>
    </div>
    <input type="hidden" name="eagle_booking_payment_method" value="stripe">
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
    <input type="hidden" name="eagle_booking_form_action_type" value="stripe">
    <input type="hidden" name="eagle_booking_form_payment_status" value="Pending Payment">
    <button id="card-button" class="btn eb-btn btn-stripe" type="submit" data-secret="<?= $intent->client_secret ?>"><?php echo esc_html__('Checkout Now','eagle-booking') ?></button>
  </form>

  <script type="text/javascript">

    jQuery(function($){

      var stripe = Stripe("<?php echo eb_get_option('eagle_booking_stripe_public_key') ?>");
      var form = document.getElementById("payment-form");
      var elements = stripe.elements();
      var cardElement = elements.create('card');
      cardElement.mount('#card-element');
      var cardButton = document.getElementById('card-button');
      var clientSecret = cardButton.dataset.secret;

      cardButton.addEventListener('click', function(ev){

          // make the payment
          stripe.handleCardPayment(
            clientSecret, cardElement, {
              // payment_method_data: {
              // //	billing_details: {name: 'test'}
              // }
            }
          ).then(function(result) {

              if (result.error) {

                // Error
                var errorElement = document.getElementById("card-errors");
                errorElement.textContent = result.error.message;

              } else {

                // Create Token
                var hiddenInput = document.createElement("input");
                hiddenInput.setAttribute("type", "hidden");
                hiddenInput.setAttribute("name", "stripeToken");
                hiddenInput.setAttribute("value",  result.paymentIntent.id);
                form.appendChild(hiddenInput);

                // Submit Form
                form.submit();

              }
            });

      });

      // Prevent
      $(cardButton).on('click', function(){
        return false;
      });


    });
  </script>

</div>
<?php endif ?>
