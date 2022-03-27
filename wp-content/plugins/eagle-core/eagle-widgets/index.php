<?php

/* --------------------------------------------------------------------------
 * Register Widgets
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
add_action( 'widgets_init', 'zante_register_widgets' );

if ( !function_exists( 'zante_register_widgets' ) ) :
	function zante_register_widgets() {

    // include all required widgets
    foreach ( glob ( plugin_dir_path( __FILE__ ) . "widgets/*.php" ) as $file ){
        include_once $file;
    }

		register_widget( 'Zante_About_Footer_Widget' );
		register_widget( 'Zante_Contact_Footer_Widget' );
		register_widget( 'Zante_Category_Widget' );
		register_widget( 'Zante_Recent_Posts_Widget' );

	}
endif;
