@php
    use Carbon\Carbon;
    use App\Models\Unfinished;
    //pastikan tanggalnya hari ini, kalo lewat brati udh expired
    $datas = Unfinished::where('status','unpaid')->where('tanggal_transaksi',Carbon::today('Asia/Jakarta'))->get();
@endphp
@extends('layouts.main')
@section('content')
<h4 class="" style="margin-top: 90px; margin-left:20px">Waiting for payment</h4>
<div style="min-height:350px; flex-wrap:wrap;" class="d-flex py-2 px-4 mt-1 justify-content-center">
    @if (count($datas)>0)
        @foreach ($datas as $d)       
            <div style="width:250px; height:150px;border:1px solid black;" class="text-center mx-3 my-2 px-3 py-3">
                <h4>{{ json_decode($d->order)->id_invoice }}</h4>
                <p class="">Total : Rp. {{ formatUang(json_decode($d->order)->total) }}</p>
                <a class="btn btn-success" href="{{ route('resume.payment',['id'=>$d->id]) }}">Pay Now</a>
            </div>
        @endforeach
    @else
        <h3 style="color:red">Tidak ada transaksi yang belum diselesaikan</h3>        
    @endif
</div>
@endsection
