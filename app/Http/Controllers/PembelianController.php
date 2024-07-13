<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Tiket;
use App\Models\Pembeli;
use App\Models\Penjual;
use App\Models\Unfinished;
use App\Models\Promo;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PembelianController extends Controller
{
    public function invoice($id){
        $title = "Lihat Invoice";
        $invoice = Pembelian::where('id_invoice',$id)->first();
        $ticket = Tiket::where('id_tiket',$invoice->id_tiket)->first();
        $pembeli = Pembeli::where('id_pembeli',$invoice->id_pembeli)->first();
        $penjual = Penjual::where('id_penjual',$ticket->id_penjual)->first();
        return view('viewInvoice',compact('title','invoice','ticket','pembeli','penjual'));
    }

    public function history(){
        $title = "History";
        //get all transaction made by this user
        $purchases = Pembelian::where('id_pembeli',session('user')->id_pembeli)->get();
        // $purchases = $raw->sortByDesc('tanggal_pembelian');
        $tickets = Tiket::all();
        return view('history',compact('title','purchases','tickets'));

    }

    public function historySuccess(){
        $title = "History Transaksi Sukses";
        //get all transaction made by this user
        $purchases = Pembelian::join('tikets', 'pembelians.id_tiket', '=', 'tikets.id_tiket')->select(DB::raw('pembelians.id_invoice as id_invoice'), DB::raw('pembelians.tanggal_pembelian as tanggal_pembelian'), DB::raw('pembelians.total as total'), DB::raw('pembelians.status as status'), DB::raw('tikets.gambar as gambar_tiket'), DB::raw('tikets.nama as nama_tiket'))->with(['tiket'])->where('pembelians.id_pembeli', session('user')->id_pembeli)->where('pembelians.status', 'berhasil')->orderBy('pembelians.tanggal_pembelian', 'desc')->paginate(10);
        
        // $purchases = Pembelian::with(['tiket'])->where('id_pembeli', session('user')->id_pembeli)->where('status', 'berhasil')->orderBy('tanggal_pembelian', 'desc')->paginate(10);

        return view('historySuccess',compact('title','purchases'));
    }

    public function historySuccessSearch(Request $request){
        $title = "History Transaksi Sukses";
        $keyword = $request->input('keyword');
        $dateFilter = $request->input('date');//get date from filter
        //get all transaction made by this user
        $purchases = Pembelian::join('tikets', 'pembelians.id_tiket', '=', 'tikets.id_tiket')->select(DB::raw('pembelians.id_invoice as id_invoice'), DB::raw('pembelians.tanggal_pembelian as tanggal_pembelian'), DB::raw('pembelians.total as total'), DB::raw('pembelians.status as status'), DB::raw('tikets.gambar as gambar_tiket'), DB::raw('tikets.nama as nama_tiket'))->with(['tiket'])->where('pembelians.id_pembeli', session('user')->id_pembeli)->where('pembelians.status', 'berhasil')->where('pembelians.tanggal_pembelian', 'like', '%'.$dateFilter.'%')->where('tikets.nama', 'like', '%'.$keyword.'%')->orderBy('pembelians.tanggal_pembelian', 'desc')->paginate(10);
        
        // $purchases = Pembelian::with(['tiket'])->where('id_pembeli', session('user')->id_pembeli)->where('status', 'berhasil')->where('tanggal_pembelian', 'like', '%'.$dateFilter.'%')->orderBy('tanggal_pembelian', 'desc')->paginate(10);
        // dd($purchases);
        return view('historySuccess',compact('title','purchases'));
    }

    public function historyFail(){
        $title = "History Transaksi Gagal";
        //get all transaction made by this user
        $purchases = Pembelian::join('tikets', 'pembelians.id_tiket', '=', 'tikets.id_tiket')->select(DB::raw('pembelians.id_invoice as id_invoice'), DB::raw('pembelians.tanggal_pembelian as tanggal_pembelian'), DB::raw('pembelians.total as total'), DB::raw('pembelians.status as status'), DB::raw('tikets.gambar as gambar_tiket'), DB::raw('tikets.nama as nama_tiket'))->with(['tiket'])->where('pembelians.id_pembeli', session('user')->id_pembeli)->where('pembelians.status', 'gagal')->orderBy('pembelians.tanggal_pembelian', 'desc')->paginate(10);

        // $purchases = Pembelian::with(['tiket'])->where('id_pembeli', session('user')->id_pembeli)->where('status', 'gagal')->orderBy('tanggal_pembelian', 'desc')->paginate(10);

        return view('historyFail',compact('title','purchases'));
    }

    public function historyFailSearch(Request $request){
        $title = "History Transaksi Gagal";
        $keyword = $request->input('keyword');
        $dateFilter = $request->input('date');//get date from filter
        //get all transaction made by this user

        $purchases = Pembelian::join('tikets', 'pembelians.id_tiket', '=', 'tikets.id_tiket')->select(DB::raw('pembelians.id_invoice as id_invoice'), DB::raw('pembelians.tanggal_pembelian as tanggal_pembelian'), DB::raw('pembelians.total as total'), DB::raw('pembelians.status as status'), DB::raw('tikets.gambar as gambar_tiket'), DB::raw('tikets.nama as nama_tiket'))->with(['tiket'])->where('pembelians.id_pembeli', session('user')->id_pembeli)->where('pembelians.status', 'gagal')->where('pembelians.tanggal_pembelian', 'like', '%'.$dateFilter.'%')->where('tikets.nama', 'like', '%'.$keyword.'%')->orderBy('pembelians.tanggal_pembelian', 'desc')->paginate(10);

        // $purchases = Pembelian::with(['tiket'])->where('id_pembeli', session('user')->id_pembeli)->where('status', 'gagal')->where('tanggal_pembelian', 'like', '%'.$keyword.'%')->orderBy('tanggal_pembelian', 'desc')->paginate(10);
        return view('historyFail',compact('title','purchases'));
    }

    public function afterpay(){
        //update invoice status to success
        $id_invoice = session('id_invoice');
        Pembelian::where('id_invoice',$id_invoice)->update(['status'=>'berhasil' ]);
        $all = Unfinished::all();
        $idx=-1;
        foreach($all as $a){
            //cari index
            $arr = json_decode($a->order);
            if($arr->id_invoice == $id_invoice){
                $idx = $a->id;
                break;
            }
        }
        //update di unfinisheds
        if($idx!=-1){
            Unfinished::where('id',$idx)->update(['status'=>'paid']);
            //tambah saldo penjual
            $tempData = Unfinished::where('id',$idx)->first();
            $tempTiket = Tiket::where('nama',$tempData->nama_tiket)->first();
            $tempPenjual = Penjual::where('id_penjual',$tempTiket->id_penjual)->first();
            $newBalance = intVal($tempPenjual->saldo)+ intVal(json_decode($tempData->order)->total);
            Penjual::where('id_penjual',$tempTiket->id_penjual)->update(['saldo'=>$newBalance]);
        }
        return redirect('/home')->with('message','Berhasil melakukan pembelian!');
    }

    public function pay(Request $request,$id){
        $ticket = Tiket::where('id_tiket',$id)->first();
        $namaTiket = $ticket->nama;
        $hiddenTotal = $request->input('hiddenTotal');
        $hiddenPromo = $request->input('hiddenPromo');
        $final = intval($hiddenTotal)-intval($hiddenPromo); //harga setelah dipotong promo
        $ctr = Pembelian::count()+1;
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT); //beri leading zero sebanyak 3. misal 1 jadi 001
        $newId = 'INV'.$numberWithLeadingZeros; //buat refferal dengan format REF+numberleadingzeros
        session(['id_invoice'=>$newId]); //sementara diakali pake session untuk update status
        $order = Pembelian::create([//berhasil
            'id_invoice'=>$newId,
            'id_pembeli'=>session('user')->id_pembeli,
            'id_kodepromo'=>$request->input('promoCode'),
            'id_tiket'=>$id,
            'tanggal_pembelian'=>Carbon::now('Asia/Jakarta'), //supaya dapat tanggal dari timezone indonesia
            'quantity'=>$request->input('hiddenQty'),
            'harga_beli'=>$ticket->harga,
            'total'=>$final,
        ]);
        
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $final,
            ),
            'customer_details' => array(
                'first_name' => session('user')->name,
                'email' => session('user')->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        //simpan unfinished transaction ke DB
        Unfinished::create([
            'tanggal_transaksi'=>Carbon::today('Asia/Jakarta'),
            'snap_token'=>json_encode($snapToken),
            'nama_tiket'=>$namaTiket,
            'order'=>json_encode($order),
        ]);

        return view('cobaCheckout',compact('snapToken','order','namaTiket'));
    }

    public function checkout($id){
        $title = "Checkout";
        $ticket = Tiket::where('id_tiket',$id)->first(); //kalo pake get() dapatnya bentuk array[]
        //ambil kode promo yang tersedia
        $promos = Promo::where('id_penjual',$ticket->id_penjual)->where('status',1)->get(); //array
        $date = ""; //kalo place tidak ada startDatenya
        if($ticket->kategori == "seminar"){
            $date = $ticket->start_date;
        }
        return view('checkout',compact('title','ticket','date','promos'));
    }

    public function apply(Request $request,$id){
        $promoEntered = $request->input('promo'); //promo code yang dimasukkan user
        $ticket = Tiket::where('id_tiket',$id)->first(); //kalo pake get() dapatnya bentuk array[]
        //ambil kode promo yang tersedia
        $promos = Promo::where('id_penjual',$ticket->id_penjual)->where('status',1)->get(); //array
        //validasi kode promo yang dimasukkan
        $ketemu=false;
        $tempPromo = [];
        foreach ($promos as $p) {
            if ($p->kode_promo == $promoEntered) {
                $ketemu=true;
                array_push($tempPromo,$p);
                break;
            }
        }
        $nilaiPotongan=0;
        if (!$ketemu) return redirect()->back()->with('error','Kode promo tidak valid!');
        if($ketemu){
            //cari besaran promo
            if ($tempPromo[0]->tipe == "non"){
                //potongan langsung bukan persen
                // dd('non persen');
                return redirect()->back()->with('message','Kode promo berhasil digunakan')->with('potongan',$tempPromo[0]->nilai_promo)->with('kodepromo',$promoEntered);

            }else{ //potongan persen(belum selesai)
                $newPotongan = (intval($tempPromo[0]->nilai_promo)/100) * intval($ticket->harga);
                return redirect()->back()->with('message','Kode promo berhasil digunakan')->with('potongan',$newPotongan)->with('kodepromo',$promoEntered);
            }
        }
    }
}
