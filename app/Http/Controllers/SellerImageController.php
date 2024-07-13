<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Penjual;
class SellerImageController extends Controller
{
    public function show(){
        return view('sellerProfile');
    }

    public function update(Request $request){
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->hasFile('profile_picture')){
            $file = $request->file('profile_picture');
            $penjual = Penjual::where('id_penjual', session('user')->id_penjual)->first();
            $originalName = $penjual->id_penjual . 'PROFILE.'. $file->extension();
            $file->move(public_path('images'), $originalName);

            $newNama = $request->input('nama');
            $newGender = $request->input('gender');
            $newTelp = $request->input('no_telp');
            $newDob = $request->input('dob');

            Penjual::where('id_penjual',session('user')->id_penjual)->update([
                'profile_picture' => $originalName,
                'name' => $newNama,
                'no_telp' => $newTelp,
                'jk' => $newGender,
                'tgl_lahir' => $newDob
            ]);
            return redirect('/dashboard')->with('message','berhasil edit profil');
        }else return redirect('/dashboard')->with('message','Gagal edit');
    }
}
