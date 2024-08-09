@extends('partial.app')

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/leaflet.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/MarkerCluster.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/MarkerCluster.Default.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendors/esri-leaflet/esri-leaflet-geocoder.css') }}">
   <style>
      .map-scroll:before {
         content: 'Use ctrl + scroll to zoom the map';
         position: absolute;
         top: 50%;
         left: 36%;
         z-index: 9999;
         font-size: 24px;
         color: #fff;
      }

      .map-scroll:after {
         position: absolute;
         left: 0;
         right: 0;
         bottom: 0;
         top: 0;
         content: '';
         background: rgba(0, 0, 0, 0.3);
         z-index: 998;
      }
   </style>
@endsection

@section('content')
    <!-- Modal -->
    <div id="edit_modal">
        <div class="modal-dialog" id="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-header text-center"> <b>FORM UPGRADE Business</b> </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="form_submit" action="/profile/upgrade" method="POST" autocomplete="off">
                            <input type="text" name="id" id="id" hidden value="{{ auth()->user()->id }}">
                            <div class="ec-vendor-upload-detail">
                                <div class="row">
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">NPWP</label>
                                        <input type="text" id="npwp" name="npwp" class="form-control required-field" maxlength="15" onkeypress="return onKeypressAngka(event,false);">
                                    </div>
                                    <div class="col-md-12 space-t-15">
                                           <div id="myMap" style="width: 100%; height: 400px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">Latitude</label>
                                            <input type="text" id="lat" name="lat" class="form-control required-field" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12 space-t-15 mt-2">
                                        <label class="form-label">Longitude</label>
                                            <input type="text" id="lng" name="lng" class="form-control required-field" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center" id="user-profile-edit-button">
                                        <button type="submit" class="btn btn-primary btn-block">UPGRADE STATUS BUSINESS</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection

@section('js')
<script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/vendors/leaflet/leaflet.markercluster.js') }}"></script>
<script src="{{ asset('assets/vendors/esri-leaflet/esri-leaflet.js') }}"></script>
<script src="{{ asset('assets/vendors/esri-leaflet/esri-leaflet-geocoder.js') }}"></script>

<script>
        var basemaps= {
            "Google Satelite":L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Esri World Dark":L.tileLayer('https://server.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>',
            }),
            "OSM":L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }),
            "Esri World Gray":L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>',
            maxZoom: 16
            }),
            "Google Street":L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Google Hybrid":L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Google Traffic":L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            min5oom: 2,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Google Terrain":L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "CYL" : L.tileLayer('https://dev.{s}.tile.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            })
        }


    var map = L.map('myMap', {
        center: [-7.320063,112.7292863],
        zoom: 15,
        preferCanvas:true,
        bounceAtZoomLimits:false,
        minZoom: 8,
                maxBounds:[
                [-9.319,110.868],
                [-5.713,116.103]
                ],
        zoomControl:false,
        layers: [
                basemaps["Google Street"]
        ],
    });


   //disable default scroll
    map.scrollWheelZoom.disable();

    $("#myMap").bind('mousewheel DOMMouseScroll', function (event) {
    event.stopPropagation();
        if (event.ctrlKey == true) {
                event.preventDefault();
            map.scrollWheelZoom.enable();
                $('#myMap').removeClass('map-scroll');
            setTimeout(function(){
                map.scrollWheelZoom.disable();
            }, 1000);
        } else {
            map.scrollWheelZoom.disable();
            $('#myMap').addClass('map-scroll');
        }
    });

    $(window).bind('mousewheel DOMMouseScroll', function (event) {
        $('#myMap').removeClass('map-scroll');
    })

    $(document).mousemove(function(e){
        $('#myMap').removeClass('map-scroll');
    });

    var searchControl = new L.esri.Controls.Geosearch().addTo(map);
    var results = new L.LayerGroup().addTo(map);
    searchControl.on('results', function(data){
        results.clearLayers();
        for (var i = data.results.length - 1; i >= 0; i--) {
                $("#lat").val(data.results[i].latlng.lat);
                $("#lng").val(data.results[i].latlng.lng);
                results.addLayer(L.marker(data.results[i].latlng));
        }
    });
    var marker = null;
    map.on("click", function(e){
            results.clearLayers();
            if (marker !== null) {
                map.removeLayer(marker);
            }
            marker = new L.Marker(e.latlng, {draggable:true});
            results.addLayer(marker);
            // results.addLayer(L.marker(e.latlng));
            $("#lat").val(e.latlng.lat);
            $("#lng").val(e.latlng.lng);
    });

    $(document).ready(function(){
        var latitude         = $('#lat').val();
        var longitude        = $('#lng').val();
        var nama_perusahaan  = $('#nama').val();
        var alamat           = $('#alamat').val();
        marker = new L.marker([latitude, longitude]).addTo(map).bindPopup("<b>" + nama_perusahaan + "<b><br>" + alamat);
        if(latitude != ""){
            map.flyTo(new L.LatLng(latitude, longitude), 13);
        }
    });
</script>

@endsection
