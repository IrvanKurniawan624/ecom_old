@extends("partial.app");

@section("content")
<section class="ec-page-content ec-vendor-uploads ec-user-account mt-5">
    <div class="container">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Keanggotaan</h5>
            <p>Tipe keanggotaan anda di Kharisma Online</p>
            <hr style="background-color: black; ">
        </div>
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="content-container d-flex align-items-center b2b-info" style="background-image: url({{ asset("front/assets/images/bg/background-3.png") }}); min-height: 200px; padding-left: 50px;">
                    <div class="avatar-container" style="width: 72px; height: 72px">
                        <img src="{{ asset($data->url_image) }}" class="rounded-circle" style="width: 100%; height: 100%" alt="">
                    </div>
                    <div class="account-info pl-3">
                        <div class="account-name fw-bold text-dark">{{ $data->nama }}</div>
                        <div class="account-email">{{ $data->email }}</div>
                        <div class="account-status fw-bold" style="color: var(--base-color)">Member {{ $data->tipe_customer->customer }}</div><span style="color: var(--base-color)">(Bergabung Sejak {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }})</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="content-container d-flex align-items-center" style="background-color: #fbfbfb; min-height: 200px; padding-left: 50px;">
                    <div class="total-belanja">
                        <h5>Total Belanja</h5>
                        <div class="total-belanja-place fw-bold">
                            {{ "Rp " . number_format($total_belanja->total_pembelian,0,',','.'); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="ec-page-content section-space-p" hidden>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h5 class="ec-title" style="padding: 0!important; font-size: 1.7rem">Member Business</h5>
                        </div>
                    </div>
                    <div class="ec-tab-wrapper ec-tab-wrapper-1">
                        <div class="ec-single-pro-tab-wrapper">
                            <div class="ec-single-pro-tab-nav">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-details"
                                            role="tablist">Apa itu member Business?</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-info"
                                            role="tablist">Keuntungan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content  ec-single-pro-tab-content">
                                <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                    <div class="ec-single-pro-tab-desc">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                            Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                            unknown printer took a galley of type and scrambled it to make a type specimen
                                            book. It has survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged.
                                        </p>
                                    </div>
                                </div>
                                <div id="ec-spt-nav-info" class="tab-pane fade">
                                    <div class="ec-single-pro-tab-moreinfo">
                                        <p>It is a long established fact that a reader will be distracted by the readable
                                            content of a page when looking at its layout. The point of using Lorem Ipsum is
                                            that it has a more-or-less normal distribution of letters, as opposed to using
                                            'Content here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @if (auth()->user()->status_upgrade == null || auth()->user()->status_upgrade == '2')
                    <div class="row mt-3">
                        <a href="/profile/upgrade/detail"><button class="btn btn-primary btn block" style="width: 98%; margin-left: 1%">Upgrade Member Business</button></a>
                    </div>
                @elseif(auth()->user()->status_upgrade == '0')
                    <div class="row mt-3">
                        <button class="btn btn-primary btn block" style="width: 98%; margin-left: 1%" disabled>Proses Upgrade Sedang Ditinjau</button>
                    </div>
                @endif
            </div>
        </section>
    </div>
</section>
@endsection
