<?php
/* --------------------------------------------------------------------------
 * @ EB Admin
 * @ Taxes & Fees [Admin]
 * @ Since  1.3.3
 * @ Author: Eagle Themes
 * @ Developer: Jomin Muskaj
---------------------------------------------------------------------------*/

// Exit if accessed directly
defined('ABSPATH') || exit;

class EB_ADMIN_TAXES_FEES {

    public function __construct() {

        // Actions
        add_action( 'admin_menu', array( $this, 'add_admin_sub_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'wp_ajax_admin_create_entry', array( $this, 'create') );
        add_action( 'wp_ajax_admin_update_entry', array( $this, 'update') );
        add_action( 'wp_ajax_admin_delete_entry', array( $this, 'delete') );
    }

   /**
   * Create the submenu
   */
    public function add_admin_sub_page(){
        add_submenu_page(
            'eb_bookings',
            __('Taxes & Fees', 'eagle-booking'),
            __('Taxes & Fees', 'eagle-booking'),
            'edit_pages',
            'eb_taxes_and_fees',
            array( $this, 'render' )
        );
    }

    /**
     * Enqueue the required scripts
     */
     public function enqueue_scripts() {

        wp_enqueue_script( 'eb-admin-taxes-fees', EB_URL .'assets/js/admin/taxesfees.js', array( 'jquery' ), EB_VERSION, true );

        wp_localize_script( 'eb-admin-taxes-fees', 'taxes_fees', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nonce')
        ));
    }

    /**
     * Create Entry [AJAX Request]
     */
    public function create() {

        if( isset( $_POST['entry_title'] ) ) {

            $entry_cat = sanitize_text_field( $_POST['entry_cat'] );
            $entry_nonce = sanitize_text_field( $_POST['entry_nonce'] );
            $entry_title = sanitize_text_field( $_POST['entry_title'] );
            $entry_type = sanitize_text_field( $_POST['entry_type'] );
            $entry_amount = sanitize_text_field( $_POST['entry_amount'] );
            $entry_global = sanitize_text_field( $_POST['entry_global'] );
            $entry_services = sanitize_text_field( $_POST['entry_services'] );
            // $entry_fees = sanitize_text_field( $_POST['entry_fees'] );

            // Check nonce
            if ( !wp_verify_nonce($entry_nonce, 'nonce') ) {

                $return_data['status'] = 'failed';
                $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

            // If everything is ok let's proceed to the deletion
            } else {

                // Current Entries
                $current_entries = get_option( $entry_cat );

                if (  empty( $current_entries ) ) {

                    // Set first id to 1
                    $entry_id = "1";

                } else {

                    // Get the last entry
                    $last_array = end( $current_entries );

                    // Get the id of the latest entry
                    $last_id = $last_array['id'];

                    // Get the last id + 1
                    $entry_id = ++$last_id;

                }

                // New Entry Fields (based on cat)
                if ( $entry_cat === 'eb_taxes' ){

                    $new_entries = array(
                        'id'     => $entry_id,
                        'title'  => $entry_title,
                        'amount' => $entry_amount,
                        'global' => $entry_global,
                        'services' => $entry_services,
                        // 'fees' => $entry_fees
                    );

                } else {

                    $new_entries = array(
                        'id'     => $entry_id,
                        'title'  => $entry_title,
                        'type'   => $entry_type,
                        'amount' => $entry_amount,
                        'global' => $entry_global
                    );

                }

                // First time (doesn't exist yet)
                if ( empty( $current_entries)  ){

                    update_option( $entry_cat, array( $new_entries ) );

                } else {

                    $merged_options = array_merge ( $current_entries , array ( $new_entries ) );

                    //Update Option
                    update_option( $entry_cat, $merged_options );

                }

                $return_data['status'] = 'success';
                $return_data['mssg'] = __('New Entry Added Successfully', 'eagle-booking');

            }

        } else {

            $return_data['status'] = 'failed';
            $return_data['mssg'] = __('No ID', 'eagle-booking');

          }

      // Return all data to json
      wp_send_json($return_data);
      wp_die();

    }

  /**
   * Update Entry [AJAX Request]
  */
  public function update() {

    // Check if Ajax response and get Ajax variables
    if (! empty($_POST['entry_id'])) {

        $entry_nonce = sanitize_text_field( $_POST['entry_nonce'] );
        $entry_cat = sanitize_text_field( $_POST['entry_cat'] );
        $entry_id = sanitize_text_field( $_POST['entry_id'] );
        $entry_title = sanitize_text_field( $_POST['entry_title'] );
        $entry_type = sanitize_text_field( $_POST['entry_type'] );
        $entry_amount = sanitize_text_field( $_POST['entry_amount'] );
        $entry_global = sanitize_text_field( $_POST['entry_global'] );
        $entry_services = sanitize_text_field( $_POST['entry_services'] );
        // $entry_fees = sanitize_text_field( $_POST['entry_fees'] );

        // Check nonce
        if ( !wp_verify_nonce($entry_nonce, 'nonce') ) {

          $return_data['status'] = 'failed';
          $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

        // // If everything is ok let's proceed to the deletion
        } else {

            // Existing Entries
            $data = get_option($entry_cat);

            // Loop the array to find the specific entry
            foreach( $data as $key => $row ) {

                if( $row['id'] == $entry_id ) {

                    // Update Entry Fields based on cat
                    if ( $entry_cat === 'eb_taxes' ){

                        // Set new values
                        $data[$key]['id'] = $entry_id;
                        $data[$key]['title'] = $entry_title;
                        $data[$key]['amount'] = $entry_amount;
                        $data[$key]['global'] = $entry_global;
                        $data[$key]['services'] = $entry_services;
                        // $data[$key]['fees'] = $entry_fees;

                        // break the loop
                        break;

                    } else {

                        // Set new values
                        $data[$key]['id'] = $entry_id;
                        $data[$key]['title'] = $entry_title;
                        $data[$key]['type'] = $entry_type;
                        $data[$key]['amount'] = $entry_amount;
                        $data[$key]['global'] = $entry_global;

                        // break the loop
                        break;

                    }
                }
            }

            update_option($entry_cat, $data);

            $return_data['status'] = 'success';
            $return_data['mssg'] = __('Entry Updated Successfully ', 'eagle-booking');

        }

      } else {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('No ID', 'eagle-booking');

      }

      // Return all data to json
      wp_send_json($return_data);
      wp_die();

  }

  /**
   * Delete Entry [AJAX Request]f
  */
  public function delete() {

    // Check if Ajax response and get Ajax variables
    if (! empty($_POST['id'])) {

        $entry_nonce = sanitize_text_field( $_POST['nonce'] );
        $entry_cat = sanitize_text_field( $_POST['cat'] );
        $entry_id = sanitize_text_field( $_POST['id'] );

        // Check nonce
        if ( !wp_verify_nonce($entry_nonce, 'nonce') ) {

          $return_data['status'] = 'failed';
          $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

        // If everything is ok let's proceed to the deletion
        } else {

            // Existing Entries (tax or fee)
            $data = get_option($entry_cat);

            // Loop the array to find the specific entry
            foreach( $data as $key => $row ) {

                if( $row['id'] == $entry_id ){

                    // Dlete the array
                    unset( $data[$key] );

                    // Stop the loop
                    break;

                }
            }

            update_option($entry_cat, $data);

            $return_data['status'] = 'success';
            $return_data['mssg'] = __('Entry Deleted Successfully ', 'eagle-booking');

        }

      } else {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('No ID', 'eagle-booking');

      }

      // Return all data to json
      wp_send_json($return_data);
      wp_die();

  }

  /**
  * On Load Retrive Entries
  */
  public function entries( $cat = '' ) {

    // Get Entries
    if( $cat === 'fees' ) {

        $entry_cat = 'eb_fees';

    } else {

        $entry_cat = 'eb_taxes';

    }

    $entries = get_option($entry_cat);

    // echo '<pre>'; print_r($entries); echo '</pre>';

    $html = '';

    if ( $entries ) {

        foreach( $entries as $key => $item ) {

            $entry_id = !empty( $item["id"] ) ? $item["id"] :  '';
            $entry_title = !empty( $item["title"] ) ? $item["title"] : '';
            $entry_type = !empty( $item["type"] ) ? $item["type"] : '';
            $entry_amount = !empty( $item["amount"] ) ? $item["amount"] : '';
            $entry_global = !empty( $item["global"] ) ? $item["global"] : '';
            $entry_services = !empty( $item["services"] ) ? $item["services"] : '';
            // $entry_fees = !empty( $item["fees"] ) ? $item["fees"] : '';

            if ( $entry_global == true ) {
                $entry_global = 'Yes';
            } else {
                $entry_global = 'No';
            }
            if ( $entry_services == true ) {
                $entry_services = 'Yes';
            } else {
                $entry_services = 'No';
            }
            // if ( $entry_fees == true ) {
            //     $entry_fees = 'Yes';
            // } else {
            //     $entry_fees = 'No';
            // }

            $html .= "<tr class='eb-entry-line' data-entry-id='$entry_id' data-cat='$entry_cat'>";
            $html .= "<td class='eb-entry-title'>$entry_title</td>";
            if ( $entry_cat === 'eb_fees' ) $html .= "<td class='eb-entry-type'>".str_replace('_', ' ', $entry_type)."</td>";
            $html .= "<td class='eb-entry-amount'>$entry_amount</td>";
            $html .= "<td class='eb-entry-global'>$entry_global</td>";
            if ( $entry_cat === 'eb_taxes' ) $html .= "<td class='eb-entry-services'>$entry_services</td>";
            // if ( $entry_cat === 'eb_taxes' ) $html .= "<td class='eb-entry-fees'>$entry_fees</td>";
            $html .= "<td class='eb-action-buttons'>";
            $html .= "<span class='eb-edit-action eb-edit-entry' data-entry-id='$entry_id' data-cat='$entry_cat'><i class='far fa-edit'></i></span>";
            $html .= "<span class='eb-delete-action eb-delete-entry' data-entry-id='$entry_id' data-cat='$entry_cat'><i class='far fa-trash-alt'></i></span>";
            $html .= "</td>";
            $html .= "</tr>";

        }

    } else {

        $html .= "<tr class='eb-$entry_cat-no-entry'><td colspan='5' style='text-align: center'>". __('No entries have been created yet', 'eagle-booking' )."</td></tr>";
    }

    return $html;

  }

   /**
   * Render Output
   */
    public function render() {

        ?>

        <div class="eb-admin eb-wrapper">
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
                    <h1 class="wp-heading-inline"><?php echo __('Taxes & Fees', 'eagle-booking') ?></h1>
                </div>

                <div class="eb-admin-dashboard-inner">

                    <form method="POST" action="">

                        <!-- Taxes -->
                        <div class="eb-admin-list-group eb-admin-taxes-fees" data-cat="eb_taxes">

                            <h3 style="display: inline-block; margin-right: 20px; margin-bottom: 40px"><?php echo __('Taxes', 'eagle-booking') ?></h3> <button class="eb-admin-btn eb-new-entry" data-cat="eb_taxes"><i class="fas fa-plus"></i></button>

                            <table class="widefat striped">

                                <thead>
                                    <tr>
                                        <th class="row-title" width="30%"><?php echo __('Title', 'eagle-booking') ?></th>
                                        <th class="row-title" width="15%"><span data-eb-tooltip="Enter a tax rate (percentage)"><?php echo __('Rate %', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="15%"><span data-eb-tooltip="Choose if you want to apply this taX globally on all rooms or if you want to assign it under each room's price tab"><?php echo __('Global', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="15%"><span data-eb-tooltip="Choose if you want to apply this tax on additional services price"><?php echo __('Additional Services', 'eagle-booking') ?></span></th>
                                        <!-- <th class="row-title" width="15%"><span data-eb-tooltip="Choose if you want to apply this tax on fees price"><?php echo __('Fees', 'eagle-booking') ?></span></th> -->
                                        <th class="row-title" width="10%"><?php echo __('Actions', 'eagle-booking') ?></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    /**
                                     * Print Existing Entries
                                    */
                                    echo $this->entries('taxes');

                                    ?>

                                    <tr class="eb-new-eb_taxes-line " style="display: none;">
                                        <td>
                                            <input id="eb_entry_title" class="" type="text" placeholder="<?php echo __('Title', 'eagle-booking') ?>">
                                            <input id="eb_entry_cat" value="eb_taxes" type="hidden">
                                        </td>
                                        <td>
                                            <input type="text" id="eb_entry_amount" laceholder="<?php echo __('Amount', 'eagle-booking') ?>">
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" id="eb_entry_global">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" id="eb_entry_services">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <!-- <td>
                                            <label class="switch">
                                                <input type="checkbox" id="eb_entry_fees">
                                                <span class="slider round"></span>
                                            </label>
                                        </td> -->
                                        <td class="eb-action-buttons">
                                            <span class='eb-edit-action eb-create-entry'><i class='fas fa-check'></i></span>
                                            <span class='eb-delete-action eb-cancel-entry' data-booking-id='2'><i class='fas fa-times'></i></span>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <!-- Fees -->
                        <div class="eb-admin-list-group eb-admin-taxes-fees" data-cat="eb_fees" style="margin-top: 40px;">

                            <h3 style="display: inline-block; margin-right: 20px; margin-bottom: 40px"><?php echo __('Fees', 'eagle-booking') ?></h3> <button class="eb-admin-btn eb-new-entry" data-cat="eb_fees"><i class="fas fa-plus"></i></button>

                            <table class="widefat striped">

                                <thead>
                                    <tr>
                                        <th class="row-title" width="30%"><?php echo __('Title', 'eagle-booking') ?></th>
                                        <th class="row-title" width="20%"><?php echo __('Type', 'eagle-booking') ?></th>
                                        <th class="row-title" width="20%"><span data-eb-tooltip="Enter a fee amount (fixed)"><?php echo __('Amount', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="20%"><span data-eb-tooltip="Choose if you want to apply this fee globally on all rooms or if you want to assign it under each room's price tab"><?php echo __('Global', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="10%"><?php echo __('Actions', 'eagle-booking') ?></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    /**
                                     * Print Existing Entries
                                    */
                                    echo $this->entries('fees');

                                    ?>

                                    <tr class="eb-new-eb_fees-line" style="display: none;">
                                        <td>
                                            <input id="eb_entry_title" value="" class="" type="text" placeholder="<?php echo __('Title', 'eagle-booking') ?>">
                                            <input id="eb_entry_cat" value="eb_fees" type="hidden">
                                        </td>
                                        <td>
                                            <select id="eb_entry_type">
                                                <option value="per_booking" selected="selected"><?php echo __('Per Booking ', 'eagle-booking') ?></option>
                                                <option value="per_booking_nights"><?php echo __('Per Booking Nights', 'eagle-booking') ?></option>
                                                <option value="per_guests"><?php echo __('Per Guests', 'eagle-booking') ?></option>
                                                <option value="per_booking_nights_guests"><?php echo __('Per Booking Nights x Guests', 'eagle-booking') ?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="eb_entry_amount" value="" placeholder="<?php echo __('Amount', 'eagle-booking') ?>">
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" id="eb_entry_global">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td class="eb-action-buttons">
                                            <span class='eb-edit-action eb-create-entry'><i class='fas fa-check'></i></span>
                                            <span class='eb-delete-action eb-cancel-entry' data-booking-id='2'><i class='fas fa-times'></i></span>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    <?php

    }

}

new EB_ADMIN_TAXES_FEES();
