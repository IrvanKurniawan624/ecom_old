@php
    use App\Helpers\App;
@endphp

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="x-ua-compatible" content="ie=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

     <title>SIMANHURA.</title>
     <meta name="keywords" content="pemerintah, bahan baku, madiun, hutan rakyat, hutan, simanhura" />
     <meta name="description" content="SISTEM INFORMASI MANJEMEN HUTAN RAKYAT">
     <meta property="image" content="https://SIMANHURA.com/front/assets/images/custom-image/logo_new.png">

    <!-- site Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('front\assets\images\custom-image\favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('front\assets\images\custom-image\favicon-16x16.png') }}" sizes="16x16" />
    <meta name="msapplication-TileImage" content="assets/images/favicon/favicon.png') }}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/vendor/ecicons.min.css') }}" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/countdownTimer.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.css') }}" />

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-additional.css') }}">

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">

    {{-- <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">

    <style>
        .ec-login-wrapper .ec-login-container .ec-login-form .btn {
            width:100% !important;
            margin: !important;
        }

        form input, textarea, .selectric{
            border: 2px solid var(--base-color)!important;

        }
    </style>

</head>
<body class="sticky-header-next-sec">
    <div id="ec-overlay"><span class="loader_img"></span></div>

    <!-- Start Register -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row" id="place_register">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Register</h2>
                        <h2 class="ec-title">Register</h2>
                        <p class="sub-title mb-3">Selamat datang dan Silahkan mendaftar di SIMANHURA</p>
                    </div>
                </div>
                <div class="ec-register-wrapper">
                    <div class="ec-register-container">
                        <div class="ec-register-form">
                            <form id="form" autocomplete="off">
                                <input type="text" name="status_otp" id="status_otp" value="0" hidden>
                                <span class="ec-register-wrap">
                                    <label>Nama</label>
                                    <input type="text" class="form-control required-field" name="nama" placeholder="Isikan dengan nama anda"/>
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Email</label>
                                    <input type="email" class="form-control required-field"  name="email" placeholder="Isikan dengan email anda"/>
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>No Telepon <span style="color: red">Ex: 081xxxx</span></label>
                                    <input type="text" class="form-control required-field"  name="no_telepon" id="no_telepon" value="0" placeholder="Isikan dengan no telepon anda format 081xxxx" onkeypress="return onKeypressAngka(event,false);"/>
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control required-field datepicker"  name="tanggal_lahir" id="tanggal_lahir" placeholder="Isikan dengan tanggal lahir anda"/>
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Agama</label>
                                    <select name="agama" id="agama" class="form-control required-field selectric">
                                        <option value="Islam">Islam</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                    </select>
                                </span>
                                <span class="ec-register-wrap">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control required-field"  name="alamat" placeholder="Isikan dengan Alamat anda"/>
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Password &nbsp; <span><i class="far fa-eye-slash" id="eye"></i></span></label>
                                    <input type="password" class="form-control required-field"  name="password" id="password" placeholder="Password Anda"/>

                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Ulangi Password &nbsp; <span><i class="far fa-eye-slash" id="eye_ulangi"></i></span></label>
                                    <input type="password" class="form-control required-field"  name="ulangi_password" id="ulangi_password" placeholder="Ulangi Password Anda"/>
                                </span>
                                <span class="ec-register-wrap pt-1">
                                    <center>
                                        <span>**Dengan daftar kamu telah menyetujui br <b>Syarat dan Ketentuan</b> serta <b>Kebijakan Privasi</b> kami</span>
                                    </center>
                                </span>


                                <span class="ec-register-wrap">
                                <div id="recaptcha-container" class="mt-2"></div>
                                </span>
                                <span class="ec-register-wrap ec-register-btn">
                                    <button class="btn btn-primary" type="submit" id="button_register">Register</button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="place_verification" style="display: none;">
                <div class="col-md-12 text-center" style="margin-top:20px">

                    <div class="section-title">
                        <h2 class="ec-bg-title">VERIFIKASI</h2>
                        <h2 class="ec-title">Verifikasi Nomor HP Anda</h2>
                    </div>
                </div>

                <div class="ec-register-wrapper">
                    <div class="ec-register-container">
                        <div class="ec-register-form">
                        <div class="alert alert-danger" id="error" style="display: none;"></div>
                        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
                        <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
                            <form id="form_submit" action="/register" method="post">
                                <span class="ec-register-wrap">
                                    <label>OTP SMS</label>
                                    <input type="text" class="form-control required-field" id="verification" placeholder="OTP SMS" style="background-color:#E8E8E6"/>
                                </span>
                                <span class="ec-register-wrap ec-register-btn">
                                    <button class="btn btn-success" type="button" id="button_verify" onclick="verify();">Verifikasi</button>
                                    <a class="text-center mt-4" style="cursor:pointer;" onclick="click_ganti_nomor_telepon()">Ganti Nomor Telepon</a>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- End Register -->

    <!-- Footer Start -->
    <footer class="ec-footer section-space-mt">
        <div class="footer-container">
            <div class="footer-top section-space-footer-p">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-3 ec-footer-contact">
                            <div class="ec-footer-widget ec-footer-logo">
                                <div class="ec-footer-logo"><a href="/" class="d-flex justify-content-center"><img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                            alt="" style="width: 53%"><img class="dark-footer-logo" src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                            alt="Site Logo" style="display: none;" /></a></div>
                                <h4 class="d-flex justify-content-center jatim-logo">
                                    <img src="{{ asset('front/assets/images/project/jatim-logo.png') }}" alt="" srcset="">
                                </h4>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-2 ec-footer-info">
                            <div class="ec-footer-widget">
                                <h4 class="ec-footer-heading">Kategori</h4>
                                <div class="ec-footer-links">
                                    <ul class="align-items-center">
                                        @foreach (App::get_master_package() as $item)
                                            <li class="ec-footer-link"><a href="/produk?{{http_build_query(['package' => $item->package_slug, 'filter' => 'all'])}}">{{ $item->package }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 ec-footer-account">
                            <div class="ec-footer-widget">
                                <h4 class="ec-footer-heading">Tentang Kami</h4>
                                <div class="ec-footer-links">
                                    <p>SIMANHURA</p>
                                    <p>SISTEM INFORMASI MANJEMEN HUTAN RAKYAT<br></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 ec-footer-news">
                            <div class="ec-footer-widget">
                                <h4 class="ec-footer-heading">Metode Pengiriman</h4>
                                <div class="ec-footer-links">
                                    <img src="{{ asset('front/assets/images/icons/pengiriman1.png') }}" alt="">
                                    <img src="{{ asset('front/assets/images/icons/pengiriman2.png') }}" alt="" style="margin-top:1%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Footer social Start -->
                        <div class="col text-left footer-bottom-left">
                            <div class="footer-bottom-social">
                                <span class="social-text text-upper">Follow us on:</span>
                                <ul class="mb-0">
                                    <li class="list-inline-item"><a class="hdr-facebook" href="#"><i class="ecicon eci-facebook"></i></a></li>
                                    <li class="list-inline-item"><a class="hdr-twitter" href="#"><i class="ecicon eci-twitter"></i></a></li>
                                    <li class="list-inline-item"><a class="hdr-instagram" href="#"><i class="ecicon eci-instagram"></i></a></li>
                                    <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i class="ecicon eci-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Footer social End -->
                        <!-- Footer Copyright Start -->
                        <div class="col text-center footer-copy">
                            <div class="footer-bottom-copy ">
                                <div class="ec-copy">Copyright © 2022 <a class="site-name text-upper"
                                        href="#">SIMANHURA.com<span></span></a></div>
                            </div>
                        </div>
                        <!-- Footer Copyright End -->
                        <!-- Footer payment -->
                        <div class="col footer-bottom-right">
                            <div class="footer-bottom-payment d-flex justify-content-end">
                                <div class="payment-link">
                                    <img src="{{ asset('front/assets/images/icons/payment-new.png') }}" alt="">
                                </div>

                            </div>
                        </div>
                        <!-- Footer payment -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->


    @include('partial.mobile-footer-menu')

    <!-- Vendor JS -->
    <script src="{{ asset('front/assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/vendor/popper.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/vendor/modernizr-3.11.2.min.js')}}"></script>

    <!--Plugins JS-->
    <script src="{{ asset('front/assets/js/plugins/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/countdownTimer.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/scrollup.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.zoom.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/slick.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/infiniteslidev2.js')}}"></script>
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js')}}"></script>
    <!-- Google translate Js -->
    <script src="{{ asset('front/assets/js/vendor/google-translate.js')}}"></script>

    {{-- <script src="{{asset('assets/modules/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> --}}
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script>

        $(document).ready(function(){
            $('#agama').selectric();
        })

        $('#eye').on('click', function(){
            $(this).toggleClass('fas fa-eye');
            $(this).toggleClass('far fa-eye-slash');
            $('#password').attr("type") == "password" ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
        });

        $('#eye_ulangi').on('click', function(){
            $(this).toggleClass('fas fa-eye');
            $(this).toggleClass('far fa-eye-slash');
            $('#ulangi_password').attr("type") == "password" ? $('#ulangi_password').attr('type', 'text') : $('#ulangi_password').attr('type', 'password');
        });

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
        }
    </script>
    <!-- Main Js -->
    <script src="{{ asset('front/assets/js/vendor/index.js')}}"></script>
    <script src="{{ asset('front/assets/js/main.js')}}"></script>

    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script type="text/javascript">

        $('#no_telepon').on('input', function() {
            const value = $(this).prop('value');
            $(this).prop('value', value.padStart(1, '0'));
        })

        function click_ganti_nomor_telepon(){
            $('#place_register').show();
            $('#place_verification').hide();
        }

        $('#form').submit(function(e){

            $('#button_register').attr('disabled', true);
            $('#button_register').html('<i class="fas fa-spinner fa-spin"></i>');

            e.preventDefault();

            var form_id = $(this).attr("id");
            if(check_required(form_id) === false){
                $('#button_register').attr('disabled', false);
                $('#button_register').html('REGISTER');
                Swal.fire('','Mohon isi field kosong','warning');
                return;
            }

            $("#modal_loading").modal('show');
            $.ajax({
                url : "/register",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(response){

                    $('#button_register').attr('disabled', false);
                    $('#button_register').html('REGISTER');

                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status === 200){
                        $('#place_register').hide();
                        // sendOTP(response.no_telepon);
                    }else if(response.status == 201){
                        Swal.fire('Good job!',response.message,'success');
                        setTimeout(function () {   window.location.href = response.link; }, 1500);
                    }else{
                        Swal.fire('Oops!',response.message,'error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){

                    $('#button_register').attr('disabled', false);
                    $('#button_register').html('REGISTER');

                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>

     <script>

        // const firebaseConfig = {
        //     apiKey: "AIzaSyDJsD3UNiQ0aDW-HRtz8YK13hg7sasmBYo",
        //     authDomain: "e-commerce-kharisma.firebaseapp.com",
        //     projectId: "e-commerce-kharisma",
        //     storageBucket: "e-commerce-kharisma.appspot.com",
        //     messagingSenderId: "442343032577",
        //     appId: "1:442343032577:web:0b3c5c9457f88383f2bd00",
        //     measurementId: "G-5L3VKN9K6E"
        // };
        // firebase.initializeApp(firebaseConfig);
    </script>

     <script type="text/javascript">
        window.onload = function () {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
                "recaptcha-container", {
                    size: "invisible"
                }
            );
            recaptchaVerifier.render();
        }

        // function sendOTP(no_telepon) {
        //     firebase.auth().signInWithPhoneNumber(no_telepon, window.recaptchaVerifier).then(function (confirmationResult) {
        //         window.confirmationResult = confirmationResult;
        //         coderesult = confirmationResult;
        //         $('#place_verification').show();
        //         $("#successAuth").text("We Have to Send code verification to your mobile number");
        //         $("#successAuth").show();
        //     }).catch(function (error) {
        //         $("#error").text(error.message);
        //         $("#error").show();
        //     });
        // }

        // function verify() {
        //     var code = $("#verification").val();

        //     if( code.length === 0 ) {
        //         Swal.fire('Oops!','Field OTP tidak boleh kosong','error');
        //         return;
        //     }

        //     $('#button_verify').attr('disabled', true);
        //     $('#button_verify').html('<i class="fas fa-spinner fa-spin"></i>');

        //     coderesult.confirm(code).then(function (result) {
        //         var user = result.user;

        //         // update user active
        //         $('#status_otp').val('1');
        //         $("#modal_loading").modal('show');
        //         $.ajax({
        //             url : "/register",
        //             type: "POST",
        //             data: $('#form').serialize(),
        //             dataType: "JSON",
        //             success: function(response){
        //                 $('#button_verify').attr('disabled', false);
        //                 $('#button_verify').html('Verifikasi');
        //                 setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
        //                 if(response.status === 200){
        //                     $('#place_register').hide();
        //                     sendOTP(response.no_telepon);
        //                 }else if(response.status == 201){
        //                     Swal.fire('Pendaftaran berhasil!','Authentikasi Berhasil akun anda telah aktif','success');
        //                     setTimeout(function () {  window.location.href = response.link; }, 500);

        //                 }else{
        //                     Swal.fire('Oops!','Kode OTP tidak valid, silahkan coba lagi','error');
        //                 }
        //             },
        //             error: function (jqXHR, textStatus, errorThrown){
        //                 $('#button_verify').attr('disabled', false);
        //                 $('#button_verify').html('Verifikasi');
        //                 setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
        //                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
        //             }
        //         });

        //         // $("#successOtpAuth").text("Authentikasi Berhasil akun anda telah aktif");
        //         // $("#successOtpAuth").show();
        //     }).catch(function (error) {

        //         $('#button_verify').attr('disabled', false);
        //         $('#button_verify').html('Verifikasi');

        //         $("#error").text(error.message);
        //         $("#error").show();
        //     });
        // }

    </script>

    @include('scriptjs')

</body>
</html>
