@extends('layouts.sellerMain')
@section('content')
    <div class="container" style="min-height: 580px; padding-top:100px; margin-left: 250px;">
        @if(session('message')) 
            <div style="width: 500px" class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif 
        <h2 class="fw-bold" style="margin-left: 20px;">Dashboard</h2>
        <a href="/addPromo"><button type="button" class="btn" style="width: 200px; height: 40px; background-color: #0C9509; color: white;">Buat Kode Promo</button></a>
        <div class="Statistik text-center mt-3 mb-4" style="font-size: 14px; width:850px; min-height:300px;">
            <div class="row d-flex" style="min-height: 100px">
                <div class="col-md-7">
                    <div class="row kecil-atas">
                        <div style="border-radius:10px;background-color: rgb(160, 251, 160);" class="col-md-5 me-2 shadow pt-3 h-75 Kiri">
                            <p class="fw-bold">Jumlah Tiket Terjual (all time)</p>
                            <p>{{ $ticketSold }}</p>
                        </div>
                        <div style="background-color: rgb(160, 251, 160); border-radius:10px;" class="col-md-5 me-2 shadow pt-3 h-75 Kanan">
                            <p class="fw-bold">Total View Tiket (all time)</p>
                            <p>{{ $totalView }}</p>
                        </div>
                    </div>
                    <div class="row mt-4 kecil-bawah">
                        <div class="col-md-10 me-2 shadow pt-3 h-75" style="border-radius:10px;background-color: rgb(160, 251, 160);">
                            <p class="fw-bold" style="">Total Penghasilan (all time)</p>
                            <p>Rp. {{ formatUang($totalRevenue) }}</p>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <canvas id="soldTiketChart"></canvas>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-start">
                <div class="col-md-4">
                    <canvas id="mostViewTiketChart"></canvas>
                </div>
                <div class="col-md-8">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        //income chart in past 7 days
        let incomeChart = document.getElementById('incomeChart').getContext('2d');
        
        let pastIncome = @json($pastIncome);//receive data from controller
        // console.log(pastIncome);
        let countData = [];
        let dateData = [];
        pastIncome.map((t)=>{
            dateData.push(t.date);
            countData.push(t.count);
        });
        // console.log(countData);
        // console.log(Object.values(pastTransaction)[0].date);
        let totalIncomeChart = new Chart(incomeChart, {
            type: 'line',
            data: {
                labels: dateData,
                datasets: [{
                    label: 'Last 7 Days Revenue (Rp)',
                    data: countData,
                    backgroundColor: 'rgba(7, 148, 80, 1)',
                    borderColor: 'rgba(7, 148, 80, 1)',
                    borderWidth: 1,
                    tension: 0.3
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

        //sold ticket chart
        let soldTiketChart = document.getElementById('soldTiketChart').getContext('2d');

        const seminar = @json($soldSeminarTiket);//receive data
        const place = @json($soldPlaceTiket);//receive data
        // console.log(seminar[0].total);
        // console.log(seminar);
        let jumTiketSeminar = 0;
        let jumTiketPlace = 0;
        if(seminar.length != 0){
            jumTiketSeminar = seminar[0].total;
        }
        if(place.length != 0){
            jumTiketPlace = place[0].total; 
        }

        let soldTicketChart = new Chart(soldTiketChart, {
            type: 'doughnut',
            data: {
                labels: ["Place", "Seminar"],
                datasets: [{
                    label: "Jumlah Tiket Terjual",
                    data: [jumTiketPlace, jumTiketSeminar],//insert data to display
                    backgroundColor: ['rgb(237, 7, 7)', 'rgb(17, 150, 5)'],
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
                        text: 'Tiket Terjual per Kategori'
                    }
                }
            }
        });

        //Most viewed ticket (Top 5)
        let mostViewTiketChart = document.getElementById('mostViewTiketChart').getContext('2d');
        let mostViewedTicket = @json($mostViewedTicket);
        // console.log(mostViewedTicket);

        let viewData = [];
        let ticketData = [];
        mostViewedTicket.map((t)=>{
            if(t.totalView != 0){ //if the ticket still 0 view don't show the ticket
                ticketData.push(t.namaTiket);
                viewData.push(t.totalView);
            }
        })

        let topViewTicketChart = new Chart(mostViewTiketChart, {
            type: 'doughnut',
            data: {
                labels: ticketData,
                datasets: [{
                    label: "Total View",
                    data: viewData,//insert data to display
                    backgroundColor: ['rgb(237, 7, 7)', 'rgb(17, 150, 5)', 'rgb(240, 228, 10)', 'rgb(2, 170, 247)', 'rgb(247, 141, 2)'],
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
                        text: 'Tiket yang Paling Banyak Dilihat'
                    }
                }
            }
        });


    </script>
@endsection