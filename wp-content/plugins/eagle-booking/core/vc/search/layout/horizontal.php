<div class="hbf <?php echo esc_attr( $eb_search_form_class ); ?>">
  <div class="inner">

      <form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">
        <div class="row">

        <?php include eb_load_template('elements/custom-parameters.php'); ?>

        <div class="col-md-4">
        <?php include eb_load_template('elements/dates-picker.php'); ?>
        </div>

        <div class="col-md-4">
        <?php include eb_load_template('elements/guests-picker.php'); ?>
        </div>

        <div class="col-md-4">
          <button id="eb_search_form" class="button eb-btn" type="submit">
              <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking') ?></span>
          </button>
        </div>

      </div>
    </form>
  </div>
</div>
