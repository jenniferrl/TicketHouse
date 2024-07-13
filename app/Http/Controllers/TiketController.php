<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google\Client;
use App\Models\Promo;
use App\Models\Tiket;
use App\Models\View;
use App\Models\Penjual;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Google\Service\Calendar\Event;

class TiketController extends Controller
{

    public function setReminderToCalendar(Request $request, $id){
        $getTiket = Tiket::where('id_tiket',$id)->first();
        $summary = $getTiket->nama;
        $description = $getTiket->deskripsi;
        $startDate = $getTiket->start_date;
        $startTime = $getTiket->start_time;
        $endTime = $getTiket->end_time;
        session(['summary'=>$summary]);
        session(['description'=>$description]);
        session(['startDate'=>$startDate]);
        session(['startTime'=>$startTime]);
        session(['endTime'=>$endTime]);
        // Initialize the Google API client
        $client = new Client();
        $client->setAuthConfig(app_path('client_secret.json')); //client secret json tak pake punyaku
        $client->setAccessType('offline');
        $client->setRedirectUri(url('/auth/google/callback')); //harus sesuai dengan yang ada di google calendar api 
        // If the access token is not set or expired, redirect to Google's OAuth consent screen
        $client->setScopes([
            'https://www.googleapis.com/auth/calendar',
            // perlu di set scope spy ga error smh
        ]);
        
            if (!$client->isAccessTokenExpired()) {
                // Use the access token to create an event in Google Calendar
            } else {
                // Redirect to Google's OAuth consent screen
                return redirect($client->createAuthUrl());
            }
    }
       
    public function handleCallback(Request $request){
        // Handle the callback after the user grants access
        $client = new Client();
        $client->setAuthConfig(app_path('client_secret.json'));
        $client->setAccessType('offline');
        $client->setRedirectUri(url('/auth/google/callback'));

        $code = $request->get('code');

        // Exchange authorization code for access token
        $accessToken = $client->fetchAccessTokenWithAuthCode($code);

        $service = new Calendar($client);

        $event = new Event([
            'summary' =>  session('summary'),
            'description' => session('description'),
            'start' => [
                'dateTime' => session('startDate').'T'.session('startTime').'.000',
                'timeZone' => 'Asia/Jakarta',
            ],
            'end' => [
                'dateTime' => session('startDate').'T'.session('endTime').'.000',
                'timeZone' => 'Asia/Jakarta',
            ],
        ]);

        $calendarId = 'primary'; // Use 'primary' for the user's primary calendar

        $event = $service->events->insert($calendarId, $event);
         // Redirect ke home page dengan kembalian pesan 
        return redirect('/home')->with('message', 'Successfully added to Google Calendar!');
    }
    public function getSeminar(){
        $category = "seminar";
        $tickets = Tiket::where('kategori', $category)->where('status', 1)->get();

        return view('seminar')->with(['seminars' => $tickets, 'title' => 'Seminar']);
    }

    public function getPlaces(){
        $category = "place";
        $places = Tiket::where('kategori', $category)->where('status', 1)->get();

        return view('places')->with(['places' => $places, 'title' => 'Places']);
    }

    public function show($id){
        // Logic to fetch item details from the database using $id
        $ticket = Tiket::where('id_tiket',$id)->first(); 
        $seller = Penjual::where('id_penjual',$ticket->id_penjual)->first();
        $sellerPromo = Promo::where('id_penjual', $ticket->id_penjual)->where('status', 1)->get();
        //add view count 
        Tiket::where('id_tiket',$id)->update(['jumlah_view'=>$ticket->jumlah_view+1]); 
        //add view per day count
        if(View::where('tanggal',Carbon::today('Asia/Jakarta'))->exists()){
            $viewData = View::where('tanggal',Carbon::today('Asia/Jakarta'))->first();
            $viewData->update(['jumlah_kunjungan'=>$viewData->jumlah_kunjungan +1]);
        }else{
            View::create([
                'id'=>View::count()+1,
                'tanggal'=>Carbon::today('Asia/Jakarta'),
                'jumlah_kunjungan'=>1
            ]);
        }
        return view('ticketDetail', ['ticket' => $ticket, 'title'=>'Detail Ticket', 'seller'=>$seller, "id"=>$id, "promo"=>$sellerPromo]);
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');

        if(!$keyword){
            return redirect()->route("home");
        }

        $tiket = Tiket::where('nama','LIKE', '%'.$keyword.'%')->where('status', 1)->get();

        return view('searchResult')->with(['result' => $tiket, 'title' => 'Search result']);
    }

