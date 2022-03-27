<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

include_once EB_PATH . '/include/licensor.php';

class EB_LICENSE {

	public $plugin_file = __FILE__;
	public $responseObj;
	public $licenseMessage;
	public $showMessage = false;
	public $slug = "eb_license";
    private $status;

	function __construct() {

		$licenseKey = get_option("eb_license_key","");
		$liceEmail = get_option( "eb_license_email","");
		$templateDir = get_stylesheet_directory();

		if( EBBase::CheckWPPlugin( $licenseKey, $liceEmail, $this->licenseMessage, $this->responseObj, $templateDir."/style.css" )){

            $this->status = true;

			add_action( 'admin_menu', [$this,'ActiveAdminMenu'], 99999);
			add_action( 'admin_post_deactivate_license', [ $this, 'action_deactivate_license' ] );

		} else {

            $this->status = false;

			if(!empty($licenseKey) && !empty($this->licenseMessage)){
				$this->showMessage = true;
			}

			update_option("eb_license_key","") || add_option("eb_license_key","");
			add_action( 'admin_post_eb_el_activate_license', [ $this, 'action_activate_license' ] );
			add_action( 'admin_menu', [$this,'InactiveMenu'], 11);

		}

        add_action( 'init', [$this, 'upgrader'], 99 );
        add_action('admin_notices', [ $this, 'license_activation_notice' ] );

    }

	function ActiveAdminMenu(){

        add_submenu_page(
            'eb_options',
            __('License', 'eagle-booking'),
            __('License', 'eagle-booking'),
            'activate_plugins',
            $this->slug,
            [$this, "ActivePage"],
            0
        );

	}

	function InactiveMenu() {

        add_submenu_page(
            'eb_options',
            __('License', 'eagle-booking'),
            __('License', 'eagle-booking'),
            'manage_options',
            $this->slug,
            [$this, "InactivePage"],
            0
        );
	}

    /**
	 * License Active Page Element
	 *
	 * @since 1.2.9.5
     */
    function ActivePage() {
        $this->Activated_Page();
    }

    /**
	 * License Inactive Page Element
	 *
	 * @since 1.2.9.5
     */
    function InactivePage() {
        $this->Not_Activated_Page();
    }

    /**
	 * Update options on license activation
	 *
	 * @since 1.2.9.5
     */
	function action_activate_license(){

		check_admin_referer( 'el-license' );

		$licenseKey = !empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
		$licenseEmail = !empty($_POST['el_license_email'])?$_POST['el_license_email']:"";

		update_option("eb_license_key",$licenseKey) || add_option("eb_license_key", $licenseKey);
		update_option("eb_license_email",$licenseEmail) || add_option("eb_license_email", $licenseEmail);

		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
	}

    /**
	 * Update options on license deactivation
	 *
	 * @since 1.2.9.5
     *
     */
    function action_deactivate_license() {

        check_admin_referer( 'el-license' );

		$message = "";

		if( EBBase::RemoveLicenseKey( __FILE__, $message )) {

            update_option('eb_license_key', '');
            update_option('eb_license_email', '');
		}

    	wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }

    /**
     * Check if EB is used with one of our theme and its license is actiated
     *
     * @since 1.3.2
     */
    public function theme_license() {

        if ( class_exists('Zante_License') ) {

            return zante_license_status();


            if ( zante_license_status() == 1 ) {

                return true;

            } else {


                return false;

            }


        } else {


            return false;

        }

    }

