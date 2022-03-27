<?php
/*---------------------------------------------------------------------------------
	SERVICES
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_services_v2' );
function eagle_vc_services_v2() {

  vc_map( array(
  	"name"					=> esc_html__( "Services", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-services-v2",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(

  		// GENERAL
  		array(
  			"type"       => "dropdown",
  			"class"      => "",
  			"heading"    => "Autoplay",
  			"param_name" => "services_tab_autoplay",
  			"value"      => array(
  				"True"   => true,
  				"False"  => false,
  			),
  		),

  		array(
  			"type"       => "dropdown",
  			"class"      => "",
  			"heading"    => "Transition",
  			"param_name" => "services_tab_transition",
  			"value"      => array(
  				"Slide"   => '',
  				"Fade"  => 'fade',
  			),
  		),

		// SLIDES
    array(
    'type' => 'param_group',
     'value' => '',
     "group" => "Slides",
     'heading' =>  __( 'Slides Items', 'zante' ),
     "param_name" => "services_slides",
     "save_always" => true,
      // Note params is mapped inside param-group:
      "params" => array(

          array(
            "param_name" => "service_title",
            "type" => "textfield",
            "value" => '',
            "heading" => esc_html__("Title", "zante" ),
            "description" => "",
            "save_always" => true
          ),

          array(
            "param_name" => "service_desc",
            "type" => "textfield",
            "value" => '',
            "heading" => esc_html__("Description", "zante" ),
            "description" => "",
            "save_always" => true
          ),

          array(
            "param_name" => "service_icon",
            "heading" => esc_html__("Icon", "zante" ),
            "description" => esc_html__( "Select Icon", "zante" ),
            "type" => "attach_image",
            "save_always" => true
          ),

          array(
            "param_name" => "service_image",
            "heading" => esc_html__("Image", "zante" ),
            "description" => esc_html__( "Select Image", "zante" ),
            "type" => "attach_image",
            "save_always" => true
          ),
     )


  ),


)

) );

}
