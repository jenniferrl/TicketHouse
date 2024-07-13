@extends('layouts.sellerMain')
@section('content')
<!-- {{-- Desain interface masih belum perfect sesuai figma, masih ada field yang kurang (ex. startdate, starttime, endtime) --}} -->
<div class="container" style="min-height: 900px; margin-left:30%;">
    <div class="my-3 pt-5" style=" ">
        <h2 class="mt-5">Edit Tiket</h2>
        
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

        <form action="/edit/{{$id}}" method="post" class="mt-3 pb-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <table>
              <tr>
                <td>Nama Tiket:</td>
                <td>
                  <input required value="{{ $oldData->nama}}" id="namaTiket" class=" form-control @error('namaTiket') is-invalid @enderror" type="text" name="namaTiket" size="50" placeholder="Nama Tiket" id="">
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
                  <select value="{{ $oldData->kategori }}" style="width: 450px" class="form-control" name="kategori" id="kategori" onchange="dateFillable(this)">
                      <option value="place" {{ $oldData->kategori === 'place' ? 'selected' : '' }}>Place</option>
                      <option value="seminar" {{ $oldData->kategori === 'seminar' ? 'selected' : '' }}>Seminar</option>
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
                  <textarea required type="text" class=" form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" size="50" placeholder="Deskripsi" id="">{{ $oldData->deskripsi }}</textarea>
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
                    <input required value="{{ $oldData->harga }}" type="text" class=" form-control @error('harga') is-invalid @enderror" name="harga" size="40" placeholder="Harga" id="" style="width: 50%"></div> 
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
                  <input required value="{{ $oldData->quantity }}" type="text" class=" form-control @error('stok') is-invalid @enderror" name="stok" size="50" placeholder="Stok" id="">
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
                  <select value="{{ $oldData->kota }}" style="width: 450px" class="form-control" name="kota" id="kota">
                    <option value="Bandung" {{ $oldData->kota === 'Bandung' ? 'selected' : '' }}>Bandung</option>
                    <option value="Denpasar" {{ $oldData->kota === 'Denpasar' ? 'selected' : '' }}>Denpasar</option>
                    <option value="Jakarta Barat" {{ ($oldData->kota == "Jakarta Barat") ? "selected": ""}}>Jakarta Barat</option>
                    <option value="Jakarta Pusat" {{ ($oldData->kota == "Jakarta Pusat") ? "selected": ""}}>Jakarta Pusat</option>
                    <option value="Jakarta Selatan" {{ ($oldData->kota == "Jakarta Selatan") ? "selected": ""}}>Jakarta Selatan</option>
                    <option value="Jakarta Timur" {{ ($oldData->kota == "Jakarta Timur") ? "selected": ""}}>Jakarta Timur</option>
                    <option value="Jakarta Utara" {{ ($oldData->kota == "Jakarta Utara") ? "selected": ""}}>Jakarta Utara</option>
                    <option value="Malang" {{ $oldData->kota === 'Malang' ? 'selected' : '' }}>Malang</option>
                    <option value="Medan" {{ $oldData->kota === 'Medan' ? 'selected' : '' }}>Medan</option>
                    <option value="Solo" {{ $oldData->kota === 'Solo' ? 'selected' : '' }}>Solo</option>
                    <option value="Surabaya" {{ $oldData->kota === 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                    <option value="Yogyakarta" {{ $oldData->kota === 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
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
                  <input required value="{{ $oldData->alamat_lokasi }}" type="text" class=" form-control @error('lokasi') is-invalid @enderror" name="lokasi" size="50" placeholder="Lokasi" id="">
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
                  <input required value="{{ $oldData->start_date}}" type="date" class=" form-control @error('startDate') is-invalid @enderror" name="startDate" size="50" id="startDate" {{ ($oldData->kategori === 'seminar' ) ? '' : 'disabled'}}>
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
                  <input required value="{{ $oldData->start_time}}" type="time" class=" form-control @error('startTime') is-invalid @enderror" name="startTime" size="50" id="startTime">
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
                  <input required value="{{ $oldData->end_time}}" type="time" class=" form-control @error('endTime') is-invalid @enderror" name="endTime" size="50" id="endTime">
                  @error('endTime')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                  Untuk tiket tempat wisata bisa diisi jam tutup tempat wisata
                </td>
              </tr>
              <tr class="">
                <td colspan="2">
                  <button class="btn btn-success ms-2" type="submit" style="width: 100px;float: right;">Update</button>
                  <a href="/viewall"><div class="btn btn-danger" style="width: 100px; float: right;">Cancel</div></a>
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