@extends('partial.app')
@section('title','Setting Image')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Setting Image</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <form id="form_submit" action="/admin/produk/produk/setting-image/store" method="POST" autocomplete="off">
                            <table class="table table-striped" id="tb" width="100%">
                                <input type="text" name="id" value="{{ $data->id }}" hidden>
                                <thead>
                                   <tr>
                                        <th scope="col" class="text-center">Image</th>
                                        <th scope="col" class="text-center">Urutan Awal</th>
                                        <th scope="col" class="text-center">Urutan</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->url_image as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                <img class="mr-3 p-3 rounded" width="200" src="/berkas/master-produk/{{ $item }}" alt="product">
                                                @if($loop->first)
                                                    <span class="badge badge-danger">Foto Utama</span>
                                                @endif
                                            </td>
                                            <td class="text-center"> <b>{{ $key + 1 }}</b></td>
                                            <td class="text-center">
                                                <input type="number" name="urutan_image[]" min="0" class="form-control">
                                                <input type="text" hidden name="image[]" value="{{ $item }}" class="form-control">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                             </table>
                             <button class="btn btn-success btn-block">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('js')

@endsection
