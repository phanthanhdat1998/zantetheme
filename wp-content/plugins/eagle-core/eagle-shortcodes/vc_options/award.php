<?php
/*---------------------------------------------------------------------------------
AWARD
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_award' );
function eagle_vc_award() {

  vc_map( array(
    "name"	=>	esc_html__( "Award", "zante" ),
    "description"			=> '',
    "base"					=> "zante-award",
    'category'      => esc_html__("Eagle Themes",'zante'),
    "class"					=> "",
    'admin_enqueue_js'		=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
    "params"				=> array(
      array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Award Description",
      "param_name" => "zante_award_text", 
    ),
      array(
        "param_name" => "zante_award_image",
        "description" => esc_html__( "Award Image", "zante" ),
        "type" => "attach_image",
        "save_always" => true
      ),
    )
  ));

}
