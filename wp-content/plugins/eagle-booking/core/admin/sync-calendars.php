<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="eb-wrapper">
    <div class="eb-admin-dashboard">

        <?php

        /**
         * Include the EB admin header
         *
         * @since 1.3.2
         */
        include EB_PATH.''."core/admin/bookings/elements/admin-header.php";

        ?>

        <div class="eb-admin-title">
            <h1 class="wp-heading-inline"><?php echo __('Sync Calendars', 'eagle-booking') ?></h1>
        </div>

        <div class="eb-admin-dashboard-inner">

            <form method="POST" action="">

            </form>

        </div>

    </div>

</div>