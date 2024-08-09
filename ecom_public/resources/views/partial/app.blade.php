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
    <link rel="stylesheet" href="{{ asset('front/assets/css/pages/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('front/assets/css/pages/owl.theme.default.min.css') }}" />

     <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo1.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-additional.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css') }}" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">

    <!-- custom -->
    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <style>

        @media (min-width: 576px) and (max-width: 992px){
            #before-main{
                margin-top: 175px!important;
            }

            .ec-page-content{
                margin-top: 0!important;
            }
        }

        @media
        only screen and (-webkit-min-device-pixel-ratio: 1.5),
        only screen and (-o-min-device-pixel-ratio: 3/2),
        only screen and (min--moz-device-pixel-ratio: 1.5),
        only screen and (min-device-pixel-ratio: 1.5){

        html,
        body{
            width:100%;
            overflow-x:hidden;
        }

        }

        form input, textarea, .selectric{
            border: 2px solid #096A2E!important;

        }

        @media (max-width: 575px){
            .header-logo a img{
                width: 50%;
            }
        }

        @media (min-width: 575px) and (max-width: 992px){
            .dropdown-menu.show{
                position: fixed!important;
                top: 55px!important;
                right: unset!important;
            }
            #dropdown-md{
                display: unset!important;   
            }
            .mobile-header-number{
                top: 8px!important;
            }
        }

        .old-price{
            color: #fa4747b3!important;
            font-weight: 700;
            font-family: "Montserrat";
            letter-spacing: 0;
        }

        .notification-list li{
            padding: 2px 10px!important;
            text-align: start!important;
        }

        .class-customer {
            background: linear-gradient(to right, #314755 0%, #26a0da  51%, #314755  100%);
        }

        .class-business {
            background: linear-gradient(to right, #77A1D3 0%, #79CBCA  51%, #77A1D3  100%);
        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        @media(max-width: 991px){
            .ec-footer-logo a{
                display: flex!important;
                justify-content: center;
            }
        }

    </style>

    @include('style-additional')

    @yield('css')

</head>
<body class="blog_page sticky-header-next-sec">
    <div id="ec-overlay"><span class="loader_img"></span></div>

    
    <!-- Header Start -->
    
    @include("partial.header")

    <!-- EC Main Menu Start -->
    @include("partial/main-menu")
    <!-- Ec Main Menu End -->

    <!-- ekka Mobile Menu Start -->
    @include("partial/mobile-main-menu")
    <!-- ekka Mobile Menu End -->

    <!-- Header End  -->

    @include('partial/cart')

    <!-- Content page -->
    <div id="before-main"></div>
    <div id="main">
        @yield('content')
    </div>

    @yield('modal')

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
                                    {{-- <img src="{{ asset('front/assets/images/icons/pengiriman3.png') }}" alt=""> --}}
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

    <!-- Modal Load-->
    <div class="modal fade" role="dialog" id="modal_loading" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pt-0" style="background-color: #FAFAF8; border-radius: 6px;">
                <div class="text-center">
                    <img style="border-radius: 4px; height: 140px;" src="{{ asset('assets/img/project/icon/loader.gif') }}" alt="Loading">
                    <h6 style="position: absolute; bottom: 10%; left: 37%;" class="pb-2">Mohon Tunggu..</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Floating Button -->
    <div class="ec-cart-float">
        <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
            <div class="header-icon"><img src="{{ asset('front/assets/images/icons/cart.svg') }}" class="svg_img header_svg" alt="" /></div>
            <span class="ec-cart-count cart-count-lable">0</span>
        </a>
    </div>
    <!-- Cart Floating Button end -->

    <!-- Vendor JS -->
    <script src="{{ asset('front/assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery-ui.min.js')}}"></script>
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
    <script src="{{ asset('front/assets/js/vendor/owl.carousel.min.js')}}"></script>
    <!-- Google translate Js -->
    <script src="{{ asset('front/assets/js/vendor/google-translate.js')}}"></script>

    <!-- Main Js -->
    <script src="{{ asset('front/assets/js/vendor/index.js')}}"></script>
    <script src="{{ asset('front/assets/js/main.js')}}"></script>

        <!-- Custom -->
    <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('front/assets/js/index.umd.min.js') }}"></script>

    @include('scriptjs')

    <!--Start of Tawk.to Script-->

    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/634d5b4db0d6371309c9f66f/1gfj2pa1b';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script>
        PullToRefresh.init({
            mainElement: '#main',
            onRefresh: function() { location.reload() }
        });

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
        }

        $(document).ready(function(){
            get_data_cart();
            get_count_cart();
            $('.place_alert_search').attr('hidden', true);
            if ($(window).width() < 960) {
                $('.for_website').attr('hidden', true);
                $('.for_mobile').attr('hidden', false);
            }
            else {
                $('.for_website').attr('hidden', false);
                $('.for_mobile').attr('hidden', true);
            }
        });

        function get_data_cart(){
            $.ajax({
                    url: '/get_data_cart',
                    type: "GET",
                    dataType: 'JSON',
                    success: function( response, textStatus, jQxhr ){
                    let total_harga_global = 0;
                    $('#place_cart_global').empty();
                    $.each( response, function( key, value ) {

                        var str1 = value.master_produk.url_image[0];
                        var img_url = '/commerce/ecom_seller_final/public/berkas/master-produk/' + value.master_produk.url_image[0];
                        

                        console.log(img_url);

                        total_harga_global += parseInt(value.master_produk.harga_jual) * parseInt(value.quantity);
                        $('#place_cart_global').append(`
                                <li id="li_${value.id}">
                                <a href="/produk/${value.master_produk.nama_produk_slug}" class="sidekka_pro_img"><img
                                            src="${img_url}" alt="product"></a>
                                <div class="ec-pro-content">
                                    <a href="/produk/${value.master_produk.nama_produk_slug}" class="cart_pro_title">${value.master_produk.nama_produk_desc}</a>
                                    <span class="cart-price"><span>${fungsiRupiah(value.master_produk.harga_jual)}</span> x ${value.quantity}</span>
                                    <a href="javascript:void(0)" class="remove" data-id="${value.id}">×</a>
                                </div>
                                </li>
                        `);
                    })

                    $('#total_belanja').html(fungsiRupiah(total_harga_global));

                    if($(".eccart-pro-items li").length == 0){
                        $('.eccart-pro-items').html('<li><p class="emp-cart-msg">Your cart is empty!</p></li>');
                        $('#button_checkout').addClass("disabled");
                    }
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    },
            });
        }

        function get_count_cart(){
            $.ajax({
                    url: '/count_cart',
                    type: "GET",
                    dataType: 'JSON',
                    success: function( response, textStatus, jQxhr ){
                    $('#count_cart').html(response);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                    },
            });
        }

        function add_to_cart(id){

            var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
            if(!loggedIn){
                    window.location.href = '/login';
            }

            $.ajax({
                    url: '/cart/store/' + id,
                    type: "GET",
                    dataType: 'JSON',
                    success: function( data, textStatus, jQxhr ){
                    if(data.status == 200){
                        iziToast.success({
                                title: 'Success!',
                                message: data.message,
                                position: 'topRight'
                        });
                        $('.count_cart').html(data.data);
                        $('#button_checkout').removeClass('disabled');
                    }else{
                        iziToast.error({
                                title: 'Oops!',
                                message: data.message,
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

        function add_to_wishlist(id){

            var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
            if(!loggedIn){
                    window.location.href = '/login';
            }

            $.ajax({
                    url: '/wishlist/store/' + id,
                    type: "GET",
                    dataType: 'JSON',
                    success: function( data, textStatus, jQxhr ){
                    if(data.status == 200){
                        iziToast.success({
                                title: 'Success!',
                                message: data.message,
                                position: 'topRight'
                        });
                        $('.count_wishlist').html(data.data);
                    }else{
                        iziToast.error({
                                title: 'Oops!',
                                message: data.message,
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

        function add_to_compare(id){

            var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
            if(!loggedIn){
                    window.location.href = '/login';
            }

            $.ajax({
                    url: '/compare/store/' + id,
                    type: "GET",
                    dataType: 'JSON',
                    success: function( data, textStatus, jQxhr ){
                    if(data.status == 200){
                        iziToast.success({
                                title: 'Success!',
                                message: data.message,
                                position: 'topRight'
                        });
                        $('.count_compare').html(data.data);
                    }else{
                        iziToast.error({
                                title: 'Oops!',
                                message: data.message,
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

        //DELETE CART
        $("body").on("click", ".ec-pro-content .remove", function(){
            $.ajax({
                url: '/cart/delete/' + $(this).attr('data-id'),
                type: "DELETE",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){

                if(response.status == 200){

                    iziToast.success({
                            title: 'Yeay!',
                            message: response.message,
                            position: 'topRight'
                    });

                    let total_belanja = parseInt($('#total_belanja').html().replace(/,.*|[^0-9]/g, ''), 10);
                    total_belanja = parseInt(total_belanja) - parseInt(response.total_harga);
                    $('#total_belanja').html(fungsiRupiah(total_belanja));

                    $('#li_' + response.id).remove();

                    $(".cart-count-lable").html($(".cart-count-lable").html() - response.total_quantity);

                    var cart_product_count = $(".eccart-pro-items li").length;

                    if (cart_product_count == 0) {
                            $('.eccart-pro-items').html('<li><p class="emp-cart-msg">Your cart is empty!</p></li>');
                            $('#button_checkout').addClass("disabled");
                    }else{
                            $('#button_checkout').removeClass("disabled");
                    }
                }


                },
                error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
                },
            });
        });

        $('.search').on("focus", function(){
            $('.search-popover').addClass('open');
        })

        $('.suggestion li').on("click", function(){
            $('.search').val($(this).text());
        })

        $('.trending-box').on("click", function(){
            $('.search').val($(this).text());
        })

        $('.search').on("blur", function(){
            $('.search-popover').removeClass('open')
        })

        $(".notification-container").on("click", function(){
            if($(".notification-list").parent().hasClass("open")){
                $(".notification-list").parent().removeClass("open")
            } else {
                $(".notification-list").parent().addClass("open")
            }
        })

        $(document).mouseup(function(e)
        {
            var container = $(".notification-container");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                $(".notification-list").parent().removeClass("open");
            }
        });
        $(".notification-list-item").first().css("marginTop", "30px");

    </script>

    @yield('js')

</body>
</html>

