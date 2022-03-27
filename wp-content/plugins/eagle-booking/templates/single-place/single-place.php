<?php
/**
 * The Template for displaying single place
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-place/single-place.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;

get_header();

if (have_posts()) : the_post();

?>

<main class="single-place">

      <!-- Place  -->
      <article class="blog_post place-details">

        <!-- Image -->
        <div class="place-image">
          <?php if (has_post_thumbnail()) : ?>
          <figure>
              <img src="<?php echo the_post_thumbnail_url('eagle_booking_image_size_1920_800')  ?>" class="img-responsive" alt="<?php echo the_title_attribute() ?>">
          </figure>

          <!-- Title -->
          <div class="place-title">
            <div class="container">
            <h1 class="title"><?php echo get_the_title() ?></h1>
            </div>
          </div>
          <?php endif ?>
        </div>

      <div class="container">
      <?php
       $eagle_booking_sidebar = get_post_meta( get_the_ID(), 'eagle_booking_mtb_place_sidebar', true);
       if ( $eagle_booking_sidebar === 'none' || $eagle_booking_sidebar === ''  ) {
          $col_class = 'col-md-12';
        } else {
          $col_class = 'col-md-9';
        }
       ?>

      <!-- Left Sidebar -->
      <?php if ( $eagle_booking_sidebar === 'left' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif ?>

      <!-- Details -->
      <div class="<?php echo esc_attr($col_class) ?> details">

          <!-- Content -->
          <div class="content entry">
              <?php the_content() ?>
          </div>
          <!-- Meta -->
          <div class="meta_post">

          <!-- SHARE BUTTONS -->
          <div class="share">
            <?php eb_social_share() ?>
          </div>

          </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <?php if ( $eagle_booking_sidebar === 'right' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif ?>

      </div>
    </article>
</main>

<?php endif ?>
<?php get_footer() ?>
