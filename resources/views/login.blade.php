@extends('layouts.main')
@section('content')
<div class="Login d-flex justify-content-center" style="padding-top: 100px;">
    <div class="mt-4 p-3" style="">
        {{-- tampilkan flash message setelah berhasil register --}}
        @if (session()->has('success'))        
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif 
        @if (session()->has('loginError'))        
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="mt-4 mb-5">Log In</h2>
        
        <form action="/login" method="post" class="mt-3">
            @csrf
            <input value="{{ old("login") }}" required type="text"  size="59" name="login" id="login" class="form-control @error("login")
                is-invalid
            @enderror" placeholder="Username or email" autofocus>
            @error("login")                
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <br/>
            {{-- required memastikan input field ga boleh kosong --}}
            <input  required class="form-control" type="password" size="59" name="password" id="password" placeholder="Password">
            <br/><br/>
            <button class="btn btn-success" style="width: 485px;">Login</button>
            <br/><br/>
  
        </form>
        <div class="d-flex justify-content-end mb-0">
            <p class="float-right">Don't have an account? <br/><span style="margin-left: 70px"><a class="" href="/register">Register Now</a></span> </p>
        </div>
    </div>
</div>
@endsection