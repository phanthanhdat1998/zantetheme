<?php
/*---------------------------------------------------------------------------------
	SECTION TITLE
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_section_title' );
function eagle_vc_section_title() {

  vc_map( array(
  	"name"	=>	esc_html__( "Section Title", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-section-title",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(
  		array(
  			"param_name" => "zante_section_title",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Title:", "zante" ),
  			"description" => esc_html__( "Enter section title", "zante" ),
  			"save_always" => true
  		),
  		array(
  			"param_name" => "zante_section_subtitle",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Sub Title:", "zante" ),
  			"description" => esc_html__( "Enter section sub title", "zante" ),
  			"save_always" => true
  		),
  		array(
  			"param_name" => "zante_section_title_align",
  			"type" => "dropdown",
  			"value" => array(
                    'Center Align' => 'text-center',
                    'Left Align' => 'text-left',
                    'Right Align' => 'text-right' ),
  			"heading" => esc_html__("Align:", "zante" ),
  			"save_always" => true
  		),
  		array(
  			"param_name" => "zante_section_title_color",
  			"type" => "dropdown",
  			"value" => array(
  				'Default' => '',
  				'Light' => 'mt_white',
  				'Dark' => 'mt_dark'
  			),
  			"heading" => esc_html__("Title Color Scheme", "zante" ),
  			"save_always" => true
  		),
  		array(
  			"param_name" => "zante_section_title_wave",
  			"type" => "dropdown",
  			"value" => array(
          'False' => '',
  				'True' => 'mt_wave'
  			),
  			"heading" => esc_html__("Display Wave", "zante" ),
  			"save_always" => true
  		),
  	)
  ) );


}
