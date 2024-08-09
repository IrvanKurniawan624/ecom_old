@extends('partial.app')
@section('title','Data Pelanggan')

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Data Pelanggan</h4>
               <div class="card-header-action">
                    <a href="/admin/pelanggan/data-pelanggan/export-excel" target="_blank"><button class="btn btn-danger mr-2"><i class="fa fa-file-excel mr-1"></i> Export Excel</button></a>
                    <button class="btn btn-success mr-2" onclick="upload_excel_modal();"><i class="fa fa-file-excel mr-1"></i> Import Excel</button>
                    <a href="/admin/pelanggan/data-pelanggan/add"><button type="button" class="btn btn-warning"><i class="fa fa-plus mr-1"></i> Tambah Data Pelanggan</button></a>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Tipe Pelanggan</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Telepon</th>
                          <th scope="col" class="text-center">Login Tipe</th>
                          <th scope="col" class="text-center">Point</th>
                          <th scope="col" class="text-center">Status</th>
                          <th scope="col" class="text-center" style="width: 15%">Actions</th>
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

<!-- Modal Upload -->
<form id="form_upload" action="/admin/pelanggan/data-pelanggan/import-excel" method="post" enctype="multipart/form-data">
    <div class="modal fade" role="dialog" id="modal_upload" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header br">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 style="color:black">Petunjuk</h6>
                    <p>Format susunan file excel, sebagai berikut :</p>

                    <ul>
                    <li>Ketentuan 1</li>
                    <li>Ketentuan 2</li>
                    <li>Ketentuan 3</li>
                    </ul>

                    <a href="{{asset('/berkas/template-excel/Format_Import_User_Excel_V2.xlsx')}}" class="btn btn-success"><i class="fas fa-download"></i> Download Template Excel</a>
                </div>

                <div class="col-md-6">
                    <div class="text-center">
                        <span>
                            <i  style="font-size: 30px; padding-bottom: 20px;" class="fa fa-upload"></i>
                        </span>
                        <p style="line-height: 10px;">Silahkan pilih file excel yang akan diupload</p>
                        <label class="label-upload" for="file_excel">
                            <input class="input-upload" type="file" name="file_excel" id="file_excel" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, .xls" required="" onchange="get_path_file();">Upload File
                        </label>
                        <small id="path_file_text"></small>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </div>
    </div>
    </div>
</form>
<!-- Modal Upload -->

@section('js')
<script>
    $(document).ready(function(){
        get_data_tipe_customer();
    });

    function upload_excel_modal(){
        $("#modal_upload").modal('show');
        $(".modal-title").text('Upload Excel');
    }

    function get_data_tipe_customer(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/TipeCustomer",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#tipe_customer_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].id != 1){
                            $("#tipe_customer_id").append(`<option value="${data[i].id}">${data[i].customer}</option>`);
                        }
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
         url: '/admin/pelanggan/data-pelanggan/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,1,4,5,6,7] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'tipe_customer.customer' },
         { data: 'nama' },
         { data: 'no_telepon' },
         { data: 'social_type' },
         { data: 'poin' },
         { data: 'is_active' },
         { data: 'poin' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/admin/pelanggan/data-pelanggan/detail/" + data.id;
         var url_reset_password   = "/admin/data-master/master-user/reset-password/" + data.id;

         $('td:eq(1)', row).html(`<span class="badge badge-primary">${data.tipe_customer.customer}</span>`);

        if(data.social_type == 'google'){
            $('td:eq(4)', row).html(`<span class="badge badge-danger">Google</span>`);
        }else if(data.social_type == 'facebook'){
            $('td:eq(4)', row).html(`<span class="badge badge-primary">Facebook</span>`);
        }

        $('td:eq(7)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
        `);

        if(data.social_type === null){
            $('td:eq(7)', row).append(`
                <button class="btn btn-warning btn-sm mr-1" onclick="reset_password('${url_reset_password}')"><i class="fas fa-key"></i> Reset</button>
            `);
        }

        if(data.is_active == '1'){
            $('td:eq(6)', row).html(`<span class="badge badge-success">aktif</span>`);
            $('td:eq(7)', row).append(`<button class="btn btn-danger btn-sm" onclick="action('${data.id}','0')"><i class="fa fa-times mr-2"></i>deactivated</button>`);
        }else{
            $('td:eq(6)', row).html(`<span class="badge badge-danger">non-aktif</span>`);
            $('td:eq(7)', row).append(`<button class="btn btn-success btn-sm mr-1" onclick="action('${data.id}','1')"><i class="fa fa-check mr-2"></i>activated</button>`);
        }


      }
   });

    function edit(url){
        window.open(url,"_blank");
        // window.location.href = url;
    }

    function reset_password(url){
        swal({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan mereset password data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
      })
      .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'JSON',
                    success: function( response, textStatus, jQxhr ){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.status === 200){
                            swal(response.message, {  icon: 'success', });
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
        })
    }

    function action(id, status){
        $.ajax({
            url: '/admin/pelanggan/data-pelanggan/action/' + id + "/" + status,
            type: "GET",
            dataType: 'JSON',
            success: function( response, textStatus, jQxhr ){
                if(response.status == 200){
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                        });
                    tb.ajax.reload(null, false);
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
            },
        });
    }
</script>
@endsection
