@php
    use Carbon\Carbon; //supaya bisa format date
@endphp
<table id="myTable" class="table table-light table-striped" style="width: 82%">
    <thead>
        <tr class="bg-light" style=" ">
            <th class="py-2" style="width:10%; padding-left:10px">ID</th>
            <th style="width:30%;padding-left:10px">Nama</th>
            <th style="width:20%;padding-left:10px; text-align:center;">Nominal Total</th>
            <th style="text-align:center;width:20%;padding-left:10px">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tempTickets as $index => $ticket)
        <tr>
            <td class="py-2" style="padding-left:10px">{{ $ticket['id_invoice'] }}</td>
            <td style="padding-left:10px">{{ $ticket['nama'] }}</td>
            <td style="text-align: center">Rp. {{ formatUang($ticket['total']) }}</td>
            <td style="text-align: center">{{ Carbon::createFromFormat('Y-m-d', $ticket['tanggal_pembelian'])->format('d-F-Y'); }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="">Total:</th>
            <th></th>
            <th class="text-center" id="nilaiTotal">Rp. 0</th>
            <th id="totalSold"></th>
        </tr>
    </tfoot>
</table>