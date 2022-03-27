<?php

/* --------------------------------------------------------------------------
 * Hotel Branches Class
 * Since  1.2.9.6
 * Author: Eagle Themes
 ---------------------------------------------------------------------------*/

defined('ABSPATH') || exit;

class EB_BRANCHES {

    private static $_instance = null;

    /**
	 * Constructor function.
	 *
	 * @since 1.2.9.6
	 */

    public function __construct() {

        // Actions
        add_action( 'init', [ $this, 'hotel_branches_taxonomy' ], 10, 2 );
        add_action('eagle_branch_add_form_fields', [ $this, 'add_term_image' ], 10, 2);
        add_action('created_eagle_branch', [ $this, 'save_custom_fields' ], 10, 2);
        add_action('eagle_branch_edit_form_fields', [ $this, 'edit_custom_fields' ], 1, 2);
        add_action('admin_enqueue_scripts', [ $this, 'load_media_files' ] );
        add_action('edited_eagle_branch', [ $this, 'update_image_upload' ], 10, 2);
        add_action('parent_file', [ $this, 'keep_taxonomy_menu_open' ] );
        add_action('save_post_eagle_rooms', [ $this, 'save_meta_box'] );

        /**
        * Allow HTML in term (category, tag) descriptions
        */
        foreach ( array( 'pre_term_description' ) as $filter ) {
            remove_filter( $filter, 'wp_filter_kses' );
        }
        foreach ( array( 'term_description' ) as $filter ) {
            remove_filter( $filter, 'wp_kses_data' );
        }

    }

    /**
	 * Create Hotel Branches Taxanomy
	 *
	 * @since 1.2.9.6
	 */

