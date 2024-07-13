@php
    use App\Models\Pembeli;
    $title = "Edit Profile Pembeli";
    // harus diambil currentUser, krn kalo pake session(user) data belum terupdate
    $currentUser = Pembeli::where('id_pembeli',session('user')->id_pembeli)->first();
@endphp
@extends('layouts.main')
@section('content')
    <div class="" style="min-height: 500px; padding-top:100px; padding-bottom:70px">
        {{-- kalo ngga ada enctype, input file tidak bisa diambil valuenya --}}
        <h3 class="" style="margin-left: 350px">Edit Profile</h3>
        <div class="d-flex justify-content-center">
            <form enctype="multipart/form-data" style="width:500px; height:350px;" method="post" action="{{ route('update.profile') }}">
                @csrf
                @if ($currentUser->profile_picture!=null)
                    <img src="/images/{{ $currentUser->profile_picture }}" style="width:50px; height:50px; border-radius:50%"  alt="">
                @else
                    <img src="/images/graybackground.png" style="width: 100px; height:100px;border-radius:50%" alt="">
                @endif
                <input class="" style="margin-left:60px" type="file" name="profile_picture" id="profile_picture"><br>
                <div class="mt-3 d-flex justify-content-between px-3">
                    <label for="">Nama</label>
                    <input size="45" type="text" name="nama" value="{{ $currentUser->name }}" id="">
                </div>
                <div class="mt-3 d-flex justify-content-between px-3">
                    <label for="">Nomor Telepon</label>
                    <input size="40" type="text" name="no_telp" value="{{ $currentUser->no_telp }}" id="">
                </div>
                <div class="mt-3 d-flex  px-3">
                    <label class="me-5" for="">Gender:</label>
                    @if ($currentUser->jk == "L")
                        <input class="form-check-input me-2" type="radio" name="gender" id="" value="L" checked>Laki-laki 
                        <input class="ms-3 form-check-input me-2" type="radio" name="gender" id="" value="P">Perempuan                        
                    @else
                        <input class="form-check-input me-2" type="radio" name="gender" id="" value="L" checked>Laki-laki 
                        <input class="ms-3 form-check-input me-2" type="radio" name="gender" id="" value="P" checked>Perempuan                        
                    @endif
                </div>
                <div class="mt-3 d-flex justify-content-between px-3">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="dob" value="{{ $currentUser->tgl_lahir }}" id="">
                </div>
                <div class="px-3 mt-4">
                    <button class="btn btn-outline-primary col-12" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection