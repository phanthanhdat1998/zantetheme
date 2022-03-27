<?php
/*---------------------------------------------------------------------------------
* Package: Eagle-Booking/Core
* Room Metaboxes
* Since 1.0.0
-----------------------------------------------------------------------------------*/
add_action('cmb2_admin_init', 'eagle_booking_rooms_metabox');

function eagle_booking_rooms_metabox() {

    $prefix = 'eagle_booking_mtb_room_';

    $cmb = new_cmb2_box(array(
        'id'            => $prefix.'meta',
        'title'         => esc_html__('Eagle Booking', 'eagle-booking'),
        'object_types'  => array('eagle_rooms'),
        'tabs'      => array(

            'settings'  => array(
                'label' => __('Main Settings', 'eagle-booking'),
                'icon'  => 'dashicons-admin-generic',
            ),

            'price'    => array(
                'label' => __('Price', 'eagle-booking'),
                'icon'  => 'dashicons-money',
            ),

            'slider'  => array(
                'label' => __('Slider', 'eagle-booking'),
                'icon'  => 'dashicons-images-alt2',
            ),

						'services'    => array(
								'label' => __('Services', 'eagle-booking'),
								'icon'  => 'dashicons-star-filled',
						),

						'reviews'    => array(
								'label' => __('Reviews', 'eagle-booking'),
								'icon'  => 'dashicons-testimonial',
						),

						'exceptions'    => array(
								'label' => __('Exceptions', 'eagle-booking'),
								'icon'  => 'dashicons-forms',
						),

						'integration'    => array(
								'label' => __('External Integration', 'eagle-booking'),
								'icon'  => 'dashicons-admin-plugins',
						),

						'translation'    => array(
								'label' => __('Translation', 'eagle-booking'),
								'icon'  => 'dashicons-translation',
						),

            'layout'    => array(
                'label' => __('Layout', 'eagle-booking'),
                'icon'  => 'dashicons-format-aside',
            )
        ),
    ));

		// Main Settings Tab
    $cmb->add_field(array(
        'name' => esc_html__('Max Guests', 'eagle-booking'),
        'desc' => esc_html__('Insert the max guests number for the room', 'eagle-booking'),
        'id'   => $prefix.'maxguests',
        'type' => 'text',
        'show_on_cb' => "eb_show_guests_room_mtb",
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Max Adults', 'eagle-booking'),
        'desc' => esc_html__('Insert the max adults number for the room', 'eagle-booking'),
        'id'   => $prefix.'max_adults',
        'type' => 'text',
        'show_on_cb' => 'eb_show_adults_children_room_mtb',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Max Children', 'eagle-booking'),
        'desc' => esc_html__('Insert the max children number for the room', 'eagle-booking'),
        'id'   => $prefix.'max_children',
        'type' => 'text',
        'show_on_cb' => 'eb_show_adults_children_room_mtb',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

		$cmb->add_field(array(
				'name' => esc_html__('Quantity', 'eagle-booking'),
				'desc' => esc_html__('Insert the room quantity', 'eagle-booking'),
				'id'   => $prefix.'quantity',
				'type' => 'text',
				'tab'  => 'settings',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
				'name' => esc_html__('Min Booking Nights', 'eagle-booking'),
				'desc' => esc_html__('Insert the minimum nights number to make a reservation. (empty = no minimum booking nights)', 'eagle-booking'),
				'id'   => $prefix.'min_booking_nights',
				'type' => 'text',
				'tab'  => 'settings',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

		$cmb->add_field(array(
				'name' => esc_html__('Max Booking Nights', 'eagle-booking'),
				'desc' => esc_html__('Insert the maximum nights number to make a reservation. (empty = no maximum booking nights)', 'eagle-booking'),
				'id'   => $prefix.'max_booking_nights',
				'type' => 'text',
				'tab'  => 'settings',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Description', 'eagle-booking'),
        'desc' => __('Set the description to display on the search & rooms archive pages.', 'eagle-booking'),
        'id'   => $prefix.'description',
        'type' => 'text',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Room Size', 'eagle-booking'),
				'desc' => esc_html__('Only number ', 'eagle-booking'),
        'id'   => $prefix.'size',
        'type' => 'text',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Bed Type', 'eagle-booking'),
        'desc' => __('Set the displayed bed type', 'eagle-booking'),
        'id'   => $prefix.'bed_type',
        'type' => 'text',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Exclude from the search page', 'eagle-booking'),
        'id'   => $prefix.'excluded',
        'type' => 'checkbox',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Featured', 'eagle-booking'),
        'id'   => $prefix.'featured',
        'type' => 'checkbox',
        'tab'  => 'settings',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

		// Price Tab
		$cmb->add_field(array(
				'name' => esc_html__('Room Price', 'eagle-booking'),
				'desc' => esc_html__('Default price, Only number.', 'eagle-booking'),
				'id'   => $prefix.'price',
				'type' => 'text',
				'tab'  => 'price',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

    $day1 = $cmb->add_field(array(
        'desc' => esc_html__('Monday', 'eagle-booking'),
        'id'   => $prefix.'price_mon',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day2 = $cmb->add_field(array(
        'desc' => esc_html__('Tuesday', 'eagle-booking'),
        'id'   => $prefix.'price_tue',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day3 = $cmb->add_field(array(
        'desc' => esc_html__('Wednesday', 'eagle-booking'),
        'id'   => $prefix.'price_wed',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day4 = $cmb->add_field(array(
        'desc' => esc_html__('Thursday', 'eagle-booking'),
        'id'   => $prefix.'price_thu',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day5 = $cmb->add_field(array(
        'desc' => esc_html__('Friday', 'eagle-booking'),
        'id'   => $prefix.'price_fri',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day6 = $cmb->add_field(array(
        'desc' => esc_html__('Saturday', 'eagle-booking'),
        'id'   => $prefix.'price_sat',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $day7 = $cmb->add_field(array(
        'desc' => esc_html__('Sunday', 'eagle-booking'),
        'id'   => $prefix.'price_sun',
        'type' => 'text_small',
        'tab'  => 'price',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $final = $cmb->add_field(array(
        'id'   => $prefix.'price_min',
        'type' => 'hidden',
        'tab'  => 'price',
        'default'    => eagle_booking_room_min_price(eagle_booking_get_the_edit_post_id()),
        'display_cb' => 'eagle_booking_room_min_price(eagle_booking_get_the_edit_post_id())',
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    //  UPDATE ROOM MIN PRICE
    add_action( 'save_post', 'eagle_booking_update_room_price_min', 11 );
    function eagle_booking_update_room_price_min() {
      if (get_post_type(eagle_booking_get_the_edit_post_id()) == "eagle_rooms"){
        update_post_meta( eagle_booking_get_the_edit_post_id(), 'eagle_booking_mtb_room_price_min', eagle_booking_room_min_price(eagle_booking_get_the_edit_post_id()));
        return;
        }
    }

		$cmb->add_field(array(
      'name' => esc_html__('Price Type', 'eagle-booking'),
      'desc' => esc_html__('Select the room price type', 'eagle-booking'),
      'id'   => $prefix.'price_type',
      'type'             => 'select',
      'show_option_none' => false,
      'default'          => eb_get_option('eb_room_price_type'),
      'options'          => array(
        'room_price_nights' => __( 'Room Price x Booking Nights', 'eagle-booking' ),
        'room_price_nights_guests'   => __( 'Room Price x Booking Nights x Guests (or adults + children)', 'eagle-booking' ),
        'room_price_nights_guests_custom'   => __( 'Room Price x Booking Nights + Price per guest (or adults + children) x Booking Nights', 'eagle-booking'  ),
      ),
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
   ));

		$cmb->add_field(array(
      'name' => esc_html__('Price per guest', 'eagle-booking'),
      'desc' => esc_html__('Only number', 'eagle-booking'),
      'id'   => $prefix.'guests_price',
      'type' => 'text',
      'show_on_cb' => 'eb_show_guests_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )

    ));

		$cmb->add_field(array(
      'name' => esc_html__('Guests price starts after', 'eagle-booking'),
      'desc' => esc_html__('Start applying the guests price after [number] guests. Only number.', 'eagle-booking'),
      'id'   => $prefix.'guests_price_start',
      'type' => 'text',
      'show_on_cb' => 'eb_show_guests_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'default'       => '1',
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )
    ));


    // If adults & children option is enabled
		$cmb->add_field(array(
      'name' => esc_html__('Price per adult', 'eagle-booking'),
      'desc' => esc_html__('Only number', 'eagle-booking'),
      'id'   => $prefix.'adult_price',
      'type' => 'text',
      'default'       => '',
      'show_on_cb' => 'eb_show_adults_children_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )
    ));

		$cmb->add_field(array(
      'name' => esc_html__('Price per children', 'eagle-booking'),
      'desc' => esc_html__('Only number', 'eagle-booking'),
      'id'   => $prefix.'children_price',
      'type' => 'text',
      'default'       => '',
      'show_on_cb' => 'eb_show_adults_children_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )
    ));


		$cmb->add_field(array(
      'name' => esc_html__('Adults price starts after', 'eagle-booking'),
      'desc' => esc_html__('Start applying the adults price after [number] of adults. Only number.', 'eagle-booking'),
      'id'   => $prefix.'adults_price_start',
      'type' => 'text',
      'show_on_cb' => 'eb_show_adults_children_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'default'       => '1',
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )
    ));

		$cmb->add_field(array(
      'name' => esc_html__('Children price starts after', 'eagle-booking'),
      'desc' => esc_html__('Start applying the children price after [number] of children. Only number.', 'eagle-booking'),
      'id'   => $prefix.'children_price_start',
      'type' => 'text',
      'show_on_cb' => 'eb_show_adults_children_room_mtb',
      'tab'  => 'price',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'default'       => '1',
      'attributes' => array(
        'data-conditional-id'    => $prefix.'price_type',
        'data-conditional-value' => wp_json_encode( array( 'room_price_nights_guests', 'room_price_nights_guests_custom' ) ),
      )
    ));

    $cmb->add_field( array(
      'name'    => 'Taxes',
      'id'   => $prefix.'taxes',
      'desc'    => 'Global Taxes are applied by default.',
      'type'    => 'pw_multiselect',
      'tab'  => 'price',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eb_taxes',
      )
    );

    $cmb->add_field( array(
      'name'    => 'Fees',
      'id'   => $prefix.'fees',
      'desc'    => 'Global Fees are applied by default.',
      'type'    => 'pw_multiselect',
      'tab'  => 'price',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eb_fees',
      )
    );

    // Slider Tab
    $cmb->add_field(array(
        'name' => esc_html__('Slider Images', 'eagle-booking'),
        'desc' => esc_html__('Select Images to display in the slider', 'eagle-booking'),
        'id'   => $prefix.'slider_images',
        'type' => 'file_list',
        'tab'  => 'slider',
        'preview_size' => array( 150, 100 ),
        'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    // Services Tab
    $cmb->add_field( array(
    	'name'    => 'Services',
    	'id'   => $prefix.'services',
    	'desc'    => 'Drag to reorder.',
    	'type'    => 'pw_multiselect',
      'tab'  => 'services',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eagle_booking_normal_services',
    ) );

    $cmb->add_field( array(
      'name'    => 'Addition Services',
      'id'   => $prefix.'additional_services',
      'desc'    => 'Drag to reorder.',
      'type'    => 'pw_multiselect',
      'tab'  => 'services',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eagle_booking_additional_services',
    ) );

    // Reviews Tab
    $cmb->add_field( array(
      'name'    => esc_html__('Reviews', 'eagle-booking'),
      'desc'    => esc_html__('Drag to reorder.', 'eagle-booking'),
      'id'   => $prefix.'reviews',
      'type'    => 'pw_multiselect',
      'tab'  => 'reviews',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eagle_booking_get_reviews',
    ) );


    // Integration tab
    $cmb->add_field(array(
      'name' => esc_html__('Room External Link', 'eagle-booking'),
      'desc' => esc_html__('Insert the room external link (the room external link will override the form action, check-in, check-out and guests parameters will pass if that is possible)', 'eagle-booking'),
      'id'   => $prefix.'integration_link',
      'type' => 'text',
      'tab'  => 'integration',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));

    $cmb->add_field(array(
      'name' => esc_html__('Room External ID', 'eagle-booking'),
      'desc' => esc_html__('Insert the room external ID (the room external ID will be passed as a form parameter)', 'eagle-booking'),
      'id'   => $prefix.'integration_id',
      'type' => 'text',
      'tab'  => 'integration',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ));


    // Translation Tab
    $cmb->add_field( array(
      'name' => esc_html__('Default Room', 'eagle-booking'),
      'desc' => wp_kses(sprintf(__("If you are using a multilanguage plugin like <a href='%s' target='_blank'> WPML </a> or Polylang and this is a translated room, select the default language room. The room quantity, price type and the minimum/maximum booking nights will be overridden by the default room's settings.", 'eagle-booking'), 'https://wpml.org/?aid=225435&affiliate_key=xqc1kSQTtLzj'), wp_kses_allowed_html('post')),
      'id'   => $prefix.'default_room_id',
      'type' => 'pw_select',
      'options_cb' => 'eagle_booking_rooms_list',
      'tab'  => 'translation',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'attributes' => array(
        'placeholder' => 'Select the default language room'
      ),
    ) );

    $cmb->add_field( array(
      'name'             => __( 'Page Layout', 'eagle-booking' ),
      'id'               => $prefix.'page_layout',
      'type'             => 'radio_image',
      'tab'              => 'layout',
      'options'          => array(
        'full-slider'    => __('Full Slider', 'eagle-booking'),
        'normal-slider'  => __('Normal Slider', 'eagle-booking'),
      ),
      'default'          => 'normal-slider',
      'images_path'      => EB_URL,
      'images'           => array(
        'full-slider'    => 'assets/images/admin/room-page-layout-full-slider.png',
        'normal-slider'  => 'assets/images/admin/room-page-layout-normal-slider.png',
      ),
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ) );

    $cmb->add_field( array(
      'name' => __('Header Background Image', 'eagle-booking'),
      'id'   => $prefix.'header_image',
      'type' => 'file',
      'tab'  => 'layout',
      'options' => array(
        'url' => false,
      ),

      'attributes' => array(
        'data-conditional-id'     => $prefix.'page_layout',
        'data-conditional-value'  => 'normal-slider',
      ),

      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),

    ) );

    $cmb->add_field( array(
      'name'             => __( 'Sidebar', 'eagle-booking' ),
      'id'               => $prefix.'sidebar',
      'type'             => 'radio_image',
      'tab'  => 'layout',
      'default'    => 'right',
      'options'          => array(
        'left'    => __('Left', 'eagle-booking'),
        'none'  => __('None', 'eagle-booking'),
        'right' => __('Right', 'eagle-booking'),
      ),
      'images_path'      => EB_URL,
      'images'           => array(
        'left'    => 'assets/images/admin/sidebar-left.png',
        'none'  => 'assets/images/admin/sidebar-none.png',
        'right' => 'assets/images/admin/sidebar-right.png',
      ),
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
    ) );


    $cmb->add_field( array(
      'name'    => 'Price Exceptions',
      'id'   => $prefix.'price_exceptions',
      'type'    => 'pw_multiselect',
      'tab'  => 'exceptions',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eagle_booking_get_price_exceptions',
    ) );


    $cmb->add_field( array(
      'name'    => 'Dates Exceptions (Blocked Dates)',
      'id'   => $prefix.'block_exceptions',
      'type'    => 'pw_multiselect',
      'tab'  => 'exceptions',
      'default'    => '',
      'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
      'options_cb'       => 'eagle_booking_get_block_exceptions',
    ) );


    // CMB2 GRID
    $cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid($cmb);
    $row = $cmb2Grid->addRow();
    //  $row->addColumns(array($day1, $day2, $day3, $day4, $day5, $day6, $day7));

    $row->addColumns(array(
        array($day1, 'class' => 'col-day'),
        array($day2, 'class' => 'col-day'),
        array($day3, 'class' => 'col-day'),
        array($day4, 'class' => 'col-day'),
        array($day5, 'class' => 'col-day'),
        array($day6, 'class' => 'col-day'),
        array($day7, 'class' => 'col-day'),
      // array($final, 'class' => 'col-day'),
    ));

}
