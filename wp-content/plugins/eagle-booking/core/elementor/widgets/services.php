<?php
namespace ElementorEagleThemes\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor Gallery
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class RoomServices extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eagle_rooms_services';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'Rooms Services', 'eagle' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'fas fa-concierge-bell';
	}

	/* Retrieve the list of categories the widget belongs to.*/
	public function get_categories() {
		return [ 'eaglebooking' ];
	}

	/*Retrieve the list of scripts the widget depended on. */
	public function get_script_depends() {
		return [ 'core-js', 'core-css' ];
	}

	/* Register the widget controls. */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Settings', 'eagle-booking' ),
			]
		);

		// Style
		$this->add_control(
			'gallery_style',
			[
				'label' => __( 'Style', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'  => __( 'Grid', 'eagle' ),
					'carousel'  => __( 'Carousel', 'eagle' ),
				],
			]
		);


		// Filters
		$this->add_control(
			'gallery_filters',
			[
				'label' => __( 'Show Filters', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle' ),
				'label_off' => __( 'Hide', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'gallery_style',
							'operator' => 'in',
							'value' => [
								'grid',
							],
						],
					],
				],
			]
		);

		// Items to Display
		$this->add_control(
			'gallery_items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
			]
		);


		// Items per Row
		$this->add_control(
			'rooms_items_per_row',
			[
				'label' => __( 'Items per Row', 'eagle' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1'  => __( '1', 'eagle' ),
					'2'  => __( '2', 'eagle' ),
					'3'  => __( '3', 'eagle' ),
					'4'  => __( '4', 'eagle' ),
					'6'  => __( '6', 'eagle' ),
					'12'  => __( '12', 'eagle' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'gallery_style',
							'operator' => 'in',
							'value' => [
								'grid',
							],
						],
					],
				],
			]
		);

		// Items per View (Carousel)
		$this->add_control(
			'gallery_items_per_view',
			[
				'label' => __( 'Items per View', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '5',
				'conditions' => [
					'terms' => [
						[
							'name' => 'gallery_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);


				// Order By
				$this->add_control(
					'gallery_order_by',
					[
						'label' => __( 'Order By', 'eagle-booking' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'ID',
						'options' => [
							'none'  => __( 'None', 'eagle' ),
							'ID'  => __( 'ID', 'eagle' ),
							'title'  => __( 'Title', 'eagle' ),
							'date'  => __( 'Date', 'eagle' ),
							'rand'  => __( 'Random', 'eagle' ),
							'menu_order'  => __( 'Menu Order', 'eagle' ),
						],
					]
				);

				// Order
				$this->add_control(
					'gallery_order',
					[
						'label' => __( 'Order', 'eagle-booking' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'ASC',
						'options' => [
							'ASC'  => __( 'ASC', 'eagle' ),
							'DESC'  => __( 'DESC', 'eagle' ),
						],
					]
				);

				// Offset
				$this->add_control(
					'gallery_offset',
					[
						'label' => __( 'Offset', 'eagle' ),
						'type' => Controls_Manager::NUMBER,
						'default' => '',
					]
				);

		// Loop (Carousel)
		$this->add_control(
			'gallery_loop',
			[
				'label' => __( 'Loop', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'gallery_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		// Navigation (Carousel)
		$this->add_control(
			'gallery_navigation',
			[
				'label' => __( 'Navigation', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle' ),
				'label_off' => __( 'False', 'eagle' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'gallery_style',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

			$settings = $this->get_settings_for_display();

			// GALLERY QUERY
			$eagle_booking_query_args = array(
          'post_type' => 'eagle_reviews',
          'posts_per_page' => '10',
          //'orderby' => $orderby,
          //'order' => $order,
          //'offset' => $offset
			);

			$eagle_booking_review_qry = new \WP_Query($eagle_booking_query_args);
			$eagle_unique_token = wp_generate_password(5, false, false);
	    ?>

          <div class="testimonials">
                <div class="owl-carousel testimonials-owl">
      	                <?php
      	                if ($eagle_booking_review_qry->have_posts()): while ($eagle_booking_review_qry->have_posts()) : $eagle_booking_review_qry->the_post();

                          // GET REVIEWS MTB
                          $eagle_booking_review_author_name = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author', true );
                          $eagle_booking_review_avatar_file_id = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_image_id', true );
                          $eagle_booking_review_avatar =  wp_get_attachment_image_url( $eagle_booking_review_avatar_file_id);
                          $eagle_booking_review_author_location = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author_location', true );
                          $eagle_booking_review_rating = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_rating', true );
                          $eagle_booking_review_quote = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_quote', true );

                         ?>

                         <!-- REVIEW ITEM -->
                          <div class="item">
                            <div class="testimonial-item">
                              <div class="author-img">
                                <img alt="<?php echo esc_html( $eagle_booking_review_author_name ) ?>" class="img-fluid" src="<?php echo esc_url( $eagle_booking_review_avatar ) ?>">
                              </div>
                              <div class="author">
                                <h4 class="name"><?php echo esc_html( $eagle_booking_review_author_name ) ?></h4>
                                <div class="location"><?php echo esc_html( $eagle_booking_review_author_location ) ?></div>
                              </div>
                              <div class="rating">
                                <?php
                                    for($x=1;$x<=$eagle_booking_review_rating;$x++) {
                                        echo '<i class="fa fa-star voted" aria-hidden="true"></i>';
                                    }
                                    if (strpos($eagle_booking_review_rating,'.')) {
                                        echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                        $x++;
                                    }
                                    while ($x<=5) {
                                        echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                        $x++;
                                    }
                                  ?>
                              </div>
                              <p><?php echo esc_html( $eagle_booking_review_quote ) ?></p>
                            </div>
                          </div>

      	                <?php endwhile; endif; ?>
      	                <?php wp_reset_postdata(); ?>
                  </div>
                  </div>



<?php

	}


}
