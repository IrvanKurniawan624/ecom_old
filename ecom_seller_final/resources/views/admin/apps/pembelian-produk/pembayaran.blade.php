@extends('partial.app')
@section('title','Pembelian Produk - Pembayaran')

@section('css')
    <style>
        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width:1200px;
            }
        }
    </style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           <div class="card">
              <div class="card-header">
                 <h4>Master Pembayaran</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-warning mr-2" onclick="addForm()"><i class="fa fa-plus mr-1"></i> Tambah</button></a>
                    </div>
              </div>
              <form id="form_submit_custom" method="post">
                    <div class="card-body" id="place_append">
                        <div class="row form-row" data-id="0">
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="no_dokumen0" name="no_dokumen" readonly>
                                    <input type="text" class="form-control" id="pembelian_produk_id0" name="pembelian_produk_id[]" hidden readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tanggal0" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="total_pembelian0" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sisa_pembayaran0" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control calculate required-field" id="pembayaran" name="pembayaran[]" onkeyup="return onkeyupRupiah(this.id)">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-1">
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteForm(0)" style="position: absolute; top: 5px"><i class="fa fa-trash"> </i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <b class="float-left" id="total_pembayaran">Total Pembayaran : Rp. 0</b>
                        <button type="button" onclick="click_bayar_hutang()" class="btn btn-success"><i class="fa fa-save"></i> Bayar Hutang</button></a>
                    </div>
                </form>
            </div>
        </div>
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pembayaran Produk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-striped" id="tb" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Tanggal Pembayaran</th>
                                <th scope="col" class="text-center">No Dokumen</th>
                                <th scope="col" class="text-center">Nama Supplier</th>
                                <th scope="col" class="text-center">Pembayaran</th>
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
    <div class="modal fade" role="dialog" id="modal_pembelian_produk" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <input type="text" id="count" hidden>
                        <table class="table table-striped" id="tb_pembelian_produk" width="100%">
                            <thead>
                                <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col" class="text-center">No Dokumen</th>
                                <th scope="col" class="text-center">Supplier</th>
                                <th scope="col" class="text-center">Total Pembelian</th>
                                <th scope="col" class="text-center">Sisa Pembayaran</th>
                                <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js')
<script>

    $(document).ready(function(){
        table_pembelian_produk();
    });

    $('#no_dokumen0').click(function(){
        $('#modal_pembelian_produk').modal('show');
        $('#count').val(0);
    });

    function table_pembelian_produk(){
        var tb = $('#tb_pembelian_produk').DataTable({
            processing: true,
            serverSide: false,
            destroy: true,
            ajax: {
                url: '/master/datatables-pembelian-produk-hutang-belum-lunas',
                type: 'GET'
            },
            columnDefs: [
                { className: 'text-center', targets: [0,1,2,3,4,5,6] },
            ],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'tanggal'},
                { data: 'no_dokumen'},
                { data: 'master_supplier.nama'},
                { data: 'total_pembelian', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )},
                { data: 'sisa_pembayaran', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )},
                { data: 'sisa_pembayaran'},
            ],
            rowCallback : function(row, data){

                $('td:eq(6)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="terpilih_pembelian_produk(${data.id},'${data.no_dokumen}','${data.tanggal}','${data.total_pembelian}','${data.sisa_pembayaran}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function terpilih_pembelian_produk(id, no_dokumen, tanggal, total_pembelian, total_pembayaran){
        console.log($('#count').val());
        $('#modal_pembelian_produk').modal('hide');
        $('#pembelian_produk_id' + $('#count').val()).val(id);
        $('#no_dokumen' + $('#count').val()).val(no_dokumen);
        $('#tanggal' + $('#count').val()).val(tanggal);
        $('#total_pembelian' + $('#count').val()).val(fungsiRupiah(total_pembelian));
        $('#sisa_pembayaran' + $('#count').val()).val(fungsiRupiah(total_pembayaran));
    }

     var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/apps/pembelian-produk/pembayaran-datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,4] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'created_at' },
            { data: 'pembelian_produk.no_dokumen' },
            { data: 'pembelian_produk.master_supplier.nama' },
            { data: 'pembayaran', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
        ],
    });

    let i = 1;
    function addForm(){

         i++;

        $('#place_append').append(`
            <div class="row form-row" data-id="${i}">
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_dokumen${i}" name="no_dokumen" readonly>
                        <input type="text" class="form-control" id="pembelian_produk_id${i}" name="pembelian_produk_id[]" hidden readonly>
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal${i}" readonly>
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="total_pembelian${i}" disabled>
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sisa_pembayaran${i}" disabled>
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <input type="text" class="form-control calculate required-field" id="pembayaran${i}" name="pembayaran[]" onkeyup="return onkeyupRupiah(this.id)">
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteForm(${i})" style="position: absolute; top: 5px"><i class="fa fa-trash"> </i></button>
                </div>
            </div>
        `);
        $('.selectric').selectric();

        $('#no_dokumen' + i).click(function(){
             $('#count').val(i);
            $('#modal_pembelian_produk').modal('show');
        });
    }

    function deleteForm(i){
        if($('.form-row').length > 1){
            console.log('tetet')
            $('.form-row[data-id="'+i+'"]').remove();
        }
    }

    function click_bayar_hutang(){

        var form_id = 'form_submit_custom';
        if(check_required(form_id) === false){
            swal("Oops! Mohon isi field yang kosong", { icon: 'warning', });
            return;
        }

        swal({
            title: 'Yakin?',
            text: 'Data yang sudah diinputkan tidak dapat dirubah lagi?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
                if (willDelete) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url:  '/admin/apps/pembelian-produk/pembayaran-store',
                    type: 'POST',
                    data: $('#form_submit_custom').serialize(),
                    success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.status == 200){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            $("#form_submit_custom")[0].reset();
                            $('#place_append').html('');
                            addForm();
                            reset_all_select();
                            tb.ajax.reload(null, false);
                        }
                        else if(response.status == 201){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            window.location.href = response.link;
                        }
                        else if(response.status == 203){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            tb.ajax.reload(null, false);
                        }
                        else if(response.status == 300){
                            swal(response.message, { icon: 'error', });
                        }
                    },error: function (jqXHR, textStatus, errorThrown){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                    }
                });
            }
        });
    };

</script>

@endsection
