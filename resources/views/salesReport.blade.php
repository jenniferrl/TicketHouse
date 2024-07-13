@extends('layouts.sellerMain')
@section('content')
    <div class="container" style="min-height: 650px; padding-bottom:50px;padding-top:100px; margin-left: 250px;">
        @if(session('message')) 
            <div style="width: 900px" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif 
        <h2 class="fw-bold " style="">Laporan Penjualan</h2>
        @include('salesReportTable')
    </div>
@endsection