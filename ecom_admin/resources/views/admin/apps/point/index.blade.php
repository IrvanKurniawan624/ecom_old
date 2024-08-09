@extends('partial.app')
@section('title','Point')

@section('css')

@endsection

@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Point</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped" id="tb" width="100%">
                    <thead>
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Nama</th>
                          <th scope="col" class="text-center">Tipe Pelanggan</th>
                          <th scope="col" class="text-center">Email</th>
                          <th scope="col" class="text-center">Point</th>
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


@section('modal')
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title"></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="form_submit" action="/admin/apps/point/add-poin" method="POST" autocomplete="off">
            <input type="text" name="id" id="id" hidden>
             <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-7 col-lg-7">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="text" class="form-control" name="poin" id="poin" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Tambahan Poin</label>
                            <input type="text" class="form-control" min="0" name="tambah_poin" id="tambah_poin" onkeypress="return onkeyupRupiah(this.id)">
                        </div>
                     </div>
                </div>
             </div>
             <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
             </div>
          </form>
       </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_history" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Log Poin Customer</h5>
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
                                  <th scope="col" class="text-center">Tanggal</th>
                                  <th scope="col" class="text-center">Nominal</th>
                                  <th scope="col" class="text-center" width="50%">History</th>
                                  <th scope="col" class="text-center">Log Poin</th>
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
        serverSide: true,
        ajax: {
            url: '/admin/apps/point/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'nama' },
            { data: 'tipe_customer.customer' },
            { data: 'email' },
            { data: 'poin', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            { data: 'poin' },
        ],
        rowCallback : function(row, data){

            $('td:eq(2)', row).html(`<span class="badge badge-primary">${data.tipe_customer.customer}</span>`);

            $('td:eq(5)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="click_tambah_poin('${data.id}','${data.poin}','${data.nama}')"><i class="fas fa-coins"></i> Tambah Poin</button>
                <button class="btn btn-warning btn-sm mr-1" onclick="click_history(${data.id})"><i class="fas fa-history"></i> History Poin</button>
            `);
        }
    });

    function click_history(id){
        $('#modal_history').modal('show');
        var tb_history = $('#tb_history').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/admin/apps/point/datatables-history',
                type: 'GET',
                data: {
                    'user_id': id,
                }
            },
            columnDefs: [
                { className: 'text-center', targets: [0,1,2,4] },
            ],
            order: [[0, 'asc']],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'created_at_desc' },
                { data: 'nominal', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
                { data: 'history_poin' },
                { data: 'sisa_poin', render: $.fn.dataTable.render.number( ',', '.', 0, '' ) },
            ],
        });
    }

    function click_tambah_poin(id, poin, nama){
        $('#modal').modal('show');
        $('.modal-title').html('Tambah Poin');
        $('#id').val(id);
        $('#poin').val(fungsiRupiah(poin));
        $('#nama').val(nama);
    }

    function reset_password(url){
            $("#modal_loading").modal('show');
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'JSON',
                success: function( response, textStatus, jQxhr ){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.status === 200){
                        swal(response.message, {  icon: 'success', });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                    }else{
                        swal(response.message, {  icon: 'error', });
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                console.warn(jqXhr.responseText);
                },
            });
    }

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master User');
        $('#place_append').html('');
        $("#form_submit")[0].reset();
    }

    function edit(url){
        edit_action(url, 'Edit Master User');
        $("#type").val('update');
    }
</script>
@endsection
