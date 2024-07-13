<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unfinished;
class UnfinishedController extends Controller
{
    public function unfinished(){//menampilkan semua unfinished transaction
        $title = "Waiting for payment";
        return view('unfinishedPayment',compact('title'));
    }
    public function resume($id){
        $data = Unfinished::where('id',$id)->first();
        $snapToken = json_decode($data->snap_token);
        $order = json_decode($data->order);
        $namaTiket = $data->nama_tiket;
        //ubah dulu id invoice yang tersimpan di session('id_invoice') supaya status bisa terupdate
        session(['id_invoice'=>$order->id_invoice]);
        return view('cobaCheckout',compact('snapToken','order','namaTiket'));
    }
}
