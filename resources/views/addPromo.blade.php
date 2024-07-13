@extends('layouts.sellerMain')
@section('content')
<!-- {{-- Desain interface masih belum perfect sesuai figma, masih ada field yang kurang (ex. startdate, starttime, endtime) dan belum bisa upload gambar. --}} -->
<div class="d-flex justify-content-center" style="min-height: 600px">
    <div class="my-3 pt-5" style=" ">
        <h3 class="mt-5">Tambah Kode Promo</h3>
        <form action="/addPromo" method="post" class="mt-3 pb-3" >
            @csrf
            Kode Promo
            <input required value="{{ old('kodePromo') }}" id="kodePromo" class=" form-control @error('kodePromo') is-invalid @enderror" type="text" name="kodePromo" size="50" placeholder="masukkan kode promo" id="">
            @error('kodePromo')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            Minimal pembelian
            <input required value="{{ old('min-purchase') }}" id="minPurchase" type="text" class=" form-control @error('min-purchase') is-invalid @enderror" name="min-purchase" size="50" placeholder="minimal pembelian" id="">
            @error('min-purchase')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror            
            <br/>
            Nilai Promo
            <input required value="{{ old('nilaiPromo') }}" id="nilaiPromo" type="text" class=" form-control @error('nilaiPromo') is-invalid @enderror" name="nilaiPromo" size="50" placeholder="nilai promo" id="">
            @error('nilaiPromo')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror            
            <br/>
            Tipe
            <select value="{{ old('tipe') }}" id="tipePromo" style="width: 450px" class="form-control" name="tipe" id="tipe">
                <option value="Persen">Persen</option>
                <option value="Non Persen">Non Persen</option>
            </select>
            @error('tipe')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
           <br/>
            <button class="btn btn-success" style="width: 450px;">Tambah</button>
            <input class="btn btn-secondary" type="reset" value="Reset">
        </form>
    </div>
</div>
@endsection