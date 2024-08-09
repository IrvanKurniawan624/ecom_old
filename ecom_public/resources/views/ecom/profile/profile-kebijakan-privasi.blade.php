@extends('partial.app')

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
            <h5 class="font-weight-bold">Kebijakan Privasi</h5>
            <p>Kebijakan Privasi Berbelanja di Kharisma Online</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body text-center pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Aturan Penggunaan</h3>
                                <p>Selamat datang di website kami. Dengan mengakses website ini berarti Anda menyetujui aturan, pedoman, kebijakan, syarat dan ketentuan yang berlaku di website ini. Aturan, pedoman, syarat dan ketentuan yang berlaku pada website ini dapat berubah sewaktu-waktu. </p>
                                <p><b>DENGAN MENGAKSES DAN MENGGUNAKAN WEBSITE INI BERARTI ANDA MENYETUJUI ATURAN, PEDOMAN, SYARAT DAN KETENTUAN YANG TERTERA DI BAWAH INI. MOHON MEMBACA DENGAN CERMAT PERSETUJUAN DI BAWAH INI SEBELUM MELAKUKAN TRANSAKSI DI WEBSITE INI.</b></p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pembatasan</h3>
                                <p>Merek dagang, logo, fotografi, ilustrasi, gambar, dan grafis semuanya milik kami. Anda tidak boleh menyalin, memodifikasi, memperbanyak, menjual atau mengeksploitasi dengan cara apapun isi dari situs ini atau perangkat lunak terkait tanpa seizin kami.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Kebijakan Privasi</h3>
                                <p>Terima kasih telah mengakses website kami. Kami sangat menghormati kenyamanan privasi Anda dan melindungi informasi pribadi Anda sebaik-baiknya. Ketika anda mendaftar atau berbelanja di kami, kami menyimpan nama, jenis kelamin, tanggal lahir, alamat pengiriman, nomor telepon, dan alamat email. Informasi yang kami dapatkan dari Anda akan digunakan untuk memproses dan mengirimkan pesanan anda. Kami mengamankan informasi pribadi Anda dengan baik. Segala informasi pribadi Anda tidak akan kami jual, sewa, atau bagikan kepada pihak lain kecuali seperti yang disebutkan di bawah ini.</p>
                                <p>Kami dapat membagikan informasi anda kepada Penyedia Layanan Pihak Ketiga Berwenang. Kami menyediakan beberapa produk layanan melalui pihak ketiga. “Penyedia Layanan Pihak Ketiga” tersebut melakukan fungsinya sesuai kepentingan seperti mengirim atau mendistribusikan email promosi dan melakukan proses pengiriman melalui jasa pengiriman dimana mereka mengirimkan produk kami kepada Anda. Kami membagikan informasi pribadi Anda kepada Penyedia Layanan tersebut untuk mengirim email, menghapus informasi yang berulang pada data customer, manganalisis data, menyediakan asisten pemasaran, menyediakan hasil pencarian dan links, mengoperasikan situs, memecahkan masalah, dan menyediakan customer service. Kami juga mengumpulkan informasi pribadi dari individu dan perusahaan (“Affiliates”) dengan mereka yang memiliki hubungan kerjasama bisnis. Kami juga berbagi informasi dengan Penyedia Layanan untuk menyelesaikan proses administrasi. Kami mendorong Penyedia Pihak Ketiga untuk bertindak setiap saat sesuai dengan Kebijakan Privasi kami serta untuk mengadopsi dan memposting kebijakan privasi mereka sendiri.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Berhenti berlangganan</h3>
                                <p>Jika sebelumnya Anda telah setuju untuk membagikan informasi Anda untuk tujuan marketing, tapi kemudian ingin berhenti menerima informasi marketing dari kami, silakan menekan tautan unsubsribe di email marketing kami. Jika Anda ingin mengetahui tujuan penggunaan informasi Anda, silakan menghubungi kami melalui email</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Penyangkalan</h3>
                                <p>kami dapat mengubah isi website kapan saja. Kami berhak mengubah kebijakan, foto produk, dan deskripsi produk sewaktu-waktu dan tanpa pemberitahuan. Warna pakaian dapat berbeda tergantung monitor yang Anda gunakan.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Kesalahan Pengetikan</h3>
                                <p>Apabila ada kesalahan dalam harga dan informasi yang tercantum pada produk yang disebabkan oleh kesalahan pengetikan yang dilakukan oleh tenant, kami berhak untuk menolak atau membatalkan pesanan apabila Anda telah memesan barang dengan harga dan informasi yang salah dicantumkan. Kami juga berhak untuk menolak atau membatalkan pesanan apabila Anda ingin membatalkan pesanan yang telah dibayar. Anda berhak mendapatkan uang Anda apabila Anda membatalkan pesanan yang telah dibayar.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pertanyaan Lebih Lanjut</h3>
                                <a href="/errors/hubungi-kami"><button class="btn btn-danger">Hubungi Kami</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Terms & Condition page -->
</div>
@endsection
