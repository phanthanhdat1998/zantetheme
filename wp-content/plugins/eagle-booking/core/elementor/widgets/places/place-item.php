<div class="places-item <?php echo esc_attr( $eb_place_class ) ?>">
    <figure class="<?php if ( $settings['places_gradient_overlay'] ) { echo 'gradient-overlay'; } ?>">
        <a href="<?php echo esc_url( $eb_place_url ) ?>">
            <img src="<?php echo esc_url( $eb_place_img_url ) ?>" class="img-fluid" alt="<?php echo esc_attr( $eb_place_title ) ?>">
        </a>
        <figcaption><?php echo esc_html( $eb_place_title ) ?></figcaption>
    </figure>
</div>