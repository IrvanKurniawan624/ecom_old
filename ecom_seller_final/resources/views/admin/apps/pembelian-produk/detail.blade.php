@extends('partial.app')
@section('title','Pembelian Produk')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <input type="text" id="pembelian_produk_id" hidden value="{{ $data->id }}">
              <div class="card-header">
                 <h4>Main</h4>
              </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Nama Supplier</label>
                                <input type="text" name="master_supplier_id" id="master_supplier_id" class="form-control required-field" value="{{ $data->master_supplier->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>No Dokumen</label>
                                <input type="text" placeholder="No Dokumen" name="no_dokumen" id="no_dokumen" class="form-control required-field" value="{{ $data->no_dokumen }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" placeholder="Tanggal" name="tanggal" id="tanggal" class="form-control required-field" value="{{ $data->tanggal }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tipe Pembayaran</label>
                                <input type="text" placeholder="Tanggal" name="is_cash" id="is_cash" class="form-control required-field" value="{{ $data->is_cash_desc }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                   <h4>Detail</h4>
                </div>
                <form id="form_submit_self" action="/admin/apps/pembelian-produk/detail-store-update" method="post">
                    <input type="text" name="id" id="id" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control required-field" onclick="click_master_produk()" name="sku" id="sku" readonly>
                                    <input type="text" class="form-control required-field" name="master_produk_id" id="master_produk_id" readonly hidden>
                                </div>
                            </div>
                          <div class="col-12 col-md-5 col-lg-5">
                              <div class="form-group">
                                  <label>Nama Produk</label>
                                  <input type="text" class="form-control required-field" name="nama_produk" id="nama_produk" readonly>
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Publish</label>
                                  <select name="is_publish" id="is_publish" class="form-control selectric required-field">
                                      <option value="1">Publish</option>
                                      <option value="0">Not Publish</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Kategori</label>
                                  <input type="text" class="form-control required-field" name="kategori" id="kategori" readonly>
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Subkategori</label>
                                  <input type="text" class="form-control required-field" name="subkategori" id="subkategori" readonly>
                              </div>
                          </div>
                          <div class="col-12 col-md-2 col-lg-2">
                              <div class="form-group">
                                  <label>Berat</label>
                                  <div class="input-group">
                                      <input type="text" class="form-control required-field" name="berat" id="berat" readonly>
                                      <div class="input-group-append">
                                          <div class="input-group-text">
                                              gram
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Diskon</label>
                                  <div class="input-group">
                                      <input type="number" min="0" max="100" name="diskon" id="diskon" class="form-control" value="0">
                                      <div class="input-group-append">
                                          <div class="input-group-text">
                                              <i class="fas fa-percent"></i>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Harga Beli</label>
                                  <input type="text" class="form-control required-field" name="harga_beli" id="harga_beli">
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Harga Jual B2C</label>
                                  <input type="text" class="form-control required-field" name="harga_jual_b2c" id="harga_jual_b2c">
                              </div>
                          </div>
                          <div class="col-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                  <label>Harga Beli B2B</label>
                                  <input type="text" class="form-control required-field" name="harga_jual_b2b" id="harga_jual_b2b">
                              </div>
                          </div>
                          <div class="col-12 col-md-2 col-lg-2">
                              <div class="form-group">
                                  <label>Quantity</label>
                                  <input type="number" class="form-control required-field" name="quantity" id="quantity">
                              </div>
                          </div>
                        </div>
                    </div>
                    @if ($data->status == 0)
                        <div class="card-footer text-right">
                            <button hidden type="button" onclick="cancel_action()" id="button_cancel" class="btn btn-danger mr-2"><i class="fa fa-times mr-1"></i> Batalkan</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button></a>
                        </div>
                    @endif
                </form>
              </div>
        </div>
    </div>
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Pembelian Produk</h4>
               @if ($data->status == 0)
                <div class="card-header-action">
                    <button type="button" class="btn btn-danger" onclick="click_lock_pembelian();"><i class="fa fa-plus mr-1"></i> Lock Pembelian</button>
                </div>
               @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">#</th>
                           <th scope="col" class="text-center">SKU</th>
                           <th scope="col" class="text-center">Nama Produk</th>
                           <th scope="col" class="text-center">Qty Pembelian</th>
                           <th scope="col" class="text-center">Harga Beli</th>
                           <th scope="col" class="text-center">Harga Jual B2C</th>
                           <th scope="col" class="text-center">Harga Jual B2B</th>
                           <th scope="col" class="text-center">Diskon (%)</th>
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

