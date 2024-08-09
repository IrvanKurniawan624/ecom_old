@extends('partial.app')
@section('title','Master Dictionary')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Master Dictionary</h4>
               <div class="card-header-action">
                    <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Dictionary</button>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Kata Kunci</th>
                           <th scope="col" class="text-center">Dictionary</th>
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
          <form id="form_submit" action="/admin/data-master/master-dictionary/store-update" method="POST" autocomplete="off">
             <div class="modal-body">
                <div class="row">
                      <div class="col-12 col-md-12 col-lg-12">
                         <div class="form-group">
                             <label>Kata Kunci</label>
                             <input type="text" hidden class="form-control" name="id" id="id">
                             <input type="text" hidden class="form-control" name="type" id="type">
                             <input type="text" class="form-control" name="kata_kunci" id="kata_kunci">
                         </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-12">
                        <button type="button" class="btn btn-success btn-block" style="margin-bottom: 1rem" onclick="add_dictionary()"> <i class="fa fa-plus"></i> Tambah Dictionary </button>
                     </div>
                </div>

                <div id="place_append">

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
         url: '/admin/data-master/master-dictionary/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,1,2,3] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'kata_kunci' },
         { data: 'dictionary_desc' },
         { data: 'kata_kunci' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/admin/data-master/master-dictionary/detail/" + data.id;
         var url_delete = "/admin/data-master/master-dictionary/delete/" + data.id;

         $('td:eq(3)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.kata_kunci}')"><i class="fa fa-trash"> </i></button>
         `);
      }
   });

    let count = 0;
    function add_dictionary(){
        count++;
        $('#place_append').append(`
            <div class="row" id="row${count}">
                <div class="col-10 col-md-10 col-lg-10">
                    <div class="form-group">
                        <input type="text" class="form-control" name="dictionary[]">
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-remove" id="${count}"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `);
    }

    $('#place_append').on('click', '.btn-remove', function(e) {
        e.preventDefault();
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master Dictionary');
        $('#place_append').html('');
        $("#form_submit")[0].reset();
    }

    function edit(url){
        edit_action_self(url, 'Edit Master Dictionary');
        $("#type").val('update');
    }

    function edit_action_self(url, modal_text){
      save_method = 'edit';
      $("#modal").modal('show');
      $('#place_append').html('');
      $("#form_submit")[0].reset();
      $(".modal-title").text(modal_text);
      $("#modal_loading").modal('show');
      $.ajax({
         url : url,
         type: "GET",
         dataType: "JSON",
         success: function(response){
            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
            $("#id").val(response.id);
            $("#kata_kunci").val(response.kata_kunci);

            for (let i = 0; i < response.dictionary.length; i++) {
                $('#place_append').append(`
                    <div class="row" id="row${i}">
                        <div class="col-10 col-md-10 col-lg-10">
                            <div class="form-group">
                                <input type="text" class="form-control" name="dictionary[]" value="${response.dictionary[i]}">
                            </div>
                        </div>
                        <div class="col-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-remove" id="${i}"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `);
            }

         },error: function (jqXHR, textStatus, errorThrown){
            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
         }
      });
   }


</script>
@endsection
