@php
    use App\Helpers\App;
@endphp

@extends('partial.app')

@section('content')
    <section>
        <!-- Ec breadcrumb start -->
        <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row ec_breadcrumb_inner">
                            <div class="col-md-6 col-sm-12">
                                <h2 class="ec-breadcrumb-title">User Profile</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ec breadcrumb end -->

        <!-- User profile section -->
        <section class="ec-page-content ec-vendor-uploads ec-user-account">
            <div class="container">
                <div class="row">
                    <div class="ec-shop-rightside col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12">
                        <!-- Profile Start -->
                        <div class="content-container ec-vendor-setting-card">
                            <div class="ec-vendor-card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ec-vendor-block-profile">
                                            <div class="ec-vendor-block-img space-bottom-30">
                                                <div class="ec-vendor-block-detail">
                                                    <img class="v-img" src=" {{ isset($data->url_image) ? '/' . $data->url_image : '/front/assets/images/user/1.jpg' }}" alt="vendor image" style="margin-top:1%">
                                                    <h5 class="name">{{ $data->nama }}</h5>
                                                    <p>{{ $data->email }}</p>
                                                    <h5 class="name">( {{ number_format($data->poin,0,',','.'); }} Point )</h5>
                                                    <br>
                                                    <div class="d-flex">
                                                        <a href="profile/detail/{{ auth()->user()->id }}/{{ auth()->user()->tipe_customer_desc }}" class="btn btn-lg btn-primary mx-3">Edit Profile</a>
                                                        {{-- @if (auth()->user()->status_upgrade == null || auth()->user()->status_upgrade == '2') --}}
                                                        <a href="profile/upgrade" class="btn btn-lg btn-danger">Keanggotaan</a>
                                                        {{-- @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                            @if (auth()->user()->tipe_customer_id == '3')
                                                <button class="btn btn-primary btn-block rounded-pill class-business">Member Business</button>
                                            @else
                                                <button class="btn btn-primary btn-block rounded-pill class-customer">Member Customer</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile End -->

                        <!-- list-card Start -->
                        <div class="mb-1">
                            <div class="row">
                                <div class="col-sm-3 col-6 list-card-item">
                                    <a href="profile/transaksi-belanja?status=menungguPembayaran">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M448 32C465.7 32 480 46.33 480 64C480 81.67 465.7 96 448 96H80C71.16 96 64 103.2 64 112C64 120.8 71.16 128 80 128H448C483.3 128 512 156.7 512 192V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H448zM416 336C433.7 336 448 321.7 448 304C448 286.3 433.7 272 416 272C398.3 272 384 286.3 384 304C384 321.7 398.3 336 416 336z"/>
                                        </svg>
                                        <div class="d-flex justify-content-center">
                                            <span class="profile-action-number rounded-circle text-light">{{ App::count_menunggu_pembayaran() }}</span>
                                        </div>
                                        <p>Menunggu Pembayaran</p>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-6 list-card-item">
                                    <a href="profile/transaksi-belanja?status=dikemas">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                            <path d="M75.23 33.4L320 63.1L564.8 33.4C571.5 32.56 578 36.06 581.1 42.12L622.8 125.5C631.7 143.4 622.2 165.1 602.9 170.6L439.6 217.3C425.7 221.2 410.8 215.4 403.4 202.1L320 63.1L236.6 202.1C229.2 215.4 214.3 221.2 200.4 217.3L37.07 170.6C17.81 165.1 8.283 143.4 17.24 125.5L58.94 42.12C61.97 36.06 68.5 32.56 75.23 33.4H75.23zM321.1 128L375.9 219.4C390.8 244.2 420.5 255.1 448.4 248L576 211.6V378.5C576 400.5 561 419.7 539.6 425.1L335.5 476.1C325.3 478.7 314.7 478.7 304.5 476.1L100.4 425.1C78.99 419.7 64 400.5 64 378.5V211.6L191.6 248C219.5 255.1 249.2 244.2 264.1 219.4L318.9 128H321.1z"/></svg>
                                        <div class="d-flex justify-content-center">
                                            <span class="profile-action-number rounded-circle text-light">{{ App::count_dikemas() }}</span>
                                        </div>
                                        <p>Dikemas</p>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-6 list-card-item">
                                    <a href="profile/transaksi-belanja?status=dikirim">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path d="M294.2 277.8c17.1 5 34.62 13.38 49.5 24.62l161.5-53.75c8.375-2.875 12.88-11.88 10-20.25L454.8 47.25c-2.748-8.502-11.88-13-20.12-10.12l-61.13 20.37l33.12 99.38l-60.75 20.13l-33.12-99.38L251.2 98.13c-8.373 2.75-12.87 11.88-9.998 20.12L294.2 277.8zM574.4 309.9c-5.594-16.75-23.67-25.91-40.48-20.23l-202.5 67.51c-17.22-22.01-43.57-36.41-73.54-36.97L165.7 43.75C156.9 17.58 132.5 0 104.9 0H32C14.33 0 0 14.33 0 32s14.33 32 32 32h72.94l92.22 276.7C174.7 358.2 160 385.3 160 416c0 53.02 42.98 96 96 96c52.4 0 94.84-42.03 95.82-94.2l202.3-67.44C570.9 344.8 579.1 326.6 574.4 309.9zM256 448c-17.67 0-32-14.33-32-32c0-17.67 14.33-31.1 32-31.1S288 398.3 288 416C288 433.7 273.7 448 256 448z"/></svg>
                                        <div class="d-flex justify-content-center">
                                            <span class="profile-action-number rounded-circle text-light">{{ App::count_dikirim() }}</span>
                                        </div>
                                        <p>Dikirim</p>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-6 list-card-item">
                                    <a href="profile/transaksi-belanja?status=penilaian">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/></svg>
                                        <div class="d-flex justify-content-center">
                                            <span class="profile-action-number rounded-circle text-light">{{ App::count_beri_penilaian() }}</span>
                                        </div>
                                        <p>Beri Penilaian</p>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Menu/Service Area Start -->
                        <div class="ec-shop-leftside ec-vendor-sidebar profile-content-container">
                            <div class="ec-sidebar-wrap">
                                <!-- Sidebar Category Block -->
                                <div class="ec-sidebar-block">
                                    <div class="row">
                                        <div class="ec-vendor-block col-lg-6 col-sm-12 col-md-6">
                                            <div class="ec-vendor-block-items menu-service-container">
                                                <h5>MENU</h5>
                                                <ul>
                                                    <li>
                                                        <a href="/profile/alamat-pengiriman">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                                                <path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg>
                                                            Alamat Pengiriman
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                            <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/transaksi-belanja">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                                <path d="M96 0C107.5 0 117.4 8.19 119.6 19.51L121.1 32H541.8C562.1 32 578.3 52.25 572.6 72.66L518.6 264.7C514.7 278.5 502.1 288 487.8 288H170.7L179.9 336H488C501.3 336 512 346.7 512 360C512 373.3 501.3 384 488 384H159.1C148.5 384 138.6 375.8 136.4 364.5L76.14 48H24C10.75 48 0 37.25 0 24C0 10.75 10.75 0 24 0H96zM128 464C128 437.5 149.5 416 176 416C202.5 416 224 437.5 224 464C224 490.5 202.5 512 176 512C149.5 512 128 490.5 128 464zM512 464C512 490.5 490.5 512 464 512C437.5 512 416 490.5 416 464C416 437.5 437.5 416 464 416C490.5 416 512 437.5 512 464z"/></svg>
                                                            Transaksi Belanja
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                            </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/history-poin">                                                        
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-coin" viewBox="0 0 16 16">
                                                                <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                                              </svg>
                                                            History Poin
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/voucher">                                                        
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                                <path d="M128 160H448V352H128V160zM512 64C547.3 64 576 92.65 576 128V208C549.5 208 528 229.5 528 256C528 282.5 549.5 304 576 304V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V304C26.51 304 48 282.5 48 256C48 229.5 26.51 208 0 208V128C0 92.65 28.65 64 64 64H512zM96 352C96 369.7 110.3 384 128 384H448C465.7 384 480 369.7 480 352V160C480 142.3 465.7 128 448 128H128C110.3 128 96 142.3 96 160V352z"/></svg>
                                                            Voucher
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/wishlist">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path d="M0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84.02L256 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 .0003 232.4 .0003 190.9L0 190.9z"/></svg>
                                                            Wishlist
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/notifikasi">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                <path d="M256 32V51.2C329 66.03 384 130.6 384 208V226.8C384 273.9 401.3 319.2 432.5 354.4L439.9 362.7C448.3 372.2 450.4 385.6 445.2 397.1C440 408.6 428.6 416 416 416H32C19.4 416 7.971 408.6 2.809 397.1C-2.353 385.6-.2883 372.2 8.084 362.7L15.5 354.4C46.74 319.2 64 273.9 64 226.8V208C64 130.6 118.1 66.03 192 51.2V32C192 14.33 206.3 0 224 0C241.7 0 256 14.33 256 32H256zM224 512C207 512 190.7 505.3 178.7 493.3C166.7 481.3 160 464.1 160 448H288C288 464.1 281.3 481.3 269.3 493.3C257.3 505.3 240.1 512 224 512z"/></svg>
                                                            Notifikasi
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ec-vendor-block col-lg-6 col-sm-12 col-md-6" id="service-menu">
                                            <div class="ec-vendor-block-items menu-service-container">
                                                <h5>LAYANAN</h5>
                                                <ul>
                                                    <li>
                                                        <a href="/profile/kebijakan-privasi">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                            <path d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z"/></svg>
                                                        Kebijakan Privasi
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                            <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/syarat-ketentuan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                                                <path d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg>
                                                            Syarat dan Ketentuan
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profile/hubungi-kami">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path d="M511.2 387l-23.25 100.8c-3.266 14.25-15.79 24.22-30.46 24.22C205.2 512 0 306.8 0 54.5c0-14.66 9.969-27.2 24.22-30.45l100.8-23.25C139.7-2.602 154.7 5.018 160.8 18.92l46.52 108.5c5.438 12.78 1.77 27.67-8.98 36.45L144.5 207.1c33.98 69.22 90.26 125.5 159.5 159.5l44.08-53.8c8.688-10.78 23.69-14.51 36.47-8.975l108.5 46.51C506.1 357.2 514.6 372.4 511.2 387z"/></svg>
                                                        Hubungi Kami
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                            <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/errors/hubungi-kami">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16" id="IconChangeColor"> <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z" id="mainIconPathAttribute" fill="#000000"></path> </svg>
                                                            Chat Kami
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                            </a>
                                                    </li>
                                                    <li>
                                                        <a href="/logout">
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 1.3rem!important">
                                                                <path d="M22 6.62219V17.245C22 18.3579 21.2857 19.4708 20.1633 19.8754L15.0612 21.7977C14.7551 21.8988 14.449 22 14.0408 22C13.5306 22 12.9184 21.7977 12.4082 21.4942C12.2041 21.2918 11.898 21.0895 11.7959 20.8871H7.91837C6.38776 20.8871 5.06122 19.6731 5.06122 18.0544V17.0427C5.06122 16.638 5.36735 16.2333 5.87755 16.2333C6.38776 16.2333 6.69388 16.5368 6.69388 17.0427V18.0544C6.69388 18.7626 7.30612 19.2684 7.91837 19.2684H11.2857V4.69997H7.91837C7.20408 4.69997 6.69388 5.20582 6.69388 5.91401V6.9257C6.69388 7.33038 6.38776 7.73506 5.87755 7.73506C5.36735 7.73506 5.06122 7.33038 5.06122 6.9257V5.91401C5.06122 4.39646 6.28572 3.08125 7.91837 3.08125H11.7959C12 2.87891 12.2041 2.67657 12.4082 2.47423C13.2245 1.96838 14.1429 1.86721 15.0612 2.17072L20.1633 4.09295C21.1837 4.39646 22 5.50933 22 6.62219Z" fill="#030D45"/>
                                                                <path d="M4.85714 14.8169C4.65306 14.8169 4.44898 14.7158 4.34694 14.6146L2.30612 12.5912C2.20408 12.49 2.20408 12.3889 2.10204 12.3889C2.10204 12.2877 2 12.1865 2 12.0854C2 11.9842 2 11.883 2.10204 11.7819C2.10204 11.6807 2.20408 11.5795 2.30612 11.5795L4.34694 9.55612C4.65306 9.25261 5.16327 9.25261 5.46939 9.55612C5.77551 9.85963 5.77551 10.3655 5.46939 10.669L4.7551 11.3772H8.93878C9.34694 11.3772 9.7551 11.6807 9.7551 12.1865C9.7551 12.6924 9.34694 12.7936 8.93878 12.7936H4.65306L5.36735 13.5017C5.67347 13.8052 5.67347 14.3111 5.36735 14.6146C5.26531 14.7158 5.06122 14.8169 4.85714 14.8169Z" fill="#030D45"/>
                                                            </svg>
                                                            Logout
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                                                <path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Menu/Service Area End -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End User profile section -->
    </section>
    <input type="text" hidden id="user_id" value="{{ auth()->user()->id }}">
@endsection

@section('js')
    @if (auth()->check())
        <script>
            $(document).ready(function(){
                localStorage.setItem("user_id", $('#user_id').val());
            });
        </script>
    @endif
@endsection
