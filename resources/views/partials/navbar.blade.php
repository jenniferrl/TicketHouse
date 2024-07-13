@php
  use App\Models\Pembeli;
  $currentUser = null;
  if(session()->has('user')){
    $currentUser = Pembeli::where('id_pembeli',session('user')->id_pembeli)->first();
  }
@endphp
<div style="" class="fixed-top Navbar d-flex justify-content-between bg-light container-fluid pt-3 shadow p-3 mb-4 navbar-expand-lg">
    <div class="WebLogo">
        <span class="fw-bold" style="font-size:23px; cursor:pointer;"><a href="/home" class="nav-link">🎟️Ticket House</a></span>
    </div>
    <div class="SearchBar " >
        <form class="d-flex" method="GET" action="/search">
            <input class="form-control me-1" size="25" name="keyword" type="search" placeholder="Cari acara atau lokasi" value="{{ request()->input('keyword') }}" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
    </div>
    {{-- navbarexpandlg supaya menu bisa nyamping dan ngga kebawah --}}
    <div class="Menu navbar-expand-lg">
        {{-- navbar nav supaya tidak ada bullet point --}}
        <ul class="navbar-nav">
        @if (session()->has('user')) 
          <li class="nav-item mx-3">
            <a class="nav-link" style="opacity: {{ request()->is('history/*') ? '100%' : '50%' }}" href="/history/success">History</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link" style="opacity: {{ request()->is('wishlist') ? '100%' : '50%' }}" href="/wishlist">Wishlist</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link" style="opacity: {{ request()->is('nearme') ? '100%' : '50%' }}" href="#" onclick="nearMe()"><i class="fa-solid fa-location-dot"></i> Near Me</a>
          </li>
          <li class="nav-item mx-3">
            <!-- {{-- untuk mendapatkan path route yang sedang dikunjungi lalu dibuat active--}} -->
            <a class="nav-link {{ request()->is('seminar') ? 'active' : '' }}" style="opacity: {{ request()->is('seminar') ? '100%' : '50%' }}" href="/seminar">Seminar</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link {{ request()->is('places') ? 'active' : '' }}" style="opacity: {{ request()->is('places') ? '100%' : '50%' }}" href="/places">Places</a>
          </li>
          <li class="nav-item mx-3">
            <!-- {{-- Mengatur style agar menu page yang aktif bisa dibedakan dari menu page lain  --}} -->
            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" 
            style="opacity: {{ request()->is('about') ? '100%' : '50%' }}" href="/about">About Us</a>
          </li>
          <li  class="nav-item mx-3">
            <a onclick="toggleNotif()" class="nav-link"  ><i class="fa-regular fa-bell fa-xl"></i></a>
          </li>
          <li onclick="closeNotif()" class="nav-item dropdown mx-3">
            {{-- if we add class dropdown-toggle, there will be a dropdown arrow displayed next to user profile --}}
            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              @if ($currentUser && $currentUser->profile_picture != null)
                <img src="/images/{{ $currentUser->profile_picture }}" width="33px" height="33px" style="border-radius:50%; object-fit: cover;" alt="">
              @else
                <i class="fa-regular fa-user fa-xl"></i>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#"><i class="fa-solid fa-dollar-sign fa-lg"></i>&nbsp; {{ session('user')->poin }} Points</a></li>
              <li><a class="dropdown-item" href="{{ route('show.profile') }}"><i class="fa-solid fa-pen-to-square fa-lg"></i> Edit Profile</a></li>
              <li><a class="dropdown-item" style="cursor: pointer">Refferal Code : {{ session('user')->refferal }}</a></li>
              <li><hr class="dropdown-divider"></li>
              {{-- dropdown divider is a separator line, like <hr> tag --}}
              <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
          </li>
          @else          
            <li class="nav-item mx-2">
              <a class="nav-link {{ request()->is('seminar') ? 'active' : '' }}" aria-current="page" style="opacity: {{ request()->is('seminar') ? '100%' : '50%' }}" href="/seminar">Seminar</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link {{ request()->is('places') ? 'active' : '' }}" style="opacity: {{ request()->is('places') ? '100%' : '50%' }}" href="/places">Places</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" style="opacity: {{ request()->is('about') ? '100%' : '50%' }}" href="/about">About Us</a>
            </li>
            <li class="nav-item mx-2">
              <a class="btn btn-success" href="/login" >Login</a>
            </li>  
          @endif
        </ul>
    </div>
