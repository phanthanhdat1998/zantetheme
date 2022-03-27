<?php

/**
 * Include a template file
 *
 * Looks up first on the theme directory, if not found
 * lods from plugins folder
 *
 * Author: Eagle Themes
 * Since 1.1.5
 *
 */
function eb_load_template($file) {

    $child_theme_dir = get_stylesheet_directory() . '/eb-templates/';
    $parent_theme_dir = get_template_directory() . '/eb-templates/';

    $eb_dir = EB_PATH . '/templates/';

    if ( file_exists( $child_theme_dir . $file ) ) {

        return $child_theme_dir . $file;

    } else if ( file_exists( $parent_theme_dir . $file ) ) {

        return $parent_theme_dir . $file;

    } else {
        return $eb_dir . $file;
    }
}