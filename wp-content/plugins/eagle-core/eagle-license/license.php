<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

require_once "licensor.php";

class Zante_License {

	public $plugin_file = __FILE__;
	public $responseObj;
	public $licenseMessage;
	public $showMessage = false;
	public $slug = "zante_dashboard";

    public $status;

	function __construct() {

		$licenseKey = get_option("zante_license_key","");
		$liceEmail = get_option( "zante_license_email","");
		$templateDir = get_stylesheet_directory();

		if( ZanteBase::CheckWPPlugin( $licenseKey, $liceEmail, $this->licenseMessage, $this->responseObj, $templateDir."/style.css" )){

            $this->status = true;

			add_action( 'admin_menu', [$this,'ActiveAdminMenu'], 99999);
			add_action( 'admin_post_deactivate_license', [ $this, 'action_deactivate_license' ] );

            if ( get_option('zante_support_notice') != true ) add_action('admin_notices', [ $this, 'support_expired_notice' ] );

            add_action( 'wp_ajax_support_notice', [ $this, 'support_notice' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'support_notice_script' ] );


		} else {

            $this->status = true;

			if(!empty($licenseKey) && !empty($this->licenseMessage)){
				$this->showMessage = true;
			}

			update_option("zante_license_key","") || add_option("zante_license_key","");
			add_action( 'admin_post_Zante_el_activate_license', [ $this, 'action_activate_license' ] );
			add_action( 'admin_menu', [$this,'InactiveMenu'], 11);
            add_action('admin_notices', [ $this, 'license_activation_notice' ] );

		}

        add_filter( 'admin_body_class', array( &$this, 'theme_dashboard_body_class' ) );

    }

	function ActiveAdminMenu(){

        add_submenu_page(
            'zante_options',
            __('Dashboard', 'eagle-booking'),
            __('Dashboard', 'eagle-booking'),
            'activate_plugins',
            $this->slug,
            [$this, "ActivePage"],
            0
        );

	}

