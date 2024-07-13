<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli;
class ImageController extends Controller
{
    public function show(){
        return view('buyerProfile');
    }

    public function update(Request $request){
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->hasFile('profile_picture')){
            $file = $request->file('profile_picture');
            $pembeli = Pembeli::where('id_pembeli',session('user')->id_pembeli)->first();  
            $originalName = $pembeli->id_pembeli . 'PROFILE.'. $file->extension();
            $file->move(public_path('images'), $originalName); //store di folder
            
            $newNama = $request->input('nama');
            $newGender = $request->input('gender');
            $newTelp = $request->input('no_telp');
            $newDob = $request->input('dob');

            //update data di db
            Pembeli::where('id_pembeli',session('user')->id_pembeli)->update([
                'profile_picture'=>$originalName,
                'name'=>$newNama,
                'no_telp'=>$newTelp,
                'jk'=>$newGender,
                'tgl_lahir'=>$newDob,
            ]);
            return redirect('/home')->with('message','berhasil edit profil');
        }else return redirect('/home')->with('message','Gagal edit');
    }
}
