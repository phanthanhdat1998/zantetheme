<?php
   /**
    * The Template for the payment tabs
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/checkout/payment.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.6
    */

   defined('ABSPATH') || exit;

?>

<div class="checkout-payment-tabs">
  <h4 class="title"><?php echo esc_html__('Payment Options','eagle-booking') ?></h4>
  <ul class="payment-tabs">
    <?php
      /**
      * Include payment tabs
      */
      include_once EB_PATH . 'core/admin/gateways/payment-tabs.php';
    ?>
  </ul>
  <div class="payment-tabs-content">
  <?php
      /**
      * Include payment caontent
      */
      include_once EB_PATH . 'core/admin/gateways/payment-content.php';
    ?>
  </div>
</div>
