
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>404 &mdash; Not Found</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/upn/logo-upn-min.png') }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/login/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            {{-- <h1>404</h1> --}}
            <img src="{{ asset('assets/img/error_404.png') }}" width="500" alt="404" style="margin-top: 40px;">
            <div class="page-description" style="margin-top: 20px; font-size: 30px;">
               Resi Tidak Ditemukan atau menggunakan jasa kirim Kurir Kharisma
            </div>
            <div class="page-search">
              <div class="mt-3">
                <a href="/admin/apps/transaksi">Back to Transaksi</a>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
        </div>
      </div>
    </section>
  </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    </body>
</html>
