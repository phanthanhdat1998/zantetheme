<?php

  /**
   * Set default values if not provided
  */
  if( !isset( $_GET['eb_guests'])  && !isset( $_GET['eb_adults'] ) ) {

    $eagle_booking_guests = eb_get_option('eb_default_guests');
    $eagle_booking_adults = eb_get_option('eb_default_adults');
    $eagle_booking_children = eb_get_option('eb_default_children');

  }

  $eb_room_id = get_the_ID();
  $eagle_booking_dates = '';

  /**
   * External Booking target
  */
  if (eb_get_option('booking_type') != 'builtin' && eb_get_option('eagle_booking_external_target')) {
    $eagle_booking_target = '_blank';
  } else {
    $eagle_booking_target = '';
  }

  /**
   * Guests Parameters
  */
  if ( is_singular( 'eagle_rooms' ) ) {

    $eb_max_guests = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_maxguests', true );
    $eb_max_adults = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_max_adults', true );
    $eb_max_children = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_max_children', true );

    if ( $eb_max_guests < $eagle_booking_guests ) $eagle_booking_guests = $eb_max_guests;
    if ( $eb_max_adults < $eagle_booking_adults ) $eagle_booking_adults = $eb_max_adults;
    if ( $eb_max_children < $eagle_booking_children ) $eagle_booking_children = $eb_max_children;

  } else {

    $eb_max_guests = eb_get_option('eb_max_guests');
    $eb_max_adults = eb_get_option('eb_max_adults');
    $eb_max_children = eb_get_option('eb_max_children');

  }

  /**
   * Form Action Based on Booking System
  */
  if (eb_get_option('booking_type') == 'builtin' ) {

    // Action for the form on single room
    if ( is_singular( 'eagle_rooms' ) ) {

      $eagle_booking_action = eb_booking_page();
      $eagle_booking_action_method = 'POST';

    } else {

      $eagle_booking_action = eb_search_page();
      $eagle_booking_action_method = 'GET';

    }

    $eagle_booking_checkin_param = 'eb_checkin';
    $eagle_booking_checkout_param = 'eb_checkout';
    $eagle_booking_guests_param = 'eb_guests';
    $eagle_booking_adults_param = 'eb_adults';
    $eagle_booking_children_param = 'eb_children';

  } elseif (eb_get_option('booking_type') == 'custom') {

    $eagle_booking_action = eb_get_option('booking_type_custom_action');
    $eagle_booking_action_method = 'GET';
    $eagle_booking_hotel_id_param = eb_get_option('booking_type_custom_hotel_id_param');
    $eagle_booking_hotel_id = eb_get_option('booking_type_custom_hotel_id');
    $eagle_booking_additional_param = eb_get_option('booking_type_custom_additional_param');
    $eagle_booking_additional_id = eb_get_option('booking_type_custom_additional_id');
    $eagle_booking_room_param = eb_get_option('booking_type_custom_room_param');
    $eagle_booking_checkin_param = eb_get_option('booking_type_custom_checkin_param');
    $eagle_booking_checkout_param = eb_get_option('booking_type_custom_checkout_param');
    $eagle_booking_guests_param = eb_get_option('booking_type_custom_guests_param');
    $eagle_booking_adults_param = eb_get_option('booking_type_custom_adults_param');
    $eagle_booking_children_param = eb_get_option('booking_type_custom_children_param');

  } elseif (eb_get_option('booking_type') == 'booking') {
    $eagle_booking_action = eb_get_option('booking_type_booking_action').'#hp_availability_style_changes';
    $eagle_booking_action_method = 'GET';
    $eagle_booking_checkin_param = 'checkin';
    $eagle_booking_checkout_param = 'checkout';
    $eagle_booking_guests_param = 'group_adults';
    $eagle_booking_adults_param = 'group_adults';
    $eagle_booking_children_param = 'group_children';

  } elseif (eb_get_option('booking_type') == 'airbnb') {
    $eagle_booking_action = eb_get_option('booking_type_airbnb_action');
    $eagle_booking_action_method = 'GET';
    $eagle_booking_checkin_param = 'check_in';
    $eagle_booking_checkout_param = 'check_out';
    $eagle_booking_guests_param = 'guests';
    $eagle_booking_adults_param = 'adults';
    $eagle_booking_children_param = 'children';

  } elseif (eb_get_option('booking_type') == 'tripadvisor') {
    $eagle_booking_action = eb_get_option('booking_type_tripadvisor_action');
    $eagle_booking_action_method = 'GET';
    $eagle_booking_checkin_param = 'checkin';
    $eagle_booking_checkout_param = 'checkout';
    $eagle_booking_guests_param = 'group_adults';
    $eagle_booking_adults_param = 'adults';
    $eagle_booking_children_param = 'children';

  }