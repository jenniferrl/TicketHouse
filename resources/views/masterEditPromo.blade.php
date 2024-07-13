
@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h2 class="" style="">Master Promo</h2>
            </div>
        </div>

        <h4 class="text-center mt-2 py-2">Edit Data</h4>
        @if(session('message'))
          <div style="width: 100%" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
          <div style="width: 100%" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- display error maximum upload image -->
        @foreach ($errors->all() as $error)
        <div style="width: 100%" class="alert alert-danger alert-dismissible fade show" role="alert">
          {{$error}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
        
        <form action="/admin/master/promo/{{$id}}/edit" method="POST" class="mt-3 pb-3" enctype="multipart/form-data">
            @csrf

            <table class="w-100">
              <tr>
                <td>ID Penjual:</td>
                <td>
                  <input required value="{{ $oldData->id_penjual}}" id="idPenjual" class=" form-control @error('idPenjual') is-invalid @enderror" type="text" name="idPenjual" size="50" placeholder="ID Penjual" id="">
                  @error('idPenjual')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Kode Promo:</td>
                <td>
                  <input required value="{{ $oldData->kode_promo}}" id="kode_promo" class=" form-control @error('kode_promo') is-invalid @enderror" type="text" name="kode_promo" size="50" placeholder="Kode Promo" id="">
                  @error('kodePromo')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Nilai Promo: </td>
                <td>
                  <div class="d-flex">
                    <div class="me-2 mt-1">Rp</div> 
                    <input required value="{{ $oldData->nilai_promo }}" type="text" class=" form-control @error('nilaiPromo') is-invalid @enderror" name="nilaiPromo" size="40" placeholder="nilaiPromo" id="" style="width: 50%"></div> 
                  @error('nilaiPromo')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Tipe Promo:</td>
                <td>
                  <select value="{{ $oldData->tipe }}" style="width: 100%" class="form-control" name="tipePromo" id="tipePromo">
                      <option value="Persen" {{ ($oldData->tipe == "Persen") ? "selected": ""}}>Persen</option>
                      <option value="Non Persen" {{ ($oldData->tipe == "Non Persen") ? "selected": ""}}>Non Persen</option>
                  </select>
                  @error('tipePromo')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
              
                </td>
              </tr>
              <tr>
                <td>Minimal Pembelian: </td>
                <td>
                  <div class="d-flex">
                    <div class="me-2 mt-1">Rp</div> 
                    <input required value="{{ $oldData->min_purchase }}" type="text" class=" form-control @error('minPurchase') is-invalid @enderror" name="minPurchase" size="40" placeholder="minPurchase" id="" style="width: 50%"></div> 
                  @error('minPurchase')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-success" style="width: 100px; float:right;">Save</button>
                  <a href="/admin/master/promo"><div class="btn btn-danger me-2" style="width: 100px; float: right;">Cancel</div></a>
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

<!-- <script>
    function dateFillable(e){
    let inputDate = document.getElementById('startDate');
    if(e.value == "seminar"){
      inputDate.removeAttribute("disabled");
    }else if(e.value == "place"){
      inputDate.setAttribute("disabled", true);
      inputDate.value = "";
    }
  }
</script> -->
