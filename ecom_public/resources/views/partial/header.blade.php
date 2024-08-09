<?php
use App\Helpers\App;
?>

<header class="ec-header">
    <!--Ec Header Top Start -->
    <div class="header-top position-relative">
        <div class="container">
            <div class="row align-items-center">
                <!-- Header Top social Start -->
                <div class="col text-left header-top-left d-none d-lg-block">
                    <div class="header-top-social">
                        <span class="social-text text-upper">Follow us on:</span>
                        <ul class="mb-0">
                            <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                        class="ecicon eci-facebook"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                        class="ecicon eci-twitter"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                        class="ecicon eci-instagram"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                        class="ecicon eci-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Header Top social End -->
                <!-- Header Top Language Currency -->
                <!-- Header Top Language Currency -->
                <!-- Header Top responsive Action -->
                <div class="col d-lg-none header-mobile">
                    <div class="row">
                        <div class="col-8 overflow-hidden position-relative">
                            <div class="d-flex" style="float: left; width: 95%">
                                <div class="ec-header-bottons d-none" id="dropdown-md">
                                    <!-- Header User Start -->
                                    <div class="ec-header-user dropdown" style="margin-left: 15px">
                                        <button class="dropdown-toggle" data-bs-toggle="dropdown">
                                            @if (Auth::check())
                                            <div class="row">
                                                <div
                                                    class="col-11 d-flex justify-content-center align-items-center padding-r-low">
                                                    <img src="{{ '/' . auth()->user()->url_image }}"
                                                        style="width: 42px; height: 39px!important" height="auto"
                                                        class="rounded" alt="" srcset="">
                                                </div>
                                            </div>
                                            @else
                                            <img src="/front/assets/images/icons/user.svg"
                                                class="svg_img header_svg" alt="" />
                                            @endif

                                        </button>
                                        @if (Auth::check())
                                        <ul class="dropdown-menu" style="overflow: unset!important">
                                            <li><a class="dropdown-item" href="/profile">
                                                    <i class="fas fa-user header-icon-right"></i>
                                                    Akun Saya
                                                </a></li>
                                            <li><a class="dropdown-item" href="/profile/alamat-pengiriman">
                                                    <i class="fas fa-map-marker-alt header-icon-right"></i>
                                                    Alamat Pengiriman
                                                </a></li>
                                            <li><a class="dropdown-item" href="/wishlist">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -28 512.001 512"
                                                        src="/front/assets/images/icons/wishlist.svg"
                                                        class="svg_img header-icon-right" alt="">
                                                        <path
                                                            d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0">
                                                        </path>
                                                    </svg>
                                                    Wishlist
                                                    <span class="count-header rounded-circle text-light count_wishlist"
                                                        id="count_wishlist">{{ App::count_wishlist() }}</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="/compare">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                        id="Capa_1" x="0px" y="0px" viewBox="0 0 384.962 384.962"
                                                        style="enable-background:new 0 0 384.962 384.962;"
                                                        xml:space="preserve"
                                                        src="/front/assets/images/icons/compare.svg"
                                                        class="svg_img header-icon-right" alt="">
                                                        <g>
                                                            <g id="Double_Arrow_Left_x2F_Right">
                                                                <path
                                                                    d="M40.942,156.619h187.589c6.641,0,12.03-5.438,12.03-12.151c0-6.713-5.39-12.151-12.03-12.151H40.942l62.558-63.46    c4.704-4.752,4.704-12.439,0-17.179c-4.704-4.752-12.319-4.752-17.011,0l-82.997,84.2c-4.632,4.68-4.68,12.512,0,17.191    l83.009,84.2c4.704,4.752,12.319,4.74,17.011,0c4.704-4.74,4.704-12.439,0-17.179L40.942,156.619z">
                                                                </path>
                                                                <path
                                                                    d="M381.472,231.904l-83.009-84.2c-4.704-4.752-12.319-4.74-17.011,0c-4.704,4.74-4.704,12.439,0,17.179l62.558,63.46    H156.421c-6.641,0-12.03,5.438-12.03,12.151c0,6.713,5.39,12.151,12.03,12.151H344.01l-62.558,63.46    c-4.704,4.752-4.704,12.439,0,17.179c4.704,4.752,12.319,4.752,17.011,0l82.997-84.2    C386.104,244.416,386.152,236.584,381.472,231.904z">
                                                                </path>
                                                            </g>
                                                            <g></g>
                                                            <g></g>
                                                            <g></g>
                                                            <g></g>
                                                            <g></g>
                                                            <g></g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>
                                                    Compare
                                                    <span class="count-header rounded-circle text-light count_compare"
                                                        id="count_compare">{{ App::count_compare() }}</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="/logout">
                                                    <i class="fas fa-sign-out-alt header-icon-right"></i>
                                                    Log Out
                                                </a></li>
                                        </ul>
                                        @else
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a class="dropdown-item" href="/register">Register</a></li>
                                            <li><a class="dropdown-item" href="/login">Login</a></li>
                                        </ul>
                                        @endif
                                    </div>
                                </div>

                                <div class="header-search" style="display: none; max-width: unset!important"
                                    id="search-mobile">
                                    <form class="ec-btn-group-form search-bar" action="#" style="z-index: 5">
                                        <input class="form-control search" autocomplete="off"
                                            placeholder="Search Products..." type="text"
                                            value="{{ app('request')->input('search') }}" id
                                            onkeyup="keyup_search(this.value)">
                                    </form>
                                </div>
                            </div>
                            <button class="submit place_alert_search loading-search-mobile" type="button"
                                style="z-index: 500" disabled><img
                                    src="{{ asset('front/assets/images/icons/loading.svg') }}"
                                    class="svg_img header_svg" alt="" /></button>
                        </div>

                        <div class="col-4" style="justify-content: end; display: flex; gap: 1rem;">
                            <!-- Header Cart Start -->
                            <a href="/compare"
                                class="ec-header-btn ec-header-compare align-items-center no-padding d-flex">
                                <div class="header-icon"><img src="{{ asset('front/assets/images/icons/compare.svg') }}"
                                        class="svg_img header_svg" alt="" /></div>
                                <span
                                    class="ec-header-count mobile-header-number rounded-circle text-light count_compare">{{ App::count_compare() }}</span>
                            </a>
                            <!-- Header Cart End -->
                            <!-- Header Cart Start MOBILE -->
                            <div class="ec-header-btn align-items-center d-flex notification-container notification-header-btn"
                                style="padding: 0;">
                                <a href="/profile/notifikasi">
                                    <div class="header-icon"><i class="fas fa-bell icon-header"></i></div>
                                </a>
                                <span
                                    class="ec-header-count mobile-header-number rounded-circle text-light">{{ App::count_notification() }}</span>
                                {{-- <div class="content-container-2 notification-popover" style="padding: 0; z-index: 2; left: unset!important; width: 210px!important;">
                                    <p class="fw-bold my-2 rounded" style="color: var(--base-color); position: fixed; background: #FEFEFE; text-align: center; width: 94%; margin-top: 0!important; padding: 6px 0">Notifikasi Baru <span>({{ App::count_notification() }})</span>
                                </p>
                                <ul class="notification-list" style="overflow: auto">
                                    @if (App::get_data_notification() != 'null' || App::count_notification() != 0)
                                    @foreach (App::get_data_notification() as $item)
                                    <li>
                                        {!! $item->notification_alert !!}
                                    </li>
                                    <div class="border-test-responsive"></div>
                                    @endforeach
                                    @else
                                    <li>Tidak ada notification</li>
                                    @endif
                                </ul>
                            </div> --}}
                        </div>
                    </div>

                    <div class="content-container search-popover search-popover-mobile"
                        style="border-radius: 0 0 14px 14px!important; width: 66.6666666667%; z-index: 600; padding: 0; left: 15px; z-index: 2;">
                        <ul class="suggestion place_search" style="overflow: scroll!important">
                        </ul>
                        {{-- <header class="trending">
                                <h5>Trending Search</h5>
                                <div class="trending-box">Perlengkapan Alat Tulis</div>
                                <div class="trending-box">PC</div>
                                <div class="trending-box">Peralatan Kantor</div>
                                <div class="trending-box">PC</div>
                                <div class="trending-box">Peralatan Kantor</div>
                            </header> --}}
                    </div>
                </div>
                <!-- Header Cart End -->
            </div>
            <!-- Header Top responsive Action -->
        </div>
    </div>
    </div>
    <!-- Ec Header Top  End -->
    <!-- Ec Header Bottom  Start -->
    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="row">
                    <!-- Ec Header Logo Start -->
                    <div class="align-self-center col-md-3">
                        <div class="header-logo">
                            <a href="/"><img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                    alt="Site Logo" /><img class="dark-logo"
                                    src="{{ asset('front/assets/images/custom-image/logo_new.png') }}" alt="Site Logo"
                                    style="display: none;" /></a>
                        </div>
                    </div>
                    <!-- Ec Header Logo End -->

                    <!-- Ec Header Search Start -->
                    <div class="align-self-center col-md-6 d-flex justify-content-center">
                        <div class="header-search">
                            <form class="ec-btn-group-form search-bar" action="#" style="z-index: 5">
                                <input class="form-control search" autocomplete="off" placeholder="Search Products..."
                                    type="text" value="{{ app('request')->input('search') }}" id
                                    onkeyup="keyup_search(this.value)">
                                <button class="submit place_alert_search" hidden type="button" disabled><img
                                        src="{{ asset('front/assets/images/icons/loading.svg') }}"
                                        class="svg_img header_svg" alt="" /></button>
                                <button type="button"
                                    style="position: absolute; right: 3%; top: 11px; font-weight: bold;"
                                    id="hapus-search" onclick="click_hapus_search()" hidden>X</button>
                            </form>
                            <div class="content-container search-popover"
                                style="border-radius: 0 0 14px 14px!important; padding: 0; z-index: 2; top: 30px">
                                <ul class="suggestion place_search">
                                </ul>
                                {{-- <header class="trending">
                                    <h5>Trending Search</h5>
                                    <div class="trending-box">Perlengkapan Alat Tulis</div>
                                    <div class="trending-box">PC</div>
                                    <div class="trending-box">Peralatan Kantor</div>
                                    <div class="trending-box">PC</div>
                                    <div class="trending-box">Peralatan Kantor</div>
                                </header> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Ec Header Search End -->

                    <!-- Ec Header Button Start -->
                    <div class="align-self-center col-md-3">
                        <div class="ec-header-bottons">
                            <!-- Notification -->
                            <div class="ec-header-btn align-items-center no-padding d-flex notification-container">
                                <div class="header-icon"><i class="fas fa-bell icon-header"></i></div>
                                <span class="ec-header-count mobile-header-number rounded-circle text-light"
                                    style="position: absolute; right: -13px">{{ App::count_notification() }}</span>
                                <div class="content-container-2 notification-popover" style="padding: 0; z-index: 2;">
                                    <ul class="notification-list" style="overflow: auto">
                                        <p class="fw-bold my-2"
                                            style="color: var(--base-color); position: fixed; background: white; width: 100%; z-index: 5; margin-top: 0!important; padding: 6px 0">
                                            Notifikasi Baru <span>({{ App::count_notification() }})</span></p>
                                        @if (App::get_data_notification() != 'null' || App::count_notification() != 0)
                                        @foreach (App::get_data_notification() as $item)
                                        <li class="notification-list-item">
                                            <a href="/profile/notifikasi">{!! $item->notification_alert !!}</a>
                                        </li>
                                        <hr style="margin: 0!important; background-color: black!important">
                                        @endforeach
                                        @else
                                        <li>Tidak ada notification</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- Notification End -->
                            <!-- Header Cart Start -->
                            <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                <div class="header-icon"><img src="{{ asset('front/assets/images/icons/cart.svg') }}"
                                        class="svg_img header_svg" alt="" /></div>
                                <span class="ec-header-count cart-count-lable count_cart"
                                    id="count_cart">{{ App::count_cart() }}</span>
                            </a>
                            <!-- Header Cart End -->
                            <!-- Header User Start -->
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                                    @if (Auth::check())
                                    <div class="row">
                                        {{-- <div class="col-1 no-padding" style="width: auto">
                                                <div class="vr vertical-hr" style="width: 5px; height: 100%"></div>
                                            </div> --}}
                                        <div
                                            class="col-11 d-flex justify-content-center align-items-center padding-r-low">
                                            <img src="{{ '/' . auth()->user()->url_image }}"
                                                style="width: 42px; height: 39px!important" height="auto"
                                                class="rounded" alt="" srcset="">
                                        </div>
                                    </div>
                                    @else
                                    <img src="/front/assets/images/icons/user.svg"
                                        class="svg_img header_svg" alt="" />
                                    @endif

                                </button>
                                @if (Auth::check())
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a class="dropdown-item" href="/profile">
                                            <i class="fas fa-user header-icon-right"></i>
                                            Akun Saya
                                        </a></li>
                                    <li><a class="dropdown-item" href="/profile/alamat-pengiriman">
                                            <i class="fas fa-map-marker-alt header-icon-right"></i>
                                            Alamat Pengiriman
                                        </a></li>
                                        <li><a class="dropdown-item" href="/wishlist">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -28 512.001 512"
                                                src="/front/assets/images/icons/wishlist.svg"
                                                class="svg_img header-icon-right" alt="">
                                                <path
                                                    d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0">
                                                </path>
                                            </svg>
                                            Wishlist
                                            <span class="count-header rounded-circle text-light count_wishlist"
                                                id="count_wishlist">{{ App::count_wishlist() }}</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="/compare">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                id="Capa_1" x="0px" y="0px" viewBox="0 0 384.962 384.962"
                                                style="enable-background:new 0 0 384.962 384.962;"
                                                xml:space="preserve"
                                                src="/front/assets/images/icons/compare.svg"
                                                class="svg_img header-icon-right" alt="">
                                                <g>
                                                    <g id="Double_Arrow_Left_x2F_Right">
                                                        <path
                                                            d="M40.942,156.619h187.589c6.641,0,12.03-5.438,12.03-12.151c0-6.713-5.39-12.151-12.03-12.151H40.942l62.558-63.46    c4.704-4.752,4.704-12.439,0-17.179c-4.704-4.752-12.319-4.752-17.011,0l-82.997,84.2c-4.632,4.68-4.68,12.512,0,17.191    l83.009,84.2c4.704,4.752,12.319,4.74,17.011,0c4.704-4.74,4.704-12.439,0-17.179L40.942,156.619z">
                                                        </path>
                                                        <path
                                                            d="M381.472,231.904l-83.009-84.2c-4.704-4.752-12.319-4.74-17.011,0c-4.704,4.74-4.704,12.439,0,17.179l62.558,63.46    H156.421c-6.641,0-12.03,5.438-12.03,12.151c0,6.713,5.39,12.151,12.03,12.151H344.01l-62.558,63.46    c-4.704,4.752-4.704,12.439,0,17.179c4.704,4.752,12.319,4.752,17.011,0l82.997-84.2    C386.104,244.416,386.152,236.584,381.472,231.904z">
                                                        </path>
                                                    </g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                </g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                            </svg>
                                            Compare
                                            <span class="count-header rounded-circle text-light count_compare"
                                                id="count_compare">{{ App::count_compare() }}</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="/logout">
                                            <i class="fas fa-sign-out-alt header-icon-right"></i>
                                            Log Out
                                        </a></li>
                                </ul>
                                @else
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a class="dropdown-item" href="/register">Register</a></li>
                                    <li><a class="dropdown-item" href="/login">Login</a></li>
                                </ul>
                                @endif
                            </div>
                            <!-- Header User End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec Header Button End -->
    <!-- Header responsive Bottom  Start -->
    <div class="ec-header-bottom d-lg-none">
        <div class="container position-relative">
            <div class="row ">

                <!-- Ec Header Logo Start -->
                <div class="col">
                    @if (auth()->check() && auth()->user()->tipe_customer_id == 3)
                    <div class="header-logo">
                        <a href="/"><img src="{{ asset('front/assets/images/custom-image/logo-business-new.png') }}"
                                alt="Site Logo" /><img class="dark-logo"
                                src="{{ asset('front/assets/images/custom-image/logo-business-new.png') }}"
                                alt="Site Logo" style="display: none;" /></a>
                    </div>
                    @else
                    <div class="header-logo">
                        <a href="/"><img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}"
                                alt="Site Logo" /><img class="dark-logo"
                                src="{{ asset('front/assets/images/custom-image/logo_new.png') }}" alt="Site Logo"
                                style="display: none;" /></a>
                    </div>
                    @endif
                </div>
                <!-- Ec Header Logo End -->
                <!-- Ec Header Search Start -->
                {{-- <div class="col">
                    <div class="header-search">
                        <form class="ec-btn-group-form" action="#" style="z-index: 5">
                            <input class="form-control search" placeholder="Enter Your Product Name..." type="text" onkeyup="keyup_search(this.value)">
                            <button class="submit" type="submit"><img src="{{ asset('front/assets/images/icons/search.svg') }}"
                class="svg_img header_svg" alt="icon" /></button>
                </form>
                <div class="content-container search-popover"
                    style="border-radius: 14px!important; padding: 0; z-index: 2; top: 43px;">
                    <ul class="suggestion" style="max-height: 150px" id="place_search">
                    </ul>

                </div>
            </div>
        </div> --}}

        <div class="col">
            <div class="header-search" id="search-md">
                <form class="ec-btn-group-form search-bar" action="#" style="z-index: 5">
                    <input class="form-control search" autocomplete="off" placeholder="Search Products..." type="text"
                        value="{{ app('request')->input('search') }}" id onkeyup="keyup_search(this.value)">
                    <button class="submit place_alert_search" type="button" disabled><img
                            src="{{ asset('front/assets/images/icons/loading.svg') }}" class="svg_img header_svg"
                            alt="" /></button>
                </form>
                <div class="content-container search-popover"
                    style="border-radius: 0 0 14px 14px!important; padding: 0; z-index: 2; top: 30px">
                    <ul class="suggestion place_search">
                    </ul>
                    {{-- <header class="trending">
                                <h5>Trending Search</h5>
                                <div class="trending-box">Perlengkapan Alat Tulis</div>
                                <div class="trending-box">PC</div>
                                <div class="trending-box">Peralatan Kantor</div>
                                <div class="trending-box">PC</div>
                                <div class="trending-box">Peralatan Kantor</div>
                            </header> --}}
                </div>
            </div>
        </div>
        <!-- Ec Header Search End -->
    </div>
    </div>
    </div>
    <!-- Header responsive Bottom  End -->
</header>

<script>
    function keyup_search(value) {
        if (event.which == 13 || event.keyCode == 13) {
            $.ajax({
                url: '/search/' + value,
                type: "GET",
                dataType: 'JSON',
                success: function (response, textStatus, jQxhr) {
                    console.log('enter' + JSON.stringify(response));
                    $('.place_search').empty();
                    $('.place_alert_search').attr('hidden', true);
                    $('#hapus-search').attr('hidden', false);
                    if (typeof (Object.keys(response)[0]) != "undefined" && Object.keys(response)[0] !==
                        null) {
                        window.location.href =
                            `/produk?package=${Object.values(response)[0]}&search=${value.replace(/ /g, "+")}`;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.warn(jqXhr.responseText);
                },
            });
        }

        $('.search').keydown(function (event) {
            if (event.keyCode == 13) { //JIKA PENCET ENTER
                console.log('bbb');
                event.preventDefault();
                return false;
            }
        });


        let searchParams = new URLSearchParams(window.location.search);
        // let package = searchParams.get('package');

        $('.place_alert_search').attr('hidden', false);
        $('#hapus-search').attr('hidden', true);


        if (value.length > 2) {
            // if(searchParams.has('package')){
            //     $.ajax({
            //         url: '/search/' + value + '/' + package ,
            //         type: "GET",
            //         dataType: 'JSON',
            //         success: function( response, textStatus, jQxhr ){
            //              $('.place_alert_search').attr('hidden', true);
            //             $('#place_search').empty();
            //             $.each(response, function( index, value ) {
            //                 console.log(value);
            //                 $('#place_search').append(`
            //                     <li onclick="url_append('search','${index}')">${index}</li>
            //                 `);
            //             });
            //         },
            //         error: function( jqXhr, textStatus, errorThrown ){
            //             console.log( errorThrown );
            //             console.warn(jqXhr.responseText);
            //         },
            //     });
            // }else{
            $.ajax({
                url: '/search/' + value,
                type: "GET",
                dataType: 'JSON',
                success: function (response, textStatus, jQxhr) {
                    $('.place_search').empty();
                    $('.place_alert_search').attr('hidden', true);
                    $('#hapus-search').attr('hidden', false);
                    $.each(response, function (index, value) {
                        $('.place_search').append(`
                                                    <a href="/produk?package=${value}&search=${index.replace(/ /g, "+")}"><li>${index}</li></a>
                                                `);
                    });
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.warn(jqXhr.responseText);
                },
            });
            // }
        } else {
            $('.place_search').empty();
            $('.place_alert_search').attr('hidden', true);
            $('#hapus-search').attr('hidden', false);

        }

        if ($(".search").val() === "") {
            $('#hapus-search').attr('hidden', true);
        }
    }

    function url_append(tipe, value) {
        const queryString = window.location.search;

        if (tipe == 'filter') {
            $('.nav-link-filter').removeClass('active');
            $('#' + value).addClass('active');
        }

        let string_parameter = '';
        parameter[tipe] = value;

        $.each(parameter, function (key, value) {
            string_parameter = string_parameter.concat('&' + key + "=" + value);
        });

        $.ajax({
            url: '/produk-filter' + queryString + string_parameter,
            type: "GET",
            dataType: 'JSON',
            success: function (response, textStatus, jQxhr) {
                $('#place-produk').empty();
                $.each(response, function (index, item) {

                    let diskon = '';
                    let harga_diskon = '';
                    if (item.diskon !== null) {
                        diskon = `<span class="percentage">${item.diskon}%</span>`;
                        harga_diskon =
                            `<span class="old-price" style="margin-right: 7px">${fungsiRupiah(item.harga_jual + (item.harga_jual / 100 * item.diskon))}</span>`;
                    }

                    let bintang = '';
                    for (let i = 1; i <= 5; i++) {
                        if (i <= item.bintang) {
                            bintang += '<i class="ecicon eci-star fill"></i>';
                        } else {
                            bintang += '<i class="ecicon eci-star-o"></i>';
                        }
                    }

                    var str1 = item.url_image[0];
                    var img_url = '/commerce/ecom_seller_final/public/' + item.url_image[0];

                    $('#place-produk').append(`
                        <div class="col-lg-3 col-6 ec-product-content">
                            <div class="ec-product-inner">
                                <div class="ec-pro-image-outer">
                                    <div class="ec-pro-image">
                                        <a href="/produk/${item.nama_produk_slug}" class="image" style="background-color: #fff; display: flex; justify-content:center; overflow: hidden; height: 250px;">
                                            <img class="main-image" style="object-fit: cover; display: block;"
                                                src="${img_url}" alt="Product" />
                                            <img class="hover-image" style="margin:0; top: 50%; left: 50%;-ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);"
                                                src="${img_url}" alt="Product" />
                                        </a>
                                        ${diskon}
                                        <div class="ec-pro-actions">
                                            <a class="ec-btn-group wishlist" title="Wishlist" onclick='add_to_wishlist(${item.id})'><img
                                                src="{{ asset('front/assets/images/icons/pro_wishlist.svg') }}"
                                                class="svg_img pro_svg" alt="" />
                                            </a>
                                            <a href="/produk/${item.nama_produk_slug}" class="ec-btn-group quickview" title="Quick view"><img
                                                    src="{{ asset('front/assets/images/icons/quickview.svg') }}"
                                                    class="svg_img pro_svg" alt="" />
                                            </a>
                                            <a class="ec-btn-group compare" onclick='add_to_compare(${item.id})'
                                                title="Compare"><img src="{{ asset('front/assets/images/icons/compare.svg') }}"
                                                    class="svg_img pro_svg" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-pro-content">
                                    <a href="/produk/${item.nama_produk_slug}"><h6 class="ec-pro-stitle text-ellipsis">${item.master_subkategori.subkategori}</h6></a>
                                    <h5 class="ec-pro-title"><a href="product-left-sidebar.html" class="text-ellipsis">${item.nama_produk_desc}</a></h5>
                                    <div class="ec-pro-rat-price d-flex ml-5" style="padding: 0!important">
                                        <span class="ec-pro-rating">
                                            ${bintang}
                                        </span>
                                        <span class="ec-id" hidden>${item.id}</span>
                                        <span class="ec-price" style="white-space: nowrap; flex-wrap: wrap">
                                            ${harga_diskon}
                                            <span class="new-price">${fungsiRupiah(item.harga_jual)}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                console.warn(jqXhr.responseText);
            },
        });
    }

    function removeURLParameter(url, parameter) {
        //prefer to use l.search if you have a location/link object
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);

            //reverse iteration as may be destructive
            for (var i = pars.length; i-- > 0;) {
                //idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
        }
        return url;
    }

    function click_hapus_search() {
        $('.search').val('');
        $('#hapus-search').attr('hidden', true);

        // window.history.replaceState(null, null, removeURLParameter(window.location.href, 'search'));
        window.location.href = removeURLParameter(window.location.href, 'search');
    }

</script>
