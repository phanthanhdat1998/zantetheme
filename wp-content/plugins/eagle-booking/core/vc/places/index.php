<?php
/*---------------------------------------------------------------------------------
PLACES
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_vc_places') ) {

  add_action( 'vc_before_init', 'eb_vc_places' );
  function eb_vc_places() {

    vc_map( array(
    	"name"	=>	esc_html__( "Places", "eagle-booking" ),
    	"description"			=> '',
    	"base"					=> "eb-places",
    	'category'      => esc_html__("Eagle Themes",'eagle-booking'),
    	"class"					=> "",
    	'admin_enqueue_js'		=> "",
    	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    	"icon" 					=> "icon-eagle",
    	"params"				=> array(

    	array(
    		"param_name" => "orderby",
    		"type" => "dropdown",
    		"value" => array('None' => 'none', 'ID' => 'ID', 'Title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
    		"heading" => esc_html__("Order By:", "eagle-booking"),
    		"description" => '',
    		"save_always" => true,
    	),
    	array(
    		"param_name" => "order",
    		"type" => "dropdown",
    		"value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
    		"heading" => esc_html__("Order:", "eagle-booking"),
    		"description" => '',
    		"save_always" => true,
    	),
    	array(
    		"param_name" => "offset",
    		"type" => "textfield",
    		"value" => "",
    		"heading" => esc_html__("Offset:", "eagle-booking"),
    		"description" => "",
    		"save_always" => true
    	)

    )
    ));

  }

}


/*---------------------------------------------------------------------------------
PLACES GRID
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_vc_places_grid') ) {

	add_action( 'vc_before_init', 'eb_vc_places_grid' );
	function eb_vc_places_grid() {
	vc_map( array(
		"name"	=>	esc_html__( "Places Grid", "eagle-booking" ),
		"description"			=> '',
		"base"					=> "eb-places-grid",
		'category'      => esc_html__("Eagle Themes",'eagle-booking'),
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
		'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
		"icon" 					=> "icon-eagle",
		"params"				=> array(

		array(
			"param_name" => "places_limit",
			"type" => "textfield",
			"value" => "6",
			"heading" => esc_html__("Items:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),
		array(
			"param_name" => "places_per_row",
			"type" => "dropdown",
			"value" => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '6' => '6'),
			"default" => "3",
			"heading" => esc_html__("Items per row:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),
		array(
			"param_name" => "orderby",
			"type" => "dropdown",
			"value" => array('None' => 'none', 'ID' => 'ID', 'Title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
			"heading" => esc_html__("Order By:", "eagle-booking"),
			"description" => '',
			"save_always" => true,
		),
		array(
			"param_name" => "order",
			"type" => "dropdown",
			"value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
			"heading" => esc_html__("Order:", "eagle-booking"),
			"description" => '',
			"save_always" => true,
		),
		array(
			"param_name" => "offset",
			"type" => "textfield",
			"value" => "",
			"heading" => esc_html__("Offset:", "eagle-booking"),
			"description" => "",
			"save_always" => true
		)

	)
	));


	}

}

// Include Palces Layout
foreach ( glob ( plugin_dir_path( __FILE__ ) . "layout/*.php" ) as $file ){
  include_once $file;
}
