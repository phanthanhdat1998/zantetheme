<?php if ( eb_get_option('eagle_booking_payment_method')['payu'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_payu_tab">
    <i class="fa fa-credit-card" aria-hidden="true"></i><?php echo esc_html__('Credit Card','eagle-booking') ?>
  </a>
</li>
<?php endif ?>
