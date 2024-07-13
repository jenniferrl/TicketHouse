@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center" style="width : 100%; min-height: 450px; padding-top:100px; padding-bottom:50px;">
        <div class="text-center pt-4" style="border:1px solid black; padding:15px 20px;width:40% ;min-height:300px">
            <h2>Invoice</h2>
            <p>ID Invoice : {{ $invoice->id_invoice }}</p>
            <p>Pembeli : {{ $pembeli->name }}</p>
            <p>Status : <span style="color : {{ $invoice->status == 'berhasil' ? 'green' : 'red' }}">{{ $invoice->status }}</span></p>
            <p>Nama Tiket : {{ $ticket->nama }}</p>
            <p>Quantity : {{ $invoice->quantity }}</p>
            <p>Total Pembayaran : Rp. {{ formatUang($invoice->total) }}</p>
        </div>
    </div>
@endsection