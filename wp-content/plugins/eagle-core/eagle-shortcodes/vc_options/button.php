<?php
/*-----------------------------------------------------------
BUTTON
-----------------------------------------------------------*/
add_action( 'vc_before_init', 'eagle_vc_button' );
function eagle_vc_button() {

  vc_map(array(
    'name'                    => "Button",
    "description"			        => '',
    'base'                    => "eagle-shortcode-button",
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => esc_html__("Eagle Themes",'eagle'),
    "icon" 				           	=> "icon-eagle",
    'js_view'                 => '',
    'params'                  => array(

      // Gneral
      array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Button Text",
      "param_name" => "eagle_button_text",
      "value"      => "Button"
    ),

    array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Link",
      "param_name" => "eagle_button_url",
      "value"      => "#"
    ),

      array(
        "type"       => "dropdown",
        "class"      => "",
        "heading"    => "Link target",
        "param_name" => "eagle_button_target",
        "value"      => array(
          "self"  => '_self',
          "blank" => '_blank'
        )
      ),

      array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Before Button Text",
      "param_name" => "eagle_button_before_text",
      "value"      => ""
    ),
      array(
      "type"       => "textfield",
      "class"      => "",
      "heading"    => "Ater Button Text",
      "param_name" => "eagle_button_after_text",
      "value"      => ""
    ),

    array(
      "type"        => "textfield",
      "class"       => "",
      "heading"     => "Icon name",
      "param_name"  => "eagle_button_icon",
      "value"       => "",
      'description' => "Enter icon name (icon list can be found her <a href='https://fontawesome.com/v4.7.0/icons/' target='_blank'>FontAwesome</a>)"
    ),


    // Layout
    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Background Color",
      "param_name" => "eagle_button_bg_color",
      "value"      => '#1dc1f8',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Hover Background Color",
      "param_name" => "eagle_button_hover_bg_color",
      "value"      => '#2c88c0',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Border Color",
      "param_name" => "eagle_button_border_color",
      "value"      => '#1dc1f8',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Hover Border Color",
      "param_name" => "eagle_button_hover_border_color",
      "value"      => '#2c88c0',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Color",
      "param_name" => "eagle_button_color",
      "value"      => '#fff',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Hover Color",
      "param_name" => "eagle_button_hover_color",
      "value"      => '#ffffff',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Icon Background Color",
      "param_name" => "eagle_button_icon_bg_color",
      "value"      => '#1dc1f8',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Icon Hover Background Color",
      "param_name" => "eagle_button_icon_hover_bg_color",
      "value"      => '#ffffff',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Icon Color",
      "param_name" => "eagle_button_icon_color",
      "value"      => '#ffffff',
    ),

    array(
      "type"       => "colorpicker",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Icon Hover Color",
      "param_name" => "eagle_button_icon_hover_color",
      "value"      => '#1dc1f8',
    ),

    array(
      "type"       => "textfield",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Padding Top-Bottom ( only number )",
      "param_name" => "eagle_button_top_bottom_padding",
      "value"      => '10',
    ),

    array(
      "type"       => "textfield",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Padding Left-Right ( only number )",
      "param_name" => "eagle_button_left_right_padding",
      "value"      => '20',
    ),

    array(
      "type"       => "textfield",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Border Width ( only number )",
      "param_name" => "eagle_button_border_width",
      "value"      => '2',
    ),

    array(
      "type"       => "textfield",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Border Radius ( only number )",
      "param_name" => "eagle_button_border_radius",
      "value"      => '2',
    ),

    array(
      "type"       => "textfield",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Font Size ( only number )",
      "param_name" => "eagle_button_font_size",
      "value"      => '15',
    ),

    array(
      "type"       => "dropdown",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Box Shadow",
      "param_name" => "eagle_button_box_shadow",
      "value"      => array(
        "False"  => false,
        "True"   => true
      )
    ),

    array(
      "type"       => "dropdown",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Box Shadow on Hover",
      "param_name" => "eagle_button_box_shadow_hover",
      "value"      => array(
        "False"  => false,
        "True"   => true
      )
    ),

    array(
      "type"       => "dropdown",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Animation on Hover",
      "param_name" => "eagle_button_animation_hover",
      "value"      => array(
        "False"  => false,
        "True"   => true
      )
    ),


    array(
      "type"       => "dropdown",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Full Width",
      "param_name" => "eagle_button_width",
      "value"      => array(
        "False"  => false,
        "True"   => true
      )
    ),

    array(
      "type"       => "dropdown",
      "group"      => "Layout",
      "class"      => "",
      "heading"    => "Align",
      "param_name" => "eagle_button_align",
      "value"      => array(
        "Left"  => 'left',
        "Center"   => 'center',
        "Right"   => 'right',
      )
    ),

    array(
      "type"        => "textfield",
      "group"      => "Layout",
      "class"       => "",
      "heading"     => "Extra class name",
      "param_name"  => "eagle_button_extra_class",
      "value"       => "",
      'description' => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
    ),
    )
  ));

}
