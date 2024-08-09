@extends('partial.app');

@section('css')
<style>
    .ec-page-content{
        margin-top: 0!important;
    }
    .button_gunakan_poin:hover{
        background: #83898e;
    }
    .alamat-action a:hover{
        color: var(--base-color)!important;
    }
    .ec-cart-coupan:hover{
        color: #e88c8d!important;
    }
    #btn-ambil-ditoko.active{
        background: #0DCAF0;
    }
    #btn-ambil-ditoko.active:hover{
        background: #14a1bd;
    }
    #btn-ambil-ditoko:hover{
        background: #83898e;
    }
    .hide-pengiriman{
        display: none;
    }
    @media (max-width: 767px) {
        table, tr{
            border: none!important;
        }

        table tr {
            margin-bottom: 50px;
            position: relative;
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
                                <h2 class="ec-breadcrumb-title">Checkout</h2>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <!-- ec-breadcrumb-list start -->
                                <ul class="ec-breadcrumb-list">
                                    <li class="ec-breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="ec-breadcrumb-item active">Checkout</li>
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
                                    <form action="#">
                                        <div class="table-content cart-table-content">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Product</th>
                                                        <th>Price</th>
                                                        <th style="text-align: center;">Quantity</th>
                                                        <th class="text-center">Sisa Produk</th>
                                                        <th class="text-center">Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="place_alert">
                                                    @php
                                                        $sub_total = 0;
                                                        $total_berat = 0;
                                                    @endphp
                                                    @if (count($cart) > 0)
                                                    <input type="hidden" name="seller_id" id="seller_id" value="{{ $cart[0]->seller_id }}">
                                                        @foreach ($cart as $key => $item)
                                                            <tr>
                                                                <input type="text" hidden name="master_produk_id[]" id="master_produk_id" class="master_produk_id" value="{{ $item->master_produk->id }}" >
                                                                <td data-label="Product" class="ec-cart-pro-name">
                                                                    <a  href="/produk/{{ $item->master_produk->nama_produk_slug }}"><img class="ec-cart-pro-img mr-4" src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->master_produk->url_image[0] }}" alt="" />{{ $item->master_produk->nama_produk_desc }}</a>
                                                                </td>
                                                                <td data-label="Price" class="ec-cart-pro-price">
                                                                    <span class="amount" id="price_{{ $key }}" value="{{ $item->master_produk->harga_jual }}" style="white-space: nowrap">{{ number_format($item->master_produk->harga_jual,0,',','.') }}</span>
                                                                    <input type="text" hidden name="cart_harga_jual[]" value="{{ $item->master_produk->harga_jual }}">
                                                                </td>
                                                                <td data-label="Quantity" class="ec-cart-pro-qty" style="text-align: center;">{{ $item->quantity }}</td>
                                                                <input type="text" name="cartqtybutton[]" value="{{ $item->quantity }}" hidden>
                                                                <td data-label="Sisa Item" id="sisa-item_{{ $key }}" style="text-align: center">{{ $item->master_produk->stock }}</td>
                                                                <td data-label="Total" id ="total_product_{{ $key }}" class="ec-cart-pro-subtotal text-center" style="white-space: nowrap">{{ number_format($item->master_produk->harga_jual * $item->quantity,0,',','.') }}</td>
                                                                <input type="text" id="total_product_input_{{  $key }}" class="row-value" hidden value="{{ $item->master_produk->harga_jual * $item->quantity }}">
                                                                <input type="text" id="total_berat_input_{{  $key }}" class="berat-produk" hidden value="{{ $item->master_produk->berat * $item->quantity }}">
                                                            </tr>

                                                            @php
                                                                $total_berat += $item->master_produk->berat * $item->quantity;
                                                                $sub_total += $item->master_produk->harga_jual * $item->quantity;
                                                            @endphp
                                                        @endforeach

                                                    @else
                                                        <tr>
                                                            <td colspan="6" class="text-center">
                                                                <img src="{{ asset("front/assets/images/email-template/offer-email-14.png") }}" id="cart-not-found-image" class="mb-3" style="display: block; margin: auto" alt="" srcset="">
                                                                <h5 class="d-block text-center fw-bold">Keranjang belanja anda kosong</h5>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" id="bayar-button-desk">
                                            <div class="col-lg-12">
                                                <div class="ec-cart-update-bottom float-right">
                                                    <button class="btn btn-info mr-2 button_gunakan_poin"  @if (count($cart) == 0) disabled @endif onclick="click_gunakan_poin()" style="color: white">Gunakan Poin</button>
                                                    <button class="btn btn-primary button_bayar" @if (count($cart) == 0) disabled @endif>Bayar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                                    <h4 class="ec-ship-title">Estimate Shipping</h4>
                                    <div class="ec-cart-form">
                                        <p>Enter your destination to get a shipping estimate</p>
                                        <form action="#" method="post">
                                            <span class="ec-cart-wrap">
                                                <label>Pilih Alamat Pengiriman</label>
                                                <div class="content-container-2 alamat-container-card" style="padding: 10px 0 0 10px;border: 2px solid var(--base-color)!important;">
                                                    <div class="row alamat-card p-1" style="align-items: center; margin-right: 0!important;margin-left: 0!important;">
                                                        <div class="col-md-8 col-12" id="place_alamat" style="margin-bottom:2%">
                                                            <input type="text" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="{{ $alamat_pengiriman_utama->id }}" hidden>
                                                            <input type="text" name="kota_id" id="kota_id" value="{{ $alamat_pengiriman_utama->kota_id }}" hidden>
                                                            <input type="text" name="kecamatan_id" id="kecamatan_id" value="{{ $alamat_pengiriman_utama->kecamatan_id }}" hidden>
                                                            <p style="margin-bottom: 0!important"><strong>{{ $alamat_pengiriman_utama->penerima }} | {{ $alamat_pengiriman_utama->no_telepon }}</strong></p>
                                                            @if ($alamat_pengiriman_utama->alamat_utama == '1')
                                                                <span class="badge badge-pill my-1 badge-primary bg-primary">Alamat Utama</span>
                                                            @endif
                                                            <p class="two-line-only" style="margin-bottom: 0!important">{{ $alamat_pengiriman_utama->alamat_lengkap }}</p>
                                                        </div>
                                                        <div class="col-md-4 py-1 text-center alamat-action">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#alamat-modal"><a href="#" >Ubah Alamat</a></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="ec-cart-wrap mt-2 place_pilih_pengiriman">
                                                <label style="margin-top:25px">Pilih Pengiriman</label>
                                                <span class="ec-cart-select-inner" style="transition: .5s;">
                                                    <select name="ec_cart_country" id="jasa_pengiriman" name="jasa_pengiriman" class="ec-cart-select" onchange="change_jasa_pengiriman()" style="border: 2px solid var(--base-color)!important">
                                                    </select>
                                                </span>
                                            </span>
                                            {{-- <button class="btn btn-primary btn-block" type="button" id="btn-ambil-ditoko" onclick="click_ambil_ditoko()">Ambil Di Toko</button> --}}
                                        </form>
                                    </div>
                                </div>

                                <div class="ec-sb-block-content">
                                    <div class="ec-cart-summary-bottom">
                                        <div class="ec-cart-summary">
                                            <div>
                                                <span class="text-left">Sub-Total</span>
                                                <span class="text-right" id="sub_total">{{ number_format($sub_total,0,',','.')  }}</span>
                                            </div>
                                            <div>
                                                <span class="text-left">Delivery Charges</span>
                                                <span class="text-right" id="delivery-charge">Pilih Metode Pengiriman</span>
                                            </div>
                                            <div>
                                                <span class="text-left">Potongan Poin (Poin Anda {{ number_format(auth()->user()->poin,0,',','.') }} )</span>
                                                <span class="text-right" id="poin">0</span>
                                            </div>
                                            <div>
                                                <span class="text-left">Voucher</span>
                                                <span class="text-right"><a class="ec-cart-coupan">Apply Voucher</a></span>
                                            </div>
                                            <div class="ec-cart-coupan-content">
                                                <form id="form_voucher" class="ec-cart-coupan-form" name="ec-cart-coupan-form" method="post" action="#">
                                                    <input class="ec-coupan required-field-voucher" disabled data-bs-toggle="modal" data-bs-target="#voucher-modal" type="text" placeholder="Enter Your Coupan Code" name="voucher" id="voucher">
                                                    <button class="ec-coupan-btn button btn-primary" type="submit" name="subscribe" value="">Pakai</button>
                                                </form>
                                                <small style="color: red" id="alert_voucher"></small>
                                            </div>
                                            <div class="ec-cart-summary-total">
                                                <span class="text-left">Total Amount</span>
                                                <span class="text-right" id="total-harga">{{ number_format($sub_total,0,',','.')  }}</span>
                                            </div>
                                            <input type="text" id="total_berat" class="row-value" hidden>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="bayar-button-mobile">
                                    <div class="col-lg-12">
                                        <div class="ec-cart-update-bottom float-right d-flex mt-3">
                                            <button class="btn btn-info mr-2 button_gunakan_poin"  @if (count($cart) == 0) disabled @endif onclick="click_gunakan_poin()" style="color: white">Gunakan Poin</button>
                                            <button class="btn btn-primary button_bayar" @if (count($cart) == 0) disabled @endif>Bayar</button>
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

    {{-- MODAL VOUCHER --}}
    <div class="modal fade" id="voucher-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ml-2" id="exampleModalLabel"><strong>Voucher Saya</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-4 offset-md-1 col-sm-12 col-12 d-flex" style="align-items: center;">
                            <h5>Tambah Voucher</h5>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 d-flex align-items-center">
                            <div class="col-8">
                                <input class="voucher-style required-field-add-voucher" type="text" placeholder="Enter Your Coupan Code" name="add_voucher" id="add_voucher" onkeyup="return onkeyupUppercase(this.id);">
                            </div>
                            <div class="col-2 offset-1">
                                <button type="button" class="btn btn-primary rounded" id="button_add_voucher">Apply</button>
                            </div>
                        </div>
                        <hr style="background-color: black; width: 90%; margin: auto; margin-top: 18px; height: 3px">
                    </div>
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center" id="place_voucher">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ALAMAT --}}
    <div class="modal fade" id="alamat-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ml-2" id="exampleModalLabel"><strong>Pilih Alamat Pengiriman</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Jika Alamat Tidak Ada --}}
                    {{-- <div id="alert_alamat_not_found">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" draggable="false" alt="">
                    </div>
                    <br><br>
                    <button class="btn btn-primary rounded-pill btn-xs btn-add-alamat-pengiriman" onclick="add()" disabled>Tambah Alamat Pengiriman</button> --}}

                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($alamat_pengiriman as $key => $item)
                                <div class="col-md-12 mb-3">
                                    <div class="content-container-2">
                                        <div class="row">
                                            <div class="col-md-8 text-start">
                                                <p style="margin-bottom: 0!important; display:block"><strong>{{ $item->penerima }} | {{ $item->no_telepon }}</strong></p>
                                                @if ($item->alamat_utama == 1)
                                                    <span class="badge badge-pill my-1 badge-primary bg-primary">Alamat Utama</span>
                                                @endif
                                                <p class="two-line-only d-block" style="margin-bottom: 0!important">{{ $item->alamat_lengkap }}</p>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-center" style="align-self: center">
                                                <div class="custom-control custom-radio active custom-control-inline">
                                                    <input type="radio" @if ($loop->first) checked @endif style="width: 30px" id="pilih_alamat_pengiriman" name="pilih_alamat_pengiriman" class="custom-control-input" value="{{ $item->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="button_pilih_alamat">Pilih Alamat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>


        $(document).ready(function(){
            get_data_kode_voucher();
            get_data_jasa_pengiriman();

        });

        // function click_ambil_ditoko(){
        //     $('.ec-cart-wrap').toggleClass("hide-pengiriman");
        //     if( $('#btn-ambil-ditoko').hasClass('active')){
        //         $('#btn-ambil-ditoko').text("Ambil Di Toko");
        //         $('#btn-ambil-ditoko').removeClass('active');
        //         var hargaPengiriman = parseInt($('#jasa_pengiriman').find('option:selected').attr('harga-pengiriman'));
        //         $('#delivery-charge').text(fungsiRupiah(hargaPengiriman));
        //         $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text())) + parseInt(hargaPengiriman))-parseInt(convertToAngka($('#potongan-harga-grosir').text()))));
        //     } else {
        //         $('#btn-ambil-ditoko').text("Customer Ambil Ditoko");
        //         $('#btn-ambil-ditoko').addClass('active');
        //         $('#delivery-charge').text(fungsiRupiah(0));
        //         $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text()))) - parseInt(convertToAngka($('#potongan-harga-grosir').text()))));
        //     }
        // }

        var poin_active = false;

        function click_gunakan_poin(){
            poin_active = true;
            $('.button_gunakan_poin').attr('disabled', true);
            $('.button_gunakan_poin').html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                url: "/checkout/check-poin",
                type: "POST",
                data: {
                    'poin_active': poin_active,
                    'total_harga': parseInt(convertToAngka($('#sub_total').text())),
                },
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('.button_gunakan_poin').html('GUNAKAN POIN');
                    $('.button_gunakan_poin').attr('disabled', false);
                    if(response.status == 200){
                        Swal.fire('Good job!',response.message,'success');
                        $('#poin').html(fungsiRupiah(response.data));
                        $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text())) + parseInt(convertToAngka($('#delivery-charge').text()))) - parseInt(convertToAngka($('#potongan-harga-grosir').text())) - parseInt(response.data)));
                    }else{
                        Swal.fire('Oops!',response.message,'warning');
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $('.button_gunakan_poin').html('GUNAKAN POIN');
                    $('.button_gunakan_poin').attr('disabled', false);

                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');
                },
            });
        }

        // function click_cek_potongan_harga_grosir(){
        //     $('#button_cek_potongan_harga_grosir').attr('disabled', true);
        //     $('#button_cek_potongan_harga_grosir').html('<i class="fas fa-spinner fa-spin"></i>');

        //     var master_produk_id = $('input[name="master_produk_id[]"]').map(function(){
        //         return this.value;
        //     }).get();

        //     var cart_qty = $('input[name="cartqtybutton[]"]').map(function(){
        //         return this.value;
        //     }).get();

        //     $.ajax({
        //         url: '/checkout/check-potongan-harga-grosir',
        //         type: "POST",
        //         data: {
        //             'master_produk_id': master_produk_id,
        //             'cart_quantity': cart_qty,
        //         },
        //         dataType: 'JSON',
        //         success: function( response, textStatus, jQxhr ){
        //             $('#button_cek_potongan_harga_grosir').html('CEK POTONGAN HARGA GROSIR');
        //             $('#button_cek_potongan_harga_grosir').attr('disabled', false);
        //             console.log(response);
        //             if(response.status == 200){
        //                 $('#potongan-harga-grosir').html(fungsiRupiah(response.data));
        //                 $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text())) + parseInt(convertToAngka($('#delivery-charge').text()))) - parseInt(convertToAngka($('#poin').text())) - parseInt(response.data)));
        //             }
        //         },
        //         error: function( jqXhr, textStatus, errorThrown ){
        //             $('#button_cek_potongan_harga_grosir').html('CEK POTONGAN HARGA GROSIR');
        //             $('#button_cek_potongan_harga_grosir').attr('disabled', false);

        //             Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');

        //             console.log( errorThrown );
        //             console.warn(jqXhr.responseText);
        //         },
        //     });
        // }

        $('#button_pilih_alamat').click(function(){
            $alamat_pengiriman_id = $('input[name="pilih_alamat_pengiriman"]:checked').val();
            $.ajax({
                url: '/master/get-data-by-id/AlamatPengiriman/' + $alamat_pengiriman_id,
                type: "GET",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('#alamat-modal').modal('hide');
                    if(response.status == 200){

                        let string_alamat_utama = '';
                        if(response.data.alamat_utama == 1){
                            string_alamat_utama = '<span class="badge badge-pill my-1 badge-primary bg-primary">Alamat Utama</span>';
                        }
                        $('#place_alamat').html(``);

                        $('#place_alamat').html(`
                            <input type="text" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="${response.data.id}" hidden>
                            <input type="text" name="kota_id" id="kota_id" value="${response.data.kota_id}" hidden>
                            <input type="text" name="kecamatan_id" id="kecamatan_id" value="${response.data.kecamatan_id}" hidden>
                            <p style="margin-bottom: 0!important"><strong>${response.data.penerima} | ${response.data.no_telepon}</strong></p>
                            ${string_alamat_utama}
                            <p class="two-line-only" style="margin-bottom: 0!important">${response.data.alamat_lengkap}</p>
                        `);

                        get_data_jasa_pengiriman();
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $('#alamat-modal').modal('hide');
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');

                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        });

        function get_data_kode_voucher(){
            $("#modal_loading").modal('show');
            $.ajax({
                url : "/master/data-kode-voucher-claim-active-by-user-id",
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    if(response.status === 200){
                        $('#place_voucher').empty();
                        $.each(response.data, function( index, value ) {
                            $('#place_voucher').append(`
                                <div class="col-md-5 col-sm-5 col-12 content-container-2 m-2" onclick="apply_voucher('${value.kode_voucher}')" style="cursor: pointer;">
                                    <div class="row">
                                        <div class="col-4 image-container">
                                            <img src="{{ asset('front/assets/images/project/voucher.jpg') }}" alt="">
                                        </div>
                                        <div class="desc-voucher col-8">
                                            <h6 class="one-line-only">${value.title}</h6>
                                            <p style="font-size: 9px" class="two-line-only">${value.keterangan}</p>
                                            <a href="/profile/voucher/detail/${value.kode_voucher}" target="_blank"><button type="button" class="btn-primary btn-sm rounded" style="float: right;">Show</button></a>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }else{
                        $('#place_voucher').html(`
                            <img src="{{ asset('front/assets/images/project/not-found.png') }}" draggable="false" alt="" style="width:60%;">
                        `);
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        }

        function get_data_jasa_pengiriman(){
            $('.button_bayar').prop('disabled', true);
            $("#modal_loading").modal('show');
            $.ajax({
                url : "/master/api-ongkos-kirim/" + $('#kecamatan_id').val() + '/' + $('#total_berat').val() + '/' + $('#seller_id').val(),
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    console.log(response);
                    if(response.status === 200){
                        $('#jasa_pengiriman').empty();
                        $.each(response.data, function( index, value ) {
                            $('#jasa_pengiriman').append(`
                               <option harga-pengiriman="${value.harga}" jasa-pengiriman="${value.nama}">${value.nama} (${value.estimasi} Hari) [<span id="ongkir_${index}">${fungsiRupiah(value.harga)}</span>]</option>
                            `);
                        });
                        change_jasa_pengiriman();
                        $('.button_bayar').prop('disabled', false);
                    }else{
                        iziToast.error({
                            title: 'Error!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text())) - parseInt(convertToAngka($('#potongan-harga-grosir').text())))));
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Jasa Pengiriman sedang mengalami gangguan, harap coba lagi nanti','error');
                }
            });
        }

         function change_jasa_pengiriman(){
             var hargaPengiriman = parseInt($('#jasa_pengiriman').find('option:selected').attr('harga-pengiriman'));
             $('#delivery-charge').text(fungsiRupiah(hargaPengiriman));
             $('#total-harga').text(fungsiRupiah((parseInt(convertToAngka($('#sub_total').text())) + parseInt(hargaPengiriman))));
         }

        function apply_voucher(kode_voucher){
            $('#voucher-modal').modal('hide');
            $('#voucher').val(kode_voucher);
        }

        var voucher_active = false;

        $('#form_voucher').submit(function(e){

            voucher_active = false;

            e.preventDefault();

            $("#modal_loading").modal('show');

            if($('.required-field-voucher').val().length === 0){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Swal.fire('Oops!','Voucher tidak boleh kosong','warning');
                return;
            }
            $.ajax({
                url: "/checkout/check-voucher",
                type: "POST",
                data: {
                    'voucher': $('#voucher').val(),
                    'total_harga': parseInt(convertToAngka($('#sub_total').text())),
                },
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status == 200){
                        Swal.fire('Good job!','voucher berhasil digunakan','success');
                        voucher_active = true;
                    }
                    $('#alert_voucher').html(response.message);
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $("#modal_loading").modal('show');
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');

                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        });

        $('#button_add_voucher').click(function(e){
            e.preventDefault();

            $('#button_add_voucher').attr('disabled', true);
            $('#button_add_voucher').html('<i class="fas fa-spinner fa-spin"></i>');

            if($('.required-field-add-voucher').val().length === 0){
                $('#button_add_voucher').html('APPLY');
                $('#button_add_voucher').attr('disabled', false);

                Swal.fire('Oops!','Voucher tidak boleh kosong','warning');
                return;
            }
            $.ajax({
                url: "/profile/voucher/action-kode-voucher/" + $('#add_voucher').val(),
                type: "GET",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('#button_add_voucher').html('APPLY');
                    $('#button_add_voucher').attr('disabled', false);

                    if(response.status == 200) {
                        Swal.fire('Good job!','voucher berhasil digunakan','success');
                    }else{
                        Swal.fire('Oops!',response.message,'warning');
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $('#button_add_voucher').html('APPLY');
                    $('#button_add_voucher').attr('disabled', false);

                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + jqXhr.responseText + ')','error');

                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                },
            });
        });

        $('.button_bayar').click(function(e){
            e.preventDefault();

            $('.button_bayar').attr('disabled', true);
            $('.button_bayar').html('<i class="fas fa-spinner fa-spin"></i>');

            var master_produk_id = $('input[name="master_produk_id[]"]').map(function(){
                return this.value;
            }).get();

            var cart_qty = $('input[name="cartqtybutton[]"]').map(function(){
                return this.value;
            }).get();

            var cart_harga = $('input[name="cart_harga_jual[]"]').map(function(){
                return this.value;
            }).get();

            if($('#btn-ambil-ditoko').hasClass('active')){
                var harga_pengiriman = 0;
                var jasa_pengiriman = "AMBIL DI TOKO";
            } else {
                var harga_pengiriman = parseInt($('#jasa_pengiriman').find('option:selected').attr('harga-pengiriman'));
                var jasa_pengiriman = $('#jasa_pengiriman').find('option:selected').attr('jasa-pengiriman');
            }

            $.ajax({
                url: "/checkout/transaksi",
                type: "POST",
                data: {
                    'master_produk_id': master_produk_id,
                    'cart_quantity': cart_qty,
                    'cart_harga': cart_harga,
                    'alamat_pengiriman_id': $('#alamat_pengiriman_id').val(),
                    'kode_voucher': $('#voucher').val(),
                    'kode_voucher_status': voucher_active,
                    'poin_active': poin_active,
                    'jasa_pengiriman': jasa_pengiriman,
                    'harga_pengiriman': harga_pengiriman,
                    'total_harga': parseInt(convertToAngka($('#sub_total').text())),
                    'total_berat': $('#total_berat').val(),
                },
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    $('.button_bayar').html('BAYAR');
                    $('.button_bayar').attr('disabled', false);
                    if(response.status == 201) {
                        iziToast.success({
                            title: 'Success!',
                            message: response.message,
                            position: 'topRight'
                        });
                        setTimeout(function () {   window.location.href = response.link; }, 2000);
                    }else if(response.status == 301) {
                        iziToast.warning({
                            title: 'Oops!',
                            message: response.message,
                            position: 'topRight'
                        });
                        setTimeout(function () {   window.location.href = response.link; }, 1000);
                    }else{
                        Swal.fire('Oops!',response.message,'warning');
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $('.button_bayar').html('BAYAR');
                    $('.button_bayar').attr('disabled', false);

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
            url: '/checkout/delete/' + $(this).attr('data-id'),
            type: "DELETE",
            dataType: 'JSON',
            success: function( response, textStatus, jQxhr ){
                console.log(response);
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
                                <td colspan="6" class="text-center">Keranjang belanja anda kosong</td>
                            </tr>
                        `);
                        $('.button_gunakan_poin').attr('disabled', true);
                        $('#button_cek_potongan_harga_grosir').attr('disabled', true);
                        $('.button_bayar').attr('disabled', true);
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

    let total_berat_produk = 0;
    $(".berat-produk").each(function(){
        total_berat_produk += parseInt($(this).val());
    })

    $('#total_berat').val(total_berat_produk);

    </script>
@endsection
