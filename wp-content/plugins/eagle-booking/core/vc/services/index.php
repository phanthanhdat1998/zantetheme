<?php
/*---------------------------------------------------------------------------------
SERVICES GRID
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_room_services' );
function eagle_vc_room_services() {

  vc_map( array(
    "name"	=>	esc_html__( "Room Services", "eagle-booking" ),
    "description"			=> '',
    "base"					=> "eb-services",
    'category'      => esc_html__("Eagle Themes",'eagle-booking'),
    "class"					=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
    "params"				=> array(

    array(
      "param_name" => "posts_limit",
      "type" => "textfield",
      "value" => "3",
      "heading" => esc_html__("Items", "eagle-booking"),
      "description" => "",
      "save_always" => true,
    ),

    array(
      "param_name" => "posts_per_row",
      "type" => "dropdown",
      "value" => array('2' => '2', '3' => '3', '4' => '4', '6' => '6'),
      "default" => "3",
      "heading" => esc_html__("Items per Row", "eagle-booking"),
      "description" => "",
      "save_always" => true,
    ),

    array(
      "param_name" => "type",
      "type" => "dropdown",
      "value" => array(
        'All' => 'all',
        'Normal' => 'normal',
        'Additional' => 'additional'
      ),
      "default" => "all",
      "heading" => esc_html__("Services Type", "eagle-booking"),
      "description" => "",
      "save_always" => true,
    ),

    array(
      "param_name" => "orderby",
      "type" => "dropdown",
      "value" => array('None' => 'none', 'ID' => 'ID', 'Title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
      "heading" => esc_html__("Order By", "eagle-booking"),
      "description" => '',
      "save_always" => true,
    ),

    array(
      "param_name" => "order",
      "type" => "dropdown",
      "value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
      "heading" => esc_html__("Order", "eagle-booking"),
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

  // INCLUDE ROOM SERVICES LAYOUT
  foreach ( glob ( plugin_dir_path( __FILE__ ) . "layout/*.php" ) as $file ){
  	include_once $file;
  }
