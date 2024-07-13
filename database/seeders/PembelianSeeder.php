<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembelian::truncate(); //replace the existing data in DB
        for ($i = 1; $i <5; $i++) {//make dummy data for purchase table
            DB::table('pembelians')->insert([
                'id_invoice' => 'INV00'.$i,
                'id_pembeli' => 'PB001',
                'id_tiket' => 'TIK00'.$i,
                'tanggal_pembelian' => Carbon::now(), //get today's date
                'quantity' => $i,
                'harga_beli' => 10000,
                'total' =>$i * 10000,
                'status'=>'berhasil',
            ]);
        }
    }
}
