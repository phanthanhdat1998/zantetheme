<?php
/*---------------------------------------------------------------------------------
Branches VC Elements
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_vc_branches') ) {

	add_action( 'vc_before_init', 'eb_vc_branches' );
	function eb_vc_branches() {
		vc_map( array(
			"name"	=>	esc_html__( "Branches", "eagle-booking" ),
			"description"			=> '',
			"base"					=> "eb-branches",
			'category'      => esc_html__("Eagle Themes",'eagle-booking'),
			"class"					=> "",
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
			'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
			"icon" 					=> "icon-eagle",
			"params"				=> array(

				array(
					"param_name" => "branches_limit",
					"type" => "textfield",
					"value" => "3",
					"heading" => esc_html__("Items:", "eagle-booking"),
					"description" => "",
					"save_always" => true,
				),

				array(
					"param_name" => "orderby",
					"type" => "dropdown",
					"value" => array(
						'None' => 'none',
						'ID' => 'ID',
						'Title' => 'title',
						'Date' => 'date',
						'Random' => 'rand',
						'Menu Order' => 'menu_order'
					),
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

// Branches Layout
foreach ( glob ( plugin_dir_path( __FILE__ ) . "layout/*.php" ) as $file ){
  include_once $file;
}
