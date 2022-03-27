<?php
/**
* The Template for the admin email
*
* This template can be overridden by copying it to yourtheme/eb-templates/email/admin.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.1.9
*/

defined('ABSPATH') || exit;

?>

<html>
   <head>
      <title><?php echo __('New Reservation','eagle-booking') ?></title>
      <style type="text/css">
         body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
            font-size: 15px;
         }
         a {
            color: <?php echo esc_attr($eagle_booking_message_template_link_color) ?>;
            text-decoration: none;
         }
         .content {
            width: 100%;
            max-width: 600px;
            border: 1px solid <?php echo esc_attr($eagle_booking_message_template_border) ?>;
         }
         .main {
            padding: 30px 0;
            line-height: 20px;
            font-family: sans-serif;
         }
         .main .booking-details td {
            padding: 5px 0;
         }
         .eheader {
            padding: 20px;
         }
         .innerpadding {
            padding: 30px 30px;
         }
         .title {
            text-align: center;
            text-transform: uppercase;
         }
         .title a {
            font-size: 30px;
            line-height: 40px;
         }
         .h2 {
            padding: 0 0 15px 0;
            font-size: 16px;
            line-height: 28px;
            font-weight: bold;
         }
         .h3 {
            font-size: 15px;
            text-decoration: underline;
         }
         .bodycopy {
            font-size: 15px;
            line-height: 22px;
         }
         .details {
            font-size: 15px;
         }
         .footer {
            padding: 20px 30px 15px 30px;
            border-top: 1px solid <?php echo esc_attr($eagle_booking_message_template_footer_border) ?>;
         }
         .footercopy {
            font-size: 15px;
            color: <?php echo esc_attr($eagle_booking_message_template_footer_color) ?>;
         }
         .social a {
            font-size: 15px;
         }
         @media screen and (max-width: 600px) {
            .main {
                  padding: 0;
            }
            .innerpadding {
                  padding: 30px;
                  5px
            }
         }

      </style>
   </head>
   <body>
      <table width="100%" bgcolor="<?php echo esc_attr($eagle_booking_message_template_bg) ?>" style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>; padding: 30px 0;" class="main" border="0" cellpadding="0" cellspacing="0">
         <tr>
            <td>
               <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="min-width: 600px;">
                  <tr>
                     <td bgcolor="<?php echo esc_attr($eagle_booking_message_template_header_bg) ?>" class="eheader" style="padding: 20px;">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                           <tr>
                              <td height="70">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                       <td class="title" style="padding: 5px 0 0 0; text-align: center;">
                                          <a style="color: <?php echo esc_attr($eagle_booking_message_template_header_color) ?>; font-size: 30px; line-height: 40px; text-decoration: none;" href="<?php echo esc_url($eagle_booking_hotel_url) ?>"><?php echo $eagle_booking_hotel_logo ?></a>
                                       </td>
                                    </tr>
                                    <tr style="color: <?php echo esc_attr($eagle_booking_message_template_header_color) ?>">
                                       <td style="padding: 0 0 0 3px; text-align: center">
                                          <?php echo __('Reservation Details - Admin', 'eagle-booking') ?>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                     <td class="innerpadding" style="border-bottom: 1px solid <?php echo esc_attr($eagle_booking_message_template_border) ?>; padding: 30px 30px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tr>
                              <td class="h2" style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                                 <?php echo __('Hello Admin,', 'eagle-booking') ?>
                              </td>
                           </tr>
                           <tr>
                              <td class="bodycopy" style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                                 <p><?php echo __('you just received a new reservation on your site.','eagle-booking') ?></p>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                     <td class="innerpadding" style="border-bottom: 1px solid <?php echo esc_attr($eagle_booking_message_template_border) ?>;  padding: 30px 30px;">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                           <tr>
                              <td style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>" class="h3"><?php echo __('Reservation Details', 'eagle-booking') ?>:</td>
                           </tr>
                           <tr>
                              <td class="innerpadding details">
                                 <table class="booking-details" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                                    <tr>
                                       <td><?php echo __('Name','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_first_name).' '.esc_html($eagle_booking_user_last_name) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Email','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_email) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Phone','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_phone) ?></td>
                                    </tr>

                                    <?php if ( eb_get_option('show_price') == true ) : ?>
                                    <tr>
                                       <td><?php echo __('Total Price','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eb_email_total_amount) ?></td>
                                    </tr>
                                    <?php if ( eb_get_option('eagle_booking_deposit_amount') < 100 ) : ?>
                                    <tr>
                                       <td><?php echo __('Deposit Amount','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eb_email_deposit_amount) ?></td>
                                    </tr>
                                    <?php endif ?>
                                    <?php endif ?>
                                    <tr>
                                       <td><?php echo __('Room','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_title_post) ?></td>
                                    </tr>
                                    <?php if ( eb_room_branch( $eagle_booking_room_id ) ) : ?>
                                       <tr>
                                          <td><?php echo __('Branch','eagle-booking') ?></td>
                                          <td><?php echo eb_room_branch( $eagle_booking_room_id ) ?></td>
                                       </tr>
                                    <?php endif ?>
                                    <?php if ( $eb_email_additional_services ) : ?>
                                    <tr>
                                       <td><?php echo __('Additional Services','eagle-booking') ?></td>
                                       <td><?php echo $eb_email_additional_services ?></td>
                                    </tr>
                                    <?php endif ?>
                                    <tr>
                                       <td><?php echo __('Guests','eagle-booking') ?></td>
                                       <td>
                                          <?php if ( eb_get_option('eb_adults_children') == true ) : ?>
                                             <?php echo esc_html($eagle_booking_adults) .' '.__('Adults', 'eagle-booking')?>,
                                             <?php echo esc_html($eagle_booking_children) .' '.__('Children', 'eagle-booking') ?>
                                          <?php else : ?>
                                             <?php echo esc_html($eagle_booking_guests) ?>
                                          <?php endif ?>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Check In','eagle-booking') ?></td>
                                       <td><?php echo eagle_booking_displayd_date_format($eagle_booking_checkin) ?><?php eb_checkin_checkout_time('checkin') ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Check Out','eagle-booking') ?></td>
                                       <td><?php echo eagle_booking_displayd_date_format($eagle_booking_checkout) ?><?php eb_checkin_checkout_time('checkout') ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Address','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_address) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('City','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_city) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Country','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_country) ?></td>
                                    </tr>
                                    <?php if ( $eagle_booking_user_message ) : ?>
                                    <tr>
                                       <td><?php echo __('Message','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_user_message) ?></td>
                                    </tr>
                                    <?php endif ?>
                                    <?php if ( $eb_customer_arrival ) : ?>
                                       <tr>
                                          <td><?php echo __('Arrival','eagle-booking') ?></td>
                                          <td><?php echo esc_html($eb_customer_arrival) ?></td>
                                       </tr>
                                    <?php endif ?>
                                    <tr>
                                       <td><?php echo __('Payment Method','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_checkout_payment_type_text) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Status','eagle-booking')?></td>
                                       <td><?php echo esc_html($eb_booking_status) ?></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo __('Transaction ID','eagle-booking') ?></td>
                                       <td><?php echo esc_html($eagle_booking_transaction_id) ?></td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>

                  <tr style="color: <?php echo esc_attr($eagle_booking_message_template_color) ?>">
                     <td class="footer" bgcolor="<?php echo esc_attr($eagle_booking_message_template_footer_bg) ?>" style="padding: 20px 30px 15px 30px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tr>
                              <td align="center" class="footercopy">
                                 &#169; <?php echo date("Y") ?> <a href="<?php echo esc_url($eagle_booking_hotel_url) ?>"><?php echo esc_html($eagle_booking_hotel_name) ?></a> <?php echo __('All Rights Reserved.', 'eagle-booking') ?>
                              </td>
                           </tr>
                           <tr>
                              <td align="center" class="social" style="padding: 10px 0 0 0;">
                                 <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                       <?php
                                       if (!empty( $eagle_booking_message_facebook_url) ) : ?>
                                       <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                                          <a href="<?php echo esc_url($eagle_booking_message_facebook_url) ?>">
                                             <?php echo __('facebook', 'eagle-booking') ?>
                                          </a>
                                       </td>
                                       <?php endif ?>
                                       <?php
                                       if (!empty( $eagle_booking_message_twitter_url) ) : ?>
                                       <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                                          <a href="<?php echo esc_url($eagle_booking_message_twitter_url) ?>">
                                             <?php echo __('twitter', 'eagle-booking') ?>
                                          </a>
                                       </td>
                                       <?php endif ?>
                                       <?php
                                       if (!empty( $eagle_booking_message_instagram_url) ) : ?>
                                       <td width="33" style="text-align: center; padding: 0 10px 0 10px;">
                                          <a href="<?php echo esc_url($eagle_booking_message_instagram_url) ?>">
                                             <?php echo __('instagram', 'eagle-booking') ?>
                                          </a>
                                       </td>
                                       <?php endif ?>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>