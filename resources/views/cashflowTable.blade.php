@php
    use Carbon\Carbon; //supaya bisa format date
@endphp
<table id="myTable" class="table table-light table-striped" style="width: 82%">
    <thead>
        <tr class="">
            <th class="py-2" style="  width:10%; padding-left:10px">No</th>
            <th style="width:20%;padding-left:10px">Tanggal</th>
            <th style="width:25%;padding-left:10px; text-align:center;">Total Pemasukan</th>
            <th style="text-align:center;width:20%;padding-left:10px">Tiket Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tempCashflows as $index => $ticket)
            <tr>
                <td class="py-2" style="padding-left:10px">{{ $index+1 }}</td>
                <td style="padding-left:10px">{{ Carbon::createFromFormat('Y-m-d', $ticket['tanggal'])->format('d-F-Y'); }}</td>
                <td style="text-align: center">Rp. {{ formatUang($ticket['total_pemasukan']) }}</td>
                <td style="text-align: center">{{ $ticket['tiket_terjual'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="">Total:</th>
            <th></th>
            <th class="text-center" id="nilaiTotal">Rp. 0</th>
            <th></th>
        </tr>
    </tfoot>
</table>