@extends('partial.app')

@section('content')

    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Compare</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="/">Home</a></li>
                                <li class="ec-breadcrumb-item active">Compare</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec Compare page Start -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Start -->
                <div class="ec-compare-leftside col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-compare-title">Product <br>Specifications</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Sidebar end -->
                <!-- Compare Content Start -->
                <div class="ec-compare-rightside col-lg-9 col-md-12">
                    <!-- Compare content Start -->
                    <div class="ec-compare-content">
                        <div class="ec-compare-inner">
                            <div class="row">
                                @foreach ($data as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content prod-1">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="/produk/{{ $item->master_produk->nama_produk_slug }}" class="image" style="background-color: #fff; display: flex; justify-content:center; overflow: hidden; height: 250px;">
                                                    <img class="main-image" style="object-fit: cover; display: block;"
                                                        src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->master_produk->url_image[0] }}" alt="Product" />
                                                    <img class="hover-image" style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);"
                                                        src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->master_produk->url_image[0] }}" alt="Product" />
                                                </a>
                                                <span class="ec-com-remove ec-remove-compare-self" data-id="{{$item->master_produk->id}}"><a href="javascript:void(0)">×</a></span>
                                                @if (isset($item->master_produk->diskon) && $item->master_produk->diskon > 0)
                                                    <span class="percentage">{{ $item->master_produk->diskon }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="/produk/{{ $item->master_produk->nama_produk_slug }}">{{ $item->master_produk->nama_produk_desc }}</a></h5>
                                            <div class="ec-pro-rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $item->master_produk->bintang)
                                                        <i class="ecicon eci-star fill"></i>
                                                    @else
                                                        <i class="ecicon eci-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ec-price">
                                                @if (isset($item->master_produk->diskon))
                                                    <span class="old-price">{{ "Rp " . number_format($item->master_produk->harga_jual + ($item->master_produk->harga_jual / 100 * $item->master_produk->diskon),0,',','.'); }}</span>
                                                @endif
                                                <span class="new-price">{{ "Rp " . number_format($item->master_produk->harga_jual,0,',','.'); }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <!--compare content End -->
                </div>
                <!-- Compare Content end -->
            </div>
            <div class="row align-items-center" id="place_description">
                <!-- Sidebar Start -->
                <div class="ec-compare-leftside col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-compare-title">Product <br>Description</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Sidebar end -->
                <!-- Compare Content Start -->
                <div class="ec-compare-rightside col-lg-9 col-md-12">
                    <!-- Compare content Start -->
                    <div class="ec-compare-content">
                        <div class="ec-compare-inner">
                            <div class="row">
                                @foreach ($data as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content-desc-{{$item->master_produk->id}} prod-1">
                                        <div class="content-container">
                                            <div class="row">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {!! $item->master_produk->deskripsi_produk !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--compare content End -->
                </div>
            </div>
        </div>
    </section>
    <!--Ec Compare Page End-->
@endsection

@section('js')
<script>

    $(document).ready(function(){
        var wish_product_count = $(".pro-gl-content").length;
        if (wish_product_count == 0) {
            $('.ec-compare-rightside').html('<p class="emp-wishlist-msg">Your Compare list is empty!</p>');
            $('#place_description').empty();
        }
    })

    $(".ec-remove-compare-self").on("click", function () {
        $(this).parents(".pro-gl-content").remove();
        $('.pro-gl-content-desc-' + $(this).attr('data-id')).remove();
        $.ajax({
            url: '/compare/delete/' + $(this).attr('data-id'),
            type: "DELETE",
            dataType: 'JSON',
            success: function( data, textStatus, jQxhr ){
                var wish_product_count = $(".pro-gl-content").length;
                if (wish_product_count == 0) {
                    $('.ec-compare-rightside').html('<p class="emp-wishlist-msg">Your Compare list is empty!</p>');
                    $('#place_description').attr('hidden', true);
                }
                $('.count_compare').html(data.data);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
            },
        });
    });
</script>
@endsection
