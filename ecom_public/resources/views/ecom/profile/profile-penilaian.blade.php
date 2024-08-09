@extends('partial.app')

@section('css')
<style>
    .jasa-pengiriman-text{
        text-align: center;
    }

    .btn-penilaian:hover{
        background: #ff9c53!important;
    }

    @media (max-width: 574px){
    .jasa-pengiriman-text{
        font-size: .7rem;
    }
}
</style>
@endsection

@section('content')
<div class="row sticky-header-next-sec">
    <!-- Start Terms & Condition page -->
    <div class="content-container mt-4 col-12 col-md-8 offset-md-2" style="padding-bottom: 0; margin-bottom: 0">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Penilaian</h5>
            <p>Yuk bantu kami dalam menilai produk kami</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body text-center pb-2">
            <div class="row">
                <form id="form_submit" method="post" action="/profile/penilaian/store">
                    @foreach ($data as $key => $item)
                        <input type="text" name="id[]" value="{{ $item->id }}" hidden>
                        <input type="text" name="transaksi_id" value="{{ $item->transaksi->id }}" hidden>
                        <div class="ec-pro-rightside ec-common-rightside">
                            <!-- Single product content Start -->
                            <div class="transaksi-content mt-5 rounded">
                                <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                                    <div class="row mb-2">
                                        <div class="col-lg-8 col-md-6 col-12">
                                            <a href="/profile/transaksi-belanja/invoice/" class="fw-bold float-left text-start">{{ $item->master_produk->nama_produk_desc }}</a><br>
                                            <p class="fw-bold float-left" style="color: var(--base-color)">{{ $item->master_produk->master_subkategori->subkategori }}</p>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12 d-flex justify-content-end align-items-center">
                                            <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                                style="background-color: var(--base-color); color: white">{{ $item->transaksi->jasa_pengiriman }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="transaksi-body mt-3">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-2 col-4 transaksi-img-container align-items-center">
                                            <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/'.$item->master_produk->url_image[0] }}"
                                                class="transaksi-img penilaian-image" alt="" srcset="">
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-8">
                                            <div class="nama-produk ">
                                                @foreach ($item->master_produk->master_produk_properties as $properties)
                                                    <div class="ec-pro-variation-inner ec-pro-variation-size">
                                                        <span class="fw-bold">{{ $properties->master_properties->properties }}</span>
                                                        <div class="ec-pro-variation-content">
                                                            <h6>{{ $properties->value }}</h6>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-6 total-pesanan-container">
                                            <div class="harga-barang">
                                                <p style="margin: 0!important">Harga</p>
                                                <p class="fw-bold">{{ "Rp " . number_format($item->harga,0,',','.'); }} <span>x {{ $item->quantity }}</span></p>
                                            </div>
                                            <div class="total-pesanan">
                                                <p style="margin: 0!important">Total Pesanan</p>
                                                <p class="fw-bold">{{ "Rp " . number_format($item->transaksi->total_harga,0,',','.'); }}</p>
                                            </div>
                                        </div>
                                        <div class=" col-md-3 col-sm-3 col-6 d-flex justify-content-start align-items-center rating-container" style="margin: 0!important; padding: 0!important">
                                            <div class="ec-single-rating-wrap d-flex">
                                                <div class="ec-single-rating rating-wrap">
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @for ($i = 0; $i < 5; $i++)
                                                    @php
                                                        $count++;
                                                    @endphp
                                                        @if (isset($item->bintang) && $count <= $item->bintang)
                                                            <i class="ecicon eci-star fill {{ $key }}"></i>
                                                        @else
                                                            <i class="ecicon eci-star-o unstarred {{ $key }}"></i>

                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="ec-read-review mx-2"></span>
                                                <input type="text" class="required-field" name="bintang[]" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="transaksi-footer">
                                    <div class="row mt-4">
                                        <div class="ec-review-note">
                                            <div class="form-outline form-white">
                                                <textarea class="form-control required-field" name="komentar[]" id="ta" placeholder="Message" style="resize: none; padding: 4px 13px; min-height: 90px!important;" maxlength="500" rows="4" @if ($transaksi->is_penilaian == 1) readonly @endif>{{ $item->komentar }}</textarea>
                                                <p class="text-danger pt-3 pb-1" id="review-max-warning" style="display: none">Max Character Allowed 500</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <br>
                    @if ($transaksi->is_penilaian == 0)
                        <button type="submit" class="btn btn-block btn-penilaian" style="background-color: var(--base-color); color: white; width: 175px; margin: auto">Beri Penilaian</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    @if ($transaksi->is_penilaian == 0)
        <script>
            $(".rating-wrap i").mouseover(function(){
                let currentRating = $(this);
                $(this).each(function(index){
                    $(this).prevAll().addBack().removeClass("eci-star-o");
                    $(this).prevAll().addBack().addClass("eci-star");
                    $(this).prevAll().addBack().addClass("fill");
                    $(this).prevAll().addBack().addClass("fill-review");
                    if(index === currentRating.index()){
                        return false;
                    }
                })
            })

            $(".rating-wrap i").mouseleave(function(){
                $(".rating-wrap i").removeClass("fill-review");
                $(".rating-wrap .unstarred").addClass("eci-star-o");
                $(".rating-wrap .unstarred").removeClass("eci-star");
                $(".rating-wrap .unstarred").removeClass("fill");
            })

            $(".rating-wrap i").click(function(){
                $(this).addClass("unstarred");
                $(this).hasClass("fill-review") ? $(this).prevAll().andSelf().addClass("eci-star"): null;
                $(this).hasClass("fill-review") ? $(this).prevAll().andSelf().addClass("fill"): null;
                $(this).hasClass("fill-review") ? $(this).prevAll().andSelf().removeClass("unstarred"): null;
                $(this).nextAll().addClass("unstarred");
                $(this).siblings().hasClass("unstarred") ? $(this).nextAll().removeClass("eci-star") : null;
                $(this).siblings().hasClass("unstarred") ? $(this).nextAll().removeClass("fill") : null;
                $(this).siblings().hasClass("unstarred") ? $(this).nextAll().addClass("eci-star-o") : null;
                let reviewCount = $(this).prevAll().andSelf().length;
                $(this).parent().next().text(reviewCount + ".0");
                $(this).parent().next().next().val(reviewCount);
                $(".transaksi-footer").css("display", "block")
            })
        </script>
    @endif

    <script>
        $("#ta").keyup(function (e) {
            autoheight(this);
        });

        function autoheight(a) {
            if (!$(a).prop('scrollTop')) {
                do {
                    var b = $(a).prop('scrollHeight');
                    var h = $(a).height();
                    $(a).height(h - 5);
                }
                while (b && (b != $(a).prop('scrollHeight')));
            };
            $(a).height($(a).prop('scrollHeight'));
        }

        autoheight($("#ta"));

        $("#ta").on('input', function() {
            if ($(this).val().length >= 500) {
                $("#review-max-warning").css("display", "block");
            } else {
                $("#review-max-warning").css("display", "none");
            }
        });
    </script>
@endsection
