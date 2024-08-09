@extends('partial.app')
@section('content')
    <div class="content-container mt-4 container col-12 col-md-8 offset-md-2 sticky-header-next-sec">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Voucher Saya</h5>
            <p>Gunakan Vouchermu Disini...</p>
            <hr style="background-color: black; ">
            <input type="text" id="voucher_available" value="false" hidden>

            <form class="form row mt-4">
                <div class="col-6 offset-2">
                    <input type="text" class="form-control" id="kode_voucher" name="kode_voucher" placeholder="Masukkan Kode Voucher" onkeyup="return onkeyupUppercase(this.id);">
                </div>
                <div class="col-2 my-auto">
                    <button type="button" onclick="action_kode_voucher()" class="btn btn-primary btn-submit">Claim</button>
                </div>
            </form>

        </div>
        <div class="container">
            <div class="row px-4" id="place_kode_voucher">
                <center>
                    <img src="{{ asset('front/assets/images/project/not-found.png') }}" draggable="false" alt="" style="width:40%;">
                </center>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            get_data_voucher();
        });

        function action_kode_voucher(){

            console.log($('#kode_voucher').val());
            if($('#kode_voucher').val() == ''){
                Swal.fire('Oops!','Voucher tidak boleh kosong','error');
                return;
            }

            $("#modal_loading").modal('show');
            $.ajax({
                url : "/profile/voucher/action-kode-voucher/" + $('#kode_voucher').val(),
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status === 200){
                        Swal.fire('Good job!',response.message,'success');

                        if($('#voucher_available').val() == 'false'){
                            $('#place_kode_voucher').html('');
                        }

                        $('#place_kode_voucher').append(`
                            <div class="col-md-4 col-sm-6 col-12 content-container">
                                <div class="row">
                                    <div class="col-4 image-container">
                                        <img src="{{ asset('front/assets/images/project/voucher.jpg') }}" alt="">
                                    </div>
                                    <div class="desc-voucher col-8">
                                        <h5 class="one-line-only">${response.data.kode_voucher.kode_voucher}</h5>
                                        <p style="font-size: 9px" class="two-line-only">${response.data.kode_voucher.keterangan}</p>
                                        <a href="/profile/voucher/detail/${response.data.kode_voucher.kode_voucher}"><button type="button" class="btn-primary btn-sm rounded" style="float: right;">Show</button></a>
                                    </div>
                                </div>
                            </div>
                        `);
                    }else{
                        Swal.fire('Oops!',response.message,'error');
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        }

        function get_data_voucher(){
            $("#modal_loading").modal('show');
            $.ajax({
                url : "/master/data-kode-voucher-claim-active-by-user-id",
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    console.log(response);
                    if(response.status === 200){
                        var data = response.data;
                        $('#place_kode_voucher').empty();
                        $('#voucher_available').val('true');
                        for (var i = 0; i < data.length; i++) {
                            $("#place_kode_voucher").append(`
                                <div class="col-md-4 col-sm-6 col-12 content-container">
                                    <div class="row">
                                        <div class="col-4 image-container">
                                            <img src="{{ asset('front/assets/images/project/voucher.jpg') }}" alt="">
                                        </div>
                                        <div class="desc-voucher col-8">
                                            <h5 class="one-line-only">${data[i].kode_voucher}</h5>
                                            <p style="font-size: 9px" class="two-line-only">${data[i].keterangan}</p>
                                            <a href="/profile/voucher/detail/${data[i].kode_voucher}"><button type="button" class="btn-primary btn-sm rounded" style="float: right;">Show</button></a>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                     Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        }
    </script>
@endsection
