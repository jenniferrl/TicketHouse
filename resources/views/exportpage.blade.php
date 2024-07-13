<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Laporan View Tiket</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center">
        <table>
            <tr class="">
                <th>Laporan View</th>
            </tr>
            <tr class="" style=" background-color: #3aaaff; color:white">
                <th class="py-2" style="  width:100px; padding-left:10px">ID</th>
                <th style="width:400px;padding-left:10px">Nama</th>
                <th style="text-align:center;width:100px;padding-left:10px">Jumlah View</th>
            </tr>
            @foreach ($allTickets as $index => $ticket)
                <tr style="background-color: {{ $index%2==0 ? 'white' : 'lightblue' }};">
                    <td class="py-2" style="padding-left:10px">{{ $ticket->id_tiket }}</td>
                    <td style="padding-left:10px">{{ $ticket->nama }}</td>
                    <td style="text-align: center">{{ $ticket->jumlah_view }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>