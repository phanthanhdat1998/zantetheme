<?php
/**
 * The Template for displaying all single rooms
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/single-room.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.9
 */

defined('ABSPATH') || exit;

get_header();

if ( have_posts() ) : the_post();

// Include form parameters
include_once EB_PATH . '/core/admin/form-parameters.php';

// Dates
$eagle_booking_checkin = date('m/d/Y');
$eagle_booking_checkout = date('m/d/Y', strtotime(' + 1 days'));
$eagle_booking_guests_default = eb_get_option( 'eagle_booking_default_guests' );
$eagle_booking_nights_default = 0;

// Defaults
$eagle_booking_id = get_the_ID();
$eagle_booking_title = get_the_title();

// Translated Rooms - Check if the room is a translated room and if so override the room id with the default one
$eb_default_room = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_default_room_id', true );
if ( $eb_default_room != '' ) $eb_room_id = $eb_default_room;

// Get external integration
$eagle_booking_room_param = eb_get_option('booking_type_custom_room_param');
$eagle_booking_room_external_url = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_integration_link', true );
$eagle_booking_room_external_id = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_integration_id', true );

// Overide the form action if room external link has been set
if ( !empty($eagle_booking_room_external_url) ) $eagle_booking_action = $eagle_booking_room_external_url;

// MTB
$eagle_booking_mtb_room_file_id = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_header_id', true );
$eb_room_page_layout = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_page_layout', true );
if ( $eb_room_page_layout == '' ) $eb_room_page_layout = 'normal-slider';
$eb_room_header_bg =  wp_get_attachment_image_url( $eagle_booking_mtb_room_file_id, 'full' );
$eb_mtb_room_max_guests = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_maxguests', true);
$eb_mtb_room_max_adults = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_adults', true);
$eb_mtb_room_max_children = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_children', true);

$eb_mtb_room_min_booking_nights = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_min_booking_nights', true);
$eb_mtb_room_max_booking_nights = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_booking_nights', true);

if( empty( $eb_mtb_room_min_booking_nights ) ) $eb_mtb_room_min_booking_nights = 1;

$eb_mtb_room_size = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_size', true);
$eb_mtb_room_bed_type = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_bed_type', true);

$eb_room_sidebar = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_sidebar', true);

// Room Grid
if ( $eb_room_sidebar == 'none' ) {

  $eb_room_grid_class = '';

} elseif ( $eb_room_sidebar == 'left' ) {

  $eb_room_grid_class = 'eb-g-2-6 eb-g-m-1-1 eb-g-c-g-40';

} else {

  $eb_room_grid_class = 'eb-g-6-2 eb-g-m-1-1 eb-g-c-g-40';

}

$room_slider = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_slider_images', true);
$eagle_booking_meta_box_min_price = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_price_min', true );
if (empty(get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_maxguests', true ) ) ) {
  $eagle_booking_meta_box_max_people = 4;
} else {
  $eagle_booking_meta_box_max_people = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_maxguests', true );
}
$eagle_booking_meta_box_text_preview = get_post_meta( $eagle_booking_id, 'eagle_booking_mtb_room_description', true );

/**
 * Include Room Header
*/
if ( $eb_room_page_layout == 'normal-slider') include eb_load_template('single-room/header.php');

/**
 * Include Room Full-Width Slider
*/
if ( $eb_room_page_layout == 'full-slider') include eb_load_template('single-room/full-slider.php');

?>

<main id="eb-room-<?php echo esc_attr($eagle_booking_id) ?>" class="room-page eb-room-page">
  <div class="container eb-container">
    <div class="<?php echo esc_attr( $eb_room_grid_class ) ?> eb-sticky-sidebar-container">

      <?php
        /**
         * Include Room Sidebar
        */
        if ( $eb_room_sidebar == 'left' ) include eb_load_template('single-room/sidebar.php');
      ?>

      <div class="eb-column">

        <?php if ( $eb_room_page_layout == 'full-slider') : ?>
          <div class="eb-g-5-3 room-main-details">
            <div class="eb-col">
              <div class="room-title">
                <h1><?php echo $eagle_booking_title ?></h1>
              </div>
            </div>
            <div class="eb-col">
              <?php eb_room_price( get_the_ID(), ' / '.__('per night', 'eagle-booking') ) ?>
            </div>
          </div>
        <?php endif ?>

      <?php

        /**
         * Include Room Normal Slider
        */
        if ( $eb_room_page_layout == 'normal-slider') include eb_load_template('single-room/slider.php');

        /**
        * Sortable Room Elements
        */
        $eb_room_elements = eb_get_option('eagle_booking_room_page_settings');
        if ($eb_room_elements) {
          foreach ($eb_room_elements as $eb_room_element=>$value) {
            switch($eb_room_element) {
              case 'basic_info': if ( $value == true ) include eb_load_template('single-room/info.php');
              break;
              case 'room_content': if ( $value == true ) include eb_load_template('single-room/content.php');
              break;
              case 'room_availability': if ( $value == true ) include eb_load_template('single-room/availability.php');
              break;
              case 'room_services': if ( $value == true ) include eb_load_template('single-room/services.php');
              break;
              case 'room_additional_services': if ( $value == true ) include eb_load_template('single-room/additional-services.php');
              break;
              case 'room_reviews': if ( $value == true ) include eb_load_template('single-room/reviews.php');
              break;
              case 'similar_rooms': if ( $value == true ) include eb_load_template('single-room/similar-rooms.php');
              break;
            }
          }
        }
      ?>

      </div>

      <?php
        /**
        * Include Room Sidebar
        */
        if ( $eb_room_sidebar == 'right' ) include eb_load_template('single-room/sidebar.php');
      ?>

    </div>
  </div>
</main>

<script type="text/javascript">

  var eb_booked_dates = [<?php echo json_encode( eb_room_availability_calendar($eb_room_id, date('Y/m/d'), date('Y/m/d', strtotime($eb_end_period)) ) ); ?>];

</script>

<?php endif ?>
<?php get_footer(); ?>
