@extends('partial.app')
@section('title','Dashboard')
@section('content')

<div class="section-body">

    @if($count_asal_pengiriman == 0)
    <div class="alert alert-danger">
        <b> Peringatan..! Anda Belum Mengatur Asal Pengiriman</b> . segera buka <a href="/admin/apps/jasa-pengiriman"> <b>MENU Pengiriman</b> </a>
    </div>
    @endif
    <div class="alert alert-info">
        HORRAY! Terdapat <b>{{ $count_new_transaksi }} TRANSAKSI butuh approval</b> . segera buka <a href="/admin/apps/transaksi"> <b>MENU TRANSAKSI</b> </a>
    </div>

   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-body ">
              <div class="text-center mb-2 mt-2">
                <h3 class="text-warning">Welcome Back, {{ auth()->user()->nama }}!</h3>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-stats">
            <div class="card-stats-title">Statistik Pesanan -
                <div class="dropdown d-inline">
                <a class="font-weight-600 dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" id="tipe_statistik">Bulanan</a>
                <ul class="dropdown-menu dropdown-menu-sm">
                    <li class="dropdown-title">Tipe Laporan</li>
                    <li><a href="javascript:void(0)" class="dropdown-item active" id="bulanan" onclick="click_statistik_pesanan(this.id)">Bulanan</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item" id="tahunan" onclick="click_statistik_pesanan(this.id)">Tahunan</a></li>
                </ul>
                </div>
            </div>
            <div class="card-stats-items">
                <div class="card-stats-item">
                    <div class="card-stats-item-count" id="place_orderan_baru">0</div>
                    <div class="card-stats-item-label">Orderan Baru</div>
                </div>
                <div class="card-stats-item">
                    <div class="card-stats-item-count" id="place_dikemas">0</div>
                    <div class="card-stats-item-label">Dikemas</div>
                </div>
                <div class="card-stats-item">
                    <div class="card-stats-item-count" id="place_dikirim">0</div>
                    <div class="card-stats-item-label">Dikirim</div>
                </div>
                <div class="card-stats-item">
                    <div class="card-stats-item-count" id="place_selesai">0</div>
                    <div class="card-stats-item-label">Selesai</div>
                </div>
            </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Pesanan</h4>
                </div>
                <div class="card-body" id="place_total_pesanan">
                    0
                </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-chart">
            <canvas id="balance-chart" height="80"></canvas>
            </div>
            <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
            <div class="card-header">
                <h4>Keuntungan Hari Ini</h4>
            </div>
            <div class="card-body">
                {{ "Rp " . number_format($keuntungan_hari_ini,0,',','.') }}
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-chart">
            <canvas id="sales-chart" height="80"></canvas>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="far fa-money-bill-alt"></i>
            </div>
            <div class="card-wrap">
            <div class="card-header">
                <h4>Keuntungan Bulan Ini</h4>
            </div>
            <div class="card-body">
                {{ "Rp " . number_format($keuntungan_bulan_ini,0,',','.') }}
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pelanggan Baru Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        {{ $pelanggan_baru_bulan_ini }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pelanggan</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_pelanggan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Produk Terjual</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_produk_terjual }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Pemasukan dan Keuntungan bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM') }}</h4>
                    </div>
                    <div class="card-body">
                    <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Invoices</h4>
                    <div class="card-header-action">
                        <a href="/admin/apps/transaksi/" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_semua" width="100%">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">No Invoice</th>
                                        <th scope="col" class="text-center">Tanggal Transaksi</th>
                                        <th scope="col" class="text-center">Tipe Customer</th>
                                        <th scope="col" class="text-center">User</th>
                                        <th scope="col" class="text-center">Pengiriman</th>
                                        <th scope="col" class="text-center">Biaya Pengiriman</th>
                                        <th scope="col" class="text-center">Total Harga</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4>Peringatan Stock Produk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_stock_produk" width="100%">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Nama Produk</th>
                                <th scope="col" class="text-center">Sisa Stock</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
             <div class="card">
                <div class="card-header">
                    <h4>Top 5 Produk Terlaris Bulan Ini</h4>
                </div>
                <div class="card-body">
                    @if (count($top_produk_bulan_ini))
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($top_produk_bulan_ini as $item)
                                <li class="media">
                                    @if (isset($item->master_produk->url_image[0]))
                                        <img class="mr-3 rounded" width="55" src="{{$item->master_produk->url_image[0]}}" alt="product">
                                    @else
                                        <img class="mr-3 rounded" width="55" src="{{'https://seller.SIMANHURAonline.com/assets/img/no-image.png'}}" alt="product">
                                    @endif
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{ $item->quantity }} Sales</div>
                                        </div>
                                        <div class="media-title">{{ $item->master_produk->master_kategori->master_package->package ?? '' }} - {{ $item->master_produk->master_kategori->kategori ?? '' }}</div>
                                        <div class="mt-1">
                                            <h6>{{ $item->master_produk->nama_produk_desc ?? '' }}</h6>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div style="border:2px dashed black;padding: 25px;text-align: center;">
                            Tidak ada data
                        </div>
                    @endif

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Top 5 Produk Terlaris Tahun Ini</h4>
                </div>
                <div class="card-body">
                    @if (count($top_produk_tahun_ini))
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($top_produk_tahun_ini as $item)
                                <li class="media">
                                    @if (isset($item->master_produk->url_image[0]))
                                        <img class="mr-3 rounded" width="55" src="{{$item->master_produk->url_image[0]}}" alt="product">
                                    @else
                                        <img class="mr-3 rounded" width="55" src="{{asset('assets/img/no-image.png')}}" alt="product">
                                    @endif
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{ $item->quantity }} Sales</div>
                                        </div>
                                        <div class="media-title">{{ $item->master_produk->master_kategori->master_package->package ?? '' }} - {{ $item->master_produk->master_kategori->kategori ?? '' }}</div>
                                        <div class="mt-1">
                                            <h6>{{ $item->master_produk->nama_produk_desc ?? '' }}</h6>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div style="border:2px dashed black;padding: 25px;text-align: center;">
                            Tidak ada data
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
<input type="text" id="monthyear" value="{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}" hidden>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_dikemas" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title">Resi Pengiriman</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_dikemas">
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Jasa Pengiriman Default</label>
                            <input type="text" class="form-control" id="jasa_pengiriman_default" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Jasa Pengiriman</label>
                            <select name="jasa_pengiriman_code" id="jasa_pengiriman_code" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Input Resi Pengiriman</label>
                            <input type="text" class="form-control" required name="id" id="id" hidden>
                            <input type="text" class="form-control" required name="resi_pengiriman" id="resi_pengiriman">
                            <small>Pastikan input resi pengiriman yang benar</small>
                        </div>
                    </div>
                </div>
             </div>
             <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="approval_dikemas()" class="btn btn-warning">Simpan</button>
             </div>
          </form>
       </div>
    </div>
 </div>
@endsection

@section('js')
      <!-- JS Libraies -->
    <script src="{{asset('assets/modules/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/modules/chart.min.js')}}"></script>
    <script src="{{asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

    <!-- Page Specific JS File -->
    <script src="{{asset('assets/js/page/index.js')}}"></script>

    <script>
        $(document).ready(function(){
            get_data_jasa_pengiriman();
            load_chart();
        })

        function get_data_jasa_pengiriman(){
            $("#modal_loading").modal('show');
            $.ajax({
                url : "/master/get-data-all/JasaPengiriman",
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status === 200){
                        var data = response.data;
                        $("#jasa_pengiriman_code").empty();
                        for (var i = 0; i < data.length; i++) {
                            $("#jasa_pengiriman_code").append(`<option value="${data[i].kode}">${data[i].nama}</option>`);
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

        function load_chart(){
            $.ajax({
                url: '/dashboard/chart',
                type: "GET",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    var ctx = document.getElementById("myChart");
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.label,
                        datasets: [
                            {
                                label: 'Penjualan Harian',
                                data: response.penjualan_harian,
                                backgroundColor: "rgb(113,106,202)",
                                pointBackgroundColor: '#ffffff',
                                pointRadius: 4
                            },
                            // {
                            //     label: 'Keuntungan Harian',
                            //     data: response.keuntungan_harian,
                            //     backgroundColor: "rgb(52,191,163)",
                            //     pointBackgroundColor: '#ffffff',
                            //     pointRadius: 4
                            // }

                        ]
                    },
                    options: {
                        legend: {
                            display: true
                        },
                        tooltips: {
                            mode: 'index',
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label;
                                    var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ':' + '  Rp.' + fungsiRupiah(val);
                                }
                            }
                        }
                    }
                    });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        }

        var tb_semua = $('#tb_semua').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'semua'
                },
            },
            columnDefs: [
                { className: 'text-center', targets: [0,1,2,3,6,7,8,9] },
            ],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'no_invoice' },
                { data: 'created_at_desc' },
                { data: 'user.tipe_customer.customer' },
                { data: 'user.nama' },
                { data: 'jasa_pengiriman' },
                { data: 'harga_pengiriman',  render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'total_harga',  render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'status_desc' },
                { data: 'total_harga' },
            ],
            rowCallback : function(row, data){

                $('td:eq(1)', row).html(`<a href="/admin/apps/transaksi/${data.uuid}" target="_blank">${data.no_invoice}</a>`);
                $('td:eq(3)', row).html(`<span class="badge badge-primary">${data.user.tipe_customer.customer}</span>`);
                $('td:eq(8)', row).html(`<span class="badge badge-${data.color}">${data.status_desc}</span>`);

                var url_approval   = "/admin/apps/transaksi/approval/" + data.id + "/" + data.status;
                var url_invoice   = "/admin/apps/transaksi/" + data.uuid;

                if(data.status_desc == 'Konfirmasi Admin'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check" onclick="approval(${data.id}, '2')"></i></button>
                        <a href="${url_invoice}" target="_blank"><button class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button></a>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-times" onclick="approval(${data.id}, '5')"> </i></button>
                    `);
                }else if(data.status_desc == 'Dikemas'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-warning btn-sm m-2" onclick="cetak_resi_pengiriman(${data.id})"><i class="fas fa-file-pdf mr-1"></i></i>Cetak Resi</button>
                        <button class="btn btn-success btn-sm" onclick="action_dikemas(${data.id},'${data.jasa_pengiriman}')"><i class="fa fa-check mr-1"></i>Sudah Dikemas</button>
                    `);
                }else if(data.status_desc == 'Dikirim'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-danger btn-sm" onclick="click_edit_pengiriman(${data.id}, '${data.jasa_pengiriman}', '${data.jasa_pengiriman_code}','${data.resi_pengiriman}')"><i class="fa fa-edit"></i></button>
                        <a href="/admin/apps/transaksi/tracking-order/${data.uuid}" target="_blank"><button class="btn btn-warning btn-sm m-2"><i class="fas fa-truck"></i></button></a>
                        <button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Sudah Dikirim</button>
                    `);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }

            }
        });
        function cetak_resi_pengiriman(id){
            $("#modal_loading").modal('show');
            $.ajax({
                url : "/admin/apps/transaksi/cetak-resi-pengiriman/" + id,
                type: "GET",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status == 200){
                        console.log("TIPE PDF")
                        var data = b64toBlob(response.data.base64);

                        //UNTUK OPEN NEW TAB
                        var file = new Blob([data], {type: 'application/pdf'});
                        var fileURL = URL.createObjectURL(file);
                        window.open(fileURL);
                    }else if(response.status == 300){
                        swal(response.message, { icon: 'error', });
                    }
                },
                error: function(blob){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT", {  icon: 'error', });
                }
            });
        }


        function action_dikemas(id, jasa_pengiriman){
            $('#modal_dikemas').modal('show');
            $('#id').val(id);
            $('#jasa_pengiriman_default').val(jasa_pengiriman);
            $('#resi_pengiriman').val('');
        }

        function approval_dikemas(){
            $('#modal_dikemas').modal('hide');
            approval($('#id').val(), '3');
        }

        function approval(id, $status){
            if($status == 5){
                $text = 'Apakah anda yakin menolak transaksi ini?'
            }else{
                $text = 'Apakah anda yakin menerima transaksi ini?'
            }

            let resi_pengiriman = null;
            let jasa_pengiriman_code = null;
            if($status == 3){
                resi_pengiriman = $('#resi_pengiriman').val();
                jasa_pengiriman_code = $('#jasa_pengiriman_code').val();
            }

            swal({
                    title: 'Yakin?',
                    text: $text,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
            })
            .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/admin/apps/transaksi/approval/'+ id + '/' + $status + '/' + resi_pengiriman + '/' + jasa_pengiriman_code,
                            type: "GET",
                            dataType: 'JSON',
                            success: function( response, textStatus, jQxhr ){
                                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                                if(response.status == 200){
                                    swal(response.message, { icon: 'success', });

                                    $('#place_count_semua').html(response.data['count_semua']);
                                    $('#place_count_belum_bayar').html(response.data['count_belum_bayar']);
                                    $('#place_count_konfirmasi_admin').html(response.data['count_konfirmasi_admin']);
                                    $('#place_count_dikemas').html(response.data['count_dikemas']);
                                    $('#place_count_dikirim').html(response.data['count_dikirim']);
                                    $('#place_count_selesai').html(response.data['count_selesai']);
                                    $('#place_count_cancel').html(response.data['count_cancel']);

                                    tb_semua.ajax.reload(null, false);
                                    tb_belum_bayar.ajax.reload(null, false);
                                    tb_konfirmasi_admin.ajax.reload(null, false);
                                    tb_dikemas.ajax.reload(null, false);
                                    tb_dikirim.ajax.reload(null, false);
                                    tb_selesai.ajax.reload(null, false);
                                    tb_cancel.ajax.reload(null, false);
                                }else{
                                    iziToast.error({
                                        title: 'Error!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                }
                            },
                            error: function( jqXhr, textStatus, errorThrown ){
                                console.log( errorThrown );
                                console.warn(jqXhr.responseText);
                            },
                        });

                    }
            });
        }

        var tb_stock_produk = $('#tb_stock_produk').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/dashboard/datatables-safety-stock',
                type: 'GET',
            },
            columnDefs: [
                { className: 'text-center', targets: [0,2] },
            ],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'nama_produk_desc' },
                { data: 'safety_stock' },
            ],
            rowCallback : function(row, data){
                $('td:eq(1)', row).html(`<a href="/admin/produk/produk/detail/${data.id}" target="_blank">${data.nama_produk_desc}</a>`);
                $('td:eq(2)', row).html(`${data.safety_stock} ${data.satuan}`);
            }
        });

        click_statistik_pesanan('bulanan');

        function click_statistik_pesanan(id){
            $('.dropdown-item').removeClass('active');
            $('#' + id).addClass('active');

            $('#tipe_statistik').html(id);

            $.ajax({
                url: '/master/data-statistik-pesanan-dashboard/' + id,
                type: "GET",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('#place_orderan_baru').html(response.konfirmasi_admin);
                    $('#place_dikemas').html(response.dikemas);
                    $('#place_dikirim').html(response.dikirim);
                    $('#place_selesai').html(response.selesai);
                    $('#place_total_pesanan').html(response.total_pesanan);
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        }
    </script>
@endsection

