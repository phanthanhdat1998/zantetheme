<?php

// Create Theme Registrtion Content

if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_registration' ) ) {

    class ReduxFramework_registration extends ReduxFramework {

        function __construct( $field = array(), $value ='', $parent ) {

            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                if (trailingslashit( str_replace( '\\', '/', ABSPATH ) ) == '/') {
                    $this->extension_url = site_url( $this->extension_dir );
                }else{
                    $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                }
                $this->extension_url = plugin_dir_url(__FILE__);
            }

        }

        public function render() {

            if (! is_array($this->value) && isset($this->field['options'])) {
                $this->value = $this->field['options'];
            }

            $option_value = $this->value;
            if (!is_array($option_value)) {
                $option_value = array(
                    'puchase_code' => $option_value,
                );
            }

            $purchase_code = $this->value;
            $registration_status = get_option('registration_status'); ?>

        <?php if ($registration_status != 'active') : ?>
            <div class="eth-activation-notice">
                <?php echo __('To unlock all theme features, please activate the theme. Enter your purchase code and click "Activate". Don\'t know where the purchase code is? ', 'eagle') ?>
                <a href="https://docs.eagle-themes.com/kb/general/where-is-my-purchase-code/" target="_blank"><?php echo __('Click Here.', 'eagle') ?></a>
            </div>
        <?php endif ?>

        <input type="text" id="eth_purchase_code" class="eth-theme-purchase-code" name="zante_purchase_code" value="<?php echo $option_value['puchase_code'] ?>" class="regular-text">

        <div class="eth-theme-buttons">
           <button id="eth_theme_activation_button" class="button"> <?php echo __('Activate Now', 'eagle') ?></button>
           <!-- <button id="eth_thene_deregister" class="button eth-theme-deregister"><?php echo __('Deactivate', 'eagle') ?></abutton>
           <button id="eth_theme_refresh" class="button"><?php echo __('Refresh Activation', 'eagle') ?></button> -->
        </div>

        <!-- PopUp -->
        <div class='eth-theme-popup'>
            <div>  </div>
        </div>

        <?php

        }

        public function enqueue() {

            add_action( 'wp_ajax_eth_theme_activation', 'eb_user_sing_out' );


            wp_enqueue_script(
                'redux-field_registration-js',
                $this->extension_url . '/field_registration.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field_registration-css',
                $this->extension_url . '/field_registration.css',
                time(),
                true
            );

        }

        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }

        }

    }
}
