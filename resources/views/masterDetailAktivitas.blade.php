
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h4 class="" style="">Master Aktivitas</h4>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Detail Data</h4>
        
        <div style="font-size: 16px" class="mb-5">
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID Laporan</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->id_aktivitas}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID Terlapor</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->id_penjual}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nama Terlapor</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->penjual->name}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID Pelapor</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->id_pembeli}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nama Pelapor</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->pembeli->name}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Deskripsi Masalah</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$aktivitas->keterangan}}</div>
            </div>

        </div>
        
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-md-3">
                <a href="/admin/master/aktivitas/{{$aktivitas->id_aktivitas}}/edit" style="text-decoration: none;">
                    <button class="btn w-75 text-dark" style="background-color: #FDE1A9">Edit</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/admin/master/aktivitas/{{$aktivitas->id_aktivitas}}/delete">
                    <button class="btn btn-danger w-75">Delete</button>
                </a>
            </div>
        </div>
        
        
    </div>
    
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

