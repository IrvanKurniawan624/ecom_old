@extends('partial.app')

@section("css")
<style>
    .wishlist > *{
        position: absolute;
        top: 5px;
        left: 5px;
    }
    .swiper-pagination-action div{
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 50%;
        z-index: 10;
        font-size: 1.5rem;
        color: white;
        padding: 5px 8px;
        background-color: rgba(55, 55, 55, .7);
        border-radius: 20px;
    }

    .slick-list{
        border-radius: 22px;
    }

    .slider .slick-slide img {
        width: 100%;
    }

    .img-social{
        max-height: 460px;
        border-radius: 15px;
        object-fit: contain;
    }

    .slick-prev:hover, .slick-next:hover {
        background: rgba(55, 55, 55, .7);
    }

    /* make button larger and change their positions */
    .slick-prev, .slick-next {
        width: 50px;
        height: 50px;
        z-index: 1;
        background: rgba(55, 55, 55, .7);
        top: 50%;
        border-radius: 25px
    }
    .slick-prev {
        left: 25px!important ;
    }
    .slick-next {
        right: 25px!important;
    }
    .slick-prev:before,
    .slick-next:before {
        font-size: 40px;
        text-shadow: 0 0 10px rgba(0,0,0,0.5);
        color: white;
    }

    /* move dotted nav position */
    .slick-dots {
        bottom: 15px;
    }

    @media(max-width: 600px){
        .ec-social-item{
            width: 100%!important;
            margin: auto;
        }
    }

    /* enlarge dots and change their colors */
    .slick-dots li button:before {
        font-size: 12px;
        color: #fff;
        text-shadow: 0 0 10px rgba(0,0,0,0.5);
        opacity: 1;
    }
    .slick-dots li.slick-active button:before {
        color: #dedede;
    }
    /* transition effects for opacity */
    .slick-arrow,
    .slick-dots {
        transition: opacity 0.5s ease-out;
    }

    @media (max-width: 400px){
        .ec-main-slider{
            margin: 0!important;
        }
        .slick-list{
            border-radius: 5px;
        }
    }

    @media (max-width: 991px){
        .slick-prev, .slick-next{
            width: 35px;
            height: 35px;
        }
        .slick-prev::before, .slick-next::before{
            font-size: 28px;
        }
    }
    @media (max-width: 1199px){
        .cat-desc > *{
            font-size: .8rem!important;
        }
    }
</style>
@endsection

