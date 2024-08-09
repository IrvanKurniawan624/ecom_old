@extends('partial.app')
@section('title','Report Pembelian Produk')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Report Pembelian Produk</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Tanggal Transaksi</th>
                            <th scope="col" class="text-center">No Invoice</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-center">Nama Produk</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Harga</th>
                            <th scope="col" class="text-center">Total Harga</th>
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
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: false,
        dom: "Bfrtip",
         buttons: [
            'copy', 'csv', 'excel', 'colvis'
        ],
        ajax: {
            url: '/admin/report/history-pembelian/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,5,6,7] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'transaksi.created_at_desc' },
            { data: 'transaksi.no_invoice' },
            { data: 'produk_image' },
            { data: 'master_produk.nama_produk_desc' },
            { data: 'quantity' },
            { data: 'harga',  render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'total_harga',  render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
        ],
        rowCallback : function(row, data){
            $('td:eq(2)', row).html(`<a href="/admin/apps/transaksi/${data.transaksi.uuid}" target="_blank">${data.transaksi.no_invoice}</a>`);
        }
    });
</script>
@endsection
