<?php

// Include Razorpay API
require_once EB_PATH . '/core/admin/gateways/razorpay/api/razorpay.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if ( eb_get_option('eagle_booking_payment_method')['razorpay'] ) : ?>

  <div id="eagle_booking_checkout_payment_razorpay_tab">
  <p class="checkout-mssg"><?php echo do_shortcode( eb_get_option('razorpay_message') ) ?></p>

  <?php

  $razorpay_public_key = eb_get_option('razorpay_public_key');
  $razorpay_secret_key = eb_get_option('razorpay_secret_key');

  $paid_amount = $eagle_booking_deposit_amount * 100;

  $api = new Api($razorpay_public_key, $razorpay_secret_key);

  // Create Order to get razorpay_order_id
  $order = $api->order->create([
      'amount'          => $paid_amount,
      'currency'        => 'INR',
      'payment_capture' =>  '1'
    ]);

  ?>

  <form action="<?php echo eb_checkout_page() ?>" method="POST" id="razorpayform">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">

    <input type="hidden" name="eagle_booking_payment_method" value="razorpay">
    <input type="hidden" name="eb_checkout_form_date_from" value="<?php echo $eagle_booking_form_date_from ?>">
    <input type="hidden" name="eb_checkout_form_date_to" value="<?php echo $eagle_booking_form_date_to ?>">
    <input type="hidden" name="eb_checkout_form_guests" value="<?php echo $eagle_booking_form_guests ?>">
    <input type="hidden" name="eb_checkout_form_adults" value="<?php echo $eagle_booking_form_adults ?>">
    <input type="hidden" name="eb_checkout_form_children" value="<?php echo $eagle_booking_form_children ?>">

    <input type="hidden" name="eb_room_price" value="<?php echo $eb_room_price ?>">

    <input type="hidden" name="eb_checkout_form_final_price" value="<?php echo $eagle_booking_form_final_price ?>">
    <input type="hidden" name="eb_deposit_amount" value="<?php echo $eagle_booking_deposit_amount ?>">
    <input type="hidden" name="eb_room_id" value="<?php echo $eagle_booking_room_id ?>">
    <input type="hidden" name="eb_room_title" value="<?php echo $eagle_booking_room_title ?>">
    <input type="hidden" name="eb_checkout_form_name" value="<?php echo $eagle_booking_form_name ?>">
    <input type="hidden" name="eb_checkout_form_surname" value="<?php echo $eagle_booking_form_surname ?>">
    <input type="hidden" name="eb_checkout_form_email" value="<?php echo $eagle_booking_form_email ?>">
    <input type="hidden" name="eb_checkout_form_phone" value="<?php echo $eagle_booking_form_phone ?>">
    <input type="hidden" name="eb_checkout_form_address" value="<?php echo $eagle_booking_form_address ?>">
    <input type="hidden" name="eb_checkout_form_city" value="<?php echo $eagle_booking_form_city ?>">
    <input type="hidden" name="eb_checkout_form_country" value="<?php echo $eagle_booking_form_country ?>">
    <input type="hidden" name="eb_checkout_form_zip" value="<?php echo $eagle_booking_form_zip ?>">
    <input type="hidden" name="eb_checkout_form_requets" value="<?php echo $eagle_booking_form_requests ?>">
    <input type="hidden" name="eb_checkout_form_arrival" value="<?php echo $eagle_booking_form_arrival ?>">
    <input type="hidden" name="eagle_booking_form_services" value="<?php echo $eagle_booking_form_services ?>">
    <input type="hidden" name="eb_form_coupon" value="<?php echo $eagle_booking_form_coupon ?>">
    <input type="hidden" name="eb_form_action_type" value="razorpay">
    <input type="hidden" name="eb_form_payment_status" value="Pending Payment">
    <button id="razorpay_btn" class="btn eb-btn btn-razorpay" type="submit"><?php echo esc_html__('Checkout Now','eagle-booking') ?></button>
  </form>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    jQuery(function($){

      $(document).ready(function() {

        $("#razorpay_btn").click(function(e) {

            var options = {
            "key": "<?php echo eb_get_option( 'razorpay_public_key' ) ?>",
            "amount": "<?php echo $paid_amount ?>",
            "name": "<?php echo $eagle_booking_room_title ?>",
            "order_id": "<?php echo $order->id ?>",
            "image": "<?php echo eb_get_option( 'hotel_logo' ) ?>",
            prefill: {
              name: "<?php echo $eagle_booking_form_name .' '.$eagle_booking_form_surname ?>",
              email: "<?php echo $eagle_booking_form_email ?>",
              contact: "<?php echo $eagle_booking_form_phone ?>"
            },

            "handler": function (response) {

              if ( typeof response.razorpay_payment_id != 'undefined' ||  response.razorpay_payment_id > 1) {

                // Pass values
                $('#razorpay_payment_id').val( response.razorpay_payment_id );
                $('#razorpay_order_id').val( response.razorpay_order_id );
                $('#razorpay_signature').val( response.razorpay_signature );

                // Submit the form
                $('#razorpayform').submit();

              }

            }

          };

          var rzp = new Razorpay(options);
          rzp.open();
          e.preventDefault();

        });

      });

    });
  </script>

</div>
<?php endif ?>
