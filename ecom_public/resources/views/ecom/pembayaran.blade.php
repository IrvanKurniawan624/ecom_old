@extends('partial.app');

@section('css')
<style>
  .btn-copy:hover {
    background: darkgray !important;
  }
</style>
@endsection

@section('content')
<section style="background-color: #eee;">
  <div class="container py-5 ">
    <div class="row d-flex justify-content-center sticky-header-next-sec">
      <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card">
          <div class="card-header bg-white p-3">
            <h5 class="fw-bold">Pembayaran</h5>
            <p>Bayar Pembelian anda melewati halaman ini</p>
          </div>
          <div class="card-body p-md-5" style="padding-top: 0!important;">
            <div class="info-pembayaran mt-3">
              <div class="row">
                <div class="col-6">
                  <div class="NVA">
                    <p class="label-info-pembayaran">Nomor Invoice</p>
                    <input type="text" value="{{ $data->uuid }}" id="uuid" hidden>
                    <p class="fw-bold">{{ $data->no_invoice }}</p>
                  </div>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center"><button type="button"
                    id="place_countdown" disabled class="btn-sm btn-primary mr-2">--:--:--</button></div>
              </div>
              <div class="exp">
                <p class="label-info-pembayaran">Bayar Sebelum</p>
                <p class="fw-bold">
                  {{ \Carbon\Carbon::parse( $data->datetime_batas_pembayaran )->isoFormat('dddd, D MMM Y HH:mm:ss'); }}
                </p>
                <input type="text" hidden value="{{ $data->datetime_batas_pembayaran }}" id="datetime_batas_pembayaran">
              </div>
              <div class="image-container justify-content-center">
                <img src="/commerce/ecom_seller_final/public/{{ $data->master_seller->qris }}" alt="">
              </div>
              <div class="total mt-5 text-center" style="font-size: 1.3rem">
                <p class="label-info-pembayaran">Total Pembayaran</p>
                <p class="fw-bold" style="font-size: 2rem !important; color: #EF7F2D"> IDR
                  {{ number_format($data->total_harga,0,',','.') }} </p>
              </div>
            </div>

            <div class="my-5">
              <h5 class="fw-bold">Pembayaran (Transfer Bank)</h5>
              <div class="d-flex justify-content-center" style="flex-direction: column">
                <p style="font-size: .9rem; margin-bottom: 4px ">Harap lakukan pembayaran hanya di Nomor Rekening ini
                  dan simpan bukti transfer.</p>
                <p style="font-size: .9rem; margin-bottom: 4px "><i>*Jangan lupa wajib transfer hingga digit terakhir
                    pembayaran</i></p>
              </div>
              <div class="row">
                <div class="col-4 col-md-3 col-lg-3">
                  <img
                    src="https://www.freepnglogos.com/uploads/logo-bca-png/bank-central-asia-logo-bank-central-asia-bca-format-cdr-png-gudril-1.png"
                    width="150px" alt="" srcset="">
                </div>
                <div class="col-8 col-md-9 col-lg-9 d-flex justify-content-center" style="flex-direction: column">
                  <p style="font-size: .9rem; margin-bottom: 4px ">PT. BCA (BANK CENTRAL ASIA) TBK</p>
                  <p style="font-size: .9rem; margin-bottom: 4px "><b id="text">{{ $data->master_seller->no_rekening }}</b><button
                      class="btn-sm btn-primary ml-2 btn-copy" onclick="copy_clipboard('#text')"
                      style="font-size: 12px">Copy</button></p>
                  <p style="font-size: .9rem; margin-bottom: 4px ">a.n <b>{{ $data->master_seller->nama }}</b></p>
                </div>
              </div>
            </div>

            <div class="cara-pembayaran">
              <div class="container-fluid mt-5 content-container-2">
                <h5 class="fw-bold">Tata Cara Pembayaran</h5>
                <div class="col-12">
                  <div class="container-fluid p-3 rounded" style="background-color: #f4f4f4">
                    <ul>
                      <li>
                        <p>1. Buka OVO, Gojek, Dana, Link Aja, Ewallet atau aplikasi mobile-banking yang Anda miliki</p>
                      </li>
                      <li>
                        <p>2. Pastikan Nomor Rekening dan Nama sesuai untuk metode Transfer Bank, nama penerima yang
                          valid hanya <b>{{ $data->master_seller->nama }}</b> </p>
                      </li>
                      <li>
                        <p>3. Input jumlah nominal yang harus dibayarkan <b>(Wajib sesuai hingga digit terakhir)</b>
                        </p>
                      </li>
                      <li>
                        <p>4. Screenshot bukti pembayaran sebagai bukti telah melakukan pembayaran</p>
                      </li>
                      <li>
                        <p>5. Kirimkan bukti screenshot pembayaran ke wa <b>{{ $data->master_seller->no_telepon_pembayaran }}<b></p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>


            <div class="mt-5">
              <button class="btn btn-primary btn-block btn-lg" id="button_bayar">
                Sudah Membayar <i class="fas fa-long-arrow-alt-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    var countDownDate = new Date($('#datetime_batas_pembayaran').val()).getTime();

    var myfunc = setInterval(function () {
      var now = new Date().getTime();
      var timeleft = countDownDate - now;

      var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

      $('#place_countdown').html(pad(hours, 2) + ":" + pad(minutes, 2) + ":" + pad(seconds, 2));

    }, 1000)
  });

  function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
  }

  $('#button_bayar').click(function () {

    swal.fire({
      title: 'Yakin...?',
      text: 'Apakah Anda Yakin Sudah Membayar...?',
      icon: 'warning',
      showDenyButton: true,
      confirmButtonText: 'Sudah',
      denyButtonText: 'Belum',
    }).then((result) => {
      if (result.isConfirmed) {
        
        $('#button_bayar').attr('disabled', true);
        $('#button_bayar').html('<i class="fas fa-spinner fa-spin"></i>');
        swal.fire({
          title: 'Info...?',
          html: 'Mohon Kirimkan Bukti Transfer ke wa <b>{{ $data->master_seller->no_telepon_pembayaran }}</b> untuk Konfirmasi Pembayaran</br><button type="button" class="btn-sm btn-yes swal2-cancel swal2-styled" onclick="copy_no_telp()" style="font-size: 12px">Copy No. Telp</button>',
          icon: 'warning',
          allowOutsideClick: false,
          allowEscapeKey: false,
        }).then(function() {
          $.ajax({
            url: '/pembayaran/bayar/' + $('#uuid').val(),
            type: "GET",
            dataType: 'JSON',
            success: function (response, textStatus, jQxhr) {
              if (response.status == 201) {
                Swal.fire('Yeay!', response.message, 'success');
                setTimeout(function () {
                  window.location.href = response.link;
                }, 1000);
              }
            },
            error: function (jqXhr, textStatus, errorThrown) {
              console.log(errorThrown);
              console.warn(jqXhr.responseText);
            },
          });
        });
      } else if (result.isDenied) {
        Swal.fire('Info', 'Silahkan Lakukan Pembayaran Terlebih Dahulu...', 'info')
      }
    })

  });

  function copy_no_telp(){
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val('+628113828859').select();
    document.execCommand("copy");
    $temp.remove();
  }

  function copy_clipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('.btn-copy').text('Copied!');
    $('.btn-copy').removeClass('btn-primary');
    $('.btn-copy').addClass('btn-secondary');
  }
</script>
@endsection