<?php
/**
 * The Template for displaying rooms in grid view
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/room-grid.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;

?>

<div class="room-item <?php echo esc_attr( $eb_room_item_class ) ?>">

    <figure class="room-image gradient-overlay overlay-opacity-02 slide-right-hover">
        <?php eb_room_price( get_the_ID(), ' / '.__('night', 'eagle-booking') ) ?>
        <a href="<?php echo esc_url( $eb_room_url ) ?>">
            <img src="<?php echo esc_url( $eb_room_img_url ) ?>" alt="<?php echo esc_html( $eb_room_title ) ?>">
        </a>
    </figure>

    <div class="room-details">

        <h3 class="room-title">
            <a href="<?php echo esc_url( $eb_room_url ) ?>"><?php echo esc_html( $eb_room_title ) ?></a>
        </h3>

        <?php
            /**
            * Include room services
            */
            include eb_load_template('room-services.php');
        ?>

    </div>

</div>