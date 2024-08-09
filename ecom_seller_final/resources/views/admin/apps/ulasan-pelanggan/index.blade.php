@extends('partial.app')
@section('title','Ulasan Pelanggan')

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
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Ulasan Pelanggan</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Produk</th>
                           <th scope="col" class="text-center">Bintang</th>
                           <th scope="col" class="text-center">Ulasan</th>
                           <th scope="col" class="text-center">Status</th>
                           <th scope="col" class="text-center" style="width: 16%">Actions</th>
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
        ajax: {
            url: '/admin/apps/ulasan-pelanggan/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'master_produk.nama_produk_desc' },
            { data: 'bintang' },
            { data: 'komentar' },
            { data: 'status_desc' },
            { data: 'DT_RowIndex' },
        ],
        rowCallback : function(row, data){
            let color = ['warning', 'success', 'danger'];
            $('td:eq(4)', row).html(`<span class="badge badge-${color[data.status]}">${data.status_desc}</span>`);

            let bintang = '<div class="star">';
            for(let i = 1; i <= 5; i++){
                if(i <= parseInt(data.bintang)){
                    bintang += `<span class="fa fa-star checked"></span>`;
                }else{
                    bintang += `<span class="fa fa-star"></span>`;
                }
            }
            bintang += '</div>';

            $('td:eq(2)', row).html(bintang);

            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="detail('${data.id}')"><i class="fa fa-search"></i> Detail</button>
            `);
        }
    });

    function detail(id){
        window.location.href="/admin/apps/ulasan-pelanggan/detail/" + id;
    }
</script>
@endsection
