@php
    use Carbon\Carbon;
    $formattedDate = Carbon::createFromFormat('Y-m-d', $pembeli->tgl_lahir)->format('d-F-Y');
    $dob = Carbon::parse($pembeli->tgl_lahir); //calculate age
    $age = $dob->age;
@endphp
@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
        <div class="container" style="min-height: 550px; padding-top:80px; padding-left: 20%;">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="">Informasi Pembeli</h4>
                </div>
                <h4 class="text-center">Detail Data</h4>
            </div>
            <div class="Content">
                <div style="font-size: 16px" class="border-bottom border-top row d-flex justify-content-between py-2">
                    <div class="col-4 fw-bold">Nama Pembeli</div>
                    <div class="d-flex justify-content-end col-4">{{ $pembeli->name }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Jenis Kelamin</div>
                    <div class="col-4 d-flex justify-content-end">{{ $pembeli->jk == "L" ? "Laki-laki" : "Perempuan" }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Tanggal Lahir</div>
                    <div class="col-4 d-flex justify-content-end">{{ $formattedDate }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Umur</div>
                    <div class="col-4 d-flex justify-content-end">{{ $age }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Email</div>
                    <div class="col-4 d-flex justify-content-end">{{ $pembeli->email }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Kode Refferal</div>
                    <div class="col-4 d-flex justify-content-end">{{ $pembeli->refferal }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Nomor Telepon</div>
                    <div class="col-4 d-flex justify-content-end">{{ $pembeli->no_telp }}</div>
                </div>
            </div>
        </div>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