@section('modal')
    <div class="modal fade" role="dialog" id="modal_master_produk" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_master_produk" width="100%">
                            <thead>
                                <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">SKU</th>
                                <th scope="col" class="text-center">Nama Produk</th>
                                <th scope="col" class="text-center">Stock</th>
                                <th scope="col" class="text-center" style="width: 25%">Actions</th>
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
        table_master_produk();
        onkeyupRupiah('harga_beli');
        onkeyupRupiah('harga_jual_b2b');
        onkeyupRupiah('harga_jual_b2c');
    })

    function click_master_produk(){
        $('#modal_master_produk').modal('show');
    }

    function table_master_produk(){
        var tb = $('#tb_master_produk').DataTable({
            processing: true,
            serverSide: false,
            destroy: true,
            ajax: {
                url: '/master/datatables-master-produk',
                type: 'GET'
            },
            columnDefs: [
                { className: 'text-center', targets: [0,1,3,4] },
            ],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'sku'},
                { data: 'nama_produk'},
                { data: 'stock'},
                { data: 'stock'},
            ],
            rowCallback : function(row, data){

                $('td:eq(4)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="terpilih_master_produk(${data.id},'${data.sku}','${data.master_kategori.kategori}','${data.master_subkategori.subkategori}','${data.nama_produk}','${data.berat}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function terpilih_master_produk(id, sku, kategori, subkategori, nama_produk, berat){
        $('#modal_master_produk').modal('hide');
        $('#master_produk_id').val(id);
        $('#sku').val(sku);
        $('#nama_produk').val(nama_produk);
        $('#kategori').val(kategori);
        $('#subkategori').val(subkategori);
        $('#berat').val(berat);
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/apps/pembelian-produk/detail-datatables',
            type: 'GET',
            data: {
                'pembelian_produk_id': $('#pembelian_produk_id').val(),
            },
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,3,4,5,6,7,8] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'sku' },
            { data: 'nama_produk' },
            { data: 'quantity' },
            { data: 'harga_beli', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'harga_jual_b2c', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'harga_jual_b2b', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'diskon' },
            { data: 'diskon' },
        ],
        rowCallback : function(row, data){
            var url_delete = "/admin/apps/pembelian-produk/detail-delete/" + data.id;

            if(data.pembelian_produk.status == '0'){
                $('td:eq(8)', row).html(`
                    <button class="btn btn-info btn-sm mr-1" onclick="action_edit('${data.id}')"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.sku}')"><i class="fa fa-trash"> </i></button>
                `);
            }else{
                $('td:eq(8)', row).html(`
                <div style="border:2px dashed black;padding: 15px;text-align: center;">
                    No Action
                </div>
                `);
            }
        }
    });

    function click_lock_pembelian(){
        swal({
            title: 'Yakin?',
            text: 'Data akan dilock dan tidak akan dapat dirubah?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
                if (willDelete) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url:  '/admin/apps/pembelian-produk/detail-lock',
                    type: 'POST',
                    data: {
                        'no_dokumen': $('#no_dokumen').val(),
                        'pembelian_produk_id': $('#pembelian_produk_id').val(),
                    },
                    success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.status == 200){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            $("#form_submit")[0].reset();
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
    }

    function action_edit(id){
        $('#id').val(id);
        $('#button_cancel').attr('hidden',false);

        $.ajax({
        url: '/admin/apps/pembelian-produk/detail-produk/' + id,
        type: "GET",
        dataType: 'JSON',
        success: function( response, textStatus, jQxhr ){
            $('#master_produk_id').val(response.master_produk_id);
            $('#harga_beli').val(response.harga_beli);
            $('#harga_jual_b2c').val(response.harga_jual_b2c);
            $('#harga_jual_b2b').val(response.harga_jual_b2b);
            $('#quantity').val(response.quantity);
            $('#diskon').val(response.diskon);
            $('#is_publish').val(response.is_publish).change().selectric('refresh');
            $('#sku').val(response.sku);
            $('#nama_produk').val(response.nama_produk);
            $('#kategori').val(response.kategori);
            $('#subkategori').val(response.subkategori);
            $('#berat').val(response.berat);
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
            console.warn(jqXhr.responseText);
        },
        });
    }

    function cancel_action(){
        $("#form_submit_self")[0].reset();
        $('#button_cancel').attr('hidden', true);
    }

    $('#form_submit_self').on('submit', function(e){
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
                  url:  $('#form_submit_self').attr('action'),
                  type: $('#form_submit_self').attr('method'),
                  data: $('#form_submit_self').serialize() + "&pembelian_produk_id=" + $('#pembelian_produk_id').val(),
                  success: function(response){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     if(response.status == 200){
                        swal(response.message, { icon: 'success', });
                        $("#modal").modal('hide');
                        $("#form_submit_self")[0].reset();
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
   });

</script>
@endsection
