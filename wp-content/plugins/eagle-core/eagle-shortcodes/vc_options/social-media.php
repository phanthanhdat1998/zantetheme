<?php
/*---------------------------------------------------------------------------------
SOCIAL MEDIA
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_social_media' );
function eagle_vc_social_media() {
  vc_map( array(
    "name"	=>	esc_html__( "Social Media", "zante" ),
    "description"			=> '',
    "base"					=> "zante-social-media",
    'category'      => esc_html__("Eagle Themes",'zante'),
    "class"					=> "",
    'admin_enqueue_js'		=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
    "params"				=> array(
      array(
        "param_name" => "zante_social_media_facebook",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Facebook Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_twitter",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Twitter Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_google_plus",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Google+ Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_pinterest",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Pinterest Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_linkedin",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Linkedin Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_youtube",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Youtube Link:", "zante" ),
        "save_always" => true
      ),
      array(
        "param_name" => "zante_social_media_instagram",
        "type" => "textfield",
        "value" => '',
        "heading" => esc_html__("Instagram Link:", "zante" ),
        "save_always" => true
      ),
    )
  ) );


}
