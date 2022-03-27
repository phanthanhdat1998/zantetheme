<?php
/**
 * The Template for displaying hotel branch
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/taxonomies/taxanomy_eagle_branch.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;

get_header();

?>

<main class="eb-branch-page no-padding">

<?php

$eb_branch_id = get_queried_object()->term_id;

$args = array('post_type' => 'eagle_rooms',
    'tax_query' => array(
        array(
            'taxonomy' => 'eagle_branch',
            'field' => 'term_id',
            'terms' => $eb_branch_id,
        ),
    ),
);

$eb_branches_query = new WP_Query($args);

$term = get_queried_object();
$term_id = $term->term_id;
$eb_branch_desc = $term->description;
$eb_branch_logo = get_term_meta( $term_id, 'eb_branch_logo', true );
$eb_branch_bg = get_term_meta( $term_id, 'eb_branch_bg', true );
$eb_branch_address = get_term_meta( $term_id, 'eb_branch_address', true );
$eb_branch_phone = get_term_meta( $term_id, 'eb_branch_phone', true );
$eb_branch_email = get_term_meta( $term_id, 'eb_branch_email', true );

?>

    <div class="eb-branch-header">

        <div class="eb-container">

            <div class="eb-branch-cover">

                <div class="eb-branch-image" data-src="<?php echo esc_url( $eb_branch_bg ) ?>" data-parallax="scroll" data-speed="0.3" data-mirror-selector=".eb-branch-image" data-z-index="0"></div>

                <div class="eb-branch-details">
                    <div class="eb-branch-info">
                        <h1 class="eb-branch-title"><?php echo single_term_title() ?></h1>
                        <p class="eb-branch-desc"><?php echo $eb_branch_desc ?></p>

                        <ul class="eb-branch-contact">
                            <?php if ( $eb_branch_address ) : ?><li><i class="las la-map-marker-alt"></i><?php echo esc_html( $eb_branch_address ) ?></li><?php endif ?>
                            <?php if ( $eb_branch_phone ) : ?><li><i class="las la-phone"></i><?php echo esc_html( $eb_branch_phone ) ?></li><?php endif ?>
                            <?php if ( $eb_branch_email ) : ?><li><i class="las la-envelope"></i><?php echo esc_html( $eb_branch_email ) ?></li><?php endif ?>
                        </ul>

                        <div class="eb-branch-search-form">
                            <form id="search-form" class="search-form" action="<?php echo eb_search_page() ?>" method="GET">

                                <?php

                                    include_once EB_PATH . '/core/admin/form-parameters.php';

                                    include eb_load_template('elements/dates-picker.php');

                                    include eb_load_template('elements/guests-picker.php');

                                ?>

                                <input type="hidden" name="eb_branch" value="<?php echo $term_id  ?>">
                                <button id="eb_search_form" class="button eb-btn" type="submit">
                                    <span class="eb-btn-text"><?php echo __('Search', 'eagle-booking') ?></span>
                                </button>

                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="eb-container">

        <div class="eb-branch-rooms">

            <?php

            if( $eb_branches_query->have_posts()) { ?>

                <div class="eb-branch-bar">
                    <h2 class="eb-branch-rooms-title"><?php echo __('Rooms of', 'eagle-booking') ?> <?php echo single_term_title() ?></h2>
                </div>

            <?php

                while( $eb_branches_query->have_posts() ) : $eb_branches_query->the_post();

                    // Default
                    $eb_room_id = get_the_ID();
                    $eb_room_title = get_the_title();
                    $eb_room_url = get_permalink();
                    $eb_room_desc = get_post_meta( get_the_ID(), 'eagle_booking_mtb_room_description', true );

                    ?>

                    <div id="eb-archive-room-<?php echo get_the_ID() ?>" class="room-list-item room-list-item-archive sidebar-none">
                        <div class="row flex-row">
                            <div class="col-md-4">
                                <figure class="gradient-overlay overlay-opacity-02 slide-right-hover">
                                    <a href="<?php echo get_permalink() ?>">
                                        <img alt="Family Room Too Long Title  Copy" src="<?php echo eagle_booking_get_room_img_url(get_the_ID(), 'eagle_booking_image_size_720_470') ?>">
                                    </a>
                                </figure>
                            </div>

                            <div class="col-md-5">
                                <div class="room-details">
                                    <h2 class="title"><a href="<?php echo esc_url($eb_room_url) ?>"><?php echo $eb_room_title ?></a></h2>

                                    <p style="margin-top: 20px;"><?php echo $eb_room_desc ?></p>

                                    <div class="room-services">
                                    <?php
                                    $eb_services_array = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_services', true ) ;

                                    if ( !empty($eb_services_array) ) :

                                    $eb_services_counter = count($eb_services_array);

                                    if ($eb_services_counter >= '8') { $eb_services_counter = '8'; }

                                    if ( !empty(get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_services', true ) ) ) :
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
                                        <img src="<?php echo esc_url($eb_mtb_service_image) ?>" class="<?php echo esc_attr($eb_mtb_service_image_class) ?>">
                                        <?php else : ?>
                                        <i class="<?php echo $eb_service_icon ?>"></i>
                                        <?php endif ?>
                                        </div>
                                    <?php  endfor ?>
                                    <?php  endif; ?>
                                    <?php endif ?>
                                    </div>
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

                  <?php endwhile;

                } else { ?>

                    <div id="eb-no-search-results" class="eb-alert mt20 text-center" role="alert"><?php echo __('There are no rooms for this hotel branch', 'eagle-booking') ?></div>

             <?php   }


            wp_reset_query()

        ?>

        </div>

    </div>

</main>

<?php get_footer() ?>
