@php
    use Carbon\Carbon;
    $formattedDate = Carbon::createFromFormat('Y-m-d', $penjual->tgl_lahir)->format('d-F-Y');
    $dob = Carbon::parse($penjual->tgl_lahir); //calculate age
    $age = $dob->age;
@endphp
@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
        <div class="container" style="min-height: 550px; padding-top:80px; padding-left:20%">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="">Informasi Penjual</h4>
                </div>
                <h4 class="text-center">Detail Data</h4>
            </div>
            <div class="Content">
                <div style="font-size: 16px" class="border-bottom border-top row d-flex justify-content-between py-2">
                    <div class="col-4 fw-bold">Nama Penjual</div>
                    <div class="d-flex justify-content-end col-4">{{ $penjual->name }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Jenis Kelamin</div>
                    <div class="col-4 d-flex justify-content-end">{{ $penjual->jk == "L" ? "Laki-laki" : "Perempuan" }}</div>
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
                    <div class="col-4 d-flex justify-content-end">{{ $penjual->email }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Nomor Telepon</div>
                    <div class="col-4 d-flex justify-content-end">{{ $penjual->no_telp }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Status Membership</div>
                    <div class="col-4 d-flex justify-content-end">{{ $penjual->premium_status == 0 ? 'Basic' : 'Premium' }}</div>
                </div>
            </div>
        </div>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

