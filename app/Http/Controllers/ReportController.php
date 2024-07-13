<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
class ReportController extends Controller
{
    public function processReport(Request $request, $id){
        //check if user has logged in or not
        if(session('user')){
            //get information from textarea in the modal
            $inputValue = $request->input('reportText');
            //make activity id for the report
            $ctr = Report::count()+1;
            $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
            $newActivityId = "RP".$numberWithLeadingZeros;
            $id_user = session('user')->id_pembeli;
            $id_penjual = $id;
            Report::create([
                'id_aktivitas'=>$newActivityId,
                'id_penjual'=>$id_penjual,
                'id_pembeli'=>$id_user,
                'keterangan'=>$inputValue,
            ]);
    
            //redirect after successfully report
            return redirect('/home')->with('message','Report successful');
        }else return redirect('/login')->with('loginError','Silahkan login terlebih dahulu');
    }
}
