@extends('layouts.sellerMain')
@section('content')
    <div class="container" style="min-height: 650px; padding-bottom:50px;padding-top:150px; margin-left: 250px;">
        @if(session('message')) 
            <div style="width: 900px" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif 
        <h2 class="fw-bold" style="">Semua Tiket</h2>
        <table style=" font-size:17px; margin-top:15px;">
            <tr>
                <th style=" width:350px;" class="">Info Produk</th>
                <th style=" width:230px;">Harga</th>
                <th style=" width:200px;">Stok</th>
                <th style=" width:150px; text-align:center">Aksi</th>
            </tr>
            @foreach ($allTickets as $ticket)
            @if ($ticket->status == 1)
                <tr class="">
                    <td style=" " class="pt-3">
                        <div class="d-flex">
                            <img src="/images/{{ json_decode($ticket->gambar)[0] }}" style="width: 150px;object-fit:cover; margin-right:15px; margin-bottom:15px" alt="">
                            <p style="padding-top: 31px" class="">{{ $ticket->nama }}</p>
                        </div>
                    
                    </td>
                    <td style=" ">Rp. {{ formatUang($ticket->harga) }}</td>
                    <td style=" padding-left:15px;">{{ $ticket->quantity }}</th>
                    <td style=" text-align:center">
                        <form action="{{ route('delete.ticket',['id'=> $ticket->id_tiket ]) }}" method="post">
                            @csrf 
                            @method('put')
                            <button type="submit" class="btn btn-danger mt-1">Hapus Tiket</button>
                        </form>
                        <a href="/edit/{{$ticket->id_tiket}}"><button class="btn btn-primary my-2">Edit Tiket</button></a>
                    </td>
                </tr>                    
                @endif
            @endforeach
        </table>
    </div>
@endsection