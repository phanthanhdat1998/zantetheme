<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Zante_About_Footer_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'zante_about_footer_widget',
			esc_html__( 'Zante - About (Footer)', 'zante' ),
			array(
				'description' => esc_html__( 'A widget that displays an about logo and description', 'zante' ),
				'classname' => 'about-footer'
			)
		);
	}
	public function widget( $args, $instance ) {
		extract( $args );
		if(empty($instance)){
			$instance = array(
                'image' => '',
                'description' => '',
                'height' => '30'
                );
		}
		$image = $instance['image'];
		$description = $instance['description'];
		if (isset($instance['height'])) {
			$height = $instance['height'];
		}
		echo wp_kses_post($args['before_widget']);
		?>
        <?php if(!empty($image)) :
            $image_full = wp_get_attachment_image_src($instance['image'],'full');
            $title = get_bloginfo( 'name' );
        ?>
            <img src="<?php echo esc_url($image_full[0]); ?>" alt="<?php echo esc_attr($title); ?>" class="mb5" <?php if(!empty($height)) : ?>style="height: <?php echo esc_html($height) ?>px" <?php endif ?> />
        <?php endif; ?>
        <p><?php echo wp_kses($description, wp_kses_allowed_html( 'post' )); ?></p>


    <?php

		echo wp_kses($after_widget, wp_kses_allowed_html( 'post' ));
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['description'] = $new_instance['description'];
		$instance['height'] = $new_instance['height'];

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
            'image' => '',
            'description' => '',
            'height' => '',
        );

		$instance = wp_parse_args( (array) $instance, $defaults );
		$image_full = wp_get_attachment_image_src($instance['image'],'full');
		?>
        <p class="upload-item"><label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php echo esc_html('Logo', 'zante') ?>:</label><br />

	    <img class="custom_media_image" src="<?php echo esc_url($image_full[0]); ?>" style="display:block;max-width:100%;height:auto;margin-bottom:8px;" />



        <input type="hidden" class="widefat custom_media_id" name="<?php echo esc_attr($this->get_field_name('image')); ?>" id="<?php echo esc_attr($this->get_field_id('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>">
        <input type="button" value="<?php echo esc_html__( 'Upload Image', 'zante' ); ?>" class="button custom_media_upload" id="custom_image_uploader" />
        <input type="button" value="<?php echo esc_html__( 'Remove', 'zante' ); ?>" class="button custom_media_upload_remove" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'height' )); ?>"><?php echo esc_html__('Logo Height', 'zante') ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'height' )); ?>" value="<?php echo esc_attr($instance['height']); ?>" style="width:100%;" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php echo esc_html('About', 'zante') ?></label>

      <textarea id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" style="width:100%;" rows="4"><?php echo wp_kses($instance['description'], wp_kses_allowed_html( 'post' )); ?></textarea></p>


<?php
	}
}
