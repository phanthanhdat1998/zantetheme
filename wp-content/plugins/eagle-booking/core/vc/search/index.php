<?php
/*-----------------------------------------------------------------------------------*/
/*	SEARCH FORM VC ELEMENT SETTINGS
/*-----------------------------------------------------------------------------------*/
function eb_search_form_shortcode($atts, $content = null) {

   $atts = shortcode_atts(

      array(

         'eagle_booking_search_form_layout' => '',
         'eagle_booking_search_form_class' => '',
         'branches' => ''

      ),

   $atts);

   ob_start();

   // Include form parameters
   include_once EB_PATH . '/core/admin/form-parameters.php';

   // Custom Class
   $eb_search_form_class = $atts['eagle_booking_search_form_class'];

   // Layout
   $eb_layout = $atts['eagle_booking_search_form_layout'];
   if ( empty($eb_layout) ) $eb_layout = "vertical";

   // Branch
   $include_branches = $atts['branches'];
   if ( $include_branches === 'false' ) $include_branches = false;

   // Include Selected Layout
   include 'layout/'.$eb_layout.'.php';

   $result = ob_get_contents();

   ob_end_clean();

   return $result;

}

  // Depracated
  add_shortcode('eagle_booking_search_form', 'eb_search_form_shortcode');

  // New Shortcode
  add_shortcode('eb_search_form', 'eb_search_form_shortcode');




/*-----------------------------------------------------------------------------------*/
/*	SEARCH FORM VC ELEMENT
/* @since 1.0.0
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'eb_vc_search_form' );

function eb_vc_search_form() {

   vc_map( array(
      "name" => __( "Booking Search Form", "eagle-booking" ),
      "base" => "eagle_booking_search_form",
      'show_settings_on_create' => true,
      "icon" => "icon-eagle",
      "class" => "",
      'category'      => esc_html__("Eagle Themes",'eagle-booking'),
      "params" => array(

          array(
           'type' => 'dropdown',
            'heading' => __( 'Layout', 'eagle-booking' ),
            'param_name' => 'eagle_booking_search_form_layout',
            "value" => array(
               'Vertical' => 'vertical',
               'Horizontal' => 'horizontal',
               'Horizontal Style 2' => 'horizontal-2',
               'Horizontal Style 3' => 'horizontal-3'
            ),
            'description' => __( "Choose the layout", "eagle-booking" ),
            "save_always" => true,
         ),

         array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Custom class", "eagle-booking" ),
            "param_name" => "eagle_booking_search_form_class",
         )
      )
   ) );
}
