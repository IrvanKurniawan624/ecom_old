@extends('partial.app')
@section('title','Produk')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        @if(!empty($unauthorize))
        <div class="alert alert-danger">
            <b>{{ $unauthorize }}</b> </a>
        </div>
        @endif
         <div class="card">
            <div class="card-header">
               <h4>Data Produk</h4>
               <div class="card-header-action">
                    <a href="/admin/produk/produk/export-excel" target="_blank"><button class="btn btn-danger mr-2"><i class="fa fa-file-excel mr-1"></i> Export Excel</button></a>
                    <button class="btn btn-success mr-2" onclick="upload_excel_modal();"><i class="fa fa-file-excel mr-1"></i> Import Excel</button>
                    <a href="/admin/produk/produk/add"><button type="button" class="btn btn-warning"><i class="fa fa-plus mr-1"></i> Tambah Produk</button></a>
               </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-3">
                            <select class="form-control selectric" id="action_checkbox" name="action_checkbox">
                                <option selected disabled>Action For Selected</option>
                                <option value="publish">Publish</option>
                                <option value="unpublish">Unpublish</option>
                                <option value="hapus">Hapus</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-8 col-lg-8 float-left">
                            <button type="button" class="btn btn-warning btn-lg" id="button_processing">Proses</button>
                            <button type="button" class="btn btn-primary btn-lg ml-2" id="selectAll">Select All</button>
                        </div>

                    </div>


                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-striped" id="tb" width="100%">
                        <thead>
                           <tr>
                              <th scope="col" class="text-center">No</th>
                              <th scope="col" class="text-center">Gambar</th>
                              <th scope="col" class="text-center">Kategori</th>
                              <th scope="col" class="text-center">Nama Produk</th>
                              <th scope="col" class="text-center">Stock</th>
                              <th scope="col" class="text-center">Harga</th>
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

@section('modal')
     <!-- Modal Upload -->
     <form id="form_upload" action="/admin/produk/produk/import-excel" method="post" enctype="multipart/form-data">
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

                        <a href="{{asset('/berkas/template-excel/Format_Import_Produk_Excel_V3.xlsx')}}" class="btn btn-success"><i class="fas fa-download"></i> Download Template Excel</a>
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
@endsection

@section('js')
<script>
    function upload_excel_modal(){
        $("#modal_upload").modal('show');
        $(".modal-title").text('Upload Excel');
    }

    $(document).ready(function () {
        $('body').on('click', '#selectAll', function () {
            if ($(this).hasClass('allChecked')) {
                $('input[type="checkbox"]').prop('checked', false);
            } else {
                $('input[type="checkbox"]').prop('checked', true);
            }
            $(this).toggleClass('allChecked');
        })
    });

    $('#button_processing').click(function(){
        if(!$('#action_checkbox').val()){
            swal("Oops! Harap pilih action terlebih dahulu", {  icon: 'warning', });
        }

        let array = [];
        tb.$('input:checked').each(function () {
            array.push($(this).val());
        });

        if(array.length == 0){
            swal("Oops! Harap pilih data terlebih dahulu", {  icon: 'warning', });
        }

        $.ajax({
            url: '/admin/produk/produk/action-selected',
            type: "POST",
            dataType: 'JSON',
            data: {
                'tipe': $('#action_checkbox').val(),
                'array': array,
            },
            success: function( response ){
                if(response.status == 200){
                    swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    reset_all_select();
                    tb.ajax.reload(null, false);
                }else{
                    swal(response.message, { icon: 'error', });
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
            },
        });

    });


    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: false,
        "pageLength": 50,
        ajax: {
            url: '/admin/produk/produk/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5,6,7] },
        ],
        columns: [
            {data: 'select_item', name: 'select_item', searchable: false, orderable: false},
            // { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'produk_image' },
            { data: 'master_kategori.kategori' },
            { data: 'nama_produk_desc' },
            { data: 'stock' },
            { data: 'harga_jual_b2c', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'is_publish_desc' },
            { data: 'is_publish' },
        ],
        rowCallback : function(row, data){

            // if(typeof(data.url_image) != "undefined" && data.url_image !== null) {
            //     $('td:eq(2)', row).html(`<a href="${data.url_image[0]}" target="_blank" class="btn btn-primary btn-sm mr-2"><i class="far fa-file-alt"></i> Lihat Foto</a>`);
            // }else{
            //     $('td:eq(2)', row).html(`
            //     <div style="border:2px dashed black;padding: 15px;text-align: center;">
            //         Tidak ada foto
            //     </div>
            //     `);
            // }

            let color = ['danger','success'];
            $('td:eq(6)', row).html(`<span class="badge badge-${color[data.is_publish]}">${data.is_publish_desc}</span>`);


            var url_edit   = "/admin/produk/produk/detail/" + data.id;
            var url_clone   = "/admin/produk/produk/clone/" + data.id;
            var url_delete = "/admin/produk/produk/delete/" + data.id;
            var url_setting_image = "/admin/produk/produk/setting-image/" + data.id;
            $('td:eq(7)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm mr-1" onclick="delete_action('${url_delete}','${data.nama_produk_desc}')"><i class="fa fa-trash"> </i></button>
                <a href="${url_setting_image}" target='_blank'><button class="btn btn-success btn-sm mr-1"><i class="fas fa-sitemap"> </i></button></a>
                <button class="btn btn-warning btn-sm" onclick="edit('${url_clone}')"><i class="fas fa-clone"></i> Clone </button>

            `);
        }
    });

    function edit(url){
        window.open(
            url,
            '_blank' // <- This is what makes it open in a new window.
        );
    }
</script>
@endsection
