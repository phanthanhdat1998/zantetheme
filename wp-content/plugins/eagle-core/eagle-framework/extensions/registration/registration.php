<?php

// Create Theme Registrtion Tab

if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'ReduxFramework_extension_registration' ) ) {

    class ReduxFramework_extension_registration extends ReduxFramework {

        public function __construct( $parent ) {

            $this->parent = $parent;
            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
            }
            $this->field_name = 'registration';

            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/class/'.$this->field_name, array( &$this, 'overload_field_path' ) );

            // Add Registrtion to theme options
            $this->add_registration();

        }

        public function getInstance() {
            return self::$theInstance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path($field) {
            return dirname(__FILE__).'/'.$this->field_name.'/field_'.$this->field_name.'.php';
        }

        public function getMenuList(){
            $menus = wp_get_nav_menus();
            $menu_list = array();

            foreach ($menus as $menu => $menu_obj) {
                $menu_list[$menu_obj->slug] = $menu_obj->name;
            }
            return $menu_list;
        }

        public function add_registration() {

            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'registration_section' ) {
                    return;
                }
            }

            $registration_option = array();
            $registration_option[] = array(
                'id'   => 'registration_id',
                'type' => 'registration'
            );

            // Not used yet
            // $this->parent->sections[] = array(
            //     'id'     => 'registration_section',
            //     'title'  =>  __( 'Theme Activation', 'eagle' ),
            //     'icon'   => 'el el-unlock',
            //     'fields' => $registration_option,
            // );

        }

    }

}