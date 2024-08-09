@extends('partial.app')
@section('title','Master Package')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-7 col-lg-7">
         <div class="card">
            <div class="card-header">
               <h4>Data Master Package</h4>
               <div class="card-header-action">
                    <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Package</button>
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
          <form id="form_upload" action="/admin/data-master/master-package/store-update" method="POST" autocomplete="off">
             <div class="modal-body">
                <div class="row">
                      <div class="col-12 col-md-12 col-lg-12">
                         <div class="form-group">
                             <label>Package</label>
                             <input type="text" hidden class="form-control" name="id" id="id">
                             <input type="text" hidden class="form-control" name="type" id="type">
                             <input type="text" class="form-control" name="package" id="package" onkeyup="return onkeyupUppercase(this.id)">
                         </div>
                     </div>
                     <div class="col-12 col-md-8 col-lg-8">
                         <div class="form-group">
                             <label>Icon (svg, png)</label>
                             <input type="file" name="upload_image" id="upload_image" class="form-control">
                         </div>
                     </div>
                     <div class="col-12 col-md-4 col-lg-4" style="margin-top: 6%">
                        <a href="https://www.svgrepo.com/" target="_blank"><button type="button" class="btn btn-primary btn-block">Pilih Icon</button></a>
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
         url: '/admin/data-master/master-package/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,1,2,3] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'package' },
         { data: 'url_image' },
         { data: 'url_image' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/admin/data-master/master-package/detail/" + data.id;
         var url_delete = "/admin/data-master/master-package/delete/" + data.id;

         $('td:eq(2)', row).html(`<a href="{{ asset('${data.url_image}') }}" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="far fa-file-alt"></i> Lihat Foto</a>`);

         $('td:eq(3)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.package}')"><i class="fa fa-trash"> </i></button>
         `);
      }
   });

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master Package');
        $("#form_upload")[0].reset();
    }

    function edit(url){
        edit_action(url, 'Edit Master Package');
        $("#type").val('update');
    }


</script>
@endsection
