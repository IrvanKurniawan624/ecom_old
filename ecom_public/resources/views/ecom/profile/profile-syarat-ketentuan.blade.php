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
            <h5 class="font-weight-bold">Syarat dan Ketentuan</h5>
            <p>Syarat dan Ketentuan Berbelanja di Kharisma Online</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body text-center pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Ketersediaan Barang.</h3>
                                <p>Setiap produk di Toko Kami tersedia sepanjang tidak ditandai “Sold Out”. Ketika produk sudah terjual semua atau stok habis dan jika stok produk akan diisi kembali, Anda dapat meminta kami untuk mengirimkan pemberitahuan via email jika produk sudah tersedia. Agar lebih mudah, follow kami di twitter kami atau like facebook kami karena setiap barang tersedia kembali akan diinformasikan melalui twitter atau facebook.</p>
                                <p>Kami selalu memastikan agar sistem kami dapat bekerja dengan baik demi memberikan pelayanan terbaik kepada Anda. Jika tanpa sengaja Anda memesan sebuah produk yang stoknya tidak tersedia maka pesanan tersebut akan dibatalkan secara otomatis dan Anda akan memperoleh informasi melalui email atau telepon. Jika pesanan Anda telah dibatalkan namun Anda sudah membayar, Anda akan diberikan pilihan untuk membeli/menggantinya dengan produk lain atau meminta uang Anda kembali.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pembelian</h3>
                                <p>Setiap pembelian yang statusnya sudah “dikemas” tidak dapat dibatalkan. kami hanya menyediakan fasilitas Return (pengembalian) bila barang tidak sesuai. Informasi selengkapnya ada di bagian Ajukan Komplain.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pembayaran</h3>
                                <p>Pembayaran dilakukan oleh pembeli dalam jangka waktu yang tertera pada halaman Pembayaran/Konfirmasi setelah barang dibook online di toko kami (checkout). Jika dalam jangka waktu tersebut pembeli belum melakukan pembayaran setelah 24 Jam maka transaksi dianggap batal dan barang dikembalikan ke dalam sistem. Closing pembayaran melalui website kami dilakukan dalam jangka waktu maksimal 2 jam setelah pembeli melakukan konfirmasi pengiriman uang pada jam kerja dan hari kerja.</p>
                                <p>Jika pembayaran telah dilakukan, Anda harus mengkonfirmasi pembayaran melalui website kami dengan mengklik “Confirm Payment”.</p>
                                <p>Setelah kami menerima pembayaran Anda, kami akan mengkonfirmasi pembayaran tersebut dan status pesanan Anda akan diganti menjadi “Confirmed” maksimal 2 jam setelah pembayaran (pada hari kerja). Setelah kami mengkonfirmasi pembayaran Anda, kami akan mengirim pesanan Anda pada hari berikutnya.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pengiriman Barang</h3>
                                <p>Pengiriman barang dilakukan oleh pihak kami. paling cepat 1×24 jam setelah konfirmasi pembayaran pada hari kerja. Lamanya waktu pengiriman tergantung jasa pengiriman yang dipilih. Setelah sampai di jasa pengiriman, barang berada di bawah tanggung jawab jasa pengiriman barang.</p>
                                <p> <b>1. Biaya Pengiriman</b> </p>
                                <p>Biaya pengiriman tergantung pada lokasi Anda dan berat produk yang Anda beli.</p>
                                <p><b>2. Lama Waktu Pengiriman</b></p>
                                <p>Pengiriman pesanan akan dilakukan dari kantor pusat kami di Jakarta. Pengiriman Reguler membutuhkan waktu 2–3 hari kerja. Perlu diperhatikan bahwa untuk beberapa kota, jasa pengiriman kami tidak menyediakan jasa kilat sehingga pengiriman mungkin membutuhkan waktu sampai dengan 6 hari kerja.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Status Pesanan</h3>
                                <p> <b>1. Menunggu Pembayaran</b> </p>
                                <p>Pembayaran sudah dicheckout namun belum dilakukan pembayaran pesanan. Status menunggu pembayaran bertahan 24 Jam setelah itu pesanan akan otomatis tercancel</p>
                                <p><b>2. Konfirmasi Admin</b></p>
                                <p>Customer sudah melakukan pembayaran dan sedang tahap konfirmasi pembayaran yang dilakukan oleh admin.</p>
                                <p><b>3. Dikemas</b></p>
                                <p>Pesanan dalam proses pengemasan oleh pihak SIMANHURA</p>
                                <p><b>4. Dikirim</b></p>
                                <p>berarti pesanan Anda sudah dikemas dan akan kami teruskan kepada jasa pengiriman</p>
                                <p><b>5. Beri Penilaian</b></p>
                                <p>Barang sudah sampai dan anda dapat memberikan penilaian maupun mengajukan komplain terhadap barang anda terima</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block mt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Customer Service</h3>
                                <p>Kami hanya akan melayani pertanyaan dari pelanggan seputar masalah teknis pembelian dan pengiriman barang. Segala pertanyaan seputar barang akan diteruskan ke Tenant dan menjadi tanggung jawab Tenant. Pertanyaan seputar pembayaran dan pengiriman barang secara online via contact form Website Kami dan akan dibalas/diteruskan paling lambat setengah hari kerja (4 jam).</p>
                            </div>
                        </div>
                        <div class="col-sm-12 ec-cms-block pt-2">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Pengembalian Barang</h3>
                                <p>Demi mengutamakan pelayanan yang maksimal kepada pembeli di Toko Online Kami, kami menyediakan fasilitas Pengembalian Barang (Return). Pembeli dapat menggunakan fasilitas ini apabila ukuran barang yang diterima tidak sesuai dengan ukuran yang dipesan atau terdapat cacat. Karena pembeli tidak dapat melakukan pembatalan pembelian barang, pembeli harus menukarkan dengan produk yang sama dengan ukuran yang sesuai atau yang tidak cacat. Pengembalian hanya dapat dilakukan dalam jangka waktu 2×24 jam sejak barang diterima via jasa pengiriman barang. Pembeli yang melakukan pengembalian barang wajib melampirkan dokumen tanda terima barang.</p>
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
