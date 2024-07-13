<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Testing for Social share">
    <meta property="og:description" content="Description of your ticket">
    <meta property="og:image" content="URL_to_an_image">
    <meta property="fb:app_id" content="863164778768127" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('font/font/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        #loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Ensure it appears above other elements */
        }
        .notifmenu:hover{
            background-color: lightgray;
        }
        #myTable3_wrapper{
      width: 100%;
  }
  #myTable3_filter, #myTable3_length{
      margin-bottom: 2%;
      margin-top: 2%;
  }
  #myTable3_paginate, .dataTables_info{
      margin-top: 1%;
      margin-bottom: 2%;
  }
    </style>
    <title>{{ $title }}</title>
</head>
<body>
    
    <div id="loader">
        <div class="wrapper d-flex justify-content-center" style="padding-top: 10%">
            <img style="width:500px;" src="{{ asset('images/loader2.gif') }}" alt="Loader">
        </div>
    </div>
    {{-- navbar dijadikan komponen terpisah di file partials/navbar. Cara panggil komponen pake @include(namafolder.namafile) --}}
    @include('partials.navbar')
    <div class="container-fluid" style="">
        @yield('content')
    </div>
    @include('partials.footer')
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0&appId=863164778768127" nonce="YOUR_RANDOM_NONCE"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable3').DataTable({
                "order": [[0, "desc"]]
            });
            $('#myTable').DataTable({
                dom:  '<"top"lf>rt<"bottom"Bpi>',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5'
                ],         
            });
            $('#myTable').css("width","100%");
        } );
    </script>
</body>
</html>