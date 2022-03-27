<div class="login-page">

    <h3 class="title mb50"><?php echo __('Sign Up', 'eagle-booking') ?></h3>

    <form id="eb_user_dashboard_signup_form" class="login-form method="post">

        <div id="eb_user_sign_up_response" class="eb-alert eb-alert-small mb20" role="alert" style="display:none">
            <span id="eb_user_sign_up_response_text"></span>
        </div>

        <input id="eb_user_sign_up_username" type="text" name="username" placeholder="<?php echo __('Username', 'eagle-booking') ?>">
        <input id="eb_user_sign_up_email" type="email" name="email" placeholder="<?php echo __('Email', 'eagle-booking') ?> ">
        <input id="eb_user_sign_up_password" type="password" name="password" placeholder="<?php echo __('Password', 'eagle-booking') ?> ">
        <div class="gdpr mb20">
            <input type="checkbox" id="eb_user_sign_up_terms">
            <label for="eb_user_sign_up_terms"><?php echo __('I agree to the', 'eagle-booking') ?> <a class="terms-conditions" target="_blank" href="<?php echo eagle_booking_terms_page() ?>"><?php echo __('Terms and Conditions','eagle-booking') ?></a></label>
        </div>
        <button id="eb_user_sign_up" class="btn eb-btn btn-full" type="submit">
            <span class="eb-btn-text"><?php echo __('Sign Up','eagle-booking') ?></span>
        </button>
        <div class="login-form-footer">
            <a href="<?php echo eb_account_page() ?>?sign_in"><?php echo __('Already Registered?', 'eagle-booking') ?></a>
            <a href="<?php echo wp_lostpassword_url(); ?>"><?php echo __('Forgot Password?', 'eagle-booking') ?></a>
        </div>

    </form>

</div>
