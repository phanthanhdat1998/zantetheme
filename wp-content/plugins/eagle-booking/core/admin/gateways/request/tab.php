<?php if ( eb_get_option('eagle_booking_payment_method')['request'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_request_tab">
    <i class="fa fa-calendar" aria-hidden="true"></i><?php echo esc_html__('Booking Request','eagle-booking') ?>
  </a>
</li>
<?php endif ?>
