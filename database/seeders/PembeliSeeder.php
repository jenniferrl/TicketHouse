<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\Pembeli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembeli::truncate(); //replace the existing seed in DB
        for ($i = 1; $i <3; $i++) {//make 2 buyer
            DB::table('pembelis')->insert([
                'id_pembeli' => 'PB00'.$i,
                'username' => 'pembeli'.$i,
                'name' => 'Mark',
                'email' => 'pembeli'.$i.'@gmail.com',
                'no_telp' => '08521111100'.$i,
                'jk' => 'L',
                'password' => Hash::make('123'),
                'poin' => 0,
                'profile_picture' =>null,
                'tgl_lahir' => '2003/01/01',
                'refferal' => 'REF00'.$i,
                'joined_at'=> Carbon::today('Asia/Jakarta'),
            ]);
        }
    }
}
