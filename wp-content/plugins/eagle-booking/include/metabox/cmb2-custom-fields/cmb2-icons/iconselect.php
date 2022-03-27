<?php

/*
Plugin Name: CMB2 Field Type: Font Awesome
Plugin URI: https://github.com/serkanalgur/cmb2-field-faiconselect
GitHub Plugin URI: https://github.com/serkanalgur/cmb2-field-faiconselect
Description: Font Awesome icon selector for CMB2
Version: 1.4
Author: Serkan Algur
Author URI: https://wpadami.com/
License: GPLv3
*/

/**
 * Class IConSelectFA
 */

if( !class_exists( 'CMBS_SerkanA_Plugin_IConSelectFA' ) ) {

class CMBS_SerkanA_Plugin_IConSelectFA {


	const VERSION = '1.4';

	public function __construct() {
		add_filter( 'cmb2_render_faiconselect', array( $this, 'render_faiconselect' ), 10, 5 );
	}

	public function render_faiconselect( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		$this->Sesetup_my_cssjs( $field );

		if ( version_compare( CMB2_VERSION, '2.2.2', '>=' ) ) {
			$field_type_object->type = new CMB2_Type_Select( $field_type_object );
		}

		echo $field_type_object->select(
			array(
				'class'   => 'iconselectfa',
				'desc'    => $field_type_object->_desc( true ),
				'options' => '<option></option>' . $field_type_object->concat_items(),
			)
		);

	}

	public function Sesetup_my_cssjs( $field ) {
		$asset_path = apply_filters( 'sa_cmb2_field_faiconselect_asset_path', plugins_url( '', __FILE__ ) );

		$font_args        = $field->args( 'attributes', 'fatype' );
		$font_awesome_ver = $field->args( 'attributes', 'faver' );

		if ( $font_awesome_ver && $font_awesome_ver === 5 ) {

		// loads all over admin via enqueue.php
		//	wp_enqueue_style( 'fontawesome5', 'https://use.fontawesome.com/releases/v5.10.2/css/all.css', array( 'jqueryfontselector' ), self::VERSION, 'all' );

		} else {

			wp_enqueue_style( 'fontawesomeiselect', $asset_path . '/css/faws/css/font-awesome.min.css', array( 'jqueryfontselector' ), self::VERSION );

		}

		wp_enqueue_style( 'jqueryfontselectormain', $asset_path . '/css/css/base/jquery.fonticonpicker.min.css', array(), self::VERSION );
		wp_enqueue_style( 'jqueryfontselector', $asset_path . '/css/css/themes/grey-theme/jquery.fonticonpicker.grey.min.css', array(), self::VERSION );
		wp_enqueue_script( 'jqueryfontselector', $asset_path . '/js/jquery.fonticonpicker.min.js', array( 'jquery' ), self::VERSION, true );
		wp_enqueue_script( 'mainjsiselect', $asset_path . '/js/main.js', array( 'jqueryfontselector' ), self::VERSION, true );
	}


}

function returnRayFaPre() {
	include 'predefined-array-fontawesome.php';
	return $fontAwesome;
}

function returnRayFapsa() {
	include 'predefined-array-fontawesome.php';

	$fa5a = array_combine( $fa5all, $fa5all );

	return $fa5a;
}


new CMBS_SerkanA_Plugin_IConSelectFA();

}
