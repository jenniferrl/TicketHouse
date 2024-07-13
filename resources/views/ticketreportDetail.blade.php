@php
    use Carbon\Carbon;
    $formattedDate = "";
    if($ticket->start_date !=null){
        $formattedDate = Carbon::createFromFormat('Y-m-d', $ticket->start_date)->format('d-F-Y');
    }
@endphp
@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
        <div class="container" style="min-height: 550px; padding-top:80px; padding-left: 20%;">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="">Informasi Tiket</h4>
                </div>
                <h4 class="text-center">Detail Data</h4>
            </div>
            <div class="Content">
                <div style="font-size: 16px" class="border-bottom border-top row d-flex justify-content-between py-2">
                    <div class="col-4 fw-bold">Nama Tiket</div>
                    <div class="d-flex justify-content-end col-4">{{ $ticket->nama }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Deskripsi</div>
                    <div class="col-4 d-flex justify-content-end">{{ $ticket->deskripsi }}</div>
                </div>
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Kategori</div>
                    <div class="col-4 d-flex justify-content-end">{{ $ticket->kategori }}</div>
                </div>
                @if ($formattedDate!="")    
                    <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                        <div class="col-4 fw-bold">Tanggal Acara</div>
                        <div class="col-4 d-flex justify-content-end">{{ $formattedDate }}</div>
                    </div>         
                @endif
                <div style="font-size: 17px" class="row d-flex border-bottom border-top justify-content-between py-2">
                    <div class="col-4 fw-bold">Jam</div>
                    <div class="col-4 d-flex justify-content-end">{{ $ticket->start_time }} - {{ $ticket->end_time }} WIB</div>
                </div>
            </div>
            {{-- <div class="shadow bg-light" style="width:45% ;border-radius: 10px; padding:35px 30px;">
                <p class=""><span class="fw-bold">Nama Tiket : </span>{{ $ticket->nama }}</p>
                <p class=""><span class="fw-bold">Deskripsi : </span>{{ $ticket->deskripsi }}</p>
                <p class=""><span class="fw-bold">Kategori : </span>{{ $ticket->kategori }}</p>
                @if ($formattedDate!="")                
                    <p class=""><span class="fw-bold">Tanggal Acara: </span>{{ $formattedDate }}</p>
                @endif
                <p class=""><span class="fw-bold">Jam : </span>{{ $ticket->start_time }} - {{ $ticket->end_time }} WIB</p>
            </div> --}}
        </div>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif

