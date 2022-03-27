<?php
/*---------------------------------------------------------------------------------
@ Coupons Metaboxes
@ Since 1.1.0
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eagle_booking_coupons');

function eagle_booking_coupons() {

    $prefix = 'eagle_booking_mtb_coupon_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
        'object_types'  => array('eagle_coupons'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Code', 'eagle-booking'),
        'desc' => esc_html__('Insert the coupon code ( e.g. SUMMER30 )', 'eagle-booking'),
        'id'   => $prefix.'code',
        'type' => 'text_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Value', 'eagle-booking'),
        'desc' => esc_html__('Insert the coupon value ( e.g. 30 for -30% )', 'eagle-booking'),
        'id'   => $prefix.'value',
        'type' => 'text_small',
    ));

}
