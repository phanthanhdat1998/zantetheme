<?php if ( eb_get_option('eagle_booking_payment_method')['payu'] ) : ?>

<div id="eagle_booking_checkout_payment_payu_tab">

    <p class="checkout-mssg"><?php echo do_shortcode(eb_get_option('eb_payu_checkout_mssg')) ?></p>

    <?php
        $eb_payu_merchant_key = eb_get_option('eb_payu_merchant_key');
        $eb_payu_merchant_salt = eb_get_option('eb_payu_merchant_salt');
        $eb_payu_transaction_id = 'Txn'.rand(10000, 99999999);

        // Pass parameters as array
        $eb_payu_udf5 = $eagle_booking_room_id .'[eb]'.$eagle_booking_form_date_from.'[eb]'.$eagle_booking_form_date_to.'[eb]'.$eagle_booking_form_guests.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_adults.'[eb]'.$eagle_booking_form_name.'[eb]'.$eagle_booking_form_surname.'[eb]'.$eagle_booking_form_email.'[eb]'.$eagle_booking_form_phone.'[eb]'.$eagle_booking_form_address.'[eb]'.$eagle_booking_form_zip.'[eb]'.$eagle_booking_form_city.'[eb]'.$eagle_booking_form_country.'[eb]'.$eagle_booking_form_services.'[eb]'.$eagle_booking_form_requests.'[eb]'.$eagle_booking_form_arrival.'[eb]'.$eagle_booking_form_coupon.'[eb]'.$eagle_booking_form_final_price;

        $eb_payu_hash = hash('sha512', $eb_payu_merchant_key.'|'.$eb_payu_transaction_id.'|'.$eagle_booking_deposit_amount.'|'.$eagle_booking_room_title.'|'.$eagle_booking_form_name.'|'.$eagle_booking_form_email.'|||||'.$eb_payu_udf5.'||||||'.$eb_payu_merchant_salt);

    ?>

    <form action="#" id="payu_form">
        <input type="hidden" id="surl" name="surl" value="<?php echo eb_checkout_page() ?>" />
        <input type="hidden" id="key" name="key" value="<?php echo $eb_payu_merchant_key ?>" />
        <input type="hidden" id="salt" name="salt" value="<?php echo $eb_payu_merchant_salt ?>" />
        <input type="hidden" id="txnid" name="txnid" value="<?php echo $eb_payu_transaction_id ?>" />
        <input type="hidden" id="amount" name="amount" value="<?php echo $eagle_booking_deposit_amount ?>">
        <input type="hidden" id="pinfo" name="pinfo" value="<?php echo $eagle_booking_room_title ?>">
        <input type="hidden" id="email" name="email" value="<?php echo $eagle_booking_form_email ?>">
        <input type="hidden" id="mobile" name="mobile" value="<?php echo $eagle_booking_form_phone ?>">
        <input type="hidden" id="fname" name="fname" value="<?php echo $eagle_booking_form_name ?>">
        <input type="hidden" id="udf5" name="udf5" value="<?php echo $eb_payu_udf5 ?>">
        <input type="hidden" id="hash" name="hash" value="<?php echo $eb_payu_hash ?>" />
        <button id="payu-button" class="btn eb-btn btn-payu" type="submit"><?php echo __('Checkout Now','eagle-booking') ?></button>
    </form>

    <?php if ( eb_get_option('eb_payu_sandbox') == true ) : ?>
         <script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="19a1f7" bolt-logo="https://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
    <?php else : ?>
         <script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="19a1f7" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
    <?php endif ?>

    <script type="text/javascript">
        jQuery(function($) {

          $(document).on('submit','#payu_form',function(e){
              launchBOLT();
          e.preventDefault();

          });

          function launchBOLT() {
          bolt.launch({
              key: $('#key').val(),
              salt: $('#salt').val(),
              txnid: $('#txnid').val(),
              hash: $('#hash').val(),
              amount: $('#amount').val(),
              firstname: $('#fname').val(),
              email: $('#email').val(),
              phone: $('#mobile').val(),
              productinfo: $('#pinfo').val(),
              udf5: $('#udf5').val(),
              surl : $('#surl').val(),
              furl: $('#surl').val(),
              mode: 'dropout'
          },
          {
              responseHandler: function(BOLT){
              console.log( BOLT.response.txnStatus );
          if(BOLT.response.txnStatus != 'CANCEL') {
              var fr = '<form action=\"'+$('#surl').val()+'\" method=\"post\">' +
              '<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
              '<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
              '<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
              '<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
              '<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
              '<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
              '<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
              '<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +
              '<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
              '<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
              '</form>';
              var form = jQuery(fr);
              jQuery('body').append(form);
              form.submit();
              }
          },
              catchException: function(BOLT){
              alert( BOLT.message );

          }
          });
          }

        });

    </script>

</div>
<?php endif ?>
