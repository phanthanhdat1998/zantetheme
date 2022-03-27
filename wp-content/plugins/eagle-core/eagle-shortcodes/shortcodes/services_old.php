<?php
/*---------------------------------------------------------------------------------
SERVICES
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_services') ) {
    function eagle_services($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'services_tab_autoplay' => '',
            'services_tab_transition' => '',
            'services_tab_1_title' => '',
            'services_tab_1_desc' => '',
            'services_tab_1_image' => '',
            'services_tab_1_icon' => '',
            'services_tab_2_title' => '',
            'services_tab_2_desc' => '',
            'services_tab_2_image' => '',
            'services_tab_2_icon' => '',
            'services_tab_3_title' => '',
            'services_tab_3_desc' => '',
            'services_tab_3_image' => '',
            'services_tab_3_icon' => '',
            'services_tab_4_title' => '',
            'services_tab_4_desc' => '',
            'services_tab_4_image' => '',
            'services_tab_4_icon' => '',
        ), $atts));

        ob_start();

      ?>

      <?php
      $token = wp_generate_password(5, false, false);
      if (is_rtl()) {
          $zante_rtl = "true";
      } else {
          $zante_rtl = "false";
      }
      ?>

      <?php

        // get icons
        $services_tab_1_icon = wp_get_attachment_url( $services_tab_1_icon );
        $services_tab_2_icon = wp_get_attachment_url( $services_tab_2_icon );
        $services_tab_3_icon = wp_get_attachment_url( $services_tab_3_icon );
        $services_tab_4_icon = wp_get_attachment_url( $services_tab_4_icon );
        // get images
        $services_tab_1_image = wp_get_attachment_url( $services_tab_1_image );
        $services_tab_2_image = wp_get_attachment_url( $services_tab_2_image );
        $services_tab_3_image = wp_get_attachment_url( $services_tab_3_image );
        $services_tab_4_image = wp_get_attachment_url( $services_tab_4_image );
       ?>

    <script>
      jQuery(document).ready(function ($) {
        $('#features-slider-<?php echo esc_attr( $token ); ?>').owlCarousel({
            thumbs: true,
            thumbsPrerendered: true,
            items: 1,
            <?php
            if ( $services_tab_transition == 'fade' ) : ?>
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            <?php endif ?>
            loop: true,
            <?php
            if ( $services_tab_autoplay == true ) : ?>
            autoplay: true,
            <?php endif ?>
            dots: false,
            nav: false,
            touchDrag  : true,
            mouseDrag  : false
          });
      });
    </script>

    <div class="features">
      <div class="row">
          <div class="col-md-7">
              <div data-slider-id="features-<?php echo esc_attr( $token ); ?>" id="features-slider-<?php echo esc_attr( $token ); ?>" class="main-image owl-carousel">
                  <div class="gradient-overlay overlay-opacity-02"><img src="<?php echo esc_url ( $services_tab_1_image ) ?>" class="img-responsive" alt="<?php echo esc_html( $services_tab_1_title ) ?>"></div>
                  <div class="gradient-overlay overlay-opacity-02"><img src="<?php echo esc_url ( $services_tab_2_image ) ?>" class="img-responsive" alt="<?php echo esc_html( $services_tab_2_title ) ?>"></div>
                  <div class="gradient-overlay overlay-opacity-02"><img src="<?php echo esc_url ( $services_tab_3_image ) ?>" class="img-responsive" alt="<?php echo esc_html( $services_tab_3_title ) ?>"></div>
                  <div class="gradient-overlay overlay-opacity-02"><img src="<?php echo esc_url ( $services_tab_4_image ) ?>" class="img-responsive" alt="<?php echo esc_html( $services_tab_4_title ) ?>"></div>
              </div>
          </div>
          <div class="col-md-5">
              <div class="owl-thumbs" data-slider-id="features-<?php echo esc_attr( $token ); ?>">
                  <!-- SLIDE -->
                  <div class="owl-thumb-item">
                      <span class="media-left"><image src="<?php echo esc_url( $services_tab_1_icon ) ?>" alt="<?php echo esc_html( $services_tab_1_title ) ?>"></span>
                      <div class="media-body">
                          <h3><?php echo esc_html( $services_tab_1_title ) ?></h3>
                          <p><?php echo esc_html( $services_tab_1_desc ) ?></p>
                      </div>
                  </div>
                  <!-- SLIDE -->
                  <div class="owl-thumb-item">
                      <span class="media-left"><image src="<?php echo esc_url( $services_tab_2_icon ) ?>" alt="<?php echo esc_html( $services_tab_2_title ) ?>"></span>
                      <div class="media-body">
                          <h3><?php echo esc_html( $services_tab_2_title ) ?></h3>
                          <p><?php echo esc_html( $services_tab_2_desc ) ?></p>
                      </div>
                  </div>
                  <!-- SLIDE -->
                  <div class="owl-thumb-item">
                      <span class="media-left"><image src="<?php echo esc_url( $services_tab_3_icon ) ?>" alt="<?php echo esc_html( $services_tab_3_title ) ?>"></span>
                      <div class="media-body">
                          <h3><?php echo esc_html( $services_tab_3_title ) ?></h3>
                          <p><?php echo esc_html( $services_tab_3_desc ) ?></p>
                      </div>
                  </div>
                  <!-- SLIDE -->
                  <div class="owl-thumb-item">
                      <span class="media-left"><image src="<?php echo esc_url( $services_tab_4_icon ) ?>" alt="<?php echo esc_html( $services_tab_4_title ) ?>"></span>
                      <div class="media-body">
                          <h3><?php echo esc_html( $services_tab_4_title ) ?></h3>
                          <p><?php echo esc_html( $services_tab_4_desc ) ?></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
      <?php
      $result = ob_get_contents();
      ob_end_clean();
      return $result;
    }

    add_shortcode('zante-services', 'eagle_services');
}
