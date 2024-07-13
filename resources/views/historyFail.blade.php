@php
    use Carbon\Carbon;
@endphp
@extends('layouts.main')
@section('content')
    <div class="container" style="min-height: 550px; padding-bottom:100px; padding-top:100px;">
        <h1 class="mb-4" style="text-align: center;">My Transaction History</h1>
        <div class="row d-flex justify-content-between">
            <div class="col-md-3">
                <a href="/unfinished" class="btn btn-secondary mb-2">Pending transactions</a>
            </div>
            <div class="col-md-5">
                <form class="d-flex" method="GET" action="/history/fail/search">
                    <input class="form-control me-1" size="25" name="keyword" type="search" placeholder="Cari nama tiket" value="{{ request()->input('keyword') }}" aria-label="Search">
                    <input class="form-control me-1" type="date" name="date" id="date" value="{{ request()->input('date') }}">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link text-success" aria-current="page" href="/history/success">Transaksi Berhasil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/history/fail">Transaksi Gagal</a>
            </li>
        </ul>

        @if (count($purchases)==0)
            <h2 style="text-align: center; color:red;">Belum ada transaksi</h2>
        @else            
            @foreach($purchases->groupBy(function($purchase) {
                return $purchase->tanggal_pembelian;
            }) as $date => $groupedTransactions)
                <div class="row d-flex justify-content-center mt-3 mb-1">
                    <div class="col-md-3 text-center fs-5 rounded-4 border" style="background-color: lightgreen;" id="dateGroup">
                        {{ Carbon::createFromFormat('Y-m-d', $date)->format('d F Y') }}
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    
                    @foreach($groupedTransactions as $transaction)
                    <div class="col-11 rounded-3 border mb-2">
                        <div class="row py-3">
                            <div class="col-md-2 d-flex align-items-center">
                                <img style="width: 100px; object-fit:cover;" src="../../images/{{json_decode($transaction->gambar_tiket)[0]}}" alt="">
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">{{ $transaction->nama_tiket }}</div>
                                <div>Rp {{ formatUang($transaction->total) }}</div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-1">{{Carbon::createFromFormat('Y-m-d', $transaction->tanggal_pembelian)->format('d F Y')}}</div>
                                <div style="color: {{ ($transaction->status == 'berhasil' ? 'Green' : 'Red') }}">{{ ($transaction->status == "berhasil" ? "Berhasil" : "Gagal") }}</div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('invoice',['id'=>$transaction->id_invoice]) }}" class="btn btn-primary">Lihat Invoice</a> 
                            </div>
                        </div>
                        
                         
                        
                        
                    </div>
                    @endforeach
                    
                </div>
                
            @endforeach
            <div class="col mt-3">
                {{ $purchases->links() }}    
            </div>
            


        @endif

    </div>

@endsection