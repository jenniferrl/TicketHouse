<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('font/font/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ $title }}</title>
</head>
<body>
{{-- navbar dijadikan komponen terpisah di file partials/navbar. Cara panggil komponen pake @include(namafolder.namafile) --}}
    <div class="container-fluid" style="">
        <div class="Login d-flex justify-content-center" style="padding-top: 50px;">
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
        
                <h2 class="mt-4 mb-5">Admin Log In</h2>
                
                <form action="/adminLogin" method="post" class="mt-3">
                    @csrf
                    <input value="{{ old("adminLogin") }}" required type="text"  size="59" name="login" id="login" class="form-control @error("login")
                        is-invalid
                    @enderror" placeholder="Username" autofocus>
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
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


