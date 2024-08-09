@extends('partial.app');

@section('title','Detail Transaksi')

@section('content')
<div class="section-body">
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Detail Transaksi</h2>
                        <div class="invoice-number">Order {{ $data->no_invoice }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                {{ $data->alamat_pengiriman->penerima ?? '' }}<br>
                                {{ $data->alamat_pengiriman->alamat_lengkap ?? '' }}<br>
                                {{ $data->jasa_pengiriman ?? '' }}<br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="section-title">Barang Teroder</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tr>
                                <th data-width="40">#</th>
                                <th>Item</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                            </tr>
                            @php
                            $sub_total = 0;
                            @endphp
                            @foreach ($data->transaksi_produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->master_produk->nama_produk_desc }}</td>
                                <td class="text-center">{{ "Rp. " . number_format($item->harga,0,',','.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ "Rp. " . number_format($item->harga * $item->quantity,0,',','.') }}</td>
                                @php
                                $sub_total += $item->harga * $item->quantity;
                                @endphp
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8">
                            <div class="section-title">Vocher yang digunakan</div>
                            @if (isset($kode_voucher))
                                <p class="section-lead">Anda Menggunakan Voucher <b class="text-primary">{{ $kode_voucher->kode_voucher}}</b></p>
                                <p class="section-lead" style="margin-top:-2%">{{ $kode_voucher->deskripsi_bonus }}</p>
                            @else
                                <p class="section-lead">Anda tidak menggunakan voucher</p>
                            @endif
                            <div class="images">
                                <img src="{{ asset('assets/img/QRIS_logo.svg') }}" class="mt-5" width="300px"
                                    alt="Qris Logo">
                            </div>
                        </div>
                        <div class="col-lg-4 text-right">
                            <div class="row">
                                <div class="col-6">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Subtotal</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Pengiriman</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Point Digunakan</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Potensi Cashback</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Point Bonus Belanja</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Point Kode Unique</div>
                                        <div class="invoice-detail-name" style="margin-top: .8rem; margin-bottom: .8rem">Potongan Harga Grosir</div>
                                        <hr class="mt-4" style="margin-bottom: 35px">
                                        <div class="invoice-detail-name h5">Total</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($sub_total,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->harga_pengiriman,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->point_use,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->point,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->point_bonus,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->harga_unique,0,',','.') }}</div>
                                        <div class="invoice-detail-value mt-2">{{ "Rp. " . number_format($data->potongan_harga_grosir,0,',','.') }}</div>
                                        <hr class="mt-4 mb-4">
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{ "Rp. " . number_format($data->total_harga,0,',','.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <span class="text-danger">*Perbedaan harga merupakan angka unique yang digunakan untuk validasi pembayaran</span>
            <button class="btn btn-warning btn-icon icon-left" onclick="cetak_invoice_pdf('{{$data->uuid}}')"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function cetak_invoice_pdf(uuid){
            window.open(
                '/admin/apps/transaksi/cetak-invoice-pdf/' + uuid,
                '_blank' // <- This is what makes it open in a new window.
            );
        }
    </script>
@endsection
