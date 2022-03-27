<?php if ( eb_get_option('eagle_booking_payment_method')['paypal'] ) : ?>
<div id="eagle_booking_checkout_payment_paypal_tab">
    <?php
    // PLUGIN OPTIONS
    $eagle_booking_paypal_email = eb_get_option('eagle_booking_paypal_id');
    $eagle_booking_paypal_currency = eb_get_option('eagle_booking_paypal_currency');
    $eagle_booking_paypal_token = eb_get_option('eagle_booking_paypal_token');

    $eagle_booking_paypal_developer = eb_get_option('eagle_booking_paypal_developer_mode');
    if ( $eagle_booking_paypal_developer == true ) {
      $eagle_booking_paypal_action_1 = 'https://www.sandbox.paypal.com/cgi-bin';
      $eagle_booking_paypal_action_2 = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    } else {
      $eagle_booking_paypal_action_1 = 'https://www.paypal.com/cgi-bin';
      $eagle_booking_paypal_action_2 = 'https://www.paypal.com/cgi-bin/webscr';
    }
    ?>
    <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('eagle_booking_paypal_mssg')) ?></p>
    <form target="paypal" action="<?php echo $eagle_booking_paypal_action_1 ?>" method="post" >
        <input type="hidden" name="eagle_booking_payment_method" value="paypal">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?php echo $eagle_booking_paypal_email ?>">
        <input type="hidden" name="lc" value="">
        <input type="hidden" name="item_name" value="<?php echo $eagle_booking_room_title ?>">
        <input type="hidden" name="item_number" value="<?php echo $eagle_booking_room_id ?>">
        <input type="hidden" name="custom" value="<?php echo $eagle_booking_form_date_from.'[eb]'.$eagle_booking_form_date_to.'[eb]'.$eagle_booking_form_guests.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_name.'[eb]'.$eagle_booking_form_surname.'[eb]'.$eagle_booking_form_email.'[eb]'.$eagle_booking_form_phone.'[eb]'.$eagle_booking_form_address.'[eb]'.$eagle_booking_form_zip.'[eb]'.$eagle_booking_form_city.'[eb]'.$eagle_booking_form_country.'[eb]'.$eagle_booking_form_services.'[eb]'.$eagle_booking_form_requests.'[eb]'.$eagle_booking_form_arrival.'[eb]'.$eagle_booking_form_coupon.'[eb]'.$eagle_booking_form_final_price.'[eb]'.$eb_room_price ?>">
        <input type="hidden" name="amount" value="<?php echo $eagle_booking_deposit_amount ?>">
        <input type="hidden" name="currency_code" value="<?php echo $eagle_booking_paypal_currency ?>">
        <input type="hidden" name="rm" value="2" />
        <input type="hidden" name="return" value="<?php echo esc_url( eb_checkout_page() ) ?>" />
        <input type="hidden" name="cancel_return" value="" />
        <input type="hidden" name="button_subtype" value="services">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
        <button class="btn eb-btn btn-paypal" type="submit"><?php echo esc_html__('Checkout with PayPal','eagle-booking') ?></button>
    </form>
</div>
<?php endif ?>
