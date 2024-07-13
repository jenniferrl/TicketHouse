@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
        <div class="container" style="overflow:hidden; min-height: 650px; padding-top:80px; padding-bottom:50px; margin-left: 280px;">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="">Laporan Tiket</h4>
                </div>
            </div>
            <table id="myTable" class="table table-light table-striped" style="width:82%;">
                <thead>
                    <tr>
                        <th class="px-2 text-center" style="width:5%">No</th>
                        <th class="px-2 " style="width:7%">ID Tiket</th>
                        <th class="px-2 " style="width:15%">Nama Tiket</th>
                        <th class="px-2 " style="width:15%">Harga</th>
                        <th class="px-2 " style="width:15%">Alamat</th>
                        <th class="px-2 " style="width:5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $idx=>$p) 
                        <tr>
                            <td class="text-center">{{ $idx+1 }}</td>
                            <td class="">{{ $p->id_tiket }}</td>
                            <td class="">{{ $p->nama }}</td>
                            <td class="">Rp. {{ formatUang($p->harga) }}</td>
                            <td class="">{{ $p->alamat_lokasi }}, {{ $p->kota }}</td>
                            <td class=""><a href="{{ route('ticketreport.detail',['id'=>$p->id_tiket]) }}" class="btn btn-outline-success">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Total</th>
                        <th></th>
                        <th></th>
                        <th class="" id="nilaiTotal">Rp. 0</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

