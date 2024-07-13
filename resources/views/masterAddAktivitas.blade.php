
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h1 class="" style="">Master Aktivitas</h1>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Add Data</h4>
        @if(session('message'))
          <div style="width: 500px" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
          <div style="width: 500px" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
        <form action="/admin/master/aktivitas/add" method="post" class="mt-3 pb-3">
            @csrf

            <table class="w-100">
              <tr>
                <td>ID Penjual Terlapor:</td>
                <!-- <td>
                  <input required value="{{ old('idTerlapor') }}" id="idTerlapor" class=" form-control @error('idTerlapor') is-invalid @enderror" type="text" name="idTerlapor" size="50" placeholder="ID Terlapor" id="">
                  @error('idTerlapor')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td> -->
                <td>
                  <select value="{{ old('idTerlapor') }}" style="width: 100%" class="form-control" name="idTerlapor" id="idTerlapor">
                      @foreach($daftarPenjual as $penjual)
                        <option value="{{$penjual->id_penjual}}">{{$penjual->id_penjual}} - {{$penjual->name}}</option>
                      @endforeach
                  </select>
                  @error('idTerlapor')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>ID Pembeli Pelapor:</td>
                <!-- <td>
                  <input required value="{{ old('idPelapor') }}" id="idPelapor" class=" form-control @error('idPelapor') is-invalid @enderror" type="text" name="idPelapor" size="50" placeholder="ID Pelapor" id="">
                  @error('idPelapor')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td> -->
                <td>
                  <select value="{{ old('idPelapor') }}" style="width: 100%" class="form-control" name="idPelapor" id="idPelapor">
                      @foreach($daftarPembeli as $pembeli)
                        <option value="{{$pembeli->id_pembeli}}">{{$pembeli->id_pembeli}} - {{$pembeli->name}}</option> 
                      @endforeach
                  </select>
                  @error('idPelapor')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
             
              <tr>
                <td>Deskripsi Masalah: </td>
                <td>
                  <input required value="{{ old('deskripsi') }}" id="deskripsi" class=" form-control @error('deskripsi') is-invalid @enderror" type="text" name="deskripsi" size="100" placeholder="Deskripsi Masalah">
                  @error('deskripsi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              
              <tr>
                <td colspan="2">
                  <button class="btn btn-success" style="width: 100px; float:right;">Tambah</button>
                  <input class="btn btn-danger me-2" type="reset" style="width: 100px; float: right;" value="Reset">
                </td>
              </tr>
            </table>

            
        </form>

    </div>
    
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif


