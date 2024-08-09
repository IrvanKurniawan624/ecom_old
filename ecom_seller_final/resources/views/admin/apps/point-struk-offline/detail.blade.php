@extends('partial.app')
@section('title','Detail Point Struk Offline')

@section('content')
<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h4>Data Point Struk Offline</h4>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                           <label>Tipe Customer</label>
                           <input type="text" class="form-control" value="@if(isset($data)){{$data->user->tipe_customer->customer}}@endif" readonly>
                        </div>
                  </div>
                  <div class="col-12 col-md-8 col-lg-8">
                        <div class="form-group">
                           <label>Nama Pelanggan</label>
                           <input type="text" class="form-control" value="@if(isset($data)){{$data->user->nama}}@endif" readonly>
                        </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                           <label>Nominal Belanja</label>
                           <input type="text" class="form-control" value="@if(isset($data)){{ "Rp " . number_format($data->nominal_belanja,0,',','.')}}@endif" readonly>
                        </div>
                  </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                        <label>Poin</label>
                        <input type="text" class="form-control" name="poin" id="poin" value="@if(isset($data)){{$data->poin}}@endif" onkeyup="return onkeyupRupiah(this.id);">
                        </div>
                    </div>
               </div>
            </div>

            <div class="card-footer text-right" id="btn_approval">

                    @if($data->status == 0)
                        <button type="button" class="btn float-right btn-danger" onclick="approval('{{ $data->id }}', '2');"><i class="fa fa-times m-1"></i> Tolak</button>
                        <button type="button" class="btn float-right btn-success mr-1" onclick="approval('{{ $data->id }}', '1');"><i class="fa fa-check m-1"></i> Terima</button>
                    @endif
                    <a href="/admin/apps/point-struk-offline"><button type="button" class="btn float-left btn-secondary"><i class="fas fa-chevron-left"></i> Back</button></a>

            </div>

         </div>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
               <h4>Data Point Struk Offline</h4>
            </div>
            <div class="card-body">
               <div class="row">
                    {{-- <div class="col-12 col-md-12 col-lg-12">
                        <img src="{{ str_contains($data->url_image, 'https://api-SIMANHURA.s3.ap-southeast-1.amazonaws.com') ? $data->url_image : 'https://SIMANHURAonline.com/' . $data->url_image }}" style="max-width:100%;max-height:100%;" alt="">
                    </div> --}}
               </div>
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
            question = "Apakah anda yakin akan menerima data ini?";
        }else{
            question = "Apakah anda yakin akan menolak data ini?";
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
                            url : '/admin/apps/point-struk-offline/approve',
                            type: "POST",
                            data: {
                                'id': id,
                                'type': type,
                                'poin': $('#poin').val(),
                            },
                            dataType: "JSON",
                            success: function(response){
                                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                                if(response.status === 200){
                                    swal(response.message, { icon: 'success', });
                                    $(".swal-button--confirm").click(function() {
                                        window.location.href = "/admin/apps/point-struk-offline";
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
