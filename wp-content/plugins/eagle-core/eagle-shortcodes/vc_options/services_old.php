<?php
/*---------------------------------------------------------------------------------
	SERVICES
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_services' );
function eagle_vc_services() {

  vc_map( array(
  	"name"					=> esc_html__( "Old Services", "zante" ),
  	"description"			=> '',
    "deprecated"    => '5.6',
  	"base"					=> "zante-services",
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

  		// SLIDE 1
  		array(
  			"param_name" => "services_tab_1_title",
  			"group" => "Slide 1",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Title", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "services_tab_1_desc",
  			"group" => "Slide 1",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Description", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		// array(
  		// 	'type' => 'dropdown',
  		// 	'heading' => __( 'Icon library', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'value' => array(
  		// 		__( 'Font Awesome', 'zante' ) => 'fontawesome',
  		// 		__( 'Open Iconic', 'zante' ) => 'openiconic',
  		// 		__( 'Typicons', 'zante' ) => 'typicons',
  		// 		__( 'Entypo', 'zante' ) => 'entypo',
  		// 		__( 'Linecons', 'zante' ) => 'linecons',
  		// 	),
  		// 	'admin_label' => true,
  		// 	'param_name' => 'type',
  		// 	'description' => __( 'Select icon library.', 'zante' ),
  		// ),
  		// array(
  		// 	'type' => 'iconpicker',
  		// 	'heading' => __( 'Icon', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'param_name' => 'services_tab_1_icon_fontawesome',
  		// 	'value' => 'fa fa-adjust', // default value to backend editor admin_label
  		// 	'settings' => array(
  		// 		'emptyIcon' => false,
  		// 		// default true, display an "EMPTY" icon?
  		// 		'iconsPerPage' => 4000,
  		// 		// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
  		// 	),
  		// 	'dependency' => array(
  		// 		'element' => 'type',
  		// 		'value' => 'fontawesome',
  		// 	),
  		// 	'description' => __( 'Select icon from library.', 'zante' ),
  		// ),
  		// array(
  		// 	'type' => 'iconpicker',
  		// 	'heading' => __( 'Icon', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'param_name' => 'icon_openiconic',
  		// 	'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
  		// 	'settings' => array(
  		// 		'emptyIcon' => false, // default true, display an "EMPTY" icon?
  		// 		'type' => 'openiconic',
  		// 		'iconsPerPage' => 4000, // default 100, how many icons per/page to display
  		// 	),
  		// 	'dependency' => array(
  		// 		'element' => 'type',
  		// 		'value' => 'openiconic',
  		// 	),
  		// 	'description' => __( 'Select icon from library.', 'zante' ),
  		// ),
  		// array(
  		// 	'type' => 'iconpicker',
  		// 	'heading' => __( 'Icon', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'param_name' => 'icon_typicons',
  		// 	'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
  		// 	'settings' => array(
  		// 		'emptyIcon' => false, // default true, display an "EMPTY" icon?
  		// 		'type' => 'typicons',
  		// 		'iconsPerPage' => 4000, // default 100, how many icons per/page to display
  		// 	),
  		// 	'dependency' => array(
  		// 		'element' => 'type',
  		// 		'value' => 'typicons',
  		// 	),
  		// 	'description' => __( 'Select icon from library.', 'zante' ),
  		// ),
  		// array(
  		// 	'type' => 'iconpicker',
  		// 	'heading' => __( 'Icon', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'param_name' => 'icon_entypo',
  		// 	'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
  		// 	'settings' => array(
  		// 		'emptyIcon' => false, // default true, display an "EMPTY" icon?
  		// 		'type' => 'entypo',
  		// 		'iconsPerPage' => 4000, // default 100, how many icons per/page to display
  		// 	),
  		// 	'dependency' => array(
  		// 		'element' => 'type',
  		// 		'value' => 'entypo',
  		// 	),
  		// ),
  		// array(
  		// 	'type' => 'iconpicker',
  		// 	'heading' => __( 'Icon', 'zante' ),
  		// 	"group" => "Slide 1",
  		// 	'param_name' => 'icon_linecons',
  		// 	'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
  		// 	'settings' => array(
  		// 		'emptyIcon' => false, // default true, display an "EMPTY" icon?
  		// 		'type' => 'linecons',
  		// 		'iconsPerPage' => 4000, // default 100, how many icons per/page to display
  		// 	),
  		// 	'dependency' => array(
  		// 		'element' => 'type',
  		// 		'value' => 'linecons',
  		// 	),
  		// 	'description' => __( 'Select icon from library.', 'zante' ),
  		// ),

      array(
        "param_name" => "services_tab_1_icon",
        "heading" => esc_html__("Icon", "zante" ),
        "description" => esc_html__( "Select Icon", "zante" ),
        "group" => "Slide 1",
        "type" => "attach_image",
        "save_always" => true
      ),

  		array(
  			"param_name" => "services_tab_1_image",
  			"heading" => esc_html__("Image", "zante" ),
  			"description" => esc_html__( "Select Image", "zante" ),
  			"group" => "Slide 1",
  			"type" => "attach_image",
  			"save_always" => true
  		),

  		// SLIDE 2
  		array(
  			"param_name" => "services_tab_2_title",
  			"group" => "Slide 2",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Title", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "services_tab_2_desc",
  			"group" => "Slide 2",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Description", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

      array(
        "param_name" => "services_tab_2_icon",
        "heading" => esc_html__("Icon", "zante" ),
        "description" => esc_html__( "Select Icon", "zante" ),
        "group" => "Slide 2",
        "type" => "attach_image",
        "save_always" => true
      ),

  		array(
  			"param_name" => "services_tab_2_image",
  			"heading" => esc_html__("Image", "zante" ),
  			"description" => esc_html__( "Select Image", "zante" ),
  			"group" => "Slide 2",
  			"type" => "attach_image",
  			"save_always" => true
  		),

  		// SLIDE 3
  		array(
  			"param_name" => "services_tab_3_title",
  			"group" => "Slide 3",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Title", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "services_tab_3_desc",
  			"group" => "Slide 3",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Description", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

      array(
        "param_name" => "services_tab_3_icon",
        "heading" => esc_html__("Icon", "zante" ),
        "description" => esc_html__( "Select Icon", "zante" ),
        "group" => "Slide 3",
        "type" => "attach_image",
        "save_always" => true
      ),

  		array(
  			"param_name" => "services_tab_3_image",
  			"heading" => esc_html__("Image", "zante" ),
  			"description" => esc_html__( "Select Image", "zante" ),
  			"group" => "Slide 3",
  			"type" => "attach_image",
  			"save_always" => true
  		),

  		// SLIDE 4
  		array(
  			"param_name" => "services_tab_4_title",
  			"group" => "Slide 4",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Title", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  		array(
  			"param_name" => "services_tab_4_desc",
  			"group" => "Slide 4",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Description", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),
      array(
        "param_name" => "services_tab_4_icon",
        "heading" => esc_html__("Icon", "zante" ),
        "description" => esc_html__( "Select Icon", "zante" ),
        "group" => "Slide 4",
        "type" => "attach_image",
        "save_always" => true
      ),

  		array(
  			"param_name" => "services_tab_4_image",
  			"heading" => esc_html__("Image", "zante" ),
  			"description" => esc_html__( "Select Image", "zante" ),
  			"group" => "Slide 4",
  			"type" => "attach_image",
  			"save_always" => true
  		),

  	)

  ) );

}
