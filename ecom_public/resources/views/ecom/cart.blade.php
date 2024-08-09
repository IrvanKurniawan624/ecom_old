@extends('partial.app')

@section("css")
    <style>
        .seller-container{
            background: url('{{ asset("front/assets/images/bg/background-1.png") }}'), #F7DDB2
        }

        @media (max-width: 767px) {
            table, tr{
                border: none!important;
            }

            table tr {
                margin-bottom: 50px;
                position: relative;
            }

            .check-box-container{
                border: none!important;
                padding: 0!important;
                margin: 0!important;
            }

            .check-box-container div {
                width: 25px;
                height: 25px;
                position: absolute;
                top: 50%;
                left: 48%;
            }

            .check-box-container div input{
                width: 100%;
                height:100%;
                padding: 0!important;
            }

            .ec-cart-pro-name{
                margin-bottom: 50px;
                border: none!important;
            }

            .ec-cart-pro-name, .ec-cart-pro-name a{
                display: flex!important;
                flex-direction: column;
                text-align: center;
            }

            .ec-cart-pro-name a img{
                width: 150px!important;
                margin: 20px 0!important;
            }

            .ec-cart-pro-price{
                border-top: 1px solid #ebebeb
            }
        }
    </style>
@endsection

@section('content')
        <!-- Ec breadcrumb start -->
        <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row ec_breadcrumb_inner">
                            <div class="col-md-6 col-sm-12">
                                <h2 class="ec-breadcrumb-title">Cart</h2>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <!-- ec-breadcrumb-list start -->
                                <ul class="ec-breadcrumb-list">
                                    <li class="ec-breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="ec-breadcrumb-item active">Cart</li>
                                </ul>
                                <!-- ec-breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ec breadcrumb end -->

        <!-- Ec cart page -->
        <section class="ec-page-content section-space-p">
            <div class="container">
                <div class="row">
                    <div class="ec-cart-leftside col-lg-8 col-md-12 ">
                        <!-- cart content Start -->
                        <div class="ec-cart-content">
                            <div class="ec-cart-inner">
                                <div class="row">
                                    @if (count($cart) > 0)
                                    @php
                                        $sub_total = 0;
                                        $total_berat = 0;
                                        $key_temporary = 0;
                                    @endphp
                                    @foreach ($cart as $seller)
                                    <div class="content-container-2 mb-5">
                                        <div class="content-container mb-5 d-flex align-items-center seller-container" style="gap: 15px; box-shadow: none!important; margin-bottom: 20px!important">
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <input class="form-check-input" checkbox-seller="{{ $seller[0]->seller_id }}" onclick="checkbox_seller({{ $seller[0]->seller_id }}, $(this))" type="checkbox" style="padding: 0!important" value="">
                                            </div>
                                            <div class="img-container">
                                                <img src="{{ asset('front\assets\images\shop-svgrepo-com.svg') }}" width="50px" alt="">
                                            </div>
                                            <div class="text">
                                                <h5>{{ $seller[0]->master_seller->nama_toko }}</h5>
                                            </div>
                                        </div>
                                        <form action="#">
                                            <div class="table-content cart-table-content">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th width="10%">Product</th>
                                                            <th>Price</th>
                                                            <th style="text-align: center;">Quantity</th>
                                                            <th>Sisa Produk</th>
                                                            <th class="text-center">Total</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="place_alert">
                                                        @foreach ($seller as $key => $item)
                                                            @php
                                                                $key += $key_temporary;
                                                                $key_temporary += $key;
                                                            @endphp
                                                            <tr>
                                                                <td class="check-box-container">
                                                                    <div class="d-flex justify-content-center align-items-center">
                                                                        <input class="form-check-input check-box-cart" seller-id="{{ $item->seller_id }}" type="checkbox" style="padding: 0!important" value="" data-id="{{ $key_temporary }}" id="check-box-cart-{{ $key_temporary }}">
                                                                    </div>
                                                                </td>
                                                                <input type="text" hidden name="master_produk_id[]" id="master_produk_id_{{ $key_temporary }}" class="master_produk_id" data-id="{{ $key_temporary }}" value="{{ $item->master_produk->id }}" >
                                                                <td data-label="Product" class="ec-cart-pro-name">
                                                                    <a  href="/produk/{{ $item->master_produk->nama_produk_slug }}"><img class="ec-cart-pro-img mr-4" src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->master_produk->url_image[0] }}" alt="" />{{ $item->master_produk->nama_produk_desc }}</a>
                                                                </td>
                                                                <td data-label="Price" class="ec-cart-pro-price">
                                                                    <span class="amount" id="price_{{ $key_temporary }}" value="{{ $item->master_produk->harga_jual }}" style="white-space: nowrap">{{ number_format($item->master_produk->harga_jual,0,',','.') }}</span>
                                                                    <input type="text" hidden name="cart_harga_jual[]" value="{{ $item->master_produk->harga_jual }}">
                                                                </td>
                                                                <td data-label="Quantity" class="ec-cart-pro-qty" style="text-align: center;">
                                                                    <div class="cart-qty-plus-minus">
                                                                        <input class="cart-plus-minus quantity" type="text" id="input_{{ $key_temporary }}" data-id="{{ $key_temporary }}" style="border: none!important" name="cartqtybutton[]" disabled value="{{ $item->quantity }}" />
                                                                        <div class="ec_cart_qtybtn"><div class="inc ec_qtybtn" data-id="{{ $key_temporary }}">+</div><div class="dec ec_qtybtn" data-id="{{ $key_temporary }}">-</div></div>
                                                                    </div>
                                                                </td>
                                                                <td data-label="Sisa Produk" id="sisa-item_{{ $key_temporary }}" style="text-align: center" class="sisa-item">{{ $item->master_produk->stock }}</td>
                                                                <td data-label="Total" id ="total_product_{{ $key_temporary }}" class="ec-cart-pro-subtotal text-center total-produk-value" style="white-space: nowrap">{{ number_format($item->master_produk->harga_jual * $item->quantity,0,',','.') }}</td>
                                                                <input type="text" id="total_product_input_{{  $key_temporary }}" class="row-value" hidden value="{{ $item->master_produk->harga_jual * $item->quantity }}">
                                                                <input type="text" id="berat_produk_{{  $key_temporary }}" class="row-value" hidden value="{{ $item->master_produk->berat}}">
                                                                <input type="text" id="total_berat_input_{{  $key_temporary }}" class="row-value" hidden value="{{ $item->master_produk->berat * $item->quantity }}">
                                                                <td data-label="Remove" class="ec-cart-pro-remove">
                                                                    <a href="#" class="cart-remove" data-id="{{ $item->id }}"><i class="ecicon eci-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach                                                            
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <img src="{{ asset("front/assets/images/email-template/offer-email-14.png") }}" id="cart-not-found-image" class="mb-3" style="display: block; margin: auto" alt="" srcset="">
                                    <h5 class="d-block text-center fw-bold">Keranjang belanja anda kosong</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--cart content End -->
                    </div>
                    <!-- Sidebar Area Start -->
                    <div class="ec-cart-rightside col-lg-4 col-md-12">
                        <div class="ec-sidebar-wrap">
                            <!-- Sidebar Summary Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Summary</h3>
                                </div>

                                <div class="ec-sb-block-content">
                                    <div class="ec-cart-summary-bottom">
                                        <div class="ec-cart-summary">
                                            <div>
                                                <span class="text-left">Sub-Total</span>
                                                <span class="text-right" id="sub_total">{{ number_format($sub_total,0,',','.')  }}</span>
                                            </div>
                                            <div class="ec-cart-summary-total">
                                                <span class="text-left">Total Amount</span>
                                                <span class="text-right" id="total-harga">{{ number_format($sub_total,0,',','.')  }}</span>
                                            </div>
                                            <div class="row mt-5" id="bayar-button-desk">
                                                <div class="col-lg-12">
                                                    <div class="ec-cart-update-bottom float-right w-100">
                                                        <button class="btn btn-primary button_checkout w-100" @if (count($cart) == 0) disabled @endif>Checkout</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="bayar-button-mobile">
                                        <div class="col-lg-12">
                                            <div class="ec-cart-update-bottom float-right d-flex mb-4">
                                                <button class="btn btn-primary button_checkout" @if (count($cart) == 0) disabled @endif>Checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Summary Block -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- New Product Start -->
