<?php

if (isset($_GET["account_details"])) :

?>

 <!-- User Menu -->
<nav class="eb-account-menu">
    <ul class="short">
        <li class="menu-item"><a href="<?php echo esc_url( eb_account_page() ) ?>" aria-current="page"><?php echo __('Dashboard', 'eagle-booking') ?></a></li>
        <li class="menu-item"><a href="<?php echo esc_url( eb_account_page() ) ?>?bookings"><?php echo __('Bookings', 'eagle-booking') ?></a></li>
        <li class="menu-item active"><a href="<?php echo esc_url( eb_account_page() ) ?>?account_details"><?php echo __('Account Details', 'eagle-booking') ?></a></li>
        <li class="menu-item"><a href="<?php echo wp_logout_url( eb_account_page().'?sign_in' ) ?>"><?php echo __('Log Out', 'eagle-booking') ?></a></li>
    </ul>
</nav>


<?php

    // DB QUERY
    global $wpdb;

    $eb_booking_id = get_the_ID();
    $eb_current_user_id = get_current_user_id();
    $eb_current_user = wp_get_current_user();

    // Get New User Meta
    if(isset($_POST['form_submit'])) {

        $eb_user_firstname = $_POST['first_name'];
        $eb_user_lastname = $_POST['last_name'];
        $eb_user_phone = $_POST['user_phone'];
        $eb_user_address = $_POST['user_address'];
        $eb_user_city = $_POST['user_city'];
        $eb_user_country = $_POST['user_country'];
        $eb_user_zip = $_POST['user_zip'];
        $eb_user_email = $_POST['user_email'];

        // Create User Meta
        update_user_meta( $eb_current_user_id, 'first_name', $eb_user_firstname);
        update_user_meta( $eb_current_user_id, 'last_name', $eb_user_lastname);
        update_user_meta( $eb_current_user_id, 'user_phone', $eb_user_phone);
        update_user_meta( $eb_current_user_id, 'user_address', $eb_user_address);
        update_user_meta( $eb_current_user_id, 'user_city', $eb_user_city);
        update_user_meta( $eb_current_user_id, 'user_country', $eb_user_country);
        update_user_meta( $eb_current_user_id, 'user_zip', $eb_user_zip);

        if (!email_exists( $eb_user_email )){

            $args = array(
                'ID'         => $eb_current_user_id,
                'user_email' => esc_attr( $eb_user_email )
            );

            wp_update_user( $args );

        }

    ?>

        <div class="eb-alert eb-alert-success eb-alert-icon mb50" role="alert">
            <?php echo __('Your account has been updated successfully', 'eagle-booking') ?>
        </div>


    <?php

    } else {

        if ( isset($_GET['form_fill_required']) ) { ?>

            <div class="eb-alert eb-alert-info eb-alert-icon mb50" role="alert">
                <?php echo __('Please fill out all the required fields before starting a new reservation.', 'eagle-booking') ?>
            </div>

        <?php

        }

        // Get User Meta
        $eb_user_firstname = get_user_meta( $eb_current_user_id, 'first_name', true);
        $eb_user_lastname = get_user_meta( $eb_current_user_id, 'last_name', true);
        $eb_user_phone = get_user_meta( $eb_current_user_id, 'user_phone', true);
        $eb_user_address = get_user_meta( $eb_current_user_id, 'user_address', true);
        $eb_user_city = get_user_meta( $eb_current_user_id, 'user_city', true);
        $eb_user_country = get_user_meta( $eb_current_user_id, 'user_country', true);
        $eb_user_zip = get_user_meta( $eb_current_user_id, 'user_zip', true);
        $eb_user_email = $eb_current_user->user_email;
    }

?>


<h6 class="mb40"><?php echo __('Account Details', 'eagle-booking') ?></h6>

    <form method="POST">
        <div class="row flex-row">
            <div class="col-md-6">
                <label for="first_name"><?php echo __('First Name', 'eagle-booking') ?> <span class="required">*</span></label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $eb_user_firstname ?>">
            </div>

            <div class="col-md-6">
                <label for="last_name"><?php echo __('Last Name', 'eagle-booking') ?> <span class="required">*</span></label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $eb_user_lastname ?>">
            </div>

            <div class="col-md-6">
                <label for="user_email"><?php echo __('Email', 'eagle-booking') ?> <span class="required">*</span></label>
                <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo  $eb_user_email ?>">
            </div>

            <div class="col-md-6">
                <label for="user_phone"><?php echo __('Phone', 'eagle-booking') ?> <span class="required">*</span></label>
                <input type="tel" class="eb_user_phone_field form-control" value="<?php echo  $eb_user_phone ?>">
                <!-- Hidden input will be shown here -->
            </div>

            <div class="col-md-6">
                <label for="user_address"><?php echo __('Address', 'eagle-booking') ?></label>
                <input type="text" class="form-control" name="user_address" id="user_address" value="<?php echo  $eb_user_address ?>">
            </div>

            <div class="col-md-6">
                <label for="user_city"><?php echo __('City', 'eagle-booking') ?></label>
                <input type="text" class="form-control" name="user_city" id="user_city" value="<?php echo  $eb_user_city ?>">
            </div>

            <div class="col-md-6">
                <label for="user_country"><?php echo __('Country', 'eagle-booking') ?></label>
                <input type="text" class="form-control" name="user_country" id="user_country" value="<?php echo  $eb_user_country ?>">
            </div>

            <div class="col-md-6">
                <label for="user_zip"><?php echo __('ZIP', 'eagle-booking') ?></label>
                <input type="text" class="form-control" name="user_zip" id="user_zip" value="<?php echo  $eb_user_zip ?>">
            </div>

            <div class="col-md-12">
                <button type="submit" name="form_submit" class="btn eb-btn pull-right mt50"><?php echo __('Update Account Details', 'eagle-booking')?></button>
            </div>

        </div>
    </form>

    <?php

        /**
        * Include phone field translation
        */
        include eb_load_template('elements/phone-field.php');

    ?>

<?php endif ?>