</div>
<div id="notif"  class="fixed-top bg-light shadow-lg" style="display:none;width:30%;margin-left:800px; margin-top:60px; border-radius:7px">
  @if (session('tempTickets')!=null && session()->has('user')) 
    @foreach (session('tempTickets') as $index => $s)
      @if ($index == 0)
        <div class="notifmenu shadow-sm px-3 py-4"><a style="text-decoration: none; color:black" href="{{ route('ticket.detail',['id'=>$s->id_tiket]) }}">Tiket <span class="fw-bold">{{ $s->nama }}</span> mungkin menarik perhatianmu!</a></div>
      @elseif ($index==1)
        <div class="notifmenu shadow-sm px-3 py-4"><a href="{{ route('ticket.detail',['id'=>$s->id_tiket]) }}" style="text-decoration: none; color:black" href="">Tiket <span class="fw-bold">{{ $s->nama }}</span> jangan sampai kamu lewatkan!</a></div>
      @else
        <div class="notifmenu shadow-sm px-3 py-4"><a style="text-decoration: none; color:black" href="{{ route('ticket.detail',['id'=>$s->id_tiket]) }}" >Tiket <span class="fw-bold">{{ $s->nama }}</span> tampaknya cocok buat kamu!</a></div>
      @endif 
    @endforeach
  @endif
</div>

<script>
    let storeLatitude = 0;
    let storeLongitude = 0;

    function nearMe(){
      // Check if the browser supports Geolocation
      if (navigator.geolocation) {
          // Get the current position
          navigator.geolocation.getCurrentPosition(
              function(position) {
                  // Extract latitude and longitude from the position object
                  const latitude = position.coords.latitude;
                  const longitude = position.coords.longitude;

                  //menyisipkan posisi longitude dan latitude user saat ini ke params url
                  const urlParams = new URLSearchParams(window.location.search);
                  // console.log(urlParams.toString().includes("lat"));

                  //pengecekan supaya latitude dan longitude hanya ditambahkan jika belum ada di url
                  if(!urlParams.toString().includes("lat") || !urlParams.toString().includes("long")){ 
                      urlParams.set('lat', latitude);
                      urlParams.set('long', longitude);

                      let url = "{{ route('nearMe', ':parameter') }}";
                      url = url.replace(':parameter', urlParams);
                      window.location.href = url;

                      console.log("/nearMe/"+urlParams.toString());
                  }
                  // console.log(urlParams.toString().includes("lat"));

                  
                  
                  // Nilai longitude dan latitude
                  console.log('Latitude: ' + latitude);
                  console.log('Longitude: ' + longitude);
              },
              function(error) {
                  // Handle errors
                  switch (error.code) {
                      case error.PERMISSION_DENIED:
                          console.error('User denied the request for Geolocation.');
                          break;
                      case error.POSITION_UNAVAILABLE:
                          console.error('Location information is unavailable.');
                          break;
                      case error.TIMEOUT:
                          console.error('The request to get user location timed out.');
                          break;
                      case error.UNKNOWN_ERROR:
                          console.error('An unknown error occurred.');
                          break;
                  }
              }
          );
      } else {
          console.error('Geolocation is not supported by this browser.');
      }

    }
    function toggleNotif(){
      let notifBar = document.getElementById('notif');
      notifBar.style.display = (notifBar.style.display == "block")  ? "none" : "block";
    }
    function closeNotif(){
      //function to ensure that the notification dropdown is closed whenever we click the user profile
      let notifbar = document.getElementById('notif');
      notifbar.style.display = "none";
    }
</script>