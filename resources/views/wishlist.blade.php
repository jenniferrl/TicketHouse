@extends('layouts.main')
@section('content')
    <div class="container" style="height: 850px; padding-top:100px;">
        <h1 style="text-align: center;">My Wishlist</h1>
        <table class="mt-3">
            <tr class="" style="text-align:center;border-bottom:1px solid black">
                <th style="padding: 15px 25px; "></th>
                <th  style=" padding: 10px 35px; ">Product Name</th>
                <th style=" padding:10px 70px; " >Price</th>
                <th style="padding:10px 60px">Quantity</th>
                <th style=" padding:10px 60px;">Stock</th>
                <th style=" padding:10px 80px; ">Action</th>
            </tr>
            @foreach ($tempTickets as $ticket)
                @if ($ticket->status == 1)               
                    <tr class="" style="border-bottom:1px solid black; text-align:center;">
                        <td style="padding: 20px"><a href="/ticket/{{ $ticket->id_tiket }}"><img style="width: 100px; object-fit:cover;" src="/images/{{ json_decode($ticket->gambar)[0] }}" alt=""></a> </td>
                        <td  style="padding: 10px; ">{{ $ticket->nama }}</td>
                        <td style=" padding:10px 70px; ">Rp. {{ formatUang($ticket->harga) }}</td>
                        <td style="padding:10px 60px">1</td>
                        <td style=" padding:10px 60px;">{{ $ticket->quantity }}</td>
                        <td style=" padding:10px 60px; ">
                            <div class="">
                                {{-- need to use form so we can send a PUT request --}}
                                {{-- collect() being used here to get first array element that matched given condition  --}}
                                <form action="{{ route('remove.wishlist',['id'=>collect($wishlistItems)->where('id_tiket',$ticket->id_tiket)->where('status',1)->first()->id_wishlist  ]) }}" method="post">
                                    @csrf 
                                    @method('put')
                                    <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-trash fa-sm"></i></button>
                                </form>
         
                            </div>
                            
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
        {{-- only display Remove All button when wishlist is not empty --}}
        @if (count($tempTickets)>0)             
            <div class="d-flex flex-row-reverse " style="padding-right: 35px">
                <form action="/wishlist" method="post">
                    @csrf
                    @method("put");
                    <button type="submit" class="btn btn-danger mt-5 " style="text-align: right">Remove All</button>
                </form>
            </div>
        @endif
    </div>

@endsection