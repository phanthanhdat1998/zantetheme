<?php

$eb_services_array = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_services', true ) ;

if($eb_services_array) : ?>

<div class="room-services">
    <div class="dragscroll">

<?php

    $eb_services_counter = count($eb_services_array);

    for ($eb_services_array_i = 0; $eb_services_array_i < $eb_services_counter; $eb_services_array_i++) :

        $eb_page_by_path = get_post($eb_services_array[$eb_services_array_i],OBJECT,'eagle_services');
        $eb_service_id = $eb_page_by_path->ID;
        $eb_service_name = get_the_title($eb_service_id);

        // FONT ICON & CUSTOM IMAGE
        $eb_service_icon_type = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon_type', true );
        if ($eb_service_icon_type == 'fontawesome') {
            $eb_service_icon = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon_fontawesome', true );
        } else {
            $eb_service_icon = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon', true );
        }

        $eb_mtb_service_image = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_image', true );
        $eb_mtb_service_image_class_original = str_replace(' ', '-', $eb_service_name);
        $eb_mtb_service_image_class = strtolower($eb_mtb_service_image_class_original);
        $eb_service_description = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_description', true );
        ?>
        <div class="room-service-item" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $eb_service_description ?>" data-original-title="<?php echo $eb_service_name ?>">
            <?php if ($eb_service_icon_type == 'customicon') : ?>
                <img src="<?php echo esc_url($eb_mtb_service_image) ?>" class="<?php echo esc_attr($eb_mtb_service_image_class) ?>" loading="lazy">
            <?php else : ?>
                <i class="<?php echo $eb_service_icon ?>"></i>
            <?php endif ?>
        </div>

    <?php endfor ?>

    </div>
</div>

<?php endif ?>