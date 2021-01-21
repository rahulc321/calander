 <!-- <?php error_reporting(0) ?> -->
 @extends('webpanel.layouts.base')
@section('title')
User Info
@parent
@stop
@section('body')
<script type='text/javascript' src='https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js'></script>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyDe6orIFBWaj-afNJA8ma4u0TbNjDQGJn4" type="text/javascript"></script>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js'></script>
 

 
    <div id="container">

        <article class="entry">

             

            <div class="entry-content">

                <?php /* === THIS IS WHERE WE WILL ADD OUR MAP USING JS ==== */ ?>
                <div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
                    <div id="google-map" class="google-map">
                    </div><!-- #google-map -->
                </div>

                <?php /* === MAP DATA === */ ?>
                <?php
                $locations = array();
                $i=0;
                foreach( $userInfos as $userInfo ){
                

                //echo '<pre>';print_r($userInfo);
                $lat = $userInfo->lat;
                $lng = $userInfo->lng;
                if($userInfo->type=='future'){
                $locations[] = array(
                    'google_map' => array(
                        'lat' => $lat,
                        'lng' => $lng,
                    ),
                    'location_address' => $userInfo->address,
                    'location_name'    => $userInfo->first_name.' '.$userInfo->last_name,
                );
                }else{

                    $locations[] = array(
                    'google_map' => array(
                        'lat' => $lat,
                        'lng' => $lng,
                    ),
                    'location_address' => $userInfo->address,
                    'location_name'    => $userInfo->full_name,
                );

                }
               
                
                $i++;
                }
               // die;
               // echo '<pre>';print_r($locations);die;
                ?>


                <?php /* === PRINT THE JAVASCRIPT === */ ?>

                <?php
                /* Set Default Map Area Using First Location */
                if(!empty($locations)){
                $map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
                $map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
                ?>

                <script>
                jQuery( document ).ready( function($) {

                    /* Do not drag on mobile. */
                    var is_touch_device = 'ontouchstart' in document.documentElement;

                    var map = new GMaps({
                        el: '#google-map',
                        lat: '<?php echo $map_area_lat; ?>',
                        lng: '<?php echo $map_area_lng; ?>',
                        scrollwheel: false,
                        draggable: ! is_touch_device
                    });

                    /* Map Bound */
                    var bounds = [];

                    <?php /* For Each Location Create a Marker. */
                    
                    foreach( $locations as $location ){


                        $name = $location['location_name'];
                        $addr = $location['location_address'];
                        $map_lat = $location['google_map']['lat'];
                        $map_lng = $location['google_map']['lng'];
                        ?>
                        /* Set Bound Marker */
                        var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
                        bounds.push(latlng);
                        /* Add Marker */
                        map.addMarker({
                            lat: <?php echo $map_lat; ?>,
                            lng: <?php echo $map_lng; ?>,
                            title: '<?php echo $name; ?>',
                            infoWindow: {
                                content: '<p><?php echo $name; ?></p>'
                            }
                        });

                        

                    <?php }
                        
                     //end foreach locations ?>

                    /* Fit All Marker to map */
                    map.fitLatLngBounds(bounds);

                    /* Make Map Responsive */
                    var $window = $(window);
                    function mapWidth() {
                        var size = $('.google-map-wrap').width();
                        $('.google-map').css({width: size + 'px', height: (size/2) + 'px'});
                    }
                    mapWidth();
                    $(window).resize(mapWidth);

                });
                </script>
            <?php } ?>
                 

            </div><!-- .entry-content -->

        </article>

    </div><!-- #container -->
@stop

@section('scripts')
      
@stop