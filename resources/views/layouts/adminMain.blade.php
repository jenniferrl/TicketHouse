<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('font/font/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <title>{{ $title }}</title>
</head>
<style>
  .content {
    padding: 20px;   
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
  /* tabel untuk master admin agak berbeda (tidak pake tombol export) */
  #myTable2_wrapper{
      width: 100%;
  }
  #myTable2_filter, #myTable2_length{
      margin-bottom: 2%;
      margin-top: 2%;
  }
  #myTable2_paginate, .dataTables_info{
      margin-top: 1%;
      margin-bottom: 2%;
  }
.content h1 {
  font-size: 24px;
  margin-top: 100px;    
  margin-left: 100px;
}

.sidebarMenu:hover{
  background-color: #FDD991;
}

.sidebarMainMenu:hover{
  background-color: #FD9191;
}


</style>
<body>
{{-- navbar dijadikan komponen terpisah di file partials/navbar. Cara panggil komponen pake @include(namafolder.namafile) --}}
    @include('partials.adminNavbar')
    @include('partials.adminSidebar')

    <div class="container-fluid" style="overflow:hidden;">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
            $('#myTable2').DataTable({
            });
            
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
                            .column(3)
                            .data()
                            .reduce((a, b) => ubah(a) + ubah(b), 0);
                        let pageTotal = api
                            .column(3, { page: 'current' })
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
                        { 
                            extend: 'excelHtml5',
                            footer: true,
                            // customizeData: function (excelData) { //not work
                            //     // Add logo to the Excel header using data URL
                            //     excelData.header.unshift([{
                            //         image: dataURL,
                            //         width: 50, // adjust width as needed
                            //         alignment: 'left'
                            //     }]);
                            // }
                        }                    
                    ],         
                });
            });
            $('#myTable').css("width","100%");
        } );
    </script>
</body>
</html>