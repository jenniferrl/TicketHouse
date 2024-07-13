<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('font/font/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>

    <title>Checkout</title>
</head>
<body>
  <div style="" class="fixed-top Navbar d-flex justify-content-between bg-light container-fluid pt-3 shadow p-3 mb-5 navbar-expand-lg">
    <div class="WebLogo">
        <span class="fw-bold" style="font-size:23px; cursor:pointer;"><a href="/home" class="nav-link">🎟️Ticket House</a></span>
    </div>
  </div>
    <div style="min-height:350px" class="d-flex pt-5 mt-5 justify-content-center">
        <div style="text-align:center;width:300px; height:50% ;border: 1px solid black; border-radius:10px; padding:15px 20px;">
            <h2>{{ $order->id_invoice }}</h2>
            <p>Nama Tiket : {{ $namaTiket }}</p>
            <p>Quantity : {{ $order->quantity }}</p>
            <p>Total : Rp {{ formatUang($order->total) }}</p>
            <button style="width: 70%" class="btn btn-success" id="pay-button">Pay</button>
        </div>
        
    </div>
    {{-- footer --}}
    <div class="Footer position-relative bottom-0 py-3 ps-4 container-fluid d-flex justify-content-between" style="background-color: #F1F8FF; ">
      <div class="Kiri " >
          <span class="fw-bold" style="font-size: 21px">🎟️Ticket House</span>
          <p style="font-size: 14px">Ticket House adalah website yang memfasilitasi orang yang <br>ingin melakukan jual beli tiket. Tersedia berbagai pilihan tiket <br>tempat wisata dan seminar. Tersedia pula promo-promo <br>menarik yang tidak boleh dilewatkan.</p>
      </div>
      <div class="kanan  pe-4" style="width: 180px">
          <p class="fw-bold ms-4" style="font-size: 21px">Contact Us</p>
          <div class="d-flex justify-content-evenly">
              <a href="" style="text-decoration: none; color:inherit;"><i class="fa-brands fa-meta fa-xl"></i></a>
              <a href="" style="text-decoration: none; color:inherit;"><i class="fa-brands fa-x-twitter fa-xl"></i></a>
              <a href="" style="text-decoration: none; color:inherit;"><i class="fa-brands fa-instagram fa-xl"></i></a>
          </div>
  
  
      </div>
    </div>
    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            alert("payment success!"); window.location.href = "/afterPay";
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); 
            window.location.href = "/home";
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
            window.location.href = "/home";
          }
        })
      });
    </script>
</body>
</html>