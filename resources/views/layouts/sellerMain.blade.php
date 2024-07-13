<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    {{-- untuk impor font awesome icons --}}
    <link rel="stylesheet" href="{{ asset('font/font/css/all.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        td{
            padding-top: 5px; 
            padding-bottom: 5px; 
        }
        #myTable_wrapper{
            width: 82%;
        }
        #myTable_filter, #myTable_length{
            margin-bottom: 2%;
            margin-top: 2%;
        }
        #myTable_paginate, .dt-buttons{
            margin-top: 2%;
        }
    </style>
    <title>{{ $title }}</title>
</head>
<body>
    {{-- navbar dijadikan komponen terpisah di file partials/navbar. Cara panggil komponen pake @include(namafolder.namafile) --}}
    @include('partials.sellerNavbar')
    @include('partials.sellerSidebar')

    <div class="container-fluid" style="overflow:hidden;">
        @yield('content')
        @yield('profile')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script>
        function formatCurrencyIDR(number) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });

            return formatter.format(number);
        }
        function convertImageToDataURL(url, callback) {
                let img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function () {
                    let canvas = document.createElement('canvas');
                    let ctx = canvas.getContext('2d');
                    canvas.height = img.height;
                    canvas.width = img.width;
                    ctx.drawImage(img, 0, 0);
                    let dataURL = canvas.toDataURL('image/png');
                    callback(dataURL);
                };
                img.src = url;
        }

        $(document).ready( function () {
            $('#myTable').css("width","100%");
            convertImageToDataURL('../../images/logo/ticketHouse.png', function (dataURL) {
                $('#myTable').DataTable({
                    dom:  '<"top"Bf>rt<"bottom"lpi>',
                    footerCallback : function (row, data, start, end, display){
                        let api = this.api();
                        //convert formatted string (Rp. 100000 etc) to integer
                        let ubah = function(i){
                            return typeof i === 'string'
                            ? i.replace(/[\$Rp.,]/g, '') * 1
                            : i;
                        }   
                                
                        // Total over all pages
                        let total = api
                            .column(2)
                            .data()
                            .reduce((a, b) => ubah(a) + ubah(b), 0);
                        let pageTotal = api
                            .column(2, { page: 'current' })
                            .data()
                            .reduce((a, b) => ubah(a) + ubah(b), 0);

                        $('#nilaiTotal').html(formatCurrencyIDR(pageTotal));
                    },
                    buttons: [
                        { 
                            extend: 'pdfHtml5',
                            footer: true,
                            customize: function(doc) {
                                // Add company information to the PDF header
                                doc.header = function () {
                                    return {
                                        columns: [
                                            {
                                                image: dataURL,  // Adjust the path to your logo
                                                width: 150,
                                                alignment: 'left',
                                                margin: [0, 0]
                                            },
                                            // {
                                            //     text: 'Ticket House',
                                            //     alignment: 'left',
                                            //     margin: [150, 30],
                                            // }
                                        ],
                                        margin: [10, 0],
                                        fontSize: 12
                                    };
                                };

                            }
                        },
                        { extend: 'excelHtml5', footer: true }                    
                    ],     
                });
            });
        } );
    </script>
</body>
</html>