@extends('partial.app')
@section('title','Master Banner')

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Master Banner</h4>
               <div class="card-header-action">
                  <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Banner</button>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Package</th>
                          <th scope="col" class="text-center">Banner</th>
                          <th scope="col" class="text-center">Judul</th>
                          <th scope="col" class="text-center">Status</th>
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
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title"></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_upload" action="/admin/data-master/master-banner/store-update" method="POST" autocomplete="off">
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Master Package</label>
                            <input type="text" hidden class="form-control" name="id" id="id">
                            <input type="text" hidden class="form-control" name="type" id="type">
                            <select class="form-control select2" name="master_package_id" id="master_package_id">
                               <option selected disabled>- Pilih -</option>
                           </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Banner</label>
                            <input type="file" name="upload_image" id="upload_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Judul Banner</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <textarea class="summernote" name="deskripsi" id="deskripsi" width="100px"></textarea>
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
        get_data_master_package();
    });

    function get_data_master_package(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/MasterPackage",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#master_package_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#master_package_id").append(`<option value="${data[i].id}">${data[i].package}</option>`);
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
            url: '/admin/data-master/master-banner/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_package.package' },
            { data: 'url_image' },
            { data: 'title' },
            { data: 'status_desc' },
            { data: 'url_image' },
        ],
        rowCallback : function(row, data){

            $('td:eq(2)', row).html(`<a href="{{ asset('${data.url_image}') }}" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="far fa-file-alt"></i> Lihat Foto</a>`);

            let color = ['danger', 'success'];
            $('td:eq(4)', row).html(`<span class="badge badge-${color[data.status]}">${data.status_desc}</span>`);

            var url_edit   = "/admin/data-master/master-banner/detail/" + data.id;
            var url_delete = "/admin/data-master/master-banner/delete/" + data.id;
            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.kategori}')"><i class="fa fa-trash"> </i></button>
            `);
        }
    });

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Banner Produk');
        $("#form_upload")[0].reset();
        $('#deskripsi').summernote('code', '');
        reset_all_select();
    }

    function edit(url){
        edit_action(url, 'Edit Banner Produk');
        $("#type").val('update');
    }
</script>
@endsection
