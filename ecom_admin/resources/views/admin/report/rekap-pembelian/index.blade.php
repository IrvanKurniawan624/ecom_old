@extends('partial.app')
@section('title','Report Rekap Pembelian')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h4>Filter</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                              <label>Tipe Tanggal</label>
                              <select class="form-control selectric" id="tipe_tanggal" name="tipe_tanggal" onchange="pilih_tipe_tanggal();">
                                 <option value="harian">Harian</option>
                                 <option value="range">Range Tanggal</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-6">
                        <div class="form-group">
                           <label id="date_start_text">Tanggal</label>
                           <input type="text" class="form-control datepicker required-field" name="tanggal_mulai" id="tanggal_mulai" onchange="get_date_start();">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-6 card-range" hidden>
                        <div class="form-group">
                           <label>Tanggal Akhir</label>
                           <input type="text" class="form-control datepicker" name="tanggal_selesai" id="tanggal_selesai">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-success" onclick="click_filter_data()">Filter Data</button>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           <div class="card-header">
              <h4>Data Report Rekap Pembelian</h4>
           </div>
           <div class="card-body">
              <div class="table-responsive">
               <table class="table table-striped" id="tb" width="100%">
                   <thead>
                      <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Image</th>
                           <th scope="col" class="text-center">Kategori</th>
                           <th scope="col" class="text-center">Nama Produk</th>
                           <th scope="col" class="text-center">Kata Kunci</th>
                           <th scope="col" class="text-center">Total Penjualan</th>
                      </tr>
                   </thead>
                </table>
              </div>
           </div>
        </div>
     </div>
   </div>
</div>
@endsection

@section('js')
<script>

    $(document).ready(function(){
        click_filter_data();
        //set date now
        var d           = new Date();
        var date        = ("0" + d.getDate()).slice(-2);
        var m           = ("0" + (d.getMonth() + 1)).slice(-2);
        var y           = d.getFullYear();
        var date_now    = y + "-" + m + "-" + date;
        $('#tanggal_mulai').datepicker('setDate', date_now);
    });

    function pilih_tipe_tanggal(){
        if($("#tipe_tanggal").val() === "harian"){
            $(".card-range").attr("hidden", true);
            $("#tanggal_selesai").removeClass("required-field");
            $("#date_start_text").text("Tanggal");
            get_date_start();
        }else{
            $(".card-range").attr("hidden", false);
            $("#tanggal_selesai").addClass("required-field");
            $("#tanggal_selesai").val("");
            $("#date_start_text").text("Tanggal Mulai");
        }
    }

   function get_date_start(){
      if($("#tipe_tanggal").val() === "harian"){
         var tgl_mulai = $("#tanggal_mulai").val();
         $("#tanggal_selesai").val(tgl_mulai);
      }
   }

    function click_filter_data(){
        var tb = $('#tb').DataTable({
        processing: true,
        serverSide: false,
        "bDestroy": true,
        dom: "Bfrtip",
        buttons: [
            'copy', 'csv', 'excel', 'colvis'
        ],
        ajax: {
            url: '/admin/report/rekap-pembelian/datatables',
            type: 'GET',
            data: {
                'tanggal_mulai': $('#tanggal_mulai').val(),
                'tanggal_selesai': $('#tanggal_selesai').val(),
            },
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'produk_image' },
            { data: 'master_produk.master_kategori.kategori' },
            { data: 'master_produk.nama_produk_desc' },
            { data: 'master_produk.kata_kunci' },
            { data: 'total_quantity' },
        ],
    });
    }
</script>
@endsection
