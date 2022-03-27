<?php
/*
Plugin Name:       Eagle Core
Description:       Plugin that adds all features needed by our theme.
Version:           1.1.7
Plugin URI:        http://eagle-themes.com
Author:            Eagle Themes
Author URI:        http://eagle-themes.com
Text Domain:       eagle
*/

// translation
function eagle_load_textdomain() {
  load_plugin_textdomain("eagle", false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'eagle_load_textdomain');

// include all required plugins
foreach ( glob ( plugin_dir_path( __FILE__ ) . "*/index.php" ) as $file ){
    include_once $file;
}