@extends('partial.app')
@section('title','Detail Produk')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/dropzonejs/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">

    <style>
        .image-preview {
            width: 150px !important;
            height: 200px !important;
        }
    </style>

@endsection

@section('content')

<div class="section-body">
   <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kategori - Sub Kategori</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="place_subkategori">
                            <div style="border:2px dashed black;padding: 25px;text-align: center;" id="alert_subkategori">
                                Anda belum memilih sub kategori
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="form_upload" autocomplete="off">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Produk</h4>
                    <div class="card-header-action">
                        <label class="custom-switch mt-2 mr-4">
                            <input type="checkbox" name="is_diskon" id="is_diskon" class="custom-switch-input" value="1">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Diskon</span>
                        </label>
                        <label class="custom-switch mt-2 mr-4">
                            <input type="checkbox" name="is_ready_stock" id="is_ready_stock" class="custom-switch-input" value="1">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Ready Stock</span>
                        </label>
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="is_publish" id="is_publish" class="custom-switch-input" value="1">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Publish this Product</span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Kategori Produk</label>
                                <select class="form-control select2" name="master_kategori_id" id="id_master_kategori">
                                    <option selected disabled>- Pilih -</option>
                                    @foreach (\App\Models\MasterKategori::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Sub Kategori</label>
                                <input type="text" onclick="pilih_subkategori()" name="master_subkategori_id_view" id="master_subkategori_id_view" class="form-control required-field" readonly>
                                <input type="text" onclick="pilih_subkategori()" name="master_subkategori_id" id="master_subkategori_id" class="form-control required-field" hidden readonly>
                                <small class="text-danger">Pastikan pilih Kategori Produk</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk_desc" id="nama_produk_desc" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-1 col-lg-1">
                            <div class="form-group">
                                <label>Berat (gr)</label>
                                <input type="text" name="berat" id="berat" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Diskon</label>
                                <input type="text" name="diskon" id="diskon" class="form-control required-field diskon" readonly value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="text" name="harga_beli" id="harga_beli" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="text" name="sotck" id="sotck" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Minimal Order</label>
                                <input type="text" name="minimal_order" id="minimal_order" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" id="sku" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Jual B2C</label>
                                <input type="text" name="harga_jual_b2c" id="harga_jual_b2c" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Coret B2C</label>
                                <input type="text" name="harga_coret_b2c" id="harga_coret_b2c" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Jual B2B</label>
                                <input type="text" name="harga_jual_b2b" id="harga_jual_b2b" class="form-control required-field" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Coret B2B</label>
                                <input type="text" name="harga_coret_b2b" id="harga_coret_b2b" class="form-control required-field" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-7 col-lg-7">
                            <div class="form-group">
                                <label>Upload Foto</label>
                                <div class="dropzone" id="my-dropzone" name="mainFileUploader" style="border:3px dashed #D3D6D9;padding: 10px;text-align: center;">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Url Video</label>
                                <input type="text" name="url_video" id="url_video" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <textarea class="summernote" name="deskripsi_produk" id="deskripsi_produk" width="100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Harga Grosir B2C</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <input type="text" class="form-control">
                                        </div>
                                            <div class="col-10 col-md-6 col-lg-6">
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-2 col-md-1 col-lg-1">
                                            <button class="btn btn-warning mt-1"> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4>Harga Grosir B2B</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <input type="text" class="form-control">
                                        </div>
                                            <div class="col-10 col-md-6 col-lg-6">
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-2 col-md-1 col-lg-1">
                                            <button class="btn btn-warning mt-1"> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-warning">
                                <div class="card-header">
                                    <h4>Varian Produk</h4>
                                    <div class="card-header-action">
                                        <button type="button" class="btn btn-warning" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Kategori</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12 col-md-12">
                                                    <div id="image-preview" class="image-preview">
                                                        <label for="image-upload" id="image-label">Choose File</label>
                                                        <input type="file" name="image" id="image-upload" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-lg-10">
                                            <div class="row ml-1 mb-3">
                                                <label class="custom-switch mt-2 mr-4">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Ready Stock</span>
                                                </label>

                                                <label class="custom-switch mt-2">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Publish this Product</span>
                                                </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>SKU (Stock Keeping Unit)</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 col-lg-2">
                                                    <div class="form-group">
                                                        <label>Stock</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 col-lg-2">
                                                    <div class="form-group">
                                                        <label>Minimal Order</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Harga Beli</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 col-lg-2">
                                                    <div class="form-group">
                                                        <label>Diskon</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field diskon" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Harga Jual B2C</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Harga Coret B2C</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Harga Jual B2B</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Harga Coret B2B</label>
                                                        <input type="text" name="nama" id="nama" class="form-control required-field" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Harga Grosir B2C</h4>
                                                    <div class="card-header-action">
                                                        <a data-collapse="#mycard-collapse-b2c" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="mycard-collapse-b2c">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-4 col-lg-4">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                                <div class="col-10 col-md-6 col-lg-6">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-2 col-md-1 col-lg-1">
                                                                <button class="btn btn-warning mt-1"> <i class="fa fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Properties Varian</h4>
                                                    <div class="card-header-action">
                                                        <a data-collapse="#mycard-collapse-properties" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="mycard-collapse-properties">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-5 col-lg-5">
                                                                <select class="form-control selectric" name="agama" id="agama">
                                                                    <option selected disabled>- Pilih -</option>
                                                                </select>
                                                            </div>
                                                                <div class="col-10 col-md-5 col-lg-5">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-2 col-md-1 col-lg-1">
                                                                <button class="btn btn-warning mt-1"> <i class="fa fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Harga Grosir B2B</h4>
                                                    <div class="card-header-action">
                                                        <a data-collapse="#mycard-collapse-b2b" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="mycard-collapse-b2b">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-4 col-lg-4">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                                <div class="col-10 col-md-6 col-lg-6">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-2 col-md-1 col-lg-1">
                                                                <button class="btn btn-warning mt-1"> <i class="fa fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit-all" class="btn btn-success"><i class="fa fa-save m-1"></i> Simpan</button>
                </div>
            </div>
        </div>
        </form>
   </div>
</div>
@endsection

@section('modal')

<div class="modal fade" role="dialog" id="modal_subkategori" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title">Pilih Sub Kategori</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_ttd" autocomplete="off">
             <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_subkategori" width="100%">
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
          </form>
          <div class="modal-footer bg-whitesmoke br">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
       </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('assets/modules/dropzonejs/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>


    <script>

        $('#is_diskon').change(function(){
            if(!$(this).is(':checked')){
                $('.diskon').val('');
                $('.diskon').attr('readonly', true);
            }else{
                $('.diskon').attr('readonly', false);
            }
        });

        $('#id_master_kategori').change(function(){
            var tb = $('#tb_subkategori').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '/master/datatables-subkategori-by-kategori/' + $('#id_master_kategori').val(),
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0,1,2,3,4,5] },
                ],
                columns: [
                    { data: 'DT_RowIndex',searchable: false, orderable: false},
                    { data: 'master_kategori.kategori' },
                    { data: 'level' },
                    { data: 'parent_id' },
                    { data: 'subkategori' },
                    { data: 'subkategori' },
                ],
                rowCallback : function(row, data){

                    let color = ['danger', 'warning', 'info', 'primary', 'success'];
                    $('td:eq(2)', row).html(`<span class="badge badge-${color[data.level - 1]}">${data.level}</span>`);

                    $('td:eq(5)', row).html(`
                        <button type="button" class="btn btn-info btn-sm mr-1" onclick="terpilih_subkategori(${data.id})"><i class="fa fa-edit"></i></button>
                    `);
                }
            });
        });

        function terpilih_subkategori(id){
            $.ajax({
                url: '/master/data-urutan-subkategori-by-id/' + id,
                type: "GET",
                dataType: 'JSON',
                success: function( data, textStatus, jQxhr ){
                    $('#alert_subkategori').attr('hidden',true);
                    let color = ['danger', 'warning', 'info', 'primary', 'success'];
                    let subkategori = '';
                    $.each(data, function( index, value ) {
                        $('#place_subkategori').append(`
                            <span class="badge badge-${color[index]}">${value.subkategori}</span>
                        `);

                        subkategori = value.subkategori;
                    });

                    $('#master_subkategori_id_view').val(subkategori);
                    $('#master_subkategori_id').val(id);
                    $('#modal_subkategori').modal('hide');
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        }

        function pilih_subkategori(){
            $('#modal_subkategori').modal('show');
        }

        Dropzone.options.myDropzone = {
            url: "/admin/produk/produk/store-update",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 5,
            maxFilesize: 1,
            acceptedFiles: "image/*",

            init: function () {

                var submitButton = document.querySelector("#submit-all");
                var wrapperThis = this;

                submitButton.addEventListener("click", function () {
                    wrapperThis.processQueue();
                });

                this.on("addedfile", function (file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-danger btn-xs mt-1 dark'>Remove File</button>");

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        wrapperThis.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });

                this.on('sendingmultiple', function (data, xhr, formData) {
                    $("#form_upload").find("input").each(function(){
                        formData.append($(this).attr("name"), $(this).val());
                    });
                });
            }
        };
    </script>
@endsection
