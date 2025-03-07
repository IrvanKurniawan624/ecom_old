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

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">

    <style>
        form input, textarea{
            border: 2px solid #096A2E!important;

        }
        .ec-login-wrapper .ec-login-container .ec-login-form .btn {
            width:100% !important;
            margin: !important;
        }
        #login_logo{
            width: 20%;
        }

        @media (max-width: 992px){
            .reverse-login{
                flex-direction: column-reverse;
            }
            #login_logo{
                width: 40%;
            }
        }

        @media(max-width: 415px){
            #login_logo{
                width: 50%!important;
            }
        }
    </style>

</head>
<body class="sticky-header-next-sec">
    <div id="ec-overlay"><span class="loader_img"></span></div>

    <!-- Ec login page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center" style="margin-bottom: 30px">
                    <a href="/"><img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}" id="login_logo" alt="" srcset=""></a>
                </div>
                <div class="ec-login-wrapper">
                    <div class="ec-login-container">
                        <div class="ec-login-form">
                            <form id="form">
                                <div class="section-title text-center">
                                    <h2 class="ec-bg-title">Login Telepon</h2>
                                    <h2 class="ec-title">Login Telepon</h2>
                                </div>
                                <span class="ec-login-wrap">
                                    <label>No Telepon*</label>
                                    <input type="text" class="required-field" name="no_telepon" id="no_telepon" value="0" maxlength="12" onkeypress="return onKeypressAngka(event,false);"/>
                                </span>
                                <span class="ec-login-wrap position-relative" id="place_otp" hidden>
                                    <label>Kode OTP*</label>
                                    <input type="text" name="otp" id="otp" minlength="1" maxlength="6" placeholder="Enter OTP" required />
                                </span>
                                <span class="ec-login-wrap ec-login-fp row reverse-login">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <button type="button" onclick="click_kirim_otp()" class="btn btn-secondary" id="kirim_otp">Kirim OTP</button>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12" id="place_login" hidden>
                                        <button class="btn btn-primary" type="submit" id="button_login">Login</button>
                                    </div>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
        }
    </script>
    <!-- Main Js -->
    <script src="{{ asset('front/assets/js/vendor/index.js')}}"></script>
    <script src="{{ asset('front/assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">

        $('#no_telepon').on('input', function() {
            const value = $(this).prop('value');
            $(this).prop('value', value.padStart(1, '0'));
        })

        function click_kirim_otp(){

            if($('#no_telepon').val().length == 0){
                Swal.fire('Oops!','Telepon tidak boleh kosong','error');
            }

            $('#kirim_otp').attr('disabled', true);
            $('#kirim_otp').html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url : "/login-telepon/send-whatsapp",
                type: "POST",
                data: {
                    'no_telepon': $('#no_telepon').val(),
                },
                dataType: "JSON",
                success: function(response){
                    $('#kirim_otp').attr('disabled', false);
                    $('#kirim_otp').html('KIRIM OTP');
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status === 200){
                        $('#place_otp').attr('hidden',false);
                        $('#place_login').prop('hidden', false);
                        Swal.fire('Good job!',response.message,'success');
                    }else{
                        Swal.fire('Oops!',response.message,'error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                        $('#kirim_otp').attr('disabled', false);
                        $('#kirim_otp').html('KIRIM OTP');
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        }

        $('#form').submit(function(e){
           e.preventDefault();

            $('#button_login').attr('disabled', true);
            $('#button_login').html('<i class="fas fa-spinner fa-spin"></i>');

           $.ajax({
              url : "/login-telepon",
              type: "POST",
              data: $('#form').serialize(),
              dataType: "JSON",
              success: function(response){
                  $('#button_login').attr('disabled', false);
                  $('#button_login').html('LOGIN');
                 setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 if(response.status === 201){
                    Swal.fire('Good job!',response.message,'success');
                    setTimeout(function () {  window.location.href = response.link }, 2000);
                 }else{
                    Swal.fire('Oops!',response.message,'error');
                 }
              },
              error: function (jqXHR, textStatus, errorThrown){
                    $('#button_login').attr('disabled', false);
                    $('#button_login').html('LOGIN');
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


</body>
</html>
