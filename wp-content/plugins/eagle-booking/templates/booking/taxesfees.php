<?php

  $eb_taxes = array();
  $eb_fees = array();
  $eb_room_taxes = array();
  $eb_room_fees = array();

  // Get All Taxes & Fees
  $eb_taxes = get_option('eb_taxes');
  $eb_fees = get_option('eb_fees');

  // Get taxes & fees asigned to the room
  $eb_room_taxes = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_taxes', true );
  $eb_room_fees = get_post_meta (  $eb_room_id, 'eagle_booking_mtb_room_fees', true );

  if ( empty( $eb_taxes ) ) $eb_taxes = array();
  if ( empty( $eb_fees ) ) $eb_fees = array();
  if ( empty( $eb_room_taxes ) ) $eb_room_taxes = array();
  if ( empty( $eb_room_fees ) ) $eb_room_fees = array();

  // Merge Taxes & Fees
  $eb_entries = array_merge( $eb_taxes, $eb_fees );
  $eb_room_entries = array_merge( $eb_room_taxes, $eb_room_fees );

  if ( empty( $eb_room_entries ) ) $eb_room_entries = array();

  $html = '';

  if ( eb_get_option('eb_adults_children') == true ) {

    $guests = $eb_adults + $eb_children;

  } else {

    $guests = $eb_guests;

  }

  if ( $eb_entries ) {

      $total_amount = 0;
      $taxes_fees_amount = 0;

      foreach( $eb_entries as $key => $item ) {

        $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
        $entry_title = !empty( $item["title"] ) ? $item["title"] : '';
        $type = !empty( $item["type"] ) ? $item["type"] : '';
        $amount = !empty( $item["amount"] ) ? $item["amount"] : '';
        $global = !empty( $item["global"] ) ? $item["global"] : '';
        $services = !empty( $item["services"] ) ? $item["services"] : '';
        $fees = !empty( $item["fees"] ) ? $item["fees"] : '';

        if ( $item["global"] == true || in_array( $entry_id, $eb_room_entries)  ) {

          // Calculate the tax & fees total based on the type
          if ( $type === 'per_booking' ) {

            $taxes_fees_amount = $amount;

          } elseif ( $type === 'per_booking_nights' ) {

            $taxes_fees_amount = $amount * $eb_booking_nights;

          } elseif ( $type === 'per_guests' ) {

            $taxes_fees_amount = $amount * $guests;

          } elseif ( $type === 'per_booking_nights_guests' ) {

            $taxes_fees_amount = $amount * $guests * $eb_booking_nights;

          } else {

            $taxes_fees_amount = $amount * $eb_trip_price / 100;

          }

          // Check if is tax or fee
          if( $services != '' ) {
            $id = 'tax-id='.$entry_id.'';
            $data = 'data-amount='.round( $taxes_fees_amount).' data-percentage='.$amount.'';
          } else {
            $id = 'vat-id='.$entry_id.'';
            $data = 'data-amount='.round( $taxes_fees_amount).'';
          }

          $html .= "<div class='item taxfee' data-$id $data>";
          $html .= "<span class='desc'>$entry_title</span>";
          $html .= "<span class='value'><strong>".eb_price( round( $taxes_fees_amount ) ). "</strong></span>";
          $html .= "</div>";

        }

        // Get the total cost of the taxes
        $total_amount += $taxes_fees_amount;

      }

      // Add the total tax cost to the total price
      $eb_trip_price = $eb_trip_price + $total_amount;

  }

  echo $html;
