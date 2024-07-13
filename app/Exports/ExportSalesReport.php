<?php

namespace App\Exports;

use App\Models\Tiket;
use App\Models\Pembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSalesReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $allTickets = Tiket::where('id_penjual',session('user')->id_penjual)->get();
        $purchases = Pembelian::all();
        $tempTickets = [];
        foreach($purchases as $p){
            foreach ($allTickets as $ticket) {
                if ($p->id_tiket == $ticket->id_tiket){
                    //buat object dengan attribute yang diperlukan untuk ditampilkan di report
                    $tempData = [
                        'id_invoice'=>$p->id_invoice,
                        'nama'=>$ticket->nama,
                        'total'=>$p->total,
                        'tanggal_pembelian'=>$p->tanggal_pembelian,
                    ];                    
                    array_push($tempTickets,$tempData);
                    //cara akses elemennya di salesReport.blade tidak bisa pake $ticket->id_tiket, tapi harus $ticket['id_tiket']
                }                
            }
        }
        return view('salesReportTable',compact('tempTickets'));
    }
}
