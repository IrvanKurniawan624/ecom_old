@extends("partial.app");
@section("css")
<style>
    #ec-progressbar li .ec-progressbar-track::after{
        height: 132%;
        top: -132%;
    }
    #ec-progressbar li{
        margin-bottom: 25px;
    }
    #scrollUp{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media only screen and (max-width: 1199px){
        #ec-progressbar li .ec-track-title{
            max-width: 100%!important;
        }
        #ec-progressbar li .ec-progressbar-track::after{
            height: 152%;
            top: -152%
        }
    }

    @media (max-width: 991px){
        .two-line-only{
            height: 4.7em;
            font-size: .8rem;
            margin-right: 10px;
        }
        #ec-progressbar li{
            margin-bottom: 20px
        }
    }

    @media (max-width: 767px){
       #ec-progressbar li .ec-progressbar-track:after {
        height: 327%!important;
        top: -325%!important;
       } 
    }

    @media (max-width: 300px){
        .ec-track-title .text-secondary{
            font-size: .6rem;
        }
    }
</style>
@endsection
@section("content")
<section class="ec-page-content section-space-p">
    <div class="container">
        <!-- Track Order Content Start -->
        <div class="ec-trackorder-content col-md-12">
            <div class="ec-trackorder-inner">
                <div class="ec-trackorder-top">
                    <h2 class="ec-order-id">{{ $transaksi->no_invoice }}</h2>
                    <div class="ec-order-detail">
                        <div class="my-3">Status : <span>{{ $data['summary']['status'] }}</span></div>
                        <div class="my-1">Tanggal : <span>{{ $data['summary']['waybill_date'] }}</span></div>
                        <div class="my-1">Pengiriman : <span>{{ $data['summary']['courier_name'] }}</span></div>
                        <div class="my-1">No Resi : <span>{{ $data['summary']['waybill_number'] }}</span></div>
                    </div>
                </div>
                <div class="ec-trackorder-bottom">
                    <div class="ec-progress-track">
                        <ul id="ec-progressbar">
                            @foreach ($data['manifest'] as $item)
                                <li class="step0 active">
                                    <span class="ec-progressbar-track mx-3"></span>
                                    {{-- <span class="text-secondary" style="white-space: nowrap">{{ $item['manifest_date'] }} <br> {{ $item['manifest_time'] }}</span> --}}
                                    <span class="ec-track-title"><div class="text-secondary">{{ $item['manifest_date'] }} {{ $item['manifest_time'] }}</div><div class="two-line-only">{{ $item['manifest_description'] }} <br>{{ $item['city_name'] }}</div></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Track Order Content end -->


    </div>
</section>
@endsection
