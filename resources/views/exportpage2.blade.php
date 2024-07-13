<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Laporan Penjualan</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center">
        <table>
            <tr>
                <th>Laporan Penjualan</th>
            </tr>
            <tr class="" style=" background-color: #3aaaff; color:white">
                <th class="py-2" style=" width:100px; padding-left:10px">ID</th>
                <th style="width:250px;padding-left:10px">Nama</th>
                <th style="width:200px;padding-left:10px; text-align:center;">Nominal Total</th>
                <th style="text-align:center;width:100px;padding-left:10px">Tanggal</th>
            </tr>
            @foreach ($tempTickets as $index => $ticket)
                <tr style="background-color: {{ $index%2==0 ? 'white' : 'lightblue' }};">
                    <td class="py-2" style="padding-left:10px">{{ $ticket['id_invoice'] }}</td>
                    <td style="padding-left:10px">{{ $ticket['nama'] }}</td>
                    <td style="text-align: center">Rp. {{ formatUang($ticket['total']) }}</td>
                    <td style="text-align: center">{{ $ticket['tanggal_pembelian'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>