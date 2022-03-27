<div class="eb-widget eb-price-range">
  <h2 class="title"><?php echo __('Price','eagle-booking') ?> </h2>
  <div class="inner">
    <input type="hidden" id="eagle_booking_slider_range" class="js-range-slider">
    <input type="hidden" id="eagle_booking_min_price" name="eagle_booking_min_price" value="<?php echo eb_get_option('eb_price_range_min') ?>">
    <input type="hidden" id="eagle_booking_max_price" name="eagle_booking_max_price" value="<?php echo eb_get_option('eb_price_range_max') ?>">
  </div>
</div>
