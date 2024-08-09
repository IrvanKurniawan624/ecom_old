@extends('partial.app')

@section("css")
<style>
    @media (max-width: 300px){
        .back-button{
            padding: 5px 5px 10px 5px;
        }
        .section-title p{
            font-size: .7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .section-title h5{
            font-size: .8rem;
        }
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
            <h5 class="font-weight-bold">Syarat Ketentuan</h5>
            <p>Syarat dan Ketentuan Kode Voucher</p>
            <hr style="background-color: black; ">
        </div>
        <div class="section-body text-center pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title text-center d-flex justify-content-center">
                                    <div style="border:2px dashed black;padding: 25px;text-align: center; width: 90%;">
                                        <b>{{ $data->kode_voucher }}</b>
                                    </div>
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">{{ $data->title }}</h3>
                                <p>{{ $data->keterangan }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Syarat Ketentuan Voucher</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
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
