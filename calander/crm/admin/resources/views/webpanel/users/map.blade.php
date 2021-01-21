@extends('webpanel.layouts.base')
@section('title')
    Customers Location
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Customers</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">
            @include('webpanel.includes.notifications')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Clients Click marker to see customer address</h6>
                </div>
                <div class="panel-body">
                    <div id="map" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script src="http://maps.google.com/maps/api/js?key=AIzaSyB9_FPiJSMDHHJ_a5n-dcZaQI9orG_iZ9o&sensor=false"
            type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            var map;
            var elevator;
            var myOptions = {
                zoom: 10,
                center: new google.maps.LatLng(0, 0),
                mapTypeId: 'terrain'
            };
            map = new google.maps.Map($('#map')[0], myOptions);
            var bounds = new google.maps.LatLngBounds();
            var infoWindow = new google.maps.InfoWindow();
            var geocoder = new google.maps.Geocoder();

            function codeAddress(user) {
                var address = user.address;
                if(address == ''){
                    return;
                }
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        if(marker)
                            marker.setMap(null);

                        var latlng = results[0].geometry.location;
                        bounds.extend(latlng);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            draggable: true,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 6,
                                strokeColor: user.isActive ? 'green' : 'red'
                            }
                        });

                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = user.name;
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');
                        text.textContent = user.address;
                        infowincontent.appendChild(text);

                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });

                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            for (var x = 0; x < users.length; x++) {
                codeAddress(users[x]);
            }
            map.fitBounds(bounds);
        });

    </script>

@stop