<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pembeli;
use App\Models\Penjual;
use Illuminate\Validation\Rule; //supaya bisa pake Rule::
class RegisterController extends Controller
{
    public function index(){
        //tampilkan halaman register
        return view('register',[
            "title" => "Register",
        ]);
    }

    public function store(Request $request){
        //return request()->all(); //tampilkan semua data yg diisikan di form
        //alternatif dari request(), bisa diisikan di parameter store(Request $request)
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:buyer,seller',
            'no_telp' => 'required|string',
            'gender'=> 'required',
            'password'=> 'required|string|confirmed',
            'dob'=> 'required',

        ];
        $selectedRole = $request->input('role');
        
        if ($selectedRole === 'buyer') {
            $rules['email'] = [
                'required',
                'string',
                'email:dns',
                'max:255',
                Rule::unique('pembelis'), 
            ];
            $rules['username'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('pembelis'), //username unik dari tabel pembelis
            ];
        }
        else{ //register sebagai penjual
            $rules['email'] = [
                'required',
                'string',
                'email:dns',
                'max:255',
                Rule::unique('penjuals'), // Example unique email validation rule
            ];
            $rules['username'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('penjuals'), //username unik dari tabel penjuals
            ];
        }
         $request->validate($rules);
        //dd untuk cek validasi berhasil/ga. Kalo berhasil akan ditampilkan isi dari dd, kalo ngga seolah hanya refresh form
        // dd('sukses'); 
        //kalau dd dijalankan, semua syntax di bawahnya tidak akan tereksekusi
        // Pembeli::create($validatedData);
        $refferal = $request->input('refferal');
        $poin = 0;
        if ($refferal!=null){
            $cek = Pembeli::where('refferal',$refferal)->first();
            if($cek){
                $poin = 1000;
            }
        }
        //buat random id dan refferal untuk create Pembeli
        if ($selectedRole === "buyer"){
            $ctr = Pembeli::count()+1; //hitung ada berapa pembeli di DB +1
            $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
            $reff = 'REF'.$numberWithLeadingZeros; //buat refferal dengan format REF+numberleadingzeros
            //cek kalo masukin kode reff

            Pembeli::create([
                'id_pembeli' => 'PB'.$numberWithLeadingZeros,
                'username'=> $request->input('username'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'no_telp' => $request->input('no_telp'),
                'jk' => $request->input('gender'),
                'password' => bcrypt($request->input('password')),
                'poin' =>$poin,
                'profile_picture'=>null,
                'tgl_lahir'=> $request->input('dob'),
                'refferal'=> $reff,
                'joined_at'=> Carbon::today('Asia/Jakarta')
            ]);
        }else{
            $ctr = Penjual::count()+1; //hitung ada berapa penjual di DB +1
            $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
            //saldo dan premium status dibuat secara default di migration, jadi ngga masuk create
            Penjual::create([
                'id_penjual' => 'PJ'.$numberWithLeadingZeros,
                'username'=> $request->input('username'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'no_telp' => $request->input('no_telp'),
                'jk' => $request->input('gender'),
                'password' => bcrypt($request->input('password')),
                'profile_picture'=>null,
                'tgl_lahir'=> $request->input('dob'),
                'joined_at'=> Carbon::today('Asia/Jakarta')
            ]);
        }
        return redirect('/login')->with('success','Berhasil register! Silahkan login');
    }
}
