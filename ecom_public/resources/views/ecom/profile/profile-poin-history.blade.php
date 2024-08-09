@extends('partial.app')

@section('css')
<style>
    .point-info{
        font-size: 1.6rem;
        white-space: nowrap;
    }

    .point-title-container{
        padding: 0 0 0 6px!important;
    }

    @media(max-width: 389px){
        .point-info-container{
            font-size: .6rem!important;
        }

        .point-info{
            font-size: .6rem!important;
        }
    }

    @media(max-width: 574px){
        .point-info{
            font-size: .8rem;
            margin: 0 5px 0 0!important;
        }

        .point-info-container{
            font-size: .7rem;
        }

        .point-history-counter{
            margin: 0!important;
            padding: 0 8px 0 0!important;
        }
    }

    @media (min-width: 575px) and (max-width: 767px){
        .point-info{
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<section class="ec-page-content ec-vendor-dashboard section-space-p">
    <div class="container">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">History Poin</h5>
            <p>History perolehan poin yang anda dapatkan</p>
            <hr style="background-color: black; ">
        </div>
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                <div class="ec-sidebar-wrap" style="padding: 0!important">
                    <!-- Sidebar Category Block -->
                    <div class="content-container d-flex align-items-center b2b-info justify-content-center"
                        style="background-image: url({{ asset("front/assets/images/bg/background-3.png") }}); min-height: 250px; padding-left: 25px; flex-direction: column; gap: 25px;">
                        <div class="avatar-container" style="width: 80px; height: 80px">
                            <img src="{{ asset($user->url_image) }}"
                                class="rounded-circle" style="width: 100%; height: 100%" alt="">
                        </div>
                        <div class="account-info pl-3 text-center">
                            <div class="account-name fw-bold text-dark">{{ $user->nama }}</div>
                            <div class="account-email">{{ $user->email }}</div>
                            <div class="account-status fw-bold" style="color: var(--base-color)">Member {{ $user->tipe_customer->customer }}</div><span style="color: var(--base-color)">(Bergabung Sejak {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM Y') }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="ec-vendor-dashboard-sort-card color-green text-end">
                            <h5>Total Point</h5>
                            <h3>{{ number_format($user->poin,0,',','.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="ec-vendor-dashboard-card space-bottom-30">
                    <div class="ec-vendor-card-header">
                        <h5>History</h5>
                    </div>
                    <div class="ec-vendor-card-body" style="padding: 10px">
                        @if (count($data))
                            @foreach ($data as $item)
                                <div class="mt-4 rounded" style="border: 3px solid #f9f9f9">
                                    <div class="row p-2">
                                        <div class="col-sm-8 col-10 point-title-container">
                                            <div style="margin-left: 10px" class="point-info-container">
                                                <p class="fw-bold" style="margin-bottom: 5px!important">{{ \Carbon\Carbon::parse( $item->updated_at )->isoFormat('D MMMM Y HH:mm'); }}</p>
                                                <p class="two-line-only">{{ $item->history_poin }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-2 d-flex justify-content-end align-items-center point-history-counter">
                                            <p class="point-info" style="color: var(--base-color); font-weight: bold; margin-right: 15px">{{ $item->status }} {{ number_format($item->nominal,0,',','.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="mt-4 rounded" style="border: 3px solid #f9f9f9">
                                <div class="row p-2">
                                    <div class="col-sm-8 col-10 point-title-container">
                                        <div style="margin-left: 10px" class="point-info-container">
                                            <p>Tidak Ada Data</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection