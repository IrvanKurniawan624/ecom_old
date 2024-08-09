<?php
use App\Helpers\App;
?>
@extends('partial.app')
@section('content')
<div class="row fix-overleap sticky-header-next-sec">
    <div class="content-container mt-4 col-12 col-md-8 offset-md-2">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path
                            d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z" />
                    </svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Notifikasi</h5>
            <p>Notifikasi Yang Anda Terima</p>
            <hr style="background-color: black; ">
        </div>

        @if (App::get_data_notification() != 'null' || App::count_notification() != 0)
            @foreach (App::get_data_notification() as $item)
            <div class="mt-4 rounded" style="border: 3px solid #f9f9f9">
                <div class="row p-3">
                    <div class="notification-detail-header col-12 d-flex align-items-center" style="border-bottom: 3px solid var(--base-color); border-radius: 0 0 0 20px">
                        <i class="fas fa-bell mx-2" style="font-size: 1.4rem; transform: rotate(15deg); color: var(--base-color)"></i>
                        <p style="margin: 0 6px 0 10px!important">Notifikasi</p>
                        <span style="font-size: 1.4rem">•</span>
                        <div class="time-notification" style="margin-left: 5px; font-size: .9rem">{{ $item->created_at->diffForHumans(); }}</div>
                    </div>
                    <div class="notification-detail-body mt-3">
                        {!! $item->notification_alert_full !!}
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="container my-4 d-flex justify-content-center align-items-center" style="flex-direction: column">
                <img src="{{ asset("front/assets/images/project/not-found-2.png") }}" width="45%" alt="">
                <h4 class="fw-bold mt-5">Notifikasi Kosong</h4>
            </div>
        @endif
    </div>
</div>
@endsection
