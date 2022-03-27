<?php
#-----------------------------------------------------------------#
# Default theme constants
#-----------------------------------------------------------------#
define('THEME_NAME', 'Zante');
define('ZANTE_THEME_VERSION', '1.3.5.1');

#-----------------------------------------------------------------#
# Localization
#-----------------------------------------------------------------#
load_theme_textdomain( 'zante', get_template_directory()  . '/languages' );

#-----------------------------------------------------------------#
# After Theme Setup
#-----------------------------------------------------------------#
add_action( 'after_setup_theme', 'zante_theme_setup' );

function zante_theme_setup() {

	/* Add thumbnails support */
	add_theme_support( 'post-thumbnails' );

	//add_theme_support( 'responsive-embeds' );

	/* Add image sizes */
	$image_sizes = zante_get_image_sizes();
	if ( !empty( $image_sizes ) ) {
		foreach ( $image_sizes as $id => $size ) {
			add_image_size( $id, $size['w'], $size['h'], $size['crop'] );
		}
	}

	/* Add theme support for title tag */
	add_theme_support( 'title-tag' );

	/* Support for HTML5 */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption') );

	add_theme_support( 'customize-selective-refresh-widgets' );

	/* Automatic Feed Links */
	add_theme_support( 'automatic-feed-links' );

	/* Support images for Gutenberg */
	add_theme_support('align-wide');

}

/* Load frontend scripts */
include_once get_template_directory() . '/core/enqueue.php';

/* Load helpers scripts */
include_once get_template_directory() . '/core/helpers.php';

/* Sidebars */
include_once get_template_directory() . '/core/sidebars.php';

/* Menus */
include_once get_template_directory() . '/core/menus.php';


/* Load admin scripts */
if ( is_admin() ) {

	/* Enque Required Files */
	include_once get_template_directory() . '/core/admin/enqueue.php';

	/* License */
	// /include_once get_template_directory() . '/core/admin/license.php';

	/* Theme Options */
	include_once get_template_directory() . '/core/admin/theme-options.php';

	/* Load Metaboxes */
	include_once get_template_directory() . '/core/admin/metaboxes.php';

	/* Include plugins - TGM */
	include_once get_template_directory() . '/core/admin/install-plugins.php';

	/* Demo importer panel */
	include_once ( get_template_directory() . '/core/admin/demo-importer.php' );

	/* Include AJAX action handlers */
	include_once get_template_directory() . '/core/admin/ajax.php';

}
