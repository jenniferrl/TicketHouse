<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wishlist::truncate();
        for ($i = 1; $i <3; $i++) {//make 2 wishlist for user 1
            DB::table('wishlists')->insert([
                'id_wishlist' => 'WL00'.$i,
                'id_pembeli' => 'PB001',
                'id_tiket' => 'TIK00'.$i,
            ]);
        }
    }
}
