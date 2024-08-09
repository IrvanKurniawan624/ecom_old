@extends('partial.app')

@section("css")
<style>
    .old-price{
        text-decoration: line-through;
        font-size: 16px;
        font-weight: 700;
        font-family: "Montserrat";
        letter-spacing: 0;
    }

    @media only screen and (max-width: 767px){
        .old-price{
            font-size: 14px;
        }
    }

    #mf-trigger:hover {
        cursor: zoom-in !important;
    }

    .image-product:hover {
        cursor: default !important;
    }

    .slick-arrow.slick-prev {
        left: unset !important;
        right: 35px;
        top: 15px;
    }

    .slick-list {
        margin-top: 10px !important;
    }

    .slick-arrow.slick-next {
        right: 0;
        top: 15px;
    }

    @media (max-width: 1200px){
        #button-video{
            width:  90px!important;
        }
    }


    @media (max-width: 768px) {
        .back-button {
            position: absolute !important;
            top: -15px !important;
            border: none !important;
        }
    }

    @media (min-width: 767px) {
        .mfp-img {
            min-width: 415px !important;
            min-height: 415px !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12" style="position: relative">
                        <div class="back-button" style="">
                            <a href="{{ url()->previous() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                    <path
                                        d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z" />
                                </svg>
                            </a>
                        </div>
                        <div style="display: flex; align-items: center; height: 100%;">
                            <h2 class="ec-breadcrumb-title" style="flex: auto">Detail Produk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->
<!-- Sart Single product -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div
                class="ec-pro-rightside ec-common-rightside col-lg-10 offset-lg-1 order-lg-last col-md-12 order-md-first">
                <!-- Single product content Start -->
                <div class="single-pro-block">
                    <div class="single-pro-inner">
                        <div class="row">
                            <div class="single-pro-img">
                                <div class="single-product-scroll">
                                    <div class="single-product-cover">
                                        @if (isset($data->url_image))
                                        @foreach ($data->url_image as $item)
                                        <div class="image-product"
                                            href='{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item }}'>
                                            <img class="img-responsive"
                                                src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item }}"
                                                alt="">
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="image-product"
                                            href='{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item }}'>
                                            <img class="img-responsive"
                                                src="{{ 'https://seller.SIMANHURA.com/assets/img/no-image.png' }}"
                                                alt="">
                                        </div>
                                        @endif
                                    </div>
                                    <i class="fas fa-search-plus" id="mf-trigger"
                                        style="position: absolute; right: 35px; top: 15px; font-size: 1.2rem;"></i>
                                    <div class="single-nav-thumb">
                                        @if (isset($data->url_image))
                                        @foreach ($data->url_image as $item)
                                        <div class="single-slide">
                                            <img class="img-responsive"
                                                src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item }}"
                                                alt="">
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-pro-desc">
                                <div class="single-pro-content">
                                    <h5 class="ec-single-title">{{ $data->nama_produk_desc }}</h5>
                                    <div class="ec-single-desc">{{ $data->master_subkategori->subkategori }}</div>
                                    <div class="ec-single-rating-wrap">
                                        <div class="ec-single-rating">
                                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$data->bintang)
                                                <i class="ecicon eci-star fill"></i>
                                                @else
                                                <i class="ecicon eci-star"></i>
                                                @endif
                                                @endfor
                                        </div>
                                        <span class="ec-read-review">{{ $data->bintang . "0" }}</span>
                                    </div>
                                    @if ($data->url_video != null)
                                    <div class="video-play">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="ec-header-wishlist d-flex my-3" style="padding: 0" data-bs-toggle="modal"
                                        data-bs-target="#modal-video">
                                        <img src="{{ asset("front/assets/images/putar-video.jpg") }}" width="18%" id="button-video" class="rounded" alt="" srcset="">
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-video" tabindex="-1"
                                            aria-labelledby="modal-video-playLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" id="close-video" aria-hidden="true" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="place_iframe">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal end -->
                                    </div>
                                    <!-- Modal Video -->
                                    @endif
                                    {{-- <div class="video-play">
                                            <a class="ec-header-wishlist" data-link-action="quickview" title="Product Player" data-bs-toggle="modal" data-bs-target="#ec_product_player_modal">
                                                <p style="color: rgb(104, 187, 214); display: inline-block;">Putar Video</p>
                                            </a>
                                        </div> --}}
                                    <div class="ec-single-price-stoke">
                                        <div class="ec-single-price">
                                            <span class="ec-single-ps-title">HARGA</span>
                                            @if (isset($item->diskon) && $item->diskon > 0)
                                                <span class="old-price">{{ "Rp " . number_format($data->harga_jual + ($data->harga_jual / 100 * $data->diskon),0,',','.'); }}</span>
                                            @endif
                                            <span class="new-price">{{ "Rp " . number_format($data->harga_jual,0,',','.'); }}</span>
                                        </div>
                                        <div class="ec-single-stoke">
                                            <span class="ec-single-ps-title">STOCK</span>
                                            <span class="ec-single-sku">{{ $data->stock }}</span>
                                            <input type="text" style="display: none" id="stock"
                                                value="{{ $data->stock }}">
                                        </div>
                                    </div>

                                    <div class="ec-pro-variation">
                                        <div class="ec-pro-variation-inner ec-pro-variation-size">
                                            <span>
                                                <a href="">
                                                    {{ $data->master_seller->nama_toko }}
                                                </a>
                                            </span>
                                            <div class="ec-pro-variation-content">
                                                <h6>{{ $data->master_seller->toko_desc }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ec-single-qty">
                                        <div class="qty-plus-minus">
                                            <input class="qty-input" disabled type="text" name="quantity" id="quantity"
                                                value="{{ ($data->stock > 0) ? 1 : 0 }}" />
                                        </div>
                                        <div class="ec-single-cart ">
                                            <button class="btn btn-primary add-to-cart-package" data-id="{{$data->id}}"
                                                data-image="{{ $data->url_image[0] ?? '' }}"
                                                data-title="{{ $data->nama_produk_desc }}"
                                                data-harga="{{ $data->harga_jual }}" title="Add To Cart"
                                                id="button_add_to_cart">Add To Cart</button>
                                        </div>
                                        <div class="ec-single-wishlist">
                                            @if($data->is_wishlist == 1)
                                            <a class="ec-btn-group wishlist" title="Wishlist"
                                                onclick='add_to_wishlist({{ $data->id }})'><i class="fas fa-heart"
                                                    style="color: pink;"></i></a>
                                            @else
                                            <a class="ec-btn-group wishlist" title="Wishlist"
                                                onclick='add_to_wishlist({{ $data->id }})'><img
                                                    src="{{ asset('front/assets/images/icons/wishlist.svg') }}"
                                                    class="svg_img pro_svg" alt="" /></a>
                                            @endif
                                        </div>
                                        <div class="ec-single-wishlist">
                                            @if($data->is_compare == 1)
                                            <a class="ec-btn-group wishlist" title="compare"
                                                onclick='add_to_compare({{ $data->id }})'><img
                                                    src="{{ asset('front/assets/images/icons/compare.svg') }}"
                                                    class="svg_img pro_svg" alt="" style="fill: #ff9d9d" /></a>
                                            @else
                                            <a class="ec-btn-group wishlist" title="compare"
                                                onclick='add_to_compare({{ $data->id }})'><img
                                                    src="{{ asset('front/assets/images/icons/compare.svg') }}"
                                                    class="svg_img pro_svg" alt="" /></a>
                                            @endif
                                        </div>
                                        <div class="ec-single-wishlist">
                                            <a class="ec-btn-group wishlist" title="Share" onclick="click_share()">
                                                <i class="fas fa-share svg_img pro_svg d-flex align-items-center"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <small style="color: red">Minimal Pembelian untuk produk ini adalah
                                        {{ $data->minimal_order ." ". $data->satuan}}</small>
                                    <div class="ec-single-social">
                                        {{-- <ul class="mb-0">
                                                <li class="list-inline-item facebook"><a href="#"><i
                                                            class="ecicon eci-facebook"></i></a></li>
                                                <li class="list-inline-item twitter"><a href="#"><i
                                                            class="ecicon eci-twitter"></i></a></li>
                                                <li class="list-inline-item instagram"><a href="#"><i
                                                            class="ecicon eci-instagram"></i></a></li>
                                                <li class="list-inline-item youtube-play"><a href="#"><i
                                                            class="ecicon eci-youtube-play"></i></a></li>
                                                <li class="list-inline-item behance"><a href="#"><i
                                                            class="ecicon eci-behance"></i></a></li>
                                                <li class="list-inline-item whatsapp"><a href="#"><i
                                                            class="ecicon eci-whatsapp"></i></a></li>
                                                <li class="list-inline-item plus"><a href="#"><i
                                                            class="ecicon eci-plus"></i></a></li>
                                            </ul> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Single product content End -->
                <!-- Single product tab start -->
                <div class="ec-single-pro-tab">
                    <div class="ec-single-pro-tab-wrapper">
                        <div class="ec-single-pro-tab-nav">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-details"
                                        role="tablist">Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-review"
                                        role="tablist">Reviews</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content  ec-single-pro-tab-content">
                            <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                <div class="ec-single-pro-tab-desc">
                                    @if ($data->deskripsi_produk != '')
                                    {!! $data->deskripsi_produk !!}
                                    @else
                                    <div style="border:2px dashed black;padding: 10px;text-align: center;">
                                        Tidak ada deskripsi
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div id="ec-spt-nav-review" class="tab-pane fade">
                                <div class="row">
                                    @if (count($ulasan))
                                    @foreach ($ulasan as $item)
                                    <div class="ec-t-review-wrapper">
                                        <div class="ec-t-review-item">
                                            <div class="ec-t-review-avtar">
                                                <img src="{{ '/' . $item->transaksi->user->url_image }}"
                                                    alt="" />
                                            </div>
                                            <div class="ec-t-review-content">
                                                <div class="ec-t-review-top">
                                                    <div class="ec-t-review-name">{{ $item->transaksi->user->nama }}
                                                    </div>
                                                    <div class="ec-t-review-rating">
                                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$item->bintang)
                                                            <i class="ecicon eci-star fill"></i>
                                                            @else
                                                            <i class="ecicon eci-star-o"></i>
                                                            @endif
                                                            @endfor
                                                    </div>
                                                </div>
                                                <div class="ec-t-review-bottom">
                                                    <p style="white-space: pre-line">{{ $item->komentar }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div style="border:2px dashed black;padding: 10px;text-align: center;">
                                        Belum ada ulasan
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details description area end -->
                <br>
                <h6><b>Produk Terkait</b></h6>
                @if (count($produk_suggest) > 0)
                <div class="slick-carousel" style="top: 15px">
                    @foreach ($produk_suggest as $item)
                    <div class="ec-single-pro-tab">
                        <div class="mx-2 mb-6 ec-product-content">
                            <div class="ec-product-inner">
                                <div class="ec-pro-image-outer">
                                    <div class="ec-pro-image">
                                        <a href="/produk/{{ $item->nama_produk_slug }}"
                                            style="background-color: #fff; display: flex; justify-content:center; overflow: hidden; height: 250px;"
                                            class="image">
                                            <img class="main-image" style="object-fit: cover; display: block;"
                                                src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->url_image[0] }}"
                                                alt="Product" />
                                            <img class="hover-image"
                                                style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);"
                                                src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->url_image[0] }}"
                                                alt="Product" />
                                        </a>
                                        <span class="ec-com-remove ec-remove-wish-self" style="display: none;"
                                            data-id="{{$item->id}}"><a href="javascript:void(0)">×</a></span>
                                        @if (isset($item->diskon) && $item->diskon > 0)
                                        <span class="percentage">{{ $item->diskon }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ec-pro-content">
                                    <h5 class="ec-pro-title"><a
                                            href="/produk/{{ $item->nama_produk_slug }}">{{ $item->nama_produk_desc }}</a>
                                    </h5>
                                    <div class="ec-pro-rating">
                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$item->bintang)
                                            <i class="ecicon eci-star fill"></i>
                                            @else
                                            <i class="ecicon eci-star-o"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <span class="ec-price">
                                        @if (isset($item->diskon) && $item->diskon > 0)
                                        <span
                                            class="old-price">{{ "Rp " . number_format($item->harga_jual + ($item->harga_jual / 100 * $item->diskon),0,',','.'); }}</span>
                                        @endif
                                        <span
                                            class="new-price">{{ "Rp " . number_format($item->harga_jual,0,',','.'); }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="mt-3" style="border:2px dashed black;padding: 25px;text-align: center;">
                    Produk Terkait tidak ditemukan
                </div>
                @endif
            </div>
        </div>
    </div>
    <input type="text" id="user_id" value="{{ auth()->check() }}" hidden>
</section>
<!-- End Single product -->


@endsection

@section('js')
<script>

    if ($('#stock').val() != 0) {
        var QtyPlusMinus = $(".qty-plus-minus");
        QtyPlusMinus.prepend('<div class="dec ec_qtybtn">-</div>');
        QtyPlusMinus.append('<div class="inc ec_qtybtn">+</div>');

        $(".ec_qtybtn").on("click", function () {
            var $qtybutton = $(this);
            var QtyoldValue = $qtybutton.parent().find("input").val();

            if ($qtybutton.text() === "+") {
                if (parseInt($('#quantity').val()) > parseInt($('#stock').val() - 1)) {
                    var QtynewVal = parseFloat(QtyoldValue);
                } else {
                    var QtynewVal = parseFloat(QtyoldValue) + 1;
                }
            } else {

                if (QtyoldValue > 1) {
                    var QtynewVal = parseFloat(QtyoldValue) - 1;
                } else {
                    QtynewVal = 1;
                }
            }
            $qtybutton.parent().find("input").val(QtynewVal);
        });
    }

    $("body").on("click", ".add-to-cart-package", function () {

        if (!$('#user_id').val()) {
            window.location.href = '/login';
        }

        $('#button_add_to_cart').attr('disabled', true);
        $('#button_add_to_cart').html('<i class="fas fa-spinner fa-spin"></i>');

        var count = $(".ec-cart-count").html();
        count++;
        $(".ec-cart-count").html(count);

        // Remove Empty message
        $(".emp-cart-msg").parent().remove();

        // get an image url
        var str1 = $(this).attr('data-image');
        var img_url = '/commerce/ecom_seller_final/public/berkas/master-produk/' + $(this).attr('data-image');
        
        var p_name = $(this).attr('data-title');
        var p_price = $(this).attr('data-harga');
        var p_id = $(this).attr('data-id');
        var quantity = $('#quantity').val();

        $.ajax({
            url: '/cart/store',
            type: "POST",
            data: {
                'id': p_id,
                'quantity': quantity,
            },
            dataType: 'JSON',
            success: function (response, textStatus, jQxhr) {

                $('#button_add_to_cart').html('ADD TO CART');
                $('#button_add_to_cart').attr('disabled', false);

                if (response.status == 200) {
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });

                    $('.eccart-pro-items').empty();
                    $('#button_checkout').removeClass("disabled");

                    let total_harga = 0;
                    $.each(response.data, function (index, value) {
                        total_harga += parseInt(value.quantity) * parseInt(value
                            .master_produk.harga_jual);

                        var str1 = value.master_produk.url_image[0];
                        var img_url = '/commerce/ecom_seller_final/public/berkas/master-produk/' + value
                            .master_produk.url_image[0];

                        $('.eccart-pro-items').append(`
                                <li id="li_${value.id}">
                                    <a href="/produk/${value.master_produk.nama_produk_slug}" class="sidekka_pro_img"><img src="${img_url}" alt="product"></a>
                                    <div class="ec-pro-content">
                                        <a href="/produk/${value.master_produk.nama_produk_slug}" class="cart_pro_title">${value.master_produk.nama_produk_desc}</a>
                                        <span class="cart-price"><span>${fungsiRupiah(value.master_produk.harga_jual)}</span> x ${value.quantity}</span>
                                        <a href="javascript:void(0)" class="remove" data-id="${value.id}">×</a>
                                    </div>
                                </li>
                            `);
                    });

                    $(".cart-count-lable").html(response.total_quantity);
                    $('#total_belanja').html(fungsiRupiah(total_harga));
                } else if (response.status == 250) {
                    iziToast.warning({
                        title: 'Oops!',
                        message: response.message,
                        position: 'topRight'
                    });
                    $(".cart-count-lable").html(response.total_quantity);
                } else {
                    iziToast.error({
                        title: 'Failed!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                $('#button_add_to_cart').html('ADD TO CART');
                $('#button_add_to_cart').attr('disabled', false);

                Swal.fire('Oops!', 'Terjadi kesalahan segera hubungi tim IT (' + jqXhr
                    .responseText + ')', 'error');

                console.log(errorThrown);
                console.warn(jqXhr.responseText);
            },
        });
    });

    $('#quantity').on("click", function () {
        if ($('#quantity') > $('#stock').val()) {
            $('#quantity') = $('#stock').val();
        }

    })

    $(".slick-slide:not(.slick-cloned)").children().children().attr("mf", "true")
    $("#mf-trigger").on("click", function (e) {
        e.preventDefault();
        $("#mf-trigger").on("click", function (e) {
            e.preventDefault();
            $(".image-product[mf='true']").magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                gallery: {
                    enabled: true
                },
                image: {
                    verticalFit: true
                },
                callbacks: {
                    beforeOpen: function () {
                        // just a hack that adds mfp-anim class to markup
                        this.st.image.markup = this.st.image.markup.replace('mfp-figure',
                            'mfp-figure mfp-with-anim');
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
            }).magnificPopup("open");
        })

    })

    $('.slick-carousel').slick({
        infinite: true,
        slidesToShow: 4, // Shows a three slides at a time
        slidesToScroll: 4, // When you click an arrow, it scrolls 1 slide at a time
        arrows: true, // Adds arrows to sides of slider
        dots: true, // Adds the dots on the bottom
        responsive: [{
                breakpoint: 766,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2 // When you click an arrow, it scrolls 1 slide at a time
                }
            },
            {
                breakpoint: 1016,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3 // When you click an arrow, it scrolls 1 slide at a time
                }
            }
        ]
    });

    $('#modal-video').on('shown.bs.modal', function () {
        $('#place_iframe').html(`<iframe id="iframe_yt" width="100%" height="450" src="{{ $data->url_video }}" allow="autoplay" frameborder="0"></iframe>`);
        let url_youtube = $("#modal-video iframe").attr("src");

        if(url_youtube.indexOf('https://youtu.be/') != -1){
            url_youtube = url_youtube.split('be/')[1];
        }else{
            url_youtube = url_youtube.split('?v=')[1]
        }

        $("#modal-video iframe").attr("src", "https://www.youtube.com/embed/" + url_youtube + "?autoplay=1");

        console.log('bbb');
    });

    $('#modal-video').on('hidden.bs.modal', function () {
        // $("#modal-video iframe").attr("src", $("#modal-video iframe").attr("src"));
        $('#place_iframe').empty();
    });

    function click_share(){
        var dummy = document.createElement('input'),
        text = window.location.href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);

        iziToast.success({
            title: 'Copied!',
            message: 'Link berhasil dicopy',
            position: 'topRight'
        });
    }


</script>
@endsection
