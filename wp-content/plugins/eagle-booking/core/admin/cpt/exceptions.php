<?php
/* --------------------------------------------------------------------------
 * Exceptions CPT
 * @since  1.0.4
 ---------------------------------------------------------------------------*/
function eagle_booking_create_post_type_exceptions() {

    register_post_type('eagle_exceptions',
        array(
            'labels' => array(
                'name' => __('Exceptions', 'eagle-booking'),
                'singular_name' => __('Exceptions', 'eagle-booking'),
                'add_new'		=>	__( 'Add New Exception', 'eagle-booking'),
                'add_new_item'	=>	__( 'Add New Exception', 'eagle-booking'),
                'edit_item'	=>	__( 'Edit Exception', 'eagle-booking'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'rewrite' => array('slug' => 'exceptions' ),
            'menu_icon'   => 'dashicons-forms',
            'supports' => array('title' )
        )
    );
}
add_action('init', 'eagle_booking_create_post_type_exceptions');
