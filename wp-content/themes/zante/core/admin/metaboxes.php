<?php
/*---------------------------------------------------------------------------------
@ Pages Metaboxes
@ Since 1.0.0
-----------------------------------------------------------------------------------*/

add_action('cmb2_admin_init', 'zante_general_meta');

function zante_general_meta() {

    $prefix = 'zante_mtb_page_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Zante', 'zante'),
        'object_types'  => array('page', 'post', 'eagle_rooms', 'eagle_places'),
    ));

			$cmb->add_field( array(
						'name'        => __('Top Bar', 'zante'),
						'id'	  => $prefix.'topbar',
						'type'    => 'switch',
						'default'  => zante_get_option('topbar'),
						'label'    => array(
							'true'=> 'Yes',
							'false'=> 'No'
						),
				));

        $cmb->add_field( array(
              'name'        => __('Transparent Top Bar', 'zante'),
              'id'	  => $prefix.'topbar_transparent',
              'type'    => 'switch',
              'default'    => zante_get_option('topbar_transparent'),
              'label'    => array(
                'true'=> 'Yes',
                'false'=> 'No'
              ),
          ));

			$cmb->add_field( array(
				    'name'        => __('Sticky Header', 'zante'),
				    'id'	  => $prefix.'header_sticky',
					  'type'    => 'switch',
					  'default'    => zante_get_option('header_sticky'),
					  'label'    => array(
							'true'=> 'Yes',
							'false'=> 'No'
						),
			  ));

				$cmb->add_field( array(
							'name'        => __('Transparent Header', 'zante'),
							'id'	  => $prefix.'header_transparent',
							'type'    => 'switch',
							'default'    => zante_get_option('header_transparent'),
							'label'    => array(
								'true'=> 'Yes',
								'false'=> 'No'
							),
				));

        $cmb->add_field( array(
              'name'        => __('Semi Transparent Header', 'zante'),
              'id'	  => $prefix.'header_semi_transparent',
              'type'    => 'switch',
              'default'    => false,
              'label'    => array(
                'true'=> 'Yes',
                'false'=> 'No'
              ),
          ));

				$cmb->add_field( array(
							'name'        => __('Page Title', 'zante'),
							'id'               => $prefix.'title',
							'type'    => 'switch',
							'default'    => true,
							'label'    => array(
								'true'=> 'Yes',
								'false'=> 'No'
							),
					));

            $cmb->add_field( array(
              'name' => esc_html__('Page Title Background Image', 'zante'),
              'id'   => $prefix.'title_bg_image',
              'type' => 'file',
              'options' => array(
                'url' => false,
              ),
            ));

          $cmb->add_field( array(
                'name'        => __('Padding Top / Bottom', 'zante'),
                'id'          => $prefix.'padding',
                'type'    => 'switch',
                'default'    => true,
                'label'    => array(
                  'true'=> 'Yes',
                  'false'=> 'No'
                ),
            ));

          $cmb->add_field( array(
            'name'             => __( 'Sidebar', 'zante' ),
            'id'               => $prefix.'sidebar',
            'type'             => 'radio_image',
            'default'    => zante_get_option('page_sidebar'),
            'options'          => array(
              'left'    => __('Left', 'zante'),
              'none'  => __('None', 'zante'),
              'right' => __('Right', 'zante'),
            ),
            'images_path'      => get_template_directory_uri(),
            'images'           => array(
              'left'    => 'assets/images/admin/sidebar-left.png',
              'none'  => 'assets/images/admin/sidebar-none.png',
              'right' => 'assets/images/admin/sidebar-right.png',
            ),
          ) );

}
