@if (session('admin') == "admin")
<!-- {{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}} -->
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style="min-height: 650px; padding-top:80px; padding-left: 20%;">
        <!-- bagian atas -->
        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <h1 class="" style="">Master Penjual</h1>
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

        
        <form action="/admin/master/penjual/add" method="post" class="mt-3 pb-3">
            @csrf

            <table class="w-100">
              <tr>
                <td>Username:</td>
                <td>
                  <input required value="{{ old('username') }}" id="username" class=" form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Username">
                  @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Nomer Telepon:</td>
                <td>
                  <input required value="{{ old('telepon') }}" id="telepon" class=" form-control @error('telepon') is-invalid @enderror" type="text" name="telepon" placeholder="Nomer Telepon">
                  @error('telepon')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
             
              <tr>
                <td>Email: </td>
                <td>
                  <input required value="{{ old('email') }}" id="email" class=" form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email Penjual">
                  @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>

              <tr>
                <td>Nama Penjual:</td>
                <td>
                  <input required value="{{ old('name') }}" id="name" class=" form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Nama">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                    @enderror
                  </div>
                </td>
              </tr>

              <tr>
                <td>Tanggal Lahir:</td>
                <td>
                  <input required value="{{ old('dob') }}" id="dob" class=" form-control @error('dob') is-invalid @enderror" type="date" name="dob">
                  @error('dob')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>

              <tr>
                <td>Jenis Kelamin:</td>
                <td>
                  <select required value="{{ old('gender') }}" id="gender" class=" form-control @error('gender') is-invalid @enderror" name="gender">
                    <option value="L">Male</option>
                    <option value="P">Female</option>
                  </select>
                  @error('gender')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>

              <tr>
                <td>Password: </td>
                <td>
                  <input required value="{{ old('password') }}" id="password" class=" form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
                  @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </td>
              </tr>
              <tr>
                <td>Confirm Password: </td>
                <td>
                  <input required value="{{ old('password_confirmation') }}" id="password_confirmation" class=" form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password">
                  @error('password_confirmation')
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


