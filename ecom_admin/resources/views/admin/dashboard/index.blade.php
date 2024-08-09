@extends('partial.app')
@section('title','Dashboard')
@section('content')

<div class="section-body">

   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-body ">
              <div class="text-center mb-2 mt-2">
                <h3 class="text-warning">Welcome Back, Admin!</h3>
              </div>
          </div>
        </div>
      </div>
    </div>

</div>
<input type="text" id="monthyear" value="{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}" hidden>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_dikemas" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title">Resi Pengiriman</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_dikemas">
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Jasa Pengiriman Default</label>
                            <input type="text" class="form-control" id="jasa_pengiriman_default" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Jasa Pengiriman</label>
                            <select name="jasa_pengiriman_code" id="jasa_pengiriman_code" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Input Resi Pengiriman</label>
                            <input type="text" class="form-control" required name="id" id="id" hidden>
                            <input type="text" class="form-control" required name="resi_pengiriman" id="resi_pengiriman">
                            <small>Pastikan input resi pengiriman yang benar</small>
                        </div>
                    </div>
                </div>
             </div>
             <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="approval_dikemas()" class="btn btn-warning">Simpan</button>
             </div>
          </form>
       </div>
    </div>
 </div>
@endsection

@section('js')
      <!-- JS Libraies -->
    <script src="{{asset('assets/modules/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/modules/chart.min.js')}}"></script>
    <script src="{{asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

    <!-- Page Specific JS File -->
    <script src="{{asset('assets/js/page/index.js')}}"></script>
@endsection

