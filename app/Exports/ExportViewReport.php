<?php

namespace App\Exports;

use App\Models\Tiket;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class ExportViewReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $allTickets = Tiket::where('id_penjual',session('user')->id_penjual)->get();
        return view('viewReportTable',compact('allTickets'));
    }
}
