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
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">


    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo8.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-additional.css') }}" />

    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}">

    <style>
        .old-price{
            color: #fa4747b3!important;
            font-weight: 700;
            font-family: "Montserrat";
            letter-spacing: 0;
        }
        form input, textarea, .selectric{
            border: 2px solid #096A2E!important;
        }
        @media (min-width: 373px) and (max-width: 460px){
            .header-search .form-control{
                width: 80%!important;
            }
        }
        @media (min-width: 330px) and (max-width: 374px){
            .header-search .form-control{
                width: 70%!important;
            }
        }
        .ec_cat_inner .ec-category-image{
            padding: 0!important;
        }
        .ec_cat_inner .ec-category-image img{
            border-radius: 0!important;
        }
        .notification-header-btn{
            margin-right: 15px!important;
        }
        .ec-product-inner .ec-pro-image .image img.product-image {
            position: absolute;
            z-index: 2;
            top: 0;
            left: 0;
        }
        .ec-footer .footer-top .col-sm-12{
            width: 25%!important;
        }
        .notification-list li{
            padding: 2px 10px!important;
            text-align: start!important;
        }
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .suggestion{
            max-height: calc(26.75px * 5 + 20px)!important;
            overflow: scroll!important;
        }
        .suggestion li{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .ec-footer-logo{
            margin-bottom: 15px;
        }
        #reset-category{
            float: right;
            font-size: .7rem;
            text-decoration: underline;
        }
        #reset-category:hover{
            color: var(--base-color)!important;
            cursor: pointer;
        }
        @media (max-width: 332px){
            .header-search{
                min-width: unset!important;
            }
        }

        @media(max-width: 300px){
            .ec-pro-image a{
                height: 120px!important;
            }
        }

        @media (min-width: 300px) and (max-width: 450px){
            .ec-pro-image .product-image-container{
                height: 178px!important;
            }
        }

        @media (max-width: 474px){
            #scrollUp{
                right: 10px;
            }
        }

        @media(max-width: 991px){
            .ec-footer-logo a{
                display: flex!important;
                justify-content: center;
            }
            #reset-category{
                position: absolute;
                right: 0;
                top: 25px;
            }
            .ec-product-tab .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content{
                margin-top: 30px!important;
            }
            .ec-pro-title .two-line-only{
                height: 2.7em!important;
            }

            .ec-footer .footer-top .col-sm-12{
                width: 100%!important;
            }
        }
    </style>

</head>
<body class="sticky-header-next-sec">
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

    @include("partial/cart")

    <!-- Content page -->
    <div id="main">
        @yield('content')
    </div>

    <!-- Footer Start -->
    <footer class="ec-footer">
        <div class="footer-container">
            <div class="footer-top section-space-footer-p">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-12 col-lg-3 ec-footer-cat">
                            <div class="ec-footer-widget ec-footer-logo">
                                <div class="ec-footer-logo"><a href="/" class="d-flex justify-content-center"><img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                            alt="" style="width: 53%"><img class="dark-footer-logo" src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                            alt="Site Logo" style="display: none;" /></a></div>
                                <h4 class="d-flex justify-content-center jatim-logo">
                                    <img src="{{ asset('front/assets/images/project/jatim-logo.png') }}" alt="" srcset="">
                                </h4>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 ec-footer-info">
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
                        <div class="col-sm-12 col-lg-3 ec-footer-account">
                            <div class="ec-footer-widget">
                                <h4 class="ec-footer-heading">Tentang Kami</h4>
                                <div class="ec-footer-links">
                                    <p>SIMANHURA</p>
                                    <p>SISTEM INFORMASI MANJEMEN HUTAN RAKYAT<br></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 ec-footer-service">
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
                    <div class="row">
                        <!-- Footer payment -->
                        <div class="footer-bottom-right">
                            <div class="footer-bottom-payment d-flex justify-content-center">
                                <div class="payment-link">
                                    <center>
                                        <img src="{{ asset('front/assets/images/icons/payment-new.png') }}" width="50%" alt="">
                                    </center>
                                </div>

                            </div>
                        </div>
                        <!-- Footer payment -->
                        <!-- Footer Copyright Start -->
                        <div class="footer-copy">
                            <div class="footer-bottom-copy ">
                                <div class="ec-copy">Copyright © <a class="site-name" href="/">SIMANHURA</a> all
                                    rights reserved. Powered by SIMANHURA</div>
                            </div>
                        </div>
                        <!-- Footer Copyright End -->

                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->

    <!-- Newsletter Modal Start -->
    {{-- <div id="ec-popnews-bg"></div>
    <div id="ec-popnews-box">
        <div id="ec-popnews-close"><i class="ecicon eci-close"></i></div>
        <div class="row">
            <div class="col-md-7 disp-no-767">
                <img src="{{ asset('front/assets/images/banner/newsletter-8.png') }}" alt="newsletter">
            </div>
            <div class="col-md-5">
                <div id="ec-popnews-box-content">
                    <h2>Subscribe Newsletter.</h2>
                    <p>Subscribe the ekka SIMANHURA to get in touch and get the future update. </p>
                    <form id="ec-popnews-form" action="#" method="post">
                        <input type="email" name="newsemail" placeholder="Email Address" required />
                        <button type="button" class="btn btn-primary" name="subscribe">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Newsletter Modal end -->

    @include('partial.mobile-footer-menu')

    <!-- Vendor JS -->
    <script src="{{ asset('front/assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

    <!--Plugins JS-->

    <script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/countdownTimer.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/nouislider.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/infiniteslidev2.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/click-to-call.js') }}"></script>

    <!-- Main Js -->
    <script src="{{ asset('front/assets/js/vendor/index.js') }}"></script>
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>

    <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/index.umd.min.js') }}"></script>

    <!--Start of Tawk.to Script-->
    {{-- <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/634d5b4db0d6371309c9f66f/1gfj2pa1b';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script> --}}
    <!--End of Tawk.to Script-->

    @yield('js')

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
                        total_harga_global += parseInt(value.master_produk.harga_jual) * parseInt(value.quantity);

                        var str1 = value.master_produk.url_image[0];
                        var img_url = '' + value.master_produk.url_image[0];
                        

                        $('#place_cart_global').append(`
                                <li id="li_${value.id}">
                                <a href="/produk/${value.master_produk.nama_produk_slug}" class="sidekka_pro_img"><img src="${img_url}" alt="product"></a>
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
                    console.warn(jqXhr.responseText);
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


        $(".border-test").first().prev().css("marginTop", "35px")
        $(".border-test").last().css("display", "none")
        $(".border-test").last().prev().css("border-radius", "0 0 0 20px")
        $(".border-test-responsive").first().prev().css("marginTop", "35px")
        $(".border-test-responsive").last().css("display", "none")
        $(".border-test-responsive").last().prev().css("border-radius", "0 0 0 20px")

        $(document).mouseup(function(e){
            var container = $(".notification-container");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                $(".notification-list").parent().removeClass("open");
            }
        });

        $(document).ready(function(){
            if( $('.search').val() != '' ) {
                $('#hapus-search').attr('hidden', false);
            }
        })

        $(".notification-list-item").first().css("marginTop", "30px");
    </script>
</body>

</html>
