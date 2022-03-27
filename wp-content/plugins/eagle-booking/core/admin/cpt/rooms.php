<?php
/* --------------------------------------------------------------------------
 * Rooms CPT
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eagle_booking_create_post_type_rooms() {

    register_post_type('eagle_rooms',
        array(
            'labels' => array(
                'name'          => __('Rooms', 'eagle-booking'),
                'singular_name' => __('Rooms', 'eagle-booking'),
                'add_new'		=> __( 'Add New Room', 'eagle-booking'),
                'add_new_item'	=> __( 'Add New Room', 'eagle-booking'),
                'edit_item'   	=> __( 'Edit Room', 'eagle-booking'),
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => true,
            'exclude_from_search' => true,
            'show_in_admin_bar' => true,
            //'show_in_rest' => true,
            'rewrite' => array('slug' => eb_get_option('eagle_booking_rooms_slug')),
            'menu_icon'   => 'dashicons-admin-multisite',
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
        )
    );
}
add_action('init', 'eagle_booking_create_post_type_rooms');



// ADD CUSTOM ROWS TO DASHBOARD
add_image_size( 'admin-list-thumb', 80, 80, false );

function eagle_rooms_dashboard_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'featured_thumb' => esc_html__('Thumbnail', 'eagle-booking'),
        'title' => esc_html__('Title', 'eagle-booking'),
        'price' => esc_html__('Price', 'eagle-booking'),
        'date' => esc_html__('Date', 'eagle-booking'),
        'taxonomy-eagle_branch' => esc_html__('Branch', 'eagle-booking')
    );
    return $columns;
}

function eb_rooms_dashboard_columns_data( $column, $post_id ) {
    switch ( $column ) {

        case 'featured_thumb':
            echo '<a href="' . get_edit_post_link() . '">';
            echo the_post_thumbnail( array(60, 60) );
            echo '</a>';
        break;

        case 'price':

            if ( eb_currency_position() === 'before' ) {

                echo eb_currency().''.eagle_booking_room_min_price( $post_id );

            } else {

                echo eagle_booking_room_min_price( $post_id ).''.eb_currency();

            }

        break;

    };
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_eagle_rooms_posts_columns' , 'eagle_rooms_dashboard_columns' );
    add_action( 'manage_eagle_rooms_posts_custom_column' , 'eb_rooms_dashboard_columns_data', 10, 2 );
}


// Keep the admin menu open on editting eagle_rooms CPT
function eb_keep_cpt_menu_open($parent_file) {

global $current_screen, $post_type;

if ( $post_type == 'eagle_rooms' ) $parent_file = 'eb_bookings';

return $parent_file;

}

add_action('parent_file', 'eb_keep_cpt_menu_open' );
