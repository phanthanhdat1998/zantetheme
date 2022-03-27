
<?php

/**
* The Template for the room hotel branch
*
* This template can be overridden by copying it to yourtheme/eb-templates/single-room/branch.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.0
*/

defined('ABSPATH') || exit;

?>

<?php if ( eb_room_has_branch( $eb_room_id ) ) : ?>

    <div class="eb-room-branch eb-widget eb-widget-border">

        <?php
            echo __('This room is part of', 'eagle-booking').' ';
            echo eb_room_branch( $eb_room_id, true );
        ?>

    </div>

<?php endif ?>