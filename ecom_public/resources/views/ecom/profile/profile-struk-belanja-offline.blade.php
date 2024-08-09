@extends("partial.app");

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/dropzonejs/dropzone.css') }}">
    <style>
        .upload-image-komplain-container{
            width: 100%!important;
        }
        .file_drop_box {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: fit-content;
        padding: 20px 40px 20px;
        box-shadow: 0 2px 20px #0001, 0 2px 6px #0001;
        border-radius: 10px;
        border: 1px solid #0002;
        position: relative;
        margin: 25px auto;
        }

        .file_drop_box .icon {
        font-size: 35px;
        color: #0002;
        margin-bottom: 30px;
        }

        .file_drop_box .select_file {
        padding: 5px 15px;
        white-space: nowrap;
        font-size: 16px;
        background-color: #03a9f4;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
        box-shadow: 0 2px 6px #0004;
        border-radius: 5px;
        position: relative;
        z-index: 1;
        transition: 0.3s ease-in-out;
        }
        .file_drop_box .select_file:hover {
        box-shadow: 0 2px 20px #03a9f4;
        background-color: #2196f3;
        }
        .file_drop_box .select_file > i {
        line-height: 0;
        font-size: 35px;
        }

        .file_drop_box p {
        margin: 25px 0;
        color: #555;
        font-size: 20px;
        }

        .file_drop_box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        }

        @media (max-width: 400px){
            .file_drop_box{
                padding: 20px 20px 20px;
                margin-bottom: 0;
            }
        }
    </style>
@endsection

@section("content")
<div class="row sticky-header-next-sec" style="margin: 0!important">
    <!-- Start Terms & Condition page -->
    <div class="content-container mt-4 col-12 col-md-8 offset-md-2" style="padding-bottom: 1%">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Struk Belanja Offline</h5>
            <p style="overflow: hidden; white-space: nowrap">Foto struk anda untuk mendapatkan extra poin</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body">
            <div class="container">
                <form id="form_upload" action="/profile/struk-belanja-offline/store" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="text" class="required-field" placeholder="Nominal Belanja" name="nominal_belanja" id="nominal_belanja" onkeyup="return onkeyupRupiah(this.id)">
                        </div>
                        <div class="container d-flex justify-content-center align-items-center">
                            <img id="blah" src="{{ asset('front/assets/images/custom-image/struk-pembelian.png') }}" alt="your image" class="img-fluid" style="max-height: 500px"/>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 upload-image-komplain-container">
                                <label class="file_drop_box">
                                    <span class="select_file">
                                    <i class="ion-upload"></i>
                                    Upload Image
                                    </span> 
                                    <input
                                    type="file" name="upload_image"
                                    onchange="readURL(this);"
                                    multiple
                                    />
                                </label>
                        </div>
                        
                        <div class="syarat-ketentuan">
                            <div class="container-fluid mt-5 content-container-2">
                            <h5 class="fw-bold">Syarat dan Ketentuan Upload Struk Offline</h5>
                            <div class="col-12">
                                <div class="container-fluid p-3 rounded" style="background-color: #f4f4f4">
                                <ul>
                                    <li><p>1. Upload Struk belanja anda pada seluruh gerai offline Kharisma Online untuk mendapatkan bonus poin.</p></li>
                                    <li><p>2. Foto yang kami terima hanya yang berekstensi JPG, JPEG, PNG.</p></li>
                                </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row mt-4">
                        <button type="submit" class="btn btn-danger" id="button_submit" hidden>Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("js")
<script>
    function countTextArea(val){
        $("#count-display").text(val.value.length + "/2000")
    }

    function readURL(input) {
        var fuData = input;
        var FileUploadPath = fuData.value;

        //To check if user upload any file
        if (FileUploadPath == '') {
            iziToast.error({
                title: 'Error!',
                message: 'Please upload an image. ',
                position: 'topRight'
            });
        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

            //The file uploaded is an image

            if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

                // To Display
                if (fuData.files && fuData.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(fuData.files[0]);
                }

                $('#button_submit').prop('hidden', false);
            } else {
                iziToast.error({
                    title: 'Error!',
                    message: 'Photo only allows file types of PNG, JPG, JPEG. ',
                    position: 'topRight'
                });
            }
        }
    }

</script>
@endsection
