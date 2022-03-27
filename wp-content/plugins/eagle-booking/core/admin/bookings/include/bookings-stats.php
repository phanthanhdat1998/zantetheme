<?php if (eb_get_option('eb_admin_booking_stats') == true ) : ?>

<div class="eagle-booking-stats">
   <!-- item -->
   <div class="stat-item stat-revenue">
      <div class="stat-icon">
       <i class="fas fa-money-bill-wave"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Total Revenue", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php if ( eb_currency_position() == 'before' ) : ?>
         <?php echo eb_currency()  .eagle_booking_total_earnings()?>
         <?php else : ?>
         <?php echo eagle_booking_total_earnings() .eb_currency() ?>
         <?php endif ?>
      </div>
   </div>
   <!-- item -->
   <div class="stat-item stat-total">
      <div class="stat-icon">
          <i class="far fa-calendar-alt"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Total Bookings", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php echo count($eb_bookings_num_status) ?>
      </div>
   </div>
   <!-- item -->
   <div class="stat-item stat-completed">
      <div class="stat-icon">
        <i class="far fa-calendar-check"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Completed Bookings", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php echo count($eb_bookings_num_status_completed) ?>
      </div>
   </div>
   <!-- item -->
   <div class="stat-item stat-pending-payment">
      <div class="stat-icon">
       <i class="far fa-calendar"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Pending Payment Bookings", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php echo count($eb_bookings_num_status_pending_payment) ?>
      </div>
   </div>
   <!-- item -->
   <div class="stat-item stat-pending">
      <div class="stat-icon">
       <i class="far fa-calendar-minus"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Pending Bookings", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php echo count($eb_bookings_num_status_pending) ?>
      </div>
   </div>

   <!-- item -->
   <div class="stat-item stat-canceled">
      <div class="stat-icon">
         <i class="far fa-calendar-times"></i>
      </div>
      <div class="stat-title">
         <?php echo esc_html__("Canceled Bookings", 'eagle-booking') ?>
      </div>
      <div class="stat-value">
         <?php echo count($eb_bookings_num_status_canceled) ?>
      </div>
   </div>

</div>

<?php endif ?>