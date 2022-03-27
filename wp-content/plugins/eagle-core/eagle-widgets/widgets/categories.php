<?php
/**
 * Category widget class
 *
 * @since  1.0
 */

class Zante_Category_Widget extends WP_Widget {

	var $defaults;

	function __construct() {
		$widget_ops = array( 'classname' => 'zante_category_widget', 'description' => esc_html__( 'Display your category list with this widget', 'zante' ) );
		$control_ops = array( 'id_base' => 'zante_category_widget' );
		parent::__construct( 'zante_category_widget', esc_html__( 'Zante - Categories', 'zante' ), $widget_ops, $control_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Zante Categories', 'zante' ),
			'categories' => array(),
			'count' => 1,
			'class' => 'categories'
		);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo wp_kses_post($before_widget);

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( !empty($title) ) {
			echo wp_kses_post($before_title . $title . $after_title);
		}

		?>
    <div class="inner">
        <ul class="categories">
            <?php //$cats = get_categories( array( 'include'	=> $instance['categories'])); ?>
            <?php $cats = get_categories(); ?>
            <?php foreach($cats as $cat): ?>
            <li>
                <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class=""><?php echo esc_html( $cat->name ); ?>
                <?php if(!empty($instance['count'])): ?>
                    <span class="num_posts">
                        <?php echo wp_kses_post($cat->count); ?>
                    </span>
                <?php endif; ?>
								</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php
		echo wp_kses_post($after_widget);
	}


	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['categories'] = !empty($new_instance['categories']) ? $new_instance['categories'] : array();
		$instance['count'] = isset($new_instance['count']) ? 1 : 0;
		$instance['type'] = $new_instance['type'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults ); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title', 'zante' ); ?>:</label>
            <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <?php $cats = get_categories( array( 'hide_empty' => false, 'number' => 0 ) ); ?>
        <?php //$cats = zante_sort_option_items( $cats,  $instance['categories']); ?>

        <p>
            <label><?php echo esc_html__( 'Choose (re-order) categories:', 'zante' ); ?></label><br/>
            <div class="zante-widget-content-sortable">
                <?php foreach ( $cats as $cat ) : ?>
                <?php $checked = in_array( $cat->term_id, $instance['categories'] ) ? 'checked' : ''; ?>
                <label><input type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'categories' )); ?>[]" value="<?php echo esc_attr($cat->term_id); ?>" <?php echo esc_attr($checked); ?> /><?php echo esc_html( $cat->name );?></label>
                <?php endforeach; ?>
            </div>
            <small class="howto"><?php echo esc_html__( 'Note: Leave empty to display all categories', 'zante' ); ?></small>
        </p>

        <p>
            <label><input type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="1" <?php echo esc_attr( checked($instance['count'], 1, true) ); ?> /><?php echo esc_html__( 'Show post count?', 'zante' ); ?></label>
        </p>

        <?php
	}

}
