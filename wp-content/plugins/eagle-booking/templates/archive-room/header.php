<?php
/**
 * The Template for displaying all archive header
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/archive-room/header.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;

get_header();

?>

<?php

$eb_rooms_archive_header = eb_get_option('rooms_archive_header');
$eb_rooms_archive_header_type = eb_get_option('rooms_archive_header_type');
$eb_rooms_archive_header_image = eb_get_option('rooms_archive_header_image');

if( $eb_rooms_archive_header_type == 'image' ) {

  $eb_rooms_archive_header_class = 'image';
  $eb_rooms_archive_header_style = 'background:url('.$eb_rooms_archive_header_image.'); background-size: cover;';

} else {

  $eb_rooms_archive_header_class = 'color';
  $eb_rooms_archive_header_style = '';

}

?>

<?php if ( $eb_rooms_archive_header ) : ?>

<div class="eb-page-header eb-page-header-<?php echo esc_attr( $eb_rooms_archive_header_class ) ?>" style="<?php echo esc_attr( $eb_rooms_archive_header_style )?>">
  <div class="container">
      <div class="title">
        <h1><?php echo post_type_archive_title(); ?></h1>
        <?php if ( eb_get_option('rooms_archive_breadcrumbs')) : eb_breadcrumb(); endif ?>
      </div>
  </div>
</div>

<?php endif ?>