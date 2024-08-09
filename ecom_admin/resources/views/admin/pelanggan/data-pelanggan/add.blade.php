@extends('partial.app')
@section('title','Data Pelanggan')

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

<div class="section-body">
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-12">
            <div class="card">
                <div class="card-header">
                <h4>Data Pelanggan</h4>
                </div>
                <form autocomplete="off" id="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-primary" role="alert">
                                    Untuk pembuatan user baru password default adalah -> "customer"
                                </div>
                            </div>
                            <br>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <input type="text" hidden class="form-control" name="id" id="id" value="@if(isset($data)){{$data->id}}@endif">
                                    <input type="text" name="type" id="type" hidden @if(isset($data)) value="update"@endif>
                                    <input type="text" name="tipe_customer" id="tipe_customer" hidden value="@if(isset($data)){{$data->tipe_customer_id}}@endif">
                                    <label>Master Tipe Customer</label>
                                    <select class="form-control select2 required-field" name="tipe_customer_id" id="tipe_customer_id" onchange="change_tipe_customer()"></select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input type="text" class="form-control required-field" name="no_telepon" id="no_telepon" value="@if(isset($data)){{$data->no_telepon}}@endif" onkeypress="return hanyaAngka(event,false);">
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control required-field" name="nama" id="nama" value="@if(isset($data)){{$data->nama}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control required-field" name="email" id="email" value="@if(isset($data)){{$data->email}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="text" class="form-control required-field datepicker" name="tanggal_lahir" id="tanggal_lahir" value="@if(isset($data)){{$data->tanggal_lahir}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select type="text" class="form-control required-field selectric" name="agama" id="agama">
                                        <option @if(isset($data) && $data->agama == 'Islam') selected @endif value="Islam">Islam</option>
                                        <option @if(isset($data) && $data->agama == 'Protestan') selected @endif value="Protestan">Protestan</option>
                                        <option @if(isset($data) && $data->agama == 'Katolik') selected @endif value="Katolik">Katolik</option>
                                        <option @if(isset($data) && $data->agama == 'Hindu') selected @endif value="Hindu">Hindu</option>
                                        <option @if(isset($data) && $data->agama == 'Budha') selected @endif value="Budha">Budha</option>
                                        <option @if(isset($data) && $data->agama == 'Khonghucu') selected @endif value="Khonghucu">Khonghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control required-field" name="alamat" id="alamat" style="height: 80px;">@if(isset($data)){{$data->alamat}}@endif</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 place_b2b">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" name="npwp" id="npwp" value="@if(isset($data)){{$data->npwp}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 place_b2b">
                                <div class="form-group">
                                <label>Koordinat Lokasi</label>
                                <div id="myMap" style="width: 100%; height: 400px;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 place_b2b">
                                <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" name="lat" id="lat" class="form-control" value="@if(isset($data)){{$data->lat}}@endif" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 place_b2b">
                                <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" name="lng" id="lng" class="form-control" value="@if(isset($data)){{$data->lng}}@endif" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save m-1"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
      // maxBounds:[
      //    [-9.319,110.868],
      //    [-5.713,116.103]
      // ],
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
        get_data_tipe_customer();
        $('.place_b2b').hide();
        change_tipe_customer();
        var latitude         = $('#lat').val();
        var longitude        = $('#lng').val();
        var nama_perusahaan  = $('#nama').val();
        var alamat           = $('#alamat').val();
        marker = new L.marker([latitude, longitude]).addTo(map).bindPopup("<b>" + nama_perusahaan + "<b><br>" + alamat);
        if(latitude != ""){
            map.flyTo(new L.LatLng(latitude, longitude), 13);
        }
    });

    function change_tipe_customer(){
        let tipe_customer = $('#tipe_customer_id :selected').val();
        if(tipe_customer == '3'){
            $('.place_b2b').show();
        }else{
            $('.place_b2b').hide();
        }
    }

   function get_data_tipe_customer(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/TipeCustomer",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#tipe_customer_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].id != 1){
                            if(data[i].id == $('#tipe_customer').val()){
                                $("#tipe_customer_id").append(`<option value="${data[i].id}" selected>${data[i].customer}</option>`);
                            }else{
                                $("#tipe_customer_id").append(`<option value="${data[i].id}">${data[i].customer}</option>`);
                            }
                        }
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

   $('#form').submit(function(e){
      e.preventDefault();

      var form_id = $(this).attr("id");
      if(check_required(form_id) === false){
         swal("Oops! Mohon isi field yang kosong", { icon: 'warning', });
         return;
      }

      swal({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan menyimpan data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
      })
      .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url : "/admin/pelanggan/data-pelanggan/store-update",
                  type: "POST",
                  data: $('#form').serialize(),
                  dataType: "JSON",
                  success: function(response){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     if(response.status === 200){
                        swal(response.message, {  icon: 'success', });
                        setTimeout(function () {  window.location.href = "/admin/pelanggan/data-pelanggan" }, 500);
                     }else{
                        swal(response.message, {  icon: 'error', });
                     }
                  },
                  error: function (jqXHR, textStatus, errorThrown){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                  }
               });
            }
      });
   })
</script>
@endsection
