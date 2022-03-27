<?php
/*---------------------------------------------------------------------------------
ROOMS VC ELEMENT SETTINGS/OPTIONS - Deprecated
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_booking_rooms_vc' );
function eagle_booking_rooms_vc() {

/*---------------------------------------------------------------------------------
  ROOMS NORMAL VIEW VC ELEMENT
-----------------------------------------------------------------------------------*/
  vc_map( array(
  	"name"	=>	esc_html__( "Rooms (Deprecated)", "eagle-booking" ),
  	"description"			=> '',
  	"base"					=> "eagle-booking-rooms",
  	'category'      => esc_html__("Eagle Themes",'eagle-booking'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
	"deprecated"            => true,
  	"params"				=> array(

		array(
			"param_name" => "branch_id",
			"type" => "dropdown",
			"value" => eb_sort_by_branch(),
			"heading" => __("Branch:", "eagle-booking"),
			"description" => '',
			"save_always" => true,
		),

		array(
			"param_name" => "rooms_limit",
			"type" => "textfield",
			"value" => "6",
			"heading" => esc_html__("Items:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),
		array(
			"param_name" => "rooms_per_row",
			"type" => "dropdown",
			"value" => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'6' => '6'
			),
			"default" => "3",
			"heading" => esc_html__("Items per row:", "eagle-booking"),
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
			"value" => array(
				'ASC' => 'ASC',
				'DESC' => 'DESC'
			),
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
		),

 	 )

  ));

/*---------------------------------------------------------------------------------
  ROOMS LIST VIEW VC ELEMENT
-----------------------------------------------------------------------------------*/
  vc_map( array(
  	"name"	=>	esc_html__( "Rooms List (Deprecated)", "eagle-booking" ),
  	"description"			=> '',
  	"base"					=> "eagle-booking-rooms-list",
  	'category'      => esc_html__("Eagle Themes",'eagle-booking'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
	"deprecated"            => true,
  	"params"				=> array(

		array(
			"param_name" => "branch_id",
			"type" => "dropdown",
			"value" => eb_sort_by_branch(),
			"heading" => __("Branch:", "eagle-booking"),
			"description" => '',
			"save_always" => true,
		),

		array(
			"param_name" => "rooms_limit",
			"type" => "textfield",
			"value" => "6",
			"heading" => esc_html__("Items:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),

		array(
			"param_name" => "branch",
			"type" => "dropdown",
			"value" => 'eagle_branch',
			"heading" => esc_html__("Branch:", "eagle-booking"),
			"description" => '',
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
			"value" => array(
				'ASC' => 'ASC',
				'DESC' => 'DESC'
			),
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
		),

  )
  ));

  /*---------------------------------------------------------------------------------
  ROOMS GRID VC ELEMENT SETTINGS
  -----------------------------------------------------------------------------------*/
  vc_map( array(
    "name"	=>	esc_html__( "Rooms Grid (Deprecated)", "eagle-booking" ),
    "description"			=> '',
    "base"					=> "eagle-booking-rooms-grid",
    'category'      => esc_html__("Eagle Themes",'eagle-booking'),
    "class"					=> "",
    'admin_enqueue_js'		=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
	"deprecated"            => true,
    "params"				=> array(

		array(
			"param_name" => "branch_id",
			"type" => "dropdown",
			"value" => eb_sort_by_branch(),
			"heading" => __("Branch:", "eagle-booking"),
			"description" => '',
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
			"value" => array(
				'ASC' => 'ASC',
				'DESC' => 'DESC'
			),
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
		),

  	)
));


  /*---------------------------------------------------------------------------------
  ROOMS CAROUSEL VC ELEMENTS SETTINGS
  -----------------------------------------------------------------------------------*/
  vc_map( array(
  	"name"	=>	esc_html__( "Rooms Carousel (Deprecated)", "eagle-booking" ),
  	"description"			=> '',
  	"base"					=> "eagle-booking-rooms-carousel",
  	'category'      => esc_html__("Eagle Themes",'eagle-booking'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
	"deprecated"            => true,
  	"params"				=> array(

		array(
			"param_name" => "branch_id",
			"type" => "dropdown",
			"value" => eb_sort_by_branch(),
			"heading" => __("Branch:", "eagle-booking"),
			"description" => '',
			"save_always" => true,
		),

		array(
			"param_name" => "rooms_limit",
			"type" => "textfield",
			"value" => "6",
			"heading" => esc_html__("Items:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),

		array(
			"param_name" => "rooms_per_view",
			"type" => "dropdown",
			"value" => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5'
			),
			"default" => "3",
			"heading" => esc_html__("Items per View:", "eagle-booking"),
			"description" => "",
			"save_always" => true,
		),

		array(
			"type"       => "dropdown",
			"class"      => "",
			"heading"    => "Navigation Buttons",
			"param_name" => "gallery_carousel_nav",
			"value"      => array(
				"True"   => true,
				"False"  => false,
			),
			"default" => true,
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
			"value" => array(
				'ASC' => 'ASC',
				'DESC' => 'DESC'
			),
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
		),
  	)

  ));


}

  foreach ( glob ( plugin_dir_path( __FILE__ ) . "layout/*.php" ) as $file ){
	include_once $file;
}