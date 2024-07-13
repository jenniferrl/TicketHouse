<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Laporan Cashflow</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center">
        <table>
            <tr>
                <th>Laporan Cashflow</th>
            </tr>
            <tr class="" style=" background-color: #3aaaff; color:white">
                <th class="py-2" style="  width:50px; padding-left:10px">No</th>
                <th style="width:200px;padding-left:10px">Tanggal</th>
                <th style="width:200px;padding-left:10px; text-align:center;">Total Pemasukan</th>
                <th style="text-align:center;width:200px;padding-left:10px">Tiket Terjual</th>
            </tr>
            @foreach ($tempCashflows as $index => $ticket)
                <tr style="background-color: {{ $index%2==0 ? 'white' : 'lightblue' }};">
                    <td class="py-2" style="padding-left:10px">{{ $index+1 }}</td>
                    <td style="padding-left:10px">{{ $ticket['tanggal'] }}</td>
                    <td style="text-align: center">Rp. {{ formatUang($ticket['total_pemasukan']) }}</td>
                    <td style="text-align: center">{{ $ticket['tiket_terjual'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>