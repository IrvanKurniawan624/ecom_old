@extends('partial.app')
@section('title','Log')

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Log Produk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">#</th>
                           <th scope="col" class="text-center">Jenis Log</th>
                           <th scope="col" class="text-center">Produk</th>
                           <th scope="col" class="text-center">Penambahan Stock</th>
                           <th scope="col" class="text-center">Harga</th>
                           <th scope="col" class="text-center">Keterangan</th>
                           <th scope="col" class="text-center">Tanggal</th>
                           <th scope="col" class="text-center">Updated By</th>
                        </tr>
                     </thead>
                  </table>
                </div>
            </div>
         </div>
      </div>

      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           <div class="card-header">
              <h4>Data Log Poin</h4>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-striped" id="tb_poin" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">User</th>
                            <th scope="col" class="text-center" width="50%">History</th>
                            <th scope="col" class="text-center">Nominal</th>
                            <th scope="col" class="text-center">Log Poin</th>
                            <th scope="col" class="text-center">Tanggal</th>
                            <th scope="col" class="text-center">Updated By</th>
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
        serverSide: true,
        dom: "Bfrtip",
        buttons: [
            'copy', 'csv', 'excel', 'colvis'
        ],
        ajax: {
            url: '/admin/apps/log/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,6,7] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'jenis_log' },
            { data: 'master_produk.nama_produk' },
            { data: 'quantity' },
            { data: 'harga', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            { data: 'keterangan' },
            { data: 'created_at' },
            { data: 'master_seller.nama' },
        ],
        rowCallback : function(row, data){
            if(data.jenis_log == 'stock'){
                $('td:eq(1)', row).html(`<span class="badge badge-danger">${data.jenis_log}</span>`);
            }else{
                $('td:eq(1)', row).html(`<span class="badge badge-primary">${data.jenis_log}</span>`);
            }
        }
    });

    var tb_poin = $('#tb_poin').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        dom: "Bfrtip",
        buttons: [
            'copy', 'csv', 'excel', 'colvis'
        ],
        ajax: {
            url: '/admin/apps/log/datatables-poin',
            type: 'GET',
        },
        columnDefs: [
            { className: 'text-center', targets: [0,3,4,5,6] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'user.nama' },
            { data: 'history_poin' },
            { data: 'nominal', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            { data: 'sisa_poin', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            { data: 'created_at_desc' },
            { data: 'created_by' },
        ],
    });
</script>
@endsection
