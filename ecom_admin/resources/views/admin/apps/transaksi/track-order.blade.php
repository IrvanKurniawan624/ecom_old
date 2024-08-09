@extends('partial.app')
@section('title','Track Order')
@section('content')

<div class="section-body">
   <h2 class="section-title">{{ $transaksi->no_invoice }}</h2>
   <div class="row">
      <div class="col-12 col-md-4 col-lg-4">
         <div class="card">
            <div class="card-header">
               <h4>Informasi Karyawan</h4>
            </div>
            <div class="card-body">
               <div class="form-group">
                  <label>Status</label>
                  <input type="text" value="{{ $data['summary']['status'] }}" class="form-control" disabled>
               </div>
               <div class="form-group">
                <label>Tanggal</label>
                <input type="text" value="<span>{{ $data['summary']['waybill_date'] }}" class="form-control" disabled>
             </div>
             <div class="form-group">
                <label>Pengiriman</label>
                <input type="text" value="{{ $data['summary']['courier_name'] }}" class="form-control" disabled>
             </div>
             <div class="form-group">
                <label>No Resi</label>
                <input type="text" value="{{ $data['summary']['waybill_number'] }}" class="form-control" disabled>
             </div>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-8 col-lg-8">
         <div class="activities">
            @php
                $count = count($data['manifest']);
            @endphp
            @foreach ($data['manifest'] as $key => $item)
                <div class="activity">
                <div class="activity-icon bg-primary text-white shadow-primary">
                    <b>{{ $count }}</b>
                </div>
                <div class="activity-detail">
                    <div class="mb-2">
                        <span class="text-job text-primary">{{ $item['manifest_date'] }} {{ $item['manifest_time'] }}</span>
                    </div>
                    <div class="row d-flex">
                        <div class="d-flex align-items-start mr-4">
                            <div class="ml-3">
                            <p><b>{{ $item['city_name'] }}</b></p>
                            <p>{{ $item['manifest_description'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @php
                    $count--;
                @endphp
            @endforeach
         </div>
      </div>
   </div>
</div>
@endsection
