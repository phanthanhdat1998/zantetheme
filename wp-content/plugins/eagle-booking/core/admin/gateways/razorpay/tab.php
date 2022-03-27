<?php if ( eb_get_option('eagle_booking_payment_method')['razorpay'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_razorpay_tab">
    <i class="fa fa-credit-card" aria-hidden="true"></i><?php echo do_shortcode( eb_get_option('razorpay_title') ) ?>
  </a>
</li>
<?php endif ?>
