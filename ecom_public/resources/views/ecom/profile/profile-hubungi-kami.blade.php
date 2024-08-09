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
            <h5 class="font-weight-bold">Hubungi Kami</h5>
            <p>Kontak Customer Service</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body text-center pb-2">
            <div class="row">
                <div class="ec_contact_map">
                    <div class="ec_map_canvas">
                        <iframe id="ec_map_canvas"
                            src="https://maps.google.com/maps?q=kharsima%20stationary%20kupang&t=&z=17&ie=UTF8&iwloc=&output=embed"></iframe>
                        <a href="https://sites.google.com/view/maps-api-v2/mapv2"></a>
                    </div>
                </div>
                <div class="ec_contact_info">
                    <ul class="align-items-center">
                        <li class="ec-contact-item"><i class="ecicon eci-map-marker"
                                aria-hidden="true"></i><span>Alamat :</span>Kharisma Stationary, Jalan W.J. Lalamentik nomor 80</li>
                        <li class="ec-contact-item align-items-center"><i class="ecicon eci-phone"
                                aria-hidden="true"></i><span>Hubungi Kami :</span><a href="/errors/hubungi-kami">+62 8113828859</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Terms & Condition page -->
</div>
@endsection
