<?php
/*---------------------------------------------------------------------------------
	MAP
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_map' );
function eagle_vc_map() {

  vc_map( array(
  	"name"					=> esc_html__( "Google Map", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-google-map",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(
  		array(
  			"param_name" => "map_latitude",
  			"type" => "textfield",
  			"value" => '37.8614626',
  			"default" => '37.8614626',
  			"heading" => wp_kses(sprintf(__('Latitude <a href="%s" target="_blank">How to get Latitude</a>.', 'zante'), 'https://support.google.com/maps/answer/18539'), wp_kses_allowed_html('post')),
  			"description" => "",
  			"save_always" => true
  		),
  		array(
  			"param_name" => "map_longitude",
  			"type" => "textfield",
  			"value" => '20.625886',
  			"default" => '20.625886', 
  			"heading" => wp_kses(sprintf(__('Longitude <a href="%s" target="_blank">How to get Longitude</a>.', 'zante'), 'https://support.google.com/maps/answer/18539'), wp_kses_allowed_html('post')),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_height",
  			"type" => "textfield",
  			"value" => '400',
  			"heading" => esc_html__("Height", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_zoom",
  			"type" => "textfield",
  			"value" => '15',
  			"heading" => esc_html__("Zoom", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_pin",
  			"description" => esc_html__( "Pin", "zante" ),
  			"value" => get_template_directory_uri()."/assets/images/map_marker.png",
  			"default" => get_template_directory_uri()."/assets/images/map_marker.png",
  			"type" => "attach_image",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_title",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Hotel Name", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_address",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Hotel Address", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "map_desc",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Hotel Description", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

      array(
        "type"       => "dropdown",
        "class"      => "",
        "heading"    => "Streetview Button",
        "param_name" => "map_streetview_button",
        "value"      => array(
          "True"   => true,
          "False"  => false,
        ),
        "default" => true,
        "save_always" => true,
      ),

  	)

  ));

}
