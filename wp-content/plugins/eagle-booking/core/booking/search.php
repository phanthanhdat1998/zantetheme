<?php
/* --------------------------------------------------------------------------
 * Search Page Shortcode
 * @since  1.0.0
 * @modified 1.2.4
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

  ob_start();

  function eagle_booking_shortcode_search_results() {

  /**
  * Include Stepline
  */
  if ( eb_get_option('eb_stepline' ) == true ) include eb_load_template('elements/stepline.php');

  // Plugins Options
  $eagle_booking_rooms_per_page = eb_get_option('eagle_booking_rooms_per_page');
  $eagle_booking_price_range_min = eb_get_option('eb_price_range_min');
  $eagle_booking_price_range_max = eb_get_option('eb_price_range_max');
  $eagle_booking_guests = eb_get_option('eb_default_guests');
  $eagle_booking_adults = eb_get_option('eb_default_adults');
  $eagle_booking_children = eb_get_option('eb_default_children');

  // Price Range
  if( empty( $eagle_booking_price_range_min ) || eb_get_option('eagle_booking_search_page_settings')['price_range_filter'] == false ) {
    $eagle_booking_price_range_min = eb_rooms_min_max_price('min');
  }
  if( empty( $eagle_booking_price_range_max ) || eb_get_option('eagle_booking_search_page_settings')['price_range_filter'] == false ) {
    $eagle_booking_price_range_max = eb_rooms_min_max_price('max');
  }

  // Defaults
  $eagle_booking_checkin = '';
  $eagle_booking_checkout = '';
  $eagle_booking_nights = 0;
  $eagle_booking_dates = '';
  $eagle_booking_checkin_param = '';
  $eagle_booking_checkout_param = '';
  $eagle_booking_guests_param = '';
  $eagle_booking_adults_param = '';
  $eagle_booking_children_param = '';

  // GET values from search form (Homepage)
  if( isset( $_GET['eb_checkin']) && isset( $_GET['eb_checkout']) ) {

    // Check-In/Out
    $eagle_booking_checkin = sanitize_text_field( $_GET['eb_checkin'] );
    $eagle_booking_checkout = sanitize_text_field( $_GET['eb_checkout'] );

    // Guests
    if ( eb_get_option('eb_adults_children') == true ) {

      $eagle_booking_adults = sanitize_text_field( $_GET['eb_adults'] );
      $eagle_booking_children = sanitize_text_field( $_GET['eb_children'] );
      $eagle_booking_guests = $eagle_booking_adults;

    } else {
      $eagle_booking_guests = sanitize_text_field( $_GET['eb_guests'] );
      $eagle_booking_children = 0;
    }

    // Format checkin & checkout dates from m-d-y to displayd system format (m/d/Y)
    $eagle_booking_checkin = DateTime::createFromFormat("m-d-Y", $eagle_booking_checkin)->format('m/d/Y');
    $eagle_booking_checkout = DateTime::createFromFormat("m-d-Y", $eagle_booking_checkout)->format('m/d/Y');
    // Booking Dates
    $eagle_booking_dates = eagle_booking_displayd_date_format($eagle_booking_checkin). ' ' .' ' .' → '. ' ' .' ' .eagle_booking_displayd_date_format($eagle_booking_checkout);
    // Booking Nights
    $eagle_booking_nights = eb_total_booking_nights($eagle_booking_checkin, $eagle_booking_checkout);

  }

  /* --------------------------------------------------------------------------
   * DEFAULT QUERRY
   ---------------------------------------------------------------------------*/
  $eagle_booking_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1 ;
  $args = array(
      'post_type' => 'eagle_rooms',
      'post_status' => 'publish',
      'posts_per_page' => $eagle_booking_rooms_per_page,
      'meta_query' => array(

        // Min Price
        array(
              'key'     => 'eagle_booking_mtb_room_price_min',
              'type' => 'numeric',
              'value'   => $eagle_booking_price_range_min,
              'compare' => '>=',
            ),

        // Max Price
        array(
              'key'     => 'eagle_booking_mtb_room_price_min',
              'type' => 'numeric',
              'value'   => $eagle_booking_price_range_max,
              'compare' => '<=',
            ),

        // Exclude
        array(
              'key'     => 'eagle_booking_mtb_room_excluded',
              'compare' => 'NOT EXISTS',
            ),

        ),

      'paged' => $eagle_booking_paged
  );

  if ( eb_get_option('eb_adults_children') == true ) {

    // Adults
    $args['meta_query'][] = array(
      'key' => 'eagle_booking_mtb_room_max_adults',
      'type' => 'numeric',
      'value' => $eagle_booking_adults,
      'compare' => '>='
    );

    // Children
    $args['meta_query'][] = array(
      'key' => 'eagle_booking_mtb_room_max_children',
      'type' => 'numeric',
      'value' => $eagle_booking_children,
      'compare' => '>='
    );

  } else {

    // Guests
    $args['meta_query'][] = array(
      'key' => 'eagle_booking_mtb_room_maxguests',
      'type' => 'numeric',
      'value' => $eagle_booking_guests,
      'compare' => '>='
    );

  }

  // Branch
  if( isset( $_GET['eb_branch'] ) && $_GET['eb_branch'] != 'all' ) {

    $eb_selected_branch = $_GET['eb_branch'];

    $args['tax_query'][] = array(
      'taxonomy' => 'eagle_branch',
      'field' => 'term_id',
      'terms' => $eb_selected_branch,
    );

  } else {

    $eb_selected_branch = '';

  }

  $the_query = new WP_Query( $args );

  // Pagination
  $eagle_booking_results_qnt = $the_query->found_posts;
  $eagle_booking_qnt_pagination = ceil($eagle_booking_results_qnt / $eagle_booking_rooms_per_page);

  ?>

  <div class="eb-g-2-7 eb-g-m-1-1 eb-g-c-g-40 eb-sticky-sidebar-container">
    <?php
    /**
     * Include Filters
    */
    include eb_load_template('search/filters.php');

    ?>
    <div>

      <?php
        /**
         * Include Sorting
        */
        include eb_load_template('search/sorting.php');
      ?>
      <div id="eagle_booking_rooms_list">
          <div id="eagle_booking_search_results">
            <?php

              while ( $the_query->have_posts() ) : $the_query->the_post();
                /**
                 * Include Room
                */
                include eb_load_template('search/room.php');

              endwhile;
              /**
               * Include Pagination
              */
              include eb_load_template('search/pagination.php');
             ?>
          </div>
        </div>
        <?php if ( $eagle_booking_results_qnt == 0 ) : ?>
          <div id="eb-no-search-results" class="eb-alert mt20 text-center" role="alert">
            <?php echo __('No results for this search','eagle-booking') ?>
          </div>
        <?php endif; ?>

    </div>
  </div>

  <?php

  return ob_get_clean();

}

