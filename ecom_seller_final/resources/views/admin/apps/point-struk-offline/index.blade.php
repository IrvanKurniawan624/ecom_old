@extends('partial.app')
@section('title','Point Struk Offline')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Point Struk Offline</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Tanggal Pengajuan</th>
                          <th scope="col" class="text-center">Tipe Customer</th>
                          <th scope="col" class="text-center">Customer</th>
                          <th scope="col" class="text-center">Nominal Belanja</th>
                          <th scope="col" class="text-center">Point</th>
                          <th scope="col" class="text-center">Status</th>
                          <th scope="col" class="text-center" style="width: 25%">Actions</th>
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
            url: '/admin/apps/point-struk-offline/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5,6,7] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'created_at_desc' },
            { data: 'user.tipe_customer.customer' },
            { data: 'user.nama' },
            { data: 'nominal_belanja', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            { data: 'poin', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            { data: 'status_badge' },
            { data: 'status_desc' },
        ],
        rowCallback : function(row, data){

            $('td:eq(2)', row).html(`<span class="badge badge-primary">${data.user.tipe_customer.customer}</span>`);

            $('td:eq(7)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="detail('${data.id}')"><i class="fa fa-search"></i> Detail</button>
            `);
        }
    });

    function detail(id){
        window.location.href="/admin/apps/point-struk-offline/detail/" + id;
    }

</script>
@endsection