    /**
     * Activated Output
     *
     * @since 1.3.2
     */
	public function Activated_Page() {

        ?>

        <div class="eb-wrapper">
            <div class="eb-admin-dashboard">

                <?php

                include EB_PATH.''."core/admin/bookings/elements/admin-header.php";

                ?>

                <div class="eb-admin-title">
                    <h1 class="wp-heading-inline"><?php echo __('License', 'eagle-booking') ?></h1>
                </div>

                <div class="eb-admin-dashboard-inner">

                    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                        <input type="hidden" name="action" value="deactivate_license"/>

                        <div class="eb-admin-notice eb-admin-notice-info">
                            <i class="dashicons dashicons-info-outline"></i>
                            <p><?php echo __('If you want to use your license on a different domain you have to deactivate your license first and activate it on your new domain.', 'eagle-booking') ?></p>
                        </div>

                        <table style="min-width: 1000px">
                            <tbody>
                                <tr>
                                    <td width="30%"><?php echo __('Version', 'eagle-booking') ?></td>
                                    <td width="30%">
                                        <span class="no"><?php echo EB_VERSION ?></span>
                                    </td>
                                    <td><a href="<?php echo esc_url('https://docs.eagle-booking.com/kb/changelog/') ?>" target="_blank"><?php echo __('Changelog', 'eagle-booking' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo __( 'License', 'eagle-booking' ) ?></td>
                                    <td>
                                        <?php if ( $this->responseObj->is_valid ) : ?>
                                            <span class="eb-license-activated"><?php echo __("Activated", 'eagle-booking');?></span>
                                        <?php else : ?>
                                            <span class="el-license-valid"><?php echo __("Not Activated", 'eagle-booking');?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="el-license-active-btn">
                                            <?php wp_nonce_field( 'el-license' ); ?>
                                            <?php submit_button( __( 'Deactivate License', 'eagle-booking' ), 'eb-deactivate-btn' ); ?>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo __('License Key', 'eagle-booking') ?></td>
                                    <td><?php echo esc_attr( substr( $this->responseObj->license_key, 0 ,9 )."XXXXXXXX-XXXXXXXX".substr( $this->responseObj->license_key, -9 ) ); ?></td>
                                    <td><a href="https://docs.eagle-booking.com/kb/how-to-activate-deactivate-license/" target="_blank"><?php echo  __("Where Is My License Key?", 'eagle-booking') ?> </a></td>
                                </tr>

                            </tbody>
                        </table>
                    </form>

                </div>

            </div>

        </div>

		<?php
	}

    /**
     * Not Activated Output
     *
     * @since 1.3.2
     */
	public function Not_Activated_Page() {

		?>

        <div class="eb-wrapper">

            <div class="eb-admin-dashboard">

            <?php

                include EB_PATH.''."core/admin/bookings/elements/admin-header.php";

            ?>

            <div class="eb-admin-title">
                <h1 class="wp-heading-inline"><?php echo __('License', 'eagle-booking') ?></h1>
            </div>

            <div class="eb-admin-dashboard-inner">

            <?php

                if ( $this->theme_license() == true ) {

            ?>
                <div class="eb-admin-notice eb-admin-notice-info">
                    <i class="dashicons dashicons-lock"></i>
                    <p><?php echo __('It looks that you are using Eagle Booking bundled within one of our themes. In this case, you do not have to activate the Eagle Booking license and you are free to use it as long as you are using our theme.', 'eagle-booking') ?></p>
                </div>

            <?php

            } else {

            ?>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                    <input type="hidden" name="action" value="eb_el_activate_license"/>

                    <div class="eb-license el-license-container">

                        <div class="eb-admin-notice eb-admin-notice-info">
                            <i class="dashicons dashicons-lock"></i>
                            <p><?php echo __('Activate your Eagle Booking license to access all its features.', 'eagle-booking') ?></p>
                        </div>

                        <?php
                            if( !empty($this->showMessage) && !empty($this->licenseMessage) ){
                                ?>
                                <div class="eth-notice eth-notice-error">
                                    <i class="dashicons dashicons-no"></i><p><?php echo $this->licenseMessage; ?></p>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="eb-license-form">

                            <div class="el-license-field">
                                <label for="el_license_key">License Key <a href="https://docs.eagle-booking.com/kb/how-to-activate-deactivate-license/" target="_blank">How to get License Key </a></label>
                                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
                            </div>

                            <?php $purchaseEmail   = get_option( "eb_license_email", get_bloginfo( 'admin_email' )); ?>
                            <input type="hidden" class="regular-text code btn" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">

                            <div class="el-license-active-btn">
                                <?php wp_nonce_field( 'el-license' ); ?>
                                <?php submit_button( __( 'Activate License', 'eagle-booking' ), 'eb-activate-btn' ); ?>
                            </div>

                        </div>

                    </div>

                </form>

            <?php } ?>

            </div>

        </div>

    </div>

		<?php
	}

    /**
	 * Get license status
	 *
	 * @since 1.5.1
	 */
    public function license_status() {

        if ( $this->theme_license() == true ) {

            return true;

        } else {

            return $this->status;

        }

    }

    /**
	 * Plugin Upgrader
	 *
	 * @since 1.5.1
	 */
    public function upgrader() {

        if ( $this->license_status() == true ) {

            $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'http://api.eagle-booking.com/updates/?action=get_metadata&slug=eagle-booking',
                EB_PATH . '/eagle-booking.php',
                'eagle-booking'
            );

        } else {

            return;

        }

    }

    /**
	 * License activation required admin notice
	 *
	 * @since 1.3.3
	 */
    public function license_activation_notice() {
        if ( $this->license_status() == true ) {
            return;
        } ?>

        <div class="eb-license notice notice-info notactivated <?php echo wp_generate_password(5, false, false) ?>">
            <p><?php echo __( 'Eagle Booking has not been activated! Make sure to activate your license to be able to use all core functionalities.', 'eagle-booking' ); ?></p>
            <p><a href="<?php echo esc_url( admin_url( 'admin.php?page=eb_license') ); ?>" class="wp-core-ui button"><?php echo __( 'Activate Eagle Booking License', 'eagle-booking' ); ?></a></p>
        </div>
    <?php

    }

}

new EB_LICENSE;
