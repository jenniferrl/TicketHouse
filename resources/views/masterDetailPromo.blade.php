
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h4 class="" style="">Master Promo</h4>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Detail Data</h4>
        
        <div style="font-size: 16px" class="mb-5">
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID Promo</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$promo->id_kodepromo}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Kode Promo</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$promo->kode_promo}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nama Penjual</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$promo->penjual->name}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nilai Promo</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$promo->nilai_promo}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Tipe Promo</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$promo->tipe}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Minimal Pembelian</div>
                <div class="col-4 row d-flex justify-content-end me-2">Rp {{formatUang($promo->min_purchase)}}</div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-md-3">
                <a href="/admin/master/promo/{{$promo->id_kodepromo}}/edit" style="text-decoration: none;">
                    <button class="btn w-75 text-dark" style="background-color: #FDE1A9">Edit</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/admin/master/promo/{{$promo->id_kodepromo}}/delete">
                    <button class="btn btn-danger w-75">{{(($promo->status == 1) ? "Delete Promo" : "Unban Promo")}}</button>
                </a>
            </div>
        </div>
        
        
    </div>
    
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

