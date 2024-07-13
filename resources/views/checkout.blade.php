{{-- check if user has logged in or not. If not redirect him to login page --}}
@if (session()->has('user')) 
    @extends('layouts.main')
    @section('content')
        <div class="container d-flex pb-4 justify-content-center" style="min-height: 750px; padding-top:100px">
            <div class="shadow-lg mt-3" style=" border-radius:10px;width:650px ;min-height:400px; padding: 15px 20px">
                <h2 class="mb-4 text-center">Checkout</h2>
                <p class="fs-5">Nama Tiket : &nbsp;{{ $ticket->nama }}</p>
                <p class="fs-5">Lokasi : &nbsp;{{ $ticket->alamat_lokasi }}, {{ $ticket->kota }}</p>
                @if ($ticket->start_date != null)
                <p class="fs-5">Tanggal : &nbsp;{{ $ticket->start_date }}</p>
                @endif
                <p class="fs-5">Jam : &nbsp;{{ $ticket->start_time }} - {{ $ticket->end_time }}</p>
                @if (session()->has('message'))        
                <p style="margin:0; color:green">{{ session('message') }}</p>
                @elseif (session()->has('error'))
                    <p style="margin:0; color:red">{{ session('error') }}</p>
                @endif 
                <div style="" class="d-flex">
                    <p style="margin:0" class="form-label mt-2">Promo Code (optional)</p>

                    <form action="{{ route('apply.promo',['id'=>$ticket->id_tiket]) }}" method="post">
                        @csrf
                        <div class="d-flex">                        
                            <input name="promo" class="form-control mx-2" type="text" value="{{ old('promo') }}" style="width: 100%" id="promo" placeholder="enter promo code">
                            <button type="submit" class="btn btn-primary">Use</button>
                        </div>
                    </form>
                    
                </div><br>
                <div class="d-flex" style="">
                    <p class=" me-3 mb-4">Jumlah :</p><br>
                    <input type="hidden" id="satuan" name="satuan" value="{{ $ticket->harga }}">
                    <input  onchange="quantityChange()" class="form-control" style="width:70px; height:35px;" type="number" id="quantity" name="quantity" value="1" min="1">
                </div>
                <input class="form-check-input" type="checkbox" value="" onchange="handleChange()" id="pointCheck">
                <label class="form-check-label" for="pointCheck">
                  <span id="" class="ms-2">Use Points ( <span id="poin">{{ session('user')->poin }}</span> )</span> 
                </label>
                <br><br>
                @if (session()->has('potongan'))     
                    <p>Potongan Promo : Rp. <span id="deduction">{{ formatUang(intval(session('potongan'))) }}</span></p>               
                @else
                    <p>Potongan Promo : <span id="deduction">0</span></p>
                @endif
                    <p  class="fs-5 fw-bold">Total (belum termasuk promo) : Rp. <span class="fs-5" id="total">{{ formatUang($ticket->harga) }}</span></p>
                {{-- redirect to midtrans after checkout button pressed --}}
                <form action="{{ route('pay',['id'=>$ticket->id_tiket]) }}" method="post">
                    @csrf
                    <input id="hiddenPromo" type="hidden" name="hiddenPromo" value="{{ session()->has('potongan') ? intval(session('potongan')) : 0 }}">
                    <input id="hiddenTotal" type="hidden" name="hiddenTotal" value="{{ $ticket->harga }}">
                    <input id="promoCode" type="hidden" name="promoCode" value="{{ session()->has('kodepromo') ? session('kodepromo') : null }}">
                    <input id="hiddenQty" type="hidden" name="hiddenQty" value="1">
                    {{-- btn col-12 supaya bisa full width --}}
                    <button type="submit" class="mt-5 btn col-12 btn-success">Checkout</button>
                </form>
            </div>
        </div>
        <script>
            function quantityChange(){
                let hiddenTotal = document.getElementById("hiddenTotal");
                let hiddenQty = document.getElementById("hiddenQty");

                // alert(hiddenTotal.value); //value sebelum diubah
                let quantity = parseInt(document.getElementById("quantity").value);
                hiddenQty.value = quantity;
                let totalSpan = document.getElementById("total");
                let hargaSatuan = document.getElementById("satuan").value;
                let pointCheck = document.getElementById("pointCheck");
                pointCheck.checked = false; //setiap quantity ditambah reset checkbox point               
                let newTotal = parseInt(hargaSatuan) * quantity;
                totalSpan.innerHTML = newTotal;
                hiddenTotal.value = newTotal; //yang akan dikirim ke midtrans saat checkout ditekan
                
            }
            function handleChange(){
                let hiddenTotal = document.getElementById("hiddenTotal");
                let pointCheck = document.getElementById("pointCheck");
                let currentPoint = document.getElementById("poin").innerHTML;
                let totalSpan = document.getElementById("total");
                let currentValue = parseInt(totalSpan.innerHTML);
                if(pointCheck.checked){
                    // alert(currentPoint);
                    //deduct total 
                    currentValue -= parseInt(currentPoint);
                }else{
                    currentValue += parseInt(currentPoint);
                }
                totalSpan.innerHTML = currentValue; //update total value
                hiddenTotal.value = currentValue;
            }
        </script>
    @endsection
@else
    <script>window.location = "{{ route('login') }}";</script>
@endif