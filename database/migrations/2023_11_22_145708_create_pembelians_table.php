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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('id_invoice')->primary();
            $table->string('id_pembeli');
            $table->string('id_kodepromo')->nullable();
            $table->string('id_tiket');
            $table->date('tanggal_pembelian');
            $table->integer('quantity');
            $table->integer('harga_beli');
            $table->integer('redeemed_point')->nullable();
            $table->integer('total');
            $table->string('status')->default('gagal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
