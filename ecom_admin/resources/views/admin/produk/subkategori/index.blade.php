@extends('partial.app')
@section('title','Sub Kategori Produk')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Sub Kategori Produk</h4>
               <div class="card-header-action">
                  <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Sub Kategori</button>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Kategori Produk</th>
                          <th scope="col" class="text-center">Level</th>
                          <th scope="col" class="text-center">Parent</th>
                          <th scope="col" class="text-center">Sub kategori</th>
                          <th scope="col" class="text-center" style="width: 25%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title"></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_submit" action="/admin/produk/subkategori/store-update" method="POST" autocomplete="off">
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label>Kategori Produk</label>
                            <select class="form-control select2" name="master_kategori_id" id="master_kategori_id" onchange="get_data_master_subkategori()">
                               <option selected disabled>- Pilih -</option>
                           </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label>Level</label>
                            <input type="number" min="1" class="form-control" name="level" id="level" value="1" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Subkategori Parent</label>
                            <select class="form-control select2" name="parent_id" id="parent_id">
                                <option selected value="0" level='0'>I'am Parent</option>
                            </select>
                            <small>Akan mencari Subkategori dengan Kategori x dan level dibawah yang di inputkan</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nama Sub Kategori</label>
                            <input type="text" hidden class="form-control" name="id" id="id">
                            <input type="text" hidden class="form-control" name="type" id="type">
                            <input type="text" class="form-control" name="subkategori" id="subkategori" onkeyup="return onkeyupUppercase(this.id)">
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

    $(document).ready(function(){
        get_data_master_kategori();
    });

    function get_data_master_kategori(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/MasterKategori",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#master_kategori_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#master_kategori_id").append(`<option value="${data[i].id}">${data[i].kategori}</option>`);
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

    $('#parent_id').change(function(){
        $('#level').val(parseInt($('option:selected', this).attr('level')) + 1);
    });


    function get_data_master_subkategori(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id_get/MasterSubkategori/master_kategori_id/" + $('#master_kategori_id').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#parent_id").empty();
                    $("#parent_id").append(`<option selected value="0" level='0'>I'am Parent</option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#parent_id").append(`<option value="${data[i].id}" level="${data[i].level}">${data[i].subkategori}</option>`);
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
            url: '/admin/produk/subkategori/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_kategori.kategori' },
            { data: 'level' },
            { data: 'parent_desc' },
            { data: 'subkategori' },
            { data: 'subkategori' },
        ],
        rowCallback : function(row, data){

            let color = ['danger', 'warning', 'info', 'primary', 'success'];
            $('td:eq(2)', row).html(`<span class="badge badge-${color[data.level - 1]}">${data.level}</span>`);

            var url_edit   = "/admin/produk/subkategori/detail/" + data.id;
            var url_delete = "/admin/produk/subkategori/delete/" + data.id;
            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.subkategori}')"><i class="fa fa-trash"> </i></button>
            `);
        }
    });

    function add(){
        get_data_master_subkategori();
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Subkategori Produk');
        $("#form_submit")[0].reset();
        reset_all_select();
        $('#level').val('1');
    }

    function edit(url){
        get_data_master_subkategori();
        edit_action(url, 'Edit Subkategori Produk');
        $("#type").val('update');
    }
</script>
@endsection
