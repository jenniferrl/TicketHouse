<?php

namespace App\Exports;

use App\Models\Tiket;
use App\Models\Pembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCashflowReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $allTickets = Tiket::where('id_penjual',session('user')->id_penjual)->get();
        $purchases = Pembelian::all();
        //kelompokkan berdasarkan tanggal
        $groupedInvoices = $purchases->groupBy(function ($invoice) {
            return $invoice->tanggal_pembelian;
        });
        $sortedGroupedInvoices = $groupedInvoices->sortBy(function ($invoicesPerDate, $createdDate) {
            return strtotime($createdDate); // Convert date string to timestamp for sorting
        });
        $tempCashflows = [];
        foreach($sortedGroupedInvoices as $invoiceDate => $invoicesPerDate){
            $tanggal = $invoiceDate;
            $total=0; //total pemasukan di tiap tanggal
            $ticketSold=0;
            foreach($invoicesPerDate as $i){
                //kumpulan dari invoice di tiap tanggal
                //sebelum di increment, pastikan dulu invoice ini adalah dari tiket milik penjual yg login
                foreach($allTickets as $a){
                    if ($a->id_tiket == $i->id_tiket){
                        $total+=$i->total; //increment total pemasukan
                        $ticketSold+=$i->quantity; //total tiket yang terjual di tanggal tertentu      
                        break;          
                    }
                }
            }
            if ($total>0 && $ticketSold>0){
                $tempData = [
                    "tanggal"=>$tanggal,
                    "total_pemasukan"=>$total,
                    "tiket_terjual"=>$ticketSold,
                ];
                array_push($tempCashflows,$tempData);
            }
        }
        return view('cashflowTable',compact('tempCashflows'));
    }
}
