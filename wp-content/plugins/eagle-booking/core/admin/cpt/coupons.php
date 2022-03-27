<?php
/* --------------------------------------------------------------------------
 * Coupons CPT
 * @since  1.0.5
 ---------------------------------------------------------------------------*/
function eagle_booking_create_post_type_coupons() {

    register_post_type('eagle_coupons',
        array(
            'labels' => array(
                'name' => __('Coupons', 'eagle-booking'),
                'singular_name' => __('Coupons', 'eagle-booking'),
                'add_new'		=>	__( 'Add New Coupon', 'eagle-booking'),
                'add_new_item'	=>	__( 'Add New Coupon', 'eagle-booking'),
                'edit_item'	=>	__( 'Edit Coupon', 'eagle-booking'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'rewrite' => array('slug' => 'coupons' ),
            'menu_icon'   => 'dashicons-forms',
            'supports' => array('title' )
        )
    );
}
add_action('init', 'eagle_booking_create_post_type_coupons');
