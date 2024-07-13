<?php

use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\SellerImageController;
use App\Models\Tiket;
use Jorenvh\Share\Share;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UnfinishedController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishlistController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[LoginController::class,'home']);

Route::get('/home', [LoginController::class,'home'])->name("home");

Route::get('/dashboard', [PenjualController::class,'show']);
Route::get('/sellerProfile', function() {
    return view('sellerProfile',[
        "title" => "Seller Profile",
    ]);
});
Route::get('/about', function () {
    $title = "About Us";
    return view('about', compact('title'));
});

// Route::get('/history',[PembelianController::class,'history'])->name('history');
Route::get('/history/success',[PembelianController::class,'historySuccess'])->name('historySuccess');
Route::get('/history/success/search',[PembelianController::class,'historySuccessSearch']);
Route::get('/history/fail',[PembelianController::class,'historyFail'])->name('historyFail');
Route::get('/history/fail/search',[PembelianController::class,'historyFailSearch']);
Route::get('/invoice/{id}',[PembelianController::class,'invoice'])->name('invoice');

//Admin
Route::get('/adminLogin', [AdminController::class,'login'])->name('login.admin');
Route::post('/adminLogin', [AdminController::class,'attemptLogin']);
Route::get('/adminDashboard',[AdminController::class,'show']);
Route::get('/adminLogout', [AdminController::class,'logout']); 

//Admin Master and Report
Route::prefix('admin')->group(function(){
    //---------------- Admin Report ----------------
    Route::get('/report/kunjungan',[AdminController::class,'kunjunganReport'])->name('kunjungan.report');
    Route::get('/report/transaksi',[AdminController::class,'transaksiReport'])->name('transaksi.report');
    Route::get('/report/tiket',[AdminController::class,'ticketReport'])->name('ticket.report');
    Route::get('/report/detailtiket/{id}',[AdminController::class,'ticketReportDetail'])->name('ticketreport.detail');
    Route::get('/report/penjual',[AdminController::class,'sellerReport'])->name('seller.report');
    Route::get('/report/detailpenjual/{id}',[AdminController::class,'sellerDetail'])->name('seller.detail');
    Route::get('/report/pembeli',[AdminController::class,'buyerReport'])->name('buyer.report');
    Route::get('/report/detailpembeli/{id}',[AdminController::class,'buyerDetail'])->name('buyer.detail');

    //---------------- Admin Master ----------------
    //Master Penjual Routes
    Route::get('/master/penjual', [AdminMasterController::class, 'showMasterPenjual']);
    Route::get('/master/penjual/add', [AdminMasterController::class, 'showMasterAddPenjual']);
    Route::post('/master/penjual/add', [AdminMasterController::class, 'saveMasterAddPenjual']);
    Route::get('/master/penjual/{id}/detail', [AdminMasterController::class, 'showMasterDetailPenjual']);
    Route::get('/master/penjual/{id}/edit', [AdminMasterController::class, 'showMasterEditPenjual']);
    Route::post('/master/penjual/{id}/edit', [AdminMasterController::class, 'saveMasterEditPenjual']);
    Route::get('/master/penjual/{id}/change', [AdminMasterController::class, 'changeStatusPenjual']);

    //Master Pembeli Routes
    Route::get('/master/pembeli', [AdminMasterController::class, 'showMasterPembeli']);
    Route::get('/master/pembeli/add', [AdminMasterController::class, 'showMasterAddPembeli']);
    Route::post('/master/pembeli/add', [AdminMasterController::class, 'saveMasterAddPembeli']);
    Route::get('/master/pembeli/{id}/detail', [AdminMasterController::class, 'showMasterDetailPembeli']);
    Route::get('/master/pembeli/{id}/edit', [AdminMasterController::class, 'showMasterEditPembeli']);
    Route::post('/master/pembeli/{id}/edit', [AdminMasterController::class, 'saveMasterEditPembeli']);
    Route::get('/master/pembeli/{id}/change', [AdminMasterController::class, 'changeStatusPembeli']);

    //Master Tiket Routes
    Route::get('/master/tiket', [AdminMasterController::class, 'showMasterTiket']);
    Route::get('/master/tiket/add', [AdminMasterController::class, 'showMasterAddTiket']);
    Route::post('/master/tiket/add', [AdminMasterController::class, 'saveMasterAddTiket']);
    Route::get('/master/tiket/{id}/detail', [AdminMasterController::class, 'showMasterDetailTiket']);
    Route::get('/master/tiket/{id}/edit', [AdminMasterController::class, 'showMasterEditTiket']);
    Route::post('/master/tiket/{id}/edit', [AdminMasterController::class, 'saveMasterEditTiket']);
    Route::get('/master/tiket/{id}/delete', [AdminMasterController::class, 'deleteMasterTiket']);

    //Master Promo Routes
    Route::get('/master/promo', [AdminMasterController::class, 'showMasterPromo']);
    Route::get('/master/promo/add', [AdminMasterController::class, 'showMasterAddPromo']);
    Route::post('/master/promo/add', [AdminMasterController::class, 'saveMasterAddPromo']);
    Route::get('/master/promo/{id}/detail', [AdminMasterController::class, 'showMasterDetailPromo']);
    Route::get('/master/promo/{id}/edit', [AdminMasterController::class, 'showMasterEditPromo']);
    Route::post('/master/promo/{id}/edit', [AdminMasterController::class, 'saveMasterEditPromo']);
    Route::get('/master/promo/{id}/delete', [AdminMasterController::class, 'deleteMasterPromo']);

    //Master Aktivitas Routes 
    Route::get('/master/aktivitas', [AdminMasterController::class, 'showMasterAktivitas']);
    Route::get('/master/aktivitas/add', [AdminMasterController::class, 'showMasterAddAktivitas']);
    Route::post('/master/aktivitas/add', [AdminMasterController::class, 'saveMasterAddAktivitas']);
    Route::get('/master/aktivitas/{id}/detail', [AdminMasterController::class, 'showMasterDetailAktivitas']);
    Route::get('/master/aktivitas/{id}/edit', [AdminMasterController::class, 'showMasterEditAktivitas']);
    Route::post('/master/aktivitas/{id}/edit', [AdminMasterController::class, 'saveMasterEditAktivitas']);
    Route::get('/master/aktivitas/{id}/delete', [AdminMasterController::class, 'deleteMasterAktivitas']);
});

