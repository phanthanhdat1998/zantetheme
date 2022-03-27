<?php
/*---------------------------------------------------------------------------------
@ Taxes & Fees Metaboxes
@ Since 1.2.9.1
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eb_taxes_fees_mtb');

function eb_taxes_fees_mtb() {

    $prefix = 'eb_mbt_taxes_fees_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
        'object_types'  => array('eagle_taxes_fees'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Type', 'eagle-booking'),
        'id'   => $prefix.'type',
        'type' => 'select',
        'default'          => 'tax',
        	'options'          => array(
        		'tax' => __( 'Tax', 'eagle-booking' ),
        		'fee'   => __( 'Fee', 'eagle-booking' ),
        	),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Value Type', 'eagle-booking'),
        'id'   => $prefix.'value_type',
        'type' => 'select',
        'default'          => 'fixed',
        	'options'          => array(
        		'fixed' => __( 'Fixed', 'eagle-booking' ),
        		'percentage'   => __( 'Percentage', 'eagle-booking' ),
        	),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Price Type', 'eagle-booking'),
        'id'   => $prefix.'price_type',
        'type' => 'select',
        'default'          => 'booking',
        	'options'          => array(
        		'booking' => __( 'Per Booking', 'eagle-booking' ),
        		'person'   => __( 'Per Person', 'eagle-booking' ),
        		'night'   => __( 'Per Booking Night', 'eagle-booking' ),
        	),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Applied', 'eagle-booking'),
        'id'   => $prefix.'applied',
        'type' => 'select',
        'default'          => 'total_price',
        	'options'          => array(
        		'total_price' => __( 'On Total Price', 'eagle-booking' ),
        		'accomodation_price'   => __( 'On Accomodation Price', 'eagle-booking' ),
        	),
    ));



    $cmb->add_field(array(
        'name' => esc_html__('Value', 'eagle-booking'),
        // 'desc' => esc_html__('Insert the coupon value ( e.g. 30 for -30% )', 'eagle-booking'),
        'id'   => $prefix.'value',
        'type' => 'text_small',
    ));

}