@section('content')
    <section class="ec-page-content">
        <!-- Main Slider Start -->
        <div class="sticky-header-next-sec ec-main-slider section section-space-pb mx-4">
            <div class="container" style="position: relative!important">
                <div class="slider swiper-wrapper mt-5">
                    @if(count($banner))
                        @foreach ($banner as $key => $item)
                            <div>
                                <a href="/banner/detail/{{ $item->title_slug }}"><img src="https://solaristamandatakom.com/commerce/ecom_admin/public/{{ $item->url_image }}" class=" ec-slide-{{$key}}" width="100%" height="auto" alt="" srcset=""></a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- Main Slider End -->

        <!--  Category Section Start -->
        <section class="section ec-category-section section-space-p" id="categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="section-title">
                            <h2 class="ec-title">Kategori</h2>
                            <p class="sub-title">Browse The Collection of Top Categories</p>
                        </div>
                    </div>
                </div>

                <!--Category Nav Start -->
                <div class="container text">
                    <ul class="ec-cat-tab-nav row d-flex justify-content-center">
                        @if(count($package))
                            @foreach ($package as $item)
                                <li class="cat-item category-item col-lg-3 col-6 col-md-4 py-2">
                                    <a class="cat-link" href="/produk?{{http_build_query(['package' => $item->package_slug])}}">
                                    <div class="cat-icons"><img class="cat-icon" style="width: 64px; max-width: 64px;"  src="{{ 'https://solaristamandatakom.com/commerce/ecom_admin/public/' . $item->url_image }}"
                                            alt="cat-icon"><img class="cat-icon-hover" style="width: 64px; max-width: 64px;" src="{{ 'https://solaristamandatakom.com/commerce/ecom_admin/public/' . $item->url_image }}"
                                            alt="cat-icon"></div>
                                    <div class="cat-desc" style="white-space: nowrap"><span>{{ $item->package }}</span><span>{{ $item->total_produk }} Produk</span></div>
                                </a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <!-- Category Nav End -->
            </div>
        </section>
        <!-- Category Section End -->

        <!-- Product tab Area Start -->
        <section class="section ec-product-tab section-space-p" id="collection">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Our Top Collection</h2>
                            <h2 class="ec-title">Our Top Collection</h2>
                            <p class="sub-title">Browse The Collection of Top Products</p>
                        </div>
                    </div>

                    <!-- Tab Start -->
                    <div class="col-md-12 text-center">
                        <ul class="ec-pro-tab-nav nav justify-content-center">
                            @if(count($package))
                                @foreach ($package as $item)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab" href="{{ '#' . $item->package_slug }}">{{ $item->package }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- Tab End -->
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            @if(count($package))
                                @foreach ($package as $item)
                                    <div class="tab-pane fade show @if ($loop->first) active @endif" id="{{ $item->package_slug }}">
                                        <div class="row">
                                            @if (count($package_produk[$item->id]))
                                                @foreach ($package_produk[$item->id] as $produk)
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content" data-animation="fadeIn">
                                                        <div class="ec-product-inner">
                                                            <div class="ec-pro-image-outer">
                                                                <div class="ec-pro-image">
                                                                    <a href="/produk/{{ $produk->nama_produk_slug }}" style="background-color: #fff; display: flex; justify-content:center; align-items: center; overflow: hidden; height: 250px;" class="image">
                                                                        @if (isset($produk->url_image))
                                                                            <img class="main-image" src="{{ 'https://solaristamandatakom.com/commerce/ecom_seller_final/public/berkas/master-produk/' . $produk->url_image[0] }}" alt="Product" style="height: fit-content!important; width: 100%;"/>
                                                                        @else
                                                                            <img class="main-image" src="{{ '/assets/img/no-image.png' }}" alt="Product" style="height: fit-content!important; width: 100%;"/>
                                                                        @endif
                                                                    </a>
                                                                    @if (isset($produk->diskon) && $produk->diskon > 0)
                                                                        <span class="percentage">{{ $produk->diskon }}%</span>
                                                                    @endif


                                                                    <div class="ec-pro-actions">
                                                                        <a class="ec-btn-group compare" onclick='add_to_compare({{ $produk->id }})'
                                                                            title="Compare"><img src="{{ asset('front/assets/images/icons/compare.svg') }}"
                                                                                class="svg_img pro_svg" alt="" />
                                                                        </a>
                                                                        <a href="/produk/{{ $produk->nama_produk_slug }}" style="bottom: -10px" class="ec-btn-group" data-link-action="quickview"
                                                                            title="View"><img
                                                                                src="{{ asset('front/assets/images/icons/quickview.svg') }}" class="svg_img pro_svg"
                                                                                alt="" />
                                                                        </a>
                                                                        {{-- <button title="Add To Cart" class=" add-to-cart"><img
                                                                                src="{{ asset('front/assets/images/icons/cart.svg') }}" class="svg_img pro_svg"
                                                                                alt="" /> Add To Cart</button> --}}

                                                                        <a class="ec-btn-group wishlist" title="Wishlist" onclick='add_to_wishlist({{ $produk->id }})'><img
                                                                                src="{{ asset('front/assets/images/icons/wishlist.svg') }}"
                                                                                class="svg_img pro_svg" alt="" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ec-pro-content">
                                                                <h5 class="ec-pro-title"><a href="/produk/{{ $produk->nama_produk_slug }}">{{ $produk->nama_produk_desc }}</a></h5>
                                                                <div class="ec-pro-rating">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $produk->bintang)
                                                                            <i class="ecicon eci-star fill"></i>
                                                                        @else
                                                                            <i class="ecicon eci-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <span class="ec-id" hidden>{{ $produk->id }}</span>
                                                                <span class="ec-price">
                                                                    @if (isset($produk->diskon) && $produk->diskon > 0)
                                                                        <span class="old-price">{{ "Rp " . number_format($produk->harga_jual + ($produk->harga_jual / 100 * $produk->diskon),0,',','.'); }}</span>
                                                                    @endif
                                                                    <span class="new-price">{{ "Rp " . number_format($produk->harga_jual,0,',','.'); }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div style="border:2px dashed black;padding: 25px;text-align: center; width:90%; margin: auto;">
                                                    Produk tidak ditemukan
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ec Product tab Area End -->

        <!-- ec Banner Section Start -->
        {{-- <section class="ec-banner section section-space-p">
            <h2 class="d-none">Banner</h2>
            <div class="container">
                <!-- ec Banners Start -->
                <div class="ec-banner-inner">
                    <!--ec Banner Start -->
                    <div class="ec-banner-block ec-banner-block-2">
                        <div class="row">
                            <div class="banner-block col-lg-6 col-md-12 margin-b-30" data-animation="slideInRight">
                                <div class="bnr-overlay">
                                    <img src="{{ asset('front/assets/images/banner/2.jpg') }}" alt="" />
                                    <div class="banner-text">
                                        <span class="ec-banner-stitle">New Arrivals</span>
                                        <span class="ec-banner-title">mens<br> Sport shoes</span>
                                        <span class="ec-banner-discount">30% Discount</span>
                                    </div>
                                    <div class="banner-content">
                                        <span class="ec-banner-btn"><a href="#">Order Now</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="banner-block col-lg-6 col-md-12" data-animation="slideInLeft">
                                <div class="bnr-overlay">
                                    <img src="{{ asset('front/assets/images/banner/3.jpg') }}" alt="" />
                                    <div class="banner-text">
                                        <span class="ec-banner-stitle">New Trending</span>
                                        <span class="ec-banner-title">Smart<br> watches</span>
                                        <span class="ec-banner-discount">Buy any 3 Items & get <br>20% Discount</span>
                                    </div>
                                    <div class="banner-content">
                                        <span class="ec-banner-btn"><a href="#">Order Now</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ec Banner End -->
                    </div>
                    <!-- ec Banners End -->
                </div>
            </div>
        </section> --}}
        <!-- ec Banner Section End -->

        {{-- <!-- Ec Brand Section Start -->
        <section class="section ec-brand-area section-space-p">
            <h2 class="d-none">Brand</h2>
            <div class="container">
                <div class="row">
                    <div class="ec-brand-outer">
                        <ul id="ec-brand-slider">
                            @for ($i = 1; $i <= 7; $i++)
                            <li class="ec-brand-item"  data-animation="zoomIn">
                                <div class="ec-brand-img">
                                    <a href="#"><img alt="brand" title="brand" src="{{ asset('front/assets/images/brand-image/1') }}.png" /></a>
                                </div>
                            </li>
                            @endfor

                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Ec Brand Section End --> --}}

        <!-- Ec Instagram Start -->
        <section class="section ec-instagram-section module section-space-p" id="insta">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Media Sosial</h2>
                            <h2 class="ec-title">Media Sosial</h2>
                            <p class="sub-title">Share your store with us</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-insta-wrapper">
                <div class="ec-insta-outer">
                    <div class="container" data-animation="fadeIn">
                        <div class="owl-carousel owl-theme">
                            @if (count($instagram))
                                @foreach ($instagram as $item)
                                    @if ($item->tipe == 'youtube')
                                        <!-- Youtube item -->
                                        <div class="ec-social-item">
                                            <div class="ec-social-inner ec-yt-inner">
                                                <a href="{{ $item->link }}" target="_blank"><img src="{{ $item->url_image }}" class="img-social" alt="youtube"></a>
                                            </div>
                                        </div>
                                    @elseif($item->tipe == 'tiktok')
                                        <!-- Tiktok item -->
                                        <div class="ec-social-item">
                                            <div class="ec-social-inner ec-tiktok-inner">
                                                <a href="{{ $item->link }}" target="_blank"><img src="{{ $item->url_image }}" class="img-social" alt="tiktok"></a>
                                            </div>
                                        </div>
                                    @else
                                        <!-- instagram item -->
                                        <div class="ec-social-item">
                                            <div class="ec-social-inner ec-insta-inner">
                                                <a href="{{ $item->link }}" target="_blank"><img src="{{ $item->url_image }}" class="img-social" alt="insta"></a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <!-- instagram item -->
                                <div class="ec-social-item">
                                    <div class="ec-social-inner ec-insta-inner">
                                        <a href="javascript:void(0)"><img src="{{ asset('front/assets/images/instragram-image/1.jpg') }}"
                                                class="img-social" alt="insta"></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Ec Instagram End -->
    </section>
@endsection


@section('js')
<script>
$(".owl-carousel").owlCarousel({
    autoplay:true,
    autoplayHoverPause:true,
    slideTransition: 'linear',
    autoplaySpeed: 10000,
    autoplayTimeout:10000,
    nav:false,
    loop:true,
    dots: false,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:3,
        },
        1200:{
            items:5,
        }
    }
  });

    function click_banner(slug){
        window.open('/banner/detail/' + slug, '_blank');
    }

    $(document).ready(function(){
        $(window).resize(() => {
            if($(window).width() < 345){
                $(".cat-icons").css("display", "none");
            } else {
                $(".cat-icons").css("display", "block");
            }
        })

        window.onload = function start() {
            slide();
        }

        function slide() {
            var num = 0;
            window.setInterval(function () {
                $("#container div:eq(" + num + ")").slideUp(450);
                num = (num + 1) % 4;
                $("#container div:eq(" + num + ")").fadeIn(450);

            }, 5000);
        }

        $(".swiper-next").click(function () {
            $("#ec-slide:eq(" + num + ")").slideUp(450);
            num = (num + 1) % 4;
            $("#container div:eq(" + num + ")").fadeIn(450);
        });
    })
    </script>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Our Script -->
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                autoplay: true,
                autoplaySpeed: 5500,
                dots: true
            });
        });
    </script>
@endsection
