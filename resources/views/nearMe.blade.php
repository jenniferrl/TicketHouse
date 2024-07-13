

@extends('layouts.main')
@section('content')

<div class="Places container" style="padding-top:100px; ">
    <h1>Near Me</h1><br>
    <div class="row pb-5">
         <!-- {{-- show text if no tiket is found near user --}} -->
         @if(count($result) == 0)
            <h2 class="text-center text-danger">Belum ada tiket disekitar anda</h2>
        @endif

        @foreach($result as $res)
            <div onclick="redirectToDetail('{{ route('ticket.detail', ['id' => $res->id_tiket]) }}')" class="col-sm-6 col-md-4 col-lg-3 rounded-3 p-3 mb-3" style="height: 250px;">
                <div class="gbr" style="height: 85%;">
                    <img class="img rounded-3 w-100 h-100" src="images/{{json_decode($res->gambar)[0]}}" alt="{{$res->nama}}" style="object-fit: cover;">
                </div>
                <div class="fw-bold">{{ $res->nama }}</div>
                <div>From IDR {{formatUang($res->harga)}}</div>
            </div>    
        @endforeach
    </div>
</div>
<script>
    // let storeLatitude = 0;
    // let storeLongitude = 0;
    
    // Function to redirect to the detail page 
    function redirectToDetail(detailUrl) {
        //we need this because we use div onclick that doesnt have href attribute
        //if we use an <a></a> instead, we dont need this
        // Update the window location to the detail page URL
        window.location.href = detailUrl;
    }

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
                    
                    window.location.search = urlParams;
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

</script>
@endsection