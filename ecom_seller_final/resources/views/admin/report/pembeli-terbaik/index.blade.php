@extends('partial.app')
@section('title','Report Pembeli Terbaik')

@section('css')
<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 90%;
            max-width:1200px;
        }
    }
</style>
@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Report Pembeli Terbaik</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Tanggal Daftar</th>
                            <th scope="col" class="text-center">Tipe Customer</th>
                            <th scope="col" class="text-center">Nama Customer</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Total Pembelian</th>
                            <th scope="col" class="text-center">#</th>
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

@section('modal')
<div class="modal fade" role="dialog" id="modal_history" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">History Pembelian Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_history" width="100%">
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
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            url: '/admin/report/pembeli-terbaik/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,5,6] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'tanggal_pendaftaran' },
            { data: 'user.tipe_customer.customer' },
            { data: 'user.nama' },
            { data: 'user.email' },
            { data: 'total_pembelian', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'total_pembelian', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
        ],
         rowCallback : function(row, data){
            $('td:eq(2)', row).html(`<span class="badge badge-primary">${data.user.tipe_customer.customer}</span>`);
            $('td:eq(6)', row).html(`<button class="btn btn-info" onclick="click_history(${data.user.id})">History</button>`);
         }
    });

    function click_history(id){
        $('#modal_history').modal('show');
        var tb_history = $('#tb_history').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            dom: "Bfrtip",
            buttons: [
                'copy', 'csv', 'excel', 'colvis'
            ],
            ajax: {
                url: '/admin/report/pembeli-terbaik/datatables-history',
                type: 'GET',
                data: {
                    'user_id': id,
                }
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
        });
    }
</script>
@endsection