Route::get('/addMasterPromo', [AdminMasterController::class, 'showAddMasterPromo'])->name('showAddMasterPromo');


Route::get('/register', [RegisterController::class,'index']);
Route::post('/register', [RegisterController::class,'store']);

Route::get('/login', [LoginController::class,'login'])->name('login');
Route::post('/login', [LoginController::class,'attemptLogin']);

Route::get('/logout', [LoginController::class,'logout']); 

//Seminar
Route::get('/seminar', [TiketController::class,'getSeminar']);
//Places
Route::get('/places', [TiketController::class,'getPlaces']);
//Detail Ticket. Name supaya bisa diakses lewat route(name)
Route::get('/ticket/{id}', [TiketController::class, 'show'])->name('ticket.detail');

//Search
Route::get('/search', [TiketController::class,'search']);

//Wishlist
Route::get('/wishlist', [WishlistController::class,'index']);
Route::post('/wishlist/{id}',[WishlistController::class, 'addToWishlist'])->name('add.wishlist');

Route::put("/wishlist", [WishlistController::class, 'removeAllFromWishlist']);
Route::put("/wishlist/{id}",[WishlistController::class,'removeFromWishlist'])->name('remove.wishlist');


//Near Me
Route::get('/nearme', [TiketController::class,'nearMe'])->name("nearMe");

Route::get('/set-reminder/{id}', [TiketController::class,'setReminderToCalendar'])->name('tickets.reminder');
Route::get('/auth/google/callback', [TiketController::class,'handleCallback']);

Route::get('/editprofile',[ImageController::class,'show'])->name('show.profile');
Route::post('/editprofile',[ImageController::class,'update'])->name('update.profile');

Route::get('/editprofile',[SellerImageController::class, 'show'])->name('show.profile');
Route::post('/editprofile',[SellerImageController::class, 'update'])->name('update.profile');

// Penjual
//Add Tiket
Route::get('/add', [TiketController::class,'showAdd']);
Route::post('/add', [TiketController::class,'saveAdd']);

//Promo
//Add Promo
Route::get('/addPromo', [PromoController::class,'showAddPromo']);
Route::post('/addPromo', [PromoController::class,'store']);
//Apply promo code
Route::post('/applypromo/{id}',[PembelianController::class,'apply'])->name('apply.promo');

Route::get("/afterPay",[PembelianController::class,'afterpay']);
Route::get('/upgrade/{id}',[PenjualController::class,'upgrade'])->name('upgrade.status');

//Tiket
//View All Ticket
Route::get('/viewall',[TiketController::class,'showAll'])->name('view.all');

//Delete Ticket
Route::put("/deleteTicket/{id}",[TiketController::class,'deleteTicket'])->name('delete.ticket');

//Edit Ticket
Route::get("/edit/{id}", [TiketController::class,'showEditForm']);
Route::put("/edit/{id}", [TiketController::class,'updateTiket']);

//Report
Route::post('/report/{id}',[ReportController::class,'processReport'])->name('submit.report');

//Laporan Penjual
//Laporan View Ticket
Route::get('/viewreport',[PenjualController::class,'viewReport'])->name('view.report');

//laporan penjualan
Route::get('/salesreport',[PenjualController::class,'salesReport'])->name('sales.report');

//laporan cashflow
Route::get('/cashflowreport',[PenjualController::class,'cashflowReport'])->name('cashflow.report');

//export 
Route::get('/exportpdf/{id}', [PenjualController::class, 'exportpdf'])->name('export.pdf');
Route::get('/exportexcel/{id}', [PenjualController::class, 'exportexcel'])->name('export.excel');

//checkout
Route::get('/checkout/{id}',[PembelianController::class,'checkout'])->name('checkout');
Route::post('/pay/{id}',[PembelianController::class,'pay'])->name('pay'); //proceed to midtrans
Route::get('/unfinished',[UnfinishedController::class,'unfinished'])->name('unfinished');
Route::get('/resumePayment/{id}',[UnfinishedController::class,'resume'])->name('resume.payment');
//COBA COBA UPLOAD IMAGE EDIT PROFIL PENJUAL
//Masih gagal, harus ubah-ubah auth web
//Route::post('/upload/image', [ImageController::class, 'upload'])->name('upload.image');