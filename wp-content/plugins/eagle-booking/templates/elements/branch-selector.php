<?php
   /**
    * The Template for the branch selector
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/elements/branch-selector.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.0
    */

   defined('ABSPATH') || exit;

?>

<label for="eagle_booking_guests"><?php echo __('Branch','eagle-booking') ?></label>

<div class="eb-select">

    <div class="form-control" id="branch_text"><?php echo __('All Branches', 'eagle-booking') ?></div>

    <ul class="eb-select-list">

        <li class="selected"><?php echo __('All Branches', 'eagle-booking') ?></li>

        <?php

        $args = array(
            'taxonomy'               => 'eagle_branch',
            'hide_empty'             => true,
        );

        $branch_query = new WP_Term_Query($args);

        if ( !empty( $branch_query->terms ) ) {

            foreach ( $branch_query->terms as $eb_branch ) {

                $eb_branch_id = $eb_branch->term_id;
                $eb_branch_name = get_term_field( 'name', $eb_branch );


                echo '<li data-branch-id="'.$eb_branch_id.'">'.$eb_branch_name.'</li >';

            }
        }

        ?>
    </ul>

    <input type="hidden" id="eb_branch" name="eb_branch" value="all">

</div>
