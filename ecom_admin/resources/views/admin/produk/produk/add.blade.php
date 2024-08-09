@extends('partial.app')
@section('title',$title)

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/dropzonejs/dropzone.css') }}">

    <style>
        .image-preview {
            width: 150px !important;
            height: 200px !important;
        }

        .form-input input {
            display:none;
        }

        .form-input label {
            display:block;
            width:45%;
            height:45px;
            margin-left: 25%;
            line-height:50px;
            text-align:center;
            background:#1172c2;
            color:#fff;
            font-size:15px;
            font-family:"Open Sans",sans-serif;
            text-transform:Uppercase;
            font-weight:600;
            border-radius:5px;
            cursor:pointer;
        }

        .vertical-center {
            margin: 0;
            position: absolute;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
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

                            @if (!empty($subkategori_produk))
                                @foreach ($subkategori_produk as $item)
                                    {!!($item)!!}
                                @endforeach
                            @endif

                            <div style="border:2px dashed black;padding: 25px;text-align: center;" id="alert_subkategori" @if (!empty($subkategori_produk)) hidden @endif>
                                Anda belum memilih sub kategori
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="form_submit" action="/admin/produk/produk/store-update" method="POST" autocomplete="off">
        @if (!isset($type))
            <input type="text" hidden name="id" @if (!empty($master_produk)) value="{{$master_produk->id}}"@endif>
        @endif
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Produk</h4>
                    <div class="card-header-action">
                        <input type='text' name='is_diskon' id='is_diskon' hidden value="{{ !empty($master_produk) && $master_produk->diskon == null ? '0' : '1'  }}">
                        <label class="custom-switch mt-2 mr-4">
                            <input type="checkbox" name="is_diskon_view" id="is_diskon_view" class="custom-switch-input" value="1" @if(!empty($master_produk) && $master_produk->diskon == null)  @else checked @endif>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Diskon</span>
                        </label>
                        <input type='text' name='is_ready_stock' id="is_ready_stock" hidden value=" {{ (!empty($master_produk)) ? $master_produk->is_ready_stock : 0 }} ">
                        <label class="custom-switch mt-2 mr-4">
                            <input type="checkbox" name="is_ready_stock_view" id="is_ready_stock_view" class="custom-switch-input" value="1" @if(!empty($master_produk) && $master_produk->is_ready_stock == 1) checked @endif>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Ready Stock</span>
                        </label>
                        <input type='text' name='is_publish' id="is_publish" hidden value=" {{ (!empty($master_produk)) ? $master_produk->is_publish : 0 }}">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="is_publish_view" id="is_publish_view" class="custom-switch-input" value="1" @if(!empty($master_produk) && $master_produk->is_publish == 1) checked @endif>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Publish this Product</span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                             <div class="form-group">
                                <label>Kata Kunci</label>&nbsp;&nbsp;<small class="text-danger"> <b>Separator `|` untuk memisahkan kata kunci</b>  <span class="text-primary">[contoh : harddisk|komputer|penyimpanan]</span> </small>
                                <input type="text" name="kata_kunci" id="kata_kunci" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->kata_kunci }}" @endif onkeyup="return onKeyupLowercase(this.id)">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Kategori Produk</label>
                                <select class="form-control select2" name="master_kategori_id" id="id_master_kategori" required>
                                    <option selected disabled>- Pilih -</option>
                                    @foreach (\App\Models\MasterKategori::get() as $item)
                                        <option value="{{ $item->id }}" @if(!empty($master_produk) && $master_produk->master_kategori_id == $item->id) selected @endif>{{ $item->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Sub Kategori</label>
                                <input type="text" onclick="pilih_subkategori()" name="master_subkategori_id_view" id="master_subkategori_id_view" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->master_subkategori->subkategori }}" @endif readonly>
                                <input type="text" name="master_subkategori_id" id="master_subkategori_id" class="form-control required-field" hidden @if(!empty($master_produk)) value="{{ $master_produk->master_subkategori_id }}" @endif>
                                <small class="text-danger">Pastikan pilih Kategori Produk</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->nama_produk }}" @endif>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <label>Diskon</label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" name="diskon" id="diskon" class="form-control diskon" @if(!empty($master_produk) && $master_produk->diskon == null) readonly @elseif(!empty($master_produk)) value="{{ $master_produk->diskon }}" @endif>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Berat</label>
                                <div class="input-group">
                                    <input type="number" min="1" name="berat" id="berat" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->berat }}" @endif>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Gram
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="0" name="stock" id="stock" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->stock }}" @endif>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Minimal Order</label>
                                <input type="number" min="1" name="minimal_order" id="minimal_order" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->minimal_order }}" @endif>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control required-field text-uppercase" @if(!empty($master_produk)) value="{{ $master_produk->satuan }}" @endif>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" id="sku" class="form-control required-field" @if(!empty($master_produk)) value="{{ $master_produk->sku }}" @endif>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="text" name="harga_beli" id="harga_beli" class="form-control required-field" @if(!empty($master_produk)) value="{{ number_format($master_produk->harga_beli,0,',','.'); }}" @endif>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="text" name="harga_jual_b2c" id="harga_jual_b2c" class="form-control required-field" @if(!empty($master_produk)) value="{{ number_format($master_produk->harga_jual_b2c,0,',','.'); }}" @endif>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Harga Coret B2C</label>
                                <input type="text" name="harga_coret_b2c" id="harga_coret_b2c" class="form-control required-field">
                            </div>
                        </div> --}}
                        {{-- <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Harga Jual B2B</label>
                                <input type="text" name="harga_jual_b2b" id="harga_jual_b2b_id" class="form-control required-field" @if(!empty($master_produk)) value="{{ number_format($master_produk->harga_jual_b2b,0,',','.'); }}" @endif>
                            </div>
                        </div> --}}
                        {{-- <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Harga Coret B2B</label>
                                <input type="text" name="harga_coret_b2b" id="harga_coret_b2b" class="form-control required-field">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Upload Foto (Maksimal 10 Foto - Ukuran Maks 2 Mb)</label>
                                <div class="needsclick dropzone" id="document-dropzone" style="border:3px dashed #D3D6D9;padding: 10px;text-align: center;">
                                    <div class="fallback">
                                        <input name="file" type="file" id="my-dropzone" multiple class="required-field" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Link Video</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fab fa-youtube"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="url_video" id="url_video" class="form-control" @if(!empty($master_produk)) value="{{ $master_produk->url_video }}" @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <textarea class="summernote" name="deskripsi_produk" id="deskripsi_produk" width="100px">@if(!empty($master_produk)) {{ $master_produk->deskripsi_produk }} @endif</textarea>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-5 col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Harga Grosir B2C</h4>
                                    <div class="card-header-action">
                                        <button type="button" class="btn btn-warning" onclick="tambah_harga_grosir_b2c()"><i class="fa fa-plus mr-1"></i> Tambah Harga</button>
                                    </div>
                                </div>
                                <div class="card-body" id="place_harga_grosir_b2c">

                                    <input type="text" hidden id="number_harga_grosir_b2c" @if (!empty($master_produk_harga_grosir_b2c)) value="{{ count($master_produk_harga_grosir_b2c) ?? '0' }}" @endif>
                                    @if (!empty($master_produk_harga_grosir_b2c))
                                        @foreach ($master_produk_harga_grosir_b2c as $key => $item)
                                            <div class="row p-2" id="{{ 'row_b2c' . $key }}">
                                                <div class="col-12 col-md-5 col-lg-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label> >= </label>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Minimal pembelian" name="minimal_pembelian_grosir_b2c[]" id="minimal_pembelian_grosir_b2c" @if(!empty($item->minimal_pembelian)) value="{{ $item->minimal_pembelian }}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5 col-lg-5">
                                                    <input type="text" class="form-control" placeholder="Harga grosir" name="harga_grosir_b2c[]" id="{{ 'harga_grosir_b2c' . $key }}" @if(!empty($item->harga)) value="{{ number_format($item->harga,0,',','.'); }}" @endif>
                                                </div>
                                                <div class="col-2 col-md-1 col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-remove mt-1" id="{{ $key }}"> <i class="fa fa-trash"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="row" id="alert_harga_grosir_b2c" hidden>
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memilih Harga Grosir
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row" id="alert_harga_grosir_b2c">
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memilih Harga Grosir
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4>Harga Grosir B2B</h4>
                                    <div class="card-header-action">
                                        <button type="button" class="btn btn-warning" onclick="tambah_harga_grosir_b2b()"><i class="fa fa-plus mr-1"></i> Tambah Harga</button>
                                    </div>
                                </div>
                                <div class="card-body" id="place_harga_grosir_b2b">
                                    <input type="text" hidden id="number_harga_grosir_b2b" @if (!empty($master_produk_harga_grosir_b2b)) value="{{ count($master_produk_harga_grosir_b2b) ?? '0' }}" @endif>
                                    @if (!empty($master_produk_harga_grosir_b2b))
                                        @foreach ($master_produk_harga_grosir_b2b as $key => $item)
                                            <div class="row p-2" id="{{ 'row_b2b' . $key }}">
                                                <div class="col-12 col-md-5 col-lg-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label> >= </label>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Minimal pembelian" name="minimal_pembelian_grosir_b2b[]" id="minimal_pembelian_grosir_b2b" @if(!empty($item->minimal_pembelian)) value="{{ $item->minimal_pembelian }}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5 col-lg-5">
                                                    <input type="text" class="form-control" placeholder="Harga grosir" name="harga_grosir_b2b[]" id="{{ 'harga_grosir_b2b' . $key }}" @if(!empty($item->harga)) value="{{ number_format($item->harga,0,',','.'); }}" @endif>
                                                </div>
                                                <div class="col-2 col-md-1 col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-remove mt-1" id="{{ $key }}"> <i class="fa fa-trash"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="row" id="alert_harga_grosir_b2b" hidden>
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memilih Harga Grosir
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row" id="alert_harga_grosir_b2b">
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memilih Harga Grosir
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4>Master Properties</h4>
                                    <div class="card-header-action">
                                        <button type="button" class="btn btn-warning" onclick="tambah_master_properties()"><i class="fa fa-plus mr-1"></i> Tambah Properties</button>
                                    </div>
                                </div>
                                <div class="card-body" id="place_master_properties">
                                    <input type="text" id="number_master_properties" hidden @if (!empty($master_produk_properties)) value="{{ count($master_produk_properties) ?? '0' }}" @endif>
                                    @if (!empty($master_produk_properties))
                                        @foreach ($master_produk_properties as $key => $item)
                                            <div class="row p-2 row_properties" id="{{'row_properties' . $key}}">
                                                <div class="col-12 col-md-5 col-lg-5">
                                                    <select class="form-control select2" name="master_properties[]" id="{{'master_properties' . $key}}">
                                                        @foreach ($master_properties as $properties)
                                                            <option value="{{$properties->id}}" @if($properties->id == $item->master_properties->id) selected @endif >{{$properties->properties}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-10 col-md-6 col-lg-6">
                                                    <input type="text" name="value[]" id="value" class="form-control required-field" @if(!empty($item->value)) value="{{ $item->value }}" @endif>
                                                </div>
                                                <div class="col-2 col-md-1 col-lg-1">
                                                    <button type="button" class="btn btn-danger mt-1 btn-remove" id="{{$key}}"> <i class="fa fa-trash"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="row" id="alert_master_properties" hidden>
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memiliki properties
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <div class="row" id="alert_master_properties">
                                            <div class="col-12">
                                                <div style="border:2px dashed black;padding: 25px;text-align: center;">
                                                    Anda belum memiliki properties
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="submit" class="btn float-right btn-success"><i class="fa fa-save m-1"></i> Simpan</button>
                    <a href="/admin/produk/produk"><button type="button" class="btn float-left btn-secondary"><i class="fas fa-chevron-left"></i> Back</button></a>
                </div>
            </div>
        </div>
        </form>
   </div>
</div>

@if (!empty($master_produk->url_image))
    @foreach (array_reverse($master_produk->url_image) as $item)
        <input type="text" name="url_image[]" id="url_image" value="{{ $item }}">
    @endforeach
@endif

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
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            onkeyupRupiah('harga_beli');
            onkeyupRupiah('harga_jual_b2c');
            onkeyupRupiah('harga_jual_b2b_id');
            $('.select2').select2();
        });



        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone  = {
            // maxFiles: 2000,
            maxFiles: 10,
            maxFilesize: 2,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            url: "solaristamandatakom.com/admin/produk/produk/store-image",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {
                var APP_URL = {!! json_encode(url('/')) !!} + '/';
                var myDropzone = this;
                $('input[name^="url_image"]').each(function() {
                    let name_image = $(this).val() . split('/');
                    console.log(name_image);    
                    var mockFile = {
                        name: name_image,
                        type: 'image/jpeg',
                        status: Dropzone.ADDED,
                    };

                    $('#form_submit').append('<input type="text" hidden name="url_image[]" value="' + $(this).val() + '">')

                    uploadedDocumentMap[name_image] = $(this).val();

                    // Call the default addedfile event handler
                    myDropzone.emit("addedfile", mockFile);
                    
                    var str1 = $(this).val();
                    var str2 = "";
                    var img_url = '/berkas/master-produk/' + $(this).val();
                    // if(str1.indexOf(str2) != -1){
                    // }else{
                    //     var img_url = APP_URL + $(this).val();
                    // }

                    // And optionally show the thumbnail of the file:
                    myDropzone.emit("thumbnail", mockFile, img_url);

                    myDropzone.files.push(mockFile);
                });

                $('.dz-image img').attr('width', 125)
                $('.dz-image img').attr('height', 125);


                // $('input[name^="existing_files"]').each(function() {
                //     let name_image = $(this).val() . split('/');
                //     var mockFile = {
                //         size: 1000,
                //         name: name_image[2],
                //     };

                //     myDropzone.emit("addedfile", mockFile); //here I get the error
                //     myDropzone.emit("thumbnail", mockFile,  APP_URL + $(this).val());
                //     myDropzone.emit("success", mockFile);

                //     var existingFileCount = 1; // The number of files already uploaded
                //     myDropzone.options.maxFiles = myDropzone.options.maxFiles - existingFileCount;
                // });
            },
            success: function (file, response) {
                $('#form_submit').append('<input type="text" hidden name="url_image[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                console.log(name);
                $('form').find('input[name="url_image[]"][value="' + name + '"]').remove()
            }
        }

        let count_harga_grosir_b2b = $('#number_harga_grosir_b2b').val();
        let number_harga_grosir_b2b = $('#number_harga_grosir_b2b').val();

        let count_harga_grosir_b2c = $('#number_harga_grosir_b2c').val();
        let number_harga_grosir_b2c = $('#number_harga_grosir_b2c').val();

        let count_master_properties = $('#number_master_properties').val();
        let number_master_properties = $('#number_master_properties').val();

        function tambah_harga_grosir_b2b(){
            $('#place_harga_grosir_b2b').append(`
                <div class="row p-2" id="row_b2b${count_harga_grosir_b2b}">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <label> >= </label>
                                </div>
                            </div>
                            <input type="text" class="form-control required-field" placeholder="Minimal pembelian" name="minimal_pembelian_grosir_b2b[]" id="minimal_pembelian_grosir_b2b">
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <input type="text" class="form-control required-field" placeholder="Harga grosir" name="harga_grosir_b2b[]" id="harga_grosir_b2b${count_harga_grosir_b2b}">
                    </div>
                    <div class="col-2 col-md-1 col-lg-1">
                        <button type="button" class="btn btn-danger btn-remove mt-1" id="${count_harga_grosir_b2b}"> <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
            `);

            onkeyupRupiah("harga_grosir_b2b"+count_harga_grosir_b2b);

            count_harga_grosir_b2b++;
            number_harga_grosir_b2b++;
            if(number_harga_grosir_b2b > 0){
                $('#alert_harga_grosir_b2b').attr('hidden',true);
            }
        }

        $('#place_harga_grosir_b2b').on('click', '.btn-remove', function(e) {
            e.preventDefault();
            let button_id = $(this).attr("id");
            $('#row_b2b'+button_id+'').remove();

            number_harga_grosir_b2b--;
            console.log(number_harga_grosir_b2b);
            if(number_harga_grosir_b2b == 0){
                $('#alert_harga_grosir_b2b').attr('hidden',false);
            }
        });


        function tambah_harga_grosir_b2c(){
            $('#place_harga_grosir_b2c').append(`

                <div class="row p-2" id="row_b2c${count_harga_grosir_b2c}">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <label> >= </label>
                                </div>
                            </div>
                            <input type="text" class="form-control required-field" placeholder="Minimal pembelian" name="minimal_pembelian_grosir_b2c[]" id="minimal_pembelian_grosir_b2c">
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <input type="text" class="form-control required-field" placeholder="Harga grosir" name="harga_grosir_b2c[]" id="harga_grosir_b2c${count_harga_grosir_b2c}">
                    </div>
                    <div class="col-2 col-md-1 col-lg-1">
                        <button type="button" class="btn btn-danger btn-remove mt-1" id="${count_harga_grosir_b2c}"> <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
            `);

            onkeyupRupiah("harga_grosir_b2c"+count_harga_grosir_b2c);

            count_harga_grosir_b2c++;
            number_harga_grosir_b2c++;
            if(number_harga_grosir_b2c > 0){
                $('#alert_harga_grosir_b2c').attr('hidden',true);
            }
        }

        $('#place_harga_grosir_b2c').on('click', '.btn-remove', function(e) {
            e.preventDefault();
            let button_id = $(this).attr("id");
            $('#row_b2c'+button_id+'').remove();

            number_harga_grosir_b2c--;
            if(number_harga_grosir_b2c == 0){
                $('#alert_harga_grosir_b2c').attr('hidden',false);
            }
        });

        function tambah_master_properties(){

            if(!$('#id_master_kategori').val()){
                swal("Oops! Mohon isi kategori produk", { icon: 'warning', });
                return;
            }else{
                get_data_properties(count_master_properties);
                $('#place_master_properties').append(`
                    <div class="row p-2 row_properties" id="row_properties${count_master_properties}">
                        <div class="col-12 col-md-5 col-lg-5">
                            <select class="form-control select2 required-field" name="master_properties[]" id="master_properties${count_master_properties}">
                            </select>
                        </div>
                        <div class="col-10 col-md-6 col-lg-6">
                            <input type="text" name="value[]" id="value" class="form-control required-field">
                        </div>
                        <div class="col-2 col-md-1 col-lg-1">
                            <button type="button" class="btn btn-danger mt-1 btn-remove" id="${count_master_properties}"> <i class="fa fa-trash"></i> </button>
                        </div>
                    </div>
                `);

                $('.select2').select2();

                count_master_properties++;
                number_master_properties++;
                if(number_master_properties > 0){
                    $('#alert_master_properties').attr('hidden',true);
                }
            }


        }

        $('#place_master_properties').on('click', '.btn-remove', function(e) {
            e.preventDefault();
            let button_id = $(this).attr("id");
            $('#row_properties'+button_id+'').remove();

            number_master_properties--;
            if(number_master_properties == 0){
                $('#alert_master_properties').attr('hidden',false);
            }
        });

        function get_data_properties(count_master_properties){
            $.ajax({
                url: 'solaristamandatakom.com/master/data-master-properties-by-kategori/' + $('#id_master_kategori').val(),
                type: "GET",
                dataType: 'JSON',
                success: function( data, textStatus, jQxhr ){
                    $('#master_properties' + count_master_properties).append(`
                        <option selected disabled>- Pilih -</option>
                    `);
                    $.each(data.data, function( index, value ) {
                        $('#master_properties' + count_master_properties).append(`
                            <option value="${value.id}">${value.properties}</option>
                        `);
                    });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        }

        function getFile(id) {
            document.getElementById(id).click();
        }


        function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
        }

        $('#is_diskon_view').change(function(){
            $('.diskon').val('');
            if(!$(this).is(':checked')){
                $('.diskon').attr('readonly', true);
                $('#is_diskon').val('0');
            }else{
                $('.diskon').attr('readonly', false);
                $('#is_diskon').val('1');
            }
        });

        $('#is_ready_stock_view').change(function(){
            if(!$(this).is(':checked')){
                $('#is_ready_stock').val('0');
            }else{
                $('#is_ready_stock').val('1');
            }
        });


        $('#is_publish_view').change(function(){
            if(!$(this).is(':checked')){
                $('#is_publish').val('0');
            }else{
                $('#is_publish').val('1');
            }
        });

        function table_subkategori(){
            // $('#place_subkategori').html('');
            // $('#master_subkategori_id_view').val('');
            // $('master_subkategori_id').val('');
            // $('#alert_subkategori').attr('hidden',false);

            // $('.row_properties').remove();
            // $('#alert_master_properties').attr('hidden',false);

            var tb = $('#tb_subkategori').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'solaristamandatakom.com/master/datatables-subkategori-by-kategori/' + $('#id_master_kategori').val(),
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

                    $('td:eq(5)', row).html(`
                        <button type="button" class="btn btn-success btn-sm mr-1" onclick="terpilih_subkategori(${data.id})"><i class="fa fa-check"></i></button>
                    `);
                }
            });
        }

        function terpilih_subkategori(id){
            $.ajax({
                url: 'solaristamandatakom.com/master/data-urutan-subkategori-by-id/' + id,
                type: "GET",
                dataType: 'JSON',
                beforeSend: function ( xhr ) {
                    $("#modal_loading").modal('show');
                },
                success: function( data, textStatus, jQxhr ){

                    $('#place_subkategori').html('');
                    $('#master_subkategori_id_view').val('');
                    $('master_subkategori_id').val('');

                    $('#alert_subkategori').attr('hidden',false);

                    $('.row_properties').remove();
                    $('#alert_master_properties').attr('hidden',false);

                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    $('#alert_subkategori').attr('hidden',true);
                    let color = ['danger', 'warning', 'info', 'primary', 'success'];
                    let subkategori = '';
                    $('#place_subkategori').empty();
                    $.each(data, function( index, value ) {
                        $('#place_subkategori').append(`
                            <span class="badge badge-${color[index]}">${value.subkategori}</span>
                        `);

                        subkategori = value.subkategori;
                    });
                    $('#master_subkategori_id_view').removeClass("is-invalid");
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

            if(!$('#id_master_kategori').val()){
                swal("Oops! Harap memilih Kategori terlebih dahulu", {  icon: 'warning', });
                return;
            }

            $('#modal_subkategori').modal('show');

            table_subkategori();
        }
    </script>
@endsection
