<?php
/*---------------------------------------------------------------------------------
@ Testimonials Metaboxes
@ Since 1.0.0
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eb_reviews_meta');

function eb_reviews_meta() {

    $prefix = 'eagle_booking_mtb_review_';

    $cmb = new_cmb2_box(array(
			'id'            => $prefix.'meta',
			'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
			'object_types'  => array('eagle_reviews'),
		));

		$cmb->add_field( array(
			'name'	=> esc_html__('Avatar of author', 'eagle-booking' ),
			'id'	=> $prefix.'image',
			'type'	=> 'file',
			'options' => array(
				'url' => false,
			),
		) );

		$cmb->add_field( array(
			'name'=> esc_html__('Quote', 'eagle-booking'),
			'desc'  => esc_html__('quote said by the author.', 'eagle-booking'),
			'id'    => $prefix.'quote',
			'type'  => 'textarea_small',
		) );

		$cmb->add_field( array(
			'name'=> esc_html__('Author Name', 'eagle-booking'),
			'id'    => $prefix.'author',
			'type'  => 'text_small',
		) );
		$cmb->add_field( array(
			'name'=> esc_html__('Author Location', 'eagle-booking'),
			'id'    => $prefix.'author_location',
			'type'  => 'text_small',
		) );

		$cmb->add_field( array(
		'name'             => 'Rating',
		'desc'             => 'Select an option',
		'id'               => $prefix.'rating',
		'type'             => 'select',
		'show_option_none' => true,
		'default'          => '5',
		'options'          => array(
			'1' 		=> __( '1 Star', 'eagle-booking' ),
			'2'   	=> __( '2 Stars', 'eagle-booking' ),
			'3'     => __( '3 Stars', 'eagle-booking' ),
			'4'     => __( '4 Stars', 'eagle-booking' ),
			'5'     => __( '5 Stars', 'eagle-booking' ),
		),
	) );

}
