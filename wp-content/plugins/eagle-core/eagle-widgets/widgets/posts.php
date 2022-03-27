<?php
/**
 * @ Recent posts widget extended.
 * @ since      1.0.0
 * @ author     Eagle-Themes (Jomin Muskaj)
 * @ Author URI:  http://eagle-themes.com
*/

class Zante_Recent_Posts_Widget extends WP_Widget {

  function __construct() {
    $widget_ops = array( 'classname' => 'zante_recent_posts_widget', 'description' => esc_html__( 'Display your category list with this widget', 'zante' ) );
    $control_ops = array( 'id_base' => 'zante_recent_posts_widget' );
    parent::__construct( 'zante_recent_posts_widget', esc_html__( 'Zante - Recent Posts', 'zante' ), $widget_ops, $control_ops );

    $this->defaults = array(
      'title' => esc_html__( 'Zante Recent Posts', 'zante' ),
      'categories' => array(),
      'count' => 1,
      'class' => 'categories'
    );
  }

  // WIDGET CONFIGURATION
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Zante - Recent Posts', 'zante' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

    // WIDGET OUTPUT
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		), $instance ) );

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<?php echo wp_kses_post($args['before_widget']); ?>
		<?php
		if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		}
		?>
    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
      <?php if (has_post_thumbnail()) : ?>
        <!-- ITEM -->
        <div class="recent-post-item">
          <div class="row">
            <!-- IMAGE -->
            <div class="col-md-6 col-sm-6 col-xs-6">
              <figure class="slide-right-hover">
                  <a href="<?php esc_url( the_permalink() ) ?>">
                    <img src="<?php  echo the_post_thumbnail_url('zante_image_size_720_520')  ?>" class="img-responsive" alt="<?php echo the_title_attribute() ?>">
                  </a>
              </figure>
            </div>
            <!-- DETAILS -->
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="details">
                <h6 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
                <?php if ( $show_date ) : ?>
                    <span class="post-date"><i class="fa fa-clock-o"></i> <?php echo esc_html( get_the_date() ); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
       <?php endif ?>
    <?php endwhile; ?>

		<?php
		echo wp_kses_post($args['after_widget']);
	}

  // UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

  // FORMS
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__('Title', 'zante'); ?>:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php echo esc_html__( 'Number of posts to show', 'zante' ); ?>:</label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php echo esc_html__( 'Display post date?', 'zante' ); ?></label></p>
<?php
	}
}
