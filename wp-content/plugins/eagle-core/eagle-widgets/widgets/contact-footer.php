<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Zante_Contact_Footer_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'zante_contact_footer_widget',
			esc_html__( 'Zante - Contact Information', 'zante' ),
			array(
				'description' => esc_html__( 'A widget that displays contact informations in the footer', 'zante' )
			)
		);
	}
	public function widget( $args, $instance ) {
	extract( $args );

	$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

	$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

	echo wp_kses_post($args['before_widget']);
	if ( $title ) {
		echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
	}

		if(empty($instance)){
			$instance = array(
				'address' => '',
				'address_url' => '',
				'phone' => '',
				'phone_url' => '',
				'fax' => '',
				'email' => '',
				'email_url' => '',
				'site' => '',
				'site_url' => '',
				'facebook' => '',
				'twitter' => '',
				'youtube' => '',
				'pinterest' => '',
				'linkedin' => '',
				'instagram' => '',
				'tripadvisor' => '',
				'whatsapp' => '',
				'target' => '',
			);
		}

		$address = $instance['address'];
		$phone = $instance['phone'];
		$fax = $instance['fax'];
		$email = $instance['email'];
		$site = $instance['site'];

		if(!empty($instance['address_url'])) {
			$address_url = $instance['address_url'];
		}

		if(!empty($instance['phone_url'])) {
			$phone_url = $instance['phone_url'];
		}

		if(!empty($instance['email_url'])) {
			$email_url = $instance['email_url'];
		}

		if(!empty($instance['site_url'])) {
			$site_url = $instance['site_url'];
		}

		if(!empty($instance['facebook'])) {
			$facebook = $instance['facebook'];
		}

		if(!empty($instance['twitter'])) {
			$twitter = $instance['twitter'];
		}

		if(!empty($instance['youtube'])) {
			$youtube = $instance['youtube'];
		}

		if(!empty($instance['pinterest'])) {
			$pinterest = $instance['pinterest'];
		}

		if(!empty($instance['linkedin'])) {
			$linkedin = $instance['linkedin'];
		}

		if(!empty($instance['instagram'])) {
			$instagram = $instance['instagram'];
		}

		if(!empty($instance['tripadvisor'])) {
			$tripadvisor = $instance['tripadvisor'];
		}

		if(!empty($instance['whatsapp'])) {
			$whatsapp = $instance['whatsapp'];
		}

		if (isset($instance['target'])) {

			$target = $instance['target'];

			if ( $target == true ) {

				$target = "_blank";

			} else {

				$target = "_self";

			}

		} else {

			$target = "_self";

		}

		?>

		<address>
			<ul class="address_details">
				<?php if( !empty( $address ) ) : ?>
				<li>
					<?php if ( !empty( $address_url ) ) echo '<a href="'.esc_url( $address_url ).'" target="'. $target .'">';  ?>
						<i class="las la-map-marker-alt"></i> <?php echo esc_html( $address ); ?>
					<?php if ( !empty( $address_url ) ) echo '</a>';  ?>
				</li>
				<?php endif; ?>

				<?php if(!empty($phone)) : ?>
				<li>
					<?php if ( !empty( $phone_url ) ) echo '<a href="tel:'.esc_html( $phone_url ).'">';  ?>
						<i class="las la-phone"></i> <?php echo esc_html( $phone ); ?>
					<?php if ( !empty( $phone_url ) ) echo '</a>';  ?>
				</li>
				<?php endif; ?>

				<?php if(!empty($fax)) : ?>
				<li>
					<i class="las la-fax"></i> <?php echo esc_html( $fax ); ?>
				</li>
				<?php endif; ?>

				<?php if(!empty($email)) : ?>
				<li>
					<?php if ( !empty( $email_url ) ) echo '<a href="mailto:'.esc_html( $email_url ).'">';  ?>
						<i class="las la-envelope"></i> <?php echo esc_html( $email ); ?>
					<?php if ( !empty( $email_url ) ) echo '</a>';  ?>
				</li>
				<?php endif; ?>

				<?php if(!empty($site)) : ?>
				<li>
					<?php if ( !empty( $site_url ) ) echo '<a href="'.esc_url( $site_url ).'" target="'. $target .'">';  ?>
						<i class="las la-globe"></i> <?php echo esc_html( $site ); ?>
					<?php if ( !empty( $site_url ) ) echo '</a>';  ?>
				</li>
				<?php endif; ?>
			</ul>
		</address>

		<div class="social-media">
			<?php if(!empty($facebook)) : ?>
			<a href="<?php echo esc_url( $facebook ) ?>" target="<?php echo $target ?>" class="facebook"><i class="fa fa-facebook"></i></a>
			<?php endif ?>
			<?php if(!empty($twitter)) : ?>
			<a href="<?php echo esc_url( $twitter ) ?>" target="<?php echo $target ?>" class="twitter"><i class="fa fa-twitter"></i></a>
			<?php endif ?>
			<?php if(!empty($youtube)) : ?>
			<a href="<?php echo esc_url( $youtube ) ?>" target="<?php echo $target ?>" class="pinterest"><i class="fa fa-youtube"></i></a>
			<?php endif ?>
			<?php if(!empty($pinterest)) : ?>
			<a href="<?php echo esc_url( $pinterest ) ?>" target="<?php echo $target ?>" class="pinterest"><i class="fa fa-pinterest"></i></a>
			<?php endif ?>
			<?php if(!empty($linkedin)) : ?>
			<a href="<?php echo esc_url( $linkedin ) ?>" target="<?php echo $target ?>" class="linkedin"><i class="fa fa-linkedin"></i></a>
			<?php endif ?>
			<?php if(!empty($instagram)) : ?>
			<a href="<?php echo esc_url( $instagram ) ?>" target="<?php echo $target ?>" class="instagram"><i class="fa fa-instagram"></i></a>
			<?php endif ?>
			<?php if(!empty($tripadvisor)) : ?>
			<a href="<?php echo esc_url( $tripadvisor ) ?>" target="<?php echo $target ?>" class="tripadvisor"><i class="fa fa-tripadvisor"></i></a>
			<?php endif ?>
			<?php if(!empty($whatsapp)) : ?>
			<a href="<?php echo esc_url( $whatsapp ) ?>" target="<?php echo $whatsapp ?>" class="whatsapp"><i class="fa fa-whatsapp"></i></i></a>
			<?php endif ?>
		</div>

    <?php

		echo wp_kses_post($args['after_widget']);
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['address_url'] = strip_tags( $new_instance['address_url'] );

		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['phone_url'] = strip_tags( $new_instance['phone_url'] );

		$instance['fax'] = strip_tags( $new_instance['fax'] );
		$instance['email'] = strip_tags( $new_instance['email'] );

		$instance['email_url'] = strip_tags( $new_instance['email_url'] );

		$instance['site'] = strip_tags( $new_instance['site'] );
		$instance['site_url'] = strip_tags( $new_instance['site_url'] );


		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['tripadvisor'] = strip_tags( $new_instance['tripadvisor'] );
		$instance['whatsapp'] = strip_tags( $new_instance['whatsapp'] );
		$instance['target'] = isset($new_instance['target']) ? 1 : 0;

		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;

	}

	public function form( $instance ) {

		$defaults = array(
            'address' => '',
            'address_url' => '',
            'phone' => '',
            'phone_url' => '',
            'fax' => '',
            'email' => '',
            'email_url' => '',
            'site' => '',
            'site_url' => '',
            'facebook' => '',
            'twitter' => '',
            'youtube' => '',
            'pinterest' => '',
            'linkedin' => '',
			'instagram' => '',
			'tripadvisor' => '',
			'whatsapp' => '',
			'target' => '',
        );

		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
			<?php echo esc_html__('Title', 'zante'); ?>:
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>

	<?php

	$instance = wp_parse_args( (array) $instance, $defaults );

	?>

	<!-- Address -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'address' )); ?>"><?php echo esc_html__('Address', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>" value="<?php echo esc_attr($instance['address']); ?>" placeholder="<?php echo __('Text', 'eagle') ?>" style="width:100%;" />
		<input id="<?php echo esc_attr($this->get_field_id( 'address_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address_url' )); ?>" value="<?php echo esc_attr($instance['address_url']); ?>" placeholder="<?php echo __('URL', 'eagle') ?>" style="width:100%; margin-top: 10px;" />
	</p>


	<!-- Phone -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>"><?php echo esc_html__('Phone', 'zante' ) ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone' )); ?>" value="<?php echo esc_attr($instance['phone']); ?>" placeholder="<?php echo __('Text', 'eagle') ?>" style="width:100%;" />
		<input id="<?php echo esc_attr($this->get_field_id( 'phone_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_url' )); ?>" value="<?php echo esc_attr($instance['phone_url']); ?>" placeholder="<?php echo __('Phone Number', 'eagle') ?>" style="width:100%; margin-top: 10px;" />
	</p>

	<!-- Fax -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'fax' )); ?>"><?php echo esc_html__('Fax', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'fax' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fax' )); ?>" value="<?php echo esc_attr($instance['fax']); ?>" style="width:100%;" />
	</p>

	<!-- Email -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'email' )); ?>"><?php echo esc_html__('Email', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" value="<?php echo esc_attr($instance['email']); ?>" placeholder="<?php echo __('Text', 'eagle') ?>" style="width:100%;" />
		<input id="<?php echo esc_attr($this->get_field_id( 'email_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email_url' )); ?>" value="<?php echo esc_attr($instance['email_url']); ?>" placeholder="<?php echo __('Email Address', 'eagle') ?>" style="width:100%; margin-top: 10px;" />
	</p>

	<!-- Website -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'site' )); ?>"><?php echo esc_html__('Site', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'site' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'site' )); ?>" value="<?php echo esc_attr($instance['site']); ?>" placeholder="<?php echo __('Text', 'eagle') ?>" style="width:100%;" />
		<input id="<?php echo esc_attr($this->get_field_id( 'site_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'site_url' )); ?>" value="<?php echo esc_attr($instance['site_url']); ?>" placeholder="<?php echo __('URL', 'eagle') ?>" style="width:100%; margin-top: 10px;" />
	</p>

	<!-- Facebook -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php echo esc_html__('Facebook Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook' )); ?>" value="<?php echo esc_attr($instance['facebook']); ?>" style="width:100%;" />
	</p>

	<!-- Twitter -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php echo esc_html__('Twitter Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter' )); ?>" value="<?php echo esc_attr($instance['twitter']); ?>" style="width:100%;" />
	</p>

	<!-- Youtube -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php echo esc_html__('Youtube Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube' )); ?>" value="<?php echo esc_attr($instance['youtube']); ?>" style="width:100%;" />
	</p>

	<!-- Pinterest -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php echo esc_html__('Pinterest Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest' )); ?>" value="<?php echo esc_attr($instance['pinterest']); ?>" style="width:100%;" />
	</p>

	<!-- Linkedin -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>"><?php echo esc_html__('Linkedin Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'linkedin' )); ?>" value="<?php echo esc_attr($instance['linkedin']); ?>" style="width:100%;" />
	</p>

	<!-- Instagram -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php echo esc_html__('Instagram Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram' )); ?>" value="<?php echo esc_attr($instance['instagram']); ?>" style="width:100%;" />
	</p>

	<!-- Tripadvisor -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tripadvisor' )); ?>"><?php echo esc_html__('TripAdvisor Link', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'tripadvisor' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tripadvisor' )); ?>" value="<?php echo esc_attr($instance['tripadvisor']); ?>" style="width:100%;" />
	</p>

	<!-- whatsapp -->
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'whatsapp' )); ?>"><?php echo esc_html__('WhatsApp Link (https://wa.me/1XXXXXXXXXX)', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'whatsapp' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'whatsapp' )); ?>" value="<?php echo esc_attr($instance['whatsapp']); ?>" style="width:100%;" />
	</p>

	<!-- Target Option -->
	<p>
		<label><input type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'target' )); ?>" value="1" <?php echo esc_attr( checked($instance['target'], 1, true) ); ?> /><?php echo esc_html__( 'Open links in a new window', 'zante' ); ?></label>
	</p>


	<?php

	}
}
