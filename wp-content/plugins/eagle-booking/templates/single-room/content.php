<?php
/**
 * The Template for displaying room content
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/content.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;
?>

<div class="content">
  <?php the_content(get_the_ID()) ?>
</div>
