<!-- ekka Cart Start -->

<?php
use App\Helpers\App;
?>

<div class="ec-side-cart-overlay" style="z-index: 900!important"></div>
<div id="ec-side-cart" class="ec-side-cart">
    <div class="ec-cart-inner">
        <div class="ec-cart-top">
            <div class="ec-cart-title">
                <span class="cart_title">My Cart</span>
                <button class="ec-close">×</button>
            </div>
            <ul class="eccart-pro-items" id="place_cart_global">
                {{-- @php
                    $total_harga = 0;
                @endphp
                @if (App::get_data_cart() != 'null')

                    @foreach (App::get_data_cart() as $item)

                        @php
                            $total_harga += $item->master_produk->harga_jual * $item->quantity;
                        @endphp

                        <li id="li_{{ $item->id }}">
                            <a href="/produk/{{$item->master_produk->nama_produk_slug }}" class="sidekka_pro_img"><img
                                    src="https://seller.SIMANHURA.com/{{ $item->master_produk->url_image[0] }}" alt="product"></a>
                            <div class="ec-pro-content">
                                <a href="/produk/{{ $item->master_produk->nama_produk_slug }}" class="cart_pro_title">{{ $item->master_produk->nama_produk_desc }}</a>
                                <span class="cart-price"><span>{{ number_format($item->master_produk->harga_jual,0,',','.') }}</span> x {{ $item->quantity }}</span>
                                <a href="javascript:void(0)" class="remove" data-id="{{ $item->id }}">×</a>
                            </div>
                        </li>
                    @endforeach
                @endif --}}
            </ul>
        </div>
        <div class="ec-cart-bottom">
            <div class="cart-sub-total">
                <table class="table cart-table">
                    <tbody>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right primary-color" id="total_belanja"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart_btn">
                <a href="/cart" class="btn btn-secondary btn-block" style="width: 100% !important" id="button_checkout" disabled>Checkout</a>
            </div>
        </div>
    </div>
</div>
<!-- ekka Cart End -->
