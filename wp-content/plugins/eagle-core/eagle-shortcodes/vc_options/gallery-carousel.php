<?php
/*---------------------------------------------------------------------------------
GALLERY CAROUSEL
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_gallery_carousel' );
function eagle_vc_gallery_carousel() {

  vc_map( array(
    "name"	=>	esc_html__( "Gallery Carousel", "zante" ),
    "description"			=> '',
    "base"					=> "zante-gallery-carousel",
    'category'      => esc_html__("Eagle Themes",'zante'),
    "class"					=> "",
    'admin_enqueue_js'		=> "",
    'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
    "icon" 					=> "icon-eagle",
    "params"				=> array(

    array(
      "param_name" => "gallery_carousel_limit",
      "type" => "textfield",
      "value" => "3",
      "heading" => esc_html__("Items:", "zante"),
      "description" => "",
      "save_always" => true,
    ),
    array(
      "param_name" => "gallery_carousel_per_view",
      "type" => "dropdown",
      "value" => array('3' => '3', '4' => '4', '5' => '5', '6' => '6'),
      "default" => "5",
      "heading" => esc_html__("Items per View:", "zante"),
      "description" => "",
      "save_always" => true,
    ),

    array(
      "type"       => "dropdown",
      "class"      => "",
      "heading"    => "Details",
      "param_name" => "gallery_carousel_details",
      "value"      => array(
        "True"   => true,
        "False"  => false,
      ),
      "default" => true,
    ),

    array(
      "param_name" => "orderby",
      "type" => "dropdown",
      "value" => array('None' => 'none', 'ID' => 'ID', 'Title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
      "heading" => esc_html__("Order By:", "zante"),
      "description" => '',
      "save_always" => true,
    ),
    array(
      "param_name" => "order",
      "type" => "dropdown",
      "value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
      "heading" => esc_html__("Order:", "zante"),
      "description" => '',
      "save_always" => true,
    ),
    array(
      "param_name" => "offset",
      "type" => "textfield",
      "value" => "",
      "heading" => esc_html__("Offset:", "zante"),
      "description" => "",
      "save_always" => true
    )

  )
  ));


}
