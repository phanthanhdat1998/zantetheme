<?php if ( zante_page_title() ) :

$zante_page_title_bg_image_mtb = get_post_meta( get_the_ID(), 'zante_mtb_page_title_bg_image', true);

if ( $zante_page_title_bg_image_mtb != '' ) {

  $zante_page_title_bg_image = $zante_page_title_bg_image_mtb;

} else {

  $zante_page_title_bg_image = zante_get_option('page_header_image_bg');

}

if ( zante_get_option('page_header') == 'image' || ( zante_get_option('page_header') == 'color' && $zante_page_title_bg_image_mtb != '' ) ) {

  $class=  'gradient-overlay page-title-image';
  $style = 'background-image: url(' .esc_url( $zante_page_title_bg_image ).  '); background-size: cover';

} else {

  $class=  '';
  $style = 'background:' .zante_get_option('page_header_color_bg');

}

?>

<div class="page-title <?php echo esc_attr( $class ) ?>" style="<?php echo esc_attr( $style ) ?>">
  <div class="container">
      <div class="inner">
        <h1><?php single_post_title(); ?></h1>
        <?php if ( zante_get_option('breadcrumb_page')) : zante_get_breadcrumb(); endif ?>
      </div>
  </div>
</div>

<?php endif ?>
