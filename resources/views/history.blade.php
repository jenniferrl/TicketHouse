@extends('layouts.main')
@section('content')
    <div class="container" style="min-height: 550px; padding-bottom:100px; padding-top:100px;">
        <h1 class="mb-4" style="text-align: center;">My Transaction History</h1>
        @if (count($purchases)==0)
            <h2 style="text-align: center; color:red;">Belum ada transaksi</h2>
        @else            
            <table id="myTable3" class="mt-4">
                <thead>
                    <tr class="" style="text-align:center;border-bottom:1px solid black">
                        <th class="text-center" style="width:10%; padding:10px 0px;">Date</th>
                        <th class="text-center" style="width:20%; padding:10px 0px; ">Product</th>
                        <th class="text-center" style="width:20%;padding:10px 0px; " >Total</th>
                        <th class="text-center px-5" style="width:10%; padding:10px 0px;">Status</th>
                        <th class="text-center" style="width:13%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $p)
                        @foreach ($tickets as $t)
                            @if ($t->id_tiket == $p->id_tiket)
                            <tr style="border-bottom:1px solid black; ">
                                    <td style="" class="text-center">{{ $p->tanggal_pembelian }} </td>
                                    <td style="" class="text-center ">{{ $t->nama }}</td>
                                    <td style="" class="text-center">Rp. {{ formatUang($p->total) }} </td>
                                    <td class="text-center" style="color:{{ $p->status == 'berhasil' ? 'green' : 'red' }}; ">{{ $p->status }} </td>
                                    <td class="text-center" style="" ><a href="{{ route('invoice',['id'=>$p->id_invoice]) }}" class="btn btn-primary">Lihat Invoice</a> </td>
                                </tr>                        
                                @break
                            @endif  
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection