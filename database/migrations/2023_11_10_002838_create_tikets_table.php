<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->string('id_tiket')->primary();
            $table->string('id_penjual');
            $table->string('nama');
            $table->integer('harga');
            $table->integer('quantity');
            $table->string('kota');
            $table->string('alamat_lokasi');
            $table->string('lokasi_lat');
            $table->string('lokasi_long');
            $table->json('gambar');
            $table->integer('jumlah_view');
            $table->char('status')->default(1); //1 means ticket active and not deleted
            $table->longText('deskripsi');
            $table->string('kategori');
            $table->date('start_date')->nullable(); 
            $table->time('start_time')->format('H:i'); //format as Hour:minutes
            $table->time('end_time')->format('H:i');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
