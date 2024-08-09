@extends('partial.app')
@section('css')
<style>
    .belum-bayar-action:hover, .lacak-pesanan-action:hover, .beri-penilaian-action:hover {
        background: #ffddc4;
    }
    .batalkan-pesanan-action:hover{
        background: #ffc7cd!important;
    }
    .terima-pesanan-action:hover{
        background: #c7ffc7;
    }
    .transaksi-img-container{
        align-items: center;
    }
    .jasa-pengiriman-text{
        text-align: center;
    }

    @media (max-width: 574px){
        .jasa-pengiriman-text{
            font-size: .7rem;
        }
    }
</style>
@endsection
@section('content')
<div class="row fix-overleap sticky-header-next-sec">
    <div class="content-container mt-4 col-12 col-md-8 offset-md-2" style="padding-right: 5px!important">
        <div class="section-title">
            <div class="back-button">
                <a href="/profile">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path
                            d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z" />
                    </svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Transaksi Belanja</h5>
            <p>Riwayat Belanja</p>
            <hr style="background-color: black; ">

            <div class="content-container-2 col-md-10 offset-md-1 text-center menu-list-order">
                <ul class="ec-pro-tab-nav nav justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="semua-tab" data-bs-toggle="tab" href="#semua" role="tab" onclick="click_tab('semua')"
                            aria-controls="semua" aria-selected="true">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="menunggu-pembayaran-tab" data-bs-toggle="tab" href="#menungguPembayaran" onclick="click_tab('menungguPembayaran')"
                            role="tab" aria-controls="menungguPembayaran" aria-selected="false">Menunggu Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="konfirmasi-admin-tab" data-bs-toggle="tab" href="#konfirmasiAdmin" onclick="click_tab('konfirmasiAdmin')"
                            role="tab" aria-controls="konfirmasiAdmin" aria-selected="false">Konfirmasi Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikemas-tab" data-bs-toggle="tab" href="#dikemas" role="tab" onclick="click_tab('dikemas')"
                            aria-controls="dikemas" aria-selected="false">Dikemas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikirim-tab" data-bs-toggle="tab" href="#dikirim" role="tab" onclick="click_tab('dikirim')"
                            aria-controls="dikirim" aria-selected="false">Dikirim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="penilaian-tab" data-bs-toggle="tab" href="#penilaian" role="tab" onclick="click_tab('penilaian')"
                            aria-controls="penilaian" aria-selected="false">Beri Penilaian</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Transaksi Not Found --}}


        <div class="tab-content" style="overflow: hidden" id="myTabContent">
            <div class="tab-fane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                @if (count($data))
                @foreach ($data as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                            <div class=" col-md-3 col-sm-2 col-6 d-flex align-items-end flex-column" style="gap: 10px">
                                @if ($item->status_desc == 'Belum Bayar')
                                    <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                        Pembayaran</button></a>
                                    <button type="button" class="fw-bold button-action-2 batalkan-pesanan-action" onclick="click_batalkan_pesanan('{{ $item->uuid }}', '{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #CF1E30; color: #CF1E30; font-size: .7rem">Batalkan Pesanan</button>
                                @elseif($item->status_desc == 'Dikirim')
                                    @if ($item->jasa_pengiriman_code != 'staff')
                                        <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="lacak-pesanan-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                        Pesanan</button></a>
                                    @endif
                                <button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                        Pesanan</button>
                                <a href="/errors/hubungi-kami"><button type="button"
                                        class="ajukan-komplain-action fw-bold button-action-2"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                @elseif($item->status_desc == 'Selesai')
                                    @if ($item->transaksi_produk[0]->bintang == null)
                                        <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="beri-penilaian-action fw-bold transaksi-action"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Beri
                                            Penilaian</button></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
            <div class="tab-fane fade" id="menungguPembayaran" role="tabpanel"
                aria-labelledby="menunggu-pembayaran-tab">
                @if(count($belum_bayar) > 0)
                @foreach ($belum_bayar as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                            <div class=" col-md-3 col-sm-2 col-6 d-flex align-items-end flex-column" style="gap: 10px">
                                @if ($item->status_desc == 'Belum Bayar')
                                    <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                        Pembayaran</button></a>
                                    <button type="button" class="fw-bold button-action-2 batalkan-pesanan-action" onclick="click_batalkan_pesanan('{{ $item->uuid }}', '{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #CF1E30; color: #CF1E30; font-size: .7rem">Batalkan Pesanan</button>
                                @elseif($item->status_desc == 'Dikirim')
                                <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="lacak-pesanan-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                        Pesanan</button></a>
                                <button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                        Pesanan</button>
                                <a href="/errors/hubungi-kami"><button type="button"
                                        class="ajukan-komplain-action fw-bold button-action-2"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                @elseif($item->status_desc == 'Selesai')
                                    @if ($item->transaksi_produk[0]->bintang == null)
                                        <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="beri-penilaian-action fw-bold transaksi-action"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Beri
                                            Penilaian</button></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
            <div class="tab-fane fade" id="konfirmasiAdmin" role="tabpanel" aria-labelledby="konfirmasi-admin-tab">
                @if(count($konfirmasi_admin) > 0)
                @foreach ($konfirmasi_admin as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                            <div class=" col-md-3 col-sm-2 col-6 d-flex justify-content-end">
                                @if ($item->status_desc == 'Belum Bayar')
                                    <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                        Pembayaran</button></a>
                                    <button type="button" class="fw-bold button-action batalkan-pesanan-action" onclick="click_batalkan_pesanan('{{ $item->uuid }}', '{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #CF1E30; color: #CF1E30; font-size: .7rem">Batalkan Pesanan</button>
                                @elseif($item->status_desc == 'Dikirim')
                                <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="lacak-pesanan-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                        Pesanan</button></a>
                                <button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                        Pesanan</button>
                                <a href="/errors/hubungi-kami"><button type="button"
                                        class="ajukan-komplain-action fw-bold button-action-2"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                @elseif($item->status_desc == 'Selesai')
                                <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="fw-bold transaksi-action beri-penilaian"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--beri-peinlaian-action base-color); color: var(--base-color); font-size: .7rem">Beri
                                        Penilaian</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </tbody>
                </table>
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
            <div class="tab-fane fade" id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
                @if(count($dikemas) > 0)
                @foreach ($dikemas as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                            <div class=" col-md-3 col-sm-2 col-6 d-flex justify-content-end">
                                @if ($item->status_desc == 'Belum Bayar')
                                    <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                        Pembayaran</button></a>
                                    <button type="button" class="fw-bold button-action batalkan-pesanan-action" onclick="click_batalkan_pesanan('{{ $item->uuid }}', '{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #CF1E30; color: #CF1E30; font-size: .7rem">Batalkan Pesanan</button>
                                @elseif($item->status_desc == 'Dikirim')
                                <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="lacak-pesanan-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                        Pesanan</button></a>
                                <button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                        Pesanan</button>
                                <a href="/errors/hubungi-kami"><button type="button"
                                        class="ajukan-komplain-action fw-bold button-action-2"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                @elseif($item->status_desc == 'Selesai')
                                <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="fw-bold transaksi-action beri-penilaian"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--beri-peinlaian-action base-color); color: var(--base-color); font-size: .7rem">Beri
                                        Penilaian</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
            <div class="tab-fane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                @if(count($dikirim) > 0)
                @foreach ($dikirim as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                                <div class=" col-md-3 col-sm-2 col-6 d-flex align-items-end flex-column" style="gap: 10px">
                                    @if ($item->status_desc == 'Belum Bayar')
                                        <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                            Pembayaran</button></a>
                                    @elseif($item->status_desc == 'Dikirim')
                                            @if ($item->jasa_pengiriman_code != 'staff')
                                                <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="fw-bold transaksi-action lacak-pesanan-action"
                                                style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                                Pesanan</button></a>
                                            @endif
                                   <button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                            Pesanan</button>
                                    <a href="/errors/hubungi-kami"><button type="button"
                                            class="ajukan-komplain-action fw-bold button-action-2"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                    @elseif($item->status_desc == 'Selesai')
                                    <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="fw-bold transaksi-action beri-penilaian-action"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--beri-peinlaian-action base-color); color: var(--base-color); font-size: .7rem">Beri
                                            Penilaian</button></a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </tbody>
                </table>
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
            <div class="tab-fane fade" id="penilaian" role="tabpanel" aria-labelledby="penilaian-tab">
                @if(count($selesai) > 0)
                @foreach ($selesai as $item)
                <div class="transaksi-content mt-5 rounded">
                    <div class="transaksi-header" style="border-bottom: 2px solid #a3a3a3">
                        <div class="row mb-2">
                            <div class="col-sm-6 col-6">
                                <a href="/profile/transaksi-belanja/invoice/{{$item->uuid}}"
                                    class="fw-bold">{{ $item->no_invoice }}</a>
                                <p class="fw-bold" style="color: var(--base-color)">{{ $item->status_desc }}</p>
                            </div>
                            <div class="col-sm-6 col-6 d-flex justify-content-end align-items-center">
                                <span class="p-2 rounded-pill fw-bolder mr-2 jasa-pengiriman-text"
                                    style="background-color: var(--base-color); color: white;">{{ $item->jasa_pengiriman }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="transaksi-body mt-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-4 transaksi-img-container">
                                <img src="{{ '/commerce/ecom_seller_final/public/berkas/master-produk/' . $item->transaksi_produk[0]->master_produk->url_image[0] }}"
                                    class="transaksi-img" alt="" srcset="">
                            </div>
                            <div class="col-md-4 col-sm-5 col-8">
                                <div class="nama-produk two-line-only">
                                    {{ $item->transaksi_produk[0]->master_produk->nama_produk_desc }}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-6 total-pesanan-container">
                                <p style="margin: 0!important">Total Pesanan</p>
                                <p class="fw-bold">{{ "Rp " . number_format($item->total_harga,2,',','.') }}</p>
                            </div>
                            <div class=" col-md-3 col-sm-2 col-6 d-flex justify-content-end">
                                @if ($item->status_desc == 'Belum Bayar')
                                    <a href="/pembayaran/{{$item->uuid}}"><button type="button" class="belum-bayar-action fw-bold transaksi-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lakukan
                                        Pembayaran</button></a>
                                    <button type="button" class="fw-bold button-action batalkan-pesanan-action" onclick="click_batalkan_pesanan('{{ $item->uuid }}', '{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #CF1E30; color: #CF1E30; font-size: .7rem">Batalkan Pesanan</button>
                                @elseif($item->status_desc == 'Dikirim')
                                <a href="/profile/transaksi-belanja/tracking-order/{{ $item->uuid }}"><button type="button" class="fw-bold transaksi-action lacak-pesanan-action"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Lacak
                                        Pesanan</button></a>
                                <a href="javascript:void(0)"><button type="button" class="fw-bold button-action terima-pesanan-action" onclick="click_terima_pesanan('{{ $item->uuid }}','{{ $item->no_invoice }}')"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #59B259; color: #59B259; font-size: .7rem">Terima
                                        Pesanan</button></a>
                                <a href="/errors/hubungi-kami"><button type="button"
                                        class="ajukan-komplain-action fw-bold button-action-2"
                                        style="padding: 10px; border-radius: 16px!important; border: 2px solid #b3c7ff; color: #0072ff; font-size: .7rem">Ajukan Komplain</button></a>
                                @elseif($item->status_desc == 'Selesai')
                                    @if ($item->transaksi_produk[0]->bintang == null)
                                        <a href="/profile/penilaian/{{ $item->uuid }}"><button type="button" class="beri-penilaian-action fw-bold transaksi-action"
                                            style="padding: 10px; border-radius: 16px!important; border: 2px solid var(--base-color); color: var(--base-color); font-size: .7rem">Beri
                                            Penilaian</button></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="image-content py-5">
                    <div class="transaksi-not-found container d-flex justify-content-center my-4">
                        <img src="{{ asset('front/assets/images/project/not-found.png') }}" alt="">
                    </div>
                    <h5 class="text-secondary text-center">Belum Ada Pesanan</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>

        $(document).ready(function(){
            let searchParams = new URLSearchParams(window.location.search);
            if(searchParams.has('status')){
                let param = searchParams.get('status');
                $('.nav-item a[href="#' + param + '"]').tab('show');
                $('a[href="#' + param + '"]').addClass('active');
            }else{
                $(`#semua-tab`).addClass("active");
            }
        })

        function click_tab(href){
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?status=' + href;
            window.history.pushState({path:newurl},'',newurl);
        }

        function click_batalkan_pesanan(uuid, no_invoice){
            Swal.fire({
                    title: 'Yakin?',
                    text: 'Apakah anda yakin akan membatalkan pesanan ' + no_invoice + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya! Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url : '/profile/transaksi-belanja/cancel-pesanan/' + uuid,
                        type: "GET",
                        dataType: "JSON",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

                            if(response.status == 200){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                $("#form_submit")[0].reset();
                                reset_all_select();
                                tb.ajax.reload(null, false);
                            }
                            else if(response.status == 201){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                window.location.href = response.link;
                            }
                            else if(response.status == 203){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                tb.ajax.reload(null, false);
                            }
                            else if(response.status == 300){
                                Swal.fire('Oops!',response.message,'error');
                            }

                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                        }
                    });
                }
            });
        }

        function click_terima_pesanan(uuid, no_invoice){
            Swal.fire({
                    title: 'Yakin ?',
                    text: 'Pastikan pesanan ' + no_invoice + ' yang anda terima telah sesuai',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#58B25A',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya! Terima Pesanan'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url : '/profile/transaksi-belanja/terima-pesanan/' + uuid,
                        type: "GET",
                        dataType: "JSON",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

                            if(response.status == 200){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                $("#form_submit")[0].reset();
                                reset_all_select();
                                tb.ajax.reload(null, false);
                            }
                            else if(response.status == 201){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                window.location.href = response.link;
                            }
                            else if(response.status == 203){
                                Swal.fire('Good job!',response.message,'success');
                                $("#modal").modal('hide');
                                tb.ajax.reload(null, false);
                            }
                            else if(response.status == 300){
                                Swal.fire('Oops!',response.message,'error');
                            }

                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                        }
                    });
                }
            });
        }
    </script>
@endsection

