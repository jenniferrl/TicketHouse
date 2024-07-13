<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use App\Models\Pembelian;
use App\Models\Penjual;
use App\Models\Promo;
use App\Models\Report;
use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminMasterController extends Controller
{
    //
    public function showMasterPenjual(){
        $penjual = Penjual::all();
        return view('masterPenjual',[
            "title" => "Master Penjual",
            "daftarPenjual" => $penjual
        ]);
    }


    public function showMasterPembeli(){
        $pembeli = Pembeli::all();
        return view('masterPembeli',[
            "title" => "Master Pembeli",
            "daftarPembeli" => $pembeli
        ]);
    }

    public function showMasterTiket(){
        $tiket = Tiket::with(['penjual'])->get();
        // $tiket = Tiket::all();
        // $tiket->load('penjual:name');
        return view('masterTiket',[
            "title" => "Master Tiket",
            "daftarTiket" => $tiket
        ]);
    }

    public function showMasterPromo(){
        $promo = Promo::where('status', 1)->with(['penjual'])->get();
        // $tiket = Tiket::all();
        // $tiket->load('penjual:name');
        return view('masterPromo',[
            "title" => "Master Promo",
            "daftarPromo" => $promo
        ]);
    }

    public function showMasterAktivitas(){
        $aktivitas = Report::with(['penjual', "pembeli"])->get();
        // $tiket = Tiket::all();
        // $tiket->load('penjual:name');
        return view('masterAktivitas',[
            "title" => "Master Aktivitas",
            "daftarAktivitas" => $aktivitas
        ]);
    }

    // ================== Detail Master ================== 


    //PENJUAL
    public function showMasterAddPenjual(){
        return view('masterAddPenjual',[
            "title" => "Add Penjual",
        ]);
    }

    public function saveMasterAddPenjual(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'required|string',
            'gender'=> 'required',
            'password'=> 'required|string|confirmed',
            'dob'=> 'required',
        ];

        $rules['email'] = [
            'required',
            'string',
            'email:dns',
            'max:255',
            Rule::unique('penjuals'), // Ensure email is unique
        ];
        $rules['username'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('penjuals'), //Ensure username is unique
        ];

        $request->validate($rules);

        $ctr = Penjual::count()+1; //hitung ada berapa penjual di DB +1
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT);
        $newId = "PJ".$numberWithLeadingZeros;

        Penjual::create([
            'id_penjual' => $newId,
            'username'=> $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('telepon'),
            'jk' => $request->input('gender'),
            'password' => bcrypt($request->input('password')),
            'profile_picture'=>null,
            'tgl_lahir'=> $request->input('dob'),
        ]);

        return redirect('/admin/master/penjual');
    }

    public function showMasterDetailPenjual($id){
        $penjual = Penjual::where('id_penjual', $id)->first();
        return view('masterDetailPenjual',[
            "title" => "Detail Penjual",
            "penjual" => $penjual
        ]);
    }

    public function changeStatusPenjual($id){
        $penjual = Penjual::where('id_penjual', $id)->first();
        $newStatus = 0;

        //toggle status
        if($penjual->status == 0){//if old status was banned
            $newStatus = 1;
        }else{
            $newStatus = 0;
        }

        Penjual::where('id_penjual', $id)->update(['status' => $newStatus]);

        return redirect("/admin/master/penjual")->with("message", "Penjual status changed successfully");
    }

    public function showMasterEditPenjual($id){
        $checkPenjual = Penjual::where('id_penjual', $id)->first();
        if($checkPenjual == null){//prevent editing penjual that not exist
            return redirect("/admin/master/penjual")->with('message','Penjual not Found');
        }

        return view("masterEditPenjual", [
            "title" => "Edit Penjual",
            "id" => $id,
            "oldData" => $checkPenjual
        ]);
    }

    public function saveMasterEditPenjual(Request $request, $id){
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'required|string',
            'gender'=> 'required',
            'password'=> 'nullable|string|confirmed',
            'dob'=> 'required',
        ];

        $cek = Penjual::where('id_penjual', $id)->first();

        if($request->input('email') != $cek->email){//if want to change email
            $rules['email'] = [
                'required',
                'string',
                'email:dns',
                'max:255',
                Rule::unique('pembelis'), // Ensure email is unique
            ];
        }

        if($request->input('username') != $cek->username){// if want to change username
            $rules['username'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('pembelis'), //Ensure username is unique
            ];
        }


        $request->validate($rules);
        $penjual = Penjual::where('id_penjual', $id);
        $penjual->update([
            'username'=> $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('telepon'),
            'jk' => $request->input('gender'),
            'tgl_lahir' => $request->input('dob'),
        ]);

        // dd($request->input('password'));
        //if change password
        if($request->input('password') != null){
            $penjual->update(['password' => bcrypt($request->input('password'))]);
        }

        return redirect('/admin/master/penjual')->with('message', 'Penjual Edited Successfully');
    }


    //PEMBELI
    public function showMasterAddPembeli(){
        return view('masterAddPembeli',[
            "title" => "Add Pembeli",
        ]);
    }

    public function saveMasterAddPembeli(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'required|string',
            'gender'=> 'required',
            'password'=> 'required|string|confirmed',
            'dob'=> 'required',
        ];

        $rules['email'] = [
            'required',
            'string',
            'email:dns',
            'max:255',
            Rule::unique('pembelis'), // Ensure email is unique
        ];
        $rules['username'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('pembelis'), //Ensure username is unique
        ];

        $request->validate($rules);

        $ctr = Pembeli::count()+1; //hitung ada berapa penjual di DB +1
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT);
        $newId = "PB".$numberWithLeadingZeros;
        $reff = 'REF'.$numberWithLeadingZeros; 

        Pembeli::create([
            'id_pembeli' => $newId,
            'username'=> $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('telepon'),
            'jk' => $request->input('gender'),
            'password' => bcrypt($request->input('password')),
            'profile_picture' => null,
            'tgl_lahir' => $request->input('dob'),
            'refferal' => $reff
        ]);

        return redirect('/admin/master/pembeli')->with('message', 'Pembeli Added Successfully');;
    }

    public function showMasterDetailPembeli($id){
        $pembeli = Pembeli::where('id_pembeli', $id)->first();
    
        return view('masterDetailPembeli',[
            "title" => "Detail Pembeli",
            "pembeli" => $pembeli
        ]);
    }

    public function changeStatusPembeli($id){
        $pembeli = Pembeli::where('id_pembeli', $id)->first();
        $newStatus = 0;

        //toggle status
        if($pembeli->status == 0){//if old status was banned
            $newStatus = 1;
        }else{
            $newStatus = 0;
        }

        Pembeli::where('id_pembeli', $id)->update(['status' => $newStatus]);

        return redirect("/admin/master/pembeli")->with("message", "Pembeli status changed successfully");
    }

    public function showMasterEditPembeli($id){
        $checkPembeli = Pembeli::where('id_pembeli', $id)->first();
        if($checkPembeli == null){//prevent editing tickets that not exist
            return redirect("/admin/master/pembeli")->with('message','Pembeli not Found');
        }

        return view("masterEditPembeli", [
            "title" => "Edit Pembeli",
            "id" => $id,
            "oldData" => $checkPembeli
        ]);
    }

    public function saveMasterEditPembeli(Request $request, $id){
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'required|string',
            'gender'=> 'required',
            'password'=> 'nullable|string|confirmed',
            'dob'=> 'required',
        ];

        $cek = Pembeli::where('id_pembeli', $id)->first();

        if($request->input('email') != $cek->email){//if want to change email
            $rules['email'] = [
                'required',
                'string',
                'email:dns',
                'max:255',
                Rule::unique('pembelis'), // Ensure email is unique
            ];
        }

        if($request->input('username') != $cek->username){// if want to change username
            $rules['username'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('pembelis'), //Ensure username is unique
            ];
        }


        $request->validate($rules);
        $pembeli = Pembeli::where('id_pembeli', $id);
        $pembeli->update([
            'username'=> $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('telepon'),
            'jk' => $request->input('gender'),
            'tgl_lahir' => $request->input('dob'),
        ]);

        // dd($request->input('password'));
        //if change password
        if($request->input('password') != null){
            $pembeli->update(['password' => bcrypt($request->input('password'))]);
        }

        return redirect('/admin/master/pembeli')->with('message', 'Pembeli edited successfully');
    }


    //PROMO

    public function showMasterDetailPromo($id){
        $promo = Promo::with(['penjual'])->where('id_kodepromo', $id)->first();

        return view('masterDetailPromo',[
            "title" => "Detail Promo",
            "promo" => $promo
        ]);
    }

    public function showMasterAddPromo(){
        return view('masterAddPromo',[
            "title" => "Add Promo",
        ]);
    }

    public function saveMasterAddPromo(Request $request){
        $limit = 5;
        $rules = [
            'idPenjual' => 'required|string',
            'tipePromo' => 'required|in:Persen,Non Persen',
            'minPurchase' => 'required|integer|gte:0'
        ];
        $rules['kode_promo'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('promos')->whereNull('deleted_at'), //kode unik dari tabel promo
        ];
        //Additional validation for promo in percent
        if($request->input('tipePromo') == "Persen"){
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

        //Cek
        $cek = Penjual::where('id_penjual', $request->input("idPenjual"))->get();

        if(count($cek) == 0){
            return redirect()->back()->with('error', 'ID Penjual tidak valid!');
        }

        //generate new ID Promo
        $ctr = Promo::withTrashed()->count()+1;
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT);
        $promoID = 'PR'.$numberWithLeadingZeros;

        //-------------------------------

        Promo::create([
            'id_kodepromo' => $promoID,
            'id_penjual' => $request->input('idPenjual'),
            'kode_promo' => $request->input('kode_promo'),
            'nilai_promo' => $request->input('nilaiPromo'),
            'tipe' => $request->input('tipePromo'),
            'min_purchase' => $request->input('minPurchase'),
            'status' => 1
        ]);
        //redirect setelah berhasil add dengan pesan
        return redirect("/admin/master/promo")->with('message', 'Successfully added new promo!');
    }

    public function showMasterEditPromo($id){
        $checkPromo = Promo::where('id_kodepromo', $id)->first();
        if($checkPromo == null){
            return redirect("admin/master/promo")->with('message', 'Invalid Promo');
        }

        return view("masterEditPromo", [
            "title" => "Edit Promo",
            "id" => $id,
            "oldData" => $checkPromo
        ]);
    }

    public function saveMasterEditPromo(Request $request, $id){
        $limit = 5;

        $rules = [
            'tipePromo' => 'required|in:Persen,Non Persen',
            'minPurchase' => 'required|integer|gte:0'
        ];
        $rules['kode_promo'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('promos')->whereNull('deleted_at'), //kode unik dari tabel promo
        ];
        //Additional validation for promo in percent
        if($request->input('tipePromo') == "Persen"){
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

        $promo = Promo::where('id_kodepromo', $id);

        $promo->update([
            'kode_promo' => $request->input('kode_promo'),
            'nilai_promo' => $request->input('nilaiPromo'),
            'tipe' => $request->input('tipePromo'),
            'min_purchase' => $request->input('minPurchase')
        ]);

        return redirect('/admin/master/promo')->with('message', 'Promo updated successfully');
    }

    public function deleteMasterPromo($id){
        $promo = Promo::where('id_kodepromo', $id)->first();
        // $newStatus = 0;

        // if($promo->status == 0){
        //     $newStatus = 1;
        // }
        // else{
        //     $newStatus = 0;
        // }

        // Promo::where('id_kodepromo', $id)->update(['status' => $newStatus]);

        //simplify with eloquent soft delete
        Promo::where('id_kodepromo', $id)->delete();

        return redirect("admin/master/promo");
    }


    
    //TIKET

    public function showMasterDetailTiket($id){
        $tiket = Tiket::with(['penjual'])->where('id_tiket', $id)->first();
        if($tiket == null){//prevent editing tickets that not exist
            return redirect("/admin/master/tiket")->with('message','Ticket not found');
        }
        return view('masterDetailTiket',[
            "title" => "Detail Tiket",
            "tiket" => $tiket
        ]);
    }

    public function showMasterAddTiket(){
        return view('masterAddTiket',[
            "title" => "Add Tiket",
        ]);
    }

    public function saveMasterAddTiket(Request $request){
        $limit = 5;
        $rules = [
            'namaTiket' => 'required|string|max:255',
            'idPenjual' => 'required|string',
            'kategori' => 'required|in:place,seminar',
            'deskripsi' => 'required|string',
            'harga'=> 'required|integer|gt:0',
            'stok'=> 'required|integer|gt:0',
            'kota'=> 'required',
            'lokasi'=> 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images'   => 'required|array|max:'.$limit.',',
            'startDate' => 'date|nullable',
            'startTime' => 'required',
            'endTime' => 'required'
        ];
        
        $tambahan = [
            'images.max' => 'You can upload a maximum of '.$limit.' images.', // Customize the error message
        ];
        $request->validate($rules, $tambahan);

        // $isIdValid = false;
        $cek = Penjual::where('id_penjual', $request->input("idPenjual"))->get();
        
        if(count($cek) == 0){
            return redirect()->back()->with('error', 'ID Penjual tidak valid!');
        }

        //generate new ID
        $ctr = Tiket::count()+1; //hitung ada berapa tiket di DB +1
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
        $tiketID = 'TIK'.$numberWithLeadingZeros;

        // Mencari latitude dan longitude dari api HERE maps
        $lat = "";//jika alamat tidak ditemukan dimap isi string kosong
        $long = "";
        $kota = $request->input('kota');
        $lokasi = $request->input('lokasi');

        $data = [
            'q' => $lokasi,
            'apiKey' => '1DvppUVi__lz1FhPrVsRjXlo92_CDUDCBgPkikH4xd4'
        ];
        
        $json = file_get_contents('https://geocode.search.hereapi.com/v1/geocode?' . http_build_query($data));
        // echo "<script>console.log('$json')</script>";
        $result = json_decode($json, true);//encode json jadi array assoc

        //cari posisi latitude dan longitude dari lokasi tiket
        foreach ($result['items'] as $res) {
            if($res['address']['city'] == $kota){
                $lat = $res['position']['lat'];
                $long = $res['position']['lng'];
                break;
            }
        }

        //pengecekan jika lokasi tidak ditemukan dimap beri peringatan
        if($lat == "" || $long == ""){
            return redirect()->back()->with('error', 'Lokasi tidak valid!');
        }

        $gambar = [];
        //insert multiple image
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '-' . $image->getClientOriginalName();
                $imageName = time() . '-' . uniqid() . '.' .$image->getClientOriginalExtension();

                // $image->move(public_path('uploads'), $imageName);
                $image->move(public_path('images'), $imageName);
                array_push($gambar, $imageName);
                
            }       
        }else{
            return redirect()->back()->with('message', 'No images were selected.');
        }
        
        
        
        Tiket::create([
            'id_tiket' => $tiketID,
            'id_penjual' =>  $request->input('idPenjual'),
            'nama' => $request->input('namaTiket'),
            'harga' => $request->input('harga'),
            'quantity' => $request->input('stok'),
            'kota' => $request->input('kota'),
            'alamat_lokasi' => $request->input('lokasi'),
            'lokasi_lat' => $lat,
            'lokasi_long' => $long,
            'gambar'=>json_encode($gambar),
            'jumlah_view'=>0,
            'status'=>1,
            'deskripsi'=> $request->input('deskripsi'),
            'kategori'=> $request->input('kategori'),
            'start_date' => $request->input('startDate'),
            'start_time' => $request->input('startTime'),
            'end_time' => $request->input('endTime'),

        ]);
        //redirect setelah berhasil add dengan pesan
        return redirect()->back()->with('message','New ticket added successfuly!');
    }


    public function deleteMasterTiket($id){
        $tiket = Tiket::where('id_tiket', $id)->first();
        $newStatus = 0;

        //toggle status
        if($tiket->status == 0){//if old status was banned
            $newStatus = 1;
        }else{
            $newStatus = 0;
        }

        Tiket::where('id_tiket', $id)->update(['status' => $newStatus]);

        return redirect("/admin/master/tiket")->with('message','Ticket status changed successfully');
    }

    public function showMasterEditTiket($id){
        $checkTicket = Tiket::where('id_tiket', $id)->first();
        if($checkTicket == null){//prevent editing tickets that not exist
            return redirect("/admin/master/tiket")->with('message','Invalid Ticket');
        }

        return view("masterEditTiket", [
            "title" => "Edit Tiket",
            "id" => $id,
            "oldData" => $checkTicket
        ]);
    }

    public function saveMasterEditTiket(Request $request, $id){
        $limit = 5;
        
        $rules = [
            'namaTiket' => 'required|string|max:255',
            'kategori' => 'required|in:place,seminar',
            'deskripsi' => 'required|string',
            'harga'=> 'required|integer|gt:0',
            'stok'=> 'required|integer|gt:0',
            'kota'=> 'required',
            'lokasi'=> 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images'   => 'required|array|max:'.$limit.',',
            'startDate' => 'date|nullable',
            'startTime' => 'required',
            'endTime' => 'required'
        ];
        
        $tambahan = [
            'images.max' => 'You can upload a maximum of '.$limit.' images.', // Customize the error message
        ];
        $request->validate($rules, $tambahan);

        //pengecekan jam selesai harus lebih besar (>) dari jam mulai (not done)
        // $jamMulai = new Carbon($request->input('startTime'));
        // $jamSelesai = new Carbon($request->input('endTime'));
        // $selisih = $jamSelesai->diffInSeconds($jamMulai);
        // echo("<script>`alert($selisih)`</script>");
        // if($selisih < 0){
        //     return redirect()->back()->with('error', 'Jam selesai harus lebih besar dari jam mulai');
        // }

        // Mencari latitude dan longitude dari api HERE maps
        $lat = "";//jika alamat tidak ditemukan dimap isi string kosong
        $long = "";
        $kota = $request->input('kota');
        $lokasi = $request->input('lokasi');

        $data = [
            'q' => $lokasi,
            'apiKey' => '1DvppUVi__lz1FhPrVsRjXlo92_CDUDCBgPkikH4xd4'
        ];
        
        $json = file_get_contents('https://geocode.search.hereapi.com/v1/geocode?' . http_build_query($data));
     
        $result = json_decode($json, true);//encode json jadi array assoc

        //cari posisi latitude dan longitude dari lokasi tiket
        foreach ($result['items'] as $res) {
            if($res['address']['city'] == $kota){
                $lat = $res['position']['lat'];
                $long = $res['position']['lng'];
                break;
            }
        }

        //pengecekan jika lokasi tidak ditemukan dimap beri peringatan
        if($lat == "" || $long == ""){
            return redirect()->back()->with('error', 'Lokasi tidak valid!');
        }

        $gambar = [];
        //insert multiple image
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '-' . $image->getClientOriginalName();
                $imageName = time() . '-' . uniqid() . '.' .$image->getClientOriginalExtension();

                // $image->move(public_path('uploads'), $imageName);
                $image->move(public_path('images'), $imageName);
                array_push($gambar, $imageName);
                
            }

        }else{
            return redirect()->back()->with('message', 'No images were selected.');
        }
        
        //Update data tiket di database
        // $tiket = Tiket::find($id);
        $tiket = Tiket::where('id_tiket', $id);

        $tiket->update([
            'nama' => $request->input('namaTiket'),
            'harga' => $request->input('harga'),
            'quantity' => $request->input('stok'),
            'kota' => $request->input('kota'),
            'alamat_lokasi' => $request->input('lokasi'),
            'lokasi_lat' => $lat,
            'lokasi_long' => $long,
            'gambar'=>json_encode($gambar),
            'deskripsi'=> $request->input('deskripsi'),
            'kategori'=> $request->input('kategori'),
            'start_date' => $request->input('startDate'),
            'start_time' => $request->input('startTime'),
            'end_time' => $request->input('endTime'),
        ]);
        
        //redirect setelah berhasil update dengan pesan
        return redirect('/admin/master/tiket')->with('message', 'Ticket updated successfully');
    }


    //AKTIVITAS

    public function showMasterAddAktivitas(){
        $daftarPembeli = Pembeli::all();
        $daftarPenjual = Penjual::all();
        return view("masterAddAktivitas", [
            "title"=>"Add Aktivitas",
            "daftarPembeli"=>$daftarPembeli,
            "daftarPenjual"=>$daftarPenjual
        ]);
    }

    public function saveMasterAddAktivitas(Request $request){
        
        $rules = [
            'idTerlapor' => 'required|string|max:6',
            'idPelapor' => 'required|string|max:6',
            'deskripsi' => 'required|string',
        ];

        $request->validate($rules);

        $ctr = Report::withTrashed()->count()+1;
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
        $newActivityId = "RP".$numberWithLeadingZeros;
        
        Report::create([
            'id_aktivitas'=>$newActivityId,
            'id_penjual'=>$request->input('idTerlapor'),
            'id_pembeli'=>$request->input('idPelapor'),
            'keterangan'=>$request->input('deskripsi'),
        ]);

        return redirect("/admin/master/aktivitas")->with('message', 'Report added successfully');
    }
    
    public function showMasterDetailAktivitas($id){
        $aktivitas = Report::with(['penjual', 'pembeli'])->where('id_aktivitas', $id)->first();
        if($aktivitas == null){//prevent editing tickets that not exist
            return redirect("/admin/master/aktivitas")->with('message','Aktivitas not found');
        }
        return view("masterDetailAktivitas", [
            "title" => "Detail Aktivitas",
            "aktivitas" => $aktivitas
        ]);
    }

    public function deleteMasterAktivitas($id){
        $aktivitas = Report::where('id_aktivitas', $id)->first();
        // Report::destroy($id); //this code can't worked
        
        Report::where('id_aktivitas', $id)->delete();

        return redirect("/admin/master/aktivitas")->with('message', 'Report deleted successfully');
    }

    public function showMasterEditAktivitas($id){
        $checkAktivitas = Report::where('id_aktivitas', $id)->first();
        $daftarPembeli = Pembeli::all();
        $daftarPenjual = Penjual::all();

        if($checkAktivitas == null){//prevent editing aktivitas that not exist
            return redirect("/admin/master/aktivitas")->with('message','Activity not Found');
        }

        return view("masterEditAktivitas", [
            "title" => "Edit Aktivitas",
            "id" => $id,
            "oldData" => $checkAktivitas,
            "daftarPembeli"=>$daftarPembeli,
            "daftarPenjual"=>$daftarPenjual,
        ]);
    }

    public function saveMasterEditAktivitas(Request $request, $id){
        $rules = [
            'idTerlapor' => 'required|string|max:6',
            'idPelapor' => 'required|string|max:6',
            'deskripsi' => 'required|string',
        ];

        $request->validate($rules);
        $aktivitas = Report::where('id_aktivitas', $id);
        $aktivitas->update([
            'id_penjual'=>$request->input('idTerlapor'),
            'id_pembeli'=>$request->input('idPelapor'),
            'keterangan'=>$request->input('deskripsi'),
        ]);

        return redirect('/admin/master/aktivitas')->with('message', 'Aktivitas edited successfully');
    }


}
