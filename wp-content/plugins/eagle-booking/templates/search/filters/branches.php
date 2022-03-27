<div class="eb-widget eb-branches">

  <h2 class="title"><?php echo __('Branch','eagle-booking') ?> </h2>
  <div class="inner">

<?php

$args = array(
    'taxonomy'               => 'eagle_branch',
    'hide_empty'             => true,
);

$branch_query = new WP_Term_Query($args);

if (!empty($branch_query->terms)) {

    foreach ($branch_query->terms as $eb_branch) {

        $eb_branch_id = $eb_branch->term_id;
        $eb_branch_name = get_term_field( 'name', $eb_branch );
        $eb_branch_logo = get_term_meta( $eb_branch_id, 'eb_branch_logo', true );
        $eb_branch_url = get_term_link($eb_branch_id);

        if ( $eb_branch_id == $eb_selected_branch ) {

            echo '<div class="eb-branch-filter selected">';
            echo '<input type="checkbox" class="eb-branch-checkbox" value="'.$eb_branch_id.'" checked>';

        } else {

            echo '<div class="eb-branch-filter">';
            echo '<input type="checkbox" class="eb-branch-checkbox" value="'.$eb_branch_id.'">';
        }


        if ( $eb_branch_logo ) {

            echo '<img src="'.$eb_branch_logo.'" alt="'.esc_html($eb_branch_name).'">';

        } else {

            echo esc_html($eb_branch_name);
        }

        echo '<a href="'.esc_url($eb_branch_url).'" target="_blank" class="eb-branch-filter-link"><i class="far fa-question-circle"></i></a>';

        echo '</div>';

    }
}

?>
    <input type="hidden" id="eb_branch" value="<?php echo $eb_selected_branch ?>">

  </div>
</div>