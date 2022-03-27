<?php
/*---------------------------------------------------------------------------------
	VIDEO
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_video' );
function eagle_vc_video() {

  vc_map( array(
  	"name"					=> esc_html__( "Video", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-video",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(
  		array(
  			"param_name" => "video_url",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Video URL (YouTube or Vimeo)", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),
  	)
  ) );

}
