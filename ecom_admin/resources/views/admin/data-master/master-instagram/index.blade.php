@extends('partial.app')
@section('title','Master Sosial Media')

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Master Sosial Media</h4>
               <div class="card-header-action">
                  <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Sosial Media</button>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Tipe</th>
                          <th scope="col" class="text-center">Image</th>
                          <th scope="col" class="text-center">Link</th>
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
          <form id="form_upload" action="/admin/data-master/master-sosial-media/store-update" method="POST" autocomplete="off">
            <input type="text" name="id" id="id" hidden>
            <input type="text" name="type" id="type" hidden>
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Tipe</label>
                              <select class="form-control selectric" id="tipe" name="tipe">
                                 <option value="instagram">Instagram</option>
                                 <option value="youtube">Youtube</option>
                                 <option value="tiktok">Tiktok</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="upload_image" id="upload_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" id="link" class="form-control">
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

   var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/data-master/master-sosial-media/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,4] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'tipe' },
            { data: 'url_image' },
            { data: 'link' },
            { data: 'link' },
        ],
        rowCallback : function(row, data){

            $('td:eq(2)', row).html(`<a href="{{ asset('${data.url_image}') }}" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="far fa-file-alt"></i> Lihat Foto</a>`);
            $('td:eq(3)', row).html(`<a href="${data.link}" target="_blank">${data.link}</a>`);

            var url_edit   = "/admin/data-master/master-sosial-media/detail/" + data.id;
            var url_delete = "/admin/data-master/master-sosial-media/delete/" + data.id;
            $('td:eq(4)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.kategori}')"><i class="fa fa-trash"> </i></button>
            `);
        }
    });

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Instagram Produk');
        $("#form_upload")[0].reset();
        reset_all_select();
    }

    function edit(url){
        edit_action(url, 'Edit Instagram Produk');
        $("#type").val('update');
    }
</script>
@endsection
