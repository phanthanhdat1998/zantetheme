<?php
/*---------------------------------------------------------------------------------
SERVICES
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_services_v2') ) {
    function eagle_services_v2($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'services_tab_autoplay' => '',
            'services_tab_transition' => '',
            'services_slides' => ' ',
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

<?php
$values = vc_param_group_parse_atts($atts['services_slides']);

$new_accordion_value = array();
if ($values) :
  foreach($values as $data) :
    $new_line = $data;
    $new_line['service_title'] = isset($new_line['service_title']) ? $new_line['service_title'] : '';
    $new_line['service_desc'] = isset($new_line['service_desc']) ? $new_line['service_desc'] : '';
    $new_line['service_image'] = isset($new_line['service_image']) ? $new_line['service_image'] : '';
    $new_line['service_icon'] = isset($new_line['service_icon']) ? $new_line['service_icon'] : '';

    $new_accordion_value[] = $new_line;

  endforeach;
endif;

$idd = 0;
foreach($new_accordion_value as $accordion) :
$idd++;
$service_image = wp_get_attachment_url( $accordion['service_image'] );
?>

  <div class="gradient-overlay overlay-opacity-02"><img src="<?php echo esc_url ( $service_image ) ?>" class="img-responsive" alt="<?php echo esc_html( $accordion['service_title'] ) ?>"></div>

  <?php

endforeach;
 ?>
</div>
</div>
<div class="col-md-5">
  <div class="owl-thumbs" data-slider-id="features-<?php echo esc_attr( $token ); ?>">

    <?php
      $values = vc_param_group_parse_atts( $atts['services_slides'] );

      $new_accordion_value = array();
      if ($values) :
      foreach($values as $data) :
        $new_line = $data;
        $new_line['service_title'] = isset($new_line['service_title']) ? $new_line['service_title'] : '';
        $new_line['service_desc'] = isset($new_line['service_desc']) ? $new_line['service_desc'] : '';
        $new_line['service_image'] = isset($new_line['service_image']) ? $new_line['service_image'] : '';
        $new_line['service_icon'] = isset($new_line['service_icon']) ? $new_line['service_icon'] : '';

        $new_accordion_value[] = $new_line;
      endforeach;
    endif;

      $idd = 0;
      foreach($new_accordion_value as $accordion):
      $idd++;
      $service_icon = wp_get_attachment_url( $accordion['service_icon'] );
    ?>

    <!-- SLIDE -->
    <div class="owl-thumb-item">
        <span class="media-left"><image src="<?php echo esc_url( $service_icon ) ?>" alt="<?php echo esc_html( $accordion['service_title'] ) ?>"></span>
        <div class="media-body">
            <h3><?php echo esc_html( $accordion['service_title'] ) ?></h3>
            <p><?php echo esc_html( $accordion['service_desc'] ) ?></p>
        </div>
    </div>

    <?php endforeach ?>

  </div>
</div>
</div>
</div>

  <?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

    add_shortcode('zante-services-v2', 'eagle_services_v2');
}
