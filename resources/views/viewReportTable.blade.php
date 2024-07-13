<table id="myTable" class="me-3 table table-light table-striped" style="width:82%">
    <thead>
        <tr class="">
            <th class="py-2" style="  width:10%; padding-left:10px">ID</th>
            <th class="" style="width:20%;padding-left:10px">Nama</th>
            <th style="text-align:center;width:20%;padding-left:10px">Jumlah View</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($allTickets as $index => $ticket)
            <tr>
                <td class="py-2" style="padding-left:10px">{{ $ticket->id_tiket }}</td>
                <td style="padding-left:10px">{{ $ticket->nama }}</td>
                <td style="text-align: center">{{ $ticket->jumlah_view }}</td>
            </tr>
        @endforeach
    </tbody>
</table>