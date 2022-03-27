<?php
/* --------------------------------------------------------------------------
 * Services CPT
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eagle_booking_create_post_type_services() {

    register_post_type('eagle_services',
        array(
            'labels' => array(
                'name' => __('Services', 'eagle-booking'),
                'singular_name' => __('Services', 'eagle-booking'),
                'add_new'		=>	__( 'Add New Service', 'eagle-booking'),
                'add_new_item'	=>	__( 'Add New Service', 'eagle-booking'),
                'edit_item'	=>	__( 'Edit Service', 'eagle-booking'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'rewrite' => array('slug' => 'services' ),
            'menu_icon'   => 'dashicons-awards',
            'supports' => array('title' )
        )
    );
}
add_action('init', 'eagle_booking_create_post_type_services');
