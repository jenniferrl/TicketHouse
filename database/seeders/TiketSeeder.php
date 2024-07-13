<?php

namespace Database\Seeders;

use App\Models\Tiket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tiket::truncate();
        for ($i = 1; $i <=5; $i++) {//make 5 seminar tickets
            DB::table('tikets')->insert([
                'id_tiket' => 'TIK00'.$i,
                'id_penjual' => 'PJ001',
                'nama' => 'Seminar '.$i,
                'harga' => 10000,
                'quantity' => 1,
                'kota' => 'Surabaya',
                'alamat_lokasi' => 'Jl. Merdeka '.$i,
                'lokasi_lat' => '-7.25558',
                'lokasi_long' => '112.75046',
                'gambar' => json_encode(['seminar1.jpg']), //convert array to JSOn string
                'jumlah_view' => 0,
                'status' => 1,
                'deskripsi' => 'ini adalah deskripsi tiket ke '.$i,
                'kategori' => 'seminar',
                'start_date' => "2023/11/21",
                'start_time' => "12:30",
                'end_time' => "15:30",
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }

        //Add places ticket
        for ($i = 1; $i <=4; $i++) {//make 4 places tickets
            DB::table('tikets')->insert([
                'id_tiket' => 'TIK00'.$i+5,
                'id_penjual' => 'PJ001',
                'nama' => 'Place '.$i,
                'harga' => 100000,
                'quantity' => 1,
                'kota' => 'Surabaya',
                'alamat_lokasi' => 'Jl. Ngagel Jaya Tengah '.$i,
                'lokasi_lat' => '-7.29156',
                'lokasi_long' => '112.75837',
                'gambar' => json_encode(['place1.jpg']), //convert array to JSOn string
                'jumlah_view' => 0,
                'status' => 1,
                'deskripsi' => 'ini adalah deskripsi tiket ke '.$i,
                'kategori' => 'place',               
                'start_time' => "14:30",
                'end_time' => "17:30",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
