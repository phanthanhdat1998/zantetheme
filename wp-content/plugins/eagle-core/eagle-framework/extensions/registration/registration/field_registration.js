(function($) {

    "use strict";

    // =============================================
    // Theme Activation
    // =============================================

    // handler to the ajax request
    var theme_activation = null;

    function eth_theme_activation() {

        $('#eth_theme_activation_button').on('click', function(event) {

            // if there is a previous ajax request, then abort it
            if( theme_activation != null ) {
                theme_activation.abort();
                theme_activation = null;
            }

            var eth_purchase_code = $("#eth_purchase_code").val();

            if ( eth_purchase_code != '' ) {

            console.log(eth_purchase_code);

            // Start the AJAX request
            theme_activation = $.ajax({
                url: 'https://api.eagle-themes.com/purchase/',
                method: 'POST',
                dataType: 'json',
                contentType : "application/json",

                // Data to send to the server
                data: 'id=10',

            })

            // Always
            .always(function (responsedata) {

            })

            // Success
            .done(function (responsedata) {

                console.log(responsedata);

            })

            // Fail
            .fail(function (responsedata) {

                console.log(responsedata);

            })

            } else {


                console.log('The purchase code is empty');

            }

            event.preventDefault();

        })

    }

    eth_theme_activation();

})(jQuery);