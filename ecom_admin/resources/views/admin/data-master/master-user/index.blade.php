@extends('partial.app')
@section('title','Master User')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="alert alert-info">
         Password Default Untuk Pembuatan Seller baru adalah <b>newuser</b> </a>
         </div>
         <div class="card">
            <div class="card-header">
               <h4>Data Master User</h4>
               <div class="card-header-action">
                    <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master User</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Nama</th>
                          <th scope="col" class="text-center">Email</th>
                          <th scope="col" class="text-center">Telepon</th>
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
          <form id="form_upload" action="/admin/data-master/master-user/store-update" method="POST" autocomplete="off">
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                       <div class="form-group">
                           <label>Nama</label>
                           <input type="text" class="form-control" name="nama" id="nama">
                       </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" id="no_telepon" onkeypress="return hanyaAngka(event,false);">
                        </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" hidden class="form-control" name="id" id="id">
                            <input type="text" hidden class="form-control" name="type" id="type">
                            <input type="text" class="form-control" name="email" id="email">
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
    // $(document).ready(function(){
    //     get_data_tipe_customer();
    // });

    // function get_data_tipe_customer(){
    //     $("#modal_loading").modal('show');
    //     $.ajax({
    //         url : "/master/get-data-all/TipeCustomer",
    //         type: "GET",
    //         dataType: "JSON",
    //         success: function(response){
    //             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
    //             if(response.status === 200){
    //                 var data = response.data;
    //                 $("#tipe_customer_id").empty();
    //                 for (var i = 0; i < data.length; i++) {
    //                     if(data[i].id == 1){
    //                         $("#tipe_customer_id").append(`<option value="${data[i].id}">${data[i].customer}</option>`);
    //                     }
    //                 }
    //             }else{
    //                 iziToast.error({
    //                     title: 'Error!',
    //                     message: response.message,
    //                     position: 'topRight'
    //                 });
    //             }
    //         },error: function (jqXHR, textStatus, errorThrown){
    //             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
    //             swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
    //         }
    //     });
    // }
   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/admin/data-master/master-user/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,1,2,3,4] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'nama' },
         { data: 'email' },
         { data: 'no_telepon' },
         { data: 'no_telepon' },
      ],
      rowCallback : function(row, data){

        var url_reset_password   = "/admin/data-master/master-user/reset-password/" + data.id;
        var url_edit   = "/admin/data-master/master-user/detail/" + data.id;
        var url_delete = "/admin/data-master/master-user/delete/" + data.id;
        $('td:eq(4)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick="reset_password('${url_reset_password}')"><i class="fas fa-key"></i> Reset Password</button>
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.nama}')"><i class="fa fa-trash"> </i> Hapus</button>
        `);
      }
   });

   function reset_password(url){
        $("#modal_loading").modal('show');
        $.ajax({
            url: url,
            type: "GET",
            dataType: 'JSON',
            success: function( response, textStatus, jQxhr ){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    swal("Password Berhasil Diubah Menjadi (passworddefault)", {  icon: 'success', });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                }else{
                    swal(response.message, {  icon: 'error', });
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
            console.warn(jqXhr.responseText);
            },
        });
   }

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master User');
        $('#place_append').html('');
        $("#form_upload")[0].reset();
    }

    function edit(url){
        edit_action(url, 'Edit Master User');
        $("#type").val('update');
    }
</script>
@endsection
