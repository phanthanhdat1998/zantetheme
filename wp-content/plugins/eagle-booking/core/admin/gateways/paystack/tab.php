<?php if ( eb_get_option('eagle_booking_payment_method')['paystack'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_paystack_tab">
    <i class="fa fa-credit-card" aria-hidden="true"></i><?php echo __('Paystack','eagle-booking') ?>
  </a>
</li>
<?php endif ?>
