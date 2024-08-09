@extends('partial.app')
@section('title','Pembelian Produk')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Hutang</h4>
                    </div>
                    <div class="card-body" id="pembelian_hutang">
                       {{ $pembelian_hutang }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Lunas</h4>
                    </div>
                    <div class="card-body" id="pembelian_lunas">
                        {{ $pembelian_lunas }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           <div class="card">
              <div class="card-header">
                 <h4>Master Pembelian Produk</h4>
              </div>
              <form id="form_submit" action="/admin/apps/pembelian-produk/store-update" method="post">
                <input type="text" hidden name="id" id="id">
                <input type="text" hidden name="type" id="type">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <select name="master_supplier_id" id="master_supplier_id" class="form-control select2 required-field">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <input type="text" placeholder="No Dokumen" name="no_dokumen" id="no_dokumen" class="form-control required-field">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <input type="text" placeholder="Tanggal" name="tanggal" id="tanggal" class="form-control required-field datepicker">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <select name="is_cash" id="is_cash" class="form-control selectric required-field">
                                        <option value="1">Cash</option>
                                        <option value="0">Hutang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button hidden type="button" onclick="cancel_action()" id="button_cancel" class="btn btn-danger mr-2"><i class="fa fa-times mr-1"></i> Batalkan</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Pembelian Produk</h4>
               <div class="card-header-action">
                    <a href="/admin/apps/pembelian-produk/pembayaran"><button type="button" class="btn btn-danger"><i class="fa fa-plus mr-1"></i> Pelunasan Hutang</button></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">#</th>
                           <th scope="col" class="text-center">Supplier</th>
                           <th scope="col" class="text-center">No Dokumen</th>
                           <th scope="col" class="text-center">Tanggal</th>
                           <th scope="col" class="text-center">Total</th>
                           <th scope="col" class="text-center">Sisa Pembayaran</th>
                           <th scope="col" class="text-center">Tipe Pembayaran</th>
                           <th scope="col" class="text-center">Status</th>
                           <th scope="col" class="text-center">Action</th>
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

@section('js')
<script>

    $(document).ready(function(){
        get_data_master_supplier();
    });

    function get_data_master_supplier(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/MasterSupplier",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#master_supplier_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#master_supplier_id").append(`<option value="${data[i].id}">${data[i].nama}</option>`);
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

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/apps/pembelian-produk/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4,5,6,7,8] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_supplier.nama' },
            { data: 'no_dokumen' },
            { data: 'tanggal' },
            { data: 'total_pembelian_detail', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'sisa_pembayaran', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'is_cash_desc' },
            { data: 'status_desc' },
            { data: 'status' },
        ],
        rowCallback : function(row, data){
            let color = ['warning', 'danger' ,'success'];
            $('td:eq(7)', row).html(`<span class="badge badge-${color[data.status]}">${data.status_desc}</span>`);

            $('td:eq(8)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="action_edit('${data.id}','${data.master_supplier_id}', '${data.no_dokumen}', '${data.tanggal}', '${data.is_cash}')"><i class="fa fa-edit"></i> Edit</button>
                <a href="/admin/apps/pembelian-produk/detail/${data.uuid}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-edit"></i> Detail</button></a>
            `);
        }
    });

    function action_edit(id, master_supplier_id,no_dokumen,tanggal,is_cash){
        $('#id').val(id);
        $('#type').val('update');
        $('#master_supplier_id').select2("trigger", "select", { data: { id: master_supplier_id } });
        $('#no_dokumen').val(no_dokumen);
        $('#tanggal').val(tanggal);
        $('#is_cash').val(is_cash).change().selectric('refresh');
        $('#button_cancel').attr('hidden',false);
    }

    function cancel_action(){
        $("#form_submit")[0].reset();
        $('#button_cancel').attr('hidden', true);
    }

</script>
@endsection
