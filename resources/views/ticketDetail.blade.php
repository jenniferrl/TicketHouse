@extends('layouts.main')
@section('content')
    {{-- @dd($seller); --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Report this ticket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="myModalForm" action="{{ route('submit.report',['id'=>$ticket->id_penjual]) }}" method="post">
                @csrf
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Message:</label>
                  <textarea name="reportText" class="form-control" id="message-text"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" >Submit Report</button>
            </form>
        </div>
      </div>
    </div>
  </div>
    <div class="container d-flex justify-content-between" style="min-height: 850px; padding-top:130px;">

        <div class="kiri">
            <div class="">
                <div class="BagianSatu " style="display:flex;justify-content: space-between">
                    <div class="kiri" >
                        <h2>{{ $ticket->nama }}</h2>
                        <p>oleh <span style="font-size: 20px" class="fw-bold">{{ $seller->name }}</span></p>
                        <div style="" class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button" data-size="large">
                            <a target="" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="fb-xfbml-parse-ignore">Share</a>
                        </div>
                        <p class="mt-2"><i class="fa-solid fa-location-dot fa-lg"></i>&nbsp; {{ $ticket->alamat_lokasi }}, {{ $ticket->kota }}</p>

                    </div>
                    <div class="kanan pt-2 d-flex" >
                        <span>
                            <a href="{{ route('tickets.reminder',['id' => $id]) }}" class="btn btn-warning me-2"><i class="fa-solid fa-calendar fa-lg"></i>&nbsp;Set Reminder</a>
                        </span>
                        <span>
                            <form action="{{ route('add.wishlist', ['id' => $id]) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary me-2" type="submit">Add to Wishlist</button>
                            </form>
                        </span>
                        <span>                            
                            <button type="button" id="myBtn"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger me-2">Report</button>
                        </span>

                    </div>
                </div>
                <div class="BagianDua">
                    <!-- gambar tiket -->
                    <div id="carouselExampleAutoplaying" class="carousel slide ms-4 mb-4" data-bs-ride="carousel" style="width: 90%; height:400px;">
                        <div class="carousel-inner" style="width: 775px;">
                            
                            @for($i = 0; $i < sizeof(json_decode($ticket->gambar)); $i++)
                                @if($i == 0)
                                    <div class="carousel-item active" style="width: 100%; height:400px">
                                        <img src="/images/{{ json_decode($ticket->gambar)[$i] }}" style="object-fit: cover;" class="d-block w-100" alt="">
                                    </div>
                                @else
                                    <div class="carousel-item" style="width: 100%; height:400px">
                                        <img src="/images/{{ json_decode($ticket->gambar)[$i] }}" style="object-fit: cover;" class="d-block w-100" alt="">
                                    </div>
                                @endif
                            @endfor
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- map preview -->
                    <h5 style="margin-left:25px">Peta lokasi tiket:</h5>
                    <div class="gambarMap" id="gambarMap" style="margin-left:25px ;width: 775px; height:200px">
                        <!-- <img class="w-100 h-100" src="/images/graybackground.png" alt=""> -->
                    </div><br>
                    @if ($ticket->start_date != null)
                        <p><i class="fa-solid fa-clock fa-lg"></i>&nbsp;{{date('D, d-M-Y',strtotime($ticket->start_date) )  }} {{ $ticket->start_time }} - {{ $ticket->end_time }} WIB</p>                        
                    @else
                        <p><i class="fa-solid fa-clock fa-lg"></i>&nbsp;Jam Operasional : {{ $ticket->start_time }} - {{ $ticket->end_time }} WIB</p>  
                    @endif
                    <form action="{{ route('checkout',['id'=>$ticket->id_tiket]) }}" style="margin-left: 25px">
                        @csrf
                        <input type="text" name="" id="" size="50" placeholder="Dari IDR {{ formatUang($ticket->harga) }}" disabled>
                        <button class=" ms-2 btn btn-success">Beli Tiket</button>
                    </form>
                </div><br>
                <div class="BagianTiga">
                    <p style="font-size: 20px; font-weight:bold;">Deskripsi</p>
                    <p>{{ $ticket->deskripsi }}</p>
                </div>
                <div class="BagianEmpat">
                    <p style="font-size: 24px; font-weight:bold;">Promo yang bisa digunakan</p>
                    @if(count($promo) == 0)
                        <p class="fw-bold fs-5 text-danger">Maaf belum ada promo yang bisa kamu gunakan dari penjual ini</p>
                    @endif 

                    @foreach($promo as $p)
                        @if($p->tipe == "persen")
                            <p>{{$p->kode_promo}} - Discount {{$p->nilai_promo}}% - <b>Minimum Pembelian Rp{{formatUang($p->min_purchase)}}</b></p>
                        @else
                            <p>{{$p->kode_promo}} - Potongan Rp {{formatUang($p->nilai_promo)}} - <b>Minimum Pembelian Rp{{formatUang($p->min_purchase)}}</b></p>
                        @endif
                    @endforeach
                    
                </div>
            </div>
        </div>
        <div class="kanan">
            <div class="Gambar" style="width: 250px; height:260px;">                    
                <img style="object-fit: cover; border-radius:5%;" class="w-100 h-100" src="/images/{{ json_decode($ticket->gambar)[0] }}" alt="">          
            </div>   
        </div>
        {{-- modal --}}
    </div>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <script>

        //function untuk load map HERE
        function loadHereMaps() {
            let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://js.api.here.com/v3/3.1/mapsjs-core.js';
            document.body.appendChild(script);

            script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://js.api.here.com/v3/3.1/mapsjs-service.js';
            document.body.appendChild(script);

            script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://js.api.here.com/v3/3.1/mapsjs-mapevents.js';
            document.body.appendChild(script);

            script.onload = function () {
                let latitude = <?php echo json_encode($ticket->lokasi_lat); ?>;
                let longitude = <?php echo json_encode($ticket->lokasi_long); ?>;
                let platform = new H.service.Platform({
                    apikey: '1DvppUVi__lz1FhPrVsRjXlo92_CDUDCBgPkikH4xd4'
                });

                let defaultLayers = platform.createDefaultLayers();

                let map = new H.Map(
                document.getElementById('gambarMap'),
                defaultLayers.vector.normal.map,
                    {
                        center: { lat: latitude, lng: longitude },
                        zoom: 14,
                        pixelRatio: window.devicePixelRatio || 1
                    }
                );

                let behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

                const marker = new H.map.Marker({ lat: latitude, lng: longitude });
                map.addObject(marker);

                marker.addEventListener('tap', function (evt) {
                    alert('Marker clicked!'); // You can replace this with your custom logic
                });
            };
        }

        window.onload = loadHereMaps;

    </script>
@endsection