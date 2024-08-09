@extends('partial.app')
@section('title','Master Poin')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                <h4>Data Master Poin</h4>
                <div class="card-header-action">
                        <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Poin</button>
                    </div>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb" width="100%">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Title</th>
                            <th scope="col" class="text-center">Tanggal</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Poin</th>
                            <th scope="col" class="text-center" style="width: 25%">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Master Pendapatan Belanja</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Akumulasi Pembelian</label>
                                <input type="text" class="form-control" name="akumulasi_pembelian" id="akumulasi_pembelian" value="{{ $bonus_pembelian->value1 }}" onkeypress="return onkeyupRupiah(this.id)">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="text" class="form-control" name="pendapatan_belanja_poin" id="pendapatan_belanja_poin" value="{{ $bonus_pembelian->value2 }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button class="btn btn-success" onclick="click_pendapatan_belanja()">Save Pendapatan Belanja</button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Minimal Use Poin</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Minimal Pembelian</label>
                                <input type="text" class="form-control" name="minimal_pembelian" id="minimal_pembelian" value="{{ $minimal_use_poin->value1 }}" onkeypress="return onkeyupRupiah(this.id)">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Presentase Penggunaan Poin (%) </label>
                                <input type="text" class="form-control" name="presentase" id="presentase" value="{{ $minimal_use_poin->value2 }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button class="btn btn-success" onclick="click_minimal_use()">Save Minimal Pembelian</button>
                </div>
            </div>
        </div>

   </div>
</div>
@endsection


@section('modal')
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title"></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_submit" action="/admin/data-master/master-poin/store-update" method="POST" autocomplete="off">
            <input type="text" name="id" id="id" readonly hidden>
            <input type="text" name="type" id="type" readonly hidden>
             <div class="modal-body">
                <div class="row">
                     <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control datepicker" name="tanggal" id="tanggal">
                        </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="text" class="form-control" name="poin" id="poin" onkeypress="return onkeyupRupiah(this.id)">
                        </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" id="status" name="status" value="1" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">active</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" id="status" name="status" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">non-active</span>
                                </label>
                            </div>
                        </div>
                     </div>
                </div>
             </div>
             <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
             </div>
          </form>
       </div>
    </div>
</div>
@endsection

@section('js')
<script>

    $('document').ready(function(){
        $('#minimal_pembelian').val(fungsiRupiah($('#minimal_pembelian').val()));
        $('#akumulasi_pembelian').val(fungsiRupiah($('#akumulasi_pembelian').val()));
    })

    function click_pendapatan_belanja(){
        swal({
            title: 'Apakah anda yakin?',
            text: 'Apakah anda yakin akan merubah global variable pendapatan belanja ?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
      .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url : '/admin/data-master/master-poin/store-pendapatan-belanja',
                  type: "POST",
                  data: {
                    'akumulasi_pembelian': $('#akumulasi_pembelian').val(),
                    'pendapatan_belanja_poin': $('#pendapatan_belanja_poin').val(),
                  },
                  dataType: "JSON",
                  success: function(response){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

                     if(response.status === 200){
                        swal(response.message, {  icon: 'success', });
                     }else{
                        swal(response.message, {  icon: 'error', });
                     }

                  },error: function (jqXHR, textStatus, errorThrown){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                  }
               });
            }
        });
    }

    function click_minimal_use(){
        swal({
            title: 'Apakah anda yakin?',
            text: 'Apakah anda yakin akan merubah global variable minimal use poin ?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
      .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url : '/admin/data-master/master-poin/store-minimal-use-poin',
                  type: "POST",
                  data: {
                    'minimal_pembelian': $('#minimal_pembelian').val(),
                    'presentase': $('#presentase').val(),
                  },
                  dataType: "JSON",
                  success: function(response){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

                     if(response.status === 200){
                        swal(response.message, {  icon: 'success', });
                     }else{
                        swal(response.message, {  icon: 'error', });
                     }

                  },error: function (jqXHR, textStatus, errorThrown){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                  }
               });
            }
        });
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/admin/data-master/master-poin/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,2,3,4,5] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'title' },
         { data: 'tanggal_desc' },
         { data: 'status_desc' },
         { data: 'poin', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'poin', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
      ],
      rowCallback : function(row, data){

        let color = ['danger', 'success'];
        $('td:eq(3)', row).html(`<span class="badge badge-${color[data.status]}">${data.status_desc}</span>`);

        var url_edit   = "/admin/data-master/master-poin/detail/" + data.id;
        var url_delete = "/admin/data-master/master-poin/delete/" + data.id;

        if(data.tanggal == null){
            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            `);    
        }else{
            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.nama}')"><i class="fa fa-trash"> </i> Hapus</button>
            `);
        }

      }
   });

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master Poin');
        $('#place_append').html('');
        $("#form_submit")[0].reset();
    }

    function edit(url){
        edit_action(url, 'Edit Master Poin');
        $("#type").val('update');
    }
</script>
@endsection
