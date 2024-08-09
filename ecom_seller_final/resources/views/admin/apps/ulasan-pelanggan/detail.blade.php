@extends('partial.app')
@section('title','Detail Ulasan Pelanggan')

@section('css')
    <style>
        .checked {
            color: orange;
        }
    </style>
@endsection

@section('content')
<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h4>Data Ulasan Pelanggan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>No Invoice</label>
                            <input type="text" class="form-control" value="@if(isset($data)){{$data->transaksi->no_invoice}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" value="@if(isset($data)){{$data->master_produk->nama_produk_desc}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control" value="@if(isset($data)){{$data->transaksi->user->nama}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Bintang</label>
                            <div class="star">
                               @for ($i = 1; $i <= 5; $i++)
                                   @if ($i <= $data->bintang)
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                   @endif
                               @endfor
                            </div>
                        </div>
                    </div>
                    @if ($data->status == 0)
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Jumlah Bintang</label>
                                <input type="number" class="form-control" min="1" max="5" name="bintang" id="bintang" value="@if(isset($data)){{$data->bintang}}@endif">
                            </div>
                        </div>
                    @endif
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Ulasan</label>
                            <textarea class="form-control" style="white-space: pre-line;height: 80px" @if ($data->status != 0) readonly @endif name="komentar" id="komentar">@if(isset($data)){{$data->komentar}}@endif</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer" id="btn_approval">
                @if($data->status == 0)
                <button type="button" class="btn float-right btn-danger" onclick="approval('{{ $data->id }}', '2');"><i class="fa fa-times m-1"></i> Tolak</button>
                <button type="button" class="btn float-right btn-success mr-1" onclick="approval('{{ $data->id }}', '1');"><i class="fa fa-check m-1"></i> Terima</button>
                @endif
                <a href="/admin/apps/ulasan-pelanggan"><button type="button" class="btn float-left btn-secondary"><i class="fas fa-chevron-left"></i> Back</button></a>
            </div>

         </div>
      </div>
   </div>
</div>
@endsection

@section('js')
<script>

    function approval(id, type){
        var question = "";
        if(type === "1"){
            question = "Apakah anda yakin akan menerima ulasan ini?";
        }else{
            question = "Apakah anda yakin akan menolak ulasan ini?";
        }

        swal({
                title: 'Yakin?',
                text: question,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
        })
        .then((willDelete) => {
                if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url : '/admin/apps/ulasan-pelanggan/approve',
                            type: "POST",
                            data: {
                                'id': id,
                                'type': type,
                                'bintang': $('#bintang').val(),
                                'komentar': $('#komentar').val(),
                            },
                            dataType: "JSON",
                            success: function(response){
                                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                                if(response.status === 200){
                                    swal(response.message, { icon: 'success', });
                                    $(".swal-button--confirm").click(function() {
                                        window.location.href = "/admin/apps/ulasan-pelanggan";
                                    });
                                }else{
                                    swal(response.message, { icon: 'error', });
                                }
                            },error: function (jqXHR, textStatus, errorThrown){
                                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                            }
                        });
                }
        });
    }

</script>
@endsection
