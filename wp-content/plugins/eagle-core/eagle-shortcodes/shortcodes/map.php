<?php
/*---------------------------------------------------------------------------------
GOOGLE MAP
-----------------------------------------------------------------------------------*/
if( !function_exists('eagle_google_map') ) {
    function eagle_google_map($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'map_latitude' => '37.8614626',
            'map_longitude' => '20.625886',
            'map_height' => '500',
            'map_zoom' => '15',
            'map_pin' => '',
            'map_title' => '',
            'map_address' => '',
            'map_desc' => '',
            'map_streetview_button' => '',
        ), $atts));

        ob_start();

        ?>

        <?php $zante_map_pin = wp_get_attachment_url( $map_pin ); ?>
        <?php $token = wp_generate_password(5, false, false); ?>

        <style>
        #map-canvas-<?php echo esc_attr( $token ); ?> {
            border: 1px solid #f2f2f2;
            border-radius: 2px;
            width: 100%;
            height: <?php echo $map_height ?>px;
        }

        </style>

        <?php if (!empty(zante_get_option('google_map_api_key'))) : ?>

        <script>
        jQuery(document).ready(function ($) {
           jQuery(function($) {

                function initialize() {
                    var map;
                    var panorama;
                    var latitude = <?php echo $map_latitude ?>;
                    var longitude = <?php echo $map_longitude ?>;
                    var pin = '<?php echo $zante_map_pin ?>';

                    //Map pin-window details
                    var title = "<?php echo $map_title ?>";
                    var hotel_name = "<?php echo $map_title ?>";
                    var hotel_address = "<?php echo $map_address ?>";
                    var hotel_desc = "<?php echo $map_desc ?>";

                    var hotel_location = new google.maps.LatLng(latitude, longitude);
                    var mapOptions = {
                        center: hotel_location,
                        zoom: <?php echo $map_zoom ?>,
                        scrollwheel: false,
                        streetViewControl: false
                    };
                    map = new google.maps.Map(document.getElementById('map-canvas-<?php echo esc_attr( $token ); ?>'),
                        mapOptions);
                    var contentString =
                        '<div id="infowindow_content">' +
                        '<p><strong>' + hotel_name + '</strong><br>' +
                        hotel_address + '<br>' +
                        hotel_desc + '</p>' +
                        '</div>';

                    var var_infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    var marker = new google.maps.Marker({
                        position: hotel_location,
                        map: map,
                        icon: pin,
                        title: title,
                        maxWidth: 100,
                        optimized: false,
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        var_infowindow.open(map, marker);
                    });
                    panorama = map.getStreetView();
                    panorama.setPosition(hotel_location);
                    panorama.setPov( /** @type {google.maps.StreetViewPov} */ ({
                        heading: 265,
                        pitch: 0
                    }));

                    var openStreet = document.getElementById('openStreetView');
                    if (openStreet) {
                        document.getElementById("openStreetView").onclick = function () {
                            toggleStreetView()
                        };
                    }

                    function toggleStreetView() {
                        var toggle = panorama.getVisible();
                        if (toggle == false) {
                            panorama.setVisible(true);
                        } else {
                            panorama.setVisible(false);
                        }
                    }
                }

                //Check if google map div exist
                if ($("#map-canvas-<?php echo esc_attr( $token ); ?>").length){
                   google.maps.event.addDomListener(window, 'load', initialize);
                }

                });
                });

                </script>

                <?php endif ?>

                <div class="google-map">
                  <?php if ( $map_streetview_button == true ) : ?>
                  <div class="toggle-streetview" id="openStreetView"><i class="fa fa-street-view" aria-hidden="true"></i></div>
                  <?php endif ?>
                  <div id="map-canvas-<?php echo esc_attr( $token ); ?>"></div>
                </div>


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('zante-google-map', 'eagle_google_map');
}
