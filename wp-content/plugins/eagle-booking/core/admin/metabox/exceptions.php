<?php
/*---------------------------------------------------------------------------------
@ Exceptions Metaboxes
@ Since 1.1.0
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eagle_booking_exceptions');

function eagle_booking_exceptions() {

    $prefix = 'eagle_booking_mtb_exception_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
        'object_types'  => array('eagle_exceptions'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Type', 'eagle-booking'),
        'id'   => $prefix.'type',
        'type' => 'select',
        'default'          => 'normal',
        	'options'          => array(
        		'price' => __( 'Custom Price', 'eagle-booking' ),
        		'block'   => __( 'Block Dates', 'eagle-booking' ),
        	),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('New Price', 'eagle-booking'),
        'desc' => esc_html__('Insert the new room price (only number)', 'eagle-booking'),
        'id'   => $prefix.'price',
        'type' => 'text_small',
        'attributes' => array(
          'data-conditional-id'    => $prefix.'type',
          'data-conditional-value' => 'price',
        ),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Date From', 'eagle-booking'),
        'id'   => $prefix.'date_from',
        'type' => 'text_date',
        'attributes' => array(
          'readonly' => 'readonly',
        ),

        // 'date_format' => 'd/m/Y',
    ));

   $cmb->add_field(array(
        'name' => esc_html__('Date To', 'eagle-booking'),
        'id'   => $prefix.'date_to',
        'type' => 'text_date',
        'attributes' => array(
          'readonly' => 'readonly',
        ),
        // 'date_format' => 'd/m/Y',
    ));

    // $cmb->add_field( array(
    // 	'name' => esc_html__('Every Year?', 'eagle-booking'),
    // 	'id'   => $prefix.'repeat',
    // 	'type' => 'checkbox',
    // ) );

    // $cmb->add_field( array(
    //       'name' => esc_html__('Every Year?', 'eagle-booking'),
    //     	'id'   => $prefix.'repeat',
    //       'type'    => 'switch',
    //       'default'  => true,
    //       'label'    => array(
    //         'true'=> 'Yes',
    //         'false'=> 'No'
    //       ),
    //       'attributes' => array(
    //         'data-conditional-id'    => $prefix.'type',
    //         'data-conditional-value' => 'block',
    //       ),
    //   ));

      $cmb->add_field( array(
        'id'   => $prefix.'note',
      	'desc' => esc_html__('Note: Date From and Date To must be in the same year.', 'eagle-booking'),
      	'type' => 'title',
      ) );


}
