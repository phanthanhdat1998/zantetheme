<?php
   /* --------------------------------------------------------------------------
    * Bookings Pges
    * Author: Eagle Themes
    * @since  1.0.0
    * @modified 1.3.3
    ---------------------------------------------------------------------------*/

   $eb_bookings_per_page = eb_get_option('eb_bookings_per_page');

   if ( $eb_bookings_per_page == '' ) $eb_bookings_per_page = 20;

   if ( isset($_GET["page_no"]) ) {

     $eb_page_no = $_GET["page_no"];

   } else {

     $eb_page_no = 1;

   }

   $eb_bookings_start = $eb_bookings_per_page * ( (float)$eb_page_no - 1 );

   // Sorting Filter
   if ( isset( $_GET['sortby'] ) ) {

      $eb_sort_by = $_GET['sortby'];

   } else {

      $eb_sort_by = 'id';

   }

   // Status Filter
   if (isset($_GET["status"])) {
     $eb_booking_status = $_GET["status"];
   } else {
     $eb_booking_status = '';
   }

   // Branch Filter
   if ( isset( $_GET['branch_id'] ) ) {

      $eb_selected_branch_id = $_GET['branch_id'];

   } else {

      $eb_selected_branch_id = '';

   }

   // DB QUERY
   global $wpdb;

   $eagle_booking_booking_id = get_the_ID();
   $eagle_booking_table_name = $wpdb->prefix . 'eagle_booking';

   // Bookings
   if ( empty($eb_booking_status) ) {

     $eb_bookings = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name ORDER BY $eb_sort_by DESC LIMIT $eb_bookings_start, $eb_bookings_per_page");

   } else {

     $eb_bookings = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = '$eb_booking_status' ORDER BY $eb_sort_by DESC LIMIT $eb_bookings_start, $eb_bookings_per_page");

   }

   // Search Query
   if (isset($_GET["search"])) {
     $eb_search = $_GET["search"];
     $eb_bookings = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = '$eb_booking_status' AND user_first_name LIKE '%$eb_search%' OR user_last_name LIKE '%$eb_search%' OR title_post LIKE '%$eb_search%' OR id LIKE '%$eb_search%' OR paypal_tx LIKE '%$eb_search%' ORDER BY $eb_sort_by");

   }

   $eb_bookings_num_status = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name");
   $eb_bookings_num_status_pending = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = 'Pending'");
   $eb_bookings_num_status_pending_payment = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = 'Pending Payment'");
   $eb_bookings_num_status_canceled = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = 'Canceled'");
   $eb_bookings_num_status_completed = $wpdb->get_results( "SELECT * FROM $eagle_booking_table_name WHERE paypal_payment_status = 'Completed'");

   ?>
