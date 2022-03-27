<?php
/**
 * VC Rooms Shortcode Options
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/room-grid.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;


add_action( 'vc_before_init', 'eb_vc_rooms_shortcode' );

function eb_vc_rooms_shortcode() {

    vc_map( array(
        "name"	=>	esc_html__( "Rooms", "eagle-booking" ),
        "description"			=> '',
        "base"					=> "eb_rooms",
        'category'      => esc_html__("Eagle Booking",'eagle-booking'),
        "class"					=> "",
        'admin_enqueue_js'		=> "",
        "icon" 					=> "icon-eagle",
        "params"				=> array(

            array(
                "param_name" => "view",
                "type" => "dropdown",
                "value" => array(
                    'Normal' => 'normal',
                    'Grid' => 'grid',
                    'List' => 'list',
                    'Carousel' => 'carousel'
                ),
                "default" => "3",
                "heading" => esc_html__("View", "eagle-booking"),
                "description" => "",
                "save_always" => true,
            ),

            array(
                "param_name" => "branch_id",
                "type" => "dropdown",
                "value" => eb_sort_by_branch(),
                "heading" => __("Branch", "eagle-booking"),
                "description" => '',
                "save_always" => true,
            ),

            array(
                "param_name" => "items",
                "type" => "textfield",
                "value" => "6",
                "heading" => esc_html__("Items", "eagle-booking"),
                "description" => "",
                "save_always" => true,
                'dependency'    => array(
                    'element'   => 'view',
                    'value'     => array('normal', 'list', 'carousel')
                ),
            ),

            array(
                "param_name" => "items_per_row",
                "type" => "dropdown",
                "value" => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                "default" => "3",
                "heading" => esc_html__("Items per row", "eagle-booking"),
                "description" => "",
                "save_always" => true,
                'dependency'    => array(
                    'element'   => 'view',
                    'value'     => 'normal'
                ),
            ),

            array(
                "param_name" => "items_per_view",
                "type" => "dropdown",
                "value" => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                "default" => "3",
                "heading" => esc_html__("Items per view", "eagle-booking"),
                "description" => "",
                "save_always" => true,
                'dependency'    => array(
                    'element'   => 'view',
                    'value'     => 'carousel'
                ),
            ),

            array(
                "type"       => "dropdown",
                "class"      => "",
                "heading"    => "Navigation buttons",
                "param_name" => "carousel_nav",
                "value"      => array(
                    "True"   => "true",
                    "False"  => "false",
                ),
                "default" => true,
                'dependency'    => array(
                    'element'   => 'view',
                    'value'     => 'carousel'
                ),
            ),

            array(
                "param_name" => "orderby",
                "type" => "dropdown",
                "value" => array(
                    'None' => 'none',
                    'ID' => 'ID',
                    'Title' => 'title',
                    'Date' => 'date',
                    'Random' => 'rand',
                    'Menu Order' => 'menu_order'
                ),
                "heading" => esc_html__("Order by", "eagle-booking"),
                "description" => '',
                "save_always" => true,
            ),

            array(
                "param_name" => "order",
                "type" => "dropdown",
                "value" => array(
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ),
                "heading" => esc_html__("Order", "eagle-booking"),
                "description" => '',
                "save_always" => true,
            ),

            array(
                "param_name" => "offset",
                "type" => "textfield",
                "value" => "",
                "heading" => esc_html__("Offset", "eagle-booking"),
                "description" => "",
                "save_always" => true
            ),
        )

    ));

}