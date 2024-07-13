@extends('layouts.main')
@section('content')

<div class="Seminar container" style="padding-top:100px; ">
    <h1>Seminar</h1><br>
    <div class="row pb-5">
        @foreach($seminars as $seminar)
            <div onclick="redirectToDetail('{{ route('ticket.detail', ['id' => $seminar->id_tiket]) }}')" class="col-sm-6 col-md-4 col-lg-3 rounded-3 p-3 mb-3" style="height: 250px;">
                <div class="gbr" style="height: 85%;">
                    <img class="img rounded-3 w-100 h-100" src="images/{{json_decode($seminar->gambar)[0]}}" alt="{{$seminar->nama}}" style="object-fit: cover;">
                </div>
                <div class="fw-bold">{{ $seminar->nama }}</div>
                <div>From IDR {{formatUang($seminar->harga)}}</div>
            </div>    
        @endforeach
    </div>
</div>
<script>
    // Function to redirect to the detail page 
    function redirectToDetail(detailUrl) {
        //we need this because we use div onclick that doesnt have href attribute
        //if we use an <a></a> instead, we dont need this
        // Update the window location to the detail page URL
        window.location.href = detailUrl;
    }
</script>
@endsection
