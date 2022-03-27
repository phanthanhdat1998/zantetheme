<?php
/*---------------------------------------------------------------------------------
	RESTAURANT MENU
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_restaurant_menu' );
function eagle_vc_restaurant_menu() {

  vc_map( array(
  	"name"					=> esc_html__( "Restaurant Menu", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-restaurant-menu",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(
  		array(
  			"param_name" => "restaurant_menu_title",
  			"type" => "textfield",
  			"value" => '',
  			"default" => '',
  			"heading" => esc_html__("Title", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),
      array(
        "param_name" => "restaurant_menu_desc",
        "type" => "textfield",
        "value" => '',
        "default" => '',
        "heading" => esc_html__("Description", "zante" ),
        "description" => "",
        "save_always" => true
      ),
      array(
        "param_name" => "restaurant_menu_price",
        "type" => "textfield",
        "value" => '',
        "default" => '',
        "heading" => esc_html__("Price", "zante" ),
        "description" => "",
        "save_always" => true
      ),
      array(
        "param_name" => "restaurant_menu_image",
        "description" => esc_html__( "Image", "zante" ),
        "type" => "attach_image",
        "save_always" => true
      ),

  	)

  ));

}
