<?php
/**
 * The Template for displaying pagination
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/search/pagination.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<?php if ( $eagle_booking_results_qnt > $eagle_booking_rooms_per_page ) : ?>
<nav class="text-center mt100">
    <ul class="pagination">
      <?php  for ($eagle_booking_i_pagination = 1; $eagle_booking_i_pagination <= $eagle_booking_qnt_pagination; $eagle_booking_i_pagination++) : ?>

          <?php  if ( $eagle_booking_i_pagination == $eagle_booking_paged ){ $eagle_booking_class_pagination_active = 'active'; } else { $eagle_booking_class_pagination_active = ''; } ?>
                  <li class="<?php echo $eagle_booking_class_pagination_active ?>">
                    <a class="pagination-button" data-pagination="<?php echo $eagle_booking_i_pagination ?>">
                        <?php echo $eagle_booking_i_pagination ?>
                    </a>
                </li>

       <?php endfor ?>
    </ul>
</div>
<?php endif ?>
