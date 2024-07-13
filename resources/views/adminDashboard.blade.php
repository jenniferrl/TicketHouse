@if (session('admin') == "admin")
{{-- layout.adminMain untuk ambil komponen navbar dan sidebar admin --}}
    @extends('layouts.adminMain')
    @section('content')
    <div class="container" style=" min-height: 580px; padding-top:80px; padding-left: 20%">
            <div class="row" id="statistikAtas">
                <div class="col-md-12">
                    <h2 class="mb-3">Dashboard</h2>
                    <div class="row d-flex justify-content-between mb-4" id="rowSatu">
                        <div class="col-md-2 text-center mx-1 p-2 rounded-4 shadow" style="background-color: rgb(160, 251, 160);">
                            <p class="fw-bold">Jumlah Transaksi (all time)</p>
                            <p class="fs-5">{{ $totalPembelian }}</p>
                        </div>
                        <div class="col-md-2 text-center mx-2 p-2 rounded-4 shadow" style="background-color: rgb(160, 251, 160);">
                            <p class="fw-bold">Jumlah Tiket <br> (all time)</p>
                            <p class="fs-5">{{ $totalTiket }}</p>
                        </div>
                        <div class="col-md-2 text-center mx-2 p-2 rounded-4 shadow" style="background-color: rgb(160, 251, 160);">
                            <p class="fw-bold">Total View <br> (all time)</p>
                            <p class="fs-5">{{ $totalView }}</p>
                        </div>
                        <div class="col-md-2 text-center mx-2 p-2 rounded-4 shadow" style="background-color: rgb(160, 251, 160);">
                            <p class="fw-bold">Jumlah Pembeli <br>(all time)</p>
                            <p class="fs-5">{{ $totalPembeli }}</p>
                        </div>
                        <div class="col-md-2 text-center mx-2 p-2 rounded-4 shadow" style="background-color: rgb(160, 251, 160);">
                            <p class="fw-bold">Jumlah Penjual <br>(all time)</p>
                            <p class="fs-5">{{ $totalPenjual }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2 ps-1" id="statistikBawah">
                <div class="col-md-8">
                    <canvas id="transactionChart"></canvas>
                </div>
                <div class="col-md-4">
                    <canvas id="ticketPieChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        
        <script>
            //pembelian chart
            let transactionChart = document.getElementById('transactionChart').getContext('2d');
            
            let pastTransaction = @json($transactionCounts);//receive data from controller
            // console.log(pastTransaction);
            let countData = [];
            let dateData = [];
            pastTransaction.map((t)=>{
                dateData.push(t.date);
                countData.push(t.count);
            });
            // console.log(countData);
            // console.log(Object.values(pastTransaction)[0].date);
            let firstChart = new Chart(transactionChart, {
                type: 'line',
                data: {
                    labels: dateData,
                    datasets: [{
                        label: 'Last 7 Days Transactions',
                        data: countData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            grid: {
                                display: false  // Set display property to false to hide the grid lines
                            }
                        }
                    }
                }
            });

            //ticket chart
            let ticketChart = document.getElementById('ticketPieChart').getContext('2d');
            
            const seminar = @json($seminarCount);//receive data
            const place = @json($placeCount);//receive data
            let jumSeminar = 0;
            let jumPlace = 0;
        
            if(seminar.length != 0){
                jumSeminar = seminar[0].count;
            }
            if(place.length != 0){
                jumPlace = place[0].count; 
            }
            // console.log(seminar);
            let secondChart = new Chart(ticketChart, {
                type: 'doughnut',
                data: {
                    labels: ["Place", "Seminar"],
                    datasets: [{
                        label: "Jumlah Tiket",
                        data: [jumPlace, jumSeminar],//insert data to display
                        backgroundColor: ['rgb(245, 97, 17)', 'rgb(3, 188, 255)'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Tiket per Kategori'
                        }
                    }
                }
            });

        </script>
    @endsection
@else
    {{-- redirect to admin login page if hasn't logged in --}}
    <script>window.location = "{{ route('login.admin') }}";</script>
@endif
<script>

    // document.addEventListener('DOMContentLoaded', function() {
    //     var transactionChart = document.getElementById('transactionChart').getContext('2d');
    //     var ticketChart = document.getElementById('ticketPieChart').getContext('2d');
        
    //     var myChart = new Chart(transactionChart, {
    //         type: 'line',
    //         data: {
    //             labels: ['Today', 'Yesterday', 'Today'],
    //             datasets: [{
    //                 label: 'Last 7 Days Transactions',
    //                 data: [1,20,300],
    //                 backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //                 borderColor: 'rgba(75, 192, 192, 1)',
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             scales: {
    //                 y: {
    //                     beginAtZero: true,
    //                 },
    //                 x: {
    //                     grid: {
    //                         display: false  // Set display property to false to hide the grid lines
    //                     }
    //                 }
    //             }
    //         }
    //     });



    // });
    
</script>

