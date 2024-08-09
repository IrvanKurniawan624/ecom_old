@extends('partial.app')

@section("css")
    <style>
        #edit_modal .ec-vendor-upload-detail input, #edit_modal .ec-vendor-upload-detail textarea, #edit_modal .ec-vendor-upload-detail select{
            border: 1px solid var(--base-color)!important;
        }

        @media(max-width: 500px){
            #edit_modal .ec-vendor-upload-detail input{
                padding: 0 0 0 10px!important;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Modal -->
    <div id="edit_modal">
        <div class="modal-dialog" id="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <form id="form_upload" action="/profile/store-update" method="POST" autocomplete="off">
                            <div class="ec-vendor-block-detail">
                                <div class="thumb-upload">
                                    <div class="thumb-edit">
                                        <input type="file" id="upload_image" name="upload_image" class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                        <label>
                                            <img src="{{ asset('front/assets/images/icons/edit.svg') }}" class="svg_img header_svg" alt="edit" />
                                        </label>
                                    </div>
                                    <div class="thumb-preview ec-preview">
                                        <div class="image-thumb-preview">
                                            <img class="image-thumb-preview ec-image-preview v-img profile-edit-image"
                                                src="{{ isset($data->url_image) ? asset('/') . $data->url_image : asset('front/assets/images/user/1.jpg') }}" alt="edit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-vendor-upload-detail">
                                <div class="row">
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">Nama</label>
                                        <input type="text" id="id" name="id" @if(isset($data)) value="{{ $data->id }}" hidden @endif>
                                        <input type="text" id="nama" name="nama" class="form-control required-field" @if(isset($data)) value="{{ $data->nama }}" @endif>
                                    </div>
                                    <div class="col-md-6 space-t-15">
                                        <label class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control required-field" @if(isset($data)) value="{{ $data->email }}" @endif>
                                    </div>
                                    <div class="col-md-6 space-t-15">
                                        <label class="form-label">No Telepon</label>
                                        <input type="text" id="no_telepon" name="no_telepon" class="form-control required-field" @if(isset($data)) value="{{ $data->no_telepon }}" @endif onkeypress="return onKeypressAngka(event,false);">
                                    </div>
                                    <span class="col-md-6 space-t-15">
                                        <label>Tanggal Lahir</label>
                                        <input type="text" class="form-control required-field"  @if(isset($data)) value="{{ \Carbon\Carbon::parse( $data->tanggal_lahir )->isoFormat('D MMMM Y') }}" @endif style="background-color: #E8E8E6" readonly/>
                                    </span>
                                    <span class="col-md-6 space-t-15">
                                        <label>Agama</label>
                                        <div class="position-relative">
                                            <select name="agama" id="agama" class="form-control required-field selectric">
                                                <option value="Islam" @if($data->agama == 'Islam') selected @endif>Islam</option>
                                                <option value="Protestan" @if($data->agama == 'Protestan') selected @endif>Protestan</option>
                                                <option value="Katolik" @if($data->agama == 'Katolik') selected @endif>Katolik</option>
                                                <option value="Hindu" @if($data->agama == 'Hindu') selected @endif>Hindu</option>
                                                <option value="Budha" @if($data->agama == 'Budha') selected @endif>Budha</option>
                                                <option value="Khonghucu" @if($data->agama == 'Khonghucu') selected @endif>Khonghucu</option>
                                            </select>
                                            <i class="fas fa-sort-down" style="position: absolute; right: 15px; top: 32%;"></i>
                                        </div>
                                    </span>
                                    <div class="col-md-12 space-t-15">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control required-field" id="alamat" name="alamat" cols="30" rows="5">@if(isset($data)){{ $data->alamat }}@endif</textarea>
                                    </div>
                                    @if (isset($data) && $data->social_type == null)
                                        <div class="col-md-6 space-t-15">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password" id="new_password" name="new_password" class="form-control">
                                        </div>
                                        <div class="col-md-6 space-t-15">
                                            <label class="form-label">Ulangi Password Baru</label>
                                            <input type="password" id="retype_new_password" name="retype_new_password" class="form-control">
                                        </div>
                                        <div class="col-md-12 space-t-15">
                                            <span style="color: red">tidak perlu di isi apabila tidak ingin merubah password</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12 text-center" id="user-profile-edit-button">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-danger btn-block mt-1">Back</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection
