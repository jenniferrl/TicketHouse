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
                <h3 class="" style="">Master Penjual</h3>
            </div>
            <div class="col-md-3 d-flex justify-content-end align-items-center">
                <a href="/admin/master/penjual/add/">
                    <button class="border-0 rounded-3 p-2" style="background-color: #FDE1A9; height: 70%;">Tambah Penjual</button>
                </a>
            </div>
        </div>

        <!-- table -->
        <table id="myTable2" class="table table-striped mt-4" style="width: 100%">
            <thead>
                <!-- <tr> -->
                    <th class="px-2 text-center" style="width: 8%">No</th>
                    <th class="px-2" style="width: 5%">ID</th>
                    <th class="px-2" style="width: 13%;">Nama</th>
                    <th class="px-2" style="width: 13%;">Kontak</th>
                    <th class="px-2" style="width: 13%;">Email</th>
                    <th class="px-2" style="width: 13%;">Status</th>
                    <th class="px-2" style="width: 15%;">Action</th>
                <!-- </tr> -->
            </thead>
            <tbody>
                @foreach($daftarPenjual as $index => $penjual)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$penjual->id_penjual}}</td>
                        <td>{{$penjual->name}}</td>
                        <td>{{$penjual->no_telp}}</td>
                        <td>{{$penjual->email}}</td>
                        <td class="{{($penjual->status == 0) ? 'text-danger' : ''}}" >{{($penjual->status == 1) ? "Aktif" : "Banned" }}</td>
                        <td>
                            <a href="/admin/master/penjual/{{$penjual->id_penjual}}/detail" style="text-decoration: none;">
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

