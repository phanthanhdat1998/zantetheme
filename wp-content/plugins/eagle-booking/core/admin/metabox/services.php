<?php
/*---------------------------------------------------------------------------------
@ Services Metaboxes
@ Since 1.0.0
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eagle_booking_services');

function eagle_booking_services() {

    $prefix = 'eagle_booking_mtb_service_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
        'object_types'  => array('eagle_services'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Description', 'eagle-booking'),
        'id'   => $prefix.'description',
        'type' => 'text',
    ));

    $cmb->add_field(array(
      'name' => esc_html__('Icon Type', 'eagle-booking'),
      'id'   => $prefix.'icon_type',
      'type' => 'select',
      'default'          => 'fontawesome',
        'options'          => array(
          'fonticon' => __( 'Font Awesome 4 (Deprecated)', 'eagle-booking' ),
          'fontawesome' => __( 'Font Awesome 5', 'eagle-booking' ),
          'customicon'   => __( 'Custom Icon (Image)', 'eagle-booking' ),
        ),
  ));

    $cmb->add_field( array(
      'name' => esc_html__( 'Font Awesome 4 Icon (Deprecated)', 'eagle-booking' ),
      'desc' => esc_html__( 'Deprecated: Please use Font Awesome 5', 'eagle-booking' ),
      'id'   => $prefix . 'icon',
      'type' => 'faiconselect',
      'default'  => 'fa fa-check',
      'options_cb' => 'returnRayFaPre',
      'attributes' => array(
        'data-conditional-id'    => $prefix.'icon_type',
        'data-conditional-value' => 'fonticon',
      ),
      ) );


    $cmb->add_field( array(
      'name' => __( 'Font Awesome 5 Icon', 'eagle-booking' ),
      'id'   => $prefix . 'icon_fontawesome',
      'type' => 'faiconselect',
      // 'default'  => 'fas fa-check',
      'options_cb' => 'returnRayFapsa',
      'attributes' => array(
          'data-conditional-id'    => $prefix.'icon_type',
          'data-conditional-value' => 'fontawesome',
          'faver' => 5
      )
    ) );


    $cmb->add_field( array(
      'name'	=> esc_html__('Custom Icon', 'eagle-booking' ),
      'id'	=> $prefix.'image',
      'type'	=> 'file',
      'options' => array(
        'url' => false,
      ),
      'attributes' => array(
        'data-conditional-id'    => $prefix.'icon_type',
        'data-conditional-value' => 'customicon',
      ),

    ) );

    $cmb->add_field(array(
        'name' => esc_html__('Type', 'eagle-booking'),
        'id'   => $prefix.'type',
        'type' => 'select',
        'default'          => 'normal',
        	'options'          => array(
        		'normal' => __( 'Normal', 'eagle-booking' ),
        		'additional'   => __( 'Additional', 'eagle-booking' ),
        	),
    ));

		$cmb->add_field(array(
        'name' => esc_html__('Price', 'eagle-booking'),
        'desc' => esc_html__('0 = free', 'eagle-booking'),
				'id'   => $prefix.'price',
				'type' => 'text_small',
        'attributes' => array(
          'data-conditional-id'    => $prefix.'type',
          'data-conditional-value' => 'additional',
        ),
		));

    $cmb->add_field(array(
        'name' => esc_html__('Price Type', 'eagle-booking'),
        'id'   => $prefix.'price_type',
        'type'             => 'select',
        'options_cb'       => 'eb_service_price_type',
        'attributes' => array(
          'data-conditional-id'    => $prefix.'type',
          'data-conditional-value' => 'additional',
        ),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Price Type 2', 'eagle-booking'),
        'id'   => $prefix.'price_type_2',
        'type' => 'select',
        'default'          => 'day',
          'options'          => array(
            'night' => __( 'Night', 'eagle-booking' ),
            'trip'   => __( 'Trip', 'eagle-booking' ),
          ),
          'attributes' => array(
            'data-conditional-id'    => $prefix.'type',
            'data-conditional-value' => 'additional',
          ),
    ));

}