    function hotel_branches_taxonomy() {

        $labels = array(
            'name' => __( 'Branch', 'eagle-booking' ),
            'singular_name' => _x( 'Branch', 'eagle-booking' ),
            'search_items' =>  __( 'Search Branches', 'eagle-booking' ),
            'all_items' => __( 'All Branches', 'eagle-booking' ),
            'parent_item' => __( 'Parent Branch', 'eagle-booking' ),
            'parent_item_colon' => __( 'Parent Branch:', 'eagle-booking' ),
            'edit_item' => __( 'Edit Branch', 'eagle-booking' ),
            'update_item' => __( 'Update Branch', 'eagle-booking' ),
            'add_new_item' => __( 'Add New Branch', 'eagle-booking' ),
            'new_item_name' => __( 'New Branch Name', 'eagle-booking' ),
            'menu_name' => __( 'Branches', 'eagle-booking' ),
        );

        register_taxonomy( 'eagle_branch', array('eagle_rooms'), array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' =>true,
            'query_var' => true,
            'rewrite' => array('slug' => eb_get_option('branches_slug')),
            'meta_box_cb' => [$this, 'create_meta_box']

        ));

    }

    /**
	 * Add custom field on create taxanomy
	 *
	 * @since 1.2.9.6
	 */

    public function add_term_image($taxonomy){
        ?>
        <div class="form-field" style="max-width: 95%">
            <label for=""><?php echo __('Logo', 'eagle-booking') ?></label>
            <div class="eb-upload-file">
                <input type="hidden" name="eb_branch_logo" class="eb-upload-file-url" value="">
                <img class="eb-upload-file-preview" src="" style="display: none">
                <span class="eb-upload-file-remove remove" style="display: none"><i class="far fa-trash-alt"></i></span>
                <p class="eb-upload-file-text"><?php echo __('Upload the logo of the hotel branch', 'eagle-booking') ?></p>
            </div>
        </div>

        <div class="form-field" style="max-width: 95%">
            <label for=""><?php echo __('Background Image', 'eagle-booking') ?></label>
            <div class="eb-upload-file">
                <input type="hidden" name="eb_branch_bg" class="eb-upload-file-url" value="">
                <img class="eb-upload-file-preview" src="" style="display: none">
                <span class="eb-upload-file-remove remove" style="display: none"><i class="far fa-trash-alt"></i></span>
                <p class="eb-upload-file-text"><?php echo __('Upload the background image', 'eagle-booking') ?></p>
            </div>
        </div>

        <div class="form-field term-slug-wrap">
            <label for=""><?php echo __('Address', 'eagle-booking') ?></label>
            <input type="text" name="eb_branch_address" value="">
        </div>

        <div class="form-field term-slug-wrap">
            <label for=""><?php echo __('Phone', 'eagle-booking') ?></label>
            <input type="text" name="eb_branch_phone" value="">
        </div>

        <div class="form-field term-slug-wrap">
            <label for=""><?php echo __('Email', 'eagle-booking') ?></label>
            <input type="text" name="eb_branch_email" value="">
        </div>

        <?php
    }

    /**
	 * Save custom field on create taxanomy
	 *
	 * @since 1.2.9.6
	 */

    public function save_custom_fields( $term_id ) {

        if ( isset($_POST['eb_branch_logo']) ){
            update_term_meta($term_id, 'eb_branch_logo', $_POST['eb_branch_logo'] );
        }

        if ( isset($_POST['eb_branch_bg']) ){
            update_term_meta($term_id, 'eb_branch_bg', $_POST['eb_branch_bg'] );
        }

        if ( isset($_POST['eb_branch_address']) ){
            update_term_meta($term_id, 'eb_branch_address', $_POST['eb_branch_address'] );
        }

        if ( isset($_POST['eb_branch_phone']) ){
            update_term_meta($term_id, 'eb_branch_phone', $_POST['eb_branch_phone'] );
        }

        if ( isset($_POST['eb_branch_email']) ){
            update_term_meta($term_id, 'eb_branch_email', $_POST['eb_branch_email'] );
        }

    }

    /**
	 * Add custom field on edit taxanomy
	 *
	 * @since 1.2.9.6
	 */

    public function edit_custom_fields($term, $taxonomy) {

        $eb_branch_logo_url = get_term_meta($term->term_id, 'eb_branch_logo', true);
        $eb_branch_bg_url = get_term_meta($term->term_id, 'eb_branch_bg', true);
        $eb_branch_address = get_term_meta($term->term_id, 'eb_branch_address', true);
        $eb_branch_phone = get_term_meta($term->term_id, 'eb_branch_phone', true);
        $eb_branch_email = get_term_meta($term->term_id, 'eb_branch_email', true);

    ?>
        <tr class="form-field">
            <th scope="row">
                <label for=""><?php echo __('Logo', 'eagle-booking') ?></label>
            </th>
            <td>
                <div class="eb-upload-file">
                    <input type="hidden" name="eb_branch_logo" class="eb-upload-file-url" value="<?php echo esc_url( $eb_branch_logo_url ) ?>">
                    <img class="eb-upload-file-preview" src="<?php echo esc_url( $eb_branch_logo_url ) ?>" style="<?php echo $eb_branch_logo_url ? '' : 'display: none' ?>">
                    <span class="eb-upload-file-remove remove"><i class="far fa-trash-alt"></i></span>
                    <p class="eb-upload-file-text" style="<?php echo $eb_branch_logo_url ? 'display: none' : '' ?>"><?php echo __('Upload the logo of the hotel branch', 'eagle-booking') ?></p>
                </div>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for=""><?php echo __('Background', 'eagle-booking') ?></label>
            </th>
            <td>
                <div class="eb-upload-file">
                    <input type="hidden" name="eb_branch_bg" class="eb-upload-file-url" value="<?php echo esc_url( $eb_branch_bg_url ) ?>">
                    <img class="eb-upload-file-preview" src="<?php echo esc_url( $eb_branch_bg_url ) ?>" style="<?php echo $eb_branch_bg_url ? '' : 'display: none' ?>">
                    <span class="eb-upload-file-remove remove"><i class="far fa-trash-alt"></i></span>
                    <p class="eb-upload-file-text" style="<?php echo $eb_branch_bg_url ? 'display: none' : '' ?>"><?php echo __('Upload the background image', 'eagle-booking') ?></p>
                </div>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for=""><?php echo __('Address', 'eagle-booking') ?></label>
            </th>
            <td>
                <input type="text" name="eb_branch_address" value="<?php echo esc_html( $eb_branch_address ) ?>">
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for=""><?php echo __('Phone', 'eagle-booking') ?></label>
            </th>
            <td>
                <input type="text" name="eb_branch_phone" value="<?php echo esc_html( $eb_branch_phone ) ?>">
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for=""><?php echo __('Email', 'eagle-booking') ?></label>
            </th>
            <td>
                <input type="text" name="eb_branch_email" value="<?php echo esc_html( $eb_branch_email ) ?>">
            </td>
        </tr>

    <?php
    }

    /**
	 * Save custom field on edit taxanomy
	 *
	 * @since 1.2.9.6
	 */
    public function update_image_upload( $term_id ) {
        if ( isset($_POST['eb_branch_logo']) ){
            update_term_meta($term_id, 'eb_branch_logo', $_POST['eb_branch_logo'] );
        }

        if ( isset($_POST['eb_branch_bg']) ){
            update_term_meta($term_id, 'eb_branch_bg', $_POST['eb_branch_bg'] );
        }

        if ( isset($_POST['eb_branch_address']) ){
            update_term_meta($term_id, 'eb_branch_address', $_POST['eb_branch_address'] );
        }

        if ( isset($_POST['eb_branch_phone']) ){

            update_term_meta($term_id, 'eb_branch_phone', $_POST['eb_branch_phone'] );
        }

        if ( isset($_POST['eb_branch_email']) ){
            update_term_meta($term_id, 'eb_branch_email', $_POST['eb_branch_email'] );
        }

    }

    /**
	 * Enque Media Files
	 *
	 * @since 1.2.9.6
	 */

    public function load_media_files() {
        wp_enqueue_media();
    }

    /**
	 * Keep taxonomy menu open
	 *
	 * @since 1.2.9.6
	 */

    public function keep_taxonomy_menu_open($parent_file) {

      global $current_screen;

      $taxonomy = $current_screen->taxonomy;

      if ( $taxonomy == 'eagle_branch' ) $parent_file = 'eb_bookings';

      return $parent_file;

    }


    /**
     * Create Branches Select [Edit Room]
     *
     * @since 1.2.9.6
     */

    public function create_meta_box( $post ) {

        $terms = get_terms( 'eagle_branch', array( 'hide_empty' => false ) );
        $post  = get_post();
        $branches = wp_get_object_terms( $post->ID, 'eagle_branch', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        $name  = '';

        if ( ! is_wp_error( $branches ) ) {

            if ( isset( $branches[0] ) && isset( $branches[0]->name ) ) {
                $name = $branches[0]->name;

            }

        }

        echo '<select name="eagle_branch" class="eb-branches-select">';
        echo '<option value="">'.__('None', 'eagle-booking').'</option>';
        foreach ( $terms as $term ) {
    ?>
        <option value="<?php esc_attr_e( $term->name ); ?>" <?php selected( $term->name, $name ); ?>><?php esc_html_e( $term->name ); ?></option>

    <?php

        }

    echo '</select>';

    }

    /**
     * Save Branches [Edit Room]
     *
     * @since 1.2.9.6
     */

    public function save_meta_box( $post_id ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! isset( $_POST['eagle_branch'] ) ) {
            return;
        }

        $branches = sanitize_text_field( $_POST['eagle_branch'] );

        $term = get_term_by( 'name', $branches, 'eagle_branch' );
        if ( ! is_wp_error( $term ) ) {
            wp_set_object_terms( $post_id, $term->term_id, 'eagle_branch', false );
        }

    }

}

new EB_BRANCHES;