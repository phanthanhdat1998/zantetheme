<?php if ( eb_get_option('eagle_booking_payment_method')['arrive'] ) : ?>
<div id="eagle_booking_checkout_payment_arrive_tab">
    <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('eagle_booking_arrive_mssg')) ?></p>
    <form action="<?php echo eb_checkout_page() ?>" method="post">
        <input type="hidden" name="eagle_booking_payment_method" value="payment_on_arrive">
        <input type="hidden" name="eagle_booking_checkout_form_date_from" value="<?php echo $eagle_booking_form_date_from ?>">
        <input type="hidden" name="eagle_booking_checkout_form_date_to" value="<?php echo $eagle_booking_form_date_to ?>">
        <input type="hidden" name="eagle_booking_checkout_form_guests" value="<?php echo $eagle_booking_form_guests ?>">
        <input type="hidden" name="eagle_booking_checkout_form_adults" value="<?php echo $eagle_booking_form_adults ?>">
        <input type="hidden" name="eagle_booking_checkout_form_children" value="<?php echo $eagle_booking_form_children ?>">

        <input type="hidden" name="eb_room_price" value="<?php echo $eb_room_price ?>">

        <input type="hidden" name="eagle_booking_checkout_form_final_price" value="<?php echo $eagle_booking_form_final_price ?>">
        <input type="hidden" name="eagle_booking_deposit_amount" value="<?php echo $eagle_booking_deposit_amount ?>">
        <input type="hidden" name="eagle_booking_checkout_room_id" value="<?php echo $eagle_booking_room_id ?>">
        <input type="hidden" name="eagle_booking_checkout_form_post_title" value="<?php echo $eagle_booking_room_title ?>">
        <input type="hidden" name="eagle_booking_checkout_form_name" value="<?php echo $eagle_booking_form_name ?>">
        <input type="hidden" name="eagle_booking_checkout_form_surname" value="<?php echo $eagle_booking_form_surname ?>">
        <input type="hidden" name="eagle_booking_checkout_form_email" value="<?php echo $eagle_booking_form_email ?>">
        <input type="hidden" name="eagle_booking_checkout_form_phone" value="<?php echo $eagle_booking_form_phone ?>">
        <input type="hidden" name="eagle_booking_checkout_form_address" value="<?php echo $eagle_booking_form_address ?>">
        <input type="hidden" name="eagle_booking_checkout_form_city" value="<?php echo $eagle_booking_form_city ?>">
        <input type="hidden" name="eagle_booking_checkout_form_country" value="<?php echo $eagle_booking_form_country ?>">
        <input type="hidden" name="eagle_booking_checkout_form_zip" value="<?php echo $eagle_booking_form_zip ?>">
        <input type="hidden" name="eagle_booking_checkout_form_requets" value="<?php echo $eagle_booking_form_requests ?>">
        <input type="hidden" name="eagle_booking_checkout_form_arrival" value="<?php echo $eagle_booking_form_arrival ?>">
        <input type="hidden" name="eagle_booking_form_services" value="<?php echo $eagle_booking_form_services ?>">
        <input type="hidden" name="eagle_booking_form_coupon" value="<?php echo $eagle_booking_form_coupon ?>">
        <input type="hidden" name="eagle_booking_form_action_type" value="payment_on_arrive">
        <input type="hidden" name="eagle_booking_form_payment_status" value="Pending Payment">
        <button type="submit" class="btn eb-btn btn-arrive"> <?php echo esc_html__('Book Now', 'eagle-booking') ?></button>
    </form>
</div>
<?php endif ?>
