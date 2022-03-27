<?php
/* --------------------------------------------------------------------------
 * Places CPT
 * @since  1.0.0
 ---------------------------------------------------------------------------*/

// REGISTER CPT PLACES
if (!function_exists('eagle_create_post_type_places')) :
function eagle_create_post_type_places() {
    register_post_type('eagle_places',
        array(
            'labels' => array(
                'name' => __('Places', 'eagle-booking'),
                'singular_name' => __('Places', 'eagle-booking'),
				'add_new'		=>	__( 'Add New Item', 'eagle-booking' ),
				'add_new_item'	=>	__( 'Add New Item', 'eagle-booking' ),
            ),
            'public' => true,
            'has_archive' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => true,
            'exclude_from_search' => true,
			'menu_icon'		=>	'dashicons-location',
            'rewrite' => array('slug' => eb_get_option('eagle_booking_places_slug')),
            'supports' => array('title', 'thumbnail', 'editor', 'page-attributes')
        )
    );
}

add_action('init', 'eagle_create_post_type_places');

endif;


// ADD CUSTOM ROWS TO DASHBOARD
add_image_size( 'admin-list-thumb', 80, 80, false );

function eagle_places_dashboard_columns( $columns ) {
		$columns = array(
				'cb' => '<input type="checkbox" />',
				'featured_thumb' => __('Thumbnail', 'eagle-booking'),
				'title' => __('Title', 'eagle-booking'),
				'date' => 'Date'
		);
		return $columns;
}

function eagle_places_dashboard_columns_data( $column, $post_id ) {
		switch ( $column ) {
		case 'featured_thumb':
				echo '<a href="' . get_edit_post_link() . '">';
				echo the_post_thumbnail( 'admin-list-thumb' );
				echo '</a>';
				break;
		}
}

if ( function_exists( 'add_theme_support' ) ) {
		add_filter( 'manage_eagle_places_posts_columns' , 'eagle_places_dashboard_columns' );
		add_action( 'manage_eagle_places_posts_custom_column' , 'eagle_places_dashboard_columns_data', 10, 2 );
	}
