<?php
/*---------------------------------------------------------------------------------
 IMAGE GALLERY
-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_image_gallery' );
function eagle_vc_image_gallery() {

  vc_map( array(
   "name"					=> esc_html__( "Image Gallery", "zante" ),
   "description"			=> '',
   "base"					=> "zante-image-gallery",
   'category'      => esc_html__("Eagle Themes",'zante'),
   "class"					=> "",
   'admin_enqueue_js'		=> "",
   'admin_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
   'front_enqueue_css'		=> get_template_directory_uri()."/assets/css/admin/global.css",
   "icon" 					=> "icon-eagle",
   "params"				=> array(
     array(
       "heading"    => "Images",
       "param_name" => "image_gallery_images",
       "description" => esc_html__( "Image", "zante" ),
       "type" => "attach_images",
       "save_always" => true
     ),

     array(
       "param_name" => "image_gallery_per_row",
       "type" => "dropdown",
       "value" => array('2' => '2', '3' => '3', '4' => '4', '6' => '6'),
       "default" => "3",
       "heading" => esc_html__("Items per row:", "zante"),
       "description" => "",
       "save_always" => true,
     ),

     array(
       "type"       => "dropdown",
       "class"      => "",
       "heading"    => "On click action",
       "param_name" => "image_gallery_action",
       "value"      => array(
         "Magnific PopUp"  => 'magnific',
         "None" => 'none'
       )
     ),

     // Required Field
     //   array(
     //   'param_name' => 'custom_links',
     //   'type' => 'textfield',
     //   'heading' => __( 'Custom links', 'zante' ),
     //   'dependency' => array(
     //     'element' => 'image_gallery_action',
     //     'value' => array( 'none' ),
     //   ),
     // ),


   )

  ));

}
