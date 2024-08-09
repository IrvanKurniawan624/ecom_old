@extends('partial.app')
@section('title','Jasa Pengiriman')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           <div class="card">
              <div class="card-header">
                 <h4>Data Asal Pengiriman</h4>
              </div>
              <div class="card-body" id="place_data">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb-asal-pengiriman" width="100%">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Seller</th>
                            <th scope="col" class="text-center">Provinsi</th>
                            <th scope="col" class="text-center">Kota</th>
                            <th scope="col" class="text-center">Kode Pos</th>
                        </tr>
                        </thead>
                    </table>
                </div>
              </div>
           </div>
        </div>
     </div>
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Jasa Pengiriman</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Jasa Pengiriman</th>
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
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" class="form-control" name="kode_pos" id="kode_pos">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" id="no_telepon">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="provinsi_id">Provinse</label>
                                <select class="form-control select2" name="provinsi" id="provinsi" required onchange="change_provinsi()">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="kota_id">Kota</label>
                                <select class="form-control select2" name="kota" id="kota" required onchange="change_kota()">
                                </select>
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
        $('#place_input').hide();
    })

    function click_ganti(){
        get_data_province();
        $('#place_data').hide();
        $('#place_input').show();
    }

    function click_batal(){
        $('#place_data').show();
        $('#place_input').hide();
    }

    function get_data_province(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/api-provinsi",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $('.btn-add-alamat-pengiriman').removeAttr('disabled');
                    $("#provinsi_id").empty();
                    $('#provinsi_id').append('<option selected disabled>- Pilih -</option>');
                    for (var i = 0; i < data.length; i++) {
                        $("#provinsi_id").append(`<option value="${data[i].province_id}">${data[i].province}</option>`);
                    }

                    $('#provinsi').val($('#provinsi_id option:selected').text());
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function change_provinsi(){
        $('#provinsi').val($('#provinsi_id option:selected').text());
        let data_kota = $('#kota').val();
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/api-city-by-provinsi/" + $('#provinsi_id').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $("#kota_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].city_name == data_kota){
                            $("#kota_id").append(`<option value="${data[i].city_id}" selected>${data[i].city_name}</option>`);
                        }else{
                            $("#kota_id").append(`<option value="${data[i].city_id}">${data[i].city_name}</option>`);
                        }
                    }

                    $('#kota').val($('#kota_id option:selected').text());
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function change_kota(){
        $('#kota').val($('#kota_id option:selected').text());
    }

    var tb2 = $('#tb-asal-pengiriman').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/apps/jasa-pengiriman/datatables2',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_seller.nama' },
            { data: 'provinsi' },
            { data: 'kota' },
            { data: 'kode_pos' },
        ],
        rowCallback : function(row, data){
            var url_edit   = "/admin/apps/jasa-pengiriman/detail/" + data.id;
            var url_delete = "/admin/apps/jasa-pengiriman/delete/" + data.id;
            // $('td:eq(4)', row).html(`
            //     <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
            //     <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.kategori}')"><i class="fa fa-trash"> </i></button>
            // `);
        }
    });

    function edit(url){
        edit_action(url, 'Edit Asal Pengiriman Produk');
        $("#type").val('update');
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        'paging': false,
        ajax: {
            url: '/admin/apps/jasa-pengiriman/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'nama' },
            { data: 'status_desc' },
            { data: 'status_desc' },
        ],
        rowCallback : function(row, data){

            if(data.status_desc == 'aktif'){
                $('td:eq(2)', row).html(`<span class="badge badge-success">aktif</span>`);
                $('td:eq(3)', row).html(`<button class="btn btn-danger btn-sm" onclick="action('${data.id}','0')"><i class="fa fa-times mr-2"></i>deactivated</button>`);
            }else{
                $('td:eq(2)', row).html(`<span class="badge badge-danger">non-aktif</span>`);
                $('td:eq(3)', row).html(`<button class="btn btn-info btn-sm mr-1" onclick="action('${data.id}','1')"><i class="fa fa-check mr-2"></i>activated</button>`);
            }
        }
    });

    function action(id, status){
        $.ajax({
            url: '/admin/apps/jasa-pengiriman/action/' + id + "/" + status,
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
