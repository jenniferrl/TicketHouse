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
        Schema::create('unfinisheds', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_transaksi');
            $table->json('snap_token');
            $table->string('nama_tiket');
            $table->json('order');
            $table->string('status')->default('unpaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unfinisheds');
    }
};
