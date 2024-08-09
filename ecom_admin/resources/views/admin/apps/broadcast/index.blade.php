@extends('partial.app')
@section('title','Broadcast')

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
                 <h4>Data Broadcast</h4>
              </div>
              <div class="card-body">
                <form id="form_submit" action="/admin/apps/broadcast/create" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Tipe Broadcast</label>
                                <select class="form-control selectric required-field" id="tipe_broadcast" name="tipe_broadcast">
                                    <option value="ALL">All</option>
                                    <option value="B2B">B2B</option>
                                    <option value="B2C">B2C</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-8 col-md-8 col-lg-8">
                            <div class="form-group">
                                <label>Judul Broadcast</label>
                                <input type="text" class="form-control required-field" name="judul" id="judul">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Pengumuman</label>
                                <textarea class="form-control required-field" name="pengumuman" id="pengumuman" style="height: 80px;"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 text-right">
                            <button type="submit" class="btn btn-success" style="margin-bottom: 1rem"> <i class="fas fa-bullhorn"></i> Broadcast Pesan </button>
                        </div>
                    </div>
                </form>
              </div>
           </div>
        </div>
     </div>
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Broadcast</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">tipe</th>
                           <th scope="col" class="text-center">judul</th>
                           <th scope="col" class="text-center">pengumuman</th>
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
            url: '/admin/apps/broadcast/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'tipe_broadcast' },
            { data: 'judul' },
            { data: 'pengumuman' },
        ],
    });
</script>
@endsection
