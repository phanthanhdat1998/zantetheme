<?php
   /**
    * The Template for the signin form
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/form/coupon.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1
    */

   defined('ABSPATH') || exit;
?>

<div class="eb-tab-content signin" data-tab="signin">

    <div id="eb_user_sign_in_response" class="eb-alert eb-alert-small mb20" style="display: none">
        <span id="eb_user_sign_in_response_text"></span>
    </div>

    <form class="eb-g-3-3-1 eb-g-m-1" id="eb_user_sign_in_form">

        <div class="eb-form-col">
            <input type="text" id="eb_user_sign_in_username" class="form-control">
            <label><?php echo __('Username or Email Address', 'eagle-booking') ?></label>
        </div>

        <div class="eb-form-col">
            <input type="password" id="eb_user_sign_in_password" class="form-control" autocomplete="on">
            <label><?php echo __('Password', 'eagle-booking') ?></label>
        </div>

        <button id="eb_user_sign_in" class="btn eb-btn btn-full" type="submit">
            <span class="eb-btn-text"><?php echo __('Sign In','eagle-booking') ?></span>
        </button>

    </form>
</div>