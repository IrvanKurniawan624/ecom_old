<?php
use App\Helpers\App;
?>

    <!-- Footer navigation panel for responsive display -->
    <div class="ec-nav-toolbar">
        <div class="container">
            <div class="ec-nav-panel">
                <div class="ec-nav-panel-icons">
                    <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><img
                            src="{{ asset('front/assets/images/icons/menu.svg') }}" class="svg_img header_svg" alt="" /></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle"><img
                            src="{{ asset('front/assets/images/icons/cart.svg') }}" class="svg_img header_svg" alt="" /><span
                            class="ec-cart-noti ec-header-count cart-count-lable count_cart">{{ App::count_cart() }}</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="/" class="ec-header-btn"><img src="{{ asset('front/assets/images/icons/home.svg') }}"
                            class="svg_img header_svg" alt="icon" /></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="/wishlist" class="ec-header-btn"><img src="{{ asset('front/assets/images/icons/wishlist.svg') }}"
                            class="svg_img header_svg" alt="icon" /><span class="ec-cart-noti count_wishlist">{{ App::count_wishlist() }}</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    @if (Auth::check())
                        <div class="row">
                            <div class="col-11 d-flex justify-content-center align-items-center padding-r-low">
                                <a href="/profile" class="ec-header-btn"><img src="{{ '/' . auth()->user()->url_image }}" style="width: 42px; height: 39px;" class="rounded" alt="" srcset=""></a>
                            </div>
                        </div>
                    @else
                    <a href="/login" class="ec-header-btn"><img src="/front/assets/images/icons/user.svg" class="svg_img header_svg" alt="" /></a>
                    @endif

                    {{-- <a href="login.html" class="ec-header-btn"><img src="{{ asset('front/assets/images/icons/user.svg') }}"
                            class="svg_img header_svg" alt="icon" /></a> --}}
                    {{-- <a href="login.html" class="ec-header-btn"><img src="https://i.pinimg.com/236x/5d/22/77/5d22778dab87dd4c25798a531a7e170c.jpg" style="width: 42px" class="rounded" alt="" srcset=""></a> --}}
                </div>

            </div>
        </div>
    </div>
    <!-- Footer navigation panel for responsive display end -->
