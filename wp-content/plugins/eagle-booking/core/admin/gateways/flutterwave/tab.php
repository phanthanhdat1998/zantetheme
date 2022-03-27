<?php if ( eb_get_option('eagle_booking_payment_method')['flutterwave'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_flutterwave_tab">
    <i class="fa fa-credit-card" aria-hidden="true"></i><?php echo do_shortcode( eb_get_option('flutterwave_title') ) ?>
  </a>
</li>
<?php endif ?>
