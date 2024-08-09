@extends('partial.app')
@section('title','Report Produk Terbaik')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Report Produk Terbaik</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Master Kategori</th>
                            <th scope="col" class="text-center">Kata Kunci</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-center">Nama Produk</th>
                            <th scope="col" class="text-center">Total Terjual</th>
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
            url: '/admin/report/produk-terbaik/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,3,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_produk.master_kategori.kategori' },
            { data: 'master_produk.kata_kunci' },
            { data: 'produk_image' },
            { data: 'master_produk.nama_produk_desc' },
            { data: 'total_terjual' },
        ],
        rowCallback : function(row, data){
             $('td:eq(5)', row).html(`${data.total_terjual} ${data.master_produk.satuan}`);
        }
    });
</script>
@endsection
