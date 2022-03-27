<?php
/*---------------------------------------------------------------------------------
POSTS
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_blog_posts_grid') ) {
    function eagle_blog_posts_grid($atts, $content = null)
    {
        extract(shortcode_atts(array(
            // 'category_id' => '',
            'posts_limit' => '',
            'offset' => '',
        ), $atts));

        ob_start();

        $wp_query_args = array(
            'ignore_sticky_posts' => 1,
            'post_type' => 'post',
            'meta_query' => array(
		        array(
			        'key'     => '_thumbnail_id',
		        )
            )
        );
        if (!empty($category_id)) {
            $wp_query_args['cat'] = $category_id;
        }
        if (!empty($offset)) {
            $wp_query_args['offset'] = $offset;
        }
        $wp_query_args['post_status'] = 'publish';

        if (empty($posts_limit)) {
            $posts_limit = get_option('posts_per_page');
        }
        $wp_query_args['posts_per_page'] = $posts_limit;

        $the_query = New WP_Query($wp_query_args);
        ?>

        <div class="latest-posts-grid">
            <div class="row grid-row">
                <?php if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
                  <?php if (has_post_thumbnail()) : ?>
                    <?php
                        $post_thumbnail = get_the_post_thumbnail_url('', 'zante_image_size_720_520');
                        $post_title = get_the_title();
                        $post_url = get_permalink();
                        $post_author = get_the_author_meta('display_name');
                        $post_author_id = get_the_author_meta('ID');
                        $post_author_gravatar = get_avatar_url($post_author_id, array('size' => 13));
                        $post_author_url = get_author_posts_url("ID");
                        $post_date = get_the_date();
                        $post_date_link = get_day_link('', '', '');
                        $post_comments = get_comments_number();
                        $posts_more_link = get_permalink( get_option( 'page_for_posts' ) );
                     ?>
                    <!-- ITEM -->
                    <div class="col-md-4 col-sm-4">
                        <article class="news-grid-item">
                          <figure class="gradient-overlay slide-right-hover">
                              <a href="<?php echo esc_url( $post_url ) ?>"><img src="<?php echo esc_url( $post_thumbnail ) ?>" class="img-responsive" alt="<?php echo esc_html( $post_title ) ?>"></a>
                          </figure>
                          <div class="details">
                              <h3><a href="<?php echo esc_url( $post_url ) ?>"><?php echo esc_html( $post_title ) ?></a></h3>
                              <p><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                              <!-- <a href="<?php echo esc_url( $post_url ) ?>" class="button btn_xs btn_blue"><?php echo zante_tr( 'read_more' ) ?></a> -->
                              <div class="info">
                                  <a href="<?php echo esc_url( $post_author_url ) ?>">
                                    <img class="author-avatar" src="<?php echo esc_url($post_author_gravatar) ?>" alt="<?php echo esc_html( $post_author ) ?>"><?php echo esc_html( $post_author ) ?>
                                  </a>
                                  <i class="las la-clock"></i><a href="<?php echo esc_url( $post_date_link ) ?>"><?php echo esc_html( $post_date ) ?></a>
                                  <i class="las la-comments"></i><a href="<?php echo esc_url( $post_url ) ?>"><?php echo esc_html( $post_comments ) ?> <?php echo zante_tr( 'comments' ) ?></a>
                              </div>
                          </div>
                        </article>
                    </div>
                <?php endif; ?>
                <?php endwhile; endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>

          </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('zante-blog-posts-grid', 'eagle_blog_posts_grid');
}
