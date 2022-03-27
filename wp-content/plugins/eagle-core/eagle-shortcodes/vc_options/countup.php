<?php
/*---------------------------------------------------------------------------------
COUNT UP
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_countup' );
function eagle_vc_countup() {

  vc_map( array(
    "name"	=>	esc_html__( "Count Up", "zante" ),
    "description"			=> '',
    "base"					=> "zante-countup",
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
      "heading"    => "Text",
      "param_name" => "zante_countup_text",
    ),
      array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Number",
      "param_name" => "zante_countup_number",
    ),
      array(
        "param_name" => "zante_countup_image",
        "description" => esc_html__( "Award Image", "zante" ),
        "type" => "attach_image",
        "save_always" => true
      ),
    )
  ));

}
