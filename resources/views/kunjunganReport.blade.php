@php
    use Carbon\Carbon; //supaya bisa format date
@endphp
@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
        <div class="container" style="overflow:hidden; min-height: 650px; padding-top:80px; padding-bottom:50px; margin-left: 280px;">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="">Laporan Kunjungan</h4>
                </div>
            </div>
            <table id="myTable" class="table table-light table-striped" style="width:82%;">
                <thead>
                    <tr>
                        <th class="px-2 text-center" style="width:7%">ID</th>
                        <th class="px-2 text-center" style="width:10%">Tanggal Kunjungan</th>
                        <th class="px-2 text-center" style="width:10%">Jumlah Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungans as $idx=>$p) 
                        <tr>
                            <td class="text-center">{{ $p->id }}</td>
                            <td class="text-center">{{ Carbon::createFromFormat('Y-m-d', $p['tanggal'])->format('d-F-Y');  }}</td>
                            <td class="text-center">{{ $p->jumlah_kunjungan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

