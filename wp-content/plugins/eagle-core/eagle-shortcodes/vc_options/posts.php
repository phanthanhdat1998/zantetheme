<?php
/*---------------------------------------------------------------------------------
	BLOG POSTS
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_blog_posts' );
function eagle_vc_blog_posts() {

  vc_map( array(
  	"name"					=> esc_html__( "Blog Posts", "zante" ),
  	"description"			=> '',
  	"base"					=> "zante-blog-posts",
  	'category'      => esc_html__("Eagle Themes",'zante'),
  	"class"					=> "",
  	'admin_enqueue_js'		=> "",
  	'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
  	"icon" 					=> "icon-eagle",
  	"params"				=> array(
  		array(
  			"param_name" => "offset",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Offset", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),
  		array(
  			"param_name" => "posts_limit",
  			"type" => "textfield",
  			"value" => '',
  			"heading" => esc_html__("Number of posts to show", "zante" ),
  			"description" => "",
  			"save_always" => true
  		),

  	)
  ) );

}
