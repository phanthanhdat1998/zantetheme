<?php
/**
 * The Template for displaying rooms in list view
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/room-list.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;

?>

<div id="eb-archive-room-<?php echo $eb_room_id ?>" class="room-list-item room-list-item-archive sidebar-none">
    <div class="row flex-row">
        <div class="col-md-4">
            <?php if ( has_post_thumbnail() ) : ?>
            <figure class="gradient-overlay overlay-opacity-02 slide-right-hover">
                <a href="<?php echo esc_url($eb_room_url) ?>">
                <img alt="<?php echo esc_html($eb_room_title) ?>" src="<?php echo eagle_booking_get_room_img_url(get_the_ID(), 'eagle_booking_image_size_720_470') ?>">
                </a>
            </figure>
            <?php endif ?>
        </div>
        <div class="col-md-5">
            <div class="room-details">
                <h3 class="title">
                    <a href="<?php echo esc_url($eb_room_url) ?>"><?php echo $eb_room_title ?></a>
                </h3>
                <p style="margin-top: 20px;"><?php echo $eb_room_description ?></p>

                <?php
                    /**
                    * Include room services
                    */
                    include eb_load_template('room-services.php');
                ?>

            </div>
        </div>

        <div class="col-md-3">
            <div style="padding: 62px 30px; text-align: center">
                <?php eb_room_price( get_the_ID(), __('per night', 'eagle-booking') ) ?>
                <a href="<?php echo esc_url ( $eb_room_url ) ?>" class="btn eb-btn"><?php echo esc_html__('More Details', 'eagle-booking') ?> <i class="fa fa fa-chevron-right"></i></a>
            </div>
        </div>

    </div>
</div>