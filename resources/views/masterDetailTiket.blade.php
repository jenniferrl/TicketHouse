
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h4 class="" style="">Master Tiket</h4>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Detail Data</h4>
        
        <div style="font-size: 16px" class="mb-5">
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Nama Tiket</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->nama}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">ID Tiket</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->id_tiket}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Penjual</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->penjual->name}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Harga</div>
                <div class="col-4 row d-flex justify-content-end me-2">Rp {{formatUang($tiket->harga)}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Stok</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->quantity}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Alamat</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->alamat_lokasi}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Kota</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->kota}}</div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Deskripsi</div>
                <div class="col-4 row d-flex justify-content-end me-2"><p>{{$tiket->deskripsi}}</p></div>
            </div>
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Kategori</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->kategori}}</div>
            </div>

            @if($tiket->start_date != "")
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Tanggal</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->start_date}}</div>
            </div>
            @endif

            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Waktu Mulai</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->start_time}}</div>
            </div>
            
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Waktu Selesai</div>
                <div class="col-4 row d-flex justify-content-end me-2">{{$tiket->end_time}}</div>
            </div>

          
            <div class="row d-flex justify-content-between border-bottom border-top py-2">
                <div class="col-4 fw-bold">Status</div>
                <div class="col-4 row d-flex justify-content-end me-2 {{($tiket->status == 0) ? 'text-danger' : ''}}">{{($tiket->status == 1) ? "Aktif" : "Banned" }}</div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-md-3">
                <a href="/admin/master/tiket/{{$tiket->id_tiket}}/edit" style="text-decoration: none;">
                    <button class="btn w-75 text-dark" style="background-color: #FDE1A9">Edit</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/admin/master/tiket/{{$tiket->id_tiket}}/delete">
                    <button class="btn btn-danger w-75">{{(($tiket->status == 1) ? "Ban Tiket" : "Unban Tiket")}}</button>
                </a>
            </div>
        </div>
        
        
    </div>
    
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