	function InactiveMenu() {

        add_submenu_page(
            'zante_options',
            __('Dashboard', 'eagle-booking'),
            __('Dashboard', 'eagle-booking'),
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
        $this->Header();
        $this->Activated();
        $this->ServerRequirements();
        $this->Help();
    }

    /**
	 * License Inactive Page Element
	 *
	 * @since 1.2.9.5
     */
    function InactivePage() {
        $this->Header();
        $this->ServerRequirements();
        $this->Help();
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

		update_option("zante_license_key",$licenseKey) || add_option("zante_license_key", $licenseKey);
		update_option("zante_license_email",$licenseEmail) || add_option("zante_license_email", $licenseEmail);

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

		$message="";

		if( ZanteBase::RemoveLicenseKey(__FILE__,$message )) {

            update_option('zante_license_key', '');
            update_option('zante_license_email', '');
		}

    	wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }

    /**
	 * Add custom class to body tag
	 *
	 * @since 1.2.9.5
     */
    function theme_dashboard_body_class() {

       $classes = '';
       $currentScreen = get_current_screen();

         if( $currentScreen->id === "zante_page_zante_dashboard" ) {

            $classes = 'eth-theme-dashboard';
        }

        return $classes;
    }

    function Header() {

		?>

        <div class="eth-admin-header">
            <div class="eth-admin-header-inner">
                <div class="eth-admin-brand">
                    <a href="https://eagle-themes.com/?utm_source=eth_header_logo" target="_blank" class="eth-admin-logo">
                        <img src="<?php echo get_template_directory_uri().'/assets/images/admin/eth_logo.png'?>" alt="Eagle Booking">
                    </a>
                    <div class="eth-admin-slogan">
                        <span>Zante <small><?php echo ZANTE_THEME_VERSION ?></small></span>
                    </div>
                </div>
                <div class="eth-admin-menu">
                        <div class="view-switcher">
                        <a href="admin.php?page=zante_dashboard" class="btn active"><?php echo __('Dashboard', 'zante') ?></a>
                        <a href="admin.php?page=zante_options" class="btn"><?php echo __('Theme Settings', 'zante' )?></a>
                    </div>
                </div>
            </div>
        </div>

    <?php
	}

	function Activated() {

		?>

        <div class="eth-theme-panel">

            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="deactivate_license"/>
                <div class="eth-license el-license-container">
                    <div class="eth-theme-panel-header">
                        <h3 class="title"><?php echo __('Theme License', 'zante');?> </h3>
                    </div>
                    <div class="eth-theme-panel-inner">
                        <div class="eth-notice eth-notice-info">
                            <i class="dashicons dashicons-info-outline"></i>
                            <p><?php echo __('If you want to use your license on a different domain you have to deactivate your license first and activate it on your new domain.', 'zante') ?></p>
                        </div>
                        <table>
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo __('Theme Version', 'zante') ?></td>
                                    <td width="30%">
                                        <span class="no"><?php echo ZANTE_THEME_VERSION ?></span>
                                    </td>
                                    <td><a href="<?php echo esc_url('https://docs.eagle-themes.com/kb/zante/changelog/') ?>" target="_blank"><?php echo __('Changelog', 'zante' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Theme License', 'zante') ?></td>
                                    <td>
                                        <?php if ( $this->responseObj->is_valid ) : ?>
                                            <span class="eth-license-activated"><?php echo __("Activated", 'zante');?></span>
                                        <?php else : ?>
                                            <span class="el-license-valid"><?php echo __("Not Activated", 'zante');?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="el-license-active-btn">
                                            <?php wp_nonce_field( 'el-license' ); ?>
                                            <?php submit_button( __( 'Deactivate License', 'zante' ), 'eth-deactivate-btn' ); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Purchase Code', 'zante') ?></td>
                                    <td><?php echo esc_attr( substr( $this->responseObj->license_key, 0 ,9 )."XXXXXXXX-XXXXXXXX".substr( $this->responseObj->license_key, -9 ) ); ?></td>
                                    <td><a href="https://docs.eagle-themes.com/kb/general/where-is-my-purchase-code/" target="_blank"><?php echo  __("Where Is My Purchase Code?", 'zante') ?> </a></td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Support Expired on', 'zante') ?></td>
                                    <td>
                                        <span class="<?php echo $this->responseObj->is_valid ? "yes" : "no" ?>">
                                        <?php

                                            if ( isset( $this->responseObj->support_end )  && $this->responseObj->support_end != 'Unlimited')  {

                                                $expired_date = new DateTime($this->responseObj->support_end);
                                                $expired_date = $expired_date->format('d-m-Y');
                                                echo $expired_date;
                                            }

                                        ?>
                                        </span>
                                    </td>
                                    <td><a href="<?php echo esc_url('https://themeforest.net/checkout/from_item/22325268?license=regular&size=source&support=renew_6month') ?>" target="_blank"><?php echo __('Renew Support', 'zante') ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Child Theme', 'zante') ?></td>
                                    <td>
                                        <span class="yes">
                                            <?php echo is_child_theme() ? "Active" : "Not Active" ?>
                                        </span>
                                    </td>
                                    <td><a href="<?php echo esc_url('https://developer.wordpress.org/themes/advanced-topics/child-themes/') ?>" target="_blank"><?php echo __('What is a Child Theme?', 'zante') ?></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

		<?php
	}

	function LicenseForm() {

		?>

        <div class="eth-theme-panel">
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="Zante_el_activate_license"/>
                <div class="eth-license el-license-container">
                    <div class="eth-theme-panel-header">
                        <h3 class="title"><?php echo __('Theme License', 'zante');?> </h3>
                    </div>
                    <div class="eth-theme-panel-inner">
                        <div class="eth-notice eth-notice-info">
                            <i class="dashicons dashicons-lock"></i>
                            <p><?php echo __('Activate the theme using your Envato Purchase Code. One standard license is valid for one website. Running multiple projects on a single license is a copyright violation.', 'zante') ?></p>
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
                        <div class="eth-license-form">

                            <div class="el-license-field">
                                <label for="el_license_key"><?php echo __('Purchase Code', 'zante');?> <a href="https://docs.eagle-themes.com/kb/general/where-is-my-purchase-code/" target="_blank"><?php echo  __("How to get Purchase Code", 'zante') ?> </a></label>
                                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
                            </div>

                            <?php $purchaseEmail   = get_option( "zante_license_email", get_bloginfo( 'admin_email' )); ?>
                            <input type="hidden" class="regular-text code btn" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">

                            <div class="el-license-active-btn">
                                <?php wp_nonce_field( 'el-license' ); ?>
                                <?php submit_button( __( 'Activate License', 'zante' ), 'eth-activate-btn' ); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

		<?php
	}

    /**
     * Get Server Environment
     *
     * @since 1.3.5
     */

    public function ServerRequirementsValues() {

        if (!isset($value)) $value = new stdClass();

        // values
        $value->php_version = PHP_VERSION;
        $value->max_execution_time = ini_get('max_execution_time');
        $value->memory_limit = ini_get('memory_limit');
        $value->upload_max_filesize = ini_get('upload_max_filesize');

        // classes
        $value->php_version >= '7.4.0' ? $value->php_version_class = 'yes' : $value->php_version_class = 'no';
        $value->max_execution_time >= '600' ? $value->max_execution_time_class = 'yes' : $value->max_execution_time_class = 'no';
        str_replace('M', '', $value->memory_limit) >= '128' ? $value->memory_limit_class = 'yes' : $value->memory_limit_class = 'no';
        str_replace('M', '', $value->upload_max_filesize) >= '32' ? $value->upload_max_filesize_class = 'yes' : $value->upload_max_filesize_class = 'no';

        return $value;
    }

	function ServerRequirements() {

		?>

        <div class="eth-theme-panel">
            <div class="eth-license el-license-container">
                <div class="eth-theme-panel-header">
                    <h3 class="title"><?php echo __('Server Environment', 'zante');?> </h3>
                    <a href="https://docs.eagle-themes.com/kb/general/recommended-php-configuration-limits/" target="_blank" class="btn"><?php echo __('Requirements', 'zante') ?></a>
                </div>
                <div class="eth-theme-panel-inner">
                    <table class="requirements">
                        <thead>
                            <tr>
                                <th width="40%"><?php echo __('Directive','zante') ?></th>
                                <th width="20%"><?php echo __('Priority','zante') ?></th>
                                <th><?php echo __('Required Value','zante') ?></th>
                                <th><?php echo __('Current Value','zante') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo __('PHP version', 'zante') ?></td>
                                <td><?php echo __('High', 'zante') ?></td>
                                <td>7.4.0</td>
                                <td class="value <?php echo $this->ServerRequirementsValues()->php_version_class ?>"><?php echo $this->ServerRequirementsValues()->php_version ?></td>
                            </tr>
                            <tr>
                                <td><?php echo __('PHP time limit', 'zante') ?> <span>(max_execution_time)</span>:</td>
                                <td><?php echo __('Medium', 'zante') ?></td>
                                <td>600</td>
                                <td class="value <?php echo $this->ServerRequirementsValues()->max_execution_time_class ?>"><?php echo $this->ServerRequirementsValues()->max_execution_time ?></td>
                            </tr>
                            <tr>
                                <td><?php echo __('PHP memory limit', 'zante') ?> <span>(memory_limit)</span>:</td>
                                <td><?php echo __('High', 'zante') ?></td>
                                <td>128M</td>
                                <td class="value <?php echo $this->ServerRequirementsValues()->memory_limit_class ?>"><?php echo $this->ServerRequirementsValues()->memory_limit ?></td>
                            </tr>
                            <tr>
                                <td><?php echo __('Max upload size', 'zante') ?> <span>(upload_max_filesize)</span>:</td>
                                <td><?php echo __('High', 'zante') ?></td>
                                <td>32M</td>
                                <td class="value <?php echo $this->ServerRequirementsValues()->upload_max_filesize_class ?>"><?php echo $this->ServerRequirementsValues()->upload_max_filesize ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

		<?php
	}

	function Help() {

		?>

        <div class="eth-theme-panel">
            <div class="eth-license el-license-container">
                <div class="eth-theme-panel-header">
                        <h3 class="title"><?php echo __('Help', 'zante');?> </h3>
                        <a href="https://docs.eagle-themes.com/" target="_blank" class="btn"><?php echo __('Documentation', 'zante') ?></a>
                </div>
                <div class="eth-theme-panel-inner">
                    <div class="eth-theme-pannel-help">
                        <div>
                            <h4><?php echo __('Theme Documentation', 'zante') ?></h4>
                            <ul>
                                <li><a href="https://docs.eagle-themes.com/kb/zante/theme-installation/" target="_blank"><?php echo __('Theme Installation', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-themes.com/kb/zante/demo-content-import/" target="_blnak"><?php echo __('Demo Content Import', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-themes.com/kb/zante/theme-translation/" target="_blnak"><?php echo __('Theme Translation', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-themes.com/kb/general/activating-premium-plugins/" target="_blnak"><?php echo __('Activating Premium Plugins', 'zante') ?></a></li>
                            </ul>
                        </div>
                        <div>
                            <h4><?php echo __('Eagle Booking Documentation', 'zante') ?></h4>
                            <ul>
                                <li><a href="https://docs.eagle-booking.com/kb/add-new-room/" target="_blank"><?php echo __('Add New Room', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-booking.com/kb/new-booking" target="_blank"><?php echo __('Add New Booking', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-booking.com/kb/new-service/" target="_blank"><?php echo __('Add New Service', 'zante') ?></a></li>
                                <li><a href="https://docs.eagle-booking.com/kb/booking-settings/" target="_blank"><?php echo __('Booking System', 'zante') ?></a></li>
                            </ul>
                        </div>
                        <div>
                            <h4><?php echo __('Useful Links', 'zante') ?></h4>
                            <ul>
                                <li><a href="https://support.eagle-themes.com/" target="_blank" ><?php echo __('Get Support', 'zante') ?></a></li>
                                <li><a href="https://eagle-booking.com/" target="_blank" ><?php echo __('Get Eagle Booking', 'zante') ?></a></li>
                                <li><a href="https://www.cloudways.com/en/wordpress-cloud-hosting.php?id=792156&a_bid=19515e01" target="_blank" ><?php echo __('Recommended Hosting', 'zante') ?></a></li>
                                <li><a href="https://wpml.org/?aid=225435&affiliate_key=xqc1kSQTtLzj" target="_blank" ><?php echo __('Recommended Multilingual Plugin', 'zante') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

    /**
	 * License activation required admin notice
	 *
	 * @since 1.3.5
	 */
    public function license_activation_notice() {
        if ( $this->status == true ) {
            return;
        } ?>

        <div class="zante-license notice notice-info notactivated <?php echo wp_generate_password(5, false, false) ?>">
            <p><?php echo __( 'Zante has not been activated! Make sure to activate your license to be able to use all core functionalities.', 'cariera' ); ?></p>
            <p><a href="<?php echo esc_url( admin_url( 'admin.php?page=zante_dashboard') ); ?>" class="wp-core-ui button"><?php echo __( 'Activate Zante License', 'zante' ); ?></a></p>
        </div>
    <?php

    }

    /**
     * Support has expired admin notice
     *
     * @since 1.3.5
     */

    public function support_expired_notice() {

        $today = date("Y-m-d H:i:s");

        // Return if license is active and support is still valid
        if ( $this->status == true && $this->responseObj->support_end > $today ) {
            return;
        } ?>

        <div data-dismissible="theme-support-expired" class="eth-support-notice notice notice-error is-dismissible">
            <p><?php echo __( 'Your support for Zante has expired. Please renew support if you wish to get help from our team.', 'zante' ); ?></p>
            <p><a href="<?php echo esc_url('https://themeforest.net/checkout/from_item/22325268?license=regular&size=source&support=renew_6month') ?>" target="_blank" class="wp-core-ui button"><?php echo __( 'Renew Support', 'zante' ); ?></a></p>
        </div>
        <?php
    }

    /**
     * Update Support Notice Option
     *
     * @since 1.3.6
     */

    public function support_notice() {
        update_option( 'zante_support_notice', true );
    }

    /*
     * Enque Support Notice Script
     *
     * @since 1.3.6
     */

    public function support_notice_script() {

        wp_enqueue_script( 'notice-update', get_template_directory_uri(). '/assets/js/admin/global.js','', ZANTE_THEME_VERSION );

        wp_localize_script( 'notice-update', 'notice_params', array(
        'ajaxurl'       => admin_url( 'admin-ajax.php' ),

        ));

        wp_enqueue_script( 'notice-update' );
    }

    /**
	 * Get license status of the theme
	 *
	 * @since 1.5.1
	 */

    public function status() {

        if ( $this->status == true ) {

            return $this->status;

        }

    }

}

$license = new Zante_License;


$status = $license->status;

function zante_license_status() {

    global $status;

    if ( $status == true ) {

        return true;

    } else {

        return false;

    }

    return;

}

add_action('plugins_loaded  ','zante_license_status', 1);
