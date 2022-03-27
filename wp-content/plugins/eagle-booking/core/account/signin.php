<?php
   /**
    * The Template for the account sign in form
    *
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.6
    */

   defined('ABSPATH') || exit;
?>

<div class="login-page">
    <h3 class="title mb50"><?php echo __('Sign In', 'eagle-booking') ?></h3>
    <form id="eb_user_dashboard_signin_form" class="login-form" method="post">
        <div id="eb_user_sign_in_response" class="eb-alert eb-alert-small mb20" style="display: none">
            <span id="eb_user_sign_in_response_text"></span>
        </div>
        <input type="hidden" id="eb_security" value="<?php echo wp_create_nonce('eb_nonce', 'security'); ?>">
        <input id="eb_user_sign_in_username" type="text" name="username" placeholder="<?php echo __('Username or Email', 'eagle-booking') ?>">
        <input id="eb_user_sign_in_password" type="password" name="password" autocomplete="on" placeholder="<?php echo __('Password', 'eagle-booking') ?>">
        <button id="eb_user_sign_in" class="btn eb-btn btn-full" type="submit">
            <span class="eb-btn-text"><?php echo __('Sign In','eagle-booking') ?></span>
        </button>
        <div class="login-form-footer">
            <a href="?sign_up"><?php echo __("Don't have an account?", 'eagle-booking') ?></a>
            <a href="<?php echo wp_lostpassword_url(); ?>"><?php echo __('Forgot Password?', 'eagle-booking') ?></a>
        </div>
    </form>
</div>
