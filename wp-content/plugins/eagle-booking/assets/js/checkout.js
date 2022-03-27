/*================================================
* Plugin Name: Eagle Booking
* Version: 1.3.3.2
* Author: Eagle Themes (Jomin Muskaj)
* Author URI: eagle-booking.com
=================================================*/
(function ($) {

    "use strict";

    /* Document is Raedy */
    $(document).ready(function () {


        /**
        * Format numbers based on options
        */
        function number_format (number, decimals, dec_point, thousands_sep) {

            decimals = eb_js_settings.eb_decimal_numbers;
            dec_point = eb_js_settings.eb_decimal_seperator;
            thousands_sep = eb_js_settings.eb_thousands_seperator;

            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

            var n = !isFinite(+number) ? 0 : + number,

                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }

            return s.join(dec);
        }


      /**
        * Additional Services
        * Version: 1.0
        */
       function eb_services() {

            $('.additional-service-item').on('click', function(event) {

                if(!$(event.target).is('.toggle-service-full-details')) {

                    $(this).toggleClass('selected');

                    var checkbox = $(this).children('input[type="checkbox"]');
                    checkbox.prop('checked', !checkbox.prop('checked'));

                    // Service amount
                    var service_amount = checkbox.val();
                    var service_amount_without_tax = checkbox.data('amount');

                    // Update Additional Prices Total Amount
                    var services_total_amount = $('#eb_services_amount').val();

                    var service_id = checkbox.attr("data-id");
                    var service_title = $(this).find('.eb-booking-service-title').text();

                    // Service price without taxes and including currency
                    if ( eb_js_settings.eb_currency_position === 'after' ) {

                        var service_price = number_format(service_amount_without_tax) + eb_js_settings.eb_currency;

                    } else {

                        var service_price =  eb_js_settings.eb_currency + number_format(service_amount_without_tax);

                    }

                    var new_service_info = $('<div class="item service" data-amount="'+service_amount+'" data-service-id="'+ service_id +'"><span class="desc">' + service_title + '</span><span class="value"><strong>'+ service_price +'</a></strong></span></div>');
                    var previous_services = $('#eb_additional_services_id');
                    var previous_services_ids = $(previous_services).val();
                    var total_services_amount = '';
                    var total_services_ids = '';
                    var price_summary = $('.eb-price-summary .room');

                    // Add Additional Service to Price Summary
                    if (checkbox.is(":checked")) {

                        $(new_service_info).insertAfter(price_summary).fadeIn();

                    } else {

                        $('.item[data-service-id="'+ service_id +'"]').remove();
                    }

                    // Get applied taxes & split
                    var applied_taxes = $(this).find('input').attr('data-aplied-taxes')+"";

                    if ( applied_taxes.indexOf(',') != -1 ) {

                        var applied_taxes = applied_taxes.split(',');

                    } else {

                        var applied_taxes = applied_taxes;

                    }

                    // Check if services have taxes
                    if( applied_taxes.length ) {

                        // Loop all applied taxes (fix: declare it as astring)
                        for ( var i = 0; i < applied_taxes.length; i++ ) {

                            // Trim the excess whitespace.
                            var applied_taxe = applied_taxes[i].replace(/^\s*/, "").replace(/\s*$/, "");

                            var tax = $('.item[data-tax-id="'+ applied_taxe +'"]');
                            // Get previous tax amount
                            var previous_tax_amount = tax.attr('data-amount');
                            var tax_percentage = tax.data('percentage');
                            var service_price = $(this).find('input').data('amount');
                            var service_tax = tax_percentage * service_amount_without_tax / 100;
                            var service_tax_amount = Math.round( Number(service_tax) );

                            // On check checkbox
                            if (checkbox.is(":checked")) {

                                // Keep The IDs if the selected additional services
                                total_services_ids = service_id+',' + previous_services_ids;
                                var services_taxes = +service_tax_amount;

                                // Add the amount of the clicked service to the total (previous) services amount
                                total_services_amount = +services_total_amount + service_amount_without_tax;

                                // Add service tax amount
                                var total_tax_amount =  Number( previous_tax_amount) + Number( service_tax_amount ) ;


                            } else {

                                // Remove the amount of the clicked service from the total services amount
                                total_services_amount = +services_total_amount - +service_amount_without_tax;
                                total_services_ids = previous_services_ids.replace(service_id+',', "");

                                // Remove service tax amount to get the previous price
                                var total_tax_amount = Number(previous_tax_amount) - Number(service_tax_amount);
                            }

                            // Update the val of the services total amount
                            $('#eb_services_amount').val(total_services_amount);

                            // Updare the services taxes total
                            $('#eb_services_taxes').val(services_taxes);

                            // Update the tax amount
                            tax.find('.value .price-amount').text( number_format( total_tax_amount ) );

                            tax.attr('data-amount', Number( total_tax_amount ));

                        }

                    } else {

                        // Add Additional Service to Price Summary
                        if (checkbox.is(":checked")) {

                            $(new_service_info).insertAfter(price_summary).fadeIn();

                            total_services_ids = service_id+',' + previous_services_ids;


                        } else {

                            $('.item[data-service-id="'+ service_id +'"]').remove();

                            total_services_ids = previous_services_ids.replace(service_id+',', "");
                        }

                        // Update the val of the services total amount
                        $('#eb_services_amount').val(total_services_amount);

                    }

                    // Update the IDs of the selected taxes
                    $(previous_services).val(total_services_ids);

                    // Update the total booking price
                    eb_final_price();

                }

            });

            // Show service full details
            $('.toggle-service-full-details').on('click', function() {
                $(this).parent().toggleClass('open');
                $(this).find('i').toggleClass('fa-question-circle fa-times-circle');
            });

        }

        eb_services();

        /**
        * Final Price (Including Additional Services, Taxes & Fees)
        * Version: 1.0
        */
        function eb_final_price() {

            var room_amount = parseFloat( $('#eb_room_price').val() );
            var services_amount = 0;
            var taxes_fees_amount = 0;

            // Get the room price

            // Sum all selected services amount
            $('.service[data-amount]').each(function() {

                services_amount += parseFloat ( $(this).attr("data-amount") );

            });

            // Sum all taxes & fees
            $('.taxfee[data-amount]').each(function() {

                taxes_fees_amount += parseFloat( $(this).attr("data-amount"));

            });

            // Total price = room price + services price + taxes & fees price
            var total_price = Number ( room_amount + services_amount + taxes_fees_amount );

            // Displayed price after format
            var displayed_total_price = number_format( total_price );

            // Update Text
            $('#eb_total_price_text').find('.price-amount').text( displayed_total_price );

            // Update Input
            $('#eb_booking_price').val( total_price );
        }

        /**
        * Arrival Time Sloter
        * Version: 1.0
        */
        function eb_arrival_slots() {
            $('.eb-panel-dropdown-toggle').on('click', function (event) {
                $('.eb-panel-dropdown .eb-panel-dropdown-inner').toggleClass('active');
            });

            $(window).click(function () {
                $('.eb-panel-dropdown .eb-panel-dropdown-inner').removeClass('active');
            });

            $('.eb-panel-dropdown-toggle').on('click', function (event) {
                event.stopPropagation();
            });
        }

        eb_arrival_slots();

        /**
        * Validate Email Address
        * Version: 1.0
        */
        function eb_validate_email(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        /**
        * Validate Phone Number
        * Version: 1.0
        */
        function eb_validate_phone_number(phone_number) {
            var regex = /^([0-9\(\)\/\+ \-]*)$/;
            return regex.test(phone_number);
        }

        /**
        * Checkout Tabs
        * Version: 1.0
        */
        function eb_checkout_tabs() {

            // Hide all tabs content
            $('.eb-tabs-content .eb-tab-content').hide();

            // Add active class to first tab
            $('.eb-tab:first').addClass('active');

            // Add checked to the active input
            $('.eb-tab.active .tab-radio').prop('checked', true);

            // Show first tab content \\ Bug it should display the content of active tab
            $('.eb-tabs-content .eb-tab-content:first').show();

            // On click change active tab
            $(".eb-tab").click(function () {

                $(this).addClass("active").siblings().removeClass("active");

                $(".eb-tabs-content > div").hide();

                $('.' + $(this).data("tab")).show();

            });

            // Show only the active tab on mobile
            if ($(window).width() < 768) {

                $(".eb-tab").click(function () {

                    $('.eb-tab').show().css('display: block');

                });

            }
        }

        eb_checkout_tabs();

        /**
        * User Sign In
        * Version: 1.0
        */
        function eb_user_sign_in() {

            // handler to the ajax request
            var eb_user_sign_in_xhr = null;

            $('#eb_user_sign_in').on('click', function(event) {

                var eb_user_sign_in_username = $('#eb_user_sign_in_username');
                var eb_user_sign_in_password = $('#eb_user_sign_in_password')
                var eb_user_sign_in_username_val = eb_user_sign_in_username.val();
                var eb_user_sign_in_password_val = eb_user_sign_in_password.val();
                var eb_user_sign_response = $('#eb_user_sign_in_response');
                var eb_user_sign_response_text = $('#eb_user_sign_in_response_text');
                var eb_user_sign_in_nonce_val = $('#eb_security').val();
                var eb_user_sign_in_has_error =  false;

                // Check if all required fields are empty
                eb_user_sign_in_username.add(eb_user_sign_in_password).each( function() {

                if( !this.value ) {
                    eb_user_sign_in_has_error = true;
                    $(this).addClass("empty");
                }

                });

                if (eb_user_sign_in_has_error == false) {

                  eb_button_loading('eb_user_sign_in');

                // if there is a previous ajax request, then abort it
                if( eb_user_sign_in_xhr != null ) {
                    eb_user_sign_in_xhr.abort();
                    eb_user_sign_in_xhr = null;
                }

                // Start the AJAX request
                eb_user_sign_in_xhr = $.ajax({
                    url: eb_checkout.eb_user_sign_in_ajax,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                    action: 'eb_user_sign_in_action',
                    eb_user_sign_in_username: eb_user_sign_in_username_val,
                    eb_user_sign_in_password: eb_user_sign_in_password_val,
                    eb_user_sign_in_nonce: eb_user_sign_in_nonce_val,
                    },

                    // Success
                    success: function (eb_user_sign_in_data) {

                    if (eb_user_sign_in_data.status === 'failed') {

                        eb_user_sign_response.show();
                        eb_user_sign_response_text.text(eb_user_sign_in_data.message);
                        eb_user_sign_response.addClass('eb-alert-error eb-alert-icon');

                        eb_button_loading('eb_user_sign_in', 'hide');

                    } else {

                        // Re-create nonce after user sign in to be used on sign out
                        $('#eb_security').val(eb_user_sign_in_data.new_nonce);

                        // If is the user dashboard login form then redirect it to the user dashboard
                        if( $('#eb_user_dashboard_signin_form').length  ) {

                            eb_user_sign_response.show();
                            eb_user_sign_response.removeClass('eb-alert-error eb-alert-icon');
                            eb_user_sign_response.addClass('eb-alert-success eb-alert-icon');
                            eb_user_sign_response_text.text(eb_user_sign_in_data.redirect_mssg);

                            // window.location.reload(true);
                            document.location.href = eb_user_sign_in_data.redirect_url;

                        // Booking Page Login Form
                        } else {

                            // Hide Billing Tabs on success login
                            $('#eb_billing_tabs').hide();

                            // Hide Signin response in case of logout
                            eb_user_sign_response.hide();

                            // Show Signed In User Alert
                            $('#eb_signed_in_user').show();

                            // Add text to signed in user alert
                            $('#eb_signed_in_user_text').text(eb_user_sign_in_data.message);
                            // Add user info into the signed in user form
                            $('#eb_signed_in_user_first_name').val(eb_user_sign_in_data.firstname);
                            $('#eb_signed_in_user_last_name').val(eb_user_sign_in_data.lastname);
                            $('#eb_signed_in_user_email').val(eb_user_sign_in_data.email);
                            $('#eb_signed_in_user_phone').val(eb_user_sign_in_data.phone);
                            $('#eb_signed_in_user_country').val(eb_user_sign_in_data.country);
                            $('#eb_signed_in_user_city').val(eb_user_sign_in_data.city);
                            $('#eb_signed_in_user_address').val(eb_user_sign_in_data.address);
                            $('#eb_signed_in_user_zip').val(eb_user_sign_in_data.zip);

                        }

                        // Debug
                        console.log(eb_user_sign_in_data.message);
                    }

                    // Debug
                    console.log(eb_user_sign_in_data.message);

                    },

                    error: function () {},

                    complete: function () {},

                });

            }

            event.preventDefault();

            });

        }

        eb_user_sign_in();

        /**
        * User Logout
        * Version: 1.0
        */
        function eb_user_sign_out() {

            // handler to the ajax request
            var eb_user_sign_out_xhr = null;

            $('body').on('click', '#eb_user_sign_out', function(event) {

                // Nonce
                var eb_logged_in_user_nonce = $('#eb_security').val();

                // Start the AJAX request
                eb_user_sign_out_xhr = $.ajax({
                    url: eb_checkout.eb_user_sign_out_ajax,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'eb_user_sign_out_action',
                        eb_sign_out_nonce: eb_logged_in_user_nonce,
                    },

                    // Success
                    success: function (eb_user_sign_out_data) {

                        if(eb_user_sign_out_data.status === 'success') {

                        // Re-create nonce after sign out to be used on sign in
                        $('#eb_security').val(eb_user_sign_out_data.new_nonce);

                        // Show Billing Tabs on success log out
                        $('#eb_billing_tabs').show();

                        // Hide Signed In Alert
                        $('#eb_signed_in_user').hide();

                          eb_button_loading('eb_user_sign_in', 'hide');

                        console.log(eb_user_sign_out_data.message);

                        } else {

                        console.log(eb_user_sign_out_data.message);

                        }

                        eb_fixed_sidebar('update');

                    },

                    error: function (eb_user_sign_out_xhr, textStatus, errorThrown) {},

                    complete: function () {},

            });

            event.preventDefault();

            });

        }

        eb_user_sign_out();

        /**
        * User Sign Up
        * Version: 1.0
        */
        function eb_user_sign_up() {

            // handler to the ajax request
            var eb_user_sign_up_xhr = null;

            $('#eb_user_dashboard_signup_form, #eb_user_signup_booking_form').on('submit', function(event) {

                var eb_user_sign_up_username = $('#eb_user_sign_up_username');
                var eb_user_sign_up_password = $('#eb_user_sign_up_password');
                var eb_user_sign_up_email = $('#eb_user_sign_up_email');
                var eb_user_sign_up_terms = $('#eb_user_sign_up_terms');
                var eb_user_sign_up_username_val = eb_user_sign_up_username.val();
                var eb_user_sign_up_password_val = eb_user_sign_up_password.val();
                var eb_user_sign_up_email_val = eb_user_sign_up_email.val();
                var eb_user_sign_up_first_name_val = $('#eb_user_sign_up_first_name').val();
                var eb_user_sign_up_last_name_val = $('#eb_user_sign_up_last_name').val();
                var eb_user_sign_up_response = $('#eb_user_sign_up_response');
                var eb_user_sign_up_response_text = $('#eb_user_sign_up_response_text');

                // Check if any inut is empty
                var eb_user_sign_up_has_error = false;

                // Check if all required fields are empty
                eb_user_sign_up_username.add(eb_user_sign_up_password).add(eb_user_sign_up_email).each( function() {

                if( !this.value ) {
                    eb_user_sign_up_has_error = true;
                    $(this).addClass("empty");
                }

                });

                // Check if GDPR is checked (only on account signup page)
                if ( !eb_user_sign_up_terms.is(':checked') && eb_js_settings.eb_terms_conditions == true && $('#eb_user_dashboard_signup_form').length ) {
                eb_user_sign_up_terms.addClass("empty");
                eb_user_sign_up_has_error = true;
                }

                // If there is no any error start the AJAX request
                if (eb_user_sign_up_has_error == false) {

                eb_button_loading('eb_user_sign_up');

                // if there is a previous ajax request, then abort it
                if( eb_user_sign_up_xhr != null ) {
                    eb_user_sign_up_xhr.abort();
                    eb_user_sign_up_xhr = null;
                }

                // Start the AJAX request
                eb_user_sign_up_xhr = $.ajax({
                    url: eb_checkout.eb_user_sign_up_ajax,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                    action: 'eb_user_sign_up_action',
                    eb_user_sign_up_username: eb_user_sign_up_username_val,
                    eb_user_sign_up_password: eb_user_sign_up_password_val,
                    eb_user_sign_up_email: eb_user_sign_up_email_val,
                    eb_user_sign_up_first_name: eb_user_sign_up_first_name_val,
                    eb_user_sign_up_last_name: eb_user_sign_up_last_name_val,
                    },

                    // Success
                    success: function (eb_user_sign_up_data) {

                    if (eb_user_sign_up_data.status === 'failed') {

                        eb_button_loading('submit_booking_form', 'hide');
                        eb_button_loading('eb_user_sign_up', 'hide');

                        eb_user_sign_up_response.css("display", "block");
                        eb_user_sign_up_response_text.text(eb_user_sign_up_data.mssg);
                        eb_user_sign_up_response.addClass('eb-alert-error eb-alert-icon');

                    } else {

                        // User Dashboard Signup Redirect to profile details page
                        if( $('#eb_user_dashboard_signup_form').length  ) {

                        eb_user_sign_up_response.css("display", "block");
                        eb_user_sign_up_response.removeClass('eb-alert-error');
                        eb_user_sign_up_response.addClass('eb-alert-success eb-alert-icon');
                        eb_user_sign_up_response_text.text(eb_user_sign_up_data.mssg);

                        document.location.href = eb_user_sign_up_data.redirect_url;

                        } else {

                        // If the user has been signed up succesfully then proceed the booking form
                        $('#eb_booking_form').submit();

                        }

                    }

                    // Console mssg - debug purpose
                    console.log(eb_user_sign_up_data);

                    },

                    error: function (eb_user_sign_up_xhr, textStatus, errorThrown) {},

                    complete: function () {},


                });

            }

            event.preventDefault();

            });

        }

        eb_user_sign_up();

        /**
        * Validate & Apply the Coupon Code
        * Version: 1.0
        */
        function eb_validate_coupon_code() {

            // handler to the ajax request
            var eb_ajax_coupon_code_xhr = null;

            $('#eb_validate_coupon').on('click', function(event) {

                var eb_coupon_code = $('#eb_coupon');
                var eb_coupon_code_value = eb_coupon_code.val();
                var eb_coupon_code_response = $('#eb_coupon_code_response');
                var eb_coupon_code_response_text = $('#eb_coupon_code_response_text');
                var eb_room_price = $('#eb_booking_price').val();
                var eb_trip_price = $('#eb_booking_price').val();
                var eb_booking_form_button = $("#submit_booking_form");

                var eb_coupon_nonce_val = $('#eb_security').val();

                // Check if not empty
                if (eb_coupon_code_value != '') {

                // Animate Checkout Button
                  eb_button_loading('eb_validate_coupon');

                // Disable button click
                eb_booking_form_button.css('pointer-events','none');

                // if there is a previous ajax request, then abort it
                if( eb_ajax_coupon_code_xhr != null ) {
                    eb_ajax_coupon_code_xhr.abort();
                    eb_ajax_coupon_code_xhr = null;
                }

                // Start the AJAX request
                eb_ajax_coupon_code_xhr = $.ajax({
                    url: eb_checkout.eb_coupon_code_ajax,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'eb_coupon_code_action',
                        eb_coupon_code: eb_coupon_code_value,
                        eb_coupon_nonce: eb_coupon_nonce_val,
                    },

                    // Success
                    success: function (eb_coupon_code_data) {

                        eb_coupon_code_response.show();

                        if (eb_coupon_code_data.status === 'failed') {

                            eb_coupon_code_response_text.text(eb_coupon_code_data.message);
                            eb_coupon_code_response.addClass('eb-alert-error mb20');

                        } else {

                            eb_button_loading('submit_booking_form');

                            eb_coupon_code_response_text.text(eb_coupon_code_data.message);
                            eb_coupon_code_response.addClass('eb-alert-success');
                            eb_coupon_code_response.removeClass('eb-alert-error mb20');

                            $('#eb_coupon_code_group').css("display", "none");
                            $('#eb_total_price_text').before('<div class="item coupon-code-applied">' + eb_js_settings.eb_discount_text + '&nbsp;' + ' <strong> ' + eb_coupon_code_data.coupon_code + '</strong> <span class="value">  ' +  eb_coupon_code_data.coupon_percent + '% </span></div>');

                            var eb_final_room_price = eb_room_price - eb_room_price * eb_coupon_code_data.coupon_percent / 100;
                            var eb_final_trip_price = eb_trip_price - eb_trip_price * eb_coupon_code_data.coupon_percent / 100;

                            // Format the price
                            var eb_final_trip_price = Math.round( eb_final_trip_price );
                            var eb_final_trip_price_displayed = number_format( eb_final_trip_price );

                            $("#eb_booking_price").val(eb_final_room_price);
                            $("#eb_total_price_text .price-amount").text(eb_final_trip_price_displayed);
                            $("#eb_booking_price").val(eb_final_trip_price);

                            $('#eb_coupon_value').val(eb_coupon_code_data.coupon_percent);
                            $('#eb_coupon_code').val(eb_coupon_code_data.coupon_code);

                        }

                        // Debug
                        console.log(eb_coupon_code_data.status);

                    },

                    error: function (eb_ajax_coupon_code_xhr, textStatus, errorThrown) {},

                    complete: function () {

                        eb_button_loading('submit_booking_form', 'hide');
                        eb_button_loading('eb_validate_coupon', 'hide');

                    },

                });

            } else {

                eb_coupon_code.addClass("empty");

            }

            event.preventDefault();

            });

        }

        eb_validate_coupon_code();

        /**
        * Validate & Submit Booking form
        * Version: 1.0
        */
        function eb_sumbit_booking_form() {

            $("#submit_booking_form").on('click', function (event) {

                var eb_checked_tab = $('input[name=eb_billing_tab]:checked').val();

                // Main Form Fields
                var eb_user_first_name = $('#eb_user_first_name');
                var eb_user_last_name = $('#eb_user_last_name');
                var eb_user_email = $('#eb_user_email');
                var eb_user_phone = $('#eb_user_phone');

                var eb_user_country = $('#eb_user_country');
                var eb_user_city = $('#eb_user_city');
                var eb_user_address = $('#eb_user_address');
                var eb_user_zip = $('#eb_user_zip');
                var eb_form_terms = $("#eb_terms");
                var eb_form_has_error = false;

                // Check if tabs are enabled or user is already logged in
                if( $('#eb_billing_tabs_content').is(':visible') ) {

                if ( eb_checked_tab === 'signin' ) {

                    // Debug
                    console.log('Login Form Selected')

                    // Prevent checkout without login in
                    eb_form_has_error = true;

                } else if ( eb_checked_tab === 'signup' ) {

                    // Debug
                    console.log('Signup Form Selected');

                    // Phone Number
                    var eb_sign_up_phone_field = document.querySelector('#eb_user_sign_up_phone');
                    var eb_sign_up_phone_iti = window.intlTelInputGlobals.getInstance(eb_sign_up_phone_field);
                    var eb_sign_up_phone_number = eb_sign_up_phone_iti.getNumber();

                    // Get sign up form values
                    var eb_sign_up_user_name = $("#eb_user_sign_up_username");

                    var eb_sign_up_first_name = $("#eb_user_sign_up_first_name");
                    var eb_sign_up_last_name = $("#eb_user_sign_up_last_name");
                    var eb_sign_up_email = $("#eb_user_sign_up_email");
                    var eb_sign_up_password = $("#eb_user_sign_up_password");
                    var eb_sign_up_country = $("#eb_user_sign_up_country");
                    var eb_sign_up_city = $("#eb_user_sign_up_city");
                    var eb_sign_up_address = $("#eb_user_sign_up_address");
                    var eb_sign_up_zip = $("#eb_user_sign_up_zip");

                    // Check if all required fields are empty
                    eb_sign_up_user_name.add(eb_sign_up_first_name).add(eb_sign_up_last_name).add(eb_sign_up_email).add(eb_sign_up_phone_field).add(eb_sign_up_password).each( function() {

                    if( !this.value ) {
                        eb_form_has_error = true;
                        $(this).addClass("empty");
                    }

                    });

                    // Validate Email
                    if ( eb_validate_email( eb_sign_up_email.val() ) == false ) {
                        eb_form_has_error = true;
                        eb_sign_up_email.addClass("empty");
                    }

                    // Validate Phone Number
                    if ( eb_validate_phone_number( eb_sign_up_phone_number ) == false ) {
                        eb_form_has_error = true;
                        $('#eb_user_sign_up_phone').addClass("empty");
                    }

                    // Add sign up values to the main form
                    eb_user_first_name.val(eb_sign_up_first_name.val());
                    eb_user_last_name.val(eb_sign_up_last_name.val());
                    eb_user_email.val(eb_sign_up_email.val());
                    eb_user_phone.val(eb_sign_up_phone_number);
                    eb_user_country.val(eb_sign_up_country.val());
                    eb_user_city.val(eb_sign_up_city.val());
                    eb_user_address.val(eb_sign_up_address.val());
                    eb_user_zip.val(eb_sign_up_zip.val());

                } else {

                    // Phone Number
                    var eb_guest_phone_field = document.querySelector('#eb_guest_phone');
                    var eb_guest_phone_iti = window.intlTelInputGlobals.getInstance(eb_guest_phone_field);
                    var eb_guest_phone_number = eb_guest_phone_iti.getNumber();

                    // Geust (Default)
                    var eb_guest_first_name = $("#eb_guest_first_name");
                    var eb_guest_last_name = $("#eb_guest_last_name");
                    var eb_guest_email = $("#eb_guest_email");
                    var eb_guest_country = $("#eb_guest_country");
                    var eb_guest_city = $("#eb_guest_city");
                    var eb_guest_address = $("#eb_guest_address");
                    var eb_guest_zip = $("#eb_guest_zip");

                    // Check if all required fields are empty
                    eb_guest_first_name.add(eb_guest_last_name).add(eb_guest_email).add(eb_guest_phone_field).each( function() {

                    if( !this.value ) {
                        eb_form_has_error = true;
                        $(this).addClass("empty");
                    }

                    });

                    // Validate Email
                    if ( eb_validate_email( eb_guest_email.val() ) == false ) {
                        eb_form_has_error = true;
                        eb_guest_email.addClass("empty");
                    }

                    // Validate Phone Number
                    if ( eb_validate_phone_number( eb_guest_phone_number ) == false ) {
                    eb_form_has_error = true;
                    $('#eb_guest_phone').addClass("empty");
                    }

                    // Add guest values to the main form
                    eb_user_first_name.val(eb_guest_first_name.val());
                    eb_user_last_name.val(eb_guest_last_name.val());
                    eb_user_email.val(eb_guest_email.val());
                    eb_user_phone.val(eb_guest_phone_number);
                    eb_user_country.val(eb_guest_country.val());
                    eb_user_city.val(eb_guest_city.val());
                    eb_user_address.val(eb_guest_address.val());
                    eb_user_zip.val(eb_guest_zip.val());

                    // Debug
                    console.log('Guest Form Selected');

                }

                // User is logged in
                } else {

                // Phone Number
                var eb_signed_in_user_phone_field = document.querySelector('#eb_signed_in_user_phone');
                var eb_signed_in_user_phone_iti = window.intlTelInputGlobals.getInstance(eb_signed_in_user_phone_field);
                var eb_signed_in_user_phone_number = eb_signed_in_user_phone_iti.getNumber();

                // Get siged in values
                var eb_signed_in_user_first_name = $('#eb_signed_in_user_first_name');
                var eb_signed_in_user_last_name = $('#eb_signed_in_user_last_name');
                var eb_signed_in_user_email = $('#eb_signed_in_user_email');
                var eb_signed_in_user_country = $('#eb_signed_in_user_country');
                var eb_signed_in_user_city = $('#eb_signed_in_user_city');
                var eb_signed_in_user_address = $('#eb_signed_in_user_address');
                var eb_signed_in_user_zip = $('#eb_signed_in_user_zip');

                // Check if all required fields are empty
                eb_signed_in_user_first_name.add(eb_signed_in_user_last_name).add(eb_signed_in_user_email).add(eb_signed_in_user_phone_field).each( function() {

                    if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                    }

                });

                // Validate Email
                if ( eb_validate_email( eb_signed_in_user_email.val() ) == false ) {
                    eb_form_has_error = true;
                    eb_signed_in_user_email.addClass("empty");
                }

                // Validate Phone Number
                if ( eb_validate_phone_number( $('#eb_signed_in_user_phone').val() ) == false ) {
                    eb_form_has_error = true;
                    $('#eb_signed_in_user_phone').addClass("empty");
                }

                // Add signed in values to the main form
                eb_user_first_name.val(eb_signed_in_user_first_name.val());
                eb_user_last_name.val(eb_signed_in_user_last_name.val());
                eb_user_email.val(eb_signed_in_user_email.val());
                eb_user_phone.val(eb_signed_in_user_phone_number);
                eb_user_country.val(eb_signed_in_user_country.val());
                eb_user_city.val(eb_signed_in_user_city.val());
                eb_user_address.val(eb_signed_in_user_address.val());
                eb_user_zip.val(eb_signed_in_user_zip.val());

                }

                // Check if GDPR is checked
                if (!eb_form_terms.is(':checked') && eb_js_settings.eb_terms_conditions == true) {
                eb_form_terms.addClass("empty");
                eb_form_has_error = true;
                }

                // If everything is ok submit form
                if ( eb_form_has_error == false ) {

                // Submit the signup form only if signup option has been selected
                if ( eb_checked_tab === 'signup' ) {

                    $("#eb_user_signup_booking_form").submit();

                } else {

                    // Submit the booking form if everything is ok
                    $('#eb_booking_form').submit();

                }

                eb_button_loading('submit_booking_form');

                } else {

                event.preventDefault();

                console.log('Error');

                // Scroll to first empty field
                var element_to_scroll = $('.empty').first();
                $('html').animate({
                    scrollTop: $(element_to_scroll).offset().top - 200
                }, 500);

                }

            })

            // Remove 'empty' class on keydown
            $('input').on("keydown", function () {
            $(this).removeClass("empty");
            })

        }

        eb_sumbit_booking_form();

    });

})(jQuery);