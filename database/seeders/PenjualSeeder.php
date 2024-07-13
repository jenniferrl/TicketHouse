<?php

namespace Database\Seeders;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use App\Models\Penjual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penjual::truncate();
        for ($i = 1; $i <3; $i++) {//make 2 seller
            DB::table('penjuals')->insert([
                'id_penjual' => 'PJ00'.$i,
                'username' => 'penjual'.$i,
                'name' => 'Chris',
                'email' => 'penjual'.$i.'@gmail.com',
                'no_telp' => '08521111100'.$i,
                'jk' => 'L',
                'password' => Hash::make('123'),
                'profile_picture' =>null,
                'tgl_lahir' => '2003/01/01',
                'saldo' => 0,
                'premium_status' => false,
                'joined_at'=>Carbon::today('Asia/Jakarta'),
            ]);
        }

    }
}
