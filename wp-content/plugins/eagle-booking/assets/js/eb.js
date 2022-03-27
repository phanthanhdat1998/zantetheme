/*================================================
* Plugin Name: Eagle Booking
* Version: 1.2.9.4
* Author: Eagle Themes (Jomin Muskaj)
* Author URI: eagle-booking.com
=================================================*/

  /**
  * Functions that can be called by external files
  * Use jQuery instead of $
  */

  /**
  * Button Animation
  * Version: 1.0
  * Can be called externally
  */
  function eb_button_loading(eb_button_id, eb_button_action) {

    var eb_button = jQuery('#'+eb_button_id);
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
    jQuery(window).unload(function () { jQuery(window).unbind('unload'); });

  }

  /**
  * Re-initialixe fixed sidebar
  * Version: 1.0
  * Can be called externally
  */
  function eb_fixed_sidebar( update ) {

    var adminbar = jQuery('#wpadminbar');
    var header = jQuery('header');
    var stickysidebar = jQuery('.sticky-sidebar');

    if (adminbar.length && adminbar.is(':visible')) {
      var adminsidebarfixed = adminbar.height();
    } else {
      var adminsidebarfixed = 0;
    }

    if (header.hasClass("fixed")) {
      var headersidebarfixed = header.height();
    } else {
      var headersidebarfixed = 10;
    }

    var sidebarfixed = adminsidebarfixed + headersidebarfixed;

    if (stickysidebar.length) {

      var sidebar = new StickySidebar('.sticky-sidebar', {
        topSpacing: sidebarfixed + 20,
        bottomSpacing: 0,
        containerSelector: '.eb-sticky-sidebar-container',
        minWidth: 991
      });

    }

    // re-initialize
    if ( update === 'update' ) {

      // Update sticky sidebar
      if (stickysidebar.length) {
        sidebar.updateSticky();
      }

    }

  }


(function ($) {

  "use strict";

  /* Document is Raedy */
  $(document).ready(function () {

    // Sticky Sidebar
    eb_fixed_sidebar();

    // =============================================
    // PAYMENT TABS
    // =============================================
    var checkout_tabs = $(".checkout-payment-tabs");
    if (checkout_tabs.length) {
      checkout_tabs.tabs();
    }

    // =============================================
    // STICKY SIDEBAR
    // =============================================
    // var adminbar = $('#wpadminbar');
    // var header = $('header');
    // var stickysidebar = $('.sticky-sidebar');

    // if (adminbar.length && adminbar.is(':visible')) {
    //   var adminsidebarfixed = adminbar.height();
    // } else {
    //   var adminsidebarfixed = 0;
    // }

    // if (header.hasClass("fixed")) {
    //   var headersidebarfixed = header.height();
    // } else {
    //   var headersidebarfixed = 10;
    // }

    // var sidebarfixed = adminsidebarfixed + headersidebarfixed;

    // if (stickysidebar.length) {

    //   var sidebar = new StickySidebar('.sticky-sidebar', {
    //     topSpacing: sidebarfixed + 20,
    //     bottomSpacing: 0,
    //     containerSelector: '.eb-sticky-sidebar-container',
    //     minWidth: 991
    //   });

    // }


    // =============================================
    // ROOM SERVICES ON HOVER
    // =============================================
    $(".room-item .room-image").on({
      mouseenter: function () {
        $(this).parent().find('.room-services').addClass('active');
      },
    });

    $(".room-item").on({
      mouseleave: function () {
        $(this).parent().find('.room-services').removeClass('active');
      }
    });


    // =============================================
    // Magnific Popup - Room Details Page Slider
    // =============================================
    $('.eb-image-gallery').magnificPopup({
      delegate: '.swiper-slide:not(.swiper-slide-duplicate) a',
      type: 'image',
      fixedContentPos: true,
      gallery: {
        enabled: true,
        preload: [0,1],
        navigateByImgClick: true,
        tPrev: eb_js_settings.eb_magnific_previous,
        tNext: eb_js_settings.eb_magnific_next,
        tCounter: '%curr%' + ' ' + eb_js_settings.eb_magnific_counter + ' ' + '%total%'

      },
      removalDelay: 300,
      mainClass: 'mfp-fade',
      retina: {
        ratio: 1,
        replaceSrc: function(item, ratio) {
          return item.src.replace(/\.\w+$/, function(m) {
            return '@2x' + m;
          });
        }
      },

      tClose: eb_js_settings.eb_magnific_close,
      tLoading: eb_js_settings.eb_magnific_loading,

    });


    // =============================================
    // Room Details Page Slider
    // =============================================

    var eb_room_slider_autplay = eb_js_settings.eb_room_slider_autoplay;

    if ( eb_room_slider_autplay == 1 ) {
      eb_room_slider_autplay = true;
    } else {
      eb_room_slider_autplay = false;
    }

    if ( $('#eb-room-slider-thumbs').length ) {

      var thumbsSlider = new Swiper('#eb-room-slider-thumbs', {
        spaceBetween: 15,
        slidesPerView: 6,
        loop: true,
        freeMode: false,
        loopedSlides: 5,
        breakpoints: {
          360: {
            slidesPerView: 3,
            spaceBetween: 10
          },

          480: {
            slidesPerView: 4,
            spaceBetween: 10
          },

          640: {
            slidesPerView: 5,
            spaceBetween: 10
          }
        },
        watchSlidesVisibility: false,
        watchSlidesProgress: false
      });

    }

    if ( $('#eb-room-slider').length ) {

      var mainSlider = new Swiper('#eb-room-slider', {
        spaceBetween: 15,
        loop: true,
        preloadImages: false,
        loopedSlides: 5,
        navigation: {
          nextEl: '.swiper-next',
          prevEl: '.swiper-prev',
        },
        thumbs: {
          swiper: thumbsSlider,
        },

        autoplay: eb_room_slider_autplay,

      });

    }

    // Check if exist first
    if ( $('#eb-room-full-slider').length ) {

      $('.eb-room-page').addClass('full-slider-is-used');

      var fullslider = new Swiper('#eb-room-full-slider', {
        spaceBetween: 20,
        grabCursor: true,
        slidesPerView: 4,
        centeredSlides: true,
        loop: true,
        preloadImages: false,
        loopedSlides: 5,
        breakpoints: {
          360: {
            slidesPerView: 1,
            spaceBetween: 10
          },

          480: {
            slidesPerView: 1,
            spaceBetween: 10
          },

          992: {
            slidesPerView: 2,
            spaceBetween: 10
          }
        },
        navigation: {
          nextEl: '.swiper-next',
          prevEl: '.swiper-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },

        autoplay: eb_room_slider_autplay,

        on: {
          init: function () {

            // // Update sticky sidebar
            // if (stickysidebar.length) {
            //   sidebar.updateSticky();
            // }

            eb_fixed_sidebar('update');

          }
        },


      });
    }

    // =============================================
    // VALIDATE HOMEPAGE & ROMM PAGE FORM / CHANGE THE OUTPUT FORMAT BASED ON THE BOOKING SYSTEM
    // =============================================
    $("#room-booking-form, #search-form").on('submit', function (e) {

      var eagle_booking_dates = $("#eagle_booking_datepicker");

      if (eagle_booking_dates.val() === '') {

        e.preventDefault();
        eagle_booking_dates.click();

      } else {

        eb_button_loading('eb_search_form');

        var eb_booking_type = eb_js_settings.eb_booking_type;
        var eb_custom_date_format = eb_js_settings.eb_custom_date_format;
        var eb_date_format = eb_js_settings.eagle_booking_date_format.toUpperCase();
        var eb_output_checkin = $('#eagle_booking_checkin').val();
        var eb_output_checkout = $('#eagle_booking_checkout').val();

        if (eb_booking_type === 'builtin') {

          // Single Room
          if ( $('form').hasClass('room-booking-form') ) {

            var eb_output_format = 'MM/DD/YYYY';

          // Search Form
          } else {

            var eb_output_format = 'MM-DD-YYYY';

          }

        } else if (eb_booking_type === 'booking') {

          var eb_output_format = 'YYYY-MM-DD';

        } else if (eb_booking_type === 'airbnb') {

          var eb_output_format = 'YYYY-MM-DD';

        } else if (eb_booking_type === 'tripadvisor') {

          var eb_output_format = 'MM-DD-YYYY';

        } else if (eb_booking_type === 'custom') {

          var eb_output_format = eb_custom_date_format;

        }

        var eb_output_checkin_formated = moment(eb_output_checkin, eb_date_format).format(eb_output_format);
        var eb_output_checkout_formated = moment(eb_output_checkout, eb_date_format).format(eb_output_format);

        $('#eagle_booking_checkin').val(eb_output_checkin_formated);
        $('#eagle_booking_checkout').val(eb_output_checkout_formated);


      }

    })

    // =============================================
    // DATERANGEPICKER
    // =============================================
    var eb_calendar_min_date = new Date();
    var eb_calendar_max_date = moment(eb_calendar_min_date).add(eb_js_settings.eb_calendar_availability_period, 'M').endOf('month');
    var eagle_booking_date_format = eb_js_settings.eagle_booking_date_format.toUpperCase();
    var eagle_booking_datepicker = $("#eagle_booking_datepicker");

    var eb_signle_room = false;

    // Check if calendar is on single room
    if ( $('form').hasClass('room-booking-form') ) {

      eb_signle_room = true;

    }

    $(eagle_booking_datepicker).each(function () {

      $(eagle_booking_datepicker).daterangepicker({
          autoUpdateInput: false,
          autoApply: true,
          alwaysShowCalendars: true,
          linkedCalendars: true,

          isInvalidDate: function(date) {

            if ( typeof eb_booked_dates!== 'undefined' && eb_booked_dates != '' ) {

              return !!(eb_booked_dates.indexOf(date.format('YYYY/MM/DD')) > -1);

            }

           },

          minDate: eb_calendar_min_date,
          maxDate: eb_calendar_max_date,
          locale: {
            format: eagle_booking_date_format,
            separator: " → ",
            "daysOfWeek": [
              eb_js_settings.eb_calendar_sunday,
              eb_js_settings.eb_calendar_monday,
              eb_js_settings.eb_calendar_tuesday,
              eb_js_settings.eb_calendar_wednesday,
              eb_js_settings.eb_calendar_thursday,
              eb_js_settings.eb_calendar_friday,
              eb_js_settings.eb_calendar_saturday,
            ],
            "monthNames": [
              eb_js_settings.eb_calendar_january,
              eb_js_settings.eb_calendar_february,
              eb_js_settings.eb_calendar_march,
              eb_js_settings.eb_calendar_april,
              eb_js_settings.eb_calendar_may,
              eb_js_settings.eb_calendar_june,
              eb_js_settings.eb_calendar_july,
              eb_js_settings.eb_calendar_august,
              eb_js_settings.eb_calendar_september,
              eb_js_settings.eb_calendar_october,
              eb_js_settings.eb_calendar_november,
              eb_js_settings.eb_calendar_december,
            ],
            "firstDay": 1
          }
        }),

        $(eagle_booking_datepicker).on("apply.daterangepicker", function () {

          // Displayd Format
          var checkin = $(eagle_booking_datepicker).data('daterangepicker').startDate.format(eagle_booking_date_format);
          var checkout = $(eagle_booking_datepicker).data('daterangepicker').endDate.format(eagle_booking_date_format);

          // Display Date
          $(this).val(checkin + " " + " " + " → " + " " + " " + checkout);

          // Add value to hidden inouts
          $('#eagle_booking_checkin').val(checkin);
          $('#eagle_booking_checkout').val(checkout);

          // Update Booking Filters only for the search page (filters)
          if ($("div").hasClass("search-filters")) {
            eagle_booking_filters();
          }

          if ($("div").hasClass("search-filters") || $("div").hasClass("calendar")) {
            eagle_booking_get_nights();
          }

          // Disable all booked & blocked room on the signle room calendar
          if ( eb_signle_room == true ) {

            var i, eb_booked_date;

            // Loop all booked dates until the condition
            for( i = 0; i < eb_booked_dates.length; i++ ) {

              eb_booked_date = moment(eb_booked_dates[i]).format('YYYY/MM/DD');

              var checkin_new = $(eagle_booking_datepicker).data('daterangepicker').startDate.format('YYYY-MM-DD');
              var checkout_new = $(eagle_booking_datepicker).data('daterangepicker').endDate.format('YYYY-MM-DD');

              if ( moment(eb_booked_date).isBetween(checkin_new, checkout_new) ) {

                $(this).data('daterangepicker').setStartDate(checkout);
                $(this).val("").focus();

                // Break loop on the first match
                break;

              }

          }

          }

        }),

        // Live Booking Nights
        $(eagle_booking_datepicker).on("show.daterangepicker", function () {

          var live_checkin = $('#eagle_booking_checkin').val();
          var live_checkout = $('#eagle_booking_checkout').val();


          if (live_checkin != '' && live_checkout != '') {
            var eagle_booking_nights_div = $('<div class="booking-nights">' + live_checkin + '&nbsp;' + ' → ' + '&nbsp' + live_checkout + ' (' + eagle_booking_get_nights() + ' ' + eb_js_settings.eb_booking_nights + ')</div>');
            $(".booking-nights").remove();
            $(".daterangepicker").append(eagle_booking_nights_div);
          }

          $(document).on('mouseenter', '.start-date', function () {
            live_checkin = $(this).attr('data-date');
            live_checkin = moment(live_checkin, 'MM/DD/YYYY').format(eb_js_settings.eagle_booking_date_format.toUpperCase());
            $('#eagle_booking_checkin').val(live_checkin)
          })

          $(document).on('mouseenter', '.in-range', function () {
            live_checkout = $(this).attr('data-date');
            live_checkout = moment(live_checkout, 'MM/DD/YYYY').format(eb_js_settings.eagle_booking_date_format.toUpperCase());
            $('#eagle_booking_checkout').val(live_checkout)
          })

          $(document).on('mouseenter', '.start-date, .in-range', function () {
            var eagle_booking_nights_div = $('<div class="booking-nights">' + live_checkin + '&nbsp;' + ' → ' + '&nbsp' + live_checkout + ' (' + eagle_booking_get_nights() + ' ' + eb_js_settings.eb_booking_nights + ')</div>');
            $(".booking-nights").remove();
            $(".daterangepicker").append(eagle_booking_nights_div);
          })

        });

    })

    // =============================================
    // CALCULATE NIGHTS NUMBER
    // =============================================
    function eagle_booking_get_nights() {

      var eagle_booking_checkin = $('#eagle_booking_checkin').val();
      var eagle_booking_checkout = $('#eagle_booking_checkout').val();

      var eagle_booking_start_date = moment(eagle_booking_checkin, eb_js_settings.eagle_booking_date_format.toUpperCase()).format('YYYY-MM-DD');;
      var eagle_booking_end_date = moment(eagle_booking_checkout, eb_js_settings.eagle_booking_date_format.toUpperCase()).format('YYYY-MM-DD');;

      var booking_nights = (new Date(eagle_booking_end_date)) - (new Date(eagle_booking_start_date));
      var eagle_booking_nights_number = booking_nights / (1000 * 60 * 60 * 24);
      if (eagle_booking_nights_number < 0) {
        var eagle_booking_nights_number = '0';
      }

      return eagle_booking_nights_number;

    }

    // =============================================
    // Guests Picker
    // =============================================
    $('.eb-guestspicker .guestspicker').on('click', function (event) {
      $('.eb-guestspicker').toggleClass('active');

      $('.eb-select-list').removeClass('active');

      event.preventDefault();
    });
    $(window).click(function () {
      $('.eb-guestspicker').removeClass('active');
    });
    $('.eb-guestspicker').on('click', function (event) {
      event.stopPropagation();
    });

    function guestsSum() {
      var guests_button = $('.guests-button');
      var arr = $('.booking-guests');
      var guests = 0;

      for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value, 10))
          guests += parseInt(arr[i].value, 10);
      }

      if (guests > 0) {

        var cardQty = document.querySelector(".gueststotal");
        cardQty.innerHTML = guests;

      }

      // Add the new value to geust input
      $("#eagle_booking_guests").val(guests);

    }

    // Execute
    guestsSum();

    function guestsPicker() {

      $(".plus, .minus").on("click", function () {
        var button = $(this);

        // Get the max value from data-max
        var oldValue = button.parent().find("input").val();
        var max_value = parseFloat(button.parent().find("input").attr('max'));
        var min_value = parseFloat(button.parent().find("input").attr("min"));

        if ( button.hasClass('plus') && max_value > 0 ) {

          if (oldValue < max_value) {

            var newVal = parseFloat(oldValue) + 1;

          } else {

            newVal = oldValue;

          }

        } else {

          if (oldValue > min_value) {
            var newVal = parseFloat(oldValue) - 1;
          } else {
            newVal = min_value;
          }

        }

        button.parent().find("input").val(newVal);

        // Get guests sum
        guestsSum();


        if ($('form').hasClass('booking-search-form')) {
          eagle_booking_filters();
        }

      });

    }

    // Execute
    guestsPicker();

    // =============================================
    // Branch Selector
    // =============================================
    $('.eb-select').on('click', function (event) {

      $(this).find('.eb-select-list').toggleClass('active');

      event.stopPropagation();

    });

    $(window).click(function () {
      $('.eb-select-list').removeClass('active');
    });

    $('.eb-select-list li').on('click', function (event) {

      $('.eb-select-list li').removeClass('selected');
      $(this).toggleClass('selected');

      var selected_branch = $('.eb-select-list li.selected').text();
      var selected_branch_id = $('.eb-select-list li.selected').data('branch-id');

      $('#branch_text').text(selected_branch);
      $('#eb_branch').val( selected_branch_id );

    });

    // =============================================
    // PRICE RANGE
    // =============================================
    var eb_price_range = $("#eagle_booking_slider_range");
    var eb_currency_position = eb_js_settings.eb_currency_position;

    if ( eb_currency_position === 'after' ) {

      var eb_prefix = '';
      var eb_postfix = eb_js_settings.eb_currency;

    } else {

      var eb_prefix = eb_js_settings.eb_currency;
      var eb_postfix = '';

    }

    eb_price_range.ionRangeSlider({
      type: "double",
      skin: "round",
      grid: true,
      min: eb_js_settings.eagle_booking_price_range_min,
      max: eb_js_settings.eagle_booking_price_range_max,
      from: eb_js_settings.eagle_booking_price_range_default_min,
      to: eb_js_settings.eagle_booking_price_range_default_max,
      prefix: eb_prefix,
      postfix: eb_postfix,
      onFinish: function (data) {
        $('#eagle_booking_min_price').val(data.from);
        $('#eagle_booking_max_price').val(data.to);
        eagle_booking_filters();

      },

      onUpdate: function (data) {
        disable: true
      }
    });


    // =============================================
    // Styled Radio Box
    // =============================================
    $('.eb-radio-box').on('click', function() {

      // Remove any previous selected option & reset the previous checked radiobox
      $('.eb-radio-box').removeClass('selected');
      $('.eb-radio-box').find('input').prop('checked', false);

      // Add selected class to this & check it
      $(this).addClass('selected');
      $(this).find('input').prop('checked', true);

    });

    // =============================================
    // SERVICES FILTER
    // =============================================
    $(".eb_normal_service").change(function () {

      if ($(this).is(":checked")) {

        var eb_normal_service_value = $(this).val();
        var eb_normal_service_previous_value = $("#eb_normal_services").val();
        $("#eb_normal_services").val(eb_normal_service_value + eb_normal_service_previous_value);
        eagle_booking_filters();

      } else {

        var eb_normal_service_value = $(this).val();
        var eb_normal_service_previous_value = $("#eb_normal_services").val();
        var eb_normal_services = eb_normal_service_previous_value.replace(eb_normal_service_value, "");

        $("#eb_normal_services").val(eb_normal_services);
        eagle_booking_filters();
      }
    });


    // =============================================
    // ADDITIONAL SERVICES FILTER
    // =============================================
    $(".eb_checkbox_additional_service").change(function () {

      if ($(this).is(":checked")) {

        var eb_additional_service_value = $(this).val();
        var eb_additional_service_previous_value = $("#eb_additional_services").val();
        $("#eb_additional_services").val(eb_additional_service_value + eb_additional_service_previous_value );
        eagle_booking_filters();

      } else {

        var eb_additional_service_value = $(this).val();
        var eb_additional_service_previous_value = $("#eb_additional_services").val();
        var eb_additional_services = eb_additional_service_previous_value.replace(eb_additional_service_value, "");
        $("#eb_additional_services").val(eb_additional_services);
        eagle_booking_filters();
      }

    });

    // =============================================
    // SORTING
    // =============================================
    $("#eagle_booking_search_sorting li").on("click", function () {

      $('#eagle_booking_search_sorting li').removeClass("selected");

      $(this).addClass("selected");

      $('#eagle_booking_active_sorting').text($(this).text());

      eagle_booking_filters();

    });

    // =============================================
    // Branches Filter
    // =============================================
    $('.eb-branch-filter').on('click', function() {

      // Remove all previous checked except the current one
      $('.eb-branch-filter').not(this).removeClass('selected');
      $('.eb-branch-filter').children('input[type="checkbox"]').not(this).prop('checked', false);

      if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');
        $(this).children('input[type="checkbox"]').prop('checked', false);

      } else {

        $(this).addClass('selected');
        $(this).children('input[type="checkbox"]').prop('checked', true);

      }

      var checkbox = $(this).children('input[type="checkbox"]');
      var branch_id  = $("#eb_branch");

      var eb_branch_value = checkbox.val();

      if ((checkbox).is(":checked")) {

        // Set value
        branch_id.val(eb_branch_value );

      } else {

        $(this).removeClass('selected');

        // Clear value
        branch_id.val('');

      }

      // Refresh results
      eagle_booking_filters();

    });

    // =============================================
    // AJAX Filters
    // Modified: 1.2.4
    // Author: Jomin Muskaj
    // =============================================

    // handler to the ajax request
    var eb_ajax_filters_xhr = null;

    function eagle_booking_filters( paged = '') {

      // if there is a previous ajax request, then abort it
      if( eb_ajax_filters_xhr != null ) {
        eb_ajax_filters_xhr.abort();
        eb_ajax_filters_xhr = null;
      }

      // Get Dates from Daterangepicker
      var eagle_booking_checkin = $(eagle_booking_datepicker).data('daterangepicker').startDate.format(eagle_booking_date_format);
      var eagle_booking_checkout = $(eagle_booking_datepicker).data('daterangepicker').endDate.format(eagle_booking_date_format);
      var eb_search_results_alert = $('#eb-no-search-results');
      var eb_search_rooms_rooms_list = $("#eagle_booking_rooms_list");

      // Check if check-in and check-out have been set
      if (eagle_booking_checkin && eagle_booking_checkout) {

        // Remove prevous results
        $("#eagle_booking_search_results").remove();

        // Remove alert
        eb_search_results_alert.remove();

        // Apend loader
        var eagle_booking_search_loader = $('<div class="eagle_booking_search_loader"><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div></div>');

        // Check if there is already a loader
        if ( !$('.eagle_booking_search_loader').length ) {
          eb_search_rooms_rooms_list.append(eagle_booking_search_loader);
        }

        // Get Values
        var eagle_booking_guests = $("#eagle_booking_guests").val();
        var eagle_booking_adults = $("#eagle_booking_adults").val();
        var eagle_booking_children = $("#eagle_booking_children").val();
        var eagle_booking_min_price = $("#eagle_booking_min_price").val();
        var eagle_booking_max_price = $("#eagle_booking_max_price").val();
        var eb_normal_services = $("#eb_normal_services").val();
        var eb_additional_services = $("#eb_additional_services").val();

        var eb_branch = $("#eb_branch").val();

        var eagle_booking_search_sorting_filter_meta_key = $("#eagle_booking_search_sorting .selected a").attr('data-meta-key');
        var eagle_booking_search_sorting_filter_order = $("#eagle_booking_search_sorting .selected a").attr('data-order');
        var eagle_booking_paged = paged;


         // Defaults
         if ( typeof eagle_booking_search_sorting_filter_meta_key == 'undefined') eagle_booking_search_sorting_filter_meta_key = '';
         if ( typeof eagle_booking_search_sorting_filter_order == 'undefined') eagle_booking_search_sorting_filter_order = '';

        // // Update sticky sidebar
        // if (stickysidebar.length) {
        //  sidebar.updateSticky();
        // }

        eb_fixed_sidebar('update');

        // Start the AJAX request
        eb_ajax_filters_xhr = $.ajax({
          url: eb_frontend_ajax.eb_search_filters_ajax,
          method: 'GET',
          data: {
            action: 'eb_search_filters_action',
            eb_search_filters_nonce: eb_frontend_ajax.eb_ajax_nonce,
            eagle_booking_paged: eagle_booking_paged,
            eagle_booking_checkin: eagle_booking_checkin,
            eagle_booking_checkout: eagle_booking_checkout,
            eagle_booking_guests: eagle_booking_guests,
            eagle_booking_adults: eagle_booking_adults,
            eagle_booking_children: eagle_booking_children,
            eagle_booking_min_price: eagle_booking_min_price,
            eagle_booking_max_price: eagle_booking_max_price,
            eb_normal_services: eb_normal_services,
            eb_additional_services: eb_additional_services,
            eb_branch_id: eb_branch,

            eagle_booking_search_sorting_filter_meta_key: eagle_booking_search_sorting_filter_meta_key,
            eagle_booking_search_sorting_filter_order: eagle_booking_search_sorting_filter_order,
          },

          // Success
          success: function (eagle_booking_filters_result) {

            // Remove alert
            eb_search_results_alert.remove();

            // Append new results
            $("#eagle_booking_rooms_list").append(eagle_booking_filters_result);

            // Re-intialize popover
            if ($.fn.popover) {
              $('[data-toggle="popover"]').popover({
                html: true,
                offset: '0 10px'
              });
            }

            // Update sticky sidebar
            // if (stickysidebar.length) {
            //  sidebar.updateSticky();
            // }

            eb_fixed_sidebar('update');

            // Remove Loader
            $('.eagle_booking_search_loader').remove();

            // Scroll to top of the page
            $('html').animate({
              scrollTop: $('body').offset().top
            }, 300);

            // Console mssg - debug purpose
            // console.log("Successful");

          },

          error: function (eb_ajax_filters_xhr, textStatus, errorThrown) {

            // Console mssg - debug purpose
            console.log(errorThrown);

          },

          complete: function () {

            // After request complited update results number
            var eagle_booking_results_qnt = $('#eagle_booking_results_qnt').val();
            $("#results-number").text(eagle_booking_results_qnt);

          }

        });

      } else {

        // Open Calendar if check-in & checkout have not been set
        //$('#eagle_booking_datepicker').click();

      }

    }

    // =============================================
    // Open Calendar on select dates button & scroll
    // =============================================
    $(document).on('click', '#select-booking-dates', function() {

      // Current Height from top
      var docViewTop = $(window).scrollTop();
      // Search form height from top
      var elemTop = $('#search_form').offset().top;

      if( docViewTop > elemTop ) {

        $('html').animate({
          scrollTop: $('body').offset().top
        }, 300);

        // Open Calendar Afrwe srolling to top (with delay)
        setTimeout(function () {
          $('#eagle_booking_datepicker').focus();
        }, 300);

      } else {

        // Open Calendar Afrwe srolling to top (with no delay)
          $('#eagle_booking_datepicker').focus();

      }

    })


    // Search Page Pagination
    $(document).on('click', '.pagination-button', function() {
      var eb_pagination = $(this).attr('data-pagination');
      eagle_booking_filters(eb_pagination);
    })


    // =============================================
    // Room Breakpoint
    // =============================================
    $(document).on('click', '.toggle-room-breakpoint', function () {
      $(this).closest('.room-list-item').find('.room-quick-details').toggleClass('open', 200);
      $(this).toggleClass('open');
      $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    });

    // =============================================
    // More Normal Services
    // =============================================
    $(document).on('click', '.more-normal-services', function () {
      $(this).closest('.room-list-item').find('.room-quick-details').toggleClass('open', 200);
      $(this).closest('.room-list-item').find('.toggle-room-breakpoint').toggleClass('open');
      $(this).closest('.room-list-item').find('.toggle-room-breakpoint i').toggleClass('fa-angle-down fa-angle-up');
    });

    // =============================================
    // EB Dropdown
    // =============================================
    $('.eb-dropdown-toggle').on('click', function() {
      event.stopPropagation();
      $(this).next('.eb-dropdown-menu').toggleClass('open');
    });

    $(window).click(function() {
      $('.eb-dropdown-menu').removeClass('open');
    });



    // EB Forms
  /* Add 'active' class on keydown
  ------------------------------------- */
  function checkForInput(element) {

    var label = $(element).siblings('label');



    if ( $(element).val().length > 0  ) {

      label.addClass('input-has-value');

    } else {

      label.removeClass('input-has-value');

    }


  }

  // The lines below are executed on page load
  $('.eb-form-col input, #eb_guest_phone').each(function() {
    checkForInput(this);
  });

  $('.eb-form-col input, #eb_guest_phone').on('change keydown focus', function() {
    checkForInput(this);
  });


  });


  // =============================================
  // Availability Calendar
  // =============================================
  var pluginName = "simpleCalendar",
    defaults = {
      days: [
        eb_js_settings.eb_calendar_sunday,
        eb_js_settings.eb_calendar_monday,
        eb_js_settings.eb_calendar_tuesday,
        eb_js_settings.eb_calendar_wednesday,
        eb_js_settings.eb_calendar_thursday,
        eb_js_settings.eb_calendar_friday,
        eb_js_settings.eb_calendar_saturday,
      ],
      months: [
        eb_js_settings.eb_calendar_january,
        eb_js_settings.eb_calendar_february,
        eb_js_settings.eb_calendar_march,
        eb_js_settings.eb_calendar_april,
        eb_js_settings.eb_calendar_may,
        eb_js_settings.eb_calendar_june,
        eb_js_settings.eb_calendar_july,
        eb_js_settings.eb_calendar_august,
        eb_js_settings.eb_calendar_september,
        eb_js_settings.eb_calendar_october,
        eb_js_settings.eb_calendar_november,
        eb_js_settings.eb_calendar_december,
      ],
      minDate: "YYYY/MM/DD",
      maxDate: "YYYY/MM/DD",
      insertEvent: true,
      displayEvent: true,
      fixedStartDay: true,
      events: [],
      insertCallback: function () {}
    };

  // The actual plugin constructor
  function Plugin(element, options) {
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.currentDate = new Date();
    this.events = options.events;
    this.init();
  }

  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, {
    init: function () {
      var container = $(this.element);
      var todayDate = this.currentDate;
      var events = this.events;
      var calendar = $('<div class="availability-calendar"></div>');
      var header = $('<div class="availability-calendar-header">' +
        '<span class="btn-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>' +
        '<span class="month"></span>' +
        '<span class="btn-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>' +
        '</div class="availability-calendar-header">');

      this.updateHeader(todayDate, header);
      calendar.append(header);
      this.buildCalendar(todayDate, calendar);
      container.append(calendar);
      this.bindEvents();
    },

    // Update the current month & year header
    updateHeader: function (date, header) {
      header.find('.month').html(this.settings.months[date.getMonth()] + ' ' + date.getFullYear());
    },

    //Build calendar of a month from date
    buildCalendar: function (fromDate, calendar) {
      var plugin = this;

      calendar.find('table').remove();

      var body = $('<table class="calendar"></table>');
      var thead = $('<thead></thead>');
      var tbody = $('<tbody></tbody>');

      //Header day in a week ( (1 to 8) % 7 to start the week by monday)
      for (var i = 1; i <= this.settings.days.length; i++) {
        thead.append($('<td class="day-name">' + this.settings.days[i % 7].substring(0, 3) + '</td>'));
      }

      //setting current year and month
      var y = fromDate.getFullYear(),
        m = fromDate.getMonth();

      //first day of the month
      var firstDay = new Date(y, m, 1);
      //If not monday set to previous monday
      while (firstDay.getDay() != 1) {
        firstDay.setDate(firstDay.getDate() - 1);
      }
      //last day of the month
      var lastDay = new Date(y, m + 1, 0);
      //If not sunday set to next sunday
      while (lastDay.getDay() != 0) {
        lastDay.setDate(lastDay.getDate() + 1);
      }


      for (var day = firstDay; day <= lastDay; day.setDate(day.getDate())) {
        var tr = $('<tr></tr>');
        //For each row
        for (var i = 0; i < 7; i++) {

            // var td = $('<td><span class="day">' + day.getDate() + '<span class="room-price">12$</span>' + '</span></td>');
            var td = $('<td><span class="day">' + day.getDate() + '</span></td>');
          //if today is this day

          var ymd = day.getFullYear() + '-' + day.getMonth() + '-' + day.getDay();
          var ymd = this.formatToYYYYMMDD(day);
          //  console.log(ymd);
          if ($.inArray(this.formatToYYYYMMDD(day), plugin.events) !== -1) {
            //  console.log('found');
            td.find(".day").addClass("event");
          }

          //if day is previous day
          if (day < (new Date())) {
            td.find(".day").addClass("wrong-day");
          }

          if (day.toDateString() === (new Date).toDateString()) {
            td.find(".day").addClass("today");
            td.find(".day").removeClass("wrong-day");
          }
          //if day is not in this month
          if (day.getMonth() != fromDate.getMonth()) {
            td.find(".day").addClass("wrong-month");
          }

          //Binding day event
          td.on('click', function (e) {
            // /alert('ok');
          });

          tr.append(td);
          day.setDate(day.getDate() + 1);
        }
        tbody.append(tr);
      }

      body.append(thead);
      body.append(tbody);

      var eventContainer = $('<div class="event-container"></div>');

      calendar.append(body);
      calendar.append(eventContainer);
    },

    // Init global events listeners
    bindEvents: function () {
      var eb_end_period = eb_js_settings.eb_calendar_availability_period;
      var plugin = this;
      var container = $(this.element);
      var counter = '';
      var startMoth = plugin.currentDate.getMonth();
      var endMonth = startMoth + (eb_end_period - 0);
      var currentMonth = startMoth;


      // Click previous month
      container.find('.btn-prev').on('click', function () {
        if (currentMonth > startMoth) {
          plugin.currentDate.setMonth(plugin.currentDate.getMonth() - 1);
          plugin.buildCalendar(plugin.currentDate, container.find('.availability-calendar'));
          plugin.updateHeader(plugin.currentDate, container.find('.availability-calendar .availability-calendar-header'));

          currentMonth--;
        }

      });

      // Click next month
      container.find('.btn-next').on('click', function () {
        if (currentMonth < endMonth) {
          plugin.currentDate.setMonth(plugin.currentDate.getMonth() + 1);
          plugin.buildCalendar(plugin.currentDate, container.find('.availability-calendar'));
          plugin.updateHeader(plugin.currentDate, container.find('.availability-calendar .availability-calendar-header'));

          currentMonth++;

        }

      });

    },

    formatToYYYYMMDD: function (date) {
      var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [year, month, day].join('/');
    }

  });

  // preventing against multiple instantiations
  $.fn[pluginName] = function (options) {
    return this.each(function () {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
      }
    });
  };

})(jQuery);