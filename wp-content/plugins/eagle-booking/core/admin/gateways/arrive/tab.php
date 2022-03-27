<?php if ( eb_get_option('eagle_booking_payment_method')['arrive'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_arrive_tab">
    <i class="fa fa-money" aria-hidden="true"></i><?php echo esc_html__('Payment On Arrival','eagle-booking') ?>
  </a>
</li>
<?php endif ?>
