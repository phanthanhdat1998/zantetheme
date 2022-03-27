(function ($) {
    "use strict";

    /* Document is Raedy */
    $(document).ready(function () {

        /*----------------------------------------------------*/
        /*  Open Delete Confirmation [Admin]
        /*----------------------------------------------------*/

        $(document).on('click', '.eb-delete-booking, #eb_delete_booking', function(event) {

            event.preventDefault(event);
            event.stopPropagation(event);

            var eb_popup = $('.eb-popup');

            eb_popup.addClass('open');
            var booking_line = $(this).closest( "tr" );

            var booking_id = booking_line.data('booking-id');

            $('#eb_booking_id_text').text(booking_id);
            $('#eb_delete_booking_confirmation').data('booking-id', booking_id);

            // Close PopUp
            $(".eb-close-popup").on('click', function() {
                $('.eb-popup').removeClass('open');
            });

            // Cose on click outside of the popup
            $(window).on('click', function() {
                eb_popup.removeClass('open');
            });

            // Avoid Close on inner click
            $(".eb-popup-inner").on('click', function(event) {
                event.stopPropagation();
            });

        })

        /*----------------------------------------------------*/
        /*  Delete Booking [Admin]
        /*----------------------------------------------------*/

        $('#eb_delete_booking_confirmation').on('click', function(event) {

            eb_button_loading('eb_delete_booking_confirmation');

            event.preventDefault(event);

            var eb_popup = $('.eb-popup');
            var booking_id = $(this).data('booking-id');
            var booking_line = $('*[data-booking-id='+booking_id+']');

            // Handler to the ajax request
            var eb_delete_booking = null;

            // If there is a previous ajax request, then abort it
            if( eb_delete_booking != null ) {
                eb_delete_booking.abort();
                eb_delete_booking = null;
            }

            // Set the data
            var data = {
                    action: 'admin_delete',
                    nonce: booking_variables.nonce,
                    booking_id: booking_id
            }

            eb_delete_booking = $.ajax({
                type: 'POST',
                url: booking_variables.ajaxurl,
                data: data

            })

            // Always
            .always( function (response) { })

            // Done
            .done( function (response) {

                // Check if booking deleted successfully
                if ( response.status === 'success' ) {

                    // Remove Line
                    booking_line.fadeOut(300);

                    // Booking details page redeirect to the booking page
                    if ( $('.eb-admin-booking-details').length ) {
                            setTimeout( function() {
                                document.location.href = response.redirect_url;
                        }, 3000);
                    }

                    var response_class = 'success';

                } else {

                    var response_class = 'error';

                }

                // Close popup
                eb_popup.removeClass('open');

                // Show notification box & and remove it after 3s
                var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                $(eb_notice).hide().appendTo("body").fadeIn(300);

                // Remove Button Loader
                setTimeout( function() {
                    eb_button_loading('eb_delete_booking_confirmation', 'hide');
                }, 1000);

                // Remove Notice
                setTimeout( function() {
                    $('.eb-notice').fadeOut(300);
                }, 3000);

            })

            // Fail
            .fail( function (response) { console.log('Request Failed');  })


        });

        /*----------------------------------------------------*/
        /*  Confirmation PopUp [Admin]
        /*----------------------------------------------------*/
        function eb_confirmation_popup(popup_heading, popup_text, popup_status) {

            var eb_popup = $('.eb-popup');

            // Open PopUp on call
            eb_popup.toggleClass('open');

            // Set heading if set
            $('#eb_popup_heading', this).text(popup_heading);

            // Set text if set
            $('#eb_popup_text', this).text(popup_text);

            // Close PopUp
            $(".eb-close-popup", this).on('click', function() {
                $('.eb-popup').removeClass('open');
            });

            // Avoid Close on inner click
            $(".eb-popup-inner", this).on('click', function(event) {
                event.stopPropagation();
            });

            // Cose on click outside of the popup
            $(window).on('click', function() {
                eb_popup.removeClass('open');
            });

            // New Booking
            if ( popup_status === 'available' ) {

                $('#eb_popup_heading').prepend('<div class="eb-popup-icon success"><i class="far fa-calendar-check"></i></div>')

            } else {

                $('#eb_popup_heading').prepend('<div class="eb-popup-icon failed"><i class="far fa-calendar-times"></i></div>')

            }

        }

        /*----------------------------------------------------*/
        /*  Button Loading Animation
        /*----------------------------------------------------*/
        function eb_button_loading(eb_button_id, eb_button_action) {

            var eb_button = $('#'+eb_button_id);
            var eb_loader_dom = '<span class="eb-btn-loader"><span class="eb-spinner spinner1"></span><span class="eb-spinner spinner2"></span><span class="eb-spinner spinner3"></span><span class="eb-spinner spinner4"></span><span class="eb-spinner spinner5"></span></span>';

            if ( eb_button_action === 'hide' ) {

                eb_button.find('.eb-btn-loader').remove();
                eb_button.find('.eb-btn-text').show();
                eb_button.css('pointer-events','');
                eb_button.blur();

            } else {

                eb_button.append(eb_loader_dom);
                eb_button.find('.eb-btn-text').hide();
                eb_button.css('pointer-events','none');

            }

            // Firefox fix: on "Go Back"
            $(window).unload(function () { $(window).unbind('unload'); });

        }

        /*----------------------------------------------------*/
        /*  Check Availablity [Admin]
        /*----------------------------------------------------*/

        $("#eb_check_availability").on('click', function(event) {

            event.preventDefault();

            var eb_form_has_error = false;

            var form_field = {
                room_id:   $('#eb_room_id'),
                dates:     $('#eagle_booking_datepicker'),
                price:     $('#eb_price'),
                firstname: $('#eb_firstname'),
                lastname:  $('#eb_lastname')
            }

            // Check if any required field is empty
            form_field.room_id.add(form_field.dates).add(form_field.firstname).add(form_field.lastname).add(form_field.price).each( function() {

                if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                }

            });

            if ( eb_form_has_error == false ) {

                eb_button_loading('eb_check_availability');

                // Handler to the ajax request
                var check_availability = null;

                // If there is a previous ajax request, then abort it
                if( check_availability != null ) {
                    check_availability.abort();
                    check_availability = null;
                }

                // Set the data
                var data = {
                    action:   'admin_availability',
                    nonce:     booking_variables.nonce,
                    room_id:   form_field.room_id.val(),
                    checkin:   $('#eagle_booking_checkin').val(),
                    checkout:  $('#eagle_booking_checkout').val(),
                }

                check_availability = $.ajax({
                    type: 'POST',
                    url: booking_variables.ajaxurl,
                    data: data

                })

                .always( function (response) {})

                .done( function (response) {

                    eb_button_loading('eb_check_availability', 'hide');

                    // Check if room is available
                    if ( response.status === 'available' ) {

                        // Hide Delete Button
                        $('#eb_create_booking_confirmation').show();

                    } else {

                        // Hide Delete Button
                        $('#eb_create_booking_confirmation').hide();
                    }

                    // Open Confirmation Box
                    eb_confirmation_popup(response.heading, response.text, response.status);

                })

                .fail( function (response) {})

            }

        });

        /*----------------------------------------------------*/
        /*  Create Booking [Admin]
        /*----------------------------------------------------*/

        $("#eb_create_booking_confirmation").on('click', function(event) {

            eb_button_loading('eb_create_booking_confirmation');

            event.preventDefault();

            var eb_form_has_error = false;

            var form_field = {
                room_id:   $('#eb_room_id'),
                dates:     $('#eagle_booking_datepicker'),
                adults:    $('#eagle_booking_adults'),
                children:  $('#eagle_booking_children'),
                guests:    $('#eagle_booking_guests'),
                price:     $('#eb_price'),
                deposit:   $('#eb_deposit'),
                firstname: $('#eb_firstname'),
                lastname:  $('#eb_lastname')
            }

            // Check if any required field is empty
            form_field.room_id.add(form_field.dates).add(form_field.firstname).add(form_field.lastname).add(form_field.price).each( function() {

                if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                }

            });

            if ( eb_form_has_error == false ) {

                // Handler to the ajax request
                var eb_cretate_booking = null;

                // If there is a previous ajax request, then abort it
                if( eb_cretate_booking != null ) {
                    eb_cretate_booking.abort();
                    eb_cretate_booking = null;
                }

                // Set the data
                var data = {
                    action:   'admin_create',
                    nonce:     booking_variables.nonce,
                    room_id:   form_field.room_id.val(),
                    checkin:   $('#eagle_booking_checkin').val(),
                    checkout:  $('#eagle_booking_checkout').val(),
                    adults:    form_field.adults.val(),
                    children:  form_field.children.val(),
                    guests:    form_field.guests.val(),
                    price:     form_field.price.val(),
                    deposit:   form_field.deposit.val(),
                    firstname: form_field.firstname.val(),
                    lastname:  form_field.lastname.val(),
                    email:     $('#eb_email').val(),
                    phone:     $('#eb_phone').val(),
                    address:   $('#eb_address').val(),
                    city:      $('#eb_city').val(),
                    country:   $('#eb_country').val(),
                    zip:       $('#eb_zip').val(),
                    arrival:   $('#eb_arrival').val(),
                    requests:  $('#eb_requests').val(),
                    services:  $('#eb_services').val(),
                    status:    $('#eb_status').val(),
                    payment:   $('#eb_payment_method').val(),

                }

                eb_cretate_booking = $.ajax({
                    type: 'POST',
                    url: booking_variables.ajaxurl,
                    data: data

                })

                .always( function (response) {

                    console.log(response);

                })

                .done( function (response) {

                    // Check if booking deleted successfully
                    if ( response.status === 'success' ) {

                    var response_class = 'success';

                    setTimeout( function() {
                         document.location.href = response.redirect_url;

                    }, 3000);


                    } else {

                        var response_class = 'error';

                    }

                    // Close PopUp Confirmation
                    $('.eb-popup').toggleClass('open');

                    eb_button_loading('eb_create_booking_confirmation', 'hide');

                    // Show notification box & and remove it after 3s
                    var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                    $(eb_notice).hide().appendTo("body").fadeIn(300);

                    setTimeout( function() {
                        $('.eb-notice').fadeOut(300);
                    }, 3000);


                })

            .fail( function (response) { })

            }

        });

        /*----------------------------------------------------*/
        /*  Remove 'empty' class on keydown
        /*----------------------------------------------------*/

        $('input').on("keydown", function(){

            $(this).removeClass("empty");
        })

        /*----------------------------------------------------*/
        /*  Additional Services
        /*----------------------------------------------------*/

        $( ".eb-additional-service" ).change(function() {

            if ( $( this ).is( ":checked" ) ) {

                var eb_service_value = $( this ).val();
                var eb_service_previous_value = $("#eb_services").val();
                $( "#eb_services" ).val( eb_service_value + eb_service_previous_value );

            } else {
                var eb_service_value = $( this ).val();
                var eb_service_previous_value = $("#eb_services").val();
                var eb_checkbox_services = eb_service_previous_value.replace(eb_service_value, "");
                $( "#eb_services" ).val( eb_checkbox_services );
            }
        });


    });

})(jQuery);
