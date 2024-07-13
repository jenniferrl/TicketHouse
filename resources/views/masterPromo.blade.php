<!-- belum selesai -->
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 18%;">
        @if(session('message')) 
            <div style="width: 900px" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- bagian atas -->
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <h3 class="" style="">Master Promo</h3>
            </div>
            <div class="col-md-3 d-flex justify-content-end align-items-center">
                <a href="/admin/master/promo/add">
                    <button class="border-0 rounded-3 p-2" style="background-color: #FDE1A9; height: 70%;">Tambah Promo</button>
                </a>    
            </div>
        </div>

        <!-- table -->
        <table id="myTable2" class="table table-striped mt-4" style="width: 100%">
            <thead>
                <!-- <tr> -->
                    <th class="px-2 text-center" style="width: 8%">No</th>
                    <th class="px-2" style="width: 5%">ID</th>
                    <th class="px-2" style="width: 13%;">Penjual</th>
                    <th class="px-2" style="width: 13%;">Kode</th>
                    <th class="px-2" style="width: 13%;">Nilai</th>
                    <th class="px-2" style="width: 8%;">Tipe</th>
                    <th class="px-2" style="width: 17%;">Min. Pembelian</th>
                    <th class="px-2" style="width: 8%;">Status</th>
                    <th class="px-2" style="width: 15%;">Action</th>
                <!-- </tr> -->
            </thead>
            <tbody>
                @foreach($daftarPromo as $index => $promo)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$promo->id_kodepromo}}</td>
                        <td>{{$promo->penjual->name}}</td>
                        <td>{{$promo->kode_promo}}</td>
                        <td>{{ ($promo->tipe == 'Persen') ? $promo->nilai_promo . "%" : "Rp." . formatUang($promo->nilai_promo) }}</td>
                        <td>{{$promo->tipe}}</td>
                        <td>Rp {{formatUang($promo->min_purchase)}}</td>
                        <td>{{$promo->status == "1" ? "Aktif" : "Tidak Aktif"}}</td>

                        <td class="">
                            <a href="/admin/master/promo/{{$promo->id_kodepromo}}/detail" style="text-decoration: none;">
                                <button class="btn btn-info d-flex align-items-center" style="height: 30px;">Lihat Detail</button>
                            </a>
                        </td>
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