@endsection

@section('js')
    <script>
        $('.button_checkout').click(function(e){
            e.preventDefault();

            var master_produk_id = $('input[name="master_produk_id[]"]').map(function(){
                var id = $(this).attr('data-id');
                if($('#check-box-cart-' + id).is(":checked")){
                    return this.value;
                }
            }).get();

            var cart_qty = $('input[name="cartqtybutton[]"]').map(function(){
                var id = $(this).attr('data-id');
                if($('#check-box-cart-' + id).is(":checked")){
                    return this.value;
                }
            }).get();

            var seller_id = $('.check-box-cart:checked').attr('seller-id');

            $('.button_checkout').attr('disabled', true);
            $('.button_cek_potongan_harga_grosir').attr('disabled', true);
            $('.button_checkout').html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "/cart/checkout",
                type: "POST",
                data: {
                    'master_produk_id': master_produk_id,
                    'cart_quantity': cart_qty,
                    'seller_id' : seller_id,
                },
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('.button_checkout').html('CHECKOUT');
                    $('.button_checkout').attr('disabled', false);
                    $('.button_cek_potongan_harga_grosir').attr('disabled', false);
                    if(response.status == 201) {
                        window.location.href = response.link;
                    }else if(response.status == 301){
                        Swal.fire({
                            title: 'Oops!',
                            html: response.message,
                            showDenyButton: true,
                            confirmButtonText: 'Yuk lengkapi datamu',
                            denyButtonText: `Nanti aja`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.href = response.link;
                            }
                        })
                    }else{
                        iziToast.error({
                            title: 'Failed!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $('.button_checkout').html('CHECKOUT');
                    $('.button_checkout').attr('disabled', false);

                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');

                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        });

    /*----------------------------- Cart  remove -------------------------------- */

    $('.cart-remove').click(function(e){
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: '/cart/delete/' + $(this).attr('data-id'),
            type: "DELETE",
            dataType: 'JSON',
            success: function( response, textStatus, jQxhr ){
                if(response.status == 200){
                    $this.closest("tr").remove();
                    let rowTotal = parseInt(convertToAngka($this.parent().prev().text()));
                    let subTotal2 = parseInt(convertToAngka($('#sub_total').text()));
                    let totalHarga2 = parseInt(convertToAngka($('#total-harga').text()));
                    subTotal2 -= rowTotal;
                    totalHarga2 -= rowTotal;
                    $('#sub_total').text(fungsiRupiah(subTotal2));
                    $('#total-harga').text(fungsiRupiah(totalHarga2));

                    //CART GLOBAL
                    get_data_cart();
                    get_count_cart();

                    var numItems = $('.cart-remove').length;
                    if(numItems == 0){
                        $('#place_alert').append(`
                            <tr>
                                <td colspan="6" class="text-center" style="flex-direction: column">Keranjang belanja anda kosong</td>
                            </tr>
                        `);
                        $('#button_gunakan_poin').attr('disabled', true);
                        $('.button_cek_potongan_harga_grosir').attr('disabled', true);
                        $('.button_checkout').attr('disabled', true);
                    }
                }else{
                    iziToast.error({
                        title: 'Failed!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
            },
        });
    })

    /*----------------------------- Cart Page Qty Plus Minus Button  ------------------------------ */
    var CartQtyPlusMinus = $(".cart-qty-plus-minus");
    $(".cart-qty-plus-minus .ec_cart_qtybtn .ec_qtybtn").on("click", function() {
        var $cartqtybutton = $(this);
        var id = $(this).attr('data-id');
        var price = parseInt(convertToAngka($('#price_'+id).attr('value')));
        var subTotal = parseInt(convertToAngka($('#sub_total').text()));
        var productTotal = parseInt($("#total_product_input_"+id).val());
        var CartQtyoldValue = $('#input_'+id).val();
        var totalHargaQTC = parseInt(convertToAngka($('#total-harga').text()));
        if ($cartqtybutton.text() === "+") {
            if(parseInt($('#input_'+id).val()) >= parseInt($('#sisa-item_'+id).text())){
                var CartQtynewVal = parseFloat(CartQtyoldValue);
            } else {
                var CartQtynewVal = parseFloat(CartQtyoldValue) + 1;
                subTotal += price;
                productTotal += price;
                totalHargaQTC += price;
            }
        } else {
            if (parseInt(CartQtyoldValue) > 1) {
                var CartQtynewVal = parseFloat(CartQtyoldValue) - 1;
                subTotal -= price;
                productTotal -= price;
                totalHargaQTC -= price;
            } else {
                CartQtynewVal = 1;
            }
        }
        if($("#check-box-cart-"+id).prop('checked') == true){
            $('#sub_total').text(fungsiRupiah(subTotal));
            $('#total-harga').text(fungsiRupiah(totalHargaQTC));
        }
        $('#total_product_'+id).text(fungsiRupiah(productTotal));
        $('#total_product_input_'+id).val(productTotal);
        $('#input_'+id).val(CartQtynewVal);
    });

    $(document).ready(function(){
        $(".check-box-cart").on("click", function(){
            let subTotal = parseInt(convertToAngka($('#sub_total').text()));
            var id = $(this).attr('data-id');
            var quantity = $('#input_'+id).val();
            var master_produk = $('#master_produk_id_'+id).val();
            var productTotal = parseInt($("#total_product_input_"+id).val());

            if($(this).prop('checked')){
                subTotal += productTotal;
                if($('input[seller-id="' +  $(this).attr('seller-id') + '"]').not(':checked').length === 0){
                    $('input[checkbox-seller="' + $(this).attr('seller-id') + '"]').prop('checked', true)
                }
            } else{
                subTotal -= productTotal;
                $('input[checkbox-seller="' + $(this).attr('seller-id') + '"]').prop('checked', false)
            }

            $('#sub_total').text(fungsiRupiah(subTotal));
            $('#total-harga').text(fungsiRupiah(subTotal));

            $('.button_checkout').attr('disabled', false);
            if(subTotal == 0){
                $('.button_checkout').attr('disabled', true);
            }
        })
    })

    function checkbox_seller(seller_id, checkbox){
        let s_id = $('.check-box-cart[seller-id="' +  seller_id + '"]');
        // if(checkbox.is(':checked')){
        //     s_id.prop('checked', true);
        // } else {
        //     s_id.prop('checked', false);
        // }

        // let s_id = $('.check-box-cart[seller-id="' +  seller_id + '"]');

        s_id.each(function(key, value){
            let subTotal = parseInt(convertToAngka($('#sub_total').text()));
            var id = $(value).attr('data-id');
            var quantity = $('#input_'+id).val();
            var master_produk = $('#master_produk_id_'+id).val();
            var productTotal = parseInt($("#total_product_input_"+id).val());
                
            if($(checkbox).prop('checked')){
                if($(value).prop('checked') == false){
                    subTotal += productTotal;
                    $(value).prop('checked', true);
                    // console.log('penambahan' + productTotal);
                }    
            } else {
                if($(value).prop('checked') == true){
                    subTotal -= productTotal;
                    $(value).prop('checked', false);
                    // console.log('pengurangan' + productTotal);
                }
            }
            // if($(value).prop('checked')){
            //     subTotal += productTotal;
            //     console.log('penambahan' + productTotal);
            // } else{
            //     subTotal -= productTotal;
            //     console.log('pengurangan' + productTotal);
            // }
    
            $('#sub_total').text(fungsiRupiah(subTotal));
            $('#total-harga').text(fungsiRupiah(subTotal));
    
            $('.button_checkout').attr('disabled', false);
            if(subTotal == 0){
                $('.button_checkout').attr('disabled', true);
            }
        })
    }


    </script>
@endsection
