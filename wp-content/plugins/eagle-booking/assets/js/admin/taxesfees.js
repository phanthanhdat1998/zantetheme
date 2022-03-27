/*================================================
* Plugin Name: Eagle Booking / Admin Taxes
* Version: 1.2.9.4
* Author: Eagle Themes (Jomin Muskaj)
* Author URI: eagle-booking.com
=================================================*/

(function ($) {

    "use strict";

    /* Document is Raedy Lets Start */
    $(document).ready(function () {

        /*----------------------------------------------------*/
        /*  New Entry Form
        /*----------------------------------------------------*/
        $(".eb-new-entry").on("click", function (event) {

            event.preventDefault();
            var cat = $(this).data('cat');

            // Clear any previous value
            $(this).closest('form').find("input[type=text]").val("");

            $('.eb-new-'+cat+'-line').toggle();
            $('.eb-'+cat+'-no-entry').hide();
        })

        /*----------------------------------------------------*/
        /*  Create Entry
        /*----------------------------------------------------*/
        $('.eb-create-entry').on('click', function(event) {

            // Check before submit
            var eb_form_has_error = false;

            var fields = {
                cat:       $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_cat'),
                title:     $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_title'),
                type:      $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_type'),
                amount:    $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_amount'),
                global:    $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_global'),
                services:  $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_services'),
                // fees:      $(this).closest('.eb-admin-taxes-fees').find('#eb_entry_fees')
            }

            if ( $(fields.global).is(":checked") ) {
                fields.global = 1;
            } else {
                fields.global = 0;
            }
            if ( $(fields.services).is(":checked") ) {
                fields.services = 1;
            } else {
                fields.services = 0;
            }
            // if ( $(fields.fees).is(":checked") ) {
            //     fields.fees = 1;
            // } else {
            //     fields.fees = 0;
            // }

            // Check if any required field is empty
            fields.title.add(fields.type).add(fields.amount).each( function() {

                if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                }

            });

            if ( eb_form_has_error == false ) {

                // Handler to the ajax request
                var eb_create_entry  = null;

                // If there is a previous ajax request, then abort it
                if( eb_create_entry != null ) {
                    eb_create_entry.abort();
                    eb_create_entry = null;
                }

                // Set the data
                var data = {
                    action: 'admin_create_entry',
                    entry_nonce: taxes_fees.nonce,
                    entry_cat: fields.cat.val(),
                    entry_title: fields.title.val(),
                    entry_type: fields.type.val(),
                    entry_amount: fields.amount.val(),
                    entry_global: fields.global,
                    entry_services: fields.services,
                    // entry_fees: fields.fees
                }

                eb_create_entry = $.ajax({
                    type: 'POST',
                    url: taxes_fees.ajaxurl,
                    data: data

                })

                // Always
                .always( function (response) {} )

                // Done
                .done( function (response) {

                    // Lets check the returned status
                    if ( response.status === 'success' ) {

                        // Hide New Line Form
                        $('.eb-new-'+data.entry_cat+'-line').hide();

                        if ( fields.global == 1 ) {
                            var global_checkbox_text = 'Yes';
                        } else {
                            var global_checkbox_text = 'No';
                        }

                        if ( fields.services == 1 ) {
                            var services_checkbox_text = 'Yes';
                        } else {
                            var services_checkbox_text = 'No';
                        }

                        // if ( fields.fees == 1 ) {
                        //     var fees_checkbox_text = 'Yes';
                        // } else {
                        //     var fees_checkbox_text = 'No';
                        // }

                        // Appened the new tr after last tr
                        if ( data.entry_cat === 'eb_taxes' ) {

                            var new_line = $(

                                '<tr class="eb-entry-line"><td>' + fields.title.val() + '</td>\
                                <td>' + fields.amount.val() + '</td>\
                                <td>' + global_checkbox_text + '</td>\
                                <td>' + services_checkbox_text + '</td>\
                                <td class="eb-action-buttons"><span class="eb-edit-action eb-edit-entry"><i class="far fa-edit"></i></span><span class="eb-delete-action eb-delete-entry"><i class="far fa-trash-alt"></i></span> </td>\
                                </tr>');

                            } else {

                            var new_line = $(

                                '<tr class="eb-entry-line">\
                                <td>' + fields.title.val() + '</td>\
                                <td>' + fields.type.val().replace(/_/g, ' ') +  '</td>\
                                <td>' + fields.amount.val() + '</td>\
                                <td>' + global_checkbox_text + '</td>\
                                <td class="eb-action-buttons"><span class="eb-edit-action eb-edit-entry"><i class="far fa-edit"></i></span><span class="eb-delete-action eb-delete-entry"><i class="far fa-trash-alt"></i></span> </td>\
                                </tr>');
                        }

                        // Add the line after the specific table
                        $('.eb-admin-taxes-fees[data-cat="'+ data.entry_cat +'"]').find('tr').last().after(new_line);

                        var response_class = 'success';

                    } else {

                        var response_class = 'failed';

                    }

                    // Show notification box & and remove it after 3s
                    var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                    $(eb_notice).hide().appendTo("body").fadeIn(300);

                    // Remove Notice
                    setTimeout( function() {
                        $('.eb-notice').fadeOut(300);
                    }, 3000);

                })

                // Fail
                .fail( function (response) { console.log('Request Failed');  })

            }

        });

        /*----------------------------------------------------*/
        /*  Update Entry
        /*----------------------------------------------------*/
        $('body').on('click', '.eb-update-entry', function(event) {

            // Check before submit
            var eb_form_has_error = false;

            var fields = {
                cat:       $(this).data('cat'),
                id:        $(this).data('entry-id'),
                title:     $('#eb_update_entry_title'),
                type:      $('#eb_update_entry_type'),
                amount:    $('#eb_update_entry_amount'),
                global:    $('#eb_update_entry_global'),
                services:  $('#eb_update_entry_services'),
                // fees:      $('#eb_update_entry_fees'),
            }

            if ( $(fields.global).is(":checked") ) {
                fields.global = 1;
            } else {
                fields.global = 0;
            }
            if ( $(fields.services).is(":checked") ) {
                fields.services = 1;
            } else {
                fields.services = 0;
            }
            // if ( $(fields.fees).is(":checked") ) {
            //     fields.fees = 1;
            // } else {
            //     fields.fees = 0;
            // }

            // Check if any required field is empty
            fields.title.add(fields.type).add(fields.amount).each( function() {

                if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                }

            });

            if ( eb_form_has_error == false ) {

                // Handler to the ajax request
                var eb_update_entry  = null;

                // If there is a previous ajax request, then abort it
                if( eb_update_entry != null ) {
                    eb_update_entry.abort();
                    eb_update_entry = null;
                }

                // Set the returned data
                var data = {
                    action: 'admin_update_entry',
                    entry_nonce: taxes_fees.nonce,
                    entry_cat: fields.cat,
                    entry_id: fields.id,
                    entry_title: fields.title.val(),
                    entry_type: fields.type.val(),
                    entry_amount: fields.amount.val(),
                    entry_global: fields.global,
                    entry_services: fields.services,
                    // entry_fees: fields.fees
                }

                if ( fields.global == 1 ) {
                   var global_text = 'Yes';
                } else {
                   var global_text = 'No';
                }
                if ( fields.services == 1 ) {
                   var services_text = 'Yes';
                } else {
                   var services_text = 'No';
                }
                // if ( fields.fees == 1 ) {
                //    var fees_text = 'Yes';
                // } else {
                //    var fees_text = 'No';
                // }

                eb_update_entry = $.ajax({
                    type: 'POST',
                    url: taxes_fees.ajaxurl,
                    data: data

                })

                // Always
                .always( function (response) {} )

                // Done
                .done( function (response) {

                    // Lets check the returned status
                    if ( response.status === 'success' ) {

                        var response_class = 'success';

                        // Hide the edit line
                        $('.eb-entry-edit[data-entry-id="'+ fields.id +'"]').hide();

                        // Show again the line ( without new values )wp_posts
                        $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').show();

                        // Lets change the old values
                        $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').find('.eb-entry-title').text(fields.title.val());
                        $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').find('.eb-entry-amount').text(data.entry_amount);
                        $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').find('.eb-entry-global').text(global_text);
                        if ( data.entry_cat === 'eb_fees' ) {
                            $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').find('.eb-entry-type').text(fields.type.val().replace(/_/g, ' '));
                        } else {
                            $('.eb-entry-line[data-entry-id="'+ fields.id +'"]').find('.eb-entry-services').text(services_text);
                        }

                        // BUG: inputs still have the old values

                    } else {

                        var response_class = 'failed';

                    }

                    // Show notification box & and remove it after 3s
                    var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                    $(eb_notice).hide().appendTo("body").fadeIn(300);

                    // Remove Notice
                    setTimeout( function() {
                        $('.eb-notice').fadeOut(300);
                    }, 3000);

                })

                // Fail
                .fail( function (response) { console.log('Request Failed');  })

            }

        });

        /*----------------------------------------------------*/
        /*  Delete Entry
        /*----------------------------------------------------*/
        $('.eb-delete-entry').on('click', function(event) {

            var entry_id = $(this).data('entry-id');
            var entry_line = $(this).closest( "tr" );
            var entry_cat = $(this).data('cat');

            // Handler to the ajax request
            var eb_delete = null;

            // If there is a previous ajax request, then abort it
            if( eb_delete != null ) {
                eb_delete.abort();
                eb_delete = null;
            }

            // Set the data
            var data = {
                action: 'admin_delete_entry',
                nonce: taxes_fees.nonce,
                id: entry_id,
                cat: entry_cat
            }

            eb_delete = $.ajax({
                type: 'POST',
                url: taxes_fees.ajaxurl,
                data: data

            })

            // Always
            .always( function (response) {} )

            // Done
            .done( function (response) {

                // Lets check the returned status
                if ( response.status === 'success' ) {

                    var response_class = 'success';
                    // Remove Deleted Line
                    entry_line.fadeOut(300);

                } else {

                    var response_class = 'failed';

                }

                // Show notification box & and remove it after 3s
                var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                $(eb_notice).hide().appendTo("body").fadeIn(300);

                // Remove Notice
                setTimeout( function() {
                    $('.eb-notice').fadeOut(300);
                }, 3000);

            })

            // Fail
            .fail( function (response) { console.log('Request Failed');  })

        });

        /*----------------------------------------------------*/
        /*  Edit Entry
        /*----------------------------------------------------*/
        $('.eb-edit-entry').on('click', function(event) {

            var entry_line = $(this).closest( "tr" );

            var fields = {
                cat:       $(this).data('cat'),
                id:        $(this).data('entry-id'),
                title:     entry_line.find('.eb-entry-title').text(),
                type:      entry_line.find('.eb-entry-type').text(),
                amount:    entry_line.find('.eb-entry-amount').text(),
                global:    entry_line.find('.eb-entry-global').text(),
                services:  entry_line.find('.eb-entry-services').text(),
                // fees:      entry_line.find('.eb-entry-fees').text(),
            }

            if ( fields.global === 'Yes' ) {
                var global_checkbox = 'checked';
            } else {
                var global_checkbox = '';
            }

            if ( fields.services === 'Yes' ) {
                var services_checkbox = 'checked';
            } else {
                var services_checkbox = '';
            }

            // if ( fields.fees === 'Yes' ) {
            //     var fees_checkbox = 'checked';
            // } else {
            //     var fees_checkbox = '';
            // }

            // Appened the edit for instead of $this tr (taxes or fees)
            if ( fields.cat === 'eb_taxes' ) {

                var new_line =

                $('<tr class="eb-entry-edit" data-entry-id='+fields.id+'> \
                <td><input type="text" id="eb_update_entry_title" value="'+ fields.title +'"></td> \
                <td><input type="text" id="eb_update_entry_amount" value="'+ fields.amount +'"></td>\
                <td><label class="switch"><input type="checkbox" id="eb_update_entry_global" value="'+ fields.global +'" ' + global_checkbox + ' ><span class="slider round"></span></labe></td>\
                <td><label class="switch"><input type="checkbox" id="eb_update_entry_services" value="'+ fields.services +'" ' + services_checkbox + ' ><span class="slider round"></span></labe></td>\
                <td class="eb-action-buttons"><span class="eb-edit-action eb-update-entry" data-entry-id="'+ fields.id +'" data-cat="'+fields.cat+'"><i class="fas fa-check"></i></span><span class="eb-delete-action eb-cancel-entry" data-entry-id="'+ fields.id +'"><i class="fas fa-times"></i></span> </td>\
                </tr>');

            } else {

                var new_line =

                $('<tr class="eb-entry-edit" data-entry-id='+fields.id+'>\
                <td><input type="text" id="eb_update_entry_title" value="'+ fields.title +'"></td>\
                <td><select id="eb_update_entry_type"><option value="per_booking">Per Booking</option><option value="per_booking_nights">Per Booking Nights</option><option value="per_guests">Per Guests</option><option value="per_booking_nights_guests">Per Booking Nights x Guests</option></select></td></select></td><td><input type="text" id="eb_update_entry_amount" value="'+ fields.amount +'"></td><td><label class="switch"><input type="checkbox" id="eb_update_entry_global" value="'+ fields.global +'" ' + global_checkbox + ' ><span class="slider round"></span></labe></td>\
                <td class="eb-action-buttons"><span class="eb-edit-action eb-update-entry" data-entry-id="'+ fields.id +'" data-cat="'+fields.cat+'"><i class="fas fa-check"></i></span><span class="eb-delete-action eb-cancel-entry" data-entry-id="'+ fields.id +'"><i class="fas fa-times"></i></span> </td>\
                </tr>');
            }

            $(entry_line).hide();
            $(new_line).insertBefore(entry_line);

        });

        /*----------------------------------------------------*/
        /*  Cancel Edit
        /*----------------------------------------------------*/
        $('body').on('click', '.eb-cancel-entry', function(event) {

            var entry_id = $(this).data('entry-id');
            var original_line = ('.eb-entry-line[data-entry-id="'+ entry_id +'"]');
            $(original_line).show();
            $(this).closest( "tr" ).hide();

        });

    });

})(jQuery);
