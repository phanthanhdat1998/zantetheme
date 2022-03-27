<?php
   /**
    * The Template for the coupon code
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/form/coupon.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1
    */

   defined('ABSPATH') || exit;
?>

<div class="form-panel">

    <h2 class="title"><?php echo __('Coupon','eagle-booking') ?></h2>

    <div id="eb_coupon_code_response" class="eb-alert eb-alert-small eb-alert-icon" style="display: none" role="alert">
        <span id="eb_coupon_code_response_text"></span>
    </div>

    <div id="eb_coupon_code_group" class="eb-g-5-2">
        <div>
            <input name="eb_coupon" type="text" id="eb_coupon" class="form-control" style="margin-bottom: 0;" placeholder="<?php echo __('Enter coupon code if you have one', 'eagle-booking') ?>">
            <input type="hidden" id="eb_coupon_code" name="eb_coupon_code">
            <input type="hidden" id="eb_coupon_value">
        </div>
        <div>
            <button id="eb_validate_coupon" class="btn eb-btn btn-full btn-coupon">
                <span class="eb-btn-text"><?php echo __('Validate Code', 'eagle-booking') ?></span>
            </button>
        </div>
    </div>

</div>
