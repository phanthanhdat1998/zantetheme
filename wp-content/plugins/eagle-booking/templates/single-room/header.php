<?php
/**
 * The Template for displaying room header
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/header.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<?php


$eb_room_header_image = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_header_image', true );

if( $eb_room_header_image != '' ) {

  $eb_room_header_class = 'image';
  $eb_room_header_style = 'background:url('.$eb_room_header_image.'); background-size: cover;';

} else {

  $eb_room_header_class = 'color';
  $eb_room_header_style = '';

}

?>

<div class="eb-page-header eb-page-header-<?php echo esc_attr( $eb_room_header_class ) ?> eb-room-header" style="<?php echo esc_attr( $eb_room_header_style ) ?>">
  <div class="container eb-container">
    <div class="wrapper">
      <div class="title">
        <h1><?php echo $eagle_booking_title ?></h1>
        <?php if ( eb_get_option('room_breadcrumbs') == true ) : eb_breadcrumb(); endif ?>
      </div>
      <?php eb_room_price( get_the_ID(), ' <span>/</span> '.__('per night', 'eagle-booking') ) ?>
    </div>
  </div>
</div>
