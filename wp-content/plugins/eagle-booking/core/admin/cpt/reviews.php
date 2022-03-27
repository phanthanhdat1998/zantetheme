<?php
/* --------------------------------------------------------------------------
 * Reviews CPT
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eagle_create_post_type_reviews() {
    register_post_type('eagle_reviews',
        array(
            'labels' => array(
                'name' => __('Reviews', 'eagle-booking'),
                'singular_name' => __('Reviews (Testimonials)', 'eagle-booking'),
								'add_new'		=>	__( 'Add New Item', 'eagle-booking' ),
								'add_new_item'	=>	__( 'Add New Item', 'eagle-booking' ),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'has_archive' => true,
            'exclude_from_search' => true,
						'menu_icon'		=>	'dashicons-testimonial',
            'supports' => array('title', 'thumbnail')
        )
    );
}
add_action('init', 'eagle_create_post_type_reviews');

/*---------------------------------------------------------------------------------
CUSTOM DASHBOARD COLUMNS
-----------------------------------------------------------------------------------*/
function eagle_reviews_dashboard_columns( $columns ) {
    $columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __('Title', 'eagle-booking'),
        'testimonial_quote' => __('Author Quote', 'eagle-booking'),
        'testimonial_author' => __('Author Name', 'eagle-booking'),
        'date' => __('Date', 'eagle-booking')
    );
    return $columns;
}

function eagle_reviews_dashboard_columns_data( $column, $post_id ) {
    switch ( $column ) {
        case 'testimonial_quote':
            echo  get_post_meta( get_the_ID(), 'eagle_booking_mtb_review_quote', true );
        break;

        case 'testimonial_author':
                echo get_post_meta( get_the_ID(), 'eagle_booking_mtb_review_author', true );
        break;
    }
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_eagle_reviews_posts_columns' , 'eagle_reviews_dashboard_columns' );
    add_action( 'manage_eagle_reviews_posts_custom_column' , 'eagle_reviews_dashboard_columns_data', 10, 2 );
}
