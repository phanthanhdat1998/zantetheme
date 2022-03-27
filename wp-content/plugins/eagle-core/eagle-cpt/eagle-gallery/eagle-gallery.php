<?php
/*
@ Eagle Gallery
@ Version: 1.0.0
@ Author: Eagle Themes
@ Author URI: https://eagle-themes.com
*/

// REGISTER CPT GALLERY
function eagle_create_post_type_gallery() {
    register_post_type('eagle_gallery',
        array(
            'labels' => array(
                'name' => __('Gallery', 'eagle'),
                'singular_name' => __('Gallery', 'eagle'),
								'add_new'		=>	__( 'Add New Item', 'eagle' ),
								'add_new_item'	=>	__( 'Add New Item', 'eagle' ),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'menu_icon'		=>	'dashicons-format-image',
            'rewrite' => array('slug' => 'gallery'),
            'supports' => array('title', 'thumbnail', 'page-attributes')
        )
    );

    register_taxonomy( 'eagle_gallery_category', 'eagle_gallery',
        array(
          'labels'			=>	array(
            'name'			=>	__( 'Filters', 'eagle' ),
            'add_new'		=>	__( 'Add New Filter', 'eagle' ),
            'add_new_item'	=>	__( 'Add New Filter', 'eagle' ),
          ),
          'public'			=>	true,
          'hierarchical'		=>	true,
          'show_in_nav_menus' => false,
        ) );

}

add_action('init', 'eagle_create_post_type_gallery');

// REMOVE SLUG AND DESCRIPTION FIELD
add_action( 'admin_footer-edit-tags.php', 'wpse_56569_remove_cat_tag_description' );
function wpse_56569_remove_cat_tag_description(){
		global $current_screen;
		switch ( $current_screen->id )
		{
				case 'edit-category':
						break;
				case 'edit-post_tag':
						break;
		}
		?>
		<script type="text/javascript">
		jQuery(document).ready( function($) {
				$('.taxonomy-eagle_gallery_category .term-description-wrap').remove();
				$('.taxonomy-eagle_gallery_category .term-slug-wrap').remove();
				$('.taxonomy-eagle_gallery_category .term-parent-wrap').remove();
		});
		</script>
		<?php
}

// ADD CUSTOM ROWS TO DASHBOARD
add_image_size( 'admin-list-thumb', 80, 80, false );

function eagle_gallery_dashboard_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'featured_thumb' => __('Thumbnail', 'eagle'),
        'title' => __('Title', 'eagle'),
       // 'filters' => __('Filters', 'eagle'),
        'date' => 'Date'
    );
    return $columns;
}

function eagle_gallery_dashboard_columns_data( $column, $post_id ) {
    switch ( $column ) {
    case 'featured_thumb':
        echo '<a href="' . get_edit_post_link() . '">';
        echo the_post_thumbnail( 'admin-list-thumb' );
        echo '</a>';
        break;
    }
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_eagle_gallery_posts_columns' , 'eagle_gallery_dashboard_columns' );
    add_action( 'manage_eagle_gallery_posts_custom_column' , 'eagle_gallery_dashboard_columns_data', 10, 2 );
	}
