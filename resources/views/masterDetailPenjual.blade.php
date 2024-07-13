@php
    use Carbon\Carbon;
@endphp
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h4 class="" style="">Master Penjual</h4>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Detail Data</h4>
        
        <div style="font-size: 16px" class="mb-5">
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nama</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$penjual->name}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$penjual->id_penjual}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Kontak</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$penjual->no_telp}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Username</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$penjual->username}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Email</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$penjual->email}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Jenis Kelamin</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{($penjual->jk == "L" ? "Laki-Laki" : "Perempuan")}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Tanggal Lahir</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{Carbon::createFromFormat('Y-m-d', $penjual->tgl_lahir)->format('d-F-Y') }}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Saldo</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{formatUang($penjual->saldo)}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Premium Status</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{($penjual->premium_status == 1 ? "Premium" : "Basic")}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Status</div>
                <div class="col-4 row d-flex justify-content-end me-2 {{($penjual->status == 0) ? 'text-danger' : ''}}">{{($penjual->status == 1) ? "Aktif" : "Banned" }}</div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-md-3">
                <a href="/admin/master/penjual/{{$penjual->id_penjual}}/edit" style="text-decoration: none;">
                    <button class="btn w-75 text-dark" style="background-color: #FDE1A9">Edit</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/admin/master/penjual/{{$penjual->id_penjual}}/change">
                    <button class="btn btn-danger w-75">{{(($penjual->status == 1) ? "Ban Penjual" : "Unban Penjual")}}</button>
                </a>
            </div>
        </div>
        
        
    </div>
    
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

