
@extends('partial.app')

@section('style')
    <style>
        .section-space-p {
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')
<div class="row sticky-header-next-sec">
    <!-- Start Terms & Condition page -->
    <div class="content-container mt-4 col-12 col-md-6 offset-md-3" style="padding-bottom: 1%">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Invoice Belanja</h5>
            <p>Terimakasih telah berbelanja di SIMANHURA.com</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
                        <div class="container">
                            <div class="row">
                                <div class="ec-shop-rightside col-lg-12 col-md-12">
                                    <div class="ec-vendor-dashboard-card">
                                        <div class="ec-vendor-card-header">
                                            <h5>Invoice</h5>
                                            <div class="ec-header-btn">
                                                <a class="btn btn-lg btn-secondary" href="#" hidden>Download</a>
                                            </div>
                                        </div>
                                        <div class="ec-vendor-card-body padding-b-0">
                                            <div class="page-content">
                                                <div class="page-header text-blue-d2">
                                                    @if (auth()->check() && auth()->user()->tipe_customer_id == 3)
                                                        <img src="{{ asset('front/assets/images/custom-image/logo-business-new.png') }}" alt="Site Logo" style="width: 40%">
                                                    @else
                                                        <img src="{{ asset('front/assets/images/custom-image/logo_new.png') }}" alt="Site Logo" style="width: 40%">
                                                    @endif
                                                </div>
                                                <div class="container px-0">
                                                    <div class="row mt-4">
                                                        <div class="col-lg-12">
                                                            <hr class="row brc-default-l1 mx-n1 mb-4" />

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="my-2">
                                                                        <span class="text-600 text-110 text-blue align-middle">Kepada Yth :</span>
                                                                        <br>
                                                                        <span class="text-sm text-grey-m2 align-middle">{{ $data->alamat_pengiriman->penerima }}</span>
                                                                    </div>
                                                                    <div class="text-grey-m2">
                                                                        <div class="my-2">
                                                                            {{ $data->alamat_pengiriman->alamat_lengkap }}
                                                                        </div>
                                                                        <div class="my-2"><b class="text-600">No Telp : </b>{{ $data->user->no_telepon }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->

                                                                <div
                                                                    class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                                    <hr class="d-sm-none" />
                                                                    <div class="text-grey-m2">

                                                                        <div class="my-2"><span class="text-600 text-90">No Invoice : </span>
                                                                            {{ $data->no_invoice }}</div>

                                                                        <div class="my-2"><span class="text-600 text-90">Tanggal :
                                                                            </span> {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMM Y') }}</div>
                                                                        <div class="my-2"><span class="text-600 text-90">Pembayaran :
                                                                            </span>QRIS</div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>

                                                            <div class="mt-4">
                                                                <div class="text-95 text-secondary-d3">
                                                                    <div class="ec-vendor-card-table">
                                                                        <table class="table ec-table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">ID</th>
                                                                                    <th scope="col">Nama Barang</th>
                                                                                    <th scope="col">Qty</th>
                                                                                    <th scope="col">Harga</th>
                                                                                    <th scope="col">Jumlah</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php $sub_total = 0 @endphp
                                                                                @foreach ($data->transaksi_produk as $item)
                                                                                    @php $sub_total += $item->harga * $item->quantity @endphp
                                                                                    <tr>
                                                                                        <th><span>{{ $loop->iteration }}</span></th>
                                                                                        <td><span>{{ $item->master_produk->nama_produk_desc }}</span></td>
                                                                                        <td><span>{{ $item->quantity }}</span></td>
                                                                                        <td><span>{{ number_format($item->harga,0,',','.'); }}</span></td>
                                                                                        <td><span>{{ number_format($item->harga * $item->quantity,0,',','.'); }}</span></td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <td class="border-none" colspan="3">
                                                                                        <span></span></td>
                                                                                    <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                        <span><strong>Sub Total</strong></span></td>
                                                                                    <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                        <span>{{ number_format($sub_total,0,',','.') }}</span></td>
                                                                                </tr>
                                                                                @if ($data->point_use > 0)
                                                                                    <tr style="color: yellow">
                                                                                        <td class="border-none" colspan="3">
                                                                                            <span></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                            <span><strong>Point Digunakan</strong></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                            <span>{{ number_format($data->point_use,0,',','.') }}</span></td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($data->point > 0)
                                                                                    <tr style="color: yellow">
                                                                                        <td class="border-none" colspan="3">
                                                                                            <span></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                            <span><strong>Potensi Cashback</strong></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                            <span>{{ number_format($data->point,0,',','.') }}</span></td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($data->point_bonus > 0)
                                                                                    <tr style="color: yellow">
                                                                                        <td class="border-none" colspan="3">
                                                                                            <span></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                            <span><strong>Point Bonus Belanja</strong></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                            <span>{{ number_format($data->point_bonus,0,',','.') }}</span></td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($data->harga_unique > 0)
                                                                                    <tr style="color: yellow">
                                                                                        <td class="border-none" colspan="3">
                                                                                            <span></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                            <span><strong>Point Bonus Pembayaran</strong></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                            <span>{{ number_format($data->harga_unique,0,',','.') }}</span></td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($data->potongan_harga_grosir > 0)
                                                                                    <tr style="color: yellow">
                                                                                        <td class="border-none" colspan="3">
                                                                                            <span></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                            <span><strong>Potongan Harga Grosir</strong></span></td>
                                                                                        <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                            <span>{{ number_format($data->potongan_harga_grosir,0,',','.') }}</span></td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <td class="border-none" colspan="3">
                                                                                        <span></span></td>
                                                                                    <td class="border-color" style="padding: 1px .5rem!important;" colspan="1">
                                                                                        <span><strong>Biaya Pengiriman</strong></span></td>
                                                                                    <td class="border-color" style="padding: 1px .5rem!important;">
                                                                                        <span>{{ number_format($data->harga_pengiriman,0,',','.') }}</span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="border-none m-m15"
                                                                                        colspan="3"><span class="note-text-color">
                                                                                            @if (isset($kode_voucher))
                                                                                                Anda Menggunakan Voucher <b>{{ $kode_voucher->kode_voucher}}</b>
                                                                                                <br>
                                                                                                <small>{{ $kode_voucher->deskripsi_bonus }}</small>
                                                                                            @endif
                                                                                        </span>
                                                                                    </td>
                                                                                    <td class="border-color  style="padding: 1px .5rem!important;"m-m15"
                                                                                        colspan="1"><span><strong>Total</strong></span>
                                                                                    </td>
                                                                                    <td class="border-color  style="padding: 1px .5rem!important;"m-m15">
                                                                                        <span>{{ number_format($data->total_harga,0,',','.') }}</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small style="color: red; margin-top:2%">*Perbedaan harga merupakan angka unique yang digunakan untuk validasi pembayaran</small>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- End Terms & Condition page -->
</div>
@endsection
