<?php if ( eb_get_option('eagle_booking_payment_method')['paypal'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_paypal_tab">
    <i class="fa fa-paypal" aria-hidden="true"></i><?php echo esc_html__('PayPal','eagle-booking')?>
  </a>
</li>
<?php endif ?>
