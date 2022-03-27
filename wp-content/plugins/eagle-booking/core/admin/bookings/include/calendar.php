<?php

// Prev / Next Month
function eb_next_prev_month_year($eb_date, $eb_month_year, $eb_next_prev) {

    if ($eb_next_prev == 'next') {
        $eb_get_next_month_year = date('Y-m-d', strtotime($eb_date.' + 1 month'));
    } else {
        $eb_get_next_month_year = date('Y-m-d', strtotime($eb_date.' - 1 month'));
    }

    if ($eb_month_year == 'month') {
        $eb_next_m_y = date_format(new DateTime($eb_get_next_month_year), 'm');
    } else {
        $eb_next_m_y = date_format(new DateTime($eb_get_next_month_year), 'Y');
    }

    return $eb_next_m_y;
}

// Month Name
function eb_month_name($eb_date) {

	$eb_month_name = date('Y-m-d', strtotime($eb_date));
	$eb_month = date_format(new DateTime($eb_month_name),'F');
    return $eb_month;

}

// Check if month isset
if (isset($_POST['eb_month'])) {

    $eb_month = sanitize_text_field($_POST['eb_month']);
    $eb_year = sanitize_text_field($_POST['eb_year']);
    $eb_new_date = $eb_year.'-'.$eb_month.'-1';
    $eb_today = $eb_month;
    $eb_year = $eb_year;
    $eb_tot_days = cal_days_in_month(CAL_GREGORIAN, $eb_today, $eb_year);

    $eb_next_month = eb_next_prev_month_year($eb_new_date, 'month','next');
    $eb_next_year = eb_next_prev_month_year($eb_new_date, 'year','next');
    $eb_prev_month = eb_next_prev_month_year($eb_new_date, 'month','prev');
    $eb_prev_year = eb_next_prev_month_year($eb_new_date, 'year','prev');

// Current / Default Month
} else {

    $eb_today = date('n');
    $eb_year = date('Y');
    $eb_tot_days = cal_days_in_month(CAL_GREGORIAN, $eb_today, $eb_year);
    $eb_next_month = eb_next_prev_month_year(date('Y-m-d'),'month','next');
    $eb_next_year = eb_next_prev_month_year(date('Y-m-d'),'year','next');
    $eb_prev_month = eb_next_prev_month_year(date('Y-m-d'),'month','prev');
    $eb_prev_year = eb_next_prev_month_year(date('Y-m-d'),'year','prev');
}

$eb_month_name_date = $eb_year.'-'.$eb_today.'-1';
$eb_short_month_name = substr(eb_month_name($eb_month_name_date), 0, 3);

?>

<div class="eb-wrapper">

<?php include EB_PATH.''."core/admin/bookings/elements/admin-header.php"; ?>

<div class="eb-admin-title">

    <div>
        <h1 class="wp-heading-inline"><?php echo __('Calendar','eagle-booking') ?></h1>
    </div>

    <div class="eb-admin-new-booking">
        <a href="<?php echo admin_url( 'admin.php?page=eb_new_booking') ?>" class="eb-new-booking-btn"><?php echo __('Add New Booking','eagle-booking') ?></a>
    </div>

</div>

