@extends('layouts.sellerMain')
@section('content')
<!-- {{-- Desain interface masih belum perfect sesuai figma, masih ada field yang kurang (ex. startdate, starttime, endtime)--}} -->
<div class="container" style="min-height: 900px; margin-left: 30%; padding-top:100px">
    <div class="my-3 " style=" ">
        <h2 class="mt-3">Tambah Tiket</h2>
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

        <!-- display error maximum upload image -->
        @foreach ($errors->all() as $error)
        <div style="width: 500px" class="alert alert-danger alert-dismissible fade show" role="alert">
          {{$error}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach

        <form action="/add" method="post" class="mt-3 pb-3" enctype="multipart/form-data">
            @csrf

            <table>
              <tr>
                <td>Nama Tiket:</td>
                <td>
                  <input required value="{{ old('namaTiket') }}" id="namaTiket" class=" form-control @error('namaTiket') is-invalid @enderror" type="text" name="namaTiket" size="50" placeholder="Nama Tiket" id="">
                  @error('namaTiket')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Kategori:</td>
                <td>
                  <select value="{{ old('kategori') }}" style="width: 450px" class="form-control" name="kategori" id="kategori" onchange="dateFillable(this);">
                      <option value="place">Place</option>
                      <option value="seminar">Seminar</option>
                  </select>
                  @error('kategori')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
              
                </td>
              </tr>
              <tr>
                <td>Deskripsi: </td>
                <td>
                  <textarea required type="text" class=" form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" size="50" placeholder="Deskripsi" id="">{{ old('deskripsi') }}</textarea>
                  @error('deskripsi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Harga: </td>
                <td>
                  <div class="d-flex">
                    <div class="me-2 mt-1">Rp</div> 
                    <input required value="{{ old('harga') }}" type="text" class=" form-control @error('harga') is-invalid @enderror" name="harga" size="40" placeholder="Harga" id="" style="width: 50%"></div> 
                  @error('harga')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Stok: </td>
                <td>
                  <input required value="{{ old('stok') }}" type="text" class=" form-control @error('stok') is-invalid @enderror" name="stok" size="50" placeholder="Stok" id="">
                  @error('stok')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Gambar: </td>
                <td>
                  <input type="file" name="images[]" id="images" multiple>
                  <!-- jika basic user can only upload up to 3 images -->
                  @if (session('user')->premium_status == 0)
                    <span>Upload up to 3 images</span>
                  @else
                    <span>Upload up to 5 images</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Kota:</td>
                <td>
                  <select value="{{ old('kota') }}" style="width: 450px" class="form-control" name="kota" id="kota">
                    <option value="Bandung">Bandung</option>
                    <option value="Denpasar">Denpasar</option>
                    <option value="Jakarta Barat">Jakarta Barat</option>
                    <option value="Jakarta Pusat">Jakarta Pusat</option>
                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                    <option value="Jakarta Timur">Jakarta Timur</option>
                    <option value="Jakarta Utara">Jakarta Utara</option>
                    <option value="Malang">Malang</option>
                    <option value="Medan">Medan</option>
                    <option value="Solo">Solo</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                  </select>
                  @error('kota')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Lokasi: </td>
                <td>
                  <input required value="{{ old('lokasi') }}" type="text" class=" form-control @error('lokasi') is-invalid @enderror" name="lokasi" size="50" placeholder="Lokasi" id="">
                  @error('lokasi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                  Kombinasi nama jalan beserta nomor jika ada, contoh: Jl. Ngagel Jaya Tengah No.77
                </td>
              </tr>
              <tr>
                <td>Tanggal: <br><b style="color: red;">(Hanya untuk tiket seminar)<b></td>
                <td>
                  <input required value="{{ old('startDate') }}" type="date" class=" form-control @error('startDate') is-invalid @enderror" name="startDate" size="50" id="startDate" disabled>
                  @error('startDate')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                  
                </td>
              </tr>
              <tr>
                <td>Waktu Mulai: </td>
                <td>
                  <input required value="{{ old('startTime') }}" type="time" class=" form-control @error('startTime') is-invalid @enderror" name="startTime" size="50" id="startTime">
                  @error('startTime')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                  Untuk tiket tempat wisata bisa diisi jam buka tempat wisata
                </td>
              </tr>
              <tr>
                <td>Waktu Selesai: </td>
                <td>
                  <input required value="{{ old('endTime') }}" type="time" class=" form-control @error('endTime') is-invalid @enderror" name="endTime" size="50" id="endTime">
                  @error('endTime')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                  Untuk tiket tempat wisata bisa diisi jam tutup tempat wisata
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
</div>
@endsection

<script>
  function dateFillable(e){
    let inputDate = document.getElementById('startDate');
    if(e.value == "seminar"){
      inputDate.removeAttribute("disabled");
    }else if(e.value == "place"){
      inputDate.setAttribute("disabled", true);
      inputDate.value = "";
    }
  }
</script>