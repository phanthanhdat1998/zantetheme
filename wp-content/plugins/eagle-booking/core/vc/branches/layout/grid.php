<?php
/*---------------------------------------------------------------------------------
Branches
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_branches') ) {
    function eb_branches($atts, $content = null) {
        extract(shortcode_atts(array(
            'branches_filters' => '',
            'branches_limit' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'taxonomy'               => 'eagle_branch',
            'hide_empty'             => false,
        );

        $branches_qry = new WP_Term_Query($args);

        ?>

        <div class="eb-g-3 eb-branches-grid">

            <?php

            if (!empty($branches_qry->terms)) {

                foreach ($branches_qry->terms as $eb_branch_term) {

                $eb_branch_id = $eb_branch_term->term_id;
                $eb_branch_name = get_term_field( 'name', $eb_branch_term );
                $eb_branch_logo = get_term_meta( $eb_branch_id, 'eb_branch_logo', true );
                $eb_branch_bg = get_term_meta( $eb_branch_id, 'eb_branch_bg', true );
                $eb_branch_address = get_term_meta( $eb_branch_id, 'eb_branch_address', true );
                $eb_branch_phone = get_term_meta( $eb_branch_id, 'eb_branch_phone', true );
                $eb_branch_email = get_term_meta( $eb_branch_id, 'eb_branch_email', true );
                $eb_branch_url = get_term_link($eb_branch_id);

            ?>
                <div class="eb-branch-item">
                    <a href="<?php echo esc_url( $eb_branch_url ) ?>">
                        <figure style="background-image: url(<?php echo esc_url( $eb_branch_bg ) ?>); background-size: cover">
                            <h3 class="eb-branch-item-title"><?php echo esc_html( $eb_branch_name ) ?></h3>
                        </figure>

                        <div class="eb-branch-item-info">
                            <ul>
                                <li><i class="las la-map-marker-alt"></i> <span class="text"><?php echo $eb_branch_address ?></span></li>
                                <li><i class="las la-phone"></i> <span class="text"><?php echo $eb_branch_phone ?></span></li>
                                <li><i class="las la-envelope"></i> <span class="text"><?php echo $eb_branch_email ?></span></li>
                            </ul>
                        </div>
                    </a>

                </div>

          <?php } } ?>

            <?php wp_reset_postdata(); ?>

        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    // Shortcode
    add_shortcode('eb-branches', 'eb_branches');

    add_shortcode('eb_branches', 'eb_branches');

}
