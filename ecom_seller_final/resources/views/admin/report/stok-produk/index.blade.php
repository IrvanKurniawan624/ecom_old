@extends('partial.app')
@section('title','Report Stok Produk')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Report Stok Produk</h4>
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
                            <th scope="col" class="text-center">Stock Available</th>
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
            url: '/admin/report/stok-produk/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_kategori.kategori' },
            { data: 'kata_kunci' },
            { data: 'produk_image' },
            { data: 'nama_produk_desc' },
            { data: 'stock' },
        ],
    });
</script>
@endsection
