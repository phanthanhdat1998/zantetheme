<?php
   /**
    * The Template for the signed in user
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/form/coupon.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1
    */

   defined('ABSPATH') || exit;
?>

<div id="eb_signed_in_user" style="<?php if ( !is_user_logged_in() ) echo esc_attr('display: none;') ?>">

    <div class="eb-alert eb-alert-success eb-alert-small eb-alert-icon mb25">
        <span id="eb_signed_in_user_text"><?php echo __('Logged in as', 'eagle-booking') ?>, <?php echo $eb_current_user->user_login ?>!</span>
        <span id="eb_user_sign_out" class="pull-right" style="cursor: pointer;"><?php echo __('Log Out', 'eagle-booking') ?></span>
    </div>

    <div class="eb-g-2 eb-g-m-1">

        <div class="eb-form-col">
            <input type="text" id="eb_signed_in_user_first_name" class="form-control" value="<?php eb_user('first_name') ?>">
            <label><?php echo __('First Name','eagle-booking') ?></label>
        </div>

        <div class="eb-form-col">
            <input type="text" id="eb_signed_in_user_last_name" class="form-control" value="<?php eb_user('last_name') ?>">
            <label><?php echo __('Last Name','eagle-booking') ?> </label>
        </div>


        <div class="eb-form-col">
            <input type="email" id="eb_signed_in_user_email" class="form-control" value="<?php eb_user('user_email') ?>">
            <label><?php echo __('Email','eagle-booking') ?></label>
        </div>


        <input type="tel" id="eb_signed_in_user_phone" class="eb_user_phone_field form-control" placeholder="<?php echo __('Phone','eagle-booking') ?> *" value="<?php eb_user('user_phone') ?>">


        <?php if ( eb_get_option('eb_booking_form_fields')['address'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_signed_in_user_address" class="form-control" value="<?php eb_user('user_address') ?>">
                <label><?php echo __('Address','eagle-booking') ?><label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['city'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_signed_in_user_city" class="form-control" value="<?php eb_user('user_city') ?>">
                <label><?php echo __('City','eagle-booking') ?><label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['country'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_signed_in_user_country" class="form-control" value="<?php eb_user('user_country') ?>">
                <label><?php echo __('Country','eagle-booking') ?><label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['zip'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_signed_in_user_zip" class="form-control" value="<?php eb_user('user_zip') ?>">
                <label><?php echo __('ZIP','eagle-booking') ?><label>
            </div>
        <?php endif ?>

    </div>

</div>
