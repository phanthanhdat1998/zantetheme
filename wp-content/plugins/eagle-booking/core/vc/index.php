<?php
// INCLUDE ALL SHRTCODES
foreach ( glob ( plugin_dir_path( __FILE__ ) . "*/index.php" ) as $file ){
	include_once $file;
}
