@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-center">
    <div class="mb-3 p-3" style="margin-top: 80px">
        <a href="/login">< Back to login</a>
        <h3 class="my-2 ">Register</h3>
        <form action="/register" method="post" class="mt-3 pb-3" >
            @csrf
            <input required value="{{ old('email') }}" id="email" class=" form-control @error('email') is-invalid @enderror" type="email" name="email" size="50" placeholder="email" id="">
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input required value="{{ old('username') }}" type="text" class=" form-control @error('username') is-invalid @enderror" name="username" size="50" placeholder="username" id="">
            @error('username')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input required type="text" value="{{ old('name') }}" class=" form-control @error('name') is-invalid @enderror" name="name" size="50" placeholder="name" id="">
            @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input required value="{{ old('no_telp') }}" type="text" class=" form-control @error('no_telp') is-invalid @enderror" name="no_telp" size="50" placeholder="phone" id="">
            @error('no_telp')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input value="{{ old('dob') }}" type="date" class=" form-control @error('dob') is-invalid @enderror" name="dob" size="50" placeholder="date of birth" id="">
            @error('dob')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <select value="{{ old('gender') }}" class=" form-control" style="width: 450px" name="gender" id="Gender">
                <option value="L">Male</option>
                <option value="P">Female</option>
            </select>
            @error('gender')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <select value="{{ old('role') }}" style="width: 450px" class="form-control" name="role" id="Role">
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>
            @error('role')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
           <br/>
            <input required value="{{ old('password') }}" type="password" class=" form-control @error('password') is-invalid @enderror" name="password" size="50" placeholder="password" id="">
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input required value="{{ old('password_confirmation') }}" type="password" class=" form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" size="50" placeholder="confirm password" id="">
            @error('password_confirmation')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <br/>
            <input  value="{{ old('refferal') }}" type="text" class=" form-control" name="refferal" size="50" placeholder="refferal code (optional)" id=""><br>
            <button class="btn btn-success" style="width: 450px;">Register</button>
        </form>
    </div>
</div>
@endsection