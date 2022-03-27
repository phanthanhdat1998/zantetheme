<?php
/**
 * The Template for the custom parameters
   *
   * This template can be overridden by copying it to yourtheme/eb-templates/elements/custom-parameters.php.
   *
   * Author: Eagle Themes
   * Package: Eagle-Booking/Templates
   * Version: 1.1.5
   */

defined('ABSPATH') || exit;
?>

<?php if (eb_get_option('booking_type') == 'custom' ) : ?>
<input type="hidden" name="<?php echo esc_html( $eagle_booking_hotel_id_param ) ?>" value="<?php echo esc_html($eagle_booking_hotel_id) ?>" >
<input type="hidden" name="<?php echo esc_html( $eagle_booking_additional_param ) ?>" value="<?php echo esc_html($eagle_booking_additional_id) ?>" >
<?php endif ?>