<div class="eb-admin eb-wrapper">

   <?php include EB_PATH.''."core/admin/bookings/elements/admin-header.php"; ?>

   <div class="eb-admin-title">

      <div>
         <h1 class="wp-heading-inline"><?php echo __('Bookings','eagle-booking') ?></h1>
      </div>

      <div class="eb-admin-new-booking">
         <a href="<?php echo admin_url( 'admin.php?page=eb_new_booking') ?>" class="eb-new-booking-btn"><?php echo __('Add New Booking','eagle-booking') ?></a>
      </div>

   </div>

   <?php

      if ($eb_bookings) {

         /**
          * Include Stats
         *
         * @since 1.2.9.6
         */

         include_once EB_PATH . 'core/admin/bookings/include/bookings-stats.php';

         ?>

         <div class="booking-search">

            <label><?php echo __('Sort by','eagle-booking') ?></label>
            <select class="eb_bookings_filter" style="margin-right: 20px">
               <option <?php if ($eb_sort_by == '' || $eb_sort_by == 'id') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&sortby=id&<?php echo $eb_booking_status ?>&branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('ID','eagle-booking') ?>
               </option>
               <option <?php if ($eb_sort_by == 'date_from') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&sortby=date_from&<?php echo $eb_booking_status ?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __ ('Check In', 'eagle-booking') ?>
               </option>
               <option <?php if ($eb_sort_by == 'date_to') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&sortby=date_to&<?php echo $eb_booking_status ?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __ ('Check Out', 'eagle-booking') ?>
               </option>
            </select>

            <label><?php echo __('Status','eagle-booking') ?></label>
            <select class="eb_bookings_filter" style="margin-right: 20px">
               <option <?php if ($eb_booking_status == '') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&status&sortby=<?php echo $eb_sort_by?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('All','eagle-booking') ?>
               </option>
               <option <?php if ($eb_booking_status == 'Pending') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&status=Pending&sortby=<?php echo $eb_sort_by?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('Pending','eagle-booking') ?>
               </option>
               <option <?php if ($eb_booking_status == 'Pending Payment') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&status=Pending Payment&sortby=<?php echo $eb_sort_by?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('Pending Payment','eagle-booking') ?>
               </option>
               <option <?php if ($eb_booking_status == 'Completed') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&status=Completed&sortby=<?php echo $eb_sort_by?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('Completed','eagle-booking') ?>
               </option>
               <option <?php if ($eb_booking_status == 'Canceled') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&status=Canceled&sortby=<?php echo $eb_sort_by?> &branch_id=<?php echo $eb_selected_branch_id ?>">
                  <?php echo __('Canceled','eagle-booking') ?>
               </option>
            </select>

            <label><?php echo __('Branch','eagle-booking') ?></label>
            <select class="eb_bookings_filter">

               <option <?php if ($eb_booking_status == '') { echo 'selected="slected"'; } ?> value="admin.php?page=eb_bookings&branch_id=&sortby=<?php echo $eb_sort_by?>&status=<?php echo $eb_booking_status ?>">
                  <?php echo __('All','eagle-booking') ?>
               </option>

               <?php

                  $args = array(
                     'taxonomy' => 'eagle_branch',
                     'hide_empty' => false,
                  );

                  $branch_query = new WP_Term_Query($args);

                  if ( !empty( $branch_query->terms ) ) {

                     foreach ( $branch_query->terms as $eb_branch ) {

                        $eb_branch_id = $eb_branch->term_id;
                        $eb_branch_name = get_term_field( 'name', $eb_branch );

                        echo '<option value="admin.php?page=eb_bookings&branch_id='.$eb_branch_id.'&sortby='.$eb_sort_by.'&status='.$eb_booking_status.'"   '.($eb_selected_branch_id == $eb_branch_id ? "selected='selected'" : "" ).'    >'.$eb_branch_name.'</option>';

                     }

                  }

               ?>

            </select>

            <div class="bookings-search" name="eb-bookings-search">
               <form method="GET">
               <input type="hidden" name="page" value="eb_bookings">
               <input type="hidden" name="status" value="<?php echo $eb_booking_status ?>">
               <input type="hidden" name="sortby" value="<?php echo $eb_sort_by ?>">
               <input type="text" name="search" class="search-box" placeholder="<?php echo esc_html__('Search Bookings by ID, Name, Surname or Transaction ID', 'eagle-booking') ?>">
               <button class="button search-button"><?php echo esc_html__('Search', 'eagle-booking') ?></button>
               <form>
            </div>
         </div>

         <table class="bookings-table">
            <tbody>
               <tr class="thead">
                  <td width="2%"><?php echo __('ID','eagle-booking') ?></td>
                  <td width="20%"><?php echo __('Room','eagle-booking') ?></td>
                  <?php if ( !empty( $branch_query->terms ) ) : ?>
                  <td width="7%"><?php echo __('Branch','eagle-booking') ?></td>
                  <?php endif ?>
                  <td width="10%"><?php echo __('Booking Dates','eagle-booking') ?></td>
                  <td width="7%"><?php echo __('Total Price','eagle-booking') ?></td>
                  <td width="12%"><?php echo __('Full Name','eagle-booking') ?></td>
                  <td width="5%"><?php echo __('Guests','eagle-booking') ?></td>
                  <td width="12%"><?php echo __('Payment Method','eagle-booking') ?></td>
                  <td class="booking-status-col" width="10%"><?php echo __('Status','eagle-booking') ?></td>
                  <td width="7%"><?php echo __('Action','eagle-booking') ?></td>
               </tr>
               <?php

                  foreach ( $eb_bookings as $eb_booking ) {

                     $branches = get_the_terms( $eb_booking->id_post, 'eagle_branch' );

                     if ( $branches ) {

                        foreach ( $branches as $branch ) {

                           $eb_room_branch_id = $branch->term_id;
                        }

                     } else {

                        $eb_room_branch_id = '';

                     }

                     if ( ( $eb_selected_branch_id == '' ) || ( $eb_selected_branch_id == $eb_room_branch_id ) ) {


                     // Booking Status & Class
                        if ( $eb_booking->paypal_payment_status == 'Pending Payment' ) {
                           $eb_booking_status_text = __('Pending Payment', 'eagle-booking');
                           $eb_booking_status_class = 'pending-payment';

                        } elseif ( $eb_booking->paypal_payment_status == 'Pending' ){
                           $eb_booking_status_text = __('Pending', 'eagle-booking');
                           $eb_booking_status_class = 'pending';

                        } elseif ( $eb_booking->paypal_payment_status == 'Canceled' ){
                           $eb_booking_status_text = __('Canceled', 'eagle-booking');
                           $eb_booking_status_class = 'canceled';

                        } else {
                           $eb_booking_status_text = __('Completed', 'eagle-booking');
                           $eb_booking_status_class = 'completed';
                        }


                        // Get the payment method text
                        if( $eb_booking->action_type === 'payment_on_arrive' ) {

                           $eb_booking_payment_method_text = __('Payment on Arrival', 'eagle-booking');

                        } elseif ($eb_booking->action_type === '2checkout') {

                           $eb_booking_payment_method_text = __('2Checkout', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'bank_transfer') {

                           $eb_booking_payment_method_text = __('Bank Transfer', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'PayU') {

                           $eb_booking_payment_method_text = __('PayU', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'paystack') {

                           $eb_booking_payment_method_text = __('Paystack', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'flutterwave') {

                           $eb_booking_payment_method_text = __('Flutterwave', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'vivawallet') {

                           $eb_booking_payment_method_text = __('Viva Wallet', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'razorpay') {

                           $eb_booking_payment_method_text = __('Razorpay', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'booking_request') {

                           $eb_booking_payment_method_text =  __('Booking Request', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'stripe') {

                           $eb_booking_payment_method_text = __('Stripe', 'eagle-booking');

                        } elseif ($eb_booking->action_type === 'paypal') {

                           $eb_booking_payment_method_text = __('PayPal', 'eagle-booking');

                        }

                     // Room Image
                     $eagle_booking_id = $eb_booking->id_post;
                     $eagle_booking_image_id = get_post_thumbnail_id($eagle_booking_id);
                     $eagle_booking_image_attributes = wp_get_attachment_image_src( $eagle_booking_image_id, 'thumbnail' );
                     $eagle_booking_room_img_src = $eagle_booking_image_attributes[0];
                     $eagle_booking_booking_id = $eb_booking->id_user;

                     ?>


                  <tr class="eb-booking-line" data-booking-id="<?php echo $eb_booking->id ?>">
                     <td>
                        <?php echo $eb_booking->id ?>
                     </td>
                     <td>
                        <div style="display:flex;">
                           <div style="width:80px; vertical-align:middle;">
                              <a href="<?php echo get_edit_post_link( $eb_booking->id_post ) ?>" target="_blank">
                              <img width="50" src="<?php echo $eagle_booking_room_img_src ?>" style="border-radius: 2px; display: block">
                              </a>
                           </div>
                           <h2 class="room-title">
                              <a href="<?php echo get_edit_post_link( $eb_booking->id_post ) ?>" target="_blank"><?php echo $eb_booking->title_post ?></a>
                           </h2>
                        </div>
                     </td>
                     <?php if ( !empty( $branch_query->terms ) ) : ?>
                     <td><?php echo eb_room_branch($eb_booking->id_post) ?></td>
                     <?php endif ?>
                     <td>
                        <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_from) ?></span> →
                        <span> <?php echo eagle_booking_displayd_date_format($eb_booking->date_to) ?></span>
                     </td>
                     <td>
                        <?php if ( eb_currency_position() == 'before' ) : ?>
                        <?php echo eb_currency() ?><?php eb_formatted_price($eb_booking->final_trip_price) ?>
                        <?php else : ?>
                        <?php eb_formatted_price($eb_booking->final_trip_price) ?><?php echo eb_currency() ?>
                        <?php endif ?>
                     </td>
                     <td>
                        <div>
                           <span><?php echo $eb_booking->user_first_name.' '.$eb_booking->user_last_name ?></span>
                        </div>
                     </td>
                     <td>
                        <?php echo $eb_booking->guests ?>
                     </td>
                     <td><span><?php echo $eb_booking_payment_method_text ?></span></td>
                     <td class="booking-status-col"><span class="booking-status status-<?php echo esc_attr($eb_booking_status_class) ?>"><?php echo $eb_booking_status_text ?></span></td>
                     <td>
                        <div class="eb-action-buttons">
                           <a href="admin.php?page=eb_edit_booking&id=<?php echo $eb_booking->id ?>" class="eb-edit-action"><i class="far fa-edit"></i></a>
                           <span class="eb-delete-action eb-delete-booking" data-booking-id="<?php echo $eb_booking->id ?>" ><i class="far fa-trash-alt"></i></span>
                        </div>
                     </td>
                  </tr>

               <?php

               }


            }

         ?>
            </tbody>
         </table>

<?php

// Get total pages based on status filter

if ( $eb_booking_status == 'Pending' ) {

   $eb_total_pages_num = ceil( count( $eb_bookings_num_status_pending ) / $eb_bookings_per_page ) ;

} elseif ( $eb_booking_status == 'Pending Payment' ) {

   $eb_total_pages_num = ceil( count( $eb_bookings_num_status_pending_payment ) / $eb_bookings_per_page ) ;

} elseif ( $eb_booking_status == 'Completed' ) {

   $eb_total_pages_num = ceil( count( $eb_bookings_num_status_completed ) / $eb_bookings_per_page ) ;

} else {

   $eb_total_pages_num = ceil( count( $eb_bookings_num_status ) / $eb_bookings_per_page ) ;

}

$current_page = (float)$eb_page_no;


// Calculate pages to output.
$end_size    = 2;
$mid_size    = 2;
$start_pages = range( 1, $end_size );
$end_pages   = range( $eb_total_pages_num - $end_size + 1, $eb_total_pages_num );
$mid_pages   = range( $current_page - $mid_size, $current_page + $mid_size );
$pages       = array_intersect( range( 1, $eb_total_pages_num ), array_merge( $start_pages, $end_pages, $mid_pages ) );
$prev_page   = 0;

?>
<nav class="eb-pagination">
	<ul>
		<?php if ( $current_page && $current_page > 1 ) : ?>
			<li><a href="?page=eb_bookings&page_no=<?php echo $current_page - 1 ?><?php echo '&status='.$eb_booking_status.'&branch_id='.$eb_selected_branch_id.'&sortby='.$eb_sort_by ?>" data-page="<?php echo esc_attr( $current_page - 1 ); ?>">&larr;</a></li>
		<?php endif; ?>

		<?php
			foreach ( $pages as $page ) {
				if ( $prev_page != $page - 1 ) {
					echo '<li><span>...</span></li>';
				}
				if ( $current_page == $page ) {
					echo '<li class="current"><a data-page="' . esc_attr( $page ) . '">' . esc_html( $page ) . '</a></li>';
				} else {
					echo '<li><a href="?page=eb_bookings&page_no='. $page .'&status='.$eb_booking_status.'&branch_id='.$eb_selected_branch_id.'&sortby='.$eb_sort_by.'" data-page="' . esc_attr( $page ) . '">' . esc_html( $page ) . '</a></li>';
				}
				$prev_page = $page;
			}
		?>

		<?php if ( $current_page && $current_page < $eb_total_pages_num ) : ?>
			<li><a href="?page=eb_bookings&page_no=<?php echo $current_page + 1  ?><?php echo '&status='.$eb_booking_status.'&branch_id='.$eb_selected_branch_id.'&sortby='.$eb_sort_by ?>" data-page="<?php echo esc_attr( $current_page + 1 ); ?>">&rarr;</a></li>
		<?php endif; ?>

	</ul>
</nav>

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

</div>

<!-- No Results -->
<?php } else { ?>

   <div class="eb-no-bookings">
      <i class="far fa-frown"></i>
      <p><?php echo __('You do not have any booking yet.', 'eagle-booking')?></p>
      <a href="<?php echo admin_url( 'admin.php?page=eb_new_booking') ?>"><?php echo __('Add New Booking', 'eagle-booking') ?></a>
   </div>

<?php } ?>