<?php
/*---------------------------------------------------------------------------------
@ Places Metaboxes
@ Since 1.1.0
@ Modified 1.2.7
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eagle_booking_places');

function eagle_booking_places() {

    $prefix = 'eagle_booking_mtb_place_';

      $cmb = new_cmb2_box(array(
          'id'            => $prefix.'meta',
          'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
          'object_types'  => array('eagle_places'),
      ));

      $cmb->add_field( array(
        'name'             => __( 'Sidebar', 'eagle-booking' ),
        'id'               => $prefix.'sidebar',
        'type'             => 'radio_image',
        'default'    => 'none',
        'options'          => array(
          'left'    => __('Left', 'eagle-booking'),
          'none'  => __('None', 'eagle-booking'),
          'right' => __('Right', 'eagle-booking'),
        ),
        'images_path'      => get_template_directory_uri(),
        'images'           => array(
          'left'    => 'assets/images/admin/sidebar-left.png',
          'none'  => 'assets/images/admin/sidebar-none.png',
          'right' => 'assets/images/admin/sidebar-right.png',
        ),
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      )
    );

}
