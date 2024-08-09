<?php
    use App\Helpers\App;
?>

@extends('partial.app-package')

@section('css')
    <style>
        .kategori-active {
            color: green;
        }

        @media (min-width: 333px) and (max-width: 460px){
            .header-search .form-control{
                width: 80%!important;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Main Slider Start -->
    <div class="ec-main-slider section section-space-pb">
        <div class="container">
            <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
            <!-- BANNER -->
            {{-- <div class="swiper-wrapper">
                @foreach ($banner as $item)
                    <div class="ec-slide-item swiper-slide d-flex slide-1" style="background-image: url('{{ 'https://seller.SIMANHURA.com/' . $item->url_image }}');">
                        <div class="container align-self-center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    <div class="ec-slide-content slider-animation">
                                        <h2 class="ec-slide-stitle">Penawaran Hari Ini</h2>
                                        <h1 class="ec-slide-title">{{ $item->title }}</h1>
                                        <div class="ec-slide-desc">
                                            <a href="/banner/detail/{{ $item->title_slug }}" target="_blank" class="btn btn-lg btn-primary">Pelajari Yuk <i
                                                    class="ecicon eci-angle-double-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}
            <div class="swiper-pagination swiper-pagination-white"></div>
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            </div>
    </div>
    </div>
    <!-- Main Slider End -->

    <!--  category Section Start -->
    <!--  For developer (More icons find in https://www.svgrepo.com/) -->
    <section class="section ec-category-section section-space-p">
        <div class="container">
            <div class="row d-none">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="ec-title">Top Category</h2>
                    </div>
                </div>
            </div>
            <div class="row margin-minus-b-15 margin-minus-t-15">
                @if (count($kategori))
                    <div id="ec-cat-slider" class="ec-cat-slider owl-carousel">
                        @foreach ($kategori as $key => $item)
                            <div class="ec_cat_content ec_cat_content_1">
                                <div class="ec_cat_inner ec_cat_inner-1">
                                    <div class="ec-category-image" style=" width: 60px !important; border-radius: 8px !important;">
                                        <img style="width: 70%" src="{{ '/commerce/ecom_admin/public/' . $item->url_image  }}" class="svg_img" alt="drink" />
                                    </div>
                                    <div class="ec-category-desc">
                                        <h3>{{ $item->kategori }} <span title="Category Items">({{ $item->total_produk }})</span></h3>
                                        {{-- {{ request()->fullUrlWithQuery(['kategori' => $item->kategori_slug]) }} --}}
                                        <a href="javascript:void(0)" class="cat-show-all" onclick="click_kategori('kategori', '{{ $item->kategori_slug }}')">Show All <i class="ecicon eci-angle-double-right"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="border:2px dashed black;padding: 25px;text-align: center;margin-left:2%;width:95%">
                        Kategori Utama tidak ditemukan
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!--category Section End -->

    <!-- Product tab Area Start -->
    <section class="section ec-product-tab section-space-p">
        <div class="container">
            <div class="row">

                <!-- Sidebar area start -->
                <div class="ec-side-cat-overlay" style="z-index: 900!important"></div>
                    <div class="col-lg-3 sidebar-dis-991" data-animation="fadeIn" style="padding: 0 30px!important">
                        <div class="cat-sidebar">
                            <div class="cat-sidebar-box">
                                <div class="ec-sidebar-wrap">
                                    <!-- Sidebar Category Block -->
                                    <div class="ec-sidebar-block">
                                        <div class="ec-sb-title">
                                            <h3 class="ec-sidebar-title">Kategori<span id="reset-category" onclick="click_reset_kategori()" class="text-secondary">Reset</span><button class="ec-close">×</button></h3>
                                        </div>
                                        @if (count($kategori))
                                            <div class="ec-sb-block-content"  id="place_category"></div>
                                        @else
                                            <div class="mt-3" style="border:2px dashed black;padding: 25px;text-align: center;">
                                                Kategori tidak ditemukan
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- BEST SELLER --}}
                            {{-- <div class="ec-sidebar-slider">
                                <div class="ec-sb-slider-title">Best Sellers</div>
                                <div class="ec-sb-pro-sl">
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/1.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">baby fabric shoes</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$5.00</span>
                                                    <span class="new-price">$4.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/2.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Men's hoodies t-shirt</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$10.00</span>
                                                    <span class="new-price">$7.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/3.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Girls t-shirt</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$5.00</span>
                                                    <span class="new-price">$3.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/4.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">woolen hat for men</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$15.00</span>
                                                    <span class="new-price">$12.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/5.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Womens purse</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$15.00</span>
                                                    <span class="new-price">$12.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/6.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Baby toy doctor kit</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                    <i class="ecicon eci-star"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$50.00</span>
                                                    <span class="new-price">$45.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/7.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">teddy bear baby toy</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$35.00</span>
                                                    <span class="new-price">$25.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                                    src="{{ asset('front/assets/images/product-image/2.jpg') }}" alt="product" /></a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Mens hoodies blue</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$15.00</span>
                                                    <span class="new-price">$13.00</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                </div>

                <!-- Product area start -->
                <div class="col-lg-9 col-md-12">
                    <!-- Product tab area start -->
                    <div class="row space-t-50">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="ec-title">Our Products</h2>
                                <a href="javascript:void(0)" class="ec-header-btn ec-sidebar-toggle filter-category-mobile" style="display: none">
                                    <div class="rounded-pill" style="border: 1px solid #c7c7c7; display: inline-block; padding: 0 5px; position: absolute; right: 0; font-size: .7rem ">Filter</div>
                                </a>
                            </div>
                        </div>

                        <!-- Tab Start -->
                        <div class="col-md-12 ec-pro-tab">
                            <ul class="ec-pro-tab-nav nav justify-content-end">
                                <li class="nav-item"><a id="all" class="nav-link nav-link-filter @if(request()->get('filter') == 'all') active @endif" onclick="url_append('filter', 'all')">All</a></li>
                                <li class="nav-item"><a id="terbaru" class="nav-link nav-link-filter @if(request()->get('filter') == 'terbaru') active @endif" onclick="url_append('filter', 'terbaru')">Terbaru</a></li>
                                <li class="nav-item"><a id="termurah" class="nav-link nav-link-filter @if(request()->get('filter') == 'termurah') active @endif" onclick="url_append('filter', 'termurah')">Harga Termurah</a></li>
                                <li class="nav-item"><a id="termahal" class="nav-link nav-link-filter @if(request()->get('filter') == 'termahal') active @endif" onclick="url_append('filter', 'termahal')">Harga Termahal</a></li>
                            </ul>
                        </div>
                        <!-- Tab End -->
                    </div>
                    <div class="row margin-minus-b-15">
                        <div class="col">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="all">
                                    {{-- Produk Tidak Ditemukan --}}
                                    {{-- <div class="product-not-found container">
                                        <div class="image-container-not-found d-flex justify-content-center align-items-center mt-4">
                                            <img src="{{ asset('front/assets/images/product-not-found.jpg') }}" width="300px" alt="">
                                        </div>
                                        <h3 class="product-not-found-text text-center text-secondary">Ooopss.. Produk Tidak Ditemukan</h3>
                                    </div> --}}
                                    @if (count($produk))
                                        <div class="row" id="place-produk" style="justify-content: flex-start!important">
                                            @foreach ($produk as $item)
                                                <div class="col-lg-3 col-6 ec-product-content">
                                                    <div class="ec-product-inner">
                                                        <div class="ec-pro-image-outer">
                                                            <div class="ec-pro-image">
                                                                <a href="/produk/{{ $item->nama_produk_slug }}" class="image product-image-container" style="background-color: #fff; display: flex; justify-content:center; overflow: hidden; height: 250px;">
                                                                    @if (isset($item->url_image))
                                                                        <img class="product-image" style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);" src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->url_image[0] }}" alt="Product" />
                                                                    @else
                                                                        <img class="product-image" style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);" src="{{ '/commerce/ecom_seller_final/public/assets/img/no-image.png' }}" alt="Product" />
                                                                    @endif
                                                                </a>
                                                                @if (isset($item->diskon) && $item->diskon > 0)
                                                                    <span class="percentage">{{ $item->diskon }}%</span>
                                                                @endif
                                                                <div class="ec-pro-actions">
                                                                    <a class="ec-btn-group wishlist" title="Wishlist" onclick='add_to_wishlist({{ $item->id }})'>
                                                                        @if($item->is_wishlist == 1)
                                                                            <img src="{{ asset('front/assets/images/icons/pro_wishlist.svg') }}" class="svg_img pro_svg" style="display: none" alt=""/><i class="fas fa-heart" style="color: pink;"></i>
                                                                        @else
                                                                            <img src="{{ asset('front/assets/images/icons/pro_wishlist.svg') }}" class="svg_img pro_svg" alt="" />
                                                                        @endif
                                                                    </a>
                                                                    <a href="/produk/{{ $item->nama_produk_slug }}" class="ec-btn-group quickview" title="Quick view"><img
                                                                            src="{{ asset('front/assets/images/icons/quickview.svg') }}"
                                                                            class="svg_img pro_svg" alt="" />
                                                                    </a>
                                                                    @if($item->is_compare == 1)
                                                                        <a class="ec-btn-group compare" onclick='add_to_compare({{ $item->id }})'
                                                                            title="Compare"><img src="{{ asset('front/assets/images/icons/compare.svg') }}" class="svg_img pro_svg" alt="" style="fill: #ff9d9d" />
                                                                        </a>
                                                                    @else
                                                                    <a class="ec-btn-group compare" onclick='add_to_compare({{ $item->id }})'
                                                                        title="Compare"><img src="{{ asset('front/assets/images/icons/compare.svg') }}" class="svg_img pro_svg" alt="" />
                                                                    </a>
                                                                    @endif

                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ec-pro-content">
                                                            <a href="/produk/{{ $item->nama_produk_slug }}"><h6 class="ec-pro-stitle text-ellipsis">{{ $item->master_subkategori->subkategori }}</h6></a>
                                                            <h5 class="ec-pro-title"><a href="/produk/{{ $item->nama_produk_slug }}" class="two-line-only">{{ $item->nama_produk_desc }}</a></h5>
                                                            <div class="ec-pro-rat-price d-flex ml-4" style="padding: 0!important">
                                                                <span class="ec-pro-rating">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $item->bintang)
                                                                            <i class="ecicon eci-star fill"></i>
                                                                        @else
                                                                            <i class="ecicon eci-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>
                                                                <span class="ec-id" hidden>{{ $item->id }}</span>
                                                                <span class="ec-price" style="white-space: nowrap; flex-wrap: wrap">
                                                                    @if (isset($item->diskon) && $item->diskon > 0)
                                                                        <span class="old-price" style="margin-right: 7px">{{ "Rp " . number_format($item->harga_jual + ($item->harga_jual / 100 * $item->diskon),0,',','.'); }}</span>
                                                                    @endif
                                                                    <span class="new-price">{{ "Rp " . number_format($item->harga_jual,0,',','.'); }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{ $produk->withQueryString()->links('vendor.pagination.custom') }}
                                        </div>
                                    @else
                                        <div class="mt-3" style="border:2px dashed black;padding: 25px;text-align: center;">
                                            Produk tidak ditemukan
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product tab area end -->

                </div>
            </div>
        </div>
    </section>
    <!-- ec Product tab Area End -->
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            show_category();
            // $('#place-produk').focus();
            $("#place-produk").attr("tabindex",0).focus();
        });

        function click_reset_kategori(){
            let searchParams = new URLSearchParams(window.location.search);
            searchParams.delete('subkategori');

            window.location.href = '/produk?' + searchParams;
        }

        function click_kategori(tipe, value){
            let searchParams = new URLSearchParams(window.location.search);

            parameter['filter'] = 'all';
            parameter[tipe] =  value;
            let string_parameter = '';
            $.each(parameter, function( key, value ) {
                string_parameter = string_parameter.concat('&' + key + "=" + value);
            });

            window.location.href = '/produk?' +'package=' +  searchParams.get('package') + string_parameter;
        }

        function click_banner(slug){
            window.open('/banner/detail/' + slug, '_blank');
        }

        var parameter = {};
        var angka = 0;

        function url_append(tipe, value){
            const queryString = window.location.search;

            if(tipe == 'filter'){
                $('.nav-link-filter').removeClass('active');
                $('#'+value).addClass('active');
            }

            let string_parameter = '';
            parameter[tipe] = value;

            $.each(parameter, function( key, value ) {
                string_parameter = string_parameter.concat('&' + key + "=" + value.replace(/ /g, "%20"));
            });

            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set(tipe,value);
            var newParams = searchParams.toString();

            window.location.href = '/produk?'+newParams;

            // $.ajax({
            //     url: '/produk-filter' + queryString + string_parameter,
            //     type: "GET",
            //     dataType: 'JSON',
            //     success: function( response, textStatus, jQxhr ){
            //         $('#place-produk').empty();
            //         $.each(response.data, function( index, item ) {

            //             let diskon = '';
            //             let harga_diskon = '';
            //             if(item.diskon !== null){
            //                 diskon = `<span class="percentage">${item.diskon}%</span>`;
            //                 harga_diskon = `<span class="old-price" style="margin-right: 7px">${fungsiRupiah(item.harga_jual + (item.harga_jual / 100 * item.diskon))}</span>`;
            //             }

            //             $('#place-produk').append(`
            //                 <div class="col-lg-3 col-6 ec-product-content">
            //                     <div class="ec-product-inner">
            //                         <div class="ec-pro-image-outer">
            //                             <div class="ec-pro-image">
            //                                 <a href="/produk/${item.nama_produk_slug}" class="image" style="background-color: #fff; display: flex; justify-content:center; overflow: hidden; height: 250px;">
            //                                     <img class="main-image" style="object-fit: cover; display: block;"
            //                                         src="${"https://seller.SIMANHURA.com/" + item.url_image[0]}" alt="Product" />
            //                                     <img class="hover-image" style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);"
            //                                         src="${"https://seller.SIMANHURA.com/" + item.url_image[0]}" alt="Product" />
            //                                 </a>
            //                                 ${diskon}
            //                                 <div class="ec-pro-actions">
            //                                     <a class="ec-btn-group wishlist" title="Wishlist" onclick='add_to_wishlist(${item.id})'><img
            //                                         src="{{ asset('front/assets/images/icons/pro_wishlist.svg') }}"
            //                                         class="svg_img pro_svg" alt="" />
            //                                     </a>
            //                                     <a href="/produk/${item.nama_produk_slug}" class="ec-btn-group quickview" title="Quick view"><img
            //                                             src="{{ asset('front/assets/images/icons/quickview.svg') }}"
            //                                             class="svg_img pro_svg" alt="" />
            //                                     </a>
            //                                     <a class="ec-btn-group compare" onclick='add_to_compare(${item.id})'
            //                                         title="Compare"><img src="{{ asset('front/assets/images/icons/compare.svg') }}"
            //                                             class="svg_img pro_svg" alt="" />
            //                                     </a>
            //                                 </div>
            //                             </div>
            //                         </div>
            //                         <div class="ec-pro-content">
            //                             <a href="/produk/${item.nama_produk_slug}"><h6 class="ec-pro-stitle text-ellipsis">${item.master_subkategori.subkategori}</h6></a>
            //                             <h5 class="ec-pro-title"><a href="product-left-sidebar.html" class="text-ellipsis">${item.nama_produk_desc}</a></h5>
            //                             <div class="ec-pro-rat-price d-flex ml-5" style="padding: 0!important">
            //                                 <span class="ec-pro-rating">
            //                                     <i class="ecicon eci-star fill"></i>
            //                                     <i class="ecicon eci-star fill"></i>
            //                                     <i class="ecicon eci-star fill"></i>
            //                                     <i class="ecicon eci-star"></i>
            //                                     <i class="ecicon eci-star"></i>
            //                                 </span>
            //                                 <span class="ec-id" hidden>${item.id}</span>
            //                                 <span class="ec-price" style="white-space: nowrap; flex-wrap: wrap">
            //                                     ${harga_diskon}
            //                                     <span class="new-price">${fungsiRupiah(item.harga_jual)}</span>
            //                                 </span>
            //                             </div>
            //                         </div>
            //                     </div>
            //                 </div>
            //             `);
            //         });
            //     },
            //     error: function( jqXhr, textStatus, errorThrown ){
            //         console.log( errorThrown );
            //         console.warn(jqXhr.responseText);
            //     },
            // });
        }

        function convertToSlug(Text) {
            let text = Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            return text.replace("--", "-");
        }

        function display_html(data){

            let searchParams = new URLSearchParams(window.location.search);
            let kategori_active = searchParams.get('subkategori');

            html = "";
            $.each(data,function(i,value){
                var slug = convertToSlug(i);

                let active = '';
                console.log(kategori_active +"===="+slug);
                if(kategori_active == slug){
                    active = 'text-success';
                }

                html += `<li>`;

                if(!jQuery.isEmptyObject(value)) {
                    angka++

                    html += `<div class="ec-sidebar-block-item item-kategori" number="`+angka+`">`+`<p class="${active}" onclick="url_append('subkategori', '`+slug+`')" >`+i+`</p>`+`<i class="fas fa-plus"></i></div>`;
                    html += `<ul style="display: block;" class="sidebar-block-list sub-item-`+angka+`">`;
                    html += display_html(value);
                    html += `</ul>`;

                }

                if(value.length==0){


                    html += `<div class="ec-sidebar-sub-item">`;
                    html += `<a class="item-kategori ${active}" id="`+slug+`" href="javascript:void(0)" onclick="url_append('subkategori', '`+slug+`')">`+i+`</a>`;
                    html += `</div>`;
                }

                html += `</li>`;

            });
            return html;
        }

        function show_category(){
            let searchParams = new URLSearchParams(window.location.search);
            $.ajax({
                url: '/category/' + searchParams.get('package') +'/'+ searchParams.get('kategori'),
                type: "GET",
                dataType: 'JSON',
                success: function( data, textStatus, jQxhr ){
                    var val = "";
                    var html = "<ul>";
                    var x = 0;

                    let searchParams = new URLSearchParams(window.location.search);
                    let kategori_active = searchParams.get('subkategori');

                    $.each(data,function(i,value){
                        angka++

                        var slug = convertToSlug(i).toString();

                        let active = '';
                        console.log(kategori_active +"===="+slug);
                        if(kategori_active == slug){
                            active = 'text-success';
                        }

                        html += `<li>`;
                        html += `<div class="item-kategori ec-sidebar-block-item" number="`+angka+`">`+`<p class="${active}" onclick="url_append('subkategori', '`+slug+`')">`+i+`</p>`+`<i class="fas fa-plus"></i></div>`;
                        html += `<ul style="display: block;" class="actived sidebar-block-list sub-item-`+angka+`">`

                        val = display_html(value);
                        html += val;

                        html += `</ul>`
                        html += `</li>`;
                        x++;
                    });

                    html += "</ul>";

                    if(html == '<ul></ul>'){
                        $('#place_category').append(`
                            <div class="mt-3" style="border:2px dashed black;padding: 25px;text-align: center;">
                                Kategori tidak ditemukan
                            </div>
                        `);
                    }

                    $('#place_category').append(html);


                    $(".ec-sidebar-block .ec-sb-block-content .sidebar-block-list").addClass("ec-cat-sub-dropdown");
                    $(".ec-sidebar-block .ec-sb-block-content .sidebar-block-list").prev().addClass("actived");
                    $('.ec-sidebar-block .ec-sidebar-block-item').siblings().css("padding-left", "10px");

                    $(".ec-sidebar-block .ec-sidebar-block-item").children("i").on("click", function() {
                        $(this).parent().toggleClass("actived")
                        var $this = $(this).parent().closest('.ec-sb-block-content').find('.ec-sidebar-block-item');
                        $('.sub-item-'+$(this).parent().attr('number')).slideToggle('slow');
                    });
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
                        $('#count_wishlist').html(data.data);
                    }

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
                url: '/wishlist/cart-store/' + id,
                type: "GET",
                dataType: 'JSON',
                success: function( data, textStatus, jQxhr ){
                    if(data.status == 200){
                        iziToast.success({
                            title: 'Success!',
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

        function fungsiRupiah(angka){
            var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        $(".ec-sidebar-block-item").next()
    </script>
@endsection
