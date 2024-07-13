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
                <h3 class="" style="">Master Aktivitas</h3>
            </div>
            <div class="col-md-3 d-flex justify-content-end align-items-center">
                <a href="/admin/master/aktivitas/add" style="text-decoration: none;">
                    <button class="border-0 rounded-3 p-2" style="background-color: #FDE1A9; height: 70%;">Tambah Report Aktivitas</button>
                </a>
            </div>
        </div>

        <!-- table -->
        <table id="myTable2" class="table table-striped mt-4" style="width: 100%">
            <thead>
                <!-- <tr> -->
                    <th class="px-2 text-center" style="width: 8%">No</th>
                    <th class="px-2" style="width: 5%">ID</th>
                    <th class="px-2" style="width: 13%;">Penjual Terlapor</th>
                    <th class="px-2" style="width: 13%;">Pelapor</th>
                    <th class="px-2" style="width: 15%;">Keterangan</th>
                    <th class="px-2" style="width: 12%;">Action</th>
                <!-- </tr> -->
            </thead>
            <tbody>
                @foreach($daftarAktivitas as $index => $aktivitas)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$aktivitas->id_aktivitas}}</td>
                        <td>{{$aktivitas->penjual->name}}</td>
                        <td>{{$aktivitas->pembeli->name}}</td>
                        <td>{{$aktivitas->keterangan}}</td>

                        <td>
                            <a href="/admin/master/aktivitas/{{$aktivitas->id_aktivitas}}/detail" style="text-decoration: none;">
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

