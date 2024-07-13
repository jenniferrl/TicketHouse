<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //supaya bisa pake Rule::
class PromoController extends Controller
{
    public function showAddPromo(){
        //show add ticket page
        return view('addPromo',[
            "title" => "Tambah Kode Promo",
        ]);
    }

    public function store(Request $request){
        $rules = [
            'kodePromo' => [
                'required','string','max:255',Rule::unique('promos','kode_promo')->whereNull('deleted_at'),
            ],
            'min-purchase' => 'required|integer|gte:0',
            'nilaiPromo' => 'required|integer|gt:0',
            'tipe'=> 'required|in:Persen,Non Persen',
        ];
        //Additional validation for promo in percent
        if($request->input('tipe') == "Persen"){
            $rules['nilaiPromo'] = [
                'required',
                'integer',
                'gt:0',
                'lte: 100',
            ];
        }else{
            $rules['nilaiPromo'] = [
                'required',
                'integer',
                'gt:0'
            ];
        }
        $request->validate($rules);

        //generate new ID
        $ctr = Promo::withTrashed()->count()+1; //hitung ada berapa tiket di DB +1
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
        $promoId = 'PR'.$numberWithLeadingZeros;
        $getPenjual = Penjual::where('username', session('user')->username)->first();
        $idPenjual = $getPenjual->id_penjual;
        $kode_promo = $request->input('kodePromo');
        $nilai_promo = $request->input('nilaiPromo');
        $min_purchase = $request->input('min-purchase');
        $tipe = $request->input('tipe');
        Promo::create([
            'id_kodepromo'=>$promoId,
            'id_penjual'=>$idPenjual,
            'kode_promo'=>$kode_promo,
            'min_purchase'=>$min_purchase,
            'nilai_promo'=>$nilai_promo,
            'tipe'=>$tipe,
        ]);
        //sementara redirect ke dashbord setelah add
        return redirect('/dashboard')->with('message','Successfully added new promo code');
    }
}
