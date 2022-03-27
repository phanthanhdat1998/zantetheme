<?php

/**
 * Sidebar generator custom field created for Redux Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Don't duplicate me!
if ( ! class_exists( 'ReduxFramework_sidgen' ) ) {

    /**
     * Main ReduxFramework_sidgen class
     *
     */
    class ReduxFramework_sidgen {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @return      void
         */
        function __construct( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field  = $field;
            $this->value  = $value;
        }

        public function render() {

            $this->add_text   = ( isset( $this->field['add_text'] ) ) ? $this->field['add_text'] : esc_html__( 'Add New Field', 'eagle-booking' );

            echo '<ul id="' . $this->field['id'] . '-ul" class="redux-multi-text">';

            if ( isset( $this->value ) && is_array( $this->value ) ) {
                foreach ( $this->value as $k => $value ) {
                    if ( $k != 'lastkey') {
                        echo '
                        <li style="position: relative; max-width: 1000px; margin-bottom: 10px !important; padding: 20px; border: 1px solid #ebebeb;">
                            <div style="padding: 10px 0">
                                <label style="margin-right: 10px !important; min-width: 100px;">ID</label>
                                <input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '['.$k.']' . '" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" />
                            </div>
                            <div style="padding: 10px 0">
                                <label style="margin-right: 10px !important; min-width: 100px;">Label</label>
                                <input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '['.$k.']' . '" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" />
                            </div>
                            <div style="padding: 10px 0">
                                <label style="margin-right: 10px !important; min-width: 100px;">Required</label>
                                <input type="checkbox" id="' . $this->field['id'] . '" name="" value="Required" class="regular-text" />
                            </div>
                            <div style="padding: 10px 0">
                                <label style="margin-right: 10px !important; min-width: 100px;">Type</label>
                                <select>
                                    <option> Text </option>
                                    <option> Checkbox </option>
                                </select>
                            </div>
                            <div style="position: absolute; right: 20px; top: 20px;">
                                <a href="javascript:void(0);" class="deletion redux-multi-text-remove"><i class="el el-trash-alt"></i></a>
                            </div>
                        </li>';

                    } else {
                        $lastkey = $value;
                    }
                }

            } else {
                $lastkey = 0;
            }

            // echo '<input type="text" value="'. esc_html__( 'Surname', 'eagle-booking' ) .'" class="regular-text" disabled>';
            // echo '<input type="text" value="'. esc_html__( 'Email Adress', 'eagle-booking' ) .'" class="regular-text" disabled>';
            // echo '<input type="text" value="'. esc_html__( 'Address', 'eagle-booking' ) .'" class="regular-text" disabled>';
            // echo '<input type="text" value="'. esc_html__( 'Name', 'eagle-booking' ) .'" class="regular-text" disabled>';

            echo '<li>
            <input type="text" id="' . $this->field['id'] . '" name="" value="" class="regular-text" style="margin-bottom: 20px" />

            Is Required? <input type="checkbox" id="">

            <a href="javascript:void(0);" class="deletion redux-multi-text-remove"> <i class="el el-remove-sign"></i></a></li>';

            echo '</ul>';
            echo '<span style="clear:both;display:block;height:0;" /></span>';
            echo '<a href="javascript:void(0);" class="button button-secondary redux-multi-text-add" data-id="' . $this->field['id'] . '-ul" data-name="' . $this->field['name'] . $this->field['name_suffix'] . '">' . $this->add_text . '</a>';
            echo '<input type="hidden" class="lastkey" name="' . $this->field['name'] . $this->field['name_suffix'] . '[lastkey]'.'" value="' . esc_attr( $lastkey ) . '">';

        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0
         * @return      void
         */
        public function enqueue() {

            wp_enqueue_script(
                'redux-field-sidgen-js',
                EB_URL . '/include/redux-custom/dynamic-field.js',
                array( 'jquery', 'redux-js' ),
                time(),
                true
            );
        }
    }
}