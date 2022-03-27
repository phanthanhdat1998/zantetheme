<div class="vbf vbf-over-slider <?php echo esc_attr($eb_search_form_class) ?>">

  <h2 class="form_title"><?php echo __('Book Your Stay','eagle-booking') ?></h2>
  <div class="inner">
    <form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">

        <?php

          include eb_load_template('elements/custom-parameters.php');

          include eb_load_template('elements/dates-picker.php');

          include eb_load_template('elements/guests-picker.php');

          if ( $include_branches == true ) include eb_load_template('elements/branch-selector.php')

        ?>

        <button id="eb_search_form" class="button eb-btn" type="submit">
            <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking') ?></span>
        </button>

    </form>
  </div>

</div>
