
 <!DOCTYPE html>
 <html lang="en">

 <head>
	 <meta charset="UTF-8">
	 <meta http-equiv="x-ua-compatible" content="ie=edge" />
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

	 <title>SIMANHURA.</title>
	 <meta name="keywords" content="kharisma komputer, kharisma stationary, kharisma home & kichen, kharisma group, kharisma, SIMANHURA" />
     <meta name="description" content="Terlengkap - Termurah - Terpercaya">
     <meta property="image" content="https://SIMANHURA.com/front/assets/images/custom-image/logo_new.png">
	 <meta name="author" content="ashishmaraviya">

	<!-- site Favicon -->
    <link rel="icon" href="{{ asset('front/assets/images/custom-image/kharisma_favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('front/assets/images/custom-image/kharisma_favicon.png') }}" />
    <meta name="msapplication-TileImage" content="assets/images/favicon/favicon.png') }}" />

	<!-- css Icon Font -->
	<link rel="stylesheet" href="{{ asset('front/assets/css/vendor/ecicons.min.css') }}" />

	<!-- css All Plugins Files -->
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/swiper-bundle.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/jquery-ui.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/countdownTimer.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/slick.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/nouislider.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.css') }}" />

	<!-- Main Style -->
	<link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css') }}" />

	<!-- Background css -->
	<link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
</head>

<body>

	<!-- Start main Section -->
	<section class="ec-404-error-page-02">
		<div class="container">
		  <div class="row">
			<div class="col-sm-12 text-center">
				<img class="img-404" width="35%" src="{{ asset('front/assets/images/custom-image/pembayaran-berhasil.png') }}" alt="" />

				<h1 class="main-title text-center">Horray!</h1>
				<h3 class="sub-title text-center">Pembayaran Berhasil Dilakukan</h3>

				<p class="desc-content text-center">Pembayaranmu berhasil dilakukan dan sedang kami review. silahkan cek notifikasi dan email secara berkala</p>

				<p class="desc-content text-center">Anda akan dikembalikan dalam <span id="time">00:10</span></p>
			</div>
		  </div>
		</div>
	</section>
	<!-- End main Section -->

	<!-- Vendor JS -->
	<script src="{{ asset('front/assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/vendor/popper.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/vendor/bootstrap.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

	<!--Plugins JS-->
	<script src="{{ asset('front/assets/js/plugins/swiper-bundle.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/countdownTimer.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/scrollup.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/slick.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/infiniteslidev2.js') }}"></script>
	<script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

	<!-- Main Js -->
	<script src="{{ asset('front/assets/js/vendor/index.js') }}"></script>
	<script src="{{ asset('front/assets/js/main.js') }}"></script>

    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var end =setInterval(function () {
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    window.location = "/profile/transaksi-belanja?status=konfirmasiAdmin";
                    clearInterval(end);
                }
            }, 1000);
        }

        window.onload = function () {
            var fiveMinutes = 10,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
    </script>

</body>

</html>