    //function untuk mengukur jarak radius antara dua titik

    public function nearMe(Request $request){
        function haversineDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km') {
            $R = ($unit === 'km') ? 6371 : 3959; // Radius of the Earth in kilometers or miles
        
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
        
            $a = sin($dLat / 2) * sin($dLat / 2) +
                 cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                 sin($dLon / 2) * sin($dLon / 2);
        
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
            $distance = $R * $c;
        
            return $distance;
        }


        $longitude = floatval($request->input('long')); //longitude user
        $latitude = floatval($request->input('lat')); //latitude user
        
        if(!$latitude || !$longitude){
            return redirect()->route("home");
        }

        $semuaTiket = Tiket::where('status', 1)->get();
        $tiketNearme = [];

        foreach($semuaTiket as $tiket){
            $lat_lokasi_tiket = floatval($tiket->lokasi_lat); //latitude tiket
            $long_lokasi_tiket = floatval($tiket->lokasi_long); //longitude tiket

            $distance = haversineDistance($latitude, $longitude, $lat_lokasi_tiket, $long_lokasi_tiket);
            $isNear = ($distance <= 4);//cari tiket yang lokasinya ada di radius < 4km
            if($isNear){
                array_push($tiketNearme, $tiket);//push data tiket near me untuk ditampilkan ke view
            }
        }

        return view('nearMe')->with(['result' => $tiketNearme, 'title' => 'Near Me']);
    }

    public function showAdd(){
        //show add ticket page
        return view('addTiket',[
            "title" => "Tambah Tiket",
        ]);
    }

    public function saveAdd(Request $request){
        // $keyword = $request->input('keyword');
        if(session('user')['premium_status'] == 1){
            $limit = 5;
        }else{
            $limit = 3;
        }
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
            'id_penjual' => session('user')['id_penjual'],
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
        return redirect()->back()->with('message','Successfully added new ticket!');
    }

    public function showAll(){
        //get all tickets owned by currently logged in seller
        $allTickets = Tiket::where('id_penjual', session('user')->id_penjual)->where('status', 1)->get();
        $title = "Lihat Semua Tiket";
        
        return view('viewAll',compact('title','allTickets'));
    }

    public function showEditForm($id){
        //get ticket id
        $checkTicket = Tiket::where('id_tiket', $id)->first();
        if($checkTicket == null){//prevent seller from editing tickets that not exist
            return redirect("/viewall")->with('message','Invalid Ticket');
        }
        if($checkTicket->id_penjual != session('user')->id_penjual){//prevent seller from editing another seller's ticket
            return redirect("/viewall")->with('message','Another Seller Ticket');
        }
        //Return form edit tiket
        return view('editTiket',[
            "title" => "Edit Tiket",
            "id" => $id,
            "oldData" => $checkTicket
        ]);
    }

    public function updateTiket(Request $request, $id)
    {
        // Validate and update the item
        if(session('user')['premium_status'] == 1){
            $limit = 5;
        }else{
            $limit = 3;
        }
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
        return redirect('/viewall')->with('message', 'Ticket updated successfully');
    }

    public function deleteTicket($id){ //accepting id_wishlist as a param
        // dd($id);
        //remove individual item from wishlist
        Tiket::where('id_tiket',$id)->update(["status"=>0]);
        return redirect()->back()->with('message','Ticket deleted successfully'); //go back to previous page with back()
    }
}
