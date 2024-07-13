<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pembelian;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([ //by doing this we can run all seeder at once by using php artisan db:seed
            PembeliSeeder::class,
            PenjualSeeder::class,
            TiketSeeder::class,
            WishlistSeeder::class,
            PembelianSeeder::class,
        ]);
    }
}
