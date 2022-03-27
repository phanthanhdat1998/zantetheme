<?php
/*---------------------------------------------------------------------------------
POSTS
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_blog_posts') ) {
    function eagle_blog_posts($atts, $content = null)
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
                    'key' => '_thumbnail_id'
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

        $news_qry = New WP_Query($wp_query_args);
        ?>

        <div class="row">

          <!-- FIRST ITEM -->
        <div class="col-md-6 first-news">
          <?php if ( $news_qry->have_posts() ) : $news_qry->the_post();
          $news_title = get_the_title();
          $news_url = get_permalink();
          $news_img_url = get_the_post_thumbnail_url('', 'zante_image_size_720_520');
          $news_cats = get_the_category_list( ' ' );
         ?>
          <div class="news-item">
            <figure class="gradient-overlay zoom-hover">
              <a href="<?php echo esc_url( $news_url ) ?>">
                <img src="<?php echo esc_url( $news_img_url ) ?>" class="img-responsive" alt="<?php echo esc_html( $news_title ) ?>">
               </a>
               <div class="news-item-details">
                 <span class="news-item-meta"><?php echo wp_kses_post($news_cats) ?></span>
                 <h3 class="news-item-title">
                   <a href="<?php echo esc_url( $news_url ) ?>"><?php echo esc_html( $news_title ) ?></a>
                 </h3>
              </div>
            </figure>
          </div>

          <?php endif; ?>
          <?php wp_reset_postdata(); ?>

        </div>

        <!-- SECOND ITEM -->
        <div class="col-md-3 second-news">
          <?php $i = 1; while ( $news_qry->have_posts() && $i++ < 2 ) : $news_qry->the_post();
          $news_title = get_the_title();
          $news_url = get_permalink();
          $news_img_url = get_the_post_thumbnail_url('', 'zante_image_size_400_800');
          $news_cats = get_the_category_list( ' ' );
         ?>
          <div class="news-item">
            <figure class="gradient-overlay zoom-hover">
              <a href="<?php echo esc_url( $news_url ) ?>">
                <img src="<?php echo esc_url( $news_img_url ) ?>" class="img-responsive" alt="<?php echo esc_html( $news_title ) ?>">
               </a>
               <div class="news-item-details">
                 <span class="news-item-meta"><?php echo wp_kses_post($news_cats) ?></span>
                 <h3 class="news-item-title">
                   <a href="<?php echo esc_url( $news_url ) ?>"><?php echo esc_html( $news_title ) ?></a>
                 </h3>
              </div>
            </figure>
          </div>

           <?php endwhile; ?>
           <?php wp_reset_postdata(); ?>
        </div>
        <!-- THIRD ITEM -->
        <div class="col-md-3 third-news">

          <?php $i = 2; while ( $news_qry->have_posts() && $i++ < 3 ) : $news_qry->the_post();
          $news_title = get_the_title();
          $news_url = get_permalink();
          $news_img_url = get_the_post_thumbnail_url('', 'zante_image_size_400_800');
          $news_cats = get_the_category_list( ' ' );
         ?>
          <div class="news-item">
            <figure class="gradient-overlay zoom-hover">
              <a href="<?php echo esc_url( $news_url ) ?>">
                <img src="<?php echo esc_url( $news_img_url ) ?>" class="img-responsive" alt="<?php echo esc_html( $news_title ) ?>">
               </a>
               <div class="news-item-details">
                 <span class="news-item-meta"><?php echo wp_kses_post($news_cats) ?></span>
                 <h3 class="news-item-title">
                   <a href="<?php echo esc_url( $news_url ) ?>"><?php echo esc_html( $news_title ) ?></a>
                 </h3>
              </div>
            </figure>
          </div>

           <?php endwhile; ?>
           <?php wp_reset_postdata(); ?>

        </div>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('zante-blog-posts', 'eagle_blog_posts');
}
