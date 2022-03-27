<?php if ( eb_get_option('eagle_booking_payment_method')['bank'] ) : ?>
<li class="payment-tab-item">
  <a href="#eagle_booking_checkout_payment_bank_tab">
    <i class="fa fa-university" aria-hidden="true"></i><?php echo esc_html__('Bank Transfer','eagle-booking') ?>
  </a>
</li>
<?php endif ?>
