@extends('partial.app')
@section('title','Transaksi Belanja')
@section('content')
     <div class="card">
        <div class="card-body">
        <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item mx-2">
                <a class="nav-link active position-relative" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px" id="place_count_semua">{{ $count_semua }}</span>
                    Semua
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="menungguPembayaran-tab" data-toggle="tab" href="#menungguPembayaran" role="tab" aria-controls="menungguPembayaran" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_belum_bayar">{{ $count_belum_bayar }}</span>
                    Menunggu Pembayaran
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="konfirmasiAdmin-tab" data-toggle="tab" href="#konfirmasiAdmin" role="tab" aria-controls="konfirmasiAdmin" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_konfirmasi_admin">{{ $count_konfirmasi_admin }}</span>
                    Konfirmasi Admin
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="dikemas-tab" data-toggle="tab" href="#dikemas" role="tab" aria-controls="dikemas" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_dikemas">{{ $count_dikemas }}</span>
                    Sedang Dikemas
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="dikirim-tab" data-toggle="tab" href="#dikirim" role="tab" aria-controls="dikirim" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_dikirim">{{ $count_dikirim }}</span>
                    Sedang Dikirim
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_selesai">{{ $count_selesai }}</span>
                    Pembelian Selesai
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link position-relative" id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="top: -10px; right: -17px;" id="place_count_cancel">{{ $count_cancel }}</span>
                    Pembelian Cancel
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Semua Transaksi</h4>
                    </div>
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
            <div class="tab-pane fade" id="menungguPembayaran" role="tabpanel" aria-labelledby="menungguPembayaran-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Menunggu Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_belum_bayar" width="100%">
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
            <div class="tab-pane fade" id="konfirmasiAdmin" role="tabpanel" aria-labelledby="konfirmasiAdmin-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Konfirmasi Admin</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_konfirmasi_admin" width="100%">
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
            <div class="tab-pane fade" id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Dikemas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_dikemas" width="100%">
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
            <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Dikirim</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_dikirim" width="100%">
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
            <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Pembelian Selesai</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_selesai" width="100%">
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
            <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                <div class="card">
                    <div class="card-header">
                        <h4>Pembelian Cancel</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_cancel" width="100%">
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
            <input type="text" name="type" id="type" hidden>
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
    <script>

    $(document).ready(function(){
        get_data_jasa_pengiriman();
    });

    function get_data_jasa_pengiriman(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all-active/JasaPengiriman",
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
            $('#type').val('new');
        }

        function click_edit_pengiriman(id, jasa_pengiriman_default, jasa_pengiriman, resi_pengiriman){
            $('#modal_dikemas').modal('show');
            $('#id').val(id);
            $('#jasa_pengiriman_default').val(jasa_pengiriman_default);
            $('#jasa_pengiriman_code').select2("trigger", "select", { data: { id: jasa_pengiriman } });
            $('#resi_pengiriman').val(resi_pengiriman);
            $('#type').val('edit');
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
            let type = null;
            if($status == 3){
                resi_pengiriman = $('#resi_pengiriman').val();
                jasa_pengiriman_code = $('#jasa_pengiriman_code').val();
                type = $('#type').val();
            }

            if(type == 'edit'){
                $text = 'Apakah anda yakin melakukan edit pengiriman ini?'
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
                            url: '/admin/apps/transaksi/approval/'+ id + '/' + $status + '/' + resi_pengiriman + '/' + jasa_pengiriman_code + '/' + type,
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

        var tb_belum_bayar = $('#tb_belum_bayar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'belum_bayar'
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
                    $('td:eq(9)', row).html(`<button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Selesai</button>`);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }

            }
        });

        var tb_konfirmasi_admin = $('#tb_konfirmasi_admin').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'konfirmasi_admin'
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
                    $('td:eq(9)', row).html(`<button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Selesai</button>`);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }
            }
        });

        var tb_dikemas = $('#tb_dikemas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'dikemas'
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

                if(data.status_desc == 'Konfirmasi Admin'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check" onclick="approval(${data.id}, '2')"></i></button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-times" onclick="approval(${data.id}, '5')"> </i></button>
                    `);
                }else if(data.status_desc == 'Dikemas'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-warning btn-sm m-2" onclick="cetak_resi_pengiriman(${data.id})"><i class="fas fa-file-pdf mr-1"></i></i>Cetak Resi</button>
                        <button class="btn btn-success btn-sm" onclick="action_dikemas(${data.id},'${data.jasa_pengiriman}')"><i class="fa fa-check mr-1"></i>Sudah Dikemas</button>
                    `);
                }else if(data.status_desc == 'Dikirim'){
                    $('td:eq(9)', row).html(`<button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Sudah Dikirim</button>`);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }

            }
        });

        var tb_dikirim = $('#tb_dikirim').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'dikirim'
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

                if(data.status_desc == 'Konfirmasi Admin'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check" onclick="approval(${data.id}, '2')"></i></button>
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
                        <a href="/admin/apps/transaksi/tracking-order/${data.uuid}" target="_blank"><button class="btn btn-warning btn-sm m-1"><i class="fas fa-truck"></i></button></a>
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

        var tb_selesai = $('#tb_selesai').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'selesai'
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

                if(data.status_desc == 'Konfirmasi Admin'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check" onclick="approval(${data.id}, '2')"></i></button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-times" onclick="approval(${data.id}, '5')"> </i></button>
                    `);
                }else if(data.status_desc == 'Dikemas'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-warning btn-sm m-2" onclick="cetak_resi_pengiriman(${data.id})"><i class="fas fa-file-pdf mr-1"></i></i>Cetak Resi</button>
                        <button class="btn btn-success btn-sm" onclick="action_dikemas(${data.id},'${data.jasa_pengiriman}')"><i class="fa fa-check mr-1"></i>Sudah Dikemas</button>
                    `);
                }else if(data.status_desc == 'Dikirim'){
                    $('td:eq(9)', row).html(`<button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Sudah Dikirim</button>`);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }
            }
        });

        var tb_cancel = $('#tb_cancel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/apps/transaksi/datatables',
                type: 'GET',
                data: {
                    'status': 'cancel'
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

                if(data.status_desc == 'Konfirmasi Admin'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check" onclick="approval(${data.id}, '2')"></i></button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-times" onclick="approval(${data.id}, '5')"> </i></button>
                    `);
                }else if(data.status_desc == 'Dikemas'){
                    $('td:eq(9)', row).html(`
                        <button class="btn btn-warning btn-sm m-2" onclick="cetak_resi_pengiriman(${data.id})"><i class="fas fa-file-pdf mr-1"></i></i>Cetak Resi</button>
                        <button class="btn btn-success btn-sm" onclick="action_dikemas(${data.id},'${data.jasa_pengiriman}')"><i class="fa fa-check mr-1"></i>Sudah Dikemas</button>
                    `);
                }else if(data.status_desc == 'Dikirim'){
                    $('td:eq(9)', row).html(`<button class="btn btn-success btn-sm" onclick="approval(${data.id}, '4')"><i class="fa fa-check mr-1"></i>Sudah Dikirim</button>`);
                }else{
                    $('td:eq(9)', row).html(`
                        <div style="border:2px dashed black;padding: 5px;text-align: center;">
                            No Action
                        </div>
                    `);
                }
            }
        });
    </script>
@endsection
