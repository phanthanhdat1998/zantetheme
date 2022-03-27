<?php
/*---------------------------------------------------------------------------------
IMAGE
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_image' );
function eagle_vc_image() {

  vc_map( array(
    "name"	=>	esc_html__( "Image", "zante" ),
    "description"			=> '',
    "base"					=> "zante-image",
    'category'      => esc_html__("Eagle Themes",'zante'),
    "class"					=> "",
    'admin_enqueue_js'		=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
    "params"				=> array(
      array(
        "param_name" => "zante_image_front_image",
        "description" => esc_html__( "Front Image", "zante" ),
        "type" => "attach_image",
        "save_always" => true
      ),

      array(
        "param_name" => "zante_image_back_image",
        "description" => esc_html__( "Back Image", "zante" ),
        "type" => "attach_image",
        "save_always" => true
      ),
    )
  ));

}