// Depracated Shortcode (Will be removed soon)
add_shortcode('eagle_booking_search_results', 'eagle_booking_shortcode_search_results');

// Search Page Shotcode
add_shortcode('eb_search', 'eagle_booking_shortcode_search_results');


function eagle_booking_filters() {

  // Check Nonce
  if ( !check_ajax_referer('eb_nonce', 'eb_search_filters_nonce', false) ) { ?>

      <div id="eb-no-search-results" class="eb-alert mt20 text-center" role="alert">
        <?php echo __('Invalid Nonce', 'eagle-booking') ?>
      </div>


  <?php  } else {

      // Plugin Options
      $eagle_booking_rooms_per_page = eb_get_option('eagle_booking_rooms_per_page');

      // Recover Values (Ajax Request)
      $eagle_booking_paged = sanitize_text_field( $_GET['eagle_booking_paged'] );
      $eagle_booking_checkin = sanitize_text_field( $_GET['eagle_booking_checkin'] );
      $eagle_booking_checkout = sanitize_text_field( $_GET['eagle_booking_checkout'] );
      $eagle_booking_price_range_min = sanitize_text_field( $_GET['eagle_booking_min_price'] );
      $eagle_booking_price_range_max = sanitize_text_field( $_GET['eagle_booking_max_price'] );
      $eb_normal_services = sanitize_text_field( $_GET['eb_normal_services'] );
      $eb_additional_services = sanitize_text_field( $_GET['eb_additional_services'] );
      $eb_branch_id = sanitize_text_field( $_GET['eb_branch_id'] );

      $eagle_booking_search_sorting_filter_meta_key = sanitize_text_field( $_GET['eagle_booking_search_sorting_filter_meta_key'] );
      $eagle_booking_search_sorting_filter_order = sanitize_text_field( $_GET['eagle_booking_search_sorting_filter_order'] );

      // Guests
      if (eb_get_option('eb_adults_children') == true) {

          $eagle_booking_adults = sanitize_text_field( $_GET['eagle_booking_adults'] );
          $eagle_booking_children = sanitize_text_field( $_GET['eagle_booking_children'] );
          $eagle_booking_guests = $eagle_booking_adults;

      } else {
          $eagle_booking_guests = sanitize_text_field($_GET['eagle_booking_guests']);
          $eagle_booking_children = 0;
      }

      $eagle_booking_checkin = eagle_booking_system_date_format($eagle_booking_checkin);
      $eagle_booking_checkout = eagle_booking_system_date_format($eagle_booking_checkout);

      // Price Range
      if (empty($eagle_booking_price_range_min)) {
          $eagle_booking_price_range_min = eb_rooms_min_max_price('min');
      }

      if (empty($eagle_booking_price_range_max)) {
          $eagle_booking_price_range_max = eb_rooms_min_max_price('max');
      }

      // Sorting
      if (empty($eagle_booking_search_sorting_filter_meta_key)) {

          $eagle_booking_booking_order_by = 'date';
          $eagle_booking_booking = 'DESC';

      } else {

          $eagle_booking_booking_order_by = 'meta_value_num';
          $eagle_booking_booking = $eagle_booking_search_sorting_filter_order;
      }

      /* --------------------------------------------------------------------------
      * AJAX QUERRY
      ---------------------------------------------------------------------------*/
      $args = array(
        'post_type' => 'eagle_rooms',
        'post_status' => 'publish',
        'post__not_in' => array(),
        'posts_per_page' => $eagle_booking_rooms_per_page,
        'orderby' => $eagle_booking_booking_order_by,
        'meta_key' => $eagle_booking_search_sorting_filter_meta_key,
        'order' => $eagle_booking_booking,
        'suppress_filters' => false,
        'meta_query' => array(

          // Min Price
          array(
                'key'     => 'eagle_booking_mtb_room_price_min',
                'type' => 'numeric',
                'value'   => $eagle_booking_price_range_min,
                'compare' => '>=',
              ),

          // Max Price
          array(
                'key'     => 'eagle_booking_mtb_room_price_min',
                'type' => 'numeric',
                'value'   => $eagle_booking_price_range_max,
                'compare' => '<=',
              ),

          // Exclude
          array(
            'key'     => 'eagle_booking_mtb_room_excluded',
            'compare' => 'NOT EXISTS',
          ),

        ),

        'paged' => $eagle_booking_paged
    );

      if ( eb_get_option('eb_adults_children') == true ) {

        // Adults
        $args['meta_query'][] = array(
        'key' => 'eagle_booking_mtb_room_max_adults',
        'type' => 'numeric',
        'value' => $eagle_booking_adults,
        'compare' => '>='
        );

        // Children
        $args['meta_query'][] = array(
        'key' => 'eagle_booking_mtb_room_max_children',
        'type' => 'numeric',
        'value' => $eagle_booking_children,
        'compare' => '>='
      );

      } else {

      // Guests
        $args['meta_query'][] = array(
        'key' => 'eagle_booking_mtb_room_maxguests',
        'type' => 'numeric',
        'value' => $eagle_booking_guests,
        'compare' => '>='
        );
      }

      /* --------------------------------------------------------------------------
       * NORMAL SERVICES
      ---------------------------------------------------------------------------*/
      if ($eb_normal_services) {

          $eb_normal_services_array = explode(',', $eb_normal_services);

          for ( $eb_normal_services_i = 0; $eb_normal_services_i < count($eb_normal_services_array); $eb_normal_services_i++ ) {

            $eb_normal_room_service = get_post($eb_normal_services_array[$eb_normal_services_i], OBJECT, 'eagle_services');
            $eb_normal_service_id = $eb_normal_room_service->ID;

            $args ['meta_query'][] = array(
              'key' => 'eagle_booking_mtb_room_services',
              'value'   => $eb_normal_service_id,
              'compare' => 'LIKE',
            );

          }
      }

      /* --------------------------------------------------------------------------
       * ADDITIONAL SERVICES
      ---------------------------------------------------------------------------*/
      if ($eb_additional_services) {

          $eb_additional_services_array = explode(',', $eb_additional_services);

          for ($eb_additional_services_i = 0; $eb_additional_services_i < count($eb_additional_services_array); $eb_additional_services_i++) {

            $eb_room_additional_service = get_post($eb_additional_services_array[$eb_additional_services_i], OBJECT, 'eagle_services');
            $eb_additional_service_id = $eb_room_additional_service->ID;

            $args['meta_query'][] = array(
              'key' => 'eagle_booking_mtb_room_additional_services',
              'value'   => $eb_additional_service_id,
              'compare' => 'LIKE',
            );

          }
      }

      /* --------------------------------------------------------------------------
       * Branch
      ---------------------------------------------------------------------------*/
      if ($eb_branch_id) {

          $args['tax_query'][] = array(
            'taxonomy' => 'eagle_branch',
            'field' => 'term_id',
            'terms' => $eb_branch_id,
          );
      }

      // Add all args to the query
      $the_query = new WP_Query($args);

      // Pagination
      $eagle_booking_results_qnt = $the_query->found_posts;
      $eagle_booking_qnt_pagination = ceil($eagle_booking_results_qnt / $eagle_booking_rooms_per_page);

      ?>
    <!-- Results -->
    <div id="eagle_booking_search_results">
      <input type="hidden" name="eagle_booking_results_qnt" id="eagle_booking_results_qnt"  value="<?php echo $eagle_booking_results_qnt ?>">

    <?php

      while ($the_query->have_posts()) : $the_query->the_post();

        /**
         * Include Room
        */
        include eb_load_template('search/room.php');

      endwhile;

      /**
       * Include Pagination
      */
      include eb_load_template('search/pagination.php');

    ?>

    </div>

    <!-- No Results -->
    <?php if ($eagle_booking_results_qnt == 0) : ?>
      <div id="eb-no-search-results" class="eb-alert mt20 text-center" role="alert">
        <?php echo __('No results for this search', 'eagle-booking') ?>
      </div>
    <?php endif; ?>

    <?php

  }

  // Reset Wuery
  wp_reset_query();
  wp_die();

}

// Actions
add_action( 'wp_ajax_eb_search_filters_action', 'eagle_booking_filters' );
add_action( 'wp_ajax_nopriv_eb_search_filters_action', 'eagle_booking_filters' );