<div class="eb-calendar-view">

    <div class="calendar-month">
        <span>
            <form method="POST" action="admin.php?page=eb_calendar">
                <input type="hidden" name="eb_month" value="<?php echo $eb_prev_month ?>">
                <input type="hidden" name="eb_year" value="<?php echo $eb_prev_year ?>">
                <button type="submit"><i class="fas fa-chevron-left"></i></button>
            </form>
        </span>
        <span>
            <h2><?php echo eb_month_name($eb_month_name_date).' '.$eb_year ?></h2>
        </span>
        <span>
            <form method="POST" action="admin.php?page=eb_calendar">
                <input type="hidden" name="eb_month" value="<?php echo $eb_next_month ?>">
                <input type="hidden" name="eb_year" value="<?php echo $eb_next_year ?>">
                <button type="submit"><i class="fas fa-chevron-right"></i></button>
            </form>
        </span>
    </div>

    <table class="calendar-days">
        <thead>
            <tr>
                <th width="20%"><strong><?php echo __('Room Title', 'eagle-booking') ?></strong></th>
                <?php for ($eb_i = 1; $eb_i <= $eb_tot_days; $eb_i++) :
                $eb_date = $eb_today.'/'.$eb_i.'/'.$eb_year; ?>
                <th class="calendar-day">
                    <span><strong><?php echo date("D",strtotime($eb_date)) ?></strong></span>
                    <span><strong><?php echo $eb_i ?></strong></span>
                    <span><?php echo $eb_short_month_name ?></span>
                    <span><?php echo $eb_year ?></span>
                </th>
                <?php endfor ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $args = array(
                    'post_type' => 'eagle_rooms',
                    'posts_per_page' => -1
                );

                $the_query = new WP_Query( $args );

                while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <?php
                        // Defaults
                        $eb_room_title = get_the_title();
                        $eb_room_id = get_the_ID();
                        $eb_room_url = get_edit_post_link( $eb_room_id );
                        $eb_room_qnt = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_quantity', true );
                    ?>

                    <tr class="calendar-room">

                        <td class="room-title"><a href="<?php echo esc_url($eb_room_url) ?>" target="_blank"><?php echo $eb_room_title ?> (<?php echo $eb_room_qnt ?>)</a></td>

                        <?php

                            for ($eb_i = 1; $eb_i <= $eb_tot_days; $eb_i++) :

                                // Dates
                                $eb_date_from = $eb_today.'/'.$eb_i.'/'.$eb_year;
                                $eb_date_to = date('m/d/Y', strtotime($eb_date_from.' + 1 days'));
                                $eb_date = date('m/d/Y', strtotime($eb_date_to.' - 1 days'));

                                // Check Availability
                                $eb_availability = eagle_booking_is_qnt_available( eagle_booking_room_availability($eb_room_id, $eb_date_from, $eb_date_to), $eb_date_from, $eb_date_to, $eb_room_id );

                                $eb_availability_block = eb_room_is_available_block( $eb_room_id, $eb_date_from, $eb_date_to );

                                if ( $eb_availability == 0 ) {

                                    // Booked / Not Available
                                    $eb_date_class = 'eb-room-booked eb-room-not-available';


                                } elseif ( $eb_availability_block == 0 ) {

                                    // Blocked
                                    $eb_date_class = 'eb-room-blocked';

                                } else {

                                    if ( eagle_booking_room_availability($eb_room_id, $eb_date_from, $eb_date_to) != '' ) {

                                        // Booked / Available
                                        $eb_date_class = 'eb-room-booked eb-room-still-available';

                                    } else {

                                        // Not Booked
                                        $eb_date_class = '';

                                    }

                                }

                            ?>

                            <td class="eb-room-availability <?php echo esc_attr($eb_date_class) ?>" data-date="<?php echo $eb_date ?>" data-room-id="<?php echo $eb_room_id ?>" data-room-title="<?php echo $eb_room_title ?>" data-displayed-date="<?php echo eagle_booking_displayd_date_format($eb_date) ?>"></td>

                        <?php endfor ?>
                    </tr>
                <?php endwhile; ?>
        </tbody>

    </table>

    <!-- Calendar Bookings Footer -->
    <div class="calendar-bookings-footer">
        <ul class="">
            <li>(*) <?php echo __('Room Quantity', 'eagle-booking') ?></li>
        </ul>
        <ul class="availability-calendar-list-availability eb-pull-right">
            <li><span class="available"></span><?php echo __('Booked / Available', 'eagle-booking') ?></li>
            <li><span class="not-available"></span><?php echo __('Booked / Not Available', 'eagle-booking') ?> </li>
            <li><span class="blocked"></span><?php echo __('Blocked / Not Available', 'eagle-booking') ?> </li>
        </ul>
    </div>

</div>

</div>

<!-- Create a popup here and tigger it on date hover -->
<div id="eb-room-availability-popup" class="eb-popover" style="display: none">
	<div class="inner">
        <h2 id="eb-calendar-title-loading"><?php echo __('Loading...', 'eagle-booking') ?></h2>
		<h2 id="eb-calendar-title"><?php echo __('Bookings for', 'eagle-booking') ?> <span id="eb-calendar-room-title"></span> <?php echo __('on', 'eagle-booking' )?> <span id="eb-calendar-date"></span></h2>
		<div id="content"></div>
        <div class="popup-footer">
            <ul class="booking-status-explanation">
                <li><span class="status completed"></span><?php echo __('Completed', 'eagle-booking' ) ?></li>
                <li><span class="status pending-payment"></span><?php echo __('Pending Payment', 'eagle-booking') ?></li>
                <li><span class="status pending"></span><?php echo __('Pending', 'eagle-booking') ?></li>
            </ul>
        </div>
	</div>
</div>

<!-- Delete Popup -->
<div class="eb-popup">
   <div class="eb-popup-inner">
      <span class="eb-close-popup"><i class="fas fa-times"></i></span>
      <div class="eb-popup-icon failed">
         <i class="far fa-trash-alt"></i>
      </div>
      <h3 class="title"><?php echo __('Delete Booking', 'eagle-booking') ?> #<span id="eb_booking_id_text"></span></h3>
      <p><?php echo __('This action cannot be undone. Are you sure you want to delete this booking?', 'eagle-booking') ?></p>
      <button class="btn btn-delete" id="eb_delete_booking_confirmation"  data-booking-id="">
         <span class="eb-btn-text"><?php echo __('Yes, delete this booking', 'eagle-booking') ?></span>
      </button>
   </div>
</div>