<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// INCLUDE ALL REQUIRED FILES
foreach ( glob ( plugin_dir_path( __FILE__ ) . "*/*.php" ) as $file ){
	include_once $file;
}